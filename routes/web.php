<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Landing Page Route
Route::get('/', function () {
    return view('home');
})->name('/');

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

// Struktur Desa Page Route
Route::get('/potensi-desa', function () {
    return view('potensidesa');
})->name('potensi-desa');

// Data Penduduk Page Route
Route::get('/data-penduduk', function () {
    return view('data-penduduk');
})->name('data-penduduk');

// Berita Page Route
Route::get('/berita', function () {
    return view('berita');
})->name('berita');

// Pengumuman Page Route
Route::get('/pengumuman', function () {
    return view('pengumuman');
})->name('pengumuman');

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
