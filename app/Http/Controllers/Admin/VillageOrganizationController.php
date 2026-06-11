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

class VillageOrganizationController extends Controller
{
    public function index(): View
    {
        [$village, $profile] = $this->resolveVillageProfile();

        return view('pages.admin.village-organizations.index', [
            'title' => 'Struktur Organisasi',
            'description' => 'Pengelolaan struktur organisasi desa untuk halaman publik.',
            'routeName' => 'village-organizations.index',
            'village' => $village,
            'profile' => $profile,
            'organizationHead' => $profile->organization_head ?? [],
            'organizationPartner' => $profile->organization_partner ?? [],
            'organizationSecretary' => $profile->organization_secretary ?? [],
            'organizationKaurItems' => collect($profile->organization_kaur_items ?? [])->values()->pad(3, [
                'label' => 'Kaur',
                'title' => '',
                'name' => '',
                'photo_path' => 'img/avatar-placeholder.png',
            ])->take(3)->all(),
            'organizationKasiItems' => collect($profile->organization_kasi_items ?? [])->values()->pad(3, [
                'label' => 'Kasi',
                'title' => '',
                'name' => '',
                'photo_path' => 'img/avatar-placeholder.png',
            ])->take(3)->all(),
            'organizationDusunItems' => collect($profile->organization_dusun_items ?? [])->values()->pad(3, [
                'label' => 'Kadus',
                'title' => '',
                'name' => '',
                'photo_path' => 'img/avatar-placeholder.png',
            ])->take(3)->all(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        [$village, $profile] = $this->resolveVillageProfile();

        $validated = $request->validate([
            'organization_page_title' => ['required', 'string', 'max:255'],
            'organization_page_description' => ['required', 'string'],
            'organization_section_badge' => ['required', 'string', 'max:255'],
            'organization_section_title' => ['required', 'string', 'max:255'],
            'organization_section_description' => ['required', 'string'],
            'organization_note' => ['required', 'string'],
            'organization_sidebar_title' => ['required', 'string', 'max:255'],
            'organization_sidebar_description' => ['required', 'string'],

            'organization_head' => ['required', 'array'],
            'organization_head.label' => ['required', 'string', 'max:255'],
            'organization_head.title' => ['required', 'string', 'max:255'],
            'organization_head.name' => ['required', 'string', 'max:255'],
            'organization_head.photo_path' => ['nullable', 'string', 'max:255'],
            'organization_head_photo' => ['nullable', 'image', 'max:4096'],

            'organization_partner' => ['required', 'array'],
            'organization_partner.label' => ['required', 'string', 'max:255'],
            'organization_partner.title' => ['required', 'string', 'max:255'],
            'organization_partner.name' => ['required', 'string', 'max:255'],
            'organization_partner.photo_path' => ['nullable', 'string', 'max:255'],
            'organization_partner_photo' => ['nullable', 'image', 'max:4096'],

            'organization_secretary' => ['required', 'array'],
            'organization_secretary.label' => ['required', 'string', 'max:255'],
            'organization_secretary.title' => ['required', 'string', 'max:255'],
            'organization_secretary.name' => ['required', 'string', 'max:255'],
            'organization_secretary.photo_path' => ['nullable', 'string', 'max:255'],
            'organization_secretary_photo' => ['nullable', 'image', 'max:4096'],

            'organization_kaur_items' => ['required', 'array', 'size:3'],
            'organization_kaur_items.*.label' => ['required', 'string', 'max:255'],
            'organization_kaur_items.*.title' => ['required', 'string', 'max:255'],
            'organization_kaur_items.*.name' => ['required', 'string', 'max:255'],
            'organization_kaur_items.*.photo_path' => ['nullable', 'string', 'max:255'],
            'organization_kaur_photos' => ['nullable', 'array'],
            'organization_kaur_photos.*' => ['nullable', 'image', 'max:4096'],

            'organization_kasi_items' => ['required', 'array', 'size:3'],
            'organization_kasi_items.*.label' => ['required', 'string', 'max:255'],
            'organization_kasi_items.*.title' => ['required', 'string', 'max:255'],
            'organization_kasi_items.*.name' => ['required', 'string', 'max:255'],
            'organization_kasi_items.*.photo_path' => ['nullable', 'string', 'max:255'],
            'organization_kasi_photos' => ['nullable', 'array'],
            'organization_kasi_photos.*' => ['nullable', 'image', 'max:4096'],

            'organization_dusun_items' => ['required', 'array', 'size:3'],
            'organization_dusun_items.*.label' => ['required', 'string', 'max:255'],
            'organization_dusun_items.*.title' => ['required', 'string', 'max:255'],
            'organization_dusun_items.*.name' => ['required', 'string', 'max:255'],
            'organization_dusun_items.*.photo_path' => ['nullable', 'string', 'max:255'],
            'organization_dusun_photos' => ['nullable', 'array'],
            'organization_dusun_photos.*' => ['nullable', 'image', 'max:4096'],
        ]);

        $existingPaths = collect([
            data_get($profile->organization_head, 'photo_path'),
            data_get($profile->organization_partner, 'photo_path'),
            data_get($profile->organization_secretary, 'photo_path'),
            ...collect($profile->organization_kaur_items ?? [])->pluck('photo_path')->all(),
            ...collect($profile->organization_kasi_items ?? [])->pluck('photo_path')->all(),
            ...collect($profile->organization_dusun_items ?? [])->pluck('photo_path')->all(),
        ])->filter(fn ($path) => filled($path) && ! str_starts_with($path, 'img/'))->values();

        $organizationHead = $this->prepareSinglePosition(
            $validated['organization_head'],
            $request->file('organization_head_photo'),
            'village-organizations/head'
        );

        $organizationPartner = $this->prepareSinglePosition(
            $validated['organization_partner'],
            $request->file('organization_partner_photo'),
            'village-organizations/partner'
        );

        $organizationSecretary = $this->prepareSinglePosition(
            $validated['organization_secretary'],
            $request->file('organization_secretary_photo'),
            'village-organizations/secretary'
        );

        $organizationKaurItems = $this->prepareRepeaterItems(
            $validated['organization_kaur_items'],
            $request->file('organization_kaur_photos', []),
            'village-organizations/kaur'
        );

        $organizationKasiItems = $this->prepareRepeaterItems(
            $validated['organization_kasi_items'],
            $request->file('organization_kasi_photos', []),
            'village-organizations/kasi'
        );

        $organizationDusunItems = $this->prepareRepeaterItems(
            $validated['organization_dusun_items'],
            $request->file('organization_dusun_photos', []),
            'village-organizations/dusun'
        );

        $profile->fill([
            'organization_page_title' => $validated['organization_page_title'],
            'organization_page_description' => $validated['organization_page_description'],
            'organization_section_badge' => $validated['organization_section_badge'],
            'organization_section_title' => $validated['organization_section_title'],
            'organization_section_description' => $validated['organization_section_description'],
            'organization_head' => $organizationHead,
            'organization_partner' => $organizationPartner,
            'organization_secretary' => $organizationSecretary,
            'organization_kaur_items' => $organizationKaurItems,
            'organization_kasi_items' => $organizationKasiItems,
            'organization_dusun_items' => $organizationDusunItems,
            'organization_note' => $validated['organization_note'],
            'organization_sidebar_title' => $validated['organization_sidebar_title'],
            'organization_sidebar_description' => $validated['organization_sidebar_description'],
        ])->save();

        $activePaths = collect([
            data_get($organizationHead, 'photo_path'),
            data_get($organizationPartner, 'photo_path'),
            data_get($organizationSecretary, 'photo_path'),
            ...collect($organizationKaurItems)->pluck('photo_path')->all(),
            ...collect($organizationKasiItems)->pluck('photo_path')->all(),
            ...collect($organizationDusunItems)->pluck('photo_path')->all(),
        ])->filter(fn ($path) => filled($path) && ! str_starts_with($path, 'img/'))->values();

        $existingPaths
            ->diff($activePaths)
            ->each(fn ($path) => Storage::disk(UploadStorage::disk())->delete($path));

        LoggerService::logUserAction('update', 'VillageOrganization', $profile->id, [
            'village_id' => $village->id,
        ]);

        return redirect()
            ->route('village-organizations.index')
            ->with('message', 'Struktur organisasi desa berhasil diperbarui.');
    }

    protected function prepareSinglePosition(array $item, $uploadedFile, string $directory): array
    {
        $photoPath = $item['photo_path'] ?? 'img/avatar-placeholder.png';

        if ($uploadedFile) {
            if ($photoPath && ! str_starts_with($photoPath, 'img/')) {
                Storage::disk(UploadStorage::disk())->delete($photoPath);
            }

            $photoPath = $uploadedFile->store($directory, UploadStorage::disk());
        }

        return [
            'label' => $item['label'],
            'title' => $item['title'],
            'name' => $item['name'],
            'photo_path' => $photoPath,
        ];
    }

    protected function prepareRepeaterItems(array $items, array $uploadedFiles, string $directory): array
    {
        return collect($items)
            ->values()
            ->map(function (array $item, int $index) use ($uploadedFiles, $directory) {
                $photoPath = $item['photo_path'] ?? 'img/avatar-placeholder.png';
                $uploadedFile = $uploadedFiles[$index] ?? null;

                if ($uploadedFile) {
                    if ($photoPath && ! str_starts_with($photoPath, 'img/')) {
                        Storage::disk(UploadStorage::disk())->delete($photoPath);
                    }

                    $photoPath = $uploadedFile->store($directory, UploadStorage::disk());
                }

                return [
                    'label' => $item['label'],
                    'title' => $item['title'],
                    'name' => $item['name'],
                    'photo_path' => $photoPath,
                ];
            })
            ->all();
    }

    /**
     * @return array{0: Village, 1: VillageProfile}
     */
    protected function resolveVillageProfile(): array
    {
        $village = Village::query()->orderBy('id')->firstOrFail();
        $defaults = VillageProfile::defaultOrganizationAttributesForVillage($village);

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
