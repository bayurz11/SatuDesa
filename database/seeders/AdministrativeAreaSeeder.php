<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdministrativeAreaSeeder extends Seeder
{
    public function run(): void
    {
        $villageId = DB::table('villages')->where('code', 'MENTUDA')->value('id');

        if (!$villageId) {
            return;
        }

        $hamlets = [
            ['name' => 'Dusun Utara', 'code' => 'DUSUN-UTARA'],
            ['name' => 'Dusun Tengah', 'code' => 'DUSUN-TENGAH'],
            ['name' => 'Dusun Selatan', 'code' => 'DUSUN-SELATAN'],
        ];

        foreach ($hamlets as $hamlet) {
            DB::table('hamlets')->updateOrInsert(
                [
                    'village_id' => $villageId,
                    'name' => $hamlet['name'],
                ],
                [
                    'code' => $hamlet['code'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        $hamletMap = DB::table('hamlets')
            ->where('village_id', $villageId)
            ->pluck('id', 'name');

        $rws = [
            ['hamlet' => 'Dusun Utara', 'number' => '001'],
            ['hamlet' => 'Dusun Utara', 'number' => '002'],
            ['hamlet' => 'Dusun Tengah', 'number' => '001'],
            ['hamlet' => 'Dusun Selatan', 'number' => '001'],
        ];

        foreach ($rws as $rw) {
            $hamletId = $hamletMap[$rw['hamlet']] ?? null;

            if (!$hamletId) {
                continue;
            }

            DB::table('rws')->updateOrInsert(
                [
                    'hamlet_id' => $hamletId,
                    'number' => $rw['number'],
                ],
                [
                    'village_id' => $villageId,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        $rwRows = DB::table('rws')
            ->join('hamlets', 'hamlets.id', '=', 'rws.hamlet_id')
            ->where('rws.village_id', $villageId)
            ->select('rws.id', 'hamlets.name as hamlet_name', 'rws.number')
            ->get();

        $rwMap = [];
        foreach ($rwRows as $rw) {
            $rwMap[$rw->hamlet_name . ':' . $rw->number] = $rw->id;
        }

        $rts = [
            ['hamlet' => 'Dusun Utara', 'rw' => '001', 'number' => '001'],
            ['hamlet' => 'Dusun Utara', 'rw' => '001', 'number' => '002'],
            ['hamlet' => 'Dusun Utara', 'rw' => '002', 'number' => '001'],
            ['hamlet' => 'Dusun Tengah', 'rw' => '001', 'number' => '001'],
            ['hamlet' => 'Dusun Tengah', 'rw' => '001', 'number' => '002'],
            ['hamlet' => 'Dusun Selatan', 'rw' => '001', 'number' => '001'],
        ];

        foreach ($rts as $rt) {
            $rwId = $rwMap[$rt['hamlet'] . ':' . $rt['rw']] ?? null;

            if (!$rwId) {
                continue;
            }

            DB::table('rts')->updateOrInsert(
                [
                    'rw_id' => $rwId,
                    'number' => $rt['number'],
                ],
                [
                    'village_id' => $villageId,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
