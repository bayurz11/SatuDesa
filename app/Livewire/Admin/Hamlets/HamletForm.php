<?php

namespace App\Livewire\Admin\Hamlets;

use App\Domains\Hamlet\Models\Hamlet;
use App\Domains\Village\Models\Village;
use App\Livewire\Concerns\AuthorizesPermissions;
use App\Services\LoggerService;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class HamletForm extends Component
{
    use AuthorizesPermissions;

    public ?int $hamletId = null;
    public string $name = '';
    public string $code = '';
    public bool $showModal = false;
    public bool $isEditing = false;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255', Rule::unique('hamlets', 'code')->ignore($this->hamletId)],
        ];
    }

    #[On('openHamletForm')]
    public function openModal(?int $hamletId = null): void
    {
        $this->authorizePermission($hamletId ? 'hamlets.edit' : 'hamlets.create');
        $this->resetForm();

        if ($hamletId) {
            $this->loadHamlet($hamletId);
        }

        $this->showModal = true;
    }

    public function loadHamlet(int $hamletId): void
    {
        $this->authorizePermission('hamlets.edit');
        $hamlet = Hamlet::findOrFail($hamletId);

        $this->hamletId = $hamlet->id;
        $this->name = $hamlet->name;
        $this->code = $hamlet->code ?? '';
        $this->isEditing = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->reset(['hamletId', 'name', 'code']);
        $this->showModal = false;
        $this->isEditing = false;
        $this->resetErrorBag();
    }

    public function save(): void
    {
        $this->authorizeCrudAction($this->isEditing, 'hamlets.create', 'hamlets.edit');
        $validated = $this->validate();
        $villageId = Village::query()->value('id');

        $hamlet = Hamlet::updateOrCreate(
            ['id' => $this->hamletId],
            [
                'village_id' => $villageId,
                'name' => $validated['name'],
                'code' => $validated['code'] ?: null,
            ]
        );

        LoggerService::logUserAction($this->isEditing ? 'update' : 'create', 'Hamlet', $hamlet->id, [
            'name' => $hamlet->name,
            'code' => $hamlet->code,
        ]);

        session()->flash('message', $this->isEditing ? 'Data dusun berhasil diperbarui.' : 'Data dusun berhasil ditambahkan.');

        $this->closeModal();
        $this->dispatch('hamletSaved');
    }

    public function render()
    {
        $this->authorizePermission('hamlets.view');
        return view('livewire.admin.hamlets.hamlet-form');
    }
}
