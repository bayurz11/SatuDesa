<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])
    ->prefix('warga')
    ->name('citizen.')
    ->group(function () {
        $citizenPages = [
            'dashboard' => [
                'name' => 'dashboard',
                'title' => 'Dashboard Warga',
                'description' => 'Beranda portal warga untuk melacak pengajuan surat dan pengaduan.',
            ],
            'surat' => [
                'name' => 'letters.index',
                'title' => 'Surat Warga',
                'description' => 'Daftar pengajuan surat warga beserta status prosesnya.',
            ],
            'surat/ajukan' => [
                'name' => 'letters.create',
                'title' => 'Ajukan Surat',
                'description' => 'Form pengajuan surat baru oleh warga.',
            ],
            'pengaduan' => [
                'name' => 'complaints.index',
                'title' => 'Pengaduan Warga',
                'description' => 'Daftar pengaduan yang dibuat warga dan progres penanganannya.',
            ],
            'pengaduan/buat' => [
                'name' => 'complaints.create',
                'title' => 'Buat Pengaduan',
                'description' => 'Form pengaduan baru untuk warga.',
            ],
        ];

        foreach ($citizenPages as $uri => $page) {
            Route::get($uri, fn () => view('pages.citizen.section', [
                'title' => $page['title'],
                'description' => $page['description'],
                'routeName' => 'citizen.' . $page['name'],
            ]))->name($page['name']);
        }
    });
