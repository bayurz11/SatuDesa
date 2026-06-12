<?php

use App\Domains\Citizen\Models\Citizen;
use App\Domains\Hamlet\Models\Hamlet;
use App\Domains\Household\Models\Household;
use App\Domains\Post\Models\Post;
use App\Domains\Potential\Models\Potential;
use App\Http\Controllers\PublicBudgetController;
use App\Http\Controllers\PublicAnnouncementController;
use App\Http\Controllers\PublicPopulationController;
use App\Http\Controllers\PublicPotentialController;
use App\Http\Controllers\PublicPostController;
use App\Http\Controllers\PublicGalleryController;
use App\Http\Controllers\PublicVillageHistoryController;
use App\Http\Controllers\PublicVillageMapController;
use App\Http\Controllers\PublicVillageOrganizationController;
use App\Http\Controllers\PublicSearchController;
use App\Http\Controllers\PublicVillageVisionMissionController;
use Illuminate\Support\Facades\Route;

Route::middleware('track.public')->group(function () {
Route::get('/', function () {
    $homeFeaturedPost = Post::query()
        ->news()
        ->with(['category:id,name,slug'])
        ->published()
        ->where('is_featured', true)
        ->orderByDesc('published_at')
        ->first();

    $homeNewsPosts = Post::query()
        ->news()
        ->with(['category:id,name,slug'])
        ->published()
        ->when($homeFeaturedPost, function ($query) use ($homeFeaturedPost) {
            $query->where('id', '!=', $homeFeaturedPost->id);
        })
        ->orderByDesc('published_at')
        ->limit(4)
        ->get();

    $homeAnnouncements = Post::query()
        ->announcements()
        ->with(['category:id,name,slug'])
        ->published()
        ->orderByDesc('is_featured')
        ->orderByDesc('published_at')
        ->limit(3)
        ->get();

    $homeFeaturedPotential = Potential::query()
        ->with(['category:id,name,slug', 'village:id,name'])
        ->where('status', 'published')
        ->whereNotNull('published_at')
        ->where('is_featured', true)
        ->orderByDesc('published_at')
        ->first();

    $totalCitizens = Citizen::query()->count();
    $totalHouseholds = Household::query()->count();
    $maleCitizens = Citizen::query()->whereIn('gender', ['L', 'Laki-laki'])->count();
    $femaleCitizens = Citizen::query()->whereIn('gender', ['P', 'Perempuan'])->count();
    $totalHamlets = Hamlet::query()->count();
    $activeCitizens = Citizen::query()->where('status', 'active')->count();

    return view('pages.public.home', compact(
        'homeFeaturedPost',
        'homeNewsPosts',
        'homeFeaturedPotential',
        'homeAnnouncements',
        'totalCitizens',
        'totalHouseholds',
        'maleCitizens',
        'femaleCitizens',
        'totalHamlets',
        'activeCitizens',
    ));
})->name('home');
Route::get('/cari', PublicSearchController::class)->name('public.search');
Route::get('/sejarah-desa', [PublicVillageHistoryController::class, 'index'])->name('public.history');
Route::get('/visi-misi', [PublicVillageVisionMissionController::class, 'index'])->name('public.vision-mission');
Route::get('/struktur-organisasi', [PublicVillageOrganizationController::class, 'index'])->name('public.organization-structure');
Route::get('/peta-desa', [PublicVillageMapController::class, 'index'])->name('public.village-map');
Route::get('/potensi-desa', [PublicPotentialController::class, 'index'])->name('public.potentials.index');
Route::get('/potensi-desa/{slug}', [PublicPotentialController::class, 'show'])->name('public.potentials.show');

Route::get('/berita', [PublicPostController::class, 'index'])->name('public.posts.index');
Route::get('/berita/{slug}', [PublicPostController::class, 'show'])->name('public.posts.show');
Route::get('/pengumuman', [PublicAnnouncementController::class, 'index'])->name('public.announcements.index');
Route::get('/pengumuman/{slug}', [PublicAnnouncementController::class, 'show'])->name('public.announcements.show');
Route::get('/apbdesa', [PublicBudgetController::class, 'index'])->name('public.budgets.index');

Route::get('/data-penduduk', [PublicPopulationController::class, 'index'])->name('public.population.index');
Route::get('/galeri-desa', [PublicGalleryController::class, 'index'])->name('public.galleries.index');
Route::view('/umkm', 'pages.public.businesses.index')->name('public.businesses.index');
Route::view('/layanan', 'pages.public.services.index')->name('public.services.index');
});
