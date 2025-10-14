<?php

namespace Database\Seeders;

use App\Domains\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Profil Desa permissions
            ['name' => 'profil.view', 'display_name' => 'View Profil Desa', 'description' => 'Can view Profil Desa menu and its details', 'group' => 'profil',],
            [
                'name' => 'profil.create',
                'display_name' => 'Create Profil Desa',
                'description' => 'Can create new content under Profil Desa',
                'group' => 'profil',
            ],
            [
                'name' => 'profil.edit',
                'display_name' => 'Edit Profil Desa',
                'description' => 'Can edit content of Profil Desa',
                'group' => 'profil',
            ],
            [
                'name' => 'profil.delete',
                'display_name' => 'Delete Profil Desa',
                'description' => 'Can delete content under Profil Desa',
                'group' => 'profil',
            ],

            // Informasi permissions
            [
                'name' => 'informasi.view',
                'display_name' => 'View Informasi',
                'description' => 'Can view Informasi menu and its details',
                'group' => 'informasi',
            ],
            [
                'name' => 'informasi.create',
                'display_name' => 'Create Informasi',
                'description' => 'Can create new content under Informasi',
                'group' => 'informasi',
            ],
            [
                'name' => 'informasi.edit',
                'display_name' => 'Edit Informasi',
                'description' => 'Can edit content of Informasi',
                'group' => 'informasi',
            ],
            [
                'name' => 'informasi.delete',
                'display_name' => 'Delete Informasi',
                'description' => 'Can delete content under Informasi',
                'group' => 'informasi',
            ],

            // Administrasi Penduduk permissions
            [
                'name' => 'penduduk.view',
                'display_name' => 'View Administrasi Penduduk',
                'description' => 'Can view Administrasi Penduduk menu and its details',
                'group' => 'penduduk',
            ],
            [
                'name' => 'penduduk.create',
                'display_name' => 'Create Data Penduduk',
                'description' => 'Can create new resident data under Administrasi Penduduk',
                'group' => 'penduduk',
            ],
            [
                'name' => 'penduduk.edit',
                'display_name' => 'Edit Data Penduduk',
                'description' => 'Can edit resident data in Administrasi Penduduk',
                'group' => 'penduduk',
            ],
            [
                'name' => 'penduduk.delete',
                'display_name' => 'Delete Data Penduduk',
                'description' => 'Can delete resident data from Administrasi Penduduk',
                'group' => 'penduduk',
            ],
            [
                'name' => 'penduduk.export',
                'display_name' => 'Export Data Penduduk',
                'description' => 'Can export resident data to Excel/PDF',
                'group' => 'penduduk',
            ],
            [
                'name' => 'penduduk.import',
                'display_name' => 'Import Data Penduduk',
                'description' => 'Can import resident data from Excel/CSV',
                'group' => 'penduduk',
            ],


            // User permissions
            ['name' => 'users.view', 'display_name' => 'View Users', 'description' => 'Can view user list and details', 'group' => 'users'],
            ['name' => 'users.create', 'display_name' => 'Create Users', 'description' => 'Can create new users', 'group' => 'users'],
            ['name' => 'users.edit', 'display_name' => 'Edit Users', 'description' => 'Can edit existing users', 'group' => 'users'],
            ['name' => 'users.delete', 'display_name' => 'Delete Users', 'description' => 'Can delete users', 'group' => 'users'],

            // Role permissions
            ['name' => 'roles.view', 'display_name' => 'View Roles', 'description' => 'Can view role list and details', 'group' => 'roles'],
            ['name' => 'roles.create', 'display_name' => 'Create Roles', 'description' => 'Can create new roles', 'group' => 'roles'],
            ['name' => 'roles.edit', 'display_name' => 'Edit Roles', 'description' => 'Can edit existing roles', 'group' => 'roles'],
            ['name' => 'roles.delete', 'display_name' => 'Delete Roles', 'description' => 'Can delete roles', 'group' => 'roles'],

            // Permission permissions
            ['name' => 'permissions.view', 'display_name' => 'View Permissions', 'description' => 'Can view permission list', 'group' => 'permissions'],
            ['name' => 'permissions.manage', 'display_name' => 'Manage Permissions', 'description' => 'Can assign/remove permissions from roles', 'group' => 'permissions'],

            // System permissions
            ['name' => 'system.settings', 'display_name' => 'System Settings', 'description' => 'Can access system settings', 'group' => 'system'],
            ['name' => 'system.logs', 'display_name' => 'View Logs', 'description' => 'Can view system logs', 'group' => 'system'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}
