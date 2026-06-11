<?php

namespace App\Http\Controllers\Admin;

use App\Domains\Village\Models\Village;
use App\Domains\Village\Models\VillageProfile;
use App\Http\Controllers\Controller;
use App\Services\LoggerService;
use App\Support\UploadStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class VillageHistoryController extends Controller
{
    public function index(): View
    {
        [$village, $profile] = $this->resolveVillageProfile();

        return view('pages.admin.village-histories.index', [
            'title' => 'Sejarah Desa',
            'description' => 'Pengelolaan konten sejarah desa untuk halaman publik.',
            'routeName' => 'village-histories.index',
            'village' => $village,
            'profile' => $profile,
            'historyCards' => collect($profile->history_cards ?? [])->values()->pad(2, [
                'badge' => '',
                'title' => '',
                'description' => '',
                'icon' => 'home',
                'image_path' => null,
            ])->take(2)->values()->all(),
            'timelineItems' => collect($profile->history_timeline_items ?? [])->values()->all(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        [$village, $profile] = $this->resolveVillageProfile();

        $validated = $request->validate([
            'history_title' => ['required', 'string', 'max:255'],
            'history_description' => ['required', 'string'],
            'history_cover_badge' => ['required', 'string', 'max:255'],
            'history_cover_title' => ['required', 'string', 'max:255'],
            'history_cover_image' => ['nullable', 'image', 'max:4096'],
            'history_intro_text' => ['required', 'string'],
            'history_cards' => ['required', 'array', 'size:2'],
            'history_cards.*.badge' => ['required', 'string', 'max:255'],
            'history_cards.*.title' => ['required', 'string', 'max:255'],
            'history_cards.*.description' => ['required', 'string'],
            'history_cards.*.icon' => ['required', 'string', 'in:home,building,spark'],
            'history_cards.*.image_path' => ['nullable', 'string', 'max:255'],
            'history_card_images' => ['nullable', 'array'],
            'history_card_images.*' => ['nullable', 'image', 'max:4096'],
            'history_timeline_badge' => ['required', 'string', 'max:255'],
            'history_timeline_title' => ['required', 'string', 'max:255'],
            'history_timeline_items' => ['required', 'array', 'min:1'],
            'history_timeline_items.*.label' => ['required', 'string', 'max:255'],
            'history_timeline_items.*.title' => ['required', 'string', 'max:255'],
            'history_timeline_items.*.desc' => ['required', 'string'],
            'history_timeline_items.*.icon' => ['required', 'string', 'in:home,building,spark'],
            'history_timeline_items.*.icon_image_path' => ['nullable', 'string', 'max:255'],
            'history_timeline_icons' => ['nullable', 'array'],
            'history_timeline_icons.*' => ['nullable', 'image', 'max:4096'],
            'history_sidebar_title' => ['required', 'string', 'max:255'],
            'history_sidebar_description' => ['required', 'string'],
        ]);

        $coverImagePath = $profile->history_cover_image_path ?: 'img/bg.jpg';

        if ($request->hasFile('history_cover_image')) {
            if ($coverImagePath && ! str_starts_with($coverImagePath, 'img/')) {
                Storage::disk(UploadStorage::disk())->delete($coverImagePath);
            }

            $coverImagePath = $request->file('history_cover_image')->store('village-histories/covers', UploadStorage::disk());
        }

        $existingCardImagePaths = collect($profile->history_cards ?? [])
            ->pluck('image_path')
            ->filter(fn ($path) => filled($path) && ! str_starts_with($path, 'img/'))
            ->values();

        $historyCards = collect($validated['history_cards'])
            ->values()
            ->map(function (array $item, int $index) use ($request) {
                $imagePath = $item['image_path'] ?? null;

                if ($request->hasFile("history_card_images.$index")) {
                    if ($imagePath && ! str_starts_with($imagePath, 'img/')) {
                        Storage::disk(UploadStorage::disk())->delete($imagePath);
                    }

                    $imagePath = $request->file("history_card_images.$index")
                        ->store('village-histories/cards', UploadStorage::disk());
                }

                return [
                    'badge' => $item['badge'],
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'icon' => $item['icon'],
                    'image_path' => $imagePath,
                ];
            })
            ->all();

        $existingIconPaths = collect($profile->history_timeline_items ?? [])
            ->pluck('icon_image_path')
            ->filter(fn ($path) => filled($path) && ! str_starts_with($path, 'img/'))
            ->values();

        $timelineItems = collect($validated['history_timeline_items'])
            ->values()
            ->map(function (array $item, int $index) use ($request) {
                $iconImagePath = $item['icon_image_path'] ?? null;

                if ($request->hasFile("history_timeline_icons.$index")) {
                    if ($iconImagePath && ! str_starts_with($iconImagePath, 'img/')) {
                        Storage::disk(UploadStorage::disk())->delete($iconImagePath);
                    }

                    $iconImagePath = $request->file("history_timeline_icons.$index")
                        ->store('village-histories/timeline-icons', UploadStorage::disk());
                }

                return [
                    'label' => $item['label'],
                    'title' => $item['title'],
                    'desc' => $item['desc'],
                    'icon' => $item['icon'],
                    'icon_image_path' => $iconImagePath,
                ];
            })
            ->all();

        $profile->fill([
            'history_title' => $validated['history_title'],
            'history_description' => $validated['history_description'],
            'history_cover_badge' => $validated['history_cover_badge'],
            'history_cover_title' => $validated['history_cover_title'],
            'history_cover_image_path' => $coverImagePath,
            'history_intro_text' => $validated['history_intro_text'],
            'history_cards' => $historyCards,
            'history_timeline_badge' => $validated['history_timeline_badge'],
            'history_timeline_title' => $validated['history_timeline_title'],
            'history_timeline_items' => $timelineItems,
            'history_sidebar_title' => $validated['history_sidebar_title'],
            'history_sidebar_description' => $validated['history_sidebar_description'],
        ])->save();

        $activeIconPaths = collect($timelineItems)
            ->pluck('icon_image_path')
            ->filter(fn ($path) => filled($path) && ! str_starts_with($path, 'img/'))
            ->values();

        $activeCardImagePaths = collect($historyCards)
            ->pluck('image_path')
            ->filter(fn ($path) => filled($path) && ! str_starts_with($path, 'img/'))
            ->values();

        $existingCardImagePaths
            ->diff($activeCardImagePaths)
            ->each(fn ($path) => Storage::disk(UploadStorage::disk())->delete($path));

        $existingIconPaths
            ->diff($activeIconPaths)
            ->each(fn ($path) => Storage::disk(UploadStorage::disk())->delete($path));

        LoggerService::logUserAction('update', 'VillageHistory', $profile->id, [
            'village_id' => $village->id,
        ]);

        return redirect()
            ->route('village-histories.index')
            ->with('message', 'Konten sejarah desa berhasil diperbarui.');
    }

    /**
     * @return array{0: Village, 1: VillageProfile}
     */
    protected function resolveVillageProfile(): array
    {
        $village = Village::query()->orderBy('id')->firstOrFail();
        $defaults = VillageProfile::defaultHistoryAttributesForVillage($village);

        $profile = VillageProfile::query()->firstOrCreate(
            ['village_id' => $village->id],
            $defaults
        );

        $missingDefaults = collect($defaults)
            ->filter(function ($value, string $key) use ($profile) {
                return blank($profile->{$key}) && filled($value);
            })
            ->all();

        if ($missingDefaults !== []) {
            $profile->fill($missingDefaults)->save();
        }

        return [$village, $profile];
    }
}
