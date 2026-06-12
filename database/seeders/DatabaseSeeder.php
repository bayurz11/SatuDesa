<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed only application core/reference data.
     * Dummy/sample content must be seeded explicitly through dedicated seeders.
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
    }
}
