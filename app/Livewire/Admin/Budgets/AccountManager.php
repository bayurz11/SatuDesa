<?php

namespace App\Livewire\Admin\Budgets;

use App\Domains\Budget\Models\ApbdesAccount;
use App\Domains\Village\Models\Village;
use App\Services\LoggerService;
use App\Shared\Traits\WithAlerts;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class AccountManager extends Component
{
    use WithAlerts;
    use WithPagination;

    public ?int $recordId = null;
    public string $search = '';
    public int $perPage = 10;
    public bool $showModal = false;
    public bool $isEditing = false;
    public string $parent_id = '';
    public string $code = '';
    public string $name = '';
    public string $type = 'pendapatan';
    public string $level = '1';
    public string $description = '';
    public bool $is_active = true;

    protected function rules(): array
    {
        $villageId = Village::query()->value('id');

        return [
            'parent_id' => ['nullable', 'exists:apbdes_accounts,id'],
            'code' => ['required', 'string', 'max:50', Rule::unique('apbdes_accounts', 'code')->ignore($this->recordId)->where(fn ($query) => $query->where('village_id', $villageId))],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:pendapatan,belanja,pembiayaan'],
            'level' => ['required', 'integer', 'min:1', 'max:5'],
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
        $this->resetForm();
        if ($id) {
            $this->loadRecord($id);
        }
        $this->showModal = true;
    }

    public function loadRecord(int $id): void
    {
        $record = ApbdesAccount::findOrFail($id);
        $this->recordId = $record->id;
        $this->parent_id = (string) ($record->parent_id ?? '');
        $this->code = $record->code;
        $this->name = $record->name;
        $this->type = $record->type;
        $this->level = (string) $record->level;
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
        $this->reset(['recordId', 'parent_id', 'code', 'name', 'description']);
        $this->type = 'pendapatan';
        $this->level = '1';
        $this->is_active = true;
        $this->showModal = false;
        $this->isEditing = false;
        $this->resetErrorBag();
    }

    public function save(): void
    {
        $validated = $this->validate();
        $villageId = Village::query()->value('id');

        $record = ApbdesAccount::updateOrCreate(
            ['id' => $this->recordId],
            [
                'village_id' => $villageId,
                'parent_id' => $validated['parent_id'] ?: null,
                'code' => $validated['code'],
                'name' => $validated['name'],
                'type' => $validated['type'],
                'level' => (int) $validated['level'],
                'description' => $validated['description'] ?: null,
                'is_active' => (bool) $validated['is_active'],
            ]
        );

        LoggerService::logUserAction($this->isEditing ? 'update' : 'create', 'ApbdesAccount', $record->id, ['code' => $record->code]);
        $this->showSuccessToast($this->isEditing ? 'Akun APBDes berhasil diperbarui.' : 'Akun APBDes berhasil ditambahkan.');
        $this->closeModal();
    }

    public function confirmDelete(int $id): void
    {
        $record = ApbdesAccount::findOrFail($id);
        $this->showConfirm('Hapus Akun APBDes', "Hapus akun {$record->code} - {$record->name}?", 'delete', ['id' => $id], 'Ya, hapus', 'Batal');
    }

    public function delete(array $params): void
    {
        ApbdesAccount::findOrFail($params['id'])->delete();
        $this->showSuccessToast('Akun APBDes berhasil dihapus.');
        $this->resetPage();
    }

    public function render()
    {
        $records = ApbdesAccount::query()
            ->with('parent:id,code,name')
            ->when($this->search, fn ($query) => $query->where('code', 'like', '%' . $this->search . '%')->orWhere('name', 'like', '%' . $this->search . '%'))
            ->orderBy('code')
            ->paginate($this->perPage);

        $parentAccounts = ApbdesAccount::query()->orderBy('code')->get(['id', 'code', 'name']);

        return view('livewire.admin.budgets.account-manager', compact('records', 'parentAccounts'));
    }
}
