<?php

namespace App\Http\Controllers;

use App\Domains\Gallery\Models\Gallery;
use App\Domains\Village\Models\Village;
use Illuminate\View\View;

class PublicGalleryController extends Controller
{
    public function index(): View
    {
        $village = Village::query()->orderBy('id')->firstOrFail();
        $this->syncDefaults($village);

        $publishedQuery = Gallery::query()
            ->where('village_id', $village->id)
            ->where('status', 'published')
            ->with('photos')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('gallery_date');

        $publishedGalleries = $publishedQuery->get();
        $featuredGallery = $publishedGalleries->firstWhere('is_featured', true) ?? $publishedGalleries->first();
        $galleryAlbums = $publishedGalleries
            ->when($featuredGallery, fn ($collection) => $collection->where('id', '!=', $featuredGallery->id))
            ->take(4)
            ->values();
        $recentAlbums = $publishedGalleries
            ->sortByDesc(fn (Gallery $gallery) => optional($gallery->gallery_date)->timestamp ?? 0)
            ->take(3)
            ->values();

        $galleryHighlights = [
            ['label' => 'Foto Pilihan', 'value' => $publishedGalleries->sum(fn (Gallery $gallery) => $gallery->resolved_photo_count)],
            ['label' => 'Album Aktif', 'value' => $publishedGalleries->count()],
            ['label' => 'Lokasi Dokumentasi', 'value' => $publishedGalleries->pluck('location_name')->filter()->unique()->count()],
        ];

        $albumCategories = collect([[
            'label' => 'Semua Album',
            'count' => $publishedGalleries->count(),
        ]])->concat(
            $publishedGalleries
                ->groupBy(fn (Gallery $gallery) => $gallery->category ?: 'Tanpa Kategori')
                ->map(fn ($items, $category) => [
                    'label' => $category,
                    'count' => $items->count(),
                ])
                ->values()
        )->values();

        return view('pages.public.galleries.index', compact(
            'village',
            'galleryHighlights',
            'albumCategories',
            'featuredGallery',
            'galleryAlbums',
            'recentAlbums',
        ));
    }

    protected function syncDefaults(Village $village): void
    {
        if (Gallery::query()->where('village_id', $village->id)->exists()) {
            return;
        }

        foreach (Gallery::defaultEntriesForVillage($village) as $payload) {
            Gallery::query()->create($payload);
        }
    }
}
