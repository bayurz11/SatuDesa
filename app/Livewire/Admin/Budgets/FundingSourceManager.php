<?php

namespace App\Livewire\Admin\Budgets;

use App\Domains\Budget\Models\ApbdesFundingSource;
use App\Domains\Village\Models\Village;
use App\Livewire\Concerns\AuthorizesPermissions;
use App\Services\LoggerService;
use App\Shared\Traits\WithAlerts;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class FundingSourceManager extends Component
{
    use WithAlerts, AuthorizesPermissions;
    use WithPagination;

    public ?int $recordId = null;
    public string $search = '';
    public int $perPage = 10;
    public bool $showModal = false;
    public bool $isEditing = false;
    public string $code = '';
    public string $name = '';
    public string $description = '';
    public bool $is_active = true;

    protected function rules(): array
    {
        $villageId = Village::query()->value('id');

        return [
            'code' => ['required', 'string', 'max:50', Rule::unique('apbdes_funding_sources', 'code')->ignore($this->recordId)->where(fn ($query) => $query->where('village_id', $villageId))],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
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
        $record = ApbdesFundingSource::findOrFail($id);
        $this->recordId = $record->id;
        $this->code = $record->code;
        $this->name = $record->name;
        $this->description = $record->description ?? '';
        $this->is_active = (bool) $record->is_active;
        $this->isEditing = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->reset(['recordId', 'code', 'name', 'description']);
        $this->is_active = true;
        $this->showModal = false;
        $this->isEditing = false;
        $this->resetErrorBag();
    }

    public function save(): void
    {
        $this->authorizeCrudAction($this->isEditing, 'budgets.create', 'budgets.edit');
        $validated = $this->validate();
        $villageId = Village::query()->value('id');

        $record = ApbdesFundingSource::updateOrCreate(
            ['id' => $this->recordId],
            [
                'village_id' => $villageId,
                'code' => strtoupper($validated['code']),
                'name' => $validated['name'],
                'description' => $validated['description'] ?: null,
                'is_active' => (bool) $validated['is_active'],
            ]
        );

        LoggerService::logUserAction($this->isEditing ? 'update' : 'create', 'ApbdesFundingSource', $record->id, ['code' => $record->code]);

        $this->showSuccessToast($this->isEditing ? 'Sumber dana berhasil diperbarui.' : 'Sumber dana berhasil ditambahkan.');
        $this->closeModal();
    }

    public function confirmDelete(int $id): void
    {
        $this->authorizePermission('budgets.delete');
        $record = ApbdesFundingSource::findOrFail($id);
        $this->showConfirm('Hapus Sumber Dana', "Hapus sumber dana {$record->name}?", 'delete', ['id' => $id], 'Ya, hapus', 'Batal');
    }

    public function delete(array $params): void
    {
        $this->authorizePermission('budgets.delete');
        ApbdesFundingSource::findOrFail($params['id'])->delete();
        $this->showSuccessToast('Sumber dana berhasil dihapus.');
        $this->resetPage();
    }

    public function render()
    {
        $this->authorizePermission('budgets.view');
        $records = ApbdesFundingSource::query()
            ->when($this->search, fn ($query) => $query->where('code', 'like', '%' . $this->search . '%')->orWhere('name', 'like', '%' . $this->search . '%'))
            ->latest('updated_at')
            ->paginate($this->perPage);

        return view('livewire.admin.budgets.funding-source-manager', compact('records'));
    }
}
