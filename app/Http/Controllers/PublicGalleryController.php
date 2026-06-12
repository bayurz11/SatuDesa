<?php

namespace App\Http\Controllers;

use App\Domains\Gallery\Models\Gallery;
use App\Domains\Village\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PublicGalleryController extends Controller
{
    public function index(Request $request): View
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

        $publishedGalleries = $publishedQuery->get()->values();

        $selectedCategorySlug = trim((string) $request->query('kategori', ''));
        $selectedCategory = null;

        $categoryMap = $publishedGalleries
            ->groupBy(fn (Gallery $gallery) => $gallery->category ?: 'Tanpa Kategori')
            ->mapWithKeys(fn ($items, $category) => [Str::slug($category) => $category]);

        if ($selectedCategorySlug !== '' && $categoryMap->has($selectedCategorySlug)) {
            $selectedCategory = $categoryMap->get($selectedCategorySlug);
        }

        $filteredGalleries = $selectedCategory
            ? $publishedGalleries->filter(fn (Gallery $gallery) => ($gallery->category ?: 'Tanpa Kategori') === $selectedCategory)->values()
            : $publishedGalleries;

        $featuredGallery = $filteredGalleries->firstWhere('is_featured', true) ?? $filteredGalleries->first();
        $galleryAlbums = $filteredGalleries
            ->when($featuredGallery, fn ($collection) => $collection->where('id', '!=', $featuredGallery->id))
            ->take(4)
            ->values();
        $recentAlbums = $filteredGalleries
            ->sortByDesc(fn (Gallery $gallery) => optional($gallery->gallery_date)->timestamp ?? 0)
            ->take(3)
            ->values();

        $galleryHighlights = [
            ['label' => 'Foto Pilihan', 'value' => $filteredGalleries->sum(fn (Gallery $gallery) => $gallery->resolved_photo_count)],
            ['label' => 'Album Aktif', 'value' => $filteredGalleries->count()],
            ['label' => 'Lokasi Dokumentasi', 'value' => $filteredGalleries->pluck('location_name')->filter()->unique()->count()],
        ];

        $albumCategories = collect([[
            'label' => 'Semua Album',
            'count' => $publishedGalleries->count(),
            'slug' => '',
            'is_active' => $selectedCategory === null,
            'url' => route('public.galleries.index'),
        ]])->concat(
            $publishedGalleries
                ->groupBy(fn (Gallery $gallery) => $gallery->category ?: 'Tanpa Kategori')
                ->map(fn ($items, $category) => [
                    'label' => $category,
                    'count' => $items->count(),
                    'slug' => Str::slug($category),
                    'is_active' => $selectedCategory === $category,
                    'url' => route('public.galleries.index', ['kategori' => Str::slug($category)]),
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
            'selectedCategory',
        ));
    }

    public function show(string $slug): View
    {
        $village = Village::query()->orderBy('id')->firstOrFail();
        $this->syncDefaults($village);

        $gallery = Gallery::query()
            ->where('village_id', $village->id)
            ->where('status', 'published')
            ->where('slug', $slug)
            ->with(['photos'])
            ->firstOrFail();

        $galleryPhotos = $gallery->photos->values();
        $relatedAlbums = Gallery::query()
            ->where('village_id', $village->id)
            ->where('status', 'published')
            ->where('id', '!=', $gallery->id)
            ->with('photos')
            ->orderByDesc('gallery_date')
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        return view('pages.public.galleries.show', compact(
            'village',
            'gallery',
            'galleryPhotos',
            'relatedAlbums',
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
