<?php

namespace Database\Seeders;

use App\Domains\Citizen\Models\Citizen;
use App\Domains\Citizen\Models\CitizenArrival;
use App\Domains\Citizen\Models\CitizenBirth;
use App\Domains\Citizen\Models\CitizenDeath;
use App\Domains\Gallery\Models\Gallery;
use App\Domains\Gallery\Models\GalleryPhoto;
use App\Domains\Potential\Models\Potential;
use App\Domains\Potential\Models\PotentialCategory;
use App\Domains\Post\Models\Post;
use App\Domains\Post\Models\PostCategory;
use App\Domains\User\Models\User;
use App\Domains\Village\Models\Village;
use App\Domains\Village\Models\VillageProfile;
use App\Support\CitizenReferenceData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class OneTimeVillageDummySeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            VillageSeeder::class,
            AdministrativeAreaSeeder::class,
            PostCategorySeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            SuperAdminAccessSeeder::class,
            ApbdesReferenceSeeder::class,
            ApbdesDummySeeder::class,
            LargeCitizenDummySeeder::class,
        ]);

        $village = Village::query()->where('code', 'MENTUDA')->first();
        $author = User::query()->where('email', 'nurazani@bayurez.com')->first();

        if (! $village || ! $author) {
            $this->command?->warn('Village atau author default tidak ditemukan. Seeder dummy dibatalkan.');
            return;
        }

        $this->seedVillageProfile($village);
        $this->seedPosts($village, $author);
        $this->seedPotentials($village);
        $this->seedGalleries($village);
        $this->seedCitizenEvents($village);

        $this->command?->info('Seeder dummy terpadu selesai dijalankan.');
    }

    private function seedVillageProfile(Village $village): void
    {
        $mapDefaults = VillageProfile::defaultMapAttributesForVillage($village);
        $historyDefaults = VillageProfile::defaultHistoryAttributesForVillage($village);
        $visionDefaults = VillageProfile::defaultVisionMissionAttributesForVillage($village);
        $organizationDefaults = VillageProfile::defaultOrganizationAttributesForVillage($village);
        $organizationIdentity = VillageProfile::defaultOrganizationIdentityForVillage($village);
        $organizationOptions = VillageProfile::defaultOrganizationPositionOptions();

        $historyCards = [
            [
                'badge' => 'Awal Permukiman',
                'title' => 'Jejak Komunitas Pesisir Mentuda',
                'description' => 'Masyarakat awal Mentuda tumbuh dari komunitas pesisir yang menggantungkan hidup pada laut, jalur dagang lokal, dan hasil kebun keluarga.',
                'icon' => 'home',
                'image_path' => 'img/bg.jpg',
            ],
            [
                'badge' => 'Perubahan Desa',
                'title' => 'Perkembangan Ekonomi dan Pelayanan',
                'description' => 'Perjalanan desa terus berkembang lewat penguatan pemerintahan, aktivitas nelayan, UMKM rumahan, dan pelayanan administrasi yang lebih tertata.',
                'icon' => 'building',
                'image_path' => 'img/bg.jpg',
            ],
        ];

        $timelineItems = [
            [
                'label' => 'Masa Awal',
                'title' => 'Pembentukan Kawasan Hunian Warga',
                'desc' => 'Wilayah Mentuda mulai dikenal sebagai kawasan hunian masyarakat pesisir dengan pola hidup gotong royong dan hubungan kekerabatan yang kuat.',
                'icon' => 'home',
                'icon_image_path' => null,
            ],
            [
                'label' => 'Masa Tumbuh',
                'title' => 'Penguatan Aktivitas Laut dan Kebun',
                'desc' => 'Warga mengembangkan penghidupan melalui hasil laut, usaha kecil, dan kebun keluarga yang menopang kebutuhan harian desa.',
                'icon' => 'building',
                'icon_image_path' => null,
            ],
            [
                'label' => 'Masa Layanan',
                'title' => 'Peningkatan Administrasi dan Infrastruktur',
                'desc' => 'Tata kelola desa, layanan administrasi, dan infrastruktur dasar berkembang untuk menjawab kebutuhan masyarakat yang terus bertambah.',
                'icon' => 'spark',
                'icon_image_path' => null,
            ],
            [
                'label' => 'Masa Digital',
                'title' => 'Transparansi Informasi Publik Desa',
                'desc' => 'Desa mulai menghadirkan informasi publik digital agar layanan, profil desa, potensi, dan kegiatan lebih mudah diakses warga.',
                'icon' => 'spark',
                'icon_image_path' => null,
            ],
        ];

        $missionItems = [
            [
                'title' => 'Meningkatkan kualitas layanan pemerintahan desa',
                'desc' => 'Memastikan pelayanan administrasi, surat menyurat, dan informasi publik berjalan cepat, rapi, dan mudah dipahami warga.',
                'icon' => 'service',
            ],
            [
                'title' => 'Menguatkan ekonomi lokal berbasis potensi desa',
                'desc' => 'Mendorong hasil laut, wisata alam, dan UMKM warga agar berkembang sebagai sumber penghasilan yang berkelanjutan.',
                'icon' => 'chart',
            ],
            [
                'title' => 'Memperkuat kehidupan sosial dan budaya masyarakat',
                'desc' => 'Menjaga semangat gotong royong, tradisi lokal, dan ruang kebersamaan sebagai fondasi kehidupan desa.',
                'icon' => 'users',
            ],
            [
                'title' => 'Mendorong pembangunan desa yang terukur dan terbuka',
                'desc' => 'Menjadikan perencanaan, pelaksanaan, dan pelaporan pembangunan desa lebih transparan dan partisipatif.',
                'icon' => 'document',
            ],
        ];

        $organizationMembers = [
            ['id' => 'member-head', 'position_option_id' => 'head', 'name' => 'Muhammad Ridwan', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 10],
            ['id' => 'member-partner', 'position_option_id' => 'partner', 'name' => 'BPD Desa Mentuda', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 20],
            ['id' => 'member-secretary', 'position_option_id' => 'secretary', 'name' => 'Rina Marlina', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 30],
            ['id' => 'member-kaur-umum', 'position_option_id' => 'kaur-umum', 'name' => 'Dewi Anggraini', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 40],
            ['id' => 'member-kaur-keuangan', 'position_option_id' => 'kaur-keuangan', 'name' => 'Andika Saputra', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 50],
            ['id' => 'member-kaur-perencanaan', 'position_option_id' => 'kaur-perencanaan', 'name' => 'Fahri Kurniawan', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 60],
            ['id' => 'member-kasi-pemerintahan', 'position_option_id' => 'kasi-pemerintahan', 'name' => 'Ilham Pratama', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 70],
            ['id' => 'member-kasi-kesejahteraan', 'position_option_id' => 'kasi-kesejahteraan', 'name' => 'Siti Rahma', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 80],
            ['id' => 'member-kasi-pelayanan', 'position_option_id' => 'kasi-pelayanan', 'name' => 'Nur Aisyah', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 90],
            ['id' => 'member-kadus-1', 'position_option_id' => 'kadus-1', 'name' => 'Junaidi Basri', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 100],
            ['id' => 'member-kadus-2', 'position_option_id' => 'kadus-2', 'name' => 'Hendra Wijaya', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 110],
            ['id' => 'member-kadus-3', 'position_option_id' => 'kadus-3', 'name' => 'Putri Lestari', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 120],
        ];

        $profile = VillageProfile::query()->withTrashed()->firstOrNew([
            'village_id' => $village->id,
        ]);

        $profile->fill(array_merge(
            $mapDefaults,
            $historyDefaults,
            $visionDefaults,
            $organizationDefaults,
            [
                'description' => 'Desa Mentuda merupakan desa pesisir di Kecamatan Lingga, Kabupaten Lingga, yang berkembang melalui kekuatan masyarakat, hasil laut, gotong royong, dan pelayanan publik yang terus diperbaiki.',
                'address' => 'Jl. Raya Desa Mentuda, Kec. Lingga, Kab. Lingga, Kepulauan Riau',
                'phone' => '0776-000123',
                'email' => 'pemdes.mentuda@example.id',
                'website' => 'https://satudesa.bayurez.com',
                'logo_path' => null,
                'map_title' => 'Peta Desa Mentuda',
                'map_description' => 'Peta satelit desa untuk membantu warga dan pengunjung melihat lokasi kantor desa, fasilitas umum, dan titik penting lainnya di Mentuda.',
                'map_popup_title' => 'Kantor Desa Mentuda',
                'map_popup_description' => 'Titik kantor desa sebagai pusat layanan pemerintahan dan administrasi warga.',
                'map_info_title' => 'Informasi',
                'map_boundary_title' => 'Koordinat Utama',
                'map_boundary_description' => 'Titik pusat desa digunakan sebagai acuan tampilan peta publik dan editor peta admin.',
                'map_facility_title' => 'Fasilitas dan Titik Penting',
                'map_facility_description' => 'Berisi lokasi kantor desa, sekolah, masjid, lapangan, layanan listrik, dan titik wisata yang mudah dikenali warga.',
                'map_potential_title' => 'Potensi Wilayah',
                'map_potential_description' => 'Beberapa marker juga menandai lokasi yang sering dikenal warga sebagai titik orientasi desa dan wisata sekitar.',
                'map_note' => 'Data peta ini dibuat sebagai dummy awal agar admin dapat langsung mengedit koordinat, marker, dan informasi publik dari panel peta desa.',
                'history_title' => 'Sejarah Desa Mentuda',
                'history_description' => 'Narasi singkat perjalanan Desa Mentuda dari permukiman pesisir, penguatan ekonomi warga, hingga tata kelola desa saat ini.',
                'history_cover_badge' => 'Profil Desa',
                'history_cover_title' => 'Perjalanan Mentuda dari Jejak Pesisir ke Desa yang Terus Bertumbuh',
                'history_cover_image_path' => 'img/bg.jpg',
                'history_intro_text' => 'Sejarah Desa Mentuda tidak hanya berbicara tentang asal mula permukiman, tetapi juga tentang bagaimana masyarakat menjaga kebersamaan, mengelola sumber daya lokal, dan menata masa depan desa dengan semangat gotong royong.',
                'history_cards' => $historyCards,
                'history_timeline_badge' => 'Linimasa',
                'history_timeline_title' => 'Tonggak Perjalanan Desa',
                'history_timeline_items' => $timelineItems,
                'history_sidebar_title' => 'Catatan Ringkas',
                'history_sidebar_description' => 'Konten ini disiapkan untuk memudahkan admin mengelola narasi sejarah desa, linimasa, dan arsip visual dari satu halaman.',
                'vision' => 'Mewujudkan Desa Mentuda yang maju, tertata, sejahtera, dan berdaya saing melalui pelayanan publik yang baik serta penguatan potensi desa.',
                'mission' => 'Meningkatkan kualitas pelayanan publik dan mendorong pertumbuhan ekonomi masyarakat.',
                'vision_mission_title' => 'Visi dan Misi Desa Mentuda',
                'vision_mission_description' => 'Arah pembangunan desa yang menjadi dasar pelayanan pemerintahan, pengelolaan potensi lokal, dan penguatan kehidupan sosial masyarakat.',
                'vision_mission_hero_badge' => 'Profil Desa',
                'vision_mission_vision_badge' => 'Visi Desa',
                'vision_mission_vision_title' => 'Arah Besar Pembangunan Mentuda',
                'vision_mission_vision_description' => 'Visi desa menjadi panduan bersama agar seluruh program pemerintah desa tetap fokus pada pelayanan, kesejahteraan warga, dan pembangunan yang berkelanjutan.',
                'vision_mission_mission_badge' => 'Misi Desa',
                'vision_mission_mission_title' => 'Langkah Strategis Pemerintah Desa',
                'vision_mission_mission_items' => $missionItems,
                'vision_mission_sidebar_title' => 'Tujuan Pembangunan',
                'vision_mission_sidebar_description' => 'Bagian ini membantu warga memahami tujuan besar desa dan langkah konkret yang dijalankan pemerintah desa dari waktu ke waktu.',
                'organization_page_title' => 'Struktur Organisasi Desa Mentuda',
                'organization_page_description' => 'Susunan perangkat desa yang menjalankan fungsi pemerintahan, pelayanan administrasi, pembangunan, dan pembinaan masyarakat.',
                'organization_section_badge' => 'Struktur Pemerintahan',
                'organization_section_title' => 'Perangkat Desa Mentuda',
                'organization_section_description' => 'Data struktur organisasi ini digunakan langsung untuk halaman publik agar masyarakat mudah mengetahui pembagian tugas di kantor desa.',
                'organization_note' => 'Seluruh data anggota dapat diedit, diganti fotonya, dan ditambah sesuai kebutuhan perangkat desa.',
                'organization_sidebar_title' => 'Informasi Tata Kelola',
                'organization_sidebar_description' => 'Struktur organisasi memperlihatkan siapa saja perangkat desa yang menangani pelayanan, administrasi, pembangunan, dan pembinaan warga.',
                'organization_identity' => array_merge($organizationIdentity, [
                    'page_title' => 'Struktur Organisasi Desa Mentuda',
                    'section_title' => 'Perangkat Desa Mentuda',
                    'note' => 'Seluruh data anggota dapat diedit, diganti fotonya, dan ditambah sesuai kebutuhan perangkat desa.',
                ]),
                'organization_position_options' => $organizationOptions,
                'organization_members' => $organizationMembers,
            ]
        ));

        if ($profile->trashed()) {
            $profile->restore();
        }

        $profile->save();
    }

    private function seedPosts(Village $village, User $author): void
    {
        $newsCategoryId = PostCategory::query()->where('slug', 'berita-desa')->value('id');
        $announcementCategoryId = PostCategory::query()->where('slug', 'pengumuman')->value('id');

        if (! $newsCategoryId || ! $announcementCategoryId) {
            $this->command?->warn('Kategori berita atau pengumuman belum tersedia.');
            return;
        }

        $newsItems = [
            ['title' => 'Pelayanan Administrasi Desa Semakin Cepat', 'excerpt' => 'Pemerintah desa mempercepat alur pelayanan administrasi agar warga mendapat proses yang lebih ringkas dan transparan.'],
            ['title' => 'Gotong Royong Warga Bersihkan Lingkungan Permukiman', 'excerpt' => 'Warga Desa Mentuda bersama perangkat desa membersihkan jalan lingkungan dan saluran air secara bergotong royong.'],
            ['title' => 'Pelatihan UMKM Rumah Tangga Dorong Produk Lokal', 'excerpt' => 'Pelatihan ini membantu warga mengembangkan kemasan, promosi, dan strategi penjualan produk lokal desa.'],
            ['title' => 'Perbaikan Jalan Lingkungan Masuk Tahap Penyelesaian', 'excerpt' => 'Pekerjaan infrastruktur jalan desa mulai memasuki tahap akhir untuk mendukung mobilitas warga.'],
            ['title' => 'Kegiatan Posyandu Rutin Tingkatkan Layanan Kesehatan', 'excerpt' => 'Pelayanan kesehatan ibu dan anak terus diperkuat melalui kegiatan posyandu bulanan di balai desa.'],
            ['title' => 'Remaja Desa Ikut Pelatihan Konten Digital', 'excerpt' => 'Generasi muda desa dilibatkan dalam promosi potensi dan kegiatan desa melalui pelatihan konten digital.'],
            ['title' => 'Nelayan Lokal Perkuat Kerja Sama Hasil Laut', 'excerpt' => 'Kelompok nelayan memperkuat koordinasi pemasaran hasil tangkap agar nilai jual produk semakin baik.'],
            ['title' => 'Pemerintah Desa Siapkan Agenda Musrenbang Tahunan', 'excerpt' => 'Agenda perencanaan tahunan desa disusun dengan mengutamakan usulan prioritas dari masyarakat.'],
            ['title' => 'Festival Pesisir Mentuda Meriahkan Akhir Pekan', 'excerpt' => 'Kegiatan budaya dan bazar warga meramaikan kawasan pesisir sekaligus mengenalkan potensi desa.'],
            ['title' => 'Layanan Informasi Publik Desa Kini Lebih Mudah Diakses', 'excerpt' => 'Halaman publik desa diperbarui agar informasi profil, peta, berita, dan galeri lebih mudah dijangkau warga.'],
        ];

        $announcementItems = [
            ['title' => 'Pengumuman Musyawarah Desa Bulan Ini', 'excerpt' => 'Warga diundang hadir dalam musyawarah desa untuk membahas agenda prioritas pembangunan.'],
            ['title' => 'Jadwal Pelayanan Administrasi Mingguan', 'excerpt' => 'Informasi jam operasional pelayanan administrasi desa untuk surat menyurat dan kebutuhan kependudukan.'],
            ['title' => 'Pemberitahuan Gotong Royong Lingkungan', 'excerpt' => 'Seluruh warga diminta berpartisipasi dalam kegiatan gotong royong di lingkungan masing-masing.'],
            ['title' => 'Informasi Posyandu Balita dan Lansia', 'excerpt' => 'Kegiatan posyandu dilaksanakan sesuai jadwal untuk balita, ibu, dan warga lanjut usia.'],
            ['title' => 'Pengumuman Pendaftaran Bantuan Sosial Desa', 'excerpt' => 'Warga yang memenuhi syarat dapat melakukan verifikasi data untuk program bantuan sosial desa.'],
            ['title' => 'Jadwal Pembagian Dokumen Kependudukan', 'excerpt' => 'Pengambilan dokumen yang telah selesai diproses dapat dilakukan pada jadwal yang ditentukan.'],
            ['title' => 'Pemberitahuan Pelatihan UMKM Desa', 'excerpt' => 'Pelaku usaha lokal dapat mengikuti pelatihan pengemasan produk dan pemasaran digital.'],
            ['title' => 'Agenda Kunjungan Tim Kecamatan ke Desa Mentuda', 'excerpt' => 'Pemerintah kecamatan dijadwalkan melakukan kunjungan koordinasi ke kantor desa.'],
            ['title' => 'Informasi Pembersihan Area Lapangan Bola', 'excerpt' => 'Warga sekitar diminta membantu menjaga kebersihan area lapangan sebelum kegiatan bersama dilaksanakan.'],
            ['title' => 'Pemberitahuan Verifikasi Data APBDesa', 'excerpt' => 'Perangkat desa melakukan penyesuaian data anggaran dan pelaporan agar informasi publik tetap akurat.'],
        ];

        foreach ($newsItems as $index => $item) {
            $publishedAt = Carbon::now()->subDays(20 - $index)->setTime(9, 0);
            $slug = 'dummy-berita-' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);

            $post = Post::query()->withTrashed()->firstOrNew(['slug' => $slug]);
            $post->fill([
                'village_id' => $village->id,
                'category_id' => $newsCategoryId,
                'author_id' => $author->id,
                'type' => Post::TYPE_NEWS,
                'title' => $item['title'],
                'excerpt' => $item['excerpt'],
                'content' => '<p>' . $item['excerpt'] . '</p><p>Konten dummy ini dibuat untuk mengisi modul berita agar admin dapat langsung melihat pola daftar artikel, kartu sorotan, pencarian, filter, dan tampilan detail artikel pada halaman publik.</p><p>Setiap artikel dapat diganti judul, ringkasan, isi, kategori, dan status publikasinya dari panel admin.</p>',
                'cover_image_path' => null,
                'cover_image_alt' => $item['title'],
                'cover_image_caption' => 'Konten dummy berita Desa Mentuda.',
                'is_featured' => $index === 0,
                'meta_title' => $item['title'],
                'meta_description' => $item['excerpt'],
                'tags' => ['berita', 'desa', 'mentuda', 'dummy'],
                'status' => 'published',
                'published_at' => $publishedAt,
                'event_at' => null,
                'event_location' => null,
            ]);
            $post->deleted_at = null;
            $post->save();
        }

        foreach ($announcementItems as $index => $item) {
            $publishedAt = Carbon::now()->subDays(15 - $index)->setTime(10, 30);
            $eventAt = Carbon::now()->addDays($index + 2)->setTime(9 + ($index % 3), 0);
            $slug = 'dummy-pengumuman-' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);

            $post = Post::query()->withTrashed()->firstOrNew(['slug' => $slug]);
            $post->fill([
                'village_id' => $village->id,
                'category_id' => $announcementCategoryId,
                'author_id' => $author->id,
                'type' => Post::TYPE_ANNOUNCEMENT,
                'title' => $item['title'],
                'excerpt' => $item['excerpt'],
                'content' => '<p>' . $item['excerpt'] . '</p><p>Data dummy pengumuman ini dibuat agar daftar pengumuman, agenda, pencarian, dan tampilan detail modul pengumuman dapat langsung digunakan untuk simulasi pengelolaan konten.</p>',
                'cover_image_path' => null,
                'cover_image_alt' => $item['title'],
                'cover_image_caption' => 'Konten dummy pengumuman Desa Mentuda.',
                'is_featured' => $index < 2,
                'meta_title' => $item['title'],
                'meta_description' => $item['excerpt'],
                'tags' => ['pengumuman', 'desa', 'mentuda', 'dummy'],
                'status' => 'published',
                'published_at' => $publishedAt,
                'event_at' => $eventAt,
                'event_location' => 'Balai Desa Mentuda',
            ]);
            $post->deleted_at = null;
            $post->save();
        }
    }

    private function seedPotentials(Village $village): void
    {
        $categories = collect([
            ['name' => 'Wisata Alam', 'slug' => 'wisata-alam', 'description' => 'Potensi wisata berbasis alam dan panorama desa.', 'icon' => 'map', 'sort_order' => 1],
            ['name' => 'UMKM', 'slug' => 'umkm', 'description' => 'Potensi produk dan usaha masyarakat desa.', 'icon' => 'store', 'sort_order' => 2],
            ['name' => 'Perikanan', 'slug' => 'perikanan', 'description' => 'Potensi hasil laut dan kegiatan perikanan desa.', 'icon' => 'fish', 'sort_order' => 3],
            ['name' => 'Budaya', 'slug' => 'budaya', 'description' => 'Potensi tradisi, seni, dan kearifan lokal desa.', 'icon' => 'sparkles', 'sort_order' => 4],
            ['name' => 'Pertanian', 'slug' => 'pertanian', 'description' => 'Potensi lahan, hasil panen, dan komoditas pertanian desa.', 'icon' => 'leaf', 'sort_order' => 5],
        ])->map(function (array $item) {
            $category = PotentialCategory::query()->updateOrCreate(
                ['slug' => $item['slug']],
                array_merge($item, [
                    'village_id' => null,
                    'is_active' => true,
                ])
            );

            return [$item['slug'] => $category];
        })->collapse();

        $items = [
            ['title' => 'Air Terjun Jelutung', 'category' => 'wisata-alam', 'type' => 'Wisata Alam', 'location' => 'Jelutung', 'lat' => -0.04471756670279473, 'lng' => 104.52458475692802],
            ['title' => 'Air Terjun Ceruk Lansi', 'category' => 'wisata-alam', 'type' => 'Wisata Alam', 'location' => 'Ceruk Lansi', 'lat' => -0.20102297802611196, 'lng' => 104.52642955211994],
            ['title' => 'Pulau Pulun dan Sekitarnya', 'category' => 'wisata-alam', 'type' => 'Wisata Alam', 'location' => 'Pulun', 'lat' => -0.152688284473764, 'lng' => 104.45535561513798],
            ['title' => 'Sentra Kerupuk Ikan Mentuda', 'category' => 'umkm', 'type' => 'UMKM', 'location' => 'Permukiman Warga', 'lat' => -0.16428162809505903, 'lng' => 104.48305243970835],
            ['title' => 'Olahan Sambal Bilis Rumah Tangga', 'category' => 'umkm', 'type' => 'UMKM', 'location' => 'Balai Usaha Warga', 'lat' => -0.16410707614686607, 'lng' => 104.48440840753422],
            ['title' => 'Aktivitas Perikanan Nelayan Pesisir', 'category' => 'perikanan', 'type' => 'Perikanan', 'location' => 'Pesisir Desa', 'lat' => -0.16444973243436398, 'lng' => 104.48380421917913],
            ['title' => 'Budaya Festival Pesisir Desa', 'category' => 'budaya', 'type' => 'Budaya', 'location' => 'Lapangan Bola', 'lat' => -0.16444973243436398, 'lng' => 104.48380421917913],
            ['title' => 'Kegiatan Keagamaan Masjid Nurul Ikhsan', 'category' => 'budaya', 'type' => 'Budaya Religi', 'location' => 'Masjid Nurul Ikhsan', 'lat' => -0.16407903156154036, 'lng' => 104.4823809066981],
            ['title' => 'Kebun Kelapa dan Hasil Tani Warga', 'category' => 'pertanian', 'type' => 'Pertanian', 'location' => 'Kawasan Kebun Desa', 'lat' => -0.16143306425100784, 'lng' => 104.48220741975265],
            ['title' => 'Peluang Wisata Edukasi Desa Pesisir', 'category' => 'wisata-alam', 'type' => 'Wisata Edukasi', 'location' => 'Koridor Desa Mentuda', 'lat' => -0.16428162809505903, 'lng' => 104.48305243970835],
        ];

        foreach ($items as $index => $item) {
            /** @var PotentialCategory|null $category */
            $category = $categories->get($item['category']);
            $slug = 'dummy-potensi-' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);

            $potential = Potential::query()->withTrashed()->firstOrNew(['slug' => $slug]);
            $potential->fill([
                'village_id' => $village->id,
                'category_id' => $category?->id,
                'title' => $item['title'],
                'excerpt' => 'Data dummy potensi desa untuk simulasi pengelolaan konten publik dan admin pada modul potensi desa.',
                'content' => '<p>' . $item['title'] . ' merupakan salah satu contoh konten dummy untuk mengisi modul potensi desa.</p><p>Konten ini dapat diedit kembali sesuai kondisi lapangan, foto asli, informasi lokasi, fasilitas pendukung, serta peluang pengembangan yang dimiliki desa.</p>',
                'cover_image_path' => null,
                'cover_image_alt' => $item['title'],
                'cover_image_caption' => 'Ilustrasi potensi desa.',
                'is_featured' => $index === 0,
                'potential_type' => $item['type'],
                'location_name' => $item['location'],
                'address' => 'Wilayah ' . $item['location'] . ', Desa Mentuda, Kec. Lingga, Kab. Lingga',
                'latitude' => $item['lat'],
                'longitude' => $item['lng'],
                'contact_person' => 'Koordinator Potensi Desa',
                'contact_phone' => '0812-3456-78' . str_pad((string) $index, 2, '0', STR_PAD_LEFT),
                'facilities' => '<ul><li>Akses lokasi dasar</li><li>Ruang aktivitas warga</li><li>Dukungan promosi desa</li></ul>',
                'opportunities' => '<ul><li>Promosi digital</li><li>Paket kunjungan</li><li>Kolaborasi UMKM dan wisata</li></ul>',
                'development_status' => $index < 4 ? 'Siap dikembangkan' : 'Dalam penguatan konten',
                'sort_order' => ($index + 1) * 10,
                'status' => 'published',
                'published_at' => Carbon::now()->subDays(12 - $index)->setTime(8, 0),
            ]);
            $potential->deleted_at = null;
            $potential->save();
        }
    }

    private function seedGalleries(Village $village): void
    {
        $items = [
            ['title' => 'Festival Pesisir Mentuda', 'category' => 'Kegiatan Desa', 'location' => 'Pesisir Desa'],
            ['title' => 'Gotong Royong Lingkungan Warga', 'category' => 'Kegiatan Desa', 'location' => 'Permukiman Warga'],
            ['title' => 'Pembangunan Jalan Lingkungan', 'category' => 'Pembangunan', 'location' => 'Koridor Jalan Utama'],
            ['title' => 'Posyandu dan Pelayanan Kesehatan', 'category' => 'Pelayanan Publik', 'location' => 'Balai Desa'],
            ['title' => 'Pelatihan UMKM Rumah Tangga', 'category' => 'UMKM', 'location' => 'Ruang Pertemuan'],
            ['title' => 'Suasana Lapangan Bola Desa', 'category' => 'Fasilitas Umum', 'location' => 'Lapangan Bola'],
            ['title' => 'Aktivitas Nelayan Pesisir', 'category' => 'Ekonomi Desa', 'location' => 'Pesisir Desa'],
            ['title' => 'Kegiatan Keagamaan Warga', 'category' => 'Sosial Budaya', 'location' => 'Masjid Nurul Ikhsan'],
            ['title' => 'Dokumentasi Sekolah dan Anak Desa', 'category' => 'Pendidikan', 'location' => 'Area SD dan SMP'],
            ['title' => 'Panorama Wisata Sekitar Mentuda', 'category' => 'Wisata', 'location' => 'Jelutung dan Ceruk Lansi'],
        ];

        foreach ($items as $index => $item) {
            $slug = 'dummy-galeri-' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);

            $gallery = Gallery::query()->withTrashed()->firstOrNew(['slug' => $slug]);
            $gallery->fill([
                'village_id' => $village->id,
                'title' => $item['title'],
                'category' => $item['category'],
                'excerpt' => 'Album dummy untuk mengisi manajemen galeri desa pada panel admin dan halaman publik.',
                'description' => 'Album ini berisi dokumentasi dummy yang dapat diganti admin dengan foto asli kegiatan, pembangunan, fasilitas, dan suasana Desa Mentuda.',
                'cover_image_path' => 'img/bg.jpg',
                'location_name' => $item['location'],
                'photo_count' => 5,
                'sort_order' => ($index + 1) * 10,
                'is_featured' => $index === 0,
                'status' => 'published',
                'gallery_date' => Carbon::now()->subDays(18 - $index)->toDateString(),
                'published_at' => Carbon::now()->subDays(17 - $index)->setTime(11, 0),
            ]);
            $gallery->deleted_at = null;
            $gallery->save();

            GalleryPhoto::query()->where('gallery_id', $gallery->id)->delete();

            for ($photoIndex = 1; $photoIndex <= 5; $photoIndex++) {
                GalleryPhoto::query()->create([
                    'gallery_id' => $gallery->id,
                    'image_path' => 'img/bg.jpg',
                    'alt_text' => $item['title'] . ' foto ' . $photoIndex,
                    'caption' => 'Foto dummy ' . $photoIndex . ' untuk album ' . $item['title'] . '.',
                    'sort_order' => $photoIndex,
                    'is_cover' => $photoIndex === 1,
                ]);
            }

            $gallery->syncPhotoCount();
            $gallery->syncCoverFromPhotos();
        }
    }

    private function seedCitizenEvents(Village $village): void
    {
        $citizens = Citizen::query()
            ->whereNotNull('household_id')
            ->orderBy('birth_date')
            ->get([
                'id',
                'household_id',
                'nik',
                'full_name',
                'gender',
                'birth_date',
                'family_relationship',
                'status',
            ]);

        if ($citizens->isEmpty()) {
            $this->command?->warn('Data warga belum tersedia untuk mengisi peristiwa penduduk.');
            return;
        }

        $byHousehold = $citizens->groupBy('household_id');

        $birthCitizens = $citizens
            ->filter(fn (Citizen $citizen) => optional($citizen->birth_date)->gte(Carbon::now()->subYears(4)))
            ->take(12)
            ->values();

        foreach ($birthCitizens as $index => $citizen) {
            $family = $byHousehold->get($citizen->household_id, collect());
            $father = $family->first(fn (Citizen $member) => $member->gender === 'L' && $member->id !== $citizen->id);
            $mother = $family->first(fn (Citizen $member) => $member->gender === 'P' && $member->id !== $citizen->id);

            CitizenBirth::query()->updateOrCreate(
                ['citizen_id' => $citizen->id],
                [
                    'village_id' => $village->id,
                    'household_id' => $citizen->household_id,
                    'father_nik' => $father?->nik,
                    'father_name' => $father?->full_name ?? 'Ayah Dummy',
                    'mother_nik' => $mother?->nik,
                    'mother_name' => $mother?->full_name ?? 'Ibu Dummy',
                    'birth_time' => sprintf('%02d:%02d', 6 + ($index % 8), ($index * 5) % 60),
                    'birth_weight' => (string) (2.8 + (($index % 4) * 0.2)) . ' kg',
                    'birth_length' => (string) (47 + $index % 5) . ' cm',
                    'birth_order' => ($index % 3) + 1,
                    'birth_type' => CitizenReferenceData::birthTypeOptions()[0],
                    'birth_attendant' => CitizenReferenceData::birthAttendantOptions()[1],
                    'birth_certificate_number' => 'KEL-' . Carbon::now()->format('Y') . '-' . str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                    'reporter_name' => $father?->full_name ?? $mother?->full_name ?? 'Pelapor Dummy',
                    'reporter_relation' => 'Kepala Keluarga',
                    'witness_1_name' => 'Saksi Kelahiran ' . ($index + 1),
                    'witness_2_name' => 'Saksi Kelahiran ' . ($index + 11),
                    'notes' => 'Riwayat kelahiran dummy untuk simulasi form kelahiran penduduk.',
                ]
            );
        }

        $arrivalCandidates = $citizens
            ->filter(fn (Citizen $citizen) => $citizen->status === 'active')
            ->sortByDesc('birth_date')
            ->take(12)
            ->values();

        foreach ($arrivalCandidates as $index => $citizen) {
            CitizenArrival::query()->updateOrCreate(
                [
                    'citizen_id' => $citizen->id,
                    'moving_certificate_number' => 'DTG-' . Carbon::now()->format('Y') . '-' . str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                ],
                [
                    'village_id' => $village->id,
                    'household_id' => $citizen->household_id,
                    'arrival_date' => Carbon::now()->subMonths($index + 1)->toDateString(),
                    'origin_address' => 'Jl. Asal Pendatang No. ' . ($index + 1),
                    'origin_region' => collect(['Kota Batam', 'Tanjungpinang', 'Dabo Singkep', 'Daik Lingga'])->get($index % 4),
                    'origin_no_kk' => '2104018' . str_pad((string) ($index + 1), 9, '0', STR_PAD_LEFT),
                    'moved_member_count' => ($index % 4) + 1,
                    'arrival_reason' => CitizenReferenceData::arrivalReasonOptions()[$index % count(CitizenReferenceData::arrivalReasonOptions())],
                    'arrival_classification' => CitizenReferenceData::arrivalClassificationOptions()[$index % count(CitizenReferenceData::arrivalClassificationOptions())],
                    'reporter_name' => $citizen->full_name,
                    'reporter_relation' => 'Kepala Keluarga',
                    'notes' => 'Riwayat kedatangan dummy untuk simulasi form pendatang.',
                ]
            );
        }

        $deathCandidates = $citizens
            ->filter(fn (Citizen $citizen) => $citizen->status === 'active')
            ->sortBy('birth_date')
            ->take(8)
            ->values();

        foreach ($deathCandidates as $index => $citizen) {
            CitizenDeath::query()->updateOrCreate(
                ['citizen_id' => $citizen->id],
                [
                    'village_id' => $village->id,
                    'death_date' => Carbon::now()->subMonths($index + 2)->toDateString(),
                    'death_time' => sprintf('%02d:%02d', 7 + ($index % 5), 15),
                    'death_place' => 'Rumah Keluarga',
                    'cause_of_death' => CitizenReferenceData::deathCauseOptions()[$index % count(CitizenReferenceData::deathCauseOptions())],
                    'certifier' => 'Petugas Kesehatan Desa',
                    'death_certificate_number' => 'MGL-' . Carbon::now()->format('Y') . '-' . str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                    'reporter_name' => 'Pelapor Kematian ' . ($index + 1),
                    'reporter_relation' => 'Anak',
                    'witness_1_name' => 'Saksi Kematian ' . ($index + 1),
                    'witness_2_name' => 'Saksi Kematian ' . ($index + 11),
                    'burial_place' => 'Pemakaman Umum Desa',
                    'notes' => 'Riwayat kematian dummy untuk simulasi form kematian penduduk.',
                ]
            );

            $citizen->forceFill(['status' => 'deceased'])->saveQuietly();
        }
    }
}
