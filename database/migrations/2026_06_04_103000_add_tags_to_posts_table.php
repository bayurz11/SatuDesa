<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('posts')) {
            return;
        }

        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'tags')) {
                $table->json('tags')->nullable()->after('content');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('posts') || !Schema::hasColumn('posts', 'tags')) {
            return;
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('tags');
        });
    }
};
