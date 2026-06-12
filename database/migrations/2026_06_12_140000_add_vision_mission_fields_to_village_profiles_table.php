<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->string('vision_mission_title')->nullable()->after('history_sidebar_description');
            $table->text('vision_mission_description')->nullable()->after('vision_mission_title');
            $table->string('vision_mission_hero_badge')->nullable()->after('vision_mission_description');
            $table->string('vision_mission_vision_badge')->nullable()->after('vision_mission_hero_badge');
            $table->string('vision_mission_vision_title')->nullable()->after('vision_mission_vision_badge');
            $table->text('vision_mission_vision_description')->nullable()->after('vision_mission_vision_title');
            $table->string('vision_mission_mission_badge')->nullable()->after('vision_mission_vision_description');
            $table->string('vision_mission_mission_title')->nullable()->after('vision_mission_mission_badge');
            $table->json('vision_mission_mission_items')->nullable()->after('vision_mission_mission_title');
            $table->string('vision_mission_sidebar_title')->nullable()->after('vision_mission_mission_items');
            $table->text('vision_mission_sidebar_description')->nullable()->after('vision_mission_sidebar_title');
        });
    }

    public function down(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'vision_mission_title',
                'vision_mission_description',
                'vision_mission_hero_badge',
                'vision_mission_vision_badge',
                'vision_mission_vision_title',
                'vision_mission_vision_description',
                'vision_mission_mission_badge',
                'vision_mission_mission_title',
                'vision_mission_mission_items',
                'vision_mission_sidebar_title',
                'vision_mission_sidebar_description',
            ]);
        });
    }
};
