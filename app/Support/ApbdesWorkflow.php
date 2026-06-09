<?php

namespace App\Support;

use App\Domains\Budget\Models\ApbdesAccount;
use App\Domains\Budget\Models\ApbdesBankBookEntry;
use App\Domains\Budget\Models\ApbdesBudgetLine;
use App\Domains\Budget\Models\ApbdesCashBookEntry;
use App\Domains\Budget\Models\ApbdesFiscalYear;
use App\Domains\Budget\Models\ApbdesFundingSource;
use App\Domains\Budget\Models\ApbdesPaymentRequest;
use App\Domains\Budget\Models\ApbdesRealization;
use App\Domains\Budget\Models\ApbdesTaxBookEntry;

class ApbdesWorkflow
{
    public static function definitions(): array
    {
        return [
            [
                'slug' => 'overview',
                'route_name' => 'budgets.index',
                'title' => 'Ringkasan APBDes',
                'short_title' => 'Ringkasan',
                'description' => 'Dashboard, cakupan pengelolaan, dan panduan urutan kerja modul APBDes.',
                'requirements' => [],
            ],
            [
                'slug' => 'fiscal-years',
                'route_name' => 'budgets.fiscal-years',
                'title' => 'Tahun Anggaran',
                'short_title' => 'Tahun Anggaran',
                'description' => 'Tetapkan tahun anggaran sebagai dasar semua data APBDes.',
                'requirements' => [],
            ],
            [
                'slug' => 'funding-sources',
                'route_name' => 'budgets.funding-sources',
                'title' => 'Sumber Dana',
                'short_title' => 'Sumber Dana',
                'description' => 'Susun sumber dana setelah tahun anggaran tersedia.',
                'requirements' => ['fiscal-years'],
            ],
            [
                'slug' => 'accounts',
                'route_name' => 'budgets.accounts',
                'title' => 'Akun APBDes',
                'short_title' => 'Akun APBDes',
                'description' => 'Bangun struktur akun APBDes setelah fondasi tahun dan sumber dana siap.',
                'requirements' => ['fiscal-years', 'funding-sources'],
            ],
            [
                'slug' => 'budget-lines',
                'route_name' => 'budgets.budget-lines',
                'title' => 'Baris Anggaran',
                'short_title' => 'Baris Anggaran',
                'description' => 'Input pagu per akun dan sumber dana pada tahun anggaran terkait.',
                'requirements' => ['fiscal-years', 'funding-sources', 'accounts'],
            ],
            [
                'slug' => 'operations',
                'route_name' => 'budgets.operations',
                'title' => 'Operasional APBDes',
                'short_title' => 'Operasional',
                'description' => 'Kelola SPP, realisasi, buku kas, buku bank, dan buku pajak setelah baris anggaran tersedia.',
                'requirements' => ['fiscal-years', 'funding-sources', 'accounts', 'budget-lines'],
            ],
        ];
    }

    public static function sections(): array
    {
        $definitions = self::definitions();
        $completion = self::completionStatus();
        $labelMap = collect($definitions)->pluck('short_title', 'slug')->all();

        return collect($definitions)
            ->map(function (array $section, int $index) use ($completion, $labelMap) {
                $missingRequirements = collect($section['requirements'])
                    ->filter(fn (string $slug) => !($completion[$slug] ?? false))
                    ->values()
                    ->all();

                $section['step'] = $index + 1;
                $section['is_complete'] = $completion[$section['slug']] ?? false;
                $section['is_unlocked'] = count($missingRequirements) === 0;
                $section['requirement_labels'] = collect($section['requirements'])
                    ->map(fn (string $slug) => $labelMap[$slug] ?? $slug)
                    ->all();
                $section['missing_requirements'] = $missingRequirements;
                $section['missing_labels'] = collect($missingRequirements)
                    ->map(fn (string $slug) => $labelMap[$slug] ?? $slug)
                    ->all();

                return $section;
            })
            ->all();
    }

    public static function section(string $slug): ?array
    {
        return collect(self::sections())->firstWhere('slug', $slug);
    }

    public static function resolveAccessibleSlug(string $requestedSlug): string
    {
        $requested = self::section($requestedSlug);

        if ($requested === null) {
            return 'overview';
        }

        if ($requested['is_unlocked']) {
            return $requestedSlug;
        }

        $firstMissing = $requested['missing_requirements'][0] ?? null;

        return $firstMissing ?: 'overview';
    }

    protected static function completionStatus(): array
    {
        return [
            'overview' => true,
            'fiscal-years' => ApbdesFiscalYear::query()->count() > 0,
            'funding-sources' => ApbdesFundingSource::query()->count() > 0,
            'accounts' => ApbdesAccount::query()->where('is_active', true)->count() > 0,
            'budget-lines' => ApbdesBudgetLine::query()->count() > 0,
            'operations' => self::hasOperationsData(),
        ];
    }

    protected static function hasOperationsData(): bool
    {
        return ApbdesPaymentRequest::query()->exists()
            || ApbdesRealization::query()->exists()
            || ApbdesCashBookEntry::query()->exists()
            || ApbdesBankBookEntry::query()->exists()
            || ApbdesTaxBookEntry::query()->exists();
    }
}
