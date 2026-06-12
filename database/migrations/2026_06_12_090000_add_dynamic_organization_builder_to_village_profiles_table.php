<?php

use App\Domains\Village\Models\Village;
use App\Domains\Village\Models\VillageProfile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->json('organization_identity')->nullable()->after('organization_sidebar_description');
            $table->json('organization_position_options')->nullable()->after('organization_identity');
            $table->json('organization_members')->nullable()->after('organization_position_options');
        });

        $village = Village::query()->orderBy('id')->first();

        if (! $village) {
            return;
        }

        DB::table('village_profiles')
            ->orderBy('id')
            ->get()
            ->each(function ($profileRow) use ($village) {
                $profile = VillageProfile::query()->find($profileRow->id);

                if (! $profile) {
                    return;
                }

                $identity = [
                    'page_title' => $profile->organization_page_title ?: 'Struktur Organisasi Desa ' . $village->name,
                    'page_description' => $profile->organization_page_description ?: 'Susunan pemerintahan desa.',
                    'section_badge' => $profile->organization_section_badge ?: 'Bagan Organisasi',
                    'section_title' => $profile->organization_section_title ?: 'Struktur Organisasi Desa ' . $village->name,
                    'section_description' => $profile->organization_section_description ?: 'Susunan pemerintahan desa.',
                    'note' => $profile->organization_note ?: 'Struktur organisasi dapat disesuaikan dengan data perangkat desa dan foto masing-masing pejabat.',
                    'sidebar_title' => $profile->organization_sidebar_title ?: 'Tata Kelola Desa',
                    'sidebar_description' => $profile->organization_sidebar_description ?: 'Struktur organisasi membantu masyarakat memahami pembagian tugas, alur koordinasi, dan perangkat desa yang menjalankan pelayanan publik.',
                ];

                $options = VillageProfile::defaultOrganizationPositionOptions();

                $legacyHead = $profile->organization_head ?? [];
                $legacyPartner = $profile->organization_partner ?? [];
                $legacySecretary = $profile->organization_secretary ?? [];
                $legacyKaur = collect($profile->organization_kaur_items ?? [])->values();
                $legacyKasi = collect($profile->organization_kasi_items ?? [])->values();
                $legacyDusun = collect($profile->organization_dusun_items ?? [])->values();

                $members = [
                    [
                        'id' => 'member-head',
                        'position_option_id' => 'head',
                        'name' => data_get($legacyHead, 'name', 'Nama Kepala Desa'),
                        'photo_path' => data_get($legacyHead, 'photo_path', 'img/avatar-placeholder.png'),
                        'sort_order' => 10,
                    ],
                    [
                        'id' => 'member-partner',
                        'position_option_id' => 'partner',
                        'name' => data_get($legacyPartner, 'name', 'Badan Permusyawaratan Desa'),
                        'photo_path' => data_get($legacyPartner, 'photo_path', 'img/avatar-placeholder.png'),
                        'sort_order' => 20,
                    ],
                    [
                        'id' => 'member-secretary',
                        'position_option_id' => 'secretary',
                        'name' => data_get($legacySecretary, 'name', 'Nama Sekretaris Desa'),
                        'photo_path' => data_get($legacySecretary, 'photo_path', 'img/avatar-placeholder.png'),
                        'sort_order' => 30,
                    ],
                ];

                foreach ($legacyKaur as $index => $item) {
                    $members[] = [
                        'id' => 'member-kaur-' . ($index + 1),
                        'position_option_id' => ['kaur-umum', 'kaur-keuangan', 'kaur-perencanaan'][$index] ?? 'kaur-umum',
                        'name' => $item['name'] ?? 'Nama Kaur',
                        'photo_path' => $item['photo_path'] ?? 'img/avatar-placeholder.png',
                        'sort_order' => 40 + ($index * 10),
                    ];
                }

                foreach ($legacyKasi as $index => $item) {
                    $members[] = [
                        'id' => 'member-kasi-' . ($index + 1),
                        'position_option_id' => ['kasi-pemerintahan', 'kasi-kesejahteraan', 'kasi-pelayanan'][$index] ?? 'kasi-pemerintahan',
                        'name' => $item['name'] ?? 'Nama Kasi',
                        'photo_path' => $item['photo_path'] ?? 'img/avatar-placeholder.png',
                        'sort_order' => 70 + ($index * 10),
                    ];
                }

                foreach ($legacyDusun as $index => $item) {
                    $members[] = [
                        'id' => 'member-kadus-' . ($index + 1),
                        'position_option_id' => ['kadus-1', 'kadus-2', 'kadus-3'][$index] ?? 'kadus-1',
                        'name' => $item['name'] ?? 'Nama Kadus',
                        'photo_path' => $item['photo_path'] ?? 'img/avatar-placeholder.png',
                        'sort_order' => 100 + ($index * 10),
                    ];
                }

                $profile->forceFill([
                    'organization_identity' => $identity,
                    'organization_position_options' => $options,
                    'organization_members' => $members,
                ])->save();
            });
    }

    public function down(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'organization_identity',
                'organization_position_options',
                'organization_members',
            ]);
        });
    }
};
