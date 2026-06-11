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
    ];

    protected $casts = [
        'map_latitude' => 'decimal:7',
        'map_longitude' => 'decimal:7',
        'map_zoom' => 'integer',
        'map_boundary_geojson' => 'array',
        'map_markers' => 'array',
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
            'map_latitude' => -0.1688817,
            'map_longitude' => 104.4712357,
            'map_zoom' => 14,
            'map_popup_title' => $village->name,
            'map_popup_description' => 'Kec. ' . $village->district . ', Kab. ' . $village->regency,
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
                    'name' => $village->name,
                    'category' => 'Pusat Desa',
                    'latitude' => -0.1688817,
                    'longitude' => 104.4712357,
                    'description' => 'Kec. ' . $village->district . ', Kab. ' . $village->regency,
                ],
            ],
        ];
    }

}
