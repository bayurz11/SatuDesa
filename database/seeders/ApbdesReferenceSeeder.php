<?php

namespace Database\Seeders;

use App\Domains\Budget\Models\ApbdesAccount;
use App\Domains\Budget\Models\ApbdesFiscalYear;
use App\Domains\Budget\Models\ApbdesFundingSource;
use App\Domains\Village\Models\Village;
use Illuminate\Database\Seeder;

class ApbdesReferenceSeeder extends Seeder
{
    public function run(): void
    {
        Village::query()->each(function (Village $village): void {
            $fundingSources = [
                ['code' => 'PAD', 'name' => 'Pendapatan Asli Desa'],
                ['code' => 'DD', 'name' => 'Dana Desa'],
                ['code' => 'ADD', 'name' => 'Alokasi Dana Desa'],
                ['code' => 'BHP', 'name' => 'Bagi Hasil Pajak dan Retribusi'],
                ['code' => 'BKK', 'name' => 'Bantuan Keuangan Kabupaten/Kota'],
                ['code' => 'BKP', 'name' => 'Bantuan Keuangan Provinsi'],
                ['code' => 'LAIN', 'name' => 'Pendapatan Lain yang Sah'],
            ];

            foreach ($fundingSources as $source) {
                ApbdesFundingSource::query()->updateOrCreate(
                    [
                        'village_id' => $village->id,
                        'code' => $source['code'],
                    ],
                    [
                        'name' => $source['name'],
                        'description' => 'Referensi sumber dana APBDes untuk penyusunan anggaran dan realisasi.',
                        'is_active' => true,
                    ]
                );
            }

            $accounts = [
                ['code' => '4', 'name' => 'Pendapatan Desa', 'type' => 'pendapatan', 'level' => 1, 'parent_code' => null],
                ['code' => '4.1', 'name' => 'Pendapatan Asli Desa', 'type' => 'pendapatan', 'level' => 2, 'parent_code' => '4'],
                ['code' => '4.2', 'name' => 'Transfer', 'type' => 'pendapatan', 'level' => 2, 'parent_code' => '4'],
                ['code' => '4.3', 'name' => 'Pendapatan Lain-lain', 'type' => 'pendapatan', 'level' => 2, 'parent_code' => '4'],
                ['code' => '5', 'name' => 'Belanja Desa', 'type' => 'belanja', 'level' => 1, 'parent_code' => null],
                ['code' => '5.1', 'name' => 'Bidang Penyelenggaraan Pemerintahan Desa', 'type' => 'belanja', 'level' => 2, 'parent_code' => '5'],
                ['code' => '5.2', 'name' => 'Bidang Pelaksanaan Pembangunan Desa', 'type' => 'belanja', 'level' => 2, 'parent_code' => '5'],
                ['code' => '5.3', 'name' => 'Bidang Pembinaan Kemasyarakatan', 'type' => 'belanja', 'level' => 2, 'parent_code' => '5'],
                ['code' => '5.4', 'name' => 'Bidang Pemberdayaan Masyarakat', 'type' => 'belanja', 'level' => 2, 'parent_code' => '5'],
                ['code' => '5.5', 'name' => 'Bidang Penanggulangan Bencana, Darurat, dan Mendesak Desa', 'type' => 'belanja', 'level' => 2, 'parent_code' => '5'],
                ['code' => '6', 'name' => 'Pembiayaan Desa', 'type' => 'pembiayaan', 'level' => 1, 'parent_code' => null],
                ['code' => '6.1', 'name' => 'Penerimaan Pembiayaan', 'type' => 'pembiayaan', 'level' => 2, 'parent_code' => '6'],
                ['code' => '6.2', 'name' => 'Pengeluaran Pembiayaan', 'type' => 'pembiayaan', 'level' => 2, 'parent_code' => '6'],
            ];

            $createdAccounts = [];

            foreach ($accounts as $account) {
                $parentId = null;

                if ($account['parent_code']) {
                    $parentId = $createdAccounts[$account['parent_code']] ?? ApbdesAccount::query()
                        ->where('village_id', $village->id)
                        ->where('code', $account['parent_code'])
                        ->value('id');
                }

                $saved = ApbdesAccount::query()->updateOrCreate(
                    [
                        'village_id' => $village->id,
                        'code' => $account['code'],
                    ],
                    [
                        'parent_id' => $parentId,
                        'name' => $account['name'],
                        'type' => $account['type'],
                        'level' => $account['level'],
                        'description' => 'Referensi akun APBDes tahap awal yang dapat dikembangkan sesuai peraturan daerah.',
                        'is_active' => true,
                    ]
                );

                $createdAccounts[$account['code']] = $saved->id;
            }

            ApbdesFiscalYear::query()->firstOrCreate(
                [
                    'village_id' => $village->id,
                    'year' => (int) now()->format('Y'),
                ],
                [
                    'title' => 'APBDes ' . now()->format('Y'),
                    'status' => 'draft',
                    'start_date' => now()->startOfYear()->toDateString(),
                    'end_date' => now()->endOfYear()->toDateString(),
                    'notes' => 'Tahun anggaran awal untuk memulai penyusunan APBDes di panel admin.',
                ]
            );
        });
    }
}
