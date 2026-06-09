<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('citizens') || !Schema::hasTable('citizen_deaths')) {
            return;
        }

        $villageId = DB::table('villages')->value('id');

        if (!$villageId) {
            return;
        }

        $citizens = DB::table('citizens')
            ->leftJoin('citizen_deaths', 'citizen_deaths.citizen_id', '=', 'citizens.id')
            ->whereNull('citizen_deaths.id')
            ->where('citizens.status', 'deceased')
            ->select('citizens.id', 'citizens.updated_at', 'citizens.created_at')
            ->get();

        foreach ($citizens as $citizen) {
            DB::table('citizen_deaths')->insert([
                'village_id' => $villageId,
                'citizen_id' => $citizen->id,
                'death_date' => substr((string) ($citizen->updated_at ?: $citizen->created_at), 0, 10),
                'notes' => 'Migrated from existing citizen status during form normalization.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('citizen_deaths')
            ->where('notes', 'Migrated from existing citizen status during form normalization.')
            ->delete();
    }
};
