<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (! Schema::hasColumn('posts', 'cover_image_path')) {
                $table->string('cover_image_path')->nullable()->after('content');
            }

            if (! Schema::hasColumn('posts', 'cover_image_alt')) {
                $table->string('cover_image_alt')->nullable()->after('cover_image_path');
            }

            if (! Schema::hasColumn('posts', 'cover_image_caption')) {
                $table->string('cover_image_caption')->nullable()->after('cover_image_alt');
            }

            if (! Schema::hasColumn('posts', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('cover_image_caption');
            }

            if (! Schema::hasColumn('posts', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('is_featured');
            }

            if (! Schema::hasColumn('posts', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('posts')) {
            return;
        }

        Schema::table('posts', function (Blueprint $table) {
            $columns = [
                'cover_image_path',
                'cover_image_alt',
                'cover_image_caption',
                'is_featured',
                'meta_title',
                'meta_description',
            ];

            $existingColumns = array_filter($columns, fn ($column) => Schema::hasColumn('posts', $column));

            if ($existingColumns !== []) {
                $table->dropColumn($existingColumns);
            }
        });
    }
};
