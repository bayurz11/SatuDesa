<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitizenSeeder extends Seeder
{
    public function run(): void
    {
        $villageId = DB::table('villages')->where('code', 'MENTUDA')->value('id');

        if (!$villageId) {
            return;
        }

        $areas = DB::table('rts')
            ->join('rws', 'rws.id', '=', 'rts.rw_id')
            ->join('hamlets', 'hamlets.id', '=', 'rws.hamlet_id')
            ->where('rts.village_id', $villageId)
            ->select([
                'rts.id as rt_id',
                'rts.number as rt_number',
                'rws.id as rw_id',
                'rws.number as rw_number',
                'hamlets.id as hamlet_id',
                'hamlets.name as hamlet_name',
            ])
            ->get()
            ->keyBy(fn ($area) => $area->hamlet_name . ':' . $area->rw_number . ':' . $area->rt_number);

        $households = [
            [
                'no_kk' => '2104010101010001',
                'address' => 'Jl. Pelantar Bahari No. 01',
                'area' => 'Dusun Utara:001:001',
                'head_nik' => '2104011201800001',
                'members' => [
                    [
                        'nik' => '2104011201800001',
                        'full_name' => 'Ahmad Fauzi',
                        'gender' => 'L',
                        'birth_place' => 'Lingga',
                        'birth_date' => '1980-01-12',
                        'religion' => 'Islam',
                        'marital_status' => 'Kawin',
                        'occupation' => 'Nelayan',
                        'education' => 'SMA',
                        'status' => 'active',
                    ],
                    [
                        'nik' => '2104012205850002',
                        'full_name' => 'Siti Rahmah',
                        'gender' => 'P',
                        'birth_place' => 'Lingga',
                        'birth_date' => '1985-05-22',
                        'religion' => 'Islam',
                        'marital_status' => 'Kawin',
                        'occupation' => 'Ibu Rumah Tangga',
                        'education' => 'SMA',
                        'status' => 'active',
                    ],
                    [
                        'nik' => '2104011508100003',
                        'full_name' => 'M. Rizky Fauzan',
                        'gender' => 'L',
                        'birth_place' => 'Tanjungpinang',
                        'birth_date' => '2010-08-15',
                        'religion' => 'Islam',
                        'marital_status' => 'Belum Kawin',
                        'occupation' => 'Pelajar',
                        'education' => 'SMP',
                        'status' => 'active',
                    ],
                ],
            ],
            [
                'no_kk' => '2104010101010002',
                'address' => 'Jl. Kampung Baru RT 002',
                'area' => 'Dusun Utara:001:002',
                'head_nik' => '2104010303770004',
                'members' => [
                    [
                        'nik' => '2104010303770004',
                        'full_name' => 'Budi Santoso',
                        'gender' => 'L',
                        'birth_place' => 'Batam',
                        'birth_date' => '1977-03-03',
                        'religion' => 'Islam',
                        'marital_status' => 'Kawin',
                        'occupation' => 'Wiraswasta',
                        'education' => 'SMA',
                        'status' => 'active',
                    ],
                    [
                        'nik' => '2104011711820005',
                        'full_name' => 'Nuraini',
                        'gender' => 'P',
                        'birth_place' => 'Lingga',
                        'birth_date' => '1982-11-17',
                        'religion' => 'Islam',
                        'marital_status' => 'Kawin',
                        'occupation' => 'Pedagang',
                        'education' => 'SMA',
                        'status' => 'active',
                    ],
                    [
                        'nik' => '2104010909070006',
                        'full_name' => 'Dewi Lestari',
                        'gender' => 'P',
                        'birth_place' => 'Lingga',
                        'birth_date' => '2007-09-09',
                        'religion' => 'Islam',
                        'marital_status' => 'Belum Kawin',
                        'occupation' => 'Pelajar',
                        'education' => 'SMA',
                        'status' => 'active',
                    ],
                ],
            ],
            [
                'no_kk' => '2104010101010003',
                'address' => 'Jl. Pesisir Selatan RT 001',
                'area' => 'Dusun Selatan:001:001',
                'head_nik' => '2104012506720007',
                'members' => [
                    [
                        'nik' => '2104012506720007',
                        'full_name' => 'Hasan Basri',
                        'gender' => 'L',
                        'birth_place' => 'Lingga',
                        'birth_date' => '1972-06-25',
                        'religion' => 'Islam',
                        'marital_status' => 'Kawin',
                        'occupation' => 'Petani',
                        'education' => 'SMP',
                        'status' => 'active',
                    ],
                    [
                        'nik' => '2104011310750008',
                        'full_name' => 'Mariani',
                        'gender' => 'P',
                        'birth_place' => 'Lingga',
                        'birth_date' => '1975-10-13',
                        'religion' => 'Islam',
                        'marital_status' => 'Kawin',
                        'occupation' => 'Pengrajin',
                        'education' => 'SMP',
                        'status' => 'active',
                    ],
                    [
                        'nik' => '2104010212990009',
                        'full_name' => 'Rina Oktaviani',
                        'gender' => 'P',
                        'birth_place' => 'Lingga',
                        'birth_date' => '1999-12-02',
                        'religion' => 'Islam',
                        'marital_status' => 'Belum Kawin',
                        'occupation' => 'Mahasiswa',
                        'education' => 'S1',
                        'status' => 'active',
                    ],
                    [
                        'nik' => '2104010101550010',
                        'full_name' => 'Jamaludin',
                        'gender' => 'L',
                        'birth_place' => 'Lingga',
                        'birth_date' => '1955-01-01',
                        'religion' => 'Islam',
                        'marital_status' => 'Cerai Mati',
                        'occupation' => 'Pensiunan',
                        'education' => 'SD',
                        'status' => 'inactive',
                    ],
                ],
            ],
        ];

        foreach ($households as $householdData) {
            $area = $areas[$householdData['area']] ?? null;

            if (!$area) {
                continue;
            }

            DB::table('households')->updateOrInsert(
                ['no_kk' => $householdData['no_kk']],
                [
                    'village_id' => $villageId,
                    'head_citizen_id' => null,
                    'hamlet_id' => $area->hamlet_id,
                    'rw_id' => $area->rw_id,
                    'rt_id' => $area->rt_id,
                    'address' => $householdData['address'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            $householdId = DB::table('households')->where('no_kk', $householdData['no_kk'])->value('id');

            foreach ($householdData['members'] as $member) {
                DB::table('citizens')->updateOrInsert(
                    ['nik' => $member['nik']],
                    [
                        'household_id' => $householdId,
                        'full_name' => $member['full_name'],
                        'gender' => $member['gender'],
                        'birth_place' => $member['birth_place'],
                        'birth_date' => $member['birth_date'],
                        'religion' => $member['religion'],
                        'marital_status' => $member['marital_status'],
                        'occupation' => $member['occupation'],
                        'education' => $member['education'],
                        'citizenship' => 'WNI',
                        'address' => $householdData['address'],
                        'status' => $member['status'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            $headCitizenId = DB::table('citizens')->where('nik', $householdData['head_nik'])->value('id');

            DB::table('households')
                ->where('id', $householdId)
                ->update([
                    'head_citizen_id' => $headCitizenId,
                    'updated_at' => now(),
                ]);
        }
    }
}
