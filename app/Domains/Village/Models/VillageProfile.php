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
            'map_description' => 'Peta ini menampilkan lokasi desa beserta informasi pendukung seperti fasilitas umum, batas wilayah, dan potensi desa.',
            'map_latitude' => -0.1688817,
            'map_longitude' => 104.4712357,
            'map_zoom' => 14,
            'map_popup_title' => $village->name,
            'map_popup_description' => 'Kec. ' . $village->district . ', Kab. ' . $village->regency,
            'map_info_title' => 'Detail Peta',
            'map_boundary_title' => 'Batas Wilayah',
            'map_boundary_description' => 'Area batas wilayah Desa Mentuda ditampilkan pada peta sebagai area hijau transparan.',
            'map_boundary_geojson' => static::defaultBoundaryGeojsonForVillage($village),
            'map_facility_title' => 'Fasilitas Umum',
            'map_facility_description' => 'Lokasi balai desa, sekolah, tempat ibadah, pelabuhan, dan layanan masyarakat.',
            'map_potential_title' => 'Potensi Desa',
            'map_potential_description' => 'Titik wisata, hasil laut, UMKM, pertanian, dan zona ekonomi warga.',
            'map_note' => 'Titik koordinat utama dapat dipilih langsung dari peta admin. Gunakan klik peta atau pencarian lokasi untuk menyesuaikannya.',
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

    public static function defaultBoundaryGeojsonForVillage(Village $village): ?array
    {
        $normalizedName = strtolower(trim($village->name));

        if (! in_array($normalizedName, ['desa mentuda', 'mentuda'], true)) {
            return null;
        }

        return [
            'type' => 'Feature',
            'properties' => [
                'name' => 'Batas Wilayah Desa Mentuda',
                'source' => 'OpenStreetMap bounding area',
            ],
            'geometry' => [
                'type' => 'Polygon',
                'coordinates' => [[
                    [104.4612758, -0.1849998],
                    [104.5012758, -0.1849998],
                    [104.5012758, -0.1449998],
                    [104.4612758, -0.1449998],
                    [104.4612758, -0.1849998],
                ]],
            ],
        ];
    }
}
