<?php

namespace Database\Seeders;

use App\Support\CitizenReferenceData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LargeCitizenDummySeeder extends Seeder
{
    private const HOUSEHOLD_COUNT = 700;
    private const ADDRESS_MARKER = 'Blok Simulasi Kependudukan';

    public function run(): void
    {
        $villageId = DB::table('villages')->where('code', 'MENTUDA')->value('id');

        if (! $villageId) {
            $this->command?->warn('Village MENTUDA tidak ditemukan. Seeder dibatalkan.');
            return;
        }

        $existingHouseholds = DB::table('households')
            ->where('address', 'like', self::ADDRESS_MARKER . '%')
            ->count();

        if ($existingHouseholds > 0) {
            $this->command?->warn('Data dummy skala besar sudah pernah dibuat. Seeder dilewati agar tidak duplikat.');
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
            ->orderBy('hamlets.name')
            ->orderBy('rws.number')
            ->orderBy('rts.number')
            ->get()
            ->values();

        if ($areas->isEmpty()) {
            $this->command?->warn('Data dusun/RW/RT belum tersedia. Seeder dibatalkan.');
            return;
        }

        $occupations = CitizenReferenceData::occupationOptions();
        $educations = CitizenReferenceData::educationOptions();
        $religions = CitizenReferenceData::religionOptions();
        $maleFirstNames = ['Ahmad', 'Budi', 'Rizal', 'Junaidi', 'Fahri', 'Rudi', 'Andika', 'Wahyu', 'Ilham', 'Hendra', 'Firman', 'Surya'];
        $femaleFirstNames = ['Siti', 'Nuraini', 'Aisyah', 'Rina', 'Lestari', 'Putri', 'Dewi', 'Marlina', 'Rahma', 'Yuliana', 'Fitri', 'Nabila'];
        $lastNames = ['Saputra', 'Pratama', 'Permana', 'Utama', 'Santoso', 'Kurniawan', 'Wijaya', 'Fauzi', 'Rahman', 'Hidayat', 'Siregar', 'Basri'];

        $totalCitizens = 0;

        for ($householdIndex = 1; $householdIndex <= self::HOUSEHOLD_COUNT; $householdIndex++) {
            $area = $areas[($householdIndex - 1) % $areas->count()];
            $noKk = sprintf('2104019%09d', $householdIndex);
            $address = sprintf(
                '%s %03d RT %s / RW %s, %s',
                self::ADDRESS_MARKER,
                $householdIndex,
                $area->rt_number,
                $area->rw_number,
                $area->hamlet_name
            );

            $householdId = DB::table('households')->insertGetId([
                'village_id' => $villageId,
                'no_kk' => $noKk,
                'head_citizen_id' => null,
                'hamlet_id' => $area->hamlet_id,
                'rw_id' => $area->rw_id,
                'rt_id' => $area->rt_id,
                'address' => $address,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $memberCount = random_int(3, 6);
            $headGender = random_int(1, 100) <= 85 ? 'L' : 'P';
            $headBirthDate = now()->subYears(random_int(30, 68))->subDays(random_int(0, 364));
            $headCitizenId = null;

            for ($memberIndex = 1; $memberIndex <= $memberCount; $memberIndex++) {
                $role = $this->resolveRole($memberIndex, $memberCount);
                $gender = $this->resolveGender($role, $headGender);
                $birthDate = $this->resolveBirthDate($role, $headBirthDate);
                $age = $birthDate->age;
                $nikSeed = (($householdIndex - 1) * 10) + $memberIndex;
                $nik = sprintf('2104018%09d', $nikSeed);
                $fullName = $this->generateFullName($gender, $nikSeed, $maleFirstNames, $femaleFirstNames, $lastNames);

                $citizenId = DB::table('citizens')->insertGetId([
                    'household_id' => $householdId,
                    'nik' => $nik,
                    'full_name' => $fullName,
                    'gender' => $gender,
                    'birth_place' => $this->generateBirthPlace($nikSeed),
                    'birth_date' => $birthDate->toDateString(),
                    'religion' => $religions[array_rand($religions)],
                    'marital_status' => $this->resolveMaritalStatus($role, $age),
                    'family_relationship' => $role,
                    'occupation' => $this->resolveOccupation($role, $age, $occupations),
                    'education' => $this->resolveEducation($age, $educations),
                    'citizenship' => 'WNI',
                    'address' => $address,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if ($role === 'Kepala Keluarga') {
                    $headCitizenId = $citizenId;
                }

                $totalCitizens++;
            }

            DB::table('households')
                ->where('id', $householdId)
                ->update([
                    'head_citizen_id' => $headCitizenId,
                    'updated_at' => now(),
                ]);

            if ($householdIndex % 100 === 0) {
                $this->command?->info("Progress seeder dummy: {$householdIndex}/" . self::HOUSEHOLD_COUNT . ' KK');
            }
        }

        $this->command?->info(sprintf(
            'Seeder dummy sekali pakai selesai: %s KK dan %s penduduk ditambahkan.',
            number_format(self::HOUSEHOLD_COUNT, 0, ',', '.'),
            number_format($totalCitizens, 0, ',', '.')
        ));
    }

    private function resolveRole(int $memberIndex, int $memberCount): string
    {
        if ($memberIndex === 1) {
            return 'Kepala Keluarga';
        }

        if ($memberIndex === 2) {
            return random_int(1, 100) <= 90 ? 'Istri' : 'Suami';
        }

        if ($memberIndex === $memberCount && $memberCount >= 5 && random_int(1, 100) <= 15) {
            return 'Orang Tua';
        }

        return 'Anak';
    }

    private function resolveGender(string $role, string $headGender): string
    {
        return match ($role) {
            'Istri' => 'P',
            'Suami' => 'L',
            'Kepala Keluarga' => $headGender,
            default => random_int(0, 1) === 1 ? 'L' : 'P',
        };
    }

    private function resolveBirthDate(string $role, $headBirthDate)
    {
        return match ($role) {
            'Kepala Keluarga' => (clone $headBirthDate),
            'Istri', 'Suami' => (clone $headBirthDate)->addYears(random_int(-5, 5))->addDays(random_int(0, 200)),
            'Orang Tua' => (clone $headBirthDate)->subYears(random_int(18, 30))->subDays(random_int(0, 200)),
            default => now()->subYears(random_int(0, 24))->subDays(random_int(0, 364)),
        };
    }

    private function resolveMaritalStatus(string $role, int $age): string
    {
        if (in_array($role, ['Kepala Keluarga', 'Istri', 'Suami'], true)) {
            return 'Kawin';
        }

        if ($role === 'Orang Tua') {
            return random_int(1, 100) <= 25 ? 'Cerai Mati' : 'Kawin';
        }

        return $age >= 22 && random_int(1, 100) <= 15 ? 'Kawin' : 'Belum Kawin';
    }

    private function resolveOccupation(string $role, int $age, array $occupations): string
    {
        if ($role === 'Anak' && $age <= 22) {
            return 'Pelajar/Mahasiswa';
        }

        if ($role === 'Orang Tua' && $age >= 60) {
            return 'Pensiunan';
        }

        $preferred = [
            'Petani/Pekebun',
            'Nelayan/Perikanan',
            'Wiraswasta',
            'Perdagangan',
            'Karyawan Swasta',
            'Mengurus Rumah Tangga',
            'Guru',
            'Buruh Harian Lepas',
        ];

        return $preferred[array_rand($preferred)] ?? $occupations[array_rand($occupations)];
    }

    private function resolveEducation(int $age, array $educations): string
    {
        return match (true) {
            $age <= 5 => 'Tidak/Belum Sekolah',
            $age <= 12 => 'Tamat SD/Sederajat',
            $age <= 15 => 'SLTP/Sederajat',
            $age <= 22 => 'SLTA/Sederajat',
            $age <= 35 => $this->pick([
                'SLTA/Sederajat',
                'Diploma IV/Strata I',
                'Akademi/Diploma III/S. Muda',
            ]),
            default => $this->pick([
                'Tamat SD/Sederajat',
                'SLTP/Sederajat',
                'SLTA/Sederajat',
            ]),
        };
    }

    private function pick(array $values): string
    {
        return $values[array_rand($values)];
    }

    private function generateFullName(string $gender, int $seed, array $maleFirstNames, array $femaleFirstNames, array $lastNames): string
    {
        $firstNames = $gender === 'L' ? $maleFirstNames : $femaleFirstNames;

        return $firstNames[$seed % count($firstNames)] . ' ' . $lastNames[($seed + 3) % count($lastNames)];
    }

    private function generateBirthPlace(int $seed): string
    {
        $places = ['Lingga', 'Daik', 'Dabo Singkep', 'Tanjungpinang', 'Batam', 'Senayang'];

        return $places[$seed % count($places)];
    }
}
