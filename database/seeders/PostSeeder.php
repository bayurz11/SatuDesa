<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $villageId = DB::table('villages')->where('code', 'MENTUDA')->value('id');
        $categoryId = DB::table('post_categories')->where('slug', 'berita-desa')->value('id');
        $authorId = DB::table('users')->where('email', 'nurazani@bayurez.com')->value('id');

        if (!$villageId || !$categoryId || !$authorId) {
            return;
        }

        DB::table('posts')->updateOrInsert(
            ['slug' => 'pelayanan-administrasi-desa-semakin-cepat'],
            [
                'village_id' => $villageId,
                'category_id' => $categoryId,
                'author_id' => $authorId,
                'title' => 'Pelayanan Administrasi Desa Semakin Cepat',
                'excerpt' => 'Pemerintah desa mempercepat layanan administrasi agar warga mendapat proses yang lebih ringkas dan transparan.',
                'content' => "Pemerintah Desa Mentuda terus memperbaiki alur pelayanan administrasi warga.\n\nFokus utama pembaruan ini adalah mempercepat proses verifikasi, mempermudah pelacakan status, dan menjaga informasi publik tetap mutakhir di dashboard admin maupun halaman publik.",
                'status' => 'published',
                'published_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ]
        );
    }
}
