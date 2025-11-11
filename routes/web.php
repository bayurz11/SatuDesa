<?php

use App\Domains\Post\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Landing Page Route
Route::get('/', function () {
    return view('home');
})->name('beranda');

// Sejarah Page Route
Route::get('/sejarah', function () {
    return view('sejarah');
})->name('sejarah');

// Visi & Misi Page Route
Route::get('/visi-misi', function () {
    return view('visimisi');
})->name('visi-misi');

// Struktur Desa Page Route
Route::get('/struktur-desa', function () {
    return view('strukturdesa');
})->name('struktur-desa');

// Potensi Desa Page Route
Route::get('/potensi', function () {
    $items = Post::query()
        ->with(['category:id,name,slug'])
        ->where('content_type', 'potensi')
        ->published()
        ->orderByDesc('published_at')
        ->paginate(10); // bebas: paginate / get

    return view('potensidesa', compact('items'));
})->name('potensi-desa');

// Detail Potensi Desa Page Route
Route::get('/potensi/{slug}', function ($slug) {
    $item = Post::query()
        ->with(['category:id,name,slug', 'tags:id,name,slug', 'editor:id,name'])
        ->where('slug', $slug)
        ->where('content_type', 'potensi')
        ->published()
        ->firstOrFail();

    $related = Post::query()
        ->with('category:id,name,slug')
        ->where('content_type', 'potensi')
        ->published()
        ->when($item->category_id, fn($q) => $q->where('category_id', $item->category_id))
        ->where('id', '!=', $item->id)
        ->orderByDesc('published_at')
        ->take(3)
        ->get();

    return view('potensi-desa-detail', compact('item', 'related'));
})->name('potensi-desa-detail');

// Data Penduduk Page Route
Route::get('/data-penduduk', function () {
    return view('data-penduduk');
})->name('data-penduduk');

// Berita Page Route
Route::get('/berita', function () {
    return view('berita');
})->name('berita');

// Berita Page detail Route
Route::get('/berita/{slug}', function ($slug) {
    $item = Post::query()
        ->with(['category:id,name,slug', 'tags:id,name,slug', 'editor:id,name'])
        ->where('slug', $slug)
        ->where('content_type', 'news')
        ->published()
        ->firstOrFail();

    $related = Post::query()
        ->with('category:id,name,slug')
        ->where('content_type', 'news')
        ->published()
        ->when($item->category_id, fn($q) => $q->where('category_id', $item->category_id))
        ->where('id', '!=', $item->id)
        ->orderByDesc('published_at')
        ->take(3)
        ->get();

    return view('berita-detail', compact('item', 'related'));
})->name('berita.show');

// Pengumuman Page Route
Route::get('/pengumuman', function () {
    return view('pengumuman');
})->name('pengumuman');

Route::get('/pengumuman/{slug}', function ($slug) {
    $item = Post::where('slug', $slug)
        ->where('content_type', 'announcement')
        ->firstOrFail();

    return view('pengumuman-detail', compact('item'));
})->name('pengumuman.show');

// Galeri Page Route
Route::get('/galeri', function () {
    return view('galeri');
})->name('galeri');

// Peta desa Page Route
Route::get('/peta-desa', function () {
    return view('peta-desa');
})->name('peta-desa');

//UMKM Page Route
Route::get('/umkm', function () {
    return view('umkm');
})->name('umkm');

//layanan Page Route
Route::get('/layanan', function () {
    return view('layanan');
})->name('layanan');

//APBdesa Page Route
Route::get('/apbdesa', function () {
    return view('apbdesa');
})->name('apbdesa');



//  <****ADMIN PANEL****>

// Dashboard Route (redirect  /dashboard)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

//profil desa Route
Route::middleware(['auth', 'permission:profil.view'])
    ->prefix('profil-desa')->name('profil.')
    ->group(function () {
        Route::get('/sejarah-desa', fn() => view('sejarah.index'))->name('sejarah-desa');
        Route::get('/visi-misi', fn() => view('visi-misi.index'))->name('visi-misi');
        Route::get('/struktur-organisasi', fn() => view('struktur-organisasi.index'))->name('struktur-organisasi');
    });
//informasi Route
Route::middleware(['auth', 'permission:informasi.view'])
    ->prefix('informasi')->name('informasi.')
    ->group(function () {
        Route::get('/postingan', fn() => view('post.index'))->name('postingan');
        Route::get('/tag', fn() => view('tag.index'))->name('tag');
        Route::get('/content-category', fn() => view('category.index'))->name('content-category');
        Route::get('/lampiran-galeri', fn() => view('struktur-organisasi.index'))->name('lampiran-galeri');
    });



// User Management Routes
Route::middleware(['auth', 'permission:users.view'])->group(function () {
    Route::get('/users', function () {
        return view('users.index');
    })->name('users.index');
});

// Role Management Routes  
Route::middleware(['auth', 'permission:roles.view'])->group(function () {
    Route::get('/roles', function () {
        return view('roles.index');
    })->name('roles.index');
});

// Profile Settings Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile.index');
});

Auth::routes();

Route::get('/home', function () {
    return redirect()->route('dashboard');
})->middleware(['auth'])->name('home');
