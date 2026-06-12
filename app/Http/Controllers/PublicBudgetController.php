<?php

namespace App\Http\Controllers;

use App\Domains\Budget\Models\ApbdesBudgetLine;
use App\Domains\Budget\Models\ApbdesFiscalYear;
use App\Domains\Budget\Models\ApbdesPaymentRequest;
use App\Domains\Budget\Models\ApbdesRealization;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class PublicBudgetController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('q'));

        $fiscalYear = ApbdesFiscalYear::query()
            ->with([
                'budgetLines.account:id,code,name,type',
                'budgetLines.fundingSource:id,code,name',
            ])
            ->orderByRaw("case when status = 'active' then 0 else 1 end")
            ->orderByDesc('year')
            ->first();

        $budgetLines = ($fiscalYear?->budgetLines ?? collect())
            ->when($search !== '', function ($collection) use ($search) {
                return $collection->filter(function ($line) use ($search) {
                    $haystacks = [
                        $line->account?->code,
                        $line->account?->name,
                        $line->description,
                        $line->fundingSource?->name,
                    ];

                    foreach ($haystacks as $haystack) {
                        if ($haystack !== null && stripos((string) $haystack, $search) !== false) {
                            return true;
                        }
                    }

                    return false;
                })->values();
            });

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
            ->when($search !== '', function ($query) use ($search) {
                $query->whereHas('budgetLine', function ($budgetLineQuery) use ($search) {
                    $budgetLineQuery
                        ->where('description', 'like', '%' . $search . '%')
                        ->orWhereHas('account', function ($accountQuery) use ($search) {
                            $accountQuery
                                ->where('code', 'like', '%' . $search . '%')
                                ->orWhere('name', 'like', '%' . $search . '%');
                        });
                });
            })
            ->latest('transaction_date')
            ->limit(6)
            ->get();

        $latestPaymentRequests = ApbdesPaymentRequest::query()
            ->when($fiscalYear, fn ($query) => $query->where('fiscal_year_id', $fiscalYear->id))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($paymentQuery) use ($search) {
                    $paymentQuery
                        ->where('request_number', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('requested_by', 'like', '%' . $search . '%');
                });
            })
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
            'search',
        ));
    }
}
