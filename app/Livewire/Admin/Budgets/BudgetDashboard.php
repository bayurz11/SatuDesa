<?php

namespace App\Livewire\Admin\Budgets;

use App\Domains\Budget\Models\ApbdesAccount;
use App\Domains\Budget\Models\ApbdesBudgetLine;
use App\Domains\Budget\Models\ApbdesFiscalYear;
use App\Domains\Budget\Models\ApbdesFundingSource;
use App\Support\ApbdesWorkflow;
use Livewire\Component;

class BudgetDashboard extends Component
{
    public function render()
    {
        $budgetLines = ApbdesBudgetLine::query()->with(['account:id,type', 'fundingSource:id,name']);

        $stats = [
            'fiscal_years' => ApbdesFiscalYear::query()->count(),
            'active_years' => ApbdesFiscalYear::query()->where('status', 'active')->count(),
            'funding_sources' => ApbdesFundingSource::query()->where('is_active', true)->count(),
            'accounts' => ApbdesAccount::query()->where('is_active', true)->count(),
            'total_budget' => (clone $budgetLines)->sum('amount'),
            'total_realization' => (clone $budgetLines)->sum('realized_amount'),
        ];

        $fiscalYears = ApbdesFiscalYear::query()
            ->withCount('budgetLines')
            ->withSum('budgetLines', 'amount')
            ->withSum('budgetLines', 'realized_amount')
            ->orderByDesc('year')
            ->get();

        $accountTypeSummary = collect(['pendapatan', 'belanja', 'pembiayaan'])
            ->map(function (string $type) {
                $lines = ApbdesBudgetLine::query()
                    ->whereHas('account', fn ($query) => $query->where('type', $type));

                return [
                    'type' => $type,
                    'label' => match ($type) {
                        'pendapatan' => 'Pendapatan Desa',
                        'belanja' => 'Belanja Desa',
                        default => 'Pembiayaan Desa',
                    },
                    'line_count' => (clone $lines)->count(),
                    'amount' => (clone $lines)->sum('amount'),
                    'realized_amount' => (clone $lines)->sum('realized_amount'),
                ];
            });

        $fundingSources = ApbdesFundingSource::query()
            ->withCount('budgetLines')
            ->withSum('budgetLines', 'amount')
            ->withSum('budgetLines', 'realized_amount')
            ->orderBy('name')
            ->get();

        $workflowSections = collect(ApbdesWorkflow::sections())
            ->reject(fn (array $section) => $section['slug'] === 'overview')
            ->values()
            ->all();

        return view('livewire.admin.budgets.budget-dashboard', compact(
            'stats',
            'fiscalYears',
            'accountTypeSummary',
            'fundingSources',
            'workflowSections',
        ));
    }
}
