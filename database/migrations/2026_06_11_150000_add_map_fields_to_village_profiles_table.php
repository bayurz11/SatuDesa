<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->string('map_title')->nullable()->after('logo_path');
            $table->text('map_description')->nullable()->after('map_title');
            $table->decimal('map_latitude', 10, 7)->nullable()->after('map_description');
            $table->decimal('map_longitude', 10, 7)->nullable()->after('map_latitude');
            $table->unsignedTinyInteger('map_zoom')->nullable()->after('map_longitude');
            $table->string('map_popup_title')->nullable()->after('map_zoom');
            $table->text('map_popup_description')->nullable()->after('map_popup_title');
            $table->string('map_info_title')->nullable()->after('map_popup_description');
            $table->string('map_boundary_title')->nullable()->after('map_info_title');
            $table->text('map_boundary_description')->nullable()->after('map_boundary_title');
            $table->string('map_facility_title')->nullable()->after('map_boundary_description');
            $table->text('map_facility_description')->nullable()->after('map_facility_title');
            $table->string('map_potential_title')->nullable()->after('map_facility_description');
            $table->text('map_potential_description')->nullable()->after('map_potential_title');
            $table->text('map_note')->nullable()->after('map_potential_description');
            $table->json('map_markers')->nullable()->after('map_note');
        });
    }

    public function down(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'map_title',
                'map_description',
                'map_latitude',
                'map_longitude',
                'map_zoom',
                'map_popup_title',
                'map_popup_description',
                'map_info_title',
                'map_boundary_title',
                'map_boundary_description',
                'map_facility_title',
                'map_facility_description',
                'map_potential_title',
                'map_potential_description',
                'map_note',
                'map_markers',
            ]);
        });
    }
};
