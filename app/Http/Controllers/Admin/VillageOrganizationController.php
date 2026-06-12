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
use Illuminate\Support\Str;
use Illuminate\View\View;

class VillageOrganizationController extends Controller
{
    public function index(): View
    {
        [$village, $profile] = $this->resolveVillageProfile();

        $identity = $this->organizationIdentity($profile, $village);
        $positionOptions = collect($this->organizationPositionOptions($profile))
            ->sortBy(['sort_order', 'title'])
            ->values()
            ->all();
        $members = collect($this->organizationMembers($profile))
            ->map(fn (array $member) => $this->decorateMember($member, $positionOptions))
            ->sortBy(['group_sort', 'sort_order', 'position_title'])
            ->values()
            ->all();

        return view('pages.admin.village-organizations.index', [
            'title' => 'Struktur Organisasi',
            'description' => 'Pengelolaan struktur organisasi desa untuk halaman publik.',
            'routeName' => 'village-organizations.index',
            'village' => $village,
            'profile' => $profile,
            'organizationIdentity' => $identity,
            'organizationPositionOptions' => $positionOptions,
            'organizationMembers' => $members,
            'organizationGroups' => $this->groupOptions(),
        ]);
    }

    public function positionSettings(): View
    {
        [$village, $profile] = $this->resolveVillageProfile();

        $positionOptions = collect($this->organizationPositionOptions($profile))
            ->sortBy(['sort_order', 'title'])
            ->values()
            ->all();

        return view('pages.admin.settings.organization-positions', [
            'title' => 'Master Jabatan Struktur Organisasi',
            'description' => 'Kelola daftar jabatan untuk dropdown struktur organisasi publik.',
            'routeName' => 'settings.organization-positions.index',
            'village' => $village,
            'profile' => $profile,
            'organizationPositionOptions' => $positionOptions,
            'organizationGroups' => $this->groupOptions(),
        ]);
    }

    public function updateIdentity(Request $request): RedirectResponse
    {
        [$village, $profile] = $this->resolveVillageProfile();

        $validated = $request->validate([
            'page_title' => ['required', 'string', 'max:255'],
            'page_description' => ['required', 'string'],
            'section_badge' => ['required', 'string', 'max:255'],
            'section_title' => ['required', 'string', 'max:255'],
            'section_description' => ['required', 'string'],
            'note' => ['required', 'string'],
            'sidebar_title' => ['required', 'string', 'max:255'],
            'sidebar_description' => ['required', 'string'],
        ]);

        $profile->forceFill([
            'organization_identity' => [
                'page_title' => strip_tags((string) $validated['page_title']),
                'page_description' => strip_tags((string) $validated['page_description']),
                'section_badge' => strip_tags((string) $validated['section_badge']),
                'section_title' => strip_tags((string) $validated['section_title']),
                'section_description' => strip_tags((string) $validated['section_description']),
                'note' => strip_tags((string) $validated['note']),
                'sidebar_title' => strip_tags((string) $validated['sidebar_title']),
                'sidebar_description' => strip_tags((string) $validated['sidebar_description']),
            ],
        ])->save();

        LoggerService::logUserAction('update', 'VillageOrganizationIdentity', $profile->id, [
            'village_id' => $village->id,
        ]);

        return redirect()->route('village-organizations.index')->with('message', 'Identitas halaman publik diperbarui.');
    }

    public function resetIdentity(): RedirectResponse
    {
        [$village, $profile] = $this->resolveVillageProfile();

        $profile->forceFill([
            'organization_identity' => VillageProfile::defaultOrganizationIdentityForVillage($village),
        ])->save();

        LoggerService::logUserAction('delete', 'VillageOrganizationIdentity', $profile->id, [
            'village_id' => $village->id,
            'action' => 'reset_to_default',
        ]);

        return redirect()->route('village-organizations.index')->with('message', 'Identitas halaman publik dikembalikan ke data awal.');
    }

    public function storePositionOption(Request $request): RedirectResponse
    {
        return $this->persistPositionOption($request);
    }

    public function updatePositionOption(Request $request, string $optionId): RedirectResponse
    {
        return $this->persistPositionOption($request, $optionId);
    }

    public function destroyPositionOption(string $optionId): RedirectResponse
    {
        [$village, $profile] = $this->resolveVillageProfile();

        $options = collect($this->organizationPositionOptions($profile));
        $option = $options->firstWhere('id', $optionId);

        if (! $option) {
            return redirect()->route('settings.organization-positions.index')->with('error', 'Data jabatan tidak ditemukan.');
        }

        $profile->forceFill([
            'organization_position_options' => $options
                ->reject(fn (array $item) => $item['id'] === $optionId)
                ->values()
                ->all(),
            'organization_members' => collect($this->organizationMembers($profile))
                ->reject(fn (array $member) => ($member['position_option_id'] ?? null) === $optionId)
                ->values()
                ->all(),
        ])->save();

        LoggerService::logUserAction('delete', 'VillageOrganizationPositionOption', $profile->id, [
            'village_id' => $village->id,
            'position_option_id' => $optionId,
        ]);

        return redirect()->route('settings.organization-positions.index')->with('message', 'Data jabatan dihapus.');
    }

    public function storeMember(Request $request): RedirectResponse
    {
        return $this->persistMember($request);
    }

    public function updateMember(Request $request, string $memberId): RedirectResponse
    {
        return $this->persistMember($request, $memberId);
    }

    public function destroyMember(string $memberId): RedirectResponse
    {
        [$village, $profile] = $this->resolveVillageProfile();

        $members = collect($this->organizationMembers($profile));
        $member = $members->firstWhere('id', $memberId);

        if (! $member) {
            return redirect()->route('village-organizations.index')->with('error', 'Data struktur tidak ditemukan.');
        }

        $photoPath = $member['photo_path'] ?? null;
        if ($photoPath && ! str_starts_with($photoPath, 'img/')) {
            Storage::disk(UploadStorage::disk())->delete($photoPath);
        }

        $profile->forceFill([
            'organization_members' => $members
                ->reject(fn (array $item) => $item['id'] === $memberId)
                ->values()
                ->all(),
        ])->save();

        LoggerService::logUserAction('delete', 'VillageOrganizationMember', $profile->id, [
            'village_id' => $village->id,
            'member_id' => $memberId,
        ]);

        return redirect()->route('village-organizations.index')->with('message', 'Data struktur dihapus.');
    }

    protected function persistPositionOption(Request $request, ?string $optionId = null): RedirectResponse
    {
        [$village, $profile] = $this->resolveVillageProfile();

        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'group' => ['required', 'string', 'in:' . implode(',', array_keys($this->groupOptions()))],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $options = collect($this->organizationPositionOptions($profile));
        $optionId = $optionId ?: Str::uuid()->toString();

        $payload = [
            'id' => $optionId,
            'label' => strip_tags((string) $validated['label']),
            'title' => strip_tags((string) $validated['title']),
            'group' => $validated['group'],
            'sort_order' => $validated['sort_order'] ?? ($options->max('sort_order') + 10),
        ];

        $updated = $options
            ->reject(fn (array $item) => $item['id'] === $optionId)
            ->push($payload)
            ->sortBy(['sort_order', 'title'])
            ->values()
            ->all();

        $profile->forceFill([
            'organization_position_options' => $updated,
        ])->save();

        LoggerService::logUserAction($request->routeIs('*.store') ? 'create' : 'update', 'VillageOrganizationPositionOption', $profile->id, [
            'village_id' => $village->id,
            'position_option_id' => $optionId,
        ]);

        return redirect()->route('settings.organization-positions.index')->with('message', 'Data jabatan berhasil disimpan.');
    }

    protected function persistMember(Request $request, ?string $memberId = null): RedirectResponse
    {
        [$village, $profile] = $this->resolveVillageProfile();

        $validated = $request->validate([
            'position_option_id' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:4096'],
        ]);

        $option = collect($this->organizationPositionOptions($profile))->firstWhere('id', $validated['position_option_id']);
        if (! $option) {
            return redirect()->route('village-organizations.index')->with('error', 'Jabatan yang dipilih tidak tersedia.');
        }

        $members = collect($this->organizationMembers($profile));
        $existing = $memberId ? $members->firstWhere('id', $memberId) : null;
        $photoPath = $existing['photo_path'] ?? 'img/avatar-placeholder.png';

        if ($request->hasFile('photo')) {
            if ($photoPath && ! str_starts_with($photoPath, 'img/')) {
                Storage::disk(UploadStorage::disk())->delete($photoPath);
            }

            $photoPath = $request->file('photo')->store('village-organizations/members', UploadStorage::disk());
        }

        $memberId = $memberId ?: Str::uuid()->toString();
        $payload = [
            'id' => $memberId,
            'position_option_id' => $validated['position_option_id'],
            'name' => strip_tags((string) $validated['name']),
            'photo_path' => $photoPath,
            'sort_order' => $validated['sort_order'] ?? (($option['sort_order'] ?? 0) + 1),
        ];

        $updated = $members
            ->reject(fn (array $item) => $item['id'] === $memberId)
            ->push($payload)
            ->values()
            ->all();

        $profile->forceFill([
            'organization_members' => $updated,
        ])->save();

        LoggerService::logUserAction($request->routeIs('*.store') ? 'create' : 'update', 'VillageOrganizationMember', $profile->id, [
            'village_id' => $village->id,
            'member_id' => $memberId,
            'position_option_id' => $validated['position_option_id'],
        ]);

        return redirect()->route('village-organizations.index')->with('message', 'Data struktur berhasil disimpan.');
    }

    protected function organizationIdentity(VillageProfile $profile, Village $village): array
    {
        return array_replace(
            VillageProfile::defaultOrganizationIdentityForVillage($village),
            $profile->organization_identity ?? []
        );
    }

    protected function organizationPositionOptions(VillageProfile $profile): array
    {
        return collect($profile->organization_position_options ?? VillageProfile::defaultOrganizationPositionOptions())
            ->filter(fn ($item) => is_array($item) && filled($item['id'] ?? null))
            ->values()
            ->all();
    }

    protected function organizationMembers(VillageProfile $profile): array
    {
        return collect($profile->organization_members ?? VillageProfile::defaultOrganizationMembers())
            ->filter(fn ($item) => is_array($item) && filled($item['id'] ?? null))
            ->values()
            ->all();
    }

    protected function decorateMember(array $member, array $positionOptions): array
    {
        $option = collect($positionOptions)->firstWhere('id', $member['position_option_id'] ?? null);
        $group = $option['group'] ?? 'other';

        return array_merge($member, [
            'position_label' => $option['label'] ?? '-',
            'position_title' => $option['title'] ?? '-',
            'group' => $group,
            'group_label' => $this->groupOptions()[$group] ?? 'Lainnya',
            'group_sort' => array_search($group, array_keys($this->groupOptions()), true) ?: 999,
        ]);
    }

    protected function groupOptions(): array
    {
        return [
            'pimpinan' => 'Pimpinan',
            'mitra' => 'Mitra Desa',
            'sekretariat' => 'Sekretariat',
            'kaur' => 'Kaur',
            'kasi' => 'Kasi',
            'kadus' => 'Kepala Dusun',
        ];
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

        if (blank($profile->organization_identity)) {
            $profile->forceFill([
                'organization_identity' => VillageProfile::defaultOrganizationIdentityForVillage($village),
            ])->save();
        }

        if (blank($profile->organization_position_options)) {
            $profile->forceFill([
                'organization_position_options' => VillageProfile::defaultOrganizationPositionOptions(),
            ])->save();
        }

        if (blank($profile->organization_members)) {
            $profile->forceFill([
                'organization_members' => VillageProfile::defaultOrganizationMembers(),
            ])->save();
        }

        return [$village, $profile];
    }
}
