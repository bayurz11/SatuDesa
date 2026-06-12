<?php

namespace App\Http\Controllers\Admin;

use App\Domains\Village\Models\Village;
use App\Domains\Village\Models\VillageProfile;
use App\Http\Controllers\Controller;
use App\Services\LoggerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VillageVisionMissionController extends Controller
{
    public function index(): View
    {
        [$village, $profile] = $this->resolveVillageProfile();

        return view('pages.admin.village-vision-missions.index', [
            'title' => 'Visi & Misi Desa',
            'description' => 'Pengelolaan konten visi dan misi desa untuk halaman publik.',
            'routeName' => 'village-vision-missions.index',
            'village' => $village,
            'profile' => $profile,
            'missionItems' => collect($profile->vision_mission_mission_items ?? [])->values()->all(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        [$village, $profile] = $this->resolveVillageProfile();

        $validated = $request->validate([
            'vision_mission_title' => ['required', 'string', 'max:255'],
            'vision_mission_description' => ['required', 'string'],
            'vision_mission_hero_badge' => ['required', 'string', 'max:255'],
            'vision' => ['required', 'string'],
            'vision_mission_vision_badge' => ['required', 'string', 'max:255'],
            'vision_mission_vision_title' => ['required', 'string', 'max:255'],
            'vision_mission_vision_description' => ['required', 'string'],
            'vision_mission_mission_badge' => ['required', 'string', 'max:255'],
            'vision_mission_mission_title' => ['required', 'string', 'max:255'],
            'vision_mission_mission_items' => ['required', 'array', 'min:1'],
            'vision_mission_mission_items.*.title' => ['required', 'string', 'max:255'],
            'vision_mission_mission_items.*.desc' => ['required', 'string'],
            'vision_mission_mission_items.*.icon' => ['required', 'string', 'in:service,chart,users,document'],
            'vision_mission_sidebar_title' => ['required', 'string', 'max:255'],
            'vision_mission_sidebar_description' => ['required', 'string'],
        ]);

        $profile->fill([
            'vision_mission_title' => $validated['vision_mission_title'],
            'vision_mission_description' => $validated['vision_mission_description'],
            'vision_mission_hero_badge' => $validated['vision_mission_hero_badge'],
            'vision' => $validated['vision'],
            'vision_mission_vision_badge' => $validated['vision_mission_vision_badge'],
            'vision_mission_vision_title' => $validated['vision_mission_vision_title'],
            'vision_mission_vision_description' => $validated['vision_mission_vision_description'],
            'vision_mission_mission_badge' => $validated['vision_mission_mission_badge'],
            'vision_mission_mission_title' => $validated['vision_mission_mission_title'],
            'vision_mission_mission_items' => collect($validated['vision_mission_mission_items'])->values()->all(),
            'vision_mission_sidebar_title' => $validated['vision_mission_sidebar_title'],
            'vision_mission_sidebar_description' => $validated['vision_mission_sidebar_description'],
        ])->save();

        LoggerService::logUserAction('update', 'VillageVisionMission', $profile->id, [
            'village_id' => $village->id,
        ]);

        return redirect()
            ->route('village-vision-missions.index')
            ->with('message', 'Konten visi dan misi desa berhasil diperbarui.');
    }

    /**
     * @return array{0: Village, 1: VillageProfile}
     */
    protected function resolveVillageProfile(): array
    {
        $village = Village::query()->orderBy('id')->firstOrFail();
        $defaults = VillageProfile::defaultVisionMissionAttributesForVillage($village);

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
