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
    ];

    protected $casts = [
        'map_latitude' => 'decimal:7',
        'map_longitude' => 'decimal:7',
        'map_zoom' => 'integer',
        'map_boundary_geojson' => 'array',
        'map_markers' => 'array',
        'history_cards' => 'array',
        'history_timeline_items' => 'array',
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
                ],
                [
                    'badge' => 'Perkembangan',
                    'title' => 'Pertumbuhan Sosial dan Ekonomi',
                    'description' => 'Seiring waktu, aktivitas masyarakat meluas pada sektor perikanan, perdagangan lokal, dan usaha rumah tangga yang memperkuat fondasi ekonomi desa.',
                    'icon' => 'building',
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
                ],
                [
                    'label' => 'Periode Penguatan',
                    'title' => 'Pengembangan Wilayah dan Kelembagaan',
                    'desc' => 'Infrastruktur dasar dan tata kelola desa berkembang untuk menjawab kebutuhan warga yang semakin beragam.',
                    'icon' => 'building',
                ],
                [
                    'label' => 'Periode Modern',
                    'title' => 'Transformasi Pelayanan dan Informasi Publik',
                    'desc' => 'Desa mulai beradaptasi dengan kebutuhan digital, transparansi informasi, dan peningkatan kualitas layanan publik.',
                    'icon' => 'spark',
                ],
            ],
            'history_sidebar_title' => 'Catatan Sejarah',
            'history_sidebar_description' => 'Bagian ini dapat digunakan untuk menampilkan narasi sejarah, foto arsip, linimasa desa, atau informasi penting sebelum dihubungkan ke data dinamis.',
        ];
    }

}
