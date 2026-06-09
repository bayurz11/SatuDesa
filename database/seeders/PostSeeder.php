<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $villageId = DB::table('villages')->where('code', 'MENTUDA')->value('id');
        $newsCategoryId = DB::table('post_categories')->where('slug', 'berita-desa')->value('id');
        $announcementCategoryId = DB::table('post_categories')->where('slug', 'pengumuman')->value('id');
        $authorId = DB::table('users')->where('email', 'nurazani@bayurez.com')->value('id');

        if (!$villageId || !$newsCategoryId || !$authorId) {
            return;
        }

        DB::table('posts')->updateOrInsert(
            ['slug' => 'pelayanan-administrasi-desa-semakin-cepat'],
            [
                'village_id' => $villageId,
                'category_id' => $newsCategoryId,
                'author_id' => $authorId,
                'type' => 'news',
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

        if ($announcementCategoryId) {
            DB::table('posts')->updateOrInsert(
                ['slug' => 'pengumuman-jadwal-musyawarah-desa-mentuda'],
                [
                    'village_id' => $villageId,
                    'category_id' => $announcementCategoryId,
                    'author_id' => $authorId,
                    'type' => 'announcement',
                    'title' => 'Pengumuman Jadwal Musyawarah Desa Mentuda',
                    'excerpt' => 'Warga diundang menghadiri musyawarah desa untuk pembahasan program prioritas dan layanan publik tahun berjalan.',
                    'content' => "Pemerintah Desa Mentuda mengundang warga untuk menghadiri musyawarah desa pada jadwal yang telah ditetapkan.\n\nAgenda utama mencakup evaluasi pelayanan, prioritas kegiatan desa, dan ruang masukan dari masyarakat.",
                    'status' => 'published',
                    'published_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'deleted_at' => null,
                ]
            );
        }
    }
}
