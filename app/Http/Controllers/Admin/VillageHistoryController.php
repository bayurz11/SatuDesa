<?php

namespace App\Http\Controllers\Admin;

use App\Domains\Village\Models\Village;
use App\Domains\Village\Models\VillageProfile;
use App\Http\Controllers\Controller;
use App\Services\LoggerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            ])->take(2)->values()->all(),
            'timelineItems' => collect($profile->history_timeline_items ?? [])->values()->pad(3, [
                'label' => '',
                'title' => '',
                'desc' => '',
                'icon' => 'home',
            ])->take(3)->values()->all(),
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
            'history_cover_image_path' => ['nullable', 'string', 'max:255'],
            'history_intro_text' => ['required', 'string'],
            'history_cards' => ['required', 'array', 'size:2'],
            'history_cards.*.badge' => ['required', 'string', 'max:255'],
            'history_cards.*.title' => ['required', 'string', 'max:255'],
            'history_cards.*.description' => ['required', 'string'],
            'history_cards.*.icon' => ['required', 'string', 'in:home,building,spark'],
            'history_timeline_badge' => ['required', 'string', 'max:255'],
            'history_timeline_title' => ['required', 'string', 'max:255'],
            'history_timeline_items' => ['required', 'array', 'size:3'],
            'history_timeline_items.*.label' => ['required', 'string', 'max:255'],
            'history_timeline_items.*.title' => ['required', 'string', 'max:255'],
            'history_timeline_items.*.desc' => ['required', 'string'],
            'history_timeline_items.*.icon' => ['required', 'string', 'in:home,building,spark'],
            'history_sidebar_title' => ['required', 'string', 'max:255'],
            'history_sidebar_description' => ['required', 'string'],
        ]);

        $profile->fill([
            'history_title' => $validated['history_title'],
            'history_description' => $validated['history_description'],
            'history_cover_badge' => $validated['history_cover_badge'],
            'history_cover_title' => $validated['history_cover_title'],
            'history_cover_image_path' => $validated['history_cover_image_path'] ?: 'img/bg.jpg',
            'history_intro_text' => $validated['history_intro_text'],
            'history_cards' => array_values($validated['history_cards']),
            'history_timeline_badge' => $validated['history_timeline_badge'],
            'history_timeline_title' => $validated['history_timeline_title'],
            'history_timeline_items' => array_values($validated['history_timeline_items']),
            'history_sidebar_title' => $validated['history_sidebar_title'],
            'history_sidebar_description' => $validated['history_sidebar_description'],
        ])->save();

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
