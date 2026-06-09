<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VillageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('villages')->updateOrInsert(
            ['code' => 'MENTUDA'],
            [
                'name' => 'Desa Mentuda',
                'district' => 'Lingga',
                'regency' => 'Lingga',
                'province' => 'Kepulauan Riau',
                'postal_code' => '29871',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
