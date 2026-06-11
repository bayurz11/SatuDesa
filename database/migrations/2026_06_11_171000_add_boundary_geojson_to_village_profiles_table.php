<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->json('map_boundary_geojson')->nullable()->after('map_boundary_description');
        });

        $mentudaVillageId = DB::table('villages')->where('code', 'MENTUDA')->value('id');

        if ($mentudaVillageId) {
            DB::table('village_profiles')
                ->where('village_id', $mentudaVillageId)
                ->update([
                    'map_boundary_geojson' => json_encode([
                        'type' => 'Feature',
                        'properties' => [
                            'name' => 'Batas Wilayah Desa Mentuda',
                            'source' => 'OpenStreetMap bounding area',
                        ],
                        'geometry' => [
                            'type' => 'Polygon',
                            'coordinates' => [[
                                [104.4612758, -0.1849998],
                                [104.5012758, -0.1849998],
                                [104.5012758, -0.1449998],
                                [104.4612758, -0.1449998],
                                [104.4612758, -0.1849998],
                            ]],
                        ],
                    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                    'updated_at' => now(),
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('village_profiles', function (Blueprint $table) {
            $table->dropColumn('map_boundary_geojson');
        });
    }
};
