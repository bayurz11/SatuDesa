<?php

namespace App\Http\Controllers;

use App\Domains\Village\Models\Village;
use App\Domains\Village\Models\VillageProfile;
use Illuminate\View\View;

class PublicVillageMapController extends Controller
{
    public function index(): View
    {
        $village = Village::query()->orderBy('id')->firstOrFail();

        $profile = VillageProfile::query()->firstOrCreate(
            ['village_id' => $village->id],
            [
                'map_title' => 'Lokasi Desa ' . $village->name,
                'map_description' => 'Peta ini menampilkan lokasi desa beserta informasi pendukung seperti fasilitas umum, batas wilayah, dan potensi desa.',
                'map_latitude' => -0.1688817,
                'map_longitude' => 104.4712357,
                'map_zoom' => 14,
                'map_popup_title' => $village->name,
                'map_popup_description' => 'Kec. ' . $village->district . ', Kab. ' . $village->regency,
                'map_info_title' => 'Detail Peta',
                'map_boundary_title' => 'Batas Wilayah',
                'map_boundary_description' => 'Area administratif desa, dusun, RT/RW, dan titik batas wilayah.',
                'map_facility_title' => 'Fasilitas Umum',
                'map_facility_description' => 'Lokasi balai desa, sekolah, tempat ibadah, pelabuhan, dan layanan masyarakat.',
                'map_potential_title' => 'Potensi Desa',
                'map_potential_description' => 'Titik wisata, hasil laut, UMKM, pertanian, dan zona ekonomi warga.',
                'map_note' => 'Titik koordinat bisa disesuaikan kembali berdasarkan data resmi pemerintah desa.',
                'map_markers' => [
                    [
                        'name' => $village->name,
                        'category' => 'Pusat Desa',
                        'latitude' => -0.1688817,
                        'longitude' => 104.4712357,
                        'description' => 'Kec. ' . $village->district . ', Kab. ' . $village->regency,
                    ],
                ],
            ]
        );

        return view('pages.public.village-map', compact('village', 'profile'));
    }
}
