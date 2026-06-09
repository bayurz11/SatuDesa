<?php

namespace App\Http\Controllers;

use App\Domains\Budget\Models\ApbdesBudgetLine;
use App\Domains\Budget\Models\ApbdesFiscalYear;
use App\Domains\Budget\Models\ApbdesPaymentRequest;
use App\Domains\Budget\Models\ApbdesRealization;
use Illuminate\Contracts\View\View;

class PublicBudgetController extends Controller
{
    public function index(): View
    {
        $fiscalYear = ApbdesFiscalYear::query()
            ->with([
                'budgetLines.account:id,code,name,type',
                'budgetLines.fundingSource:id,code,name',
            ])
            ->orderByRaw("case when status = 'active' then 0 else 1 end")
            ->orderByDesc('year')
            ->first();

        $budgetLines = $fiscalYear?->budgetLines ?? collect();

        $summaryByType = collect([
            'pendapatan' => 'Pendapatan Desa',
            'belanja' => 'Belanja Desa',
            'pembiayaan' => 'Pembiayaan Desa',
        ])->map(function (string $label, string $type) use ($budgetLines) {
            $lines = $budgetLines->filter(fn ($line) => $line->account?->type === $type);

            return [
                'type' => $type,
                'label' => $label,
                'budget' => $lines->sum('amount'),
                'realized' => $lines->sum('realized_amount'),
                'line_count' => $lines->count(),
            ];
        })->values();

        $fundingSourceSummary = $budgetLines
            ->groupBy(fn ($line) => $line->fundingSource?->name ?? 'Belum ditetapkan')
            ->map(function ($lines, $name) {
                return [
                    'name' => $name,
                    'budget' => $lines->sum('amount'),
                    'realized' => $lines->sum('realized_amount'),
                    'count' => $lines->count(),
                ];
            })
            ->sortByDesc('budget')
            ->take(6)
            ->values();

        $latestRealizations = ApbdesRealization::query()
            ->with(['budgetLine.account:id,code,name', 'budgetLine:id,account_id,description'])
            ->when($fiscalYear, fn ($query) => $query->where('fiscal_year_id', $fiscalYear->id))
            ->latest('transaction_date')
            ->limit(6)
            ->get();

        $latestPaymentRequests = ApbdesPaymentRequest::query()
            ->when($fiscalYear, fn ($query) => $query->where('fiscal_year_id', $fiscalYear->id))
            ->latest('request_date')
            ->limit(6)
            ->get();

        $totalBudget = $budgetLines->sum('amount');
        $totalRealization = $budgetLines->sum('realized_amount');
        $realizationPercent = $totalBudget > 0 ? round(($totalRealization / $totalBudget) * 100, 1) : 0;

        $headlineMetrics = [
            [
                'label' => 'Total Anggaran',
                'value' => $totalBudget,
                'tone' => 'from-emerald-500/20 to-lime-400/20',
            ],
            [
                'label' => 'Total Realisasi',
                'value' => $totalRealization,
                'tone' => 'from-sky-500/20 to-cyan-400/20',
            ],
            [
                'label' => 'Serapan Anggaran',
                'value' => $realizationPercent . '%',
                'tone' => 'from-amber-500/20 to-orange-400/20',
            ],
        ];

        $topBudgetLines = ApbdesBudgetLine::query()
            ->with(['account:id,code,name', 'fundingSource:id,name'])
            ->when($fiscalYear, fn ($query) => $query->where('fiscal_year_id', $fiscalYear->id))
            ->orderByDesc('amount')
            ->limit(5)
            ->get();

        return view('pages.public.budgets', compact(
            'fiscalYear',
            'summaryByType',
            'fundingSourceSummary',
            'latestRealizations',
            'latestPaymentRequests',
            'totalBudget',
            'totalRealization',
            'realizationPercent',
            'headlineMetrics',
            'topBudgetLines',
        ));
    }
}
