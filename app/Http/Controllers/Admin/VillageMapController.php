<?php

namespace App\Http\Controllers\Admin;

use App\Domains\Village\Models\Village;
use App\Domains\Village\Models\VillageProfile;
use App\Http\Controllers\Controller;
use App\Services\LoggerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VillageMapController extends Controller
{
    public function index(): View
    {
        [$village, $profile] = $this->resolveVillageProfile();

        return view('pages.admin.village-maps.index', [
            'title' => 'Peta Desa',
            'description' => 'Pengelolaan halaman peta desa agar selaras dengan tampilan publik.',
            'routeName' => 'village-maps.index',
            'village' => $village,
            'profile' => $profile,
            'markerRows' => collect($profile->map_markers ?? [])->values()->all(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        [$village, $profile] = $this->resolveVillageProfile();

        $validated = $request->validate([
            'map_title' => ['required', 'string', 'max:255'],
            'map_description' => ['required', 'string'],
            'map_latitude' => ['required', 'numeric', 'between:-90,90'],
            'map_longitude' => ['required', 'numeric', 'between:-180,180'],
            'map_zoom' => ['required', 'integer', 'between:1,18'],
            'map_popup_title' => ['required', 'string', 'max:255'],
            'map_popup_description' => ['required', 'string'],
            'map_info_title' => ['required', 'string', 'max:255'],
            'map_facility_title' => ['required', 'string', 'max:255'],
            'map_facility_description' => ['required', 'string'],
            'map_potential_title' => ['required', 'string', 'max:255'],
            'map_potential_description' => ['required', 'string'],
            'map_note' => ['nullable', 'string'],
            'markers' => ['nullable', 'array', 'max:25'],
            'markers.*.name' => ['nullable', 'string', 'max:255'],
            'markers.*.category' => ['nullable', 'string', 'max:255'],
            'markers.*.latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'markers.*.longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'markers.*.description' => ['nullable', 'string'],
        ]);

        $markers = collect($validated['markers'] ?? [])
            ->map(function (array $marker) {
                $name = trim((string) ($marker['name'] ?? ''));
                $latitude = $marker['latitude'] ?? null;
                $longitude = $marker['longitude'] ?? null;

                if ($name === '' || $latitude === null || $longitude === null) {
                    return null;
                }

                return [
                    'name' => $name,
                    'category' => trim((string) ($marker['category'] ?? 'Lokasi')),
                    'latitude' => (float) $latitude,
                    'longitude' => (float) $longitude,
                    'description' => trim((string) ($marker['description'] ?? '')),
                ];
            })
            ->filter()
            ->values()
            ->all();

        $profile->fill([
            'map_title' => $validated['map_title'],
            'map_description' => $validated['map_description'],
            'map_latitude' => $validated['map_latitude'],
            'map_longitude' => $validated['map_longitude'],
            'map_zoom' => $validated['map_zoom'],
            'map_popup_title' => $validated['map_popup_title'],
            'map_popup_description' => $validated['map_popup_description'],
            'map_info_title' => $validated['map_info_title'],
            'map_facility_title' => $validated['map_facility_title'],
            'map_facility_description' => $validated['map_facility_description'],
            'map_potential_title' => $validated['map_potential_title'],
            'map_potential_description' => $validated['map_potential_description'],
            'map_note' => $validated['map_note'] ?? null,
            'map_markers' => $markers,
        ])->save();

        LoggerService::logUserAction('update', 'VillageMap', $profile->id, [
            'village_id' => $village->id,
            'marker_count' => count($markers),
        ]);

        return redirect()
            ->route('village-maps.index')
            ->with('message', 'Data peta desa berhasil diperbarui.');
    }

    public function updateEditor(Request $request): RedirectResponse
    {
        [$village, $profile] = $this->resolveVillageProfile();

        $validated = $request->validate([
            'map_latitude' => ['required', 'numeric', 'between:-90,90'],
            'map_longitude' => ['required', 'numeric', 'between:-180,180'],
            'map_zoom' => ['required', 'integer', 'between:1,18'],
        ]);

        $profile->fill([
            'map_latitude' => $validated['map_latitude'],
            'map_longitude' => $validated['map_longitude'],
            'map_zoom' => $validated['map_zoom'],
        ])->save();

        LoggerService::logUserAction('update', 'VillageMapEditor', $profile->id, [
            'village_id' => $village->id,
        ]);

        return redirect()->route('village-maps.index')->with('message', 'Editor peta admin berhasil diperbarui.');
    }

    public function updateContent(Request $request): RedirectResponse
    {
        [$village, $profile] = $this->resolveVillageProfile();

        $validated = $request->validate([
            'map_title' => ['required', 'string', 'max:255'],
            'map_description' => ['required', 'string'],
            'map_popup_title' => ['required', 'string', 'max:255'],
            'map_popup_description' => ['required', 'string'],
        ]);

        $profile->fill($validated)->save();

        LoggerService::logUserAction('update', 'VillageMapContent', $profile->id, [
            'village_id' => $village->id,
        ]);

        return redirect()->route('village-maps.index')->with('message', 'Konten publik utama peta berhasil diperbarui.');
    }

    public function updatePanels(Request $request): RedirectResponse
    {
        [$village, $profile] = $this->resolveVillageProfile();

        $validated = $request->validate([
            'map_info_title' => ['required', 'string', 'max:255'],
            'map_facility_title' => ['required', 'string', 'max:255'],
            'map_facility_description' => ['required', 'string'],
            'map_potential_title' => ['required', 'string', 'max:255'],
            'map_potential_description' => ['required', 'string'],
            'map_note' => ['nullable', 'string'],
        ]);

        $profile->fill($validated)->save();

        LoggerService::logUserAction('update', 'VillageMapPanels', $profile->id, [
            'village_id' => $village->id,
        ]);

        return redirect()->route('village-maps.index')->with('message', 'Panel informasi publik berhasil diperbarui.');
    }

    public function updateMarkers(Request $request): RedirectResponse
    {
        [$village, $profile] = $this->resolveVillageProfile();

        $validated = $request->validate([
            'markers' => ['nullable', 'array', 'max:25'],
            'markers.*.name' => ['nullable', 'string', 'max:255'],
            'markers.*.category' => ['nullable', 'string', 'max:255'],
            'markers.*.latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'markers.*.longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'markers.*.description' => ['nullable', 'string'],
        ]);

        $markers = collect($validated['markers'] ?? [])
            ->map(function (array $marker) {
                $name = trim((string) ($marker['name'] ?? ''));
                $latitude = $marker['latitude'] ?? null;
                $longitude = $marker['longitude'] ?? null;

                if ($name === '' || $latitude === null || $longitude === null) {
                    return null;
                }

                return [
                    'name' => $name,
                    'category' => trim((string) ($marker['category'] ?? 'Lokasi')),
                    'latitude' => (float) $latitude,
                    'longitude' => (float) $longitude,
                    'description' => trim((string) ($marker['description'] ?? '')),
                ];
            })
            ->filter()
            ->values()
            ->all();

        $profile->fill([
            'map_markers' => $markers,
        ])->save();

        LoggerService::logUserAction('update', 'VillageMapMarkers', $profile->id, [
            'village_id' => $village->id,
            'marker_count' => count($markers),
        ]);

        return redirect()->route('village-maps.index')->with('message', 'Marker peta berhasil diperbarui.');
    }

    /**
     * @return array{0: Village, 1: VillageProfile}
     */
    protected function resolveVillageProfile(): array
    {
        $village = Village::query()->orderBy('id')->firstOrFail();
        $defaults = VillageProfile::defaultMapAttributesForVillage($village);

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
