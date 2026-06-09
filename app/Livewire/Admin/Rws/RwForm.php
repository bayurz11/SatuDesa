<?php

namespace App\Livewire\Admin\Rws;

use App\Domains\Hamlet\Models\Hamlet;
use App\Domains\Rw\Models\Rw;
use App\Domains\Village\Models\Village;
use App\Services\LoggerService;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class RwForm extends Component
{
    public ?int $rwId = null;
    public string $hamlet_id = '';
    public string $number = '';
    public bool $showModal = false;
    public bool $isEditing = false;

    protected function rules(): array
    {
        return [
            'hamlet_id' => ['required', 'exists:hamlets,id'],
            'number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('rws', 'number')->where(fn ($query) => $query->where('hamlet_id', $this->hamlet_id))->ignore($this->rwId),
            ],
        ];
    }

    #[On('openRwForm')]
    public function openModal(?int $rwId = null): void
    {
        $this->resetForm();

        if ($rwId) {
            $this->loadRw($rwId);
        }

        $this->showModal = true;
    }

    public function loadRw(int $rwId): void
    {
        $rw = Rw::findOrFail($rwId);

        $this->rwId = $rw->id;
        $this->hamlet_id = (string) $rw->hamlet_id;
        $this->number = $rw->number;
        $this->isEditing = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->reset(['rwId', 'hamlet_id', 'number']);
        $this->showModal = false;
        $this->isEditing = false;
        $this->resetErrorBag();
    }

    public function save(): void
    {
        $validated = $this->validate();
        $villageId = Village::query()->value('id');

        $rw = Rw::updateOrCreate(
            ['id' => $this->rwId],
            [
                'village_id' => $villageId,
                'hamlet_id' => $validated['hamlet_id'],
                'number' => $validated['number'],
            ]
        );

        LoggerService::logUserAction($this->isEditing ? 'update' : 'create', 'Rw', $rw->id, [
            'hamlet_id' => $rw->hamlet_id,
            'number' => $rw->number,
        ]);

        session()->flash('message', $this->isEditing ? 'Data RW berhasil diperbarui.' : 'Data RW berhasil ditambahkan.');

        $this->closeModal();
        $this->dispatch('rwSaved');
    }

    public function render()
    {
        $hamlets = Hamlet::query()->orderBy('name')->get(['id', 'name']);

        return view('livewire.admin.rws.rw-form', compact('hamlets'));
    }
}
