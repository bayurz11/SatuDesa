<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Kategori potensi (untuk filter cepat)
            $table->string('potensi_category', 100)->nullable()->after('author_name');

            // Koordinat & alamat
            $table->decimal('latitude', 10, 6)->nullable()->after('potensi_category');   // -90..90
            $table->decimal('longitude', 10, 6)->nullable()->after('latitude');          // -180..180
            $table->string('address', 200)->nullable()->after('longitude');

            // Kontak
            $table->string('contact_name', 160)->nullable()->after('address');
            $table->string('contact_phone', 40)->nullable()->after('contact_name');

            // Rentang harga (opsional)
            $table->unsignedInteger('price_min')->nullable()->after('contact_phone');
            $table->unsignedInteger('price_max')->nullable()->after('price_min');

            // Link eksternal
            $table->string('external_link', 255)->nullable()->after('price_max');

            // Meta fleksibel (galeri, tag khusus, info tambahan)
            if (!Schema::hasColumn('posts', 'meta')) {
                $table->json('meta')->nullable()->after('body_html');
            }

            // index ringan untuk filter
            $table->index(['potensi_category']);
            $table->index(['latitude', 'longitude']);
        });

        // 2) Update ENUM content_type: tambah 'potensi'
        DB::statement("
            ALTER TABLE posts
            MODIFY content_type ENUM('announcement','news','potensi') NOT NULL DEFAULT 'announcement'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // rollback ENUM
        DB::statement("
            ALTER TABLE posts
            MODIFY content_type ENUM('announcement','news') NOT NULL DEFAULT 'announcement'
        ");

        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['potensi_category']);
            $table->dropIndex(['latitude', 'longitude']);

            $table->dropColumn([
                'potensi_category',
                'latitude',
                'longitude',
                'address',
                'contact_name',
                'contact_phone',
                'price_min',
                'price_max',
                'external_link'
            ]);

            if (Schema::hasColumn('posts', 'meta')) {
                $table->dropColumn('meta');
            }
        });
    }
};
