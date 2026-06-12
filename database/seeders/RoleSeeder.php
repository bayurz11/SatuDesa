<?php

namespace Database\Seeders;

use App\Domains\Permission\Models\Permission;
use App\Domains\Role\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $allPermissions = Permission::query()->pluck('id', 'name');

        $roles = [
            'super-admin' => [
                'display_name' => 'Super Admin',
                'description' => 'Akses penuh ke seluruh modul, pengaturan sistem, role, dan permission.',
                'is_active' => true,
                'permissions' => $allPermissions->keys()->all(),
            ],
            'kepala-desa' => [
                'display_name' => 'Kepala Desa',
                'description' => 'Pimpinan desa dengan akses monitoring dan persetujuan publikasi.',
                'is_active' => true,
                'permissions' => [
                    'posts.view', 'posts.publish',
                    'announcements.view', 'announcements.publish',
                    'galleries.view', 'galleries.publish',
                    'agendas.view',
                    'post_categories.view',
                    'budgets.view', 'budgets.approve', 'budgets.report',
                    'citizens.view',
                    'village_maps.view',
                    'village_histories.view',
                    'village_organizations.view',
                    'citizen_births.view',
                    'citizen_arrivals.view',
                    'citizen_deaths.view',
                    'households.view',
                    'hamlets.view',
                    'rws.view',
                    'rts.view',
                    'letters.view',
                    'complaints.view',
                    'businesses.view',
                    'bumdes.view',
                    'users.view',
                    'roles.view',
                    'permissions.view',
                    'system.logs',
                ],
            ],
            'sekretaris-desa' => [
                'display_name' => 'Sekretaris Desa',
                'description' => 'Koordinator administrasi desa dengan akses kelola data dan publikasi operasional.',
                'is_active' => true,
                'permissions' => [
                    'posts.view', 'posts.create', 'posts.edit', 'posts.publish',
                    'announcements.view', 'announcements.create', 'announcements.edit', 'announcements.publish',
                    'galleries.view', 'galleries.create', 'galleries.edit', 'galleries.publish',
                    'agendas.view',
                    'post_categories.view', 'post_categories.create', 'post_categories.edit',
                    'budgets.view', 'budgets.create', 'budgets.edit', 'budgets.report',
                    'village_maps.view', 'village_maps.edit',
                    'village_histories.view', 'village_histories.edit',
                    'village_organizations.view', 'village_organizations.edit',
                    'citizens.view', 'citizens.create', 'citizens.edit',
                    'citizen_births.view', 'citizen_births.create', 'citizen_births.edit',
                    'citizen_arrivals.view', 'citizen_arrivals.create', 'citizen_arrivals.edit',
                    'citizen_deaths.view', 'citizen_deaths.create', 'citizen_deaths.edit',
                    'households.view', 'households.create', 'households.edit',
                    'hamlets.view', 'hamlets.create', 'hamlets.edit',
                    'rws.view', 'rws.create', 'rws.edit',
                    'rts.view', 'rts.create', 'rts.edit',
                    'letters.view',
                    'complaints.view',
                    'businesses.view',
                    'bumdes.view',
                    'users.view',
                    'roles.view',
                    'permissions.view',
                    'system.logs',
                ],
            ],
            'kaur-tata-usaha-umum' => [
                'display_name' => 'Kaur Tata Usaha dan Umum',
                'description' => 'Pengelola administrasi umum dan master data wilayah desa.',
                'is_active' => true,
                'permissions' => [
                    'posts.view',
                    'announcements.view',
                    'galleries.view',
                    'agendas.view',
                    'post_categories.view',
                    'budgets.view',
                    'village_maps.view', 'village_maps.edit',
                    'village_histories.view', 'village_histories.edit',
                    'village_organizations.view', 'village_organizations.edit',
                    'citizens.view', 'citizens.create', 'citizens.edit',
                    'households.view', 'households.create', 'households.edit',
                    'hamlets.view', 'hamlets.create', 'hamlets.edit',
                    'rws.view', 'rws.create', 'rws.edit',
                    'rts.view', 'rts.create', 'rts.edit',
                    'letters.view',
                    'complaints.view',
                ],
            ],
            'kaur-perencanaan' => [
                'display_name' => 'Kaur Perencanaan',
                'description' => 'Pengelola konten, dokumentasi, dan data pendukung perencanaan desa.',
                'is_active' => true,
                'permissions' => [
                    'posts.view', 'posts.create', 'posts.edit',
                    'announcements.view', 'announcements.create', 'announcements.edit',
                    'galleries.view', 'galleries.create', 'galleries.edit',
                    'agendas.view',
                    'post_categories.view',
                    'village_maps.view', 'village_maps.edit',
                    'village_histories.view', 'village_histories.edit',
                    'village_organizations.view', 'village_organizations.edit',
                    'budgets.view', 'budgets.create', 'budgets.edit', 'budgets.report',
                    'businesses.view',
                    'bumdes.view',
                    'citizens.view',
                    'households.view',
                    'hamlets.view',
                    'rws.view',
                    'rts.view',
                ],
            ],
            'kasi-pemerintahan' => [
                'display_name' => 'Kasi Pemerintahan',
                'description' => 'Pengelola administrasi kependudukan dan struktur wilayah desa.',
                'is_active' => true,
                'permissions' => [
                    'budgets.view',
                    'galleries.view',
                    'village_maps.view',
                    'village_histories.view',
                    'village_organizations.view',
                    'letters.view',
                    'complaints.view',
                    'citizens.view', 'citizens.create', 'citizens.edit', 'citizens.delete',
                    'citizen_births.view', 'citizen_births.create', 'citizen_births.edit', 'citizen_births.delete',
                    'citizen_arrivals.view', 'citizen_arrivals.create', 'citizen_arrivals.edit', 'citizen_arrivals.delete',
                    'citizen_deaths.view', 'citizen_deaths.create', 'citizen_deaths.edit', 'citizen_deaths.delete',
                    'households.view', 'households.create', 'households.edit', 'households.delete',
                    'hamlets.view', 'hamlets.create', 'hamlets.edit', 'hamlets.delete',
                    'rws.view', 'rws.create', 'rws.edit', 'rws.delete',
                    'rts.view', 'rts.create', 'rts.edit', 'rts.delete',
                ],
            ],
            'kasi-pelayanan' => [
                'display_name' => 'Kasi Pelayanan',
                'description' => 'Petugas pelayanan administrasi penduduk dan peristiwa kependudukan.',
                'is_active' => true,
                'permissions' => [
                    'budgets.view',
                    'galleries.view',
                    'village_maps.view',
                    'village_histories.view',
                    'village_organizations.view',
                    'letters.view',
                    'complaints.view',
                    'citizens.view', 'citizens.create', 'citizens.edit',
                    'citizen_births.view', 'citizen_births.create', 'citizen_births.edit',
                    'citizen_arrivals.view', 'citizen_arrivals.create', 'citizen_arrivals.edit',
                    'citizen_deaths.view', 'citizen_deaths.create', 'citizen_deaths.edit',
                    'households.view', 'households.create', 'households.edit',
                    'hamlets.view',
                    'rws.view',
                    'rts.view',
                ],
            ],
            'kepala-dusun' => [
                'display_name' => 'Kepala Dusun',
                'description' => 'Pemantau data penduduk dan wilayah pada tingkat dusun.',
                'is_active' => true,
                'permissions' => [
                    'budgets.view',
                    'galleries.view',
                    'village_maps.view',
                    'village_histories.view',
                    'village_organizations.view',
                    'businesses.view',
                    'citizens.view',
                    'citizen_births.view',
                    'citizen_arrivals.view',
                    'citizen_deaths.view',
                    'households.view',
                    'hamlets.view',
                    'rws.view',
                    'rts.view',
                ],
            ],
            'operator-desa' => [
                'display_name' => 'Operator Desa',
                'description' => 'Petugas input data harian untuk konten publik dan administrasi penduduk.',
                'is_active' => true,
                'permissions' => [
                    'posts.view', 'posts.create', 'posts.edit',
                    'announcements.view', 'announcements.create', 'announcements.edit',
                    'galleries.view', 'galleries.create', 'galleries.edit',
                    'agendas.view',
                    'post_categories.view',
                    'village_maps.view', 'village_maps.edit',
                    'village_histories.view', 'village_histories.edit',
                    'village_organizations.view', 'village_organizations.edit',
                    'budgets.view',
                    'letters.view',
                    'complaints.view',
                    'businesses.view',
                    'citizens.view', 'citizens.create', 'citizens.edit',
                    'citizen_births.view', 'citizen_births.create', 'citizen_births.edit',
                    'citizen_arrivals.view', 'citizen_arrivals.create', 'citizen_arrivals.edit',
                    'citizen_deaths.view', 'citizen_deaths.create', 'citizen_deaths.edit',
                    'households.view', 'households.create', 'households.edit',
                    'hamlets.view',
                    'rws.view',
                    'rts.view',
                ],
            ],
        ];

        foreach ($roles as $name => $definition) {
            $role = Role::query()->updateOrCreate(
                ['name' => $name],
                [
                    'display_name' => $definition['display_name'],
                    'description' => $definition['description'],
                    'is_active' => $definition['is_active'],
                ]
            );

            $permissionIds = collect($definition['permissions'])
                ->map(fn (string $permissionName) => $allPermissions->get($permissionName))
                ->filter()
                ->values()
                ->all();

            $role->permissions()->sync($permissionIds);
        }

        Role::query()
            ->whereIn('name', ['admin', 'manager', 'user'])
            ->update(['is_active' => false]);
    }
}
