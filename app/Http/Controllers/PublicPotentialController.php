<?php

namespace App\Http\Controllers;

use App\Domains\Potential\Models\Potential;
use App\Domains\Potential\Models\PotentialCategory;
use App\Domains\Village\Models\Village;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PublicPotentialController extends Controller
{
    public function index(Request $request): View
    {
        $selectedCategory = trim((string) $request->string('category'));

        $baseQuery = Potential::query()
            ->with(['category:id,name,slug,icon', 'village:id,name'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->when($selectedCategory !== '', function ($query) use ($selectedCategory) {
                $query->whereHas('category', function ($categoryQuery) use ($selectedCategory) {
                    $categoryQuery->where('slug', $selectedCategory);
                });
            });

        $featuredPotential = (clone $baseQuery)
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->first();

        $potentials = (clone $baseQuery)
            ->when($featuredPotential, function ($query) use ($featuredPotential) {
                $query->where('id', '!=', $featuredPotential->id);
            })
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->get();

        $categories = PotentialCategory::query()
            ->where('is_active', true)
            ->whereHas('potentials', function ($query) {
                $query->where('status', 'published')->whereNotNull('published_at');
            })
            ->withCount([
                'potentials as published_potentials_count' => function ($query) {
                    $query->where('status', 'published')->whereNotNull('published_at');
                },
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'description', 'icon']);

        return view('pages.public.potentials', compact(
            'featuredPotential',
            'potentials',
            'categories',
            'selectedCategory'
        ));
    }

    public function show(Request $request, string $slug): View
    {
        $potential = Potential::query()
            ->with(['category:id,name,slug,icon', 'village:id,name,district,regency,province'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('slug', $slug)
            ->first();

        if (! $potential) {
            $potential = $this->samplePotentials()
                ->firstWhere('slug', $slug);
        }

        if (! $potential) {
            throw new NotFoundHttpException();
        }

        $relatedPotentials = $potential->exists
            ? Potential::query()
                ->with(['category:id,name,slug,icon', 'village:id,name'])
                ->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('id', '!=', $potential->id)
                ->when($potential->category_id, function ($query) use ($potential) {
                    $query->where('category_id', $potential->category_id);
                })
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->orderByDesc('published_at')
                ->limit(3)
                ->get()
            : $this->samplePotentials()
                ->reject(fn (Potential $item) => $item->slug === $potential->slug)
                ->take(3)
                ->values();

        return view('pages.public.potentials-show', compact('potential', 'relatedPotentials'));
    }

    /**
     * @return Collection<int, Potential>
     */
    private function samplePotentials(): Collection
    {
        $village = new Village([
            'name' => 'Desa Mentuda',
            'district' => 'Lingga',
            'regency' => 'Lingga',
            'province' => 'Kepulauan Riau',
        ]);

        $items = [
            [
                'title' => 'Kawasan Pesisir dan Panorama Laut Mentuda',
                'slug' => 'kawasan-pesisir-dan-panorama-laut-mentuda',
                'excerpt' => 'Kawasan pesisir Desa Mentuda memiliki garis pandang laut terbuka, aktivitas nelayan, dan suasana desa yang potensial dikembangkan sebagai tujuan wisata lokal.',
                'content' => '<p>Potensi ini berfokus pada kawasan pesisir yang menjadi wajah utama Desa Mentuda. Area ini memiliki kombinasi panorama laut, aktivitas nelayan, serta karakter kampung pesisir yang kuat untuk dikembangkan sebagai daya tarik kunjungan.</p><p>Pada tahap desain, blok ini dapat menampung narasi tentang akses menuju lokasi, pengalaman yang bisa dirasakan pengunjung, serta potensi pengembangan wisata berbasis komunitas.</p>',
                'potential_type' => 'Wisata Alam',
                'location_name' => 'Pesisir Utama Desa Mentuda',
                'address' => 'Kawasan tepi laut Desa Mentuda, Kecamatan Lingga, Kabupaten Lingga.',
                'latitude' => '0.1234567',
                'longitude' => '104.1234567',
                'contact_person' => 'Pengelola Kawasan Desa',
                'contact_phone' => '0812-0000-1111',
                'facilities' => '<ul><li>Akses jalan menuju pesisir</li><li>Area pandang panorama laut</li><li>Titik kumpul kegiatan warga</li></ul>',
                'opportunities' => '<ul><li>Pengembangan wisata foto dan jelajah pesisir</li><li>Paket kunjungan budaya kampung nelayan</li><li>Promosi UMKM lokal di area kunjungan</li></ul>',
                'development_status' => 'Potensi prioritas pengembangan',
                'published_at' => Carbon::parse('2026-06-08 09:00:00'),
                'category' => ['name' => 'Wisata Alam', 'slug' => 'wisata-alam', 'icon' => 'map'],
            ],
            [
                'title' => 'Produk Olahan Laut dan UMKM Rumahan',
                'slug' => 'produk-olahan-laut-dan-umkm-rumahan',
                'excerpt' => 'Usaha rumahan warga menghasilkan olahan laut dan makanan lokal yang berpotensi menjadi produk unggulan desa.',
                'content' => '<p>Potensi UMKM Desa Mentuda dapat ditampilkan sebagai katalog pelaku usaha, produk unggulan, dan cerita produksi rumahan yang dekat dengan keseharian warga.</p><p>Halaman detail ini cocok untuk desain awal etalase UMKM, daftar produk, dan kontak pemesanan yang mudah diakses publik.</p>',
                'potential_type' => 'UMKM',
                'location_name' => 'Sentra Produksi Warga',
                'address' => 'Area permukiman dan rumah produksi warga Desa Mentuda.',
                'latitude' => null,
                'longitude' => null,
                'contact_person' => 'Koordinator UMKM Desa',
                'contact_phone' => '0812-0000-2222',
                'facilities' => '<ul><li>Ruang produksi rumahan</li><li>Kelompok usaha warga</li><li>Jaringan distribusi lokal</li></ul>',
                'opportunities' => '<ul><li>Branding produk unggulan</li><li>Katalog digital UMKM</li><li>Penguatan promosi desa</li></ul>',
                'development_status' => 'Siap dipromosikan',
                'published_at' => Carbon::parse('2026-06-07 10:00:00'),
                'category' => ['name' => 'UMKM', 'slug' => 'umkm', 'icon' => 'store'],
            ],
            [
                'title' => 'Sentra Perikanan Rakyat Desa Mentuda',
                'slug' => 'sentra-perikanan-rakyat-desa-mentuda',
                'excerpt' => 'Aktivitas tangkap dan hasil laut masyarakat menjadi salah satu kekuatan ekonomi utama desa.',
                'content' => '<p>Sektor perikanan rakyat merupakan fondasi penting ekonomi desa. Halaman detail bisa menampung cerita rantai nilai hasil laut, musim tangkap, dan peluang hilirisasi hasil tangkapan.</p>',
                'potential_type' => 'Perikanan',
                'location_name' => 'Dermaga dan Area Nelayan',
                'address' => 'Kawasan sandar perahu dan aktivitas hasil laut Desa Mentuda.',
                'latitude' => '0.1254321',
                'longitude' => '104.1276543',
                'contact_person' => 'Kelompok Nelayan Desa',
                'contact_phone' => '0812-0000-3333',
                'facilities' => '<ul><li>Area tambat perahu</li><li>Distribusi hasil tangkap</li><li>Ruang bongkar muat sederhana</li></ul>',
                'opportunities' => '<ul><li>Olahan hasil laut</li><li>Wisata edukasi nelayan</li><li>Pusat promosi produk perikanan</li></ul>',
                'development_status' => 'Sektor unggulan desa',
                'published_at' => Carbon::parse('2026-06-06 08:30:00'),
                'category' => ['name' => 'Perikanan', 'slug' => 'perikanan', 'icon' => 'fish'],
            ],
        ];

        return collect($items)->map(function (array $item) use ($village) {
            $potential = new Potential([
                'village_id' => 1,
                'category_id' => null,
                'title' => $item['title'],
                'slug' => $item['slug'],
                'excerpt' => $item['excerpt'],
                'content' => $item['content'],
                'cover_image_path' => null,
                'cover_image_alt' => $item['title'],
                'cover_image_caption' => 'Visual masih menggunakan placeholder untuk tahap desain.',
                'is_featured' => true,
                'potential_type' => $item['potential_type'],
                'location_name' => $item['location_name'],
                'address' => $item['address'],
                'latitude' => $item['latitude'],
                'longitude' => $item['longitude'],
                'contact_person' => $item['contact_person'],
                'contact_phone' => $item['contact_phone'],
                'facilities' => $item['facilities'],
                'opportunities' => $item['opportunities'],
                'development_status' => $item['development_status'],
                'sort_order' => 0,
                'status' => 'published',
                'published_at' => $item['published_at'],
            ]);

            $potential->setRelation('village', $village);
            $potential->setRelation('category', new PotentialCategory($item['category']));

            return $potential;
        })->values();
    }
}
