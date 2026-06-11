<?php

use App\Http\Controllers\Admin\CitizenExcelController;
use App\Http\Controllers\Admin\VillageMapController;
use App\Support\ApbdesWorkflow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'pages.admin.dashboard')->name('dashboard');
    Route::redirect('/home', '/dashboard');


    Route::prefix('admin')
        ->group(function () {
            Route::get('penduduk/export', [CitizenExcelController::class, 'export'])->name('citizens.export');
            Route::get('penduduk/template', [CitizenExcelController::class, 'template'])->name('citizens.template');
            Route::get('profil-desa/peta-desa', [VillageMapController::class, 'index'])
                ->middleware('permission:village_maps.view')
                ->name('village-maps.index');
            Route::put('profil-desa/peta-desa', [VillageMapController::class, 'update'])
                ->middleware('permission:village_maps.edit')
                ->name('village-maps.update');
            Route::prefix('apbdes')->name('budgets.')->group(function () {
                $budgetPages = [
                    'overview' => [
                        'uri' => '',
                        'route_name' => 'index',
                        'title' => 'APBDes',
                        'description' => 'Ringkasan, tahapan kerja, dan akses bertingkat modul APBDes.',
                    ],
                    'fiscal-years' => [
                        'uri' => 'tahun-anggaran',
                        'route_name' => 'fiscal-years',
                        'title' => 'Tahun Anggaran APBDes',
                        'description' => 'Tetapkan tahun anggaran sebagai dasar pengelolaan APBDes.',
                    ],
                    'funding-sources' => [
                        'uri' => 'sumber-dana',
                        'route_name' => 'funding-sources',
                        'title' => 'Sumber Dana APBDes',
                        'description' => 'Kelola sumber dana sesuai tahapan penyusunan APBDes.',
                    ],
                    'accounts' => [
                        'uri' => 'akun',
                        'route_name' => 'accounts',
                        'title' => 'Akun APBDes',
                        'description' => 'Susun struktur akun APBDes sebagai dasar penganggaran.',
                    ],
                    'budget-lines' => [
                        'uri' => 'baris-anggaran',
                        'route_name' => 'budget-lines',
                        'title' => 'Baris Anggaran APBDes',
                        'description' => 'Kelola rincian anggaran berdasarkan akun, tahun, dan sumber dana.',
                    ],
                    'operations' => [
                        'uri' => 'operasional',
                        'route_name' => 'operations',
                        'title' => 'Operasional APBDes',
                        'description' => 'Kelola SPP, realisasi, buku kas, buku bank, dan buku pajak.',
                    ],
                ];

                foreach ($budgetPages as $slug => $page) {
                    Route::get($page['uri'], function () use ($page, $slug) {
                        $workflowSections = ApbdesWorkflow::sections();
                        $resolvedSlug = ApbdesWorkflow::resolveAccessibleSlug($slug);

                        if ($resolvedSlug !== $slug) {
                            $target = ApbdesWorkflow::section($resolvedSlug);

                            return redirect()->route($target['route_name']);
                        }

                        $sectionMeta = ApbdesWorkflow::section($slug);

                        return view('pages.admin.budgets.index', [
                            'title' => $page['title'],
                            'description' => $page['description'],
                            'routeName' => 'budgets.' . $page['route_name'],
                            'currentSection' => $slug,
                            'sectionMeta' => $sectionMeta,
                            'workflowSections' => $workflowSections,
                        ]);
                    })->name($page['route_name']);
                }
            });

            $adminPages = [
                'dashboard' => [
                    'name' => 'dashboard',
                    'title' => 'Dashboard',
                    'description' => 'Ringkasan statistik dan akses cepat ke seluruh modul dashboard.',
                    'view' => 'pages.admin.dashboard',
                ],
                'master-desa' => [
                    'name' => 'villages.edit',
                    'title' => 'Master Desa',
                    'description' => 'Pengelolaan profil desa, pejabat, dan identitas wilayah.',
                    'view' => 'pages.admin.section',
                ],
                'berita' => [
                    'name' => 'posts.index',
                    'title' => 'Berita',
                    'description' => 'Manajemen berita dari draft, review, hingga publish.',
                    'view' => 'pages.admin.posts.index',
                ],
                'kategori-berita' => [
                    'name' => 'post-categories.index',
                    'title' => 'Kategori Berita',
                    'description' => 'Manajemen kategori untuk artikel berita publik.',
                    'view' => 'pages.admin.post-categories.index',
                ],
                'pengumuman' => [
                    'name' => 'announcements.index',
                    'title' => 'Pengumuman',
                    'description' => 'Manajemen pengumuman resmi desa.',
                    'view' => 'pages.admin.announcements.index',
                ],
                'agenda' => [
                    'name' => 'agendas.index',
                    'title' => 'Agenda',
                    'description' => 'Manajemen agenda kegiatan desa.',
                    'view' => 'pages.admin.section',
                ],
                'potensi-desa' => [
                    'name' => 'potentials.index',
                    'title' => 'Potensi Desa',
                    'description' => 'Manajemen potensi desa untuk website publik.',
                    'view' => 'pages.admin.potentials.index',
                ],
                'penduduk' => [
                    'name' => 'citizens.index',
                    'title' => 'Data Penduduk',
                    'description' => 'Audit dan pengelolaan data administrasi penduduk desa.',
                    'view' => 'pages.admin.citizens.index',
                ],
                'kelahiran' => [
                    'name' => 'citizen-births.index',
                    'title' => 'Kelahiran Penduduk',
                    'description' => 'Pencatatan kelahiran penduduk sesuai peristiwa adminduk.',
                    'view' => 'pages.admin.citizen-births.index',
                ],
                'pindah-datang' => [
                    'name' => 'citizen-arrivals.index',
                    'title' => 'Pindah Datang Penduduk',
                    'description' => 'Pencatatan penduduk masuk atau pindah datang ke desa.',
                    'view' => 'pages.admin.citizen-arrivals.index',
                ],
                'kematian' => [
                    'name' => 'citizen-deaths.index',
                    'title' => 'Kematian Penduduk',
                    'description' => 'Pencatatan kematian penduduk dan sinkron status adminduk.',
                    'view' => 'pages.admin.citizen-deaths.index',
                ],
                'kk' => [
                    'name' => 'households.index',
                    'title' => 'KK',
                    'description' => 'Pengelolaan data kartu keluarga dan relasinya.',
                    'view' => 'pages.admin.households.index',
                ],
                'dusun' => [
                    'name' => 'hamlets.index',
                    'title' => 'Dusun',
                    'description' => 'Pengelolaan data dusun sebagai wilayah administratif desa.',
                    'view' => 'pages.admin.hamlets.index',
                ],
                'rw' => [
                    'name' => 'rws.index',
                    'title' => 'RW',
                    'description' => 'Pengelolaan data RW per dusun.',
                    'view' => 'pages.admin.rws.index',
                ],
                'rt' => [
                    'name' => 'rts.index',
                    'title' => 'RT',
                    'description' => 'Pengelolaan data RT per RW.',
                    'view' => 'pages.admin.rts.index',
                ],
                'surat' => [
                    'name' => 'letters.index',
                    'title' => 'Surat',
                    'description' => 'Verifikasi, review, approval, dan arsip surat.',
                    'view' => 'pages.admin.section',
                ],
                'pengaduan' => [
                    'name' => 'complaints.index',
                    'title' => 'Pengaduan',
                    'description' => 'Verifikasi, assign, dan penyelesaian pengaduan.',
                    'view' => 'pages.admin.section',
                ],
                'umkm' => [
                    'name' => 'businesses.index',
                    'title' => 'UMKM',
                    'description' => 'Pengelolaan UMKM dan produk usaha desa.',
                    'view' => 'pages.admin.section',
                ],
                'bumdes' => [
                    'name' => 'bumdes.index',
                    'title' => 'BUMDes',
                    'description' => 'Pengelolaan unit usaha dan transaksi BUMDes.',
                    'view' => 'pages.admin.section',
                ],
                'users' => [
                    'name' => 'users.index',
                    'title' => 'Users',
                    'description' => 'Manajemen akun, role, dan permission pengguna.',
                    'view' => 'pages.admin.users.index',
                ],
                'roles' => [
                    'name' => 'roles.index',
                    'title' => 'Roles',
                    'description' => 'Manajemen role pengguna.',
                    'view' => 'pages.admin.roles.index',
                ],
                'notifikasi' => [
                    'name' => 'audit-logs.index',
                    'title' => 'Notifikasi Audit',
                    'description' => 'Riwayat perubahan aplikasi berdasarkan role dan permission.',
                    'view' => 'pages.admin.audit-logs.index',
                ],
                'profile' => [
                    'name' => 'profile.index',
                    'title' => 'Profile',
                    'description' => 'Pengaturan profil pengguna.',
                    'view' => 'pages.admin.profile.index',
                ],
                'settings' => [
                    'name' => 'settings.index',
                    'title' => 'Settings',
                    'description' => 'Pengaturan sistem dan konfigurasi dashboard.',
                    'view' => 'pages.admin.section',
                ],
            ];

            foreach ($adminPages as $uri => $page) {
                Route::get($uri, fn() => view($page['view'], [
                    'title' => $page['title'],
                    'description' => $page['description'],
                    'routeName' => $page['name'],
                ]))->name($page['name']);
            }
        });
});
