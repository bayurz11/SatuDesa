<?php

namespace Database\Seeders;

use App\Domains\Permission\Models\Permission;
use App\Domains\Role\Models\Role;
use App\Domains\User\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminAccessSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'super-admin'],
            [
                'display_name' => 'Super Administrator',
                'description' => 'Has access to all system functions',
                'is_active' => true,
            ]
        );

        // Keep super-admin permission set aligned with the latest PermissionSeeder output.
        $superAdminRole->permissions()->sync(Permission::query()->pluck('id')->all());

        $superAdminUsers = [
            [
                'email' => 'nurazani@bayurez.com',
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($superAdminUsers as $attributes) {
            $user = User::firstOrCreate(
                ['email' => $attributes['email']],
                $attributes
            );

            $user->roles()->syncWithoutDetaching([$superAdminRole->id]);
        }
    }
}
