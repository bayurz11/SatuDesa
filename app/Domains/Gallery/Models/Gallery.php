<?php

namespace App\Domains\Gallery\Models;

use App\Domains\Village\Models\Village;
use App\Support\UploadStorage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'village_id',
        'title',
        'slug',
        'category',
        'excerpt',
        'description',
        'cover_image_path',
        'location_name',
        'photo_count',
        'sort_order',
        'is_featured',
        'status',
        'gallery_date',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'gallery_date' => 'date',
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
            'photo_count' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        if (! $this->cover_image_path) {
            return null;
        }

        if (Str::startsWith($this->cover_image_path, 'img/')) {
            return asset($this->cover_image_path);
        }

        return UploadStorage::url($this->cover_image_path);
    }

    public static function defaultEntriesForVillage(Village $village): array
    {
        $today = Carbon::parse('2026-06-12');

        return [
            [
                'village_id' => $village->id,
                'title' => 'Festival Pesisir dan Kebersamaan Warga',
                'slug' => 'festival-pesisir-dan-kebersamaan-warga',
                'category' => 'Kegiatan Desa',
                'excerpt' => 'Album utama yang menampilkan kegiatan festival, persiapan warga, panggung seni, dan suasana kebersamaan.',
                'description' => 'Dokumentasi kegiatan festival pesisir, panggung seni, stand warga, dan momen kebersamaan masyarakat Desa Mentuda.',
                'cover_image_path' => 'img/bg.jpg',
                'location_name' => $village->name,
                'photo_count' => 24,
                'sort_order' => 10,
                'is_featured' => true,
                'status' => 'published',
                'gallery_date' => $today->copy()->subDays(19),
                'published_at' => $today->copy()->subDays(18),
            ],
            [
                'village_id' => $village->id,
                'title' => 'Gotong Royong Lingkungan',
                'slug' => 'gotong-royong-lingkungan',
                'category' => 'Kegiatan Desa',
                'excerpt' => 'Pembersihan jalan lingkungan, saluran air, dan area fasilitas umum oleh warga.',
                'description' => 'Dokumentasi gotong royong warga untuk membersihkan jalan lingkungan, saluran air, dan area publik desa.',
                'cover_image_path' => 'img/bg.jpg',
                'location_name' => 'Lingkungan Permukiman',
                'photo_count' => 18,
                'sort_order' => 20,
                'is_featured' => false,
                'status' => 'published',
                'gallery_date' => $today->copy()->subDays(12),
                'published_at' => $today->copy()->subDays(11),
            ],
            [
                'village_id' => $village->id,
                'title' => 'Peningkatan Jalan Desa',
                'slug' => 'peningkatan-jalan-desa',
                'category' => 'Pembangunan',
                'excerpt' => 'Potret progres pembangunan jalan desa dari tahap awal hingga penyelesaian lapangan.',
                'description' => 'Album pembangunan jalan desa yang menampilkan progres pekerjaan dari tahap awal hingga penyelesaian di lapangan.',
                'cover_image_path' => 'img/bg.jpg',
                'location_name' => 'Koridor Jalan Utama',
                'photo_count' => 12,
                'sort_order' => 30,
                'is_featured' => false,
                'status' => 'published',
                'gallery_date' => $today->copy()->subDays(10),
                'published_at' => $today->copy()->subDays(9),
            ],
            [
                'village_id' => $village->id,
                'title' => 'Suasana Pesisir Mentuda',
                'slug' => 'suasana-pesisir-mentuda',
                'category' => 'Wisata & Kawasan',
                'excerpt' => 'Panorama garis pantai, aktivitas nelayan, dan suasana sore di kawasan pesisir.',
                'description' => 'Album visual yang menampilkan garis pantai, aktivitas nelayan, dan panorama kawasan pesisir Desa Mentuda.',
                'cover_image_path' => 'img/bg.jpg',
                'location_name' => 'Pesisir Desa',
                'photo_count' => 15,
                'sort_order' => 40,
                'is_featured' => false,
                'status' => 'published',
                'gallery_date' => $today->copy()->subDays(7),
                'published_at' => $today->copy()->subDays(6),
            ],
            [
                'village_id' => $village->id,
                'title' => 'Posyandu dan Layanan Warga',
                'slug' => 'posyandu-dan-layanan-warga',
                'category' => 'Pelayanan Publik',
                'excerpt' => 'Pelayanan kesehatan dasar, antrean warga, dan pendampingan kader desa.',
                'description' => 'Dokumentasi pelayanan kesehatan dasar, pendampingan kader, dan aktivitas layanan publik desa.',
                'cover_image_path' => 'img/bg.jpg',
                'location_name' => 'Balai Desa',
                'photo_count' => 10,
                'sort_order' => 50,
                'is_featured' => false,
                'status' => 'published',
                'gallery_date' => $today->copy()->subDays(5),
                'published_at' => $today->copy()->subDays(4),
            ],
            [
                'village_id' => $village->id,
                'title' => 'Pelatihan UMKM Rumah Tangga',
                'slug' => 'pelatihan-umkm-rumah-tangga',
                'category' => 'Kegiatan Desa',
                'excerpt' => 'Pelatihan warga untuk pengembangan produk dan promosi UMKM rumah tangga.',
                'description' => 'Dokumentasi pelatihan UMKM rumah tangga dan pendampingan produk unggulan warga.',
                'cover_image_path' => 'img/bg.jpg',
                'location_name' => 'Ruang Pertemuan Warga',
                'photo_count' => 9,
                'sort_order' => 60,
                'is_featured' => false,
                'status' => 'draft',
                'gallery_date' => $today->copy()->subDays(3),
                'published_at' => null,
            ],
        ];
    }
}
