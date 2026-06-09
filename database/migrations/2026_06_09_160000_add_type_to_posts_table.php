<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('type')->default('news')->after('author_id');
            $table->index(['type', 'status', 'published_at'], 'posts_type_status_published_at_index');
        });

        DB::table('posts')
            ->leftJoin('post_categories', 'post_categories.id', '=', 'posts.category_id')
            ->update([
                'posts.type' => DB::raw("
                    CASE
                        WHEN post_categories.slug = 'pengumuman' THEN 'announcement'
                        ELSE 'news'
                    END
                "),
            ]);
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex('posts_type_status_published_at_index');
            $table->dropColumn('type');
        });
    }
};
