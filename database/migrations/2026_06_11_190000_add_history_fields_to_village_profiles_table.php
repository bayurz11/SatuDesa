<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->string('history_title')->nullable()->after('map_markers');
            $table->text('history_description')->nullable()->after('history_title');
            $table->string('history_cover_badge')->nullable()->after('history_description');
            $table->string('history_cover_title')->nullable()->after('history_cover_badge');
            $table->string('history_cover_image_path')->nullable()->after('history_cover_title');
            $table->text('history_intro_text')->nullable()->after('history_cover_image_path');
            $table->json('history_cards')->nullable()->after('history_intro_text');
            $table->string('history_timeline_badge')->nullable()->after('history_cards');
            $table->string('history_timeline_title')->nullable()->after('history_timeline_badge');
            $table->json('history_timeline_items')->nullable()->after('history_timeline_title');
            $table->string('history_sidebar_title')->nullable()->after('history_timeline_items');
            $table->text('history_sidebar_description')->nullable()->after('history_sidebar_title');
        });
    }

    public function down(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'history_title',
                'history_description',
                'history_cover_badge',
                'history_cover_title',
                'history_cover_image_path',
                'history_intro_text',
                'history_cards',
                'history_timeline_badge',
                'history_timeline_title',
                'history_timeline_items',
                'history_sidebar_title',
                'history_sidebar_description',
            ]);
        });
    }
};
