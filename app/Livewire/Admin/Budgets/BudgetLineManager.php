<?php

namespace App\Livewire\Admin\Budgets;

use App\Domains\Budget\Models\ApbdesAccount;
use App\Domains\Budget\Models\ApbdesBudgetLine;
use App\Domains\Budget\Models\ApbdesFiscalYear;
use App\Domains\Budget\Models\ApbdesFundingSource;
use App\Livewire\Concerns\AuthorizesPermissions;
use App\Services\LoggerService;
use App\Shared\Traits\WithAlerts;
use Livewire\Component;
use Livewire\WithPagination;

class BudgetLineManager extends Component
{
    use WithAlerts, AuthorizesPermissions;
    use WithPagination;

    public ?int $recordId = null;
    public string $search = '';
    public int $perPage = 10;
    public bool $showModal = false;
    public bool $isEditing = false;
    public string $fiscal_year_id = '';
    public string $account_id = '';
    public string $funding_source_id = '';
    public string $description = '';
    public string $amount = '0';
    public string $realized_amount = '0';
    public string $sort_order = '0';
    public string $notes = '';

    protected function rules(): array
    {
        return [
            'fiscal_year_id' => ['required', 'exists:apbdes_fiscal_years,id'],
            'account_id' => ['required', 'exists:apbdes_accounts,id'],
            'funding_source_id' => ['nullable', 'exists:apbdes_funding_sources,id'],
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'realized_amount' => ['nullable', 'numeric', 'min:0'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openModal(?int $id = null): void
    {
        $this->authorizePermission($id ? 'budgets.edit' : 'budgets.create');
        $this->resetForm();
        if ($id) {
            $this->loadRecord($id);
        }
        $this->showModal = true;
    }

    public function loadRecord(int $id): void
    {
        $this->authorizePermission('budgets.edit');
        $record = ApbdesBudgetLine::findOrFail($id);
        $this->recordId = $record->id;
        $this->fiscal_year_id = (string) $record->fiscal_year_id;
        $this->account_id = (string) $record->account_id;
        $this->funding_source_id = (string) ($record->funding_source_id ?? '');
        $this->description = $record->description;
        $this->amount = (string) $record->amount;
        $this->realized_amount = (string) $record->realized_amount;
        $this->sort_order = (string) $record->sort_order;
        $this->notes = $record->notes ?? '';
        $this->isEditing = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->reset(['recordId', 'fiscal_year_id', 'account_id', 'funding_source_id', 'description', 'notes']);
        $this->amount = '0';
        $this->realized_amount = '0';
        $this->sort_order = '0';
        $this->showModal = false;
        $this->isEditing = false;
        $this->resetErrorBag();
    }

    public function save(): void
    {
        $this->authorizeCrudAction($this->isEditing, 'budgets.create', 'budgets.edit');
        $validated = $this->validate();

        $record = ApbdesBudgetLine::updateOrCreate(
            ['id' => $this->recordId],
            [
                'fiscal_year_id' => $validated['fiscal_year_id'],
                'account_id' => $validated['account_id'],
                'funding_source_id' => $validated['funding_source_id'] ?: null,
                'description' => $validated['description'],
                'amount' => $validated['amount'],
                'realized_amount' => $validated['realized_amount'] ?: 0,
                'sort_order' => $validated['sort_order'] ?: 0,
                'notes' => $validated['notes'] ?: null,
            ]
        );

        LoggerService::logUserAction($this->isEditing ? 'update' : 'create', 'ApbdesBudgetLine', $record->id, ['description' => $record->description]);
        $this->showSuccessToast($this->isEditing ? 'Baris anggaran berhasil diperbarui.' : 'Baris anggaran berhasil ditambahkan.');
        $this->closeModal();
    }

    public function confirmDelete(int $id): void
    {
        $this->authorizePermission('budgets.delete');
        $record = ApbdesBudgetLine::findOrFail($id);
        $this->showConfirm('Hapus Baris Anggaran', "Hapus baris anggaran {$record->description}?", 'delete', ['id' => $id], 'Ya, hapus', 'Batal');
    }

    public function delete(array $params): void
    {
        $this->authorizePermission('budgets.delete');
        ApbdesBudgetLine::findOrFail($params['id'])->delete();
        $this->showSuccessToast('Baris anggaran berhasil dihapus.');
        $this->resetPage();
    }

    public function render()
    {
        $this->authorizePermission('budgets.view');
        $records = ApbdesBudgetLine::query()
            ->with(['fiscalYear:id,year,title', 'account:id,code,name,type', 'fundingSource:id,code,name'])
            ->when($this->search, function ($query) {
                $query->where('description', 'like', '%' . $this->search . '%')
                    ->orWhereHas('account', fn ($accountQuery) => $accountQuery->where('code', 'like', '%' . $this->search . '%')->orWhere('name', 'like', '%' . $this->search . '%'))
                    ->orWhereHas('fiscalYear', fn ($yearQuery) => $yearQuery->where('title', 'like', '%' . $this->search . '%'));
            })
            ->latest('updated_at')
            ->paginate($this->perPage);

        $fiscalYears = ApbdesFiscalYear::query()->orderByDesc('year')->get(['id', 'year', 'title']);
        $accounts = ApbdesAccount::query()->where('is_active', true)->orderBy('code')->get(['id', 'code', 'name', 'type']);
        $fundingSources = ApbdesFundingSource::query()->where('is_active', true)->orderBy('name')->get(['id', 'code', 'name']);

        return view('livewire.admin.budgets.budget-line-manager', compact('records', 'fiscalYears', 'accounts', 'fundingSources'));
    }
}
