<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Berita Desa', 'description' => 'Berita resmi dan pembaruan kegiatan desa.'],
            ['name' => 'Pengumuman', 'description' => 'Pengumuman resmi untuk warga desa.'],
            ['name' => 'Agenda Kegiatan', 'description' => 'Agenda dan jadwal kegiatan desa.'],
        ];

        foreach ($categories as $category) {
            DB::table('post_categories')->updateOrInsert(
                ['slug' => Str::slug($category['name'])],
                [
                    'village_id' => null,
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
