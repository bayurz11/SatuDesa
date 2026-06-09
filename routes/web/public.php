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
Route::view('/sejarah-desa', 'pages.public.history')->name('public.history');
Route::view('/visi-misi', 'pages.public.vision-mission')->name('public.vision-mission');
Route::view('/struktur-organisasi', 'pages.public.organization-structure')->name('public.organization-structure');
Route::view('/peta-desa', 'pages.public.village-map')->name('public.village-map');
Route::get('/potensi-desa', [PublicPotentialController::class, 'index'])->name('public.potentials.index');
Route::get('/potensi-desa/{slug}', [PublicPotentialController::class, 'show'])->name('public.potentials.show');

Route::get('/berita', [PublicPostController::class, 'index'])->name('public.posts.index');
Route::get('/berita/{slug}', [PublicPostController::class, 'show'])->name('public.posts.show');
Route::get('/pengumuman', [PublicAnnouncementController::class, 'index'])->name('public.announcements.index');
Route::get('/pengumuman/{slug}', [PublicAnnouncementController::class, 'show'])->name('public.announcements.show');
Route::get('/apbdesa', [PublicBudgetController::class, 'index'])->name('public.budgets.index');

$staticPublicPages = [
    '/galeri-desa' => [
        'name' => 'public.galleries.index',
        'title' => 'Galeri Desa',
        'eyebrow' => 'Dokumentasi Visual',
        'description' => 'Galeri publik untuk menampilkan suasana desa, kegiatan warga, hasil pembangunan, dan album tematik yang mudah dijelajahi.',
        'hero_badge' => 'Eksplorasi Visual',
        'hero_note' => 'Komposisi ini cocok untuk grid foto, album kegiatan, dan dokumentasi kawasan yang kuat secara visual.',
        'metrics' => [
            ['value' => '48', 'label' => 'Foto Terpilih'],
            ['value' => '6', 'label' => 'Album Kegiatan'],
            ['value' => '4K', 'label' => 'Visual Hero'],
        ],
        'feature_title' => 'Galeri yang terasa hidup dan terkurasi',
        'feature_body' => 'Halaman ini sebaiknya menonjolkan foto unggulan di bagian atas, lalu diikuti album kegiatan, potret kawasan, dan dokumentasi pembangunan.',
        'feature_points' => ['Foto kegiatan', 'Dokumentasi kawasan', 'Album tematik'],
        'cards' => [
            ['eyebrow' => 'Album', 'title' => 'Kegiatan desa', 'body' => 'Gunakan untuk foto rapat, gotong royong, festival, atau kegiatan pelayanan.'],
            ['eyebrow' => 'Kawasan', 'title' => 'Wajah desa', 'body' => 'Cocok menampilkan jalan desa, fasilitas umum, area pesisir, dan lanskap setempat.'],
            ['eyebrow' => 'Promosi', 'title' => 'Potret unggulan', 'body' => 'Dapat diisi foto yang paling representatif untuk promosi desa dan wisata.'],
        ],
        'content_title' => 'Susunan awal halaman galeri',
        'content_body' => 'Gunakan kombinasi hero visual, grid masonry, dan album tematik agar halaman terasa dinamis meski masih statis.',
        'content_blocks' => [
            ['title' => 'Hero foto unggulan', 'body' => 'Tampilkan satu visual utama yang kuat sebagai pembuka halaman.'],
            ['title' => 'Grid album', 'body' => 'Area ini cocok untuk susunan beberapa kartu album atau kategori foto.'],
        ],
        'sidebar_title' => 'Arah visual',
        'sidebar_items' => ['Foto hero besar', 'Grid album kegiatan', 'Caption singkat per foto'],
        'cta_title' => 'Siap dikembangkan menjadi galeri interaktif',
        'cta_body' => 'Bisa ditingkatkan dengan lightbox, filter album, dan integrasi media dari admin panel.',
    ],
    '/umkm' => [
        'name' => 'public.businesses.index',
        'title' => 'UMKM',
        'eyebrow' => 'Ekonomi Desa',
        'description' => 'Etalase UMKM desa untuk mengenalkan pelaku usaha lokal, produk unggulan, dan peluang belanja dari warga maupun pengunjung.',
        'hero_badge' => 'Pasar Lokal',
        'hero_note' => 'Desain ini diarahkan untuk katalog usaha, kartu produk, dan ajakan belanja produk desa.',
        'metrics' => [
            ['value' => '36', 'label' => 'Pelaku Usaha'],
            ['value' => '18', 'label' => 'Produk Unggulan'],
            ['value' => '5', 'label' => 'Kategori Usaha'],
        ],
        'feature_title' => 'Etalase usaha desa yang mudah dijelajahi',
        'feature_body' => 'Bagian utama dapat menampilkan produk pilihan, kategori usaha, cerita pelaku UMKM, dan kontak pemesanan dalam format katalog.',
        'feature_points' => ['Katalog usaha', 'Produk unggulan', 'Kontak pelaku UMKM'],
        'cards' => [
            ['eyebrow' => 'Katalog', 'title' => 'Daftar pelaku usaha', 'body' => 'Cocok untuk kartu usaha dengan foto, kategori, dan deskripsi singkat.'],
            ['eyebrow' => 'Produk', 'title' => 'Unggulan desa', 'body' => 'Gunakan untuk menonjolkan produk yang paling siap dipromosikan.'],
            ['eyebrow' => 'Kontak', 'title' => 'Akses pemesanan', 'body' => 'Sediakan nomor WhatsApp, lokasi, atau kanal pemesanan sederhana.'],
        ],
        'content_title' => 'Susunan awal halaman UMKM',
        'content_body' => 'Blok konten di bawah bisa menjadi katalog produk, profil pelaku usaha, dan bagian promosi khusus untuk produk unggulan.',
        'content_blocks' => [
            ['title' => 'Kartu usaha', 'body' => 'Tempat ideal untuk daftar UMKM dalam format katalog yang konsisten.'],
            ['title' => 'Banner promosi', 'body' => 'Gunakan area ini untuk kampanye produk musiman atau ajakan belanja lokal.'],
        ],
        'sidebar_title' => 'Komponen etalase',
        'sidebar_items' => ['Filter kategori usaha', 'Kartu produk unggulan', 'Tombol hubungi penjual'],
        'cta_title' => 'Siap menjadi etalase ekonomi desa',
        'cta_body' => 'Nanti dapat diperluas ke listing dinamis per UMKM, detail produk, dan formulir kemitraan.',
    ],
    '/layanan' => [
        'name' => 'public.services.index',
        'title' => 'Layanan',
        'eyebrow' => 'Pelayanan Publik',
        'description' => 'Halaman layanan publik yang membantu warga memahami jenis layanan, syarat berkas, proses pengajuan, dan jalur bantuan.',
        'hero_badge' => 'Panduan Warga',
        'hero_note' => 'Susunan halaman difokuskan untuk kartu layanan, alur proses, dan daftar syarat yang mudah dipindai.',
        'metrics' => [
            ['value' => '9', 'label' => 'Jenis Layanan'],
            ['value' => '3 Langkah', 'label' => 'Proses Umum'],
            ['value' => 'Senin-Jumat', 'label' => 'Jadwal Pelayanan'],
        ],
        'feature_title' => 'Panduan layanan yang jelas dan langsung',
        'feature_body' => 'Bagian pembuka ideal untuk layanan paling sering dipakai, sementara blok berikutnya memuat syarat, alur, dan kontak petugas.',
        'feature_points' => ['Jenis layanan', 'Syarat berkas', 'Alur permohonan'],
        'cards' => [
            ['eyebrow' => 'Administrasi', 'title' => 'Surat pengantar', 'body' => 'Cocok untuk layanan surat domisili, pengantar KTP, KK, dan dokumen dasar lainnya.'],
            ['eyebrow' => 'Pelayanan', 'title' => 'Panduan berkas', 'body' => 'Gunakan untuk menjelaskan syarat, formulir, dan berkas pendukung per layanan.'],
            ['eyebrow' => 'Bantuan', 'title' => 'Kontak dan alur', 'body' => 'Sediakan informasi langkah pengajuan dan kanal bantuan warga.'],
        ],
        'content_title' => 'Susunan awal halaman layanan',
        'content_body' => 'Di bagian utama, tampilkan kategori layanan populer, lalu lanjutkan dengan alur proses dan FAQ singkat agar warga tidak bingung.',
        'content_blocks' => [
            ['title' => 'Daftar layanan', 'body' => 'Bisa berupa grid kartu layanan yang masing-masing punya syarat dan estimasi waktu.'],
            ['title' => 'Alur pengajuan', 'body' => 'Tambahkan langkah-langkah proses agar warga paham apa yang harus dilakukan.'],
        ],
        'sidebar_title' => 'Informasi penting',
        'sidebar_items' => ['Jam pelayanan', 'Kontak operator', 'Dokumen yang sering diminta'],
        'cta_title' => 'Siap dihubungkan ke layanan digital',
        'cta_body' => 'Template ini bisa jadi dasar untuk form online, tracking pengajuan, atau integrasi layanan surat.',
    ],
];

Route::get('/data-penduduk', [PublicPopulationController::class, 'index'])->name('public.population.index');

foreach ($staticPublicPages as $uri => $page) {
    Route::view($uri, 'pages.public.static-page', $page)->name($page['name']);
}
});
