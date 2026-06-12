<?php

namespace App\Livewire\Admin\Budgets;

use App\Domains\Budget\Models\ApbdesFiscalYear;
use App\Domains\Village\Models\Village;
use App\Livewire\Concerns\AuthorizesPermissions;
use App\Services\LoggerService;
use App\Shared\Traits\WithAlerts;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class FiscalYearManager extends Component
{
    use WithAlerts, AuthorizesPermissions;
    use WithPagination;

    public ?int $recordId = null;
    public string $search = '';
    public int $perPage = 10;
    public bool $showModal = false;
    public bool $isEditing = false;
    public string $year = '';
    public string $title = '';
    public string $status = 'draft';
    public string $start_date = '';
    public string $end_date = '';
    public string $apbdes_regulation_number = '';
    public string $apbdes_regulation_date = '';
    public string $notes = '';

    protected function rules(): array
    {
        $villageId = Village::query()->value('id');

        return [
            'year' => ['required', 'integer', 'digits:4', Rule::unique('apbdes_fiscal_years', 'year')->ignore($this->recordId)->where(fn ($query) => $query->where('village_id', $villageId))],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:draft,active,revised,reported'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'apbdes_regulation_number' => ['nullable', 'string', 'max:255'],
            'apbdes_regulation_date' => ['nullable', 'date'],
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
        $record = ApbdesFiscalYear::findOrFail($id);

        $this->recordId = $record->id;
        $this->year = (string) $record->year;
        $this->title = $record->title;
        $this->status = $record->status;
        $this->start_date = optional($record->start_date)->format('Y-m-d') ?? '';
        $this->end_date = optional($record->end_date)->format('Y-m-d') ?? '';
        $this->apbdes_regulation_number = $record->apbdes_regulation_number ?? '';
        $this->apbdes_regulation_date = optional($record->apbdes_regulation_date)->format('Y-m-d') ?? '';
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
        $this->reset([
            'recordId', 'year', 'title', 'status', 'start_date', 'end_date',
            'apbdes_regulation_number', 'apbdes_regulation_date', 'notes',
        ]);
        $this->status = 'draft';
        $this->showModal = false;
        $this->isEditing = false;
        $this->resetErrorBag();
    }

    public function save(): void
    {
        $this->authorizeCrudAction($this->isEditing, 'budgets.create', 'budgets.edit');
        $validated = $this->validate();
        $villageId = Village::query()->value('id');

        if ($validated['status'] === 'active') {
            ApbdesFiscalYear::query()
                ->where('village_id', $villageId)
                ->where('id', '!=', $this->recordId)
                ->update(['status' => 'draft']);
        }

        $record = ApbdesFiscalYear::updateOrCreate(
            ['id' => $this->recordId],
            [
                'village_id' => $villageId,
                'year' => (int) $validated['year'],
                'title' => $validated['title'],
                'status' => $validated['status'],
                'start_date' => $validated['start_date'] ?: null,
                'end_date' => $validated['end_date'] ?: null,
                'apbdes_regulation_number' => $validated['apbdes_regulation_number'] ?: null,
                'apbdes_regulation_date' => $validated['apbdes_regulation_date'] ?: null,
                'notes' => $validated['notes'] ?: null,
            ]
        );

        LoggerService::logUserAction($this->isEditing ? 'update' : 'create', 'ApbdesFiscalYear', $record->id, [
            'year' => $record->year,
            'status' => $record->status,
        ]);

        $this->showSuccessToast($this->isEditing ? 'Tahun anggaran berhasil diperbarui.' : 'Tahun anggaran berhasil ditambahkan.');
        $this->closeModal();
    }

    public function confirmDelete(int $id): void
    {
        $this->authorizePermission('budgets.delete');
        $record = ApbdesFiscalYear::findOrFail($id);

        $this->showConfirm(
            'Hapus Tahun Anggaran',
            "Hapus {$record->title}? Tindakan ini tidak dapat dibatalkan.",
            'delete',
            ['id' => $id],
            'Ya, hapus',
            'Batal'
        );
    }

    public function delete(array $params): void
    {
        $this->authorizePermission('budgets.delete');
        $record = ApbdesFiscalYear::findOrFail($params['id']);
        $record->delete();
        $this->showSuccessToast('Tahun anggaran berhasil dihapus.');
        $this->resetPage();
    }

    public function render()
    {
        $this->authorizePermission('budgets.view');
        $records = ApbdesFiscalYear::query()
            ->when($this->search, fn ($query) => $query->where('title', 'like', '%' . $this->search . '%')->orWhere('year', 'like', '%' . $this->search . '%'))
            ->latest('year')
            ->paginate($this->perPage);

        return view('livewire.admin.budgets.fiscal-year-manager', compact('records'));
    }
}
