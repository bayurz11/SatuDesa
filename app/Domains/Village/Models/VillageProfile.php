<?php

namespace App\Domains\Village\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VillageProfile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'village_id',
        'description',
        'vision',
        'mission',
        'address',
        'phone',
        'email',
        'website',
        'logo_path',
        'map_title',
        'map_description',
        'map_latitude',
        'map_longitude',
        'map_zoom',
        'map_popup_title',
        'map_popup_description',
        'map_info_title',
        'map_boundary_title',
        'map_boundary_description',
        'map_boundary_geojson',
        'map_facility_title',
        'map_facility_description',
        'map_potential_title',
        'map_potential_description',
        'map_note',
        'map_markers',
        'history_title',
        'history_description',
        'history_cover_badge',
        'history_cover_title',
        'history_cover_image_path',
        'history_intro_text',
        'history_cards',
        'history_timeline_badge',
        'history_timeline_title',
        'history_timeline_items',
        'history_sidebar_title',
        'history_sidebar_description',
        'vision_mission_title',
        'vision_mission_description',
        'vision_mission_hero_badge',
        'vision_mission_vision_badge',
        'vision_mission_vision_title',
        'vision_mission_vision_description',
        'vision_mission_mission_badge',
        'vision_mission_mission_title',
        'vision_mission_mission_items',
        'vision_mission_sidebar_title',
        'vision_mission_sidebar_description',
        'organization_page_title',
        'organization_page_description',
        'organization_section_badge',
        'organization_section_title',
        'organization_section_description',
        'organization_head',
        'organization_partner',
        'organization_secretary',
        'organization_kaur_items',
        'organization_kasi_items',
        'organization_dusun_items',
        'organization_note',
        'organization_sidebar_title',
        'organization_sidebar_description',
        'organization_identity',
        'organization_position_options',
        'organization_members',
    ];

    protected $casts = [
        'map_latitude' => 'decimal:7',
        'map_longitude' => 'decimal:7',
        'map_zoom' => 'integer',
        'map_boundary_geojson' => 'array',
        'map_markers' => 'array',
        'history_cards' => 'array',
        'history_timeline_items' => 'array',
        'vision_mission_mission_items' => 'array',
        'organization_head' => 'array',
        'organization_partner' => 'array',
        'organization_secretary' => 'array',
        'organization_kaur_items' => 'array',
        'organization_kasi_items' => 'array',
        'organization_dusun_items' => 'array',
        'organization_identity' => 'array',
        'organization_position_options' => 'array',
        'organization_members' => 'array',
    ];

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public static function defaultMapAttributesForVillage(Village $village): array
    {
        return [
            'map_title' => 'Lokasi Desa ' . $village->name,
            'map_description' => 'Peta ini menampilkan titik koordinat desa beserta marker fasilitas umum dan lokasi penting lainnya.',
            'map_latitude' => -0.1642816,
            'map_longitude' => 104.4830524,
            'map_zoom' => 18,
            'map_popup_title' => 'Kantor Desa',
            'map_popup_description' => $village->name . ' - Kec. ' . $village->district . ', Kab. ' . $village->regency,
            'map_info_title' => 'Detail Peta',
            'map_boundary_title' => 'Koordinat Lokasi',
            'map_boundary_description' => 'Titik koordinat utama desa ditampilkan pada peta agar lokasi mudah dikenali.',
            'map_boundary_geojson' => null,
            'map_facility_title' => 'Fasilitas Umum',
            'map_facility_description' => 'Lokasi balai desa, sekolah, tempat ibadah, pelabuhan, dan layanan masyarakat.',
            'map_potential_title' => 'Potensi Desa',
            'map_potential_description' => 'Titik wisata, hasil laut, UMKM, pertanian, dan zona ekonomi warga.',
            'map_note' => 'Titik koordinat utama dapat dipilih langsung dari peta admin. Gunakan klik peta, geser marker utama, atau pencarian lokasi untuk menyesuaikannya.',
            'map_markers' => [
                [
                    'name' => 'Kantor Desa',
                    'category' => 'Pemerintahan',
                    'latitude' => -0.16428162809505903,
                    'longitude' => 104.48305243970835,
                    'description' => $village->name . ' - Kec. ' . $village->district . ', Kab. ' . $village->regency,
                ],
                [
                    'name' => 'Lapangan Bola',
                    'category' => 'Olahraga',
                    'latitude' => -0.16444973243436398,
                    'longitude' => 104.48380421917913,
                    'description' => 'Lapangan bola desa.',
                ],
                [
                    'name' => 'Masjid Nurul Ikhsan',
                    'category' => 'Ibadah',
                    'latitude' => -0.16407903156154036,
                    'longitude' => 104.4823809066981,
                    'description' => 'Masjid Nurul Ikhsan.',
                ],
                [
                    'name' => 'PLN',
                    'category' => 'Layanan',
                    'latitude' => -0.16410707614686607,
                    'longitude' => 104.48440840753422,
                    'description' => 'Titik layanan PLN.',
                ],
                [
                    'name' => 'SD dan SMP',
                    'category' => 'Pendidikan',
                    'latitude' => -0.16143306425100784,
                    'longitude' => 104.48220741975265,
                    'description' => 'Area sekolah dasar dan sekolah menengah pertama.',
                ],
                [
                    'name' => 'Pulun',
                    'category' => 'Lokasi',
                    'latitude' => -0.152688284473764,
                    'longitude' => 104.45535561513798,
                    'description' => 'Titik lokasi Pulun.',
                ],
                [
                    'name' => 'Air Terjun Jelutung',
                    'category' => 'Wisata',
                    'latitude' => -0.04471756670279473,
                    'longitude' => 104.52458475692802,
                    'description' => 'Objek wisata Air Terjun Jelutung.',
                ],
                [
                    'name' => 'Air Terjun Ceruk Lansi',
                    'category' => 'Wisata',
                    'latitude' => -0.20102297802611196,
                    'longitude' => 104.52642955211994,
                    'description' => 'Objek wisata Air Terjun Ceruk Lansi.',
                ],
            ],
        ];
    }

    public static function defaultHistoryAttributesForVillage(Village $village): array
    {
        return [
            'history_title' => 'Sejarah Desa ' . $village->name,
            'history_description' => 'Menyusuri jejak perjalanan panjang ' . $village->name . ' dari masa lampau hingga kini.',
            'history_cover_badge' => 'Arsip Desa',
            'history_cover_title' => 'Jejak Perjalanan Desa dari Masa ke Masa',
            'history_cover_image_path' => 'img/bg.jpg',
            'history_intro_text' => $village->name . ' tumbuh dari komunitas masyarakat pesisir yang memiliki hubungan erat dengan laut, pertanian, dan tradisi gotong royong. Dalam lintasan sejarahnya, desa ini berkembang menjadi ruang hidup yang menghubungkan warisan budaya lama dengan kebutuhan masyarakat modern.',
            'history_cards' => [
                [
                    'badge' => 'Awal Mula',
                    'title' => 'Asal-Usul Pemukiman',
                    'description' => 'Kawasan Mentuda dipercaya mulai dihuni oleh kelompok masyarakat yang menetap di sekitar jalur pesisir dan memanfaatkan sumber daya alam secara turun-temurun.',
                    'icon' => 'home',
                    'image_path' => null,
                ],
                [
                    'badge' => 'Perkembangan',
                    'title' => 'Pertumbuhan Sosial dan Ekonomi',
                    'description' => 'Seiring waktu, aktivitas masyarakat meluas pada sektor perikanan, perdagangan lokal, dan usaha rumah tangga yang memperkuat fondasi ekonomi desa.',
                    'icon' => 'building',
                    'image_path' => null,
                ],
            ],
            'history_timeline_badge' => 'Linimasa',
            'history_timeline_title' => 'Tonggak Sejarah Desa',
            'history_timeline_items' => [
                [
                    'label' => 'Periode Awal',
                    'title' => 'Pembentukan Komunitas Permukiman',
                    'desc' => 'Masyarakat mulai membentuk kawasan hunian tetap dan mengembangkan pola hidup berbasis kebersamaan.',
                    'icon' => 'home',
                    'icon_image_path' => null,
                ],
                [
                    'label' => 'Periode Penguatan',
                    'title' => 'Pengembangan Wilayah dan Kelembagaan',
                    'desc' => 'Infrastruktur dasar dan tata kelola desa berkembang untuk menjawab kebutuhan warga yang semakin beragam.',
                    'icon' => 'building',
                    'icon_image_path' => null,
                ],
                [
                    'label' => 'Periode Modern',
                    'title' => 'Transformasi Pelayanan dan Informasi Publik',
                    'desc' => 'Desa mulai beradaptasi dengan kebutuhan digital, transparansi informasi, dan peningkatan kualitas layanan publik.',
                    'icon' => 'spark',
                    'icon_image_path' => null,
                ],
            ],
            'history_sidebar_title' => 'Catatan Sejarah',
            'history_sidebar_description' => 'Bagian ini dapat digunakan untuk menampilkan narasi sejarah, foto arsip, linimasa desa, atau informasi penting sebelum dihubungkan ke data dinamis.',
        ];
    }

    public static function defaultOrganizationAttributesForVillage(Village $village): array
    {
        return [
            'organization_page_title' => 'Struktur Organisasi Desa ' . $village->name,
            'organization_page_description' => 'Susunan pemerintahan desa yang menggambarkan pembagian tugas, fungsi pelayanan, dan tata kelola administrasi ' . $village->name . '.',
            'organization_section_badge' => 'Bagan Organisasi',
            'organization_section_title' => 'Struktur Organisasi Desa ' . $village->name,
            'organization_section_description' => 'Susunan pemerintahan desa yang menggambarkan pembagian tugas, fungsi pelayanan, dan tata kelola administrasi ' . $village->name . '.',
            'organization_head' => [
                'label' => 'Kepala Desa',
                'title' => 'Nama Kepala Desa',
                'name' => 'Pimpinan Pemerintahan Desa',
                'photo_path' => 'img/avatar-placeholder.png',
            ],
            'organization_partner' => [
                'label' => 'Mitra Desa',
                'title' => 'BPD',
                'name' => 'Badan Permusyawaratan Desa',
                'photo_path' => 'img/avatar-placeholder.png',
            ],
            'organization_secretary' => [
                'label' => 'Sekretariat Desa',
                'title' => 'Nama Sekretaris Desa',
                'name' => 'Sekretaris Desa',
                'photo_path' => 'img/avatar-placeholder.png',
            ],
            'organization_kaur_items' => [
                [
                    'label' => 'Kaur',
                    'title' => 'Kaur Tata Usaha & Umum',
                    'name' => 'Nama Kaur',
                    'photo_path' => 'img/avatar-placeholder.png',
                ],
                [
                    'label' => 'Kaur',
                    'title' => 'Kaur Keuangan',
                    'name' => 'Nama Kaur',
                    'photo_path' => 'img/avatar-placeholder.png',
                ],
                [
                    'label' => 'Kaur',
                    'title' => 'Kaur Perencanaan',
                    'name' => 'Nama Kaur',
                    'photo_path' => 'img/avatar-placeholder.png',
                ],
            ],
            'organization_kasi_items' => [
                [
                    'label' => 'Kasi',
                    'title' => 'Kasi Pemerintahan',
                    'name' => 'Nama Kasi',
                    'photo_path' => 'img/avatar-placeholder.png',
                ],
                [
                    'label' => 'Kasi',
                    'title' => 'Kasi Kesejahteraan',
                    'name' => 'Nama Kasi',
                    'photo_path' => 'img/avatar-placeholder.png',
                ],
                [
                    'label' => 'Kasi',
                    'title' => 'Kasi Pelayanan',
                    'name' => 'Nama Kasi',
                    'photo_path' => 'img/avatar-placeholder.png',
                ],
            ],
            'organization_dusun_items' => [
                [
                    'label' => 'Kadus',
                    'title' => 'Kepala Dusun I',
                    'name' => 'Nama Kadus',
                    'photo_path' => 'img/avatar-placeholder.png',
                ],
                [
                    'label' => 'Kadus',
                    'title' => 'Kepala Dusun II',
                    'name' => 'Nama Kadus',
                    'photo_path' => 'img/avatar-placeholder.png',
                ],
                [
                    'label' => 'Kadus',
                    'title' => 'Kepala Dusun III',
                    'name' => 'Nama Kadus',
                    'photo_path' => 'img/avatar-placeholder.png',
                ],
            ],
            'organization_note' => 'Struktur organisasi dapat disesuaikan dengan data perangkat desa dan foto masing-masing pejabat.',
            'organization_sidebar_title' => 'Tata Kelola Desa',
            'organization_sidebar_description' => 'Struktur organisasi membantu masyarakat memahami pembagian tugas, alur koordinasi, dan perangkat desa yang menjalankan pelayanan publik.',
            'organization_identity' => self::defaultOrganizationIdentityForVillage($village),
            'organization_position_options' => self::defaultOrganizationPositionOptions(),
            'organization_members' => self::defaultOrganizationMembers(),
        ];
    }

    public static function defaultVisionMissionAttributesForVillage(Village $village): array
    {
        return [
            'vision_mission_title' => 'Visi & Misi Desa ' . $village->name,
            'vision_mission_description' => 'Halaman ini menampilkan arah pembangunan desa, cita-cita jangka panjang, dan langkah strategis pelayanan masyarakat.',
            'vision_mission_hero_badge' => 'Profil Desa',
            'vision' => 'Mewujudkan Desa ' . $village->name . ' yang maju, mandiri, sejahtera, dan berdaya saing.',
            'vision_mission_vision_badge' => 'Visi Desa',
            'vision_mission_vision_title' => 'Arah Besar Pembangunan Desa',
            'vision_mission_vision_description' => 'Visi ini menjadi landasan besar dalam penyusunan kebijakan, pelayanan publik, penguatan ekonomi lokal, dan pembangunan sosial budaya masyarakat desa.',
            'mission' => 'Meningkatkan kualitas pelayanan publik',
            'vision_mission_mission_badge' => 'Misi Desa',
            'vision_mission_mission_title' => 'Langkah Strategis Pembangunan Desa',
            'vision_mission_mission_items' => self::defaultVisionMissionMissionItems(),
            'vision_mission_sidebar_title' => 'Arah Pembangunan',
            'vision_mission_sidebar_description' => 'Visi dan misi menjadi pedoman utama dalam pelayanan, pembangunan, pemberdayaan masyarakat, dan tata kelola desa yang transparan.',
        ];
    }

    public static function defaultVisionMissionMissionItems(): array
    {
        return [
            [
                'title' => 'Meningkatkan kualitas pelayanan publik',
                'desc' => 'Menghadirkan pelayanan yang cepat, terbuka, ramah, dan berbasis kebutuhan masyarakat.',
                'icon' => 'service',
            ],
            [
                'title' => 'Mengembangkan ekonomi masyarakat desa',
                'desc' => 'Mendorong pertumbuhan UMKM, pemanfaatan potensi lokal, dan peluang usaha berbasis desa.',
                'icon' => 'chart',
            ],
            [
                'title' => 'Memperkuat pembangunan sosial dan budaya',
                'desc' => 'Menjaga nilai gotong royong, harmoni sosial, serta identitas budaya masyarakat desa.',
                'icon' => 'users',
            ],
            [
                'title' => 'Mendorong tata kelola pemerintahan yang transparan',
                'desc' => 'Memastikan informasi publik mudah diakses dan pembangunan desa berjalan akuntabel.',
                'icon' => 'document',
            ],
        ];
    }

    public static function defaultOrganizationIdentityForVillage(Village $village): array
    {
        return [
            'page_title' => 'Struktur Organisasi Desa ' . $village->name,
            'page_description' => 'Susunan pemerintahan desa yang menggambarkan pembagian tugas, fungsi pelayanan, dan tata kelola administrasi ' . $village->name . '.',
            'section_badge' => 'Bagan Organisasi',
            'section_title' => 'Struktur Organisasi Desa ' . $village->name,
            'section_description' => 'Susunan pemerintahan desa yang menggambarkan pembagian tugas, fungsi pelayanan, dan tata kelola administrasi ' . $village->name . '.',
            'note' => 'Struktur organisasi dapat disesuaikan dengan data perangkat desa dan foto masing-masing pejabat.',
            'sidebar_title' => 'Tata Kelola Desa',
            'sidebar_description' => 'Struktur organisasi membantu masyarakat memahami pembagian tugas, alur koordinasi, dan perangkat desa yang menjalankan pelayanan publik.',
        ];
    }

    public static function defaultOrganizationPositionOptions(): array
    {
        return [
            ['id' => 'head', 'label' => 'Kepala Desa', 'title' => 'Kepala Desa', 'group' => 'pimpinan', 'sort_order' => 10],
            ['id' => 'partner', 'label' => 'Mitra Desa', 'title' => 'BPD', 'group' => 'mitra', 'sort_order' => 20],
            ['id' => 'secretary', 'label' => 'Sekretariat Desa', 'title' => 'Sekretaris Desa', 'group' => 'sekretariat', 'sort_order' => 30],
            ['id' => 'kaur-umum', 'label' => 'Kaur', 'title' => 'Kaur Tata Usaha & Umum', 'group' => 'kaur', 'sort_order' => 40],
            ['id' => 'kaur-keuangan', 'label' => 'Kaur', 'title' => 'Kaur Keuangan', 'group' => 'kaur', 'sort_order' => 50],
            ['id' => 'kaur-perencanaan', 'label' => 'Kaur', 'title' => 'Kaur Perencanaan', 'group' => 'kaur', 'sort_order' => 60],
            ['id' => 'kasi-pemerintahan', 'label' => 'Kasi', 'title' => 'Kasi Pemerintahan', 'group' => 'kasi', 'sort_order' => 70],
            ['id' => 'kasi-kesejahteraan', 'label' => 'Kasi', 'title' => 'Kasi Kesejahteraan', 'group' => 'kasi', 'sort_order' => 80],
            ['id' => 'kasi-pelayanan', 'label' => 'Kasi', 'title' => 'Kasi Pelayanan', 'group' => 'kasi', 'sort_order' => 90],
            ['id' => 'kadus-1', 'label' => 'Kadus', 'title' => 'Kepala Dusun I', 'group' => 'kadus', 'sort_order' => 100],
            ['id' => 'kadus-2', 'label' => 'Kadus', 'title' => 'Kepala Dusun II', 'group' => 'kadus', 'sort_order' => 110],
            ['id' => 'kadus-3', 'label' => 'Kadus', 'title' => 'Kepala Dusun III', 'group' => 'kadus', 'sort_order' => 120],
        ];
    }

    public static function defaultOrganizationMembers(): array
    {
        return [
            ['id' => 'member-head', 'position_option_id' => 'head', 'name' => 'Nama Kepala Desa', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 10],
            ['id' => 'member-partner', 'position_option_id' => 'partner', 'name' => 'Badan Permusyawaratan Desa', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 20],
            ['id' => 'member-secretary', 'position_option_id' => 'secretary', 'name' => 'Nama Sekretaris Desa', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 30],
            ['id' => 'member-kaur-umum', 'position_option_id' => 'kaur-umum', 'name' => 'Nama Kaur', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 40],
            ['id' => 'member-kaur-keuangan', 'position_option_id' => 'kaur-keuangan', 'name' => 'Nama Kaur', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 50],
            ['id' => 'member-kaur-perencanaan', 'position_option_id' => 'kaur-perencanaan', 'name' => 'Nama Kaur', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 60],
            ['id' => 'member-kasi-pemerintahan', 'position_option_id' => 'kasi-pemerintahan', 'name' => 'Nama Kasi', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 70],
            ['id' => 'member-kasi-kesejahteraan', 'position_option_id' => 'kasi-kesejahteraan', 'name' => 'Nama Kasi', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 80],
            ['id' => 'member-kasi-pelayanan', 'position_option_id' => 'kasi-pelayanan', 'name' => 'Nama Kasi', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 90],
            ['id' => 'member-kadus-1', 'position_option_id' => 'kadus-1', 'name' => 'Nama Kadus', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 100],
            ['id' => 'member-kadus-2', 'position_option_id' => 'kadus-2', 'name' => 'Nama Kadus', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 110],
            ['id' => 'member-kadus-3', 'position_option_id' => 'kadus-3', 'name' => 'Nama Kadus', 'photo_path' => 'img/avatar-placeholder.png', 'sort_order' => 120],
        ];
    }

}
