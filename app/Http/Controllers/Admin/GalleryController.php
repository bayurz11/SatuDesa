<?php

namespace App\Http\Controllers\Admin;

use App\Domains\Gallery\Models\Gallery;
use App\Domains\Gallery\Models\GalleryPhoto;
use App\Domains\Village\Models\Village;
use App\Http\Controllers\Controller;
use App\Services\LoggerService;
use App\Support\UploadStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $village = $this->resolveVillage();
        $this->syncDefaults($village);

        $galleries = Gallery::query()
            ->where('village_id', $village->id)
            ->with('photos')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('gallery_date')
            ->get();

        return view('pages.admin.galleries.index', [
            'title' => 'Galeri Desa',
            'description' => 'Kelola album galeri desa untuk halaman publik.',
            'routeName' => 'galleries.index',
            'village' => $village,
            'galleries' => $galleries,
            'categories' => $galleries->pluck('category')->filter()->unique()->values(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        return $this->persist($request);
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        return $this->persist($request, $gallery);
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        $gallery->load('photos');

        foreach ($gallery->photos as $photo) {
            $this->deleteStoredImage($photo->image_path);
        }

        $this->deleteCoverImage($gallery->cover_image_path);
        $galleryTitle = $gallery->title;
        $galleryId = $gallery->id;

        $gallery->delete();

        LoggerService::logUserAction('delete', 'Gallery', $galleryId, [
            'gallery_title' => $galleryTitle,
        ]);

        return redirect()->route('galleries.index')->with('message', 'Album galeri berhasil dihapus.');
    }

    public function publish(Gallery $gallery): RedirectResponse
    {
        $gallery->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        LoggerService::logUserAction('publish', 'Gallery', $gallery->id, [
            'gallery_title' => $gallery->title,
        ]);

        return redirect()->route('galleries.index')->with('message', 'Album galeri berhasil dipublikasikan.');
    }

    public function draft(Gallery $gallery): RedirectResponse
    {
        $gallery->update([
            'status' => 'draft',
            'published_at' => null,
        ]);

        LoggerService::logUserAction('move_to_draft', 'Gallery', $gallery->id, [
            'gallery_title' => $gallery->title,
        ]);

        return redirect()->route('galleries.index')->with('message', 'Album galeri dipindahkan ke draft.');
    }

    protected function persist(Request $request, ?Gallery $gallery = null): RedirectResponse
    {
        $village = $this->resolveVillage();
        $gallery ??= new Gallery(['village_id' => $village->id]);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:galleries,slug,' . $gallery->id],
            'category' => ['nullable', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
            'remove_photo_ids' => ['nullable', 'array'],
            'remove_photo_ids.*' => ['integer'],
            'cover_photo_id' => ['nullable', 'integer'],
            'location_name' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'is_featured' => ['nullable', 'boolean'],
            'status' => ['required', 'in:draft,published'],
            'gallery_date' => ['nullable', 'date'],
        ]);

        $coverImagePath = $gallery->cover_image_path;

        if ($request->hasFile('cover_image')) {
            $this->deleteCoverImage($coverImagePath);
            $coverImagePath = $request->file('cover_image')->store('galleries/covers', UploadStorage::disk());
        }

        $status = $validated['status'];
        $publishedAt = $status === 'published'
            ? ($gallery->published_at ?? now())
            : null;

        $gallery->fill([
            'village_id' => $village->id,
            'title' => strip_tags((string) $validated['title']),
            'slug' => Str::slug($validated['slug'] ?: $validated['title']),
            'category' => filled($validated['category'] ?? null) ? trim(strip_tags((string) $validated['category'])) : null,
            'excerpt' => filled($validated['excerpt'] ?? null) ? strip_tags((string) $validated['excerpt']) : null,
            'description' => filled($validated['description'] ?? null) ? strip_tags((string) $validated['description']) : null,
            'cover_image_path' => $coverImagePath,
            'location_name' => filled($validated['location_name'] ?? null) ? strip_tags((string) $validated['location_name']) : null,
            'sort_order' => (int) ($validated['sort_order'] ?? 0),
            'is_featured' => (bool) ($validated['is_featured'] ?? false),
            'status' => $status,
            'gallery_date' => $validated['gallery_date'] ?? null,
            'published_at' => $publishedAt,
        ])->save();

        $existingPhotos = $gallery->photos()->get()->keyBy('id');
        $removedPhotoIds = collect($validated['remove_photo_ids'] ?? [])
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->values();

        foreach ($removedPhotoIds as $photoId) {
            $photo = $existingPhotos->get($photoId);

            if (! $photo) {
                continue;
            }

            $this->deleteStoredImage($photo->image_path);
            $photo->delete();
        }

        $newPhotoModels = collect();

        foreach ($request->file('photos', []) as $index => $uploadedPhoto) {
            $path = $uploadedPhoto->store('galleries/photos', UploadStorage::disk());

            $newPhotoModels->push(
                $gallery->photos()->create([
                    'image_path' => $path,
                    'alt_text' => strip_tags($gallery->title) . ' foto ' . ($index + 1),
                    'caption' => null,
                    'sort_order' => $gallery->photos()->count() + $index,
                    'is_cover' => false,
                ])
            );
        }

        $gallery->photos()->update(['is_cover' => false]);

        $selectedCoverId = filled($validated['cover_photo_id'] ?? null)
            ? (int) $validated['cover_photo_id']
            : null;

        if ($selectedCoverId) {
            $gallery->photos()->whereKey($selectedCoverId)->update(['is_cover' => true]);
        } elseif ($request->hasFile('cover_image')) {
            // Manual cover upload tetap dipakai sebagai sampul utama album.
        } elseif ($newPhotoModels->isNotEmpty()) {
            $gallery->photos()->whereKey($newPhotoModels->first()->id)->update(['is_cover' => true]);
            $gallery->cover_image_path = $newPhotoModels->first()->image_path;
            $gallery->saveQuietly();
        } else {
            $gallery->photos()->orderBy('sort_order')->orderBy('id')->limit(1)->update(['is_cover' => true]);
        }

        if (! $request->hasFile('cover_image')) {
            $gallery->syncCoverFromPhotos();
        }

        $gallery->forceFill([
            'photo_count' => $gallery->photos()->count(),
        ])->saveQuietly();

        LoggerService::logUserAction($gallery->wasRecentlyCreated ? 'create' : 'update', 'Gallery', $gallery->id, [
            'gallery_title' => $gallery->title,
            'status' => $gallery->status,
            'category' => $gallery->category,
        ]);

        return redirect()->route('galleries.index')->with('message', $gallery->wasRecentlyCreated ? 'Album galeri berhasil ditambahkan.' : 'Album galeri berhasil diperbarui.');
    }

    protected function deleteCoverImage(?string $path): void
    {
        $this->deleteStoredImage($path);
    }

    protected function deleteStoredImage(?string $path): void
    {
        if (blank($path) || Str::startsWith($path, 'img/')) {
            return;
        }

        Storage::disk(UploadStorage::disk())->delete($path);
    }

    protected function resolveVillage(): Village
    {
        return Village::query()->orderBy('id')->firstOrFail();
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
