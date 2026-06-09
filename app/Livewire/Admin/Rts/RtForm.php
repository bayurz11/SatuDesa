<?php

namespace App\Livewire\Admin\Rts;

use App\Domains\Hamlet\Models\Hamlet;
use App\Domains\Rt\Models\Rt;
use App\Domains\Rw\Models\Rw;
use App\Domains\Village\Models\Village;
use App\Services\LoggerService;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class RtForm extends Component
{
    public ?int $rtId = null;
    public string $hamlet_id = '';
    public string $rw_id = '';
    public string $number = '';
    public bool $showModal = false;
    public bool $isEditing = false;

    protected function rules(): array
    {
        return [
            'hamlet_id' => ['required', 'exists:hamlets,id'],
            'rw_id' => ['required', 'exists:rws,id'],
            'number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('rts', 'number')->where(fn ($query) => $query->where('rw_id', $this->rw_id))->ignore($this->rtId),
            ],
        ];
    }

    #[On('openRtForm')]
    public function openModal(?int $rtId = null): void
    {
        $this->resetForm();

        if ($rtId) {
            $this->loadRt($rtId);
        }

        $this->showModal = true;
    }

    public function loadRt(int $rtId): void
    {
        $rt = Rt::with('rw')->findOrFail($rtId);

        $this->rtId = $rt->id;
        $this->rw_id = (string) $rt->rw_id;
        $this->hamlet_id = (string) $rt->rw?->hamlet_id;
        $this->number = $rt->number;
        $this->isEditing = true;
    }

    public function updatedHamletId($value): void
    {
        $this->hamlet_id = (string) $value;
        $this->rw_id = '';
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->reset(['rtId', 'hamlet_id', 'rw_id', 'number']);
        $this->showModal = false;
        $this->isEditing = false;
        $this->resetErrorBag();
    }

    public function save(): void
    {
        $validated = $this->validate();
        $villageId = Village::query()->value('id');

        $rt = Rt::updateOrCreate(
            ['id' => $this->rtId],
            [
                'village_id' => $villageId,
                'rw_id' => $validated['rw_id'],
                'number' => $validated['number'],
            ]
        );

        LoggerService::logUserAction($this->isEditing ? 'update' : 'create', 'Rt', $rt->id, [
            'rw_id' => $rt->rw_id,
            'number' => $rt->number,
        ]);

        session()->flash('message', $this->isEditing ? 'Data RT berhasil diperbarui.' : 'Data RT berhasil ditambahkan.');

        $this->closeModal();
        $this->dispatch('rtSaved');
    }

    public function render()
    {
        $hamlets = Hamlet::query()->orderBy('name')->get(['id', 'name']);
        $rws = Rw::query()
            ->when($this->hamlet_id !== '', fn ($query) => $query->where('hamlet_id', $this->hamlet_id))
            ->orderBy('number')
            ->get(['id', 'hamlet_id', 'number']);

        return view('livewire.admin.rts.rt-form', compact('hamlets', 'rws'));
    }
}
