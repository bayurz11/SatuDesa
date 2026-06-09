<?php

namespace Database\Seeders;

use App\Domains\User\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            VillageSeeder::class,
            AdministrativeAreaSeeder::class,
            ApbdesReferenceSeeder::class,
            PostCategorySeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            SuperAdminAccessSeeder::class,
        ]);

        // Create a test user manually
        $testUser = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Assign user role
        $userRole = \App\Domains\Role\Models\Role::where('name', 'user')->first();
        if ($userRole && !$testUser->roles()->where('roles.id', $userRole->id)->exists()) {
            $testUser->roles()->attach($userRole->id);
        }

        $this->call([
            PostSeeder::class,
            CitizenSeeder::class,
        ]);
    }
}
