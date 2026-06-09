<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('potential_categories')) {
            Schema::table('potential_categories', function (Blueprint $table) {
                if (! Schema::hasColumn('potential_categories', 'icon')) {
                    $table->string('icon')->nullable()->after('description');
                }

                if (! Schema::hasColumn('potential_categories', 'sort_order')) {
                    $table->unsignedInteger('sort_order')->default(0)->after('icon');
                }

                if (! Schema::hasColumn('potential_categories', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('sort_order');
                }
            });

            DB::table('potential_categories')->upsert([
                [
                    'village_id' => null,
                    'name' => 'Wisata Alam',
                    'slug' => 'wisata-alam',
                    'description' => 'Potensi wisata berbasis alam dan panorama desa.',
                    'icon' => 'map',
                    'sort_order' => 1,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'village_id' => null,
                    'name' => 'UMKM',
                    'slug' => 'umkm',
                    'description' => 'Potensi produk dan usaha masyarakat desa.',
                    'icon' => 'store',
                    'sort_order' => 2,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'village_id' => null,
                    'name' => 'Perikanan',
                    'slug' => 'perikanan',
                    'description' => 'Potensi hasil laut dan kegiatan perikanan desa.',
                    'icon' => 'fish',
                    'sort_order' => 3,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'village_id' => null,
                    'name' => 'Budaya',
                    'slug' => 'budaya',
                    'description' => 'Potensi tradisi, seni, dan kearifan lokal desa.',
                    'icon' => 'sparkles',
                    'sort_order' => 4,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'village_id' => null,
                    'name' => 'Pertanian',
                    'slug' => 'pertanian',
                    'description' => 'Potensi lahan, hasil panen, dan komoditas pertanian desa.',
                    'icon' => 'leaf',
                    'sort_order' => 5,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ], ['slug'], ['name', 'description', 'icon', 'sort_order', 'is_active', 'updated_at']);
        }

        if (! Schema::hasTable('potentials')) {
            return;
        }

        Schema::table('potentials', function (Blueprint $table) {
            if (! Schema::hasColumn('potentials', 'cover_image_path')) {
                $table->string('cover_image_path')->nullable()->after('content');
            }

            if (! Schema::hasColumn('potentials', 'cover_image_alt')) {
                $table->string('cover_image_alt')->nullable()->after('cover_image_path');
            }

            if (! Schema::hasColumn('potentials', 'cover_image_caption')) {
                $table->string('cover_image_caption')->nullable()->after('cover_image_alt');
            }

            if (! Schema::hasColumn('potentials', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('cover_image_caption');
            }

            if (! Schema::hasColumn('potentials', 'potential_type')) {
                $table->string('potential_type')->nullable()->after('is_featured');
            }

            if (! Schema::hasColumn('potentials', 'location_name')) {
                $table->string('location_name')->nullable()->after('potential_type');
            }

            if (! Schema::hasColumn('potentials', 'address')) {
                $table->text('address')->nullable()->after('location_name');
            }

            if (! Schema::hasColumn('potentials', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable()->after('address');
            }

            if (! Schema::hasColumn('potentials', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            }

            if (! Schema::hasColumn('potentials', 'contact_person')) {
                $table->string('contact_person')->nullable()->after('longitude');
            }

            if (! Schema::hasColumn('potentials', 'contact_phone')) {
                $table->string('contact_phone')->nullable()->after('contact_person');
            }

            if (! Schema::hasColumn('potentials', 'facilities')) {
                $table->text('facilities')->nullable()->after('contact_phone');
            }

            if (! Schema::hasColumn('potentials', 'opportunities')) {
                $table->text('opportunities')->nullable()->after('facilities');
            }

            if (! Schema::hasColumn('potentials', 'development_status')) {
                $table->string('development_status')->nullable()->after('opportunities');
            }

            if (! Schema::hasColumn('potentials', 'sort_order')) {
                $table->unsignedInteger('sort_order')->default(0)->after('development_status');
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('potentials')) {
            Schema::table('potentials', function (Blueprint $table) {
                $columns = [
                    'cover_image_path',
                    'cover_image_alt',
                    'cover_image_caption',
                    'is_featured',
                    'potential_type',
                    'location_name',
                    'address',
                    'latitude',
                    'longitude',
                    'contact_person',
                    'contact_phone',
                    'facilities',
                    'opportunities',
                    'development_status',
                    'sort_order',
                ];

                $existingColumns = array_values(array_filter($columns, fn ($column) => Schema::hasColumn('potentials', $column)));

                if ($existingColumns !== []) {
                    $table->dropColumn($existingColumns);
                }
            });
        }

        if (Schema::hasTable('potential_categories')) {
            Schema::table('potential_categories', function (Blueprint $table) {
                $columns = ['icon', 'sort_order', 'is_active'];
                $existingColumns = array_values(array_filter($columns, fn ($column) => Schema::hasColumn('potential_categories', $column)));

                if ($existingColumns !== []) {
                    $table->dropColumn($existingColumns);
                }
            });
        }
    }
};
