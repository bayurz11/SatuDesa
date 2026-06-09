<?php

namespace Database\Seeders;

use App\Domains\Budget\Models\ApbdesAccount;
use App\Domains\Budget\Models\ApbdesBankBookEntry;
use App\Domains\Budget\Models\ApbdesBudgetLine;
use App\Domains\Budget\Models\ApbdesCashBookEntry;
use App\Domains\Budget\Models\ApbdesFiscalYear;
use App\Domains\Budget\Models\ApbdesPaymentRequest;
use App\Domains\Budget\Models\ApbdesRealization;
use App\Domains\Budget\Models\ApbdesTaxBookEntry;
use App\Domains\Budget\Models\ApbdesFundingSource;
use App\Domains\Village\Models\Village;
use Illuminate\Database\Seeder;

class ApbdesDummySeeder extends Seeder
{
    public function run(): void
    {
        $villages = Village::query()->get();

        if ($villages->isEmpty()) {
            $villages = collect([
                Village::query()->create([
                    'code' => 'VLG-001',
                    'name' => 'Desa Sukamaju',
                    'district' => 'Kecamatan Maju',
                    'regency' => 'Kabupaten Sejahtera',
                    'province' => 'Jawa Barat',
                    'postal_code' => '40123',
                ]),
            ]);
        }

        $villages->each(function (Village $village): void {
            $this->seedVillageDummyData($village);
        });
    }

    protected function seedVillageDummyData(Village $village): void
    {
        $years = $this->seedFiscalYears($village);
        $this->seedDetailAccounts($village);

        $fundingSources = ApbdesFundingSource::query()
            ->where('village_id', $village->id)
            ->where('is_active', true)
            ->orderBy('code')
            ->get()
            ->keyBy('code');

        $accounts = ApbdesAccount::query()
            ->where('village_id', $village->id)
            ->orderBy('code')
            ->get()
            ->keyBy('code');

        $budgetLines = $this->seedBudgetLines($years, $fundingSources, $accounts);
        $operations = $this->seedOperations($years, $budgetLines);
        $this->seedBooks($years, $operations['realizations']);
        $this->syncBudgetLineRealizations($budgetLines);
    }

    protected function seedFiscalYears(Village $village): array
    {
        $definitions = [
            2025 => [
                'title' => 'APBDes 2025',
                'status' => 'reported',
                'start_date' => '2025-01-01',
                'end_date' => '2025-12-31',
                'apbdes_regulation_number' => 'PERDES 01/2025',
                'apbdes_regulation_date' => '2025-01-15',
                'notes' => 'Data dummy APBDes tahun pelaporan.',
            ],
            2026 => [
                'title' => 'APBDes 2026',
                'status' => 'active',
                'start_date' => '2026-01-01',
                'end_date' => '2026-12-31',
                'apbdes_regulation_number' => 'PERDES 02/2026',
                'apbdes_regulation_date' => '2026-01-18',
                'notes' => 'Data dummy APBDes tahun berjalan.',
            ],
            2027 => [
                'title' => 'APBDes 2027',
                'status' => 'draft',
                'start_date' => '2027-01-01',
                'end_date' => '2027-12-31',
                'apbdes_regulation_number' => null,
                'apbdes_regulation_date' => null,
                'notes' => 'Data dummy APBDes tahun perencanaan.',
            ],
        ];

        $records = [];

        foreach ($definitions as $year => $payload) {
            $records[$year] = ApbdesFiscalYear::query()->updateOrCreate(
                [
                    'village_id' => $village->id,
                    'year' => $year,
                ],
                $payload
            );
        }

        return $records;
    }

    protected function seedDetailAccounts(Village $village): void
    {
        $definitions = [
            ['code' => '4.1.1', 'name' => 'Hasil Usaha Desa', 'type' => 'pendapatan', 'level' => 3, 'parent_code' => '4.1'],
            ['code' => '4.2.1', 'name' => 'Transfer Dana Desa', 'type' => 'pendapatan', 'level' => 3, 'parent_code' => '4.2'],
            ['code' => '4.2.2', 'name' => 'Transfer Alokasi Dana Desa', 'type' => 'pendapatan', 'level' => 3, 'parent_code' => '4.2'],
            ['code' => '5.1.1', 'name' => 'Penghasilan Tetap dan Tunjangan', 'type' => 'belanja', 'level' => 3, 'parent_code' => '5.1'],
            ['code' => '5.1.2', 'name' => 'Operasional Perkantoran Desa', 'type' => 'belanja', 'level' => 3, 'parent_code' => '5.1'],
            ['code' => '5.2.1', 'name' => 'Pembangunan Jalan Lingkungan', 'type' => 'belanja', 'level' => 3, 'parent_code' => '5.2'],
            ['code' => '5.2.2', 'name' => 'Pembangunan Drainase Desa', 'type' => 'belanja', 'level' => 3, 'parent_code' => '5.2'],
            ['code' => '5.3.1', 'name' => 'Pembinaan Karang Taruna', 'type' => 'belanja', 'level' => 3, 'parent_code' => '5.3'],
            ['code' => '5.4.1', 'name' => 'Pelatihan UMKM Desa', 'type' => 'belanja', 'level' => 3, 'parent_code' => '5.4'],
            ['code' => '5.5.1', 'name' => 'Bantuan Mendesak Warga', 'type' => 'belanja', 'level' => 3, 'parent_code' => '5.5'],
            ['code' => '6.1.1', 'name' => 'SILPA Tahun Sebelumnya', 'type' => 'pembiayaan', 'level' => 3, 'parent_code' => '6.1'],
            ['code' => '6.2.1', 'name' => 'Penyertaan Modal BUMDes', 'type' => 'pembiayaan', 'level' => 3, 'parent_code' => '6.2'],
        ];

        foreach ($definitions as $definition) {
            $parentId = ApbdesAccount::query()
                ->where('village_id', $village->id)
                ->where('code', $definition['parent_code'])
                ->value('id');

            ApbdesAccount::query()->updateOrCreate(
                [
                    'village_id' => $village->id,
                    'code' => $definition['code'],
                ],
                [
                    'parent_id' => $parentId,
                    'name' => $definition['name'],
                    'type' => $definition['type'],
                    'level' => $definition['level'],
                    'description' => 'Akun detail dummy untuk simulasi modul APBDes.',
                    'is_active' => true,
                ]
            );
        }
    }

    protected function seedBudgetLines(array $years, $fundingSources, $accounts): array
    {
        $definitions = [
            2025 => [
                ['account' => '4.2.1', 'source' => 'DD', 'description' => 'Pendapatan Dana Desa Tahap I', 'amount' => 500000000, 'sort_order' => 1],
                ['account' => '4.2.2', 'source' => 'ADD', 'description' => 'Pendapatan Alokasi Dana Desa', 'amount' => 225000000, 'sort_order' => 2],
                ['account' => '5.1.1', 'source' => 'ADD', 'description' => 'Penghasilan Tetap Perangkat Desa', 'amount' => 180000000, 'sort_order' => 3],
                ['account' => '5.2.1', 'source' => 'DD', 'description' => 'Pembangunan Jalan Lingkungan Dusun 1', 'amount' => 210000000, 'sort_order' => 4],
                ['account' => '5.4.1', 'source' => 'DD', 'description' => 'Pelatihan UMKM dan Wirausaha Desa', 'amount' => 45000000, 'sort_order' => 5],
                ['account' => '6.1.1', 'source' => 'LAIN', 'description' => 'SILPA Tahun 2024', 'amount' => 35000000, 'sort_order' => 6],
            ],
            2026 => [
                ['account' => '4.2.1', 'source' => 'DD', 'description' => 'Pendapatan Dana Desa Tahap I dan II', 'amount' => 650000000, 'sort_order' => 1],
                ['account' => '4.2.2', 'source' => 'ADD', 'description' => 'Pendapatan Alokasi Dana Desa 2026', 'amount' => 250000000, 'sort_order' => 2],
                ['account' => '4.1.1', 'source' => 'PAD', 'description' => 'Pendapatan Hasil Usaha BUMDes', 'amount' => 85000000, 'sort_order' => 3],
                ['account' => '5.1.1', 'source' => 'ADD', 'description' => 'Penghasilan Tetap dan Tunjangan Aparatur Desa', 'amount' => 195000000, 'sort_order' => 4],
                ['account' => '5.1.2', 'source' => 'ADD', 'description' => 'Operasional Perkantoran dan ATK Desa', 'amount' => 90000000, 'sort_order' => 5],
                ['account' => '5.2.1', 'source' => 'DD', 'description' => 'Pembangunan Jalan Usaha Tani', 'amount' => 240000000, 'sort_order' => 6],
                ['account' => '5.2.2', 'source' => 'DD', 'description' => 'Pembangunan Drainase Lingkungan RT 03', 'amount' => 125000000, 'sort_order' => 7],
                ['account' => '5.3.1', 'source' => 'BKK', 'description' => 'Pembinaan Karang Taruna Desa', 'amount' => 30000000, 'sort_order' => 8],
                ['account' => '5.4.1', 'source' => 'DD', 'description' => 'Pelatihan UMKM Perempuan dan Pemuda', 'amount' => 55000000, 'sort_order' => 9],
                ['account' => '5.5.1', 'source' => 'BKP', 'description' => 'Bantuan Mendesak untuk Warga Rentan', 'amount' => 40000000, 'sort_order' => 10],
                ['account' => '6.2.1', 'source' => 'PAD', 'description' => 'Penyertaan Modal BUMDes Sejahtera', 'amount' => 60000000, 'sort_order' => 11],
            ],
            2027 => [
                ['account' => '4.2.1', 'source' => 'DD', 'description' => 'Rencana Dana Desa 2027', 'amount' => 700000000, 'sort_order' => 1],
                ['account' => '5.2.1', 'source' => 'DD', 'description' => 'Rencana Pembangunan Jalan Tahap Lanjutan', 'amount' => 260000000, 'sort_order' => 2],
                ['account' => '5.4.1', 'source' => 'BKK', 'description' => 'Rencana Pelatihan UMKM Digital', 'amount' => 65000000, 'sort_order' => 3],
            ],
        ];

        $records = [];

        foreach ($definitions as $year => $lines) {
            foreach ($lines as $line) {
                $account = $accounts->get($line['account']);
                $fundingSource = $fundingSources->get($line['source']);

                if (!$account) {
                    continue;
                }

                $record = ApbdesBudgetLine::query()->updateOrCreate(
                    [
                        'fiscal_year_id' => $years[$year]->id,
                        'account_id' => $account->id,
                        'description' => $line['description'],
                    ],
                    [
                        'funding_source_id' => $fundingSource?->id,
                        'amount' => $line['amount'],
                        'realized_amount' => 0,
                        'sort_order' => $line['sort_order'],
                        'notes' => 'Baris anggaran dummy untuk pengujian menu APBDes.',
                    ]
                );

                $records[$year][$line['description']] = $record;
            }
        }

        return $records;
    }

    protected function seedOperations(array $years, array $budgetLines): array
    {
        $paymentDefinitions = [
            [
                'year' => 2026,
                'budget_line_description' => 'Penghasilan Tetap dan Tunjangan Aparatur Desa',
                'request_number' => 'SPP-2026-001',
                'request_date' => '2026-02-05',
                'payee_name' => 'Bendahara Penghasilan Tetap',
                'amount' => 48000000,
                'status' => 'approved',
                'description' => 'SPP penghasilan tetap perangkat desa triwulan I.',
            ],
            [
                'year' => 2026,
                'budget_line_description' => 'Pembangunan Jalan Usaha Tani',
                'request_number' => 'SPP-2026-002',
                'request_date' => '2026-03-12',
                'payee_name' => 'CV Maju Infrastruktur',
                'amount' => 110000000,
                'status' => 'paid',
                'description' => 'SPP termin pertama pembangunan jalan usaha tani.',
            ],
            [
                'year' => 2026,
                'budget_line_description' => 'Pelatihan UMKM Perempuan dan Pemuda',
                'request_number' => 'SPP-2026-003',
                'request_date' => '2026-04-08',
                'payee_name' => 'Lembaga Pelatihan Desa Cerdas',
                'amount' => 22000000,
                'status' => 'submitted',
                'description' => 'SPP pelatihan UMKM batch pertama.',
            ],
        ];

        $realizationDefinitions = [
            [
                'year' => 2026,
                'budget_line_description' => 'Penghasilan Tetap dan Tunjangan Aparatur Desa',
                'payment_request_number' => 'SPP-2026-001',
                'transaction_date' => '2026-02-10',
                'reference_number' => 'REAL-2026-001',
                'payment_method' => 'bank',
                'amount' => 48000000,
                'status' => 'verified',
                'description' => 'Pembayaran penghasilan tetap perangkat desa triwulan I.',
            ],
            [
                'year' => 2026,
                'budget_line_description' => 'Pembangunan Jalan Usaha Tani',
                'payment_request_number' => 'SPP-2026-002',
                'transaction_date' => '2026-03-20',
                'reference_number' => 'REAL-2026-002',
                'payment_method' => 'transfer',
                'amount' => 97500000,
                'status' => 'posted',
                'description' => 'Pembayaran termin pertama pekerjaan jalan usaha tani.',
            ],
            [
                'year' => 2026,
                'budget_line_description' => 'Operasional Perkantoran dan ATK Desa',
                'payment_request_number' => null,
                'transaction_date' => '2026-01-28',
                'reference_number' => 'REAL-2026-003',
                'payment_method' => 'cash',
                'amount' => 12500000,
                'status' => 'posted',
                'description' => 'Belanja operasional kantor awal tahun.',
            ],
            [
                'year' => 2025,
                'budget_line_description' => 'Pembangunan Jalan Lingkungan Dusun 1',
                'payment_request_number' => null,
                'transaction_date' => '2025-08-14',
                'reference_number' => 'REAL-2025-001',
                'payment_method' => 'bank',
                'amount' => 185000000,
                'status' => 'verified',
                'description' => 'Realisasi pembangunan jalan lingkungan tahun 2025.',
            ],
        ];

        $paymentRequests = [];

        foreach ($paymentDefinitions as $definition) {
            $budgetLine = $budgetLines[$definition['year']][$definition['budget_line_description']] ?? null;

            if (!$budgetLine) {
                continue;
            }

            $paymentRequest = ApbdesPaymentRequest::query()->updateOrCreate(
                ['request_number' => $definition['request_number']],
                [
                    'fiscal_year_id' => $years[$definition['year']]->id,
                    'budget_line_id' => $budgetLine->id,
                    'request_date' => $definition['request_date'],
                    'payee_name' => $definition['payee_name'],
                    'amount' => $definition['amount'],
                    'status' => $definition['status'],
                    'description' => $definition['description'],
                ]
            );

            $paymentRequests[$definition['request_number']] = $paymentRequest;
        }

        $realizations = [];

        foreach ($realizationDefinitions as $definition) {
            $budgetLine = $budgetLines[$definition['year']][$definition['budget_line_description']] ?? null;

            if (!$budgetLine) {
                continue;
            }

            $paymentRequestId = null;

            if ($definition['payment_request_number']) {
                $paymentRequestId = $paymentRequests[$definition['payment_request_number']]->id ?? null;
            }

            $realization = ApbdesRealization::query()->updateOrCreate(
                ['reference_number' => $definition['reference_number']],
                [
                    'fiscal_year_id' => $years[$definition['year']]->id,
                    'budget_line_id' => $budgetLine->id,
                    'payment_request_id' => $paymentRequestId,
                    'transaction_date' => $definition['transaction_date'],
                    'payment_method' => $definition['payment_method'],
                    'amount' => $definition['amount'],
                    'status' => $definition['status'],
                    'description' => $definition['description'],
                ]
            );

            $realizations[$definition['reference_number']] = $realization;
        }

        return [
            'payment_requests' => $paymentRequests,
            'realizations' => $realizations,
        ];
    }

    protected function seedBooks(array $years, array $realizations): void
    {
        $cashDefinitions = [
            ['reference_number' => 'KBK-2026-001', 'realization_reference' => 'REAL-2026-003', 'year' => 2026, 'entry_date' => '2026-01-28', 'description' => 'Pembayaran operasional kantor tunai', 'debit_amount' => 0, 'credit_amount' => 12500000, 'balance' => 87500000],
            ['reference_number' => 'KBK-2026-002', 'realization_reference' => null, 'year' => 2026, 'entry_date' => '2026-02-01', 'description' => 'Saldo awal kas bendahara', 'debit_amount' => 100000000, 'credit_amount' => 0, 'balance' => 100000000],
        ];

        $bankDefinitions = [
            ['reference_number' => 'BBN-2026-001', 'realization_reference' => 'REAL-2026-001', 'year' => 2026, 'entry_date' => '2026-02-10', 'bank_name' => 'Bank BJB', 'description' => 'Transfer penghasilan tetap perangkat desa', 'debit_amount' => 0, 'credit_amount' => 48000000, 'balance' => 452000000],
            ['reference_number' => 'BBN-2026-002', 'realization_reference' => 'REAL-2026-002', 'year' => 2026, 'entry_date' => '2026-03-20', 'bank_name' => 'Bank BJB', 'description' => 'Transfer termin pekerjaan jalan usaha tani', 'debit_amount' => 0, 'credit_amount' => 97500000, 'balance' => 354500000],
        ];

        $taxDefinitions = [
            ['reference_number' => 'BPJ-2026-001', 'realization_reference' => 'REAL-2026-001', 'year' => 2026, 'entry_date' => '2026-02-10', 'tax_type' => 'PPh 21', 'description' => 'Potongan PPh penghasilan tetap perangkat desa', 'tax_base_amount' => 48000000, 'withheld_amount' => 1200000, 'remitted_amount' => 1200000, 'status' => 'remitted'],
            ['reference_number' => 'BPJ-2026-002', 'realization_reference' => 'REAL-2026-002', 'year' => 2026, 'entry_date' => '2026-03-20', 'tax_type' => 'PPN', 'description' => 'Potongan PPN jasa konstruksi desa', 'tax_base_amount' => 97500000, 'withheld_amount' => 9750000, 'remitted_amount' => 0, 'status' => 'withheld'],
        ];

        foreach ($cashDefinitions as $definition) {
            ApbdesCashBookEntry::query()->updateOrCreate(
                ['reference_number' => $definition['reference_number']],
                [
                    'fiscal_year_id' => $years[$definition['year']]->id,
                    'realization_id' => $definition['realization_reference'] ? ($realizations[$definition['realization_reference']]->id ?? null) : null,
                    'entry_date' => $definition['entry_date'],
                    'description' => $definition['description'],
                    'debit_amount' => $definition['debit_amount'],
                    'credit_amount' => $definition['credit_amount'],
                    'balance' => $definition['balance'],
                ]
            );
        }

        foreach ($bankDefinitions as $definition) {
            ApbdesBankBookEntry::query()->updateOrCreate(
                ['reference_number' => $definition['reference_number']],
                [
                    'fiscal_year_id' => $years[$definition['year']]->id,
                    'realization_id' => $definition['realization_reference'] ? ($realizations[$definition['realization_reference']]->id ?? null) : null,
                    'entry_date' => $definition['entry_date'],
                    'bank_name' => $definition['bank_name'],
                    'description' => $definition['description'],
                    'debit_amount' => $definition['debit_amount'],
                    'credit_amount' => $definition['credit_amount'],
                    'balance' => $definition['balance'],
                ]
            );
        }

        foreach ($taxDefinitions as $definition) {
            ApbdesTaxBookEntry::query()->updateOrCreate(
                ['reference_number' => $definition['reference_number']],
                [
                    'fiscal_year_id' => $years[$definition['year']]->id,
                    'realization_id' => $definition['realization_reference'] ? ($realizations[$definition['realization_reference']]->id ?? null) : null,
                    'entry_date' => $definition['entry_date'],
                    'tax_type' => $definition['tax_type'],
                    'description' => $definition['description'],
                    'tax_base_amount' => $definition['tax_base_amount'],
                    'withheld_amount' => $definition['withheld_amount'],
                    'remitted_amount' => $definition['remitted_amount'],
                    'status' => $definition['status'],
                ]
            );
        }
    }

    protected function syncBudgetLineRealizations(array $budgetLines): void
    {
        foreach ($budgetLines as $yearLines) {
            foreach ($yearLines as $budgetLine) {
                $totalRealization = ApbdesRealization::query()
                    ->where('budget_line_id', $budgetLine->id)
                    ->sum('amount');

                $budgetLine->update([
                    'realized_amount' => $totalRealization,
                ]);
            }
        }
    }
}
