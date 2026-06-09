<?php

namespace App\Livewire\Admin\Households;

use App\Domains\Citizen\Models\Citizen;
use App\Domains\Hamlet\Models\Hamlet;
use App\Domains\Household\Models\Household;
use App\Domains\Rt\Models\Rt;
use App\Domains\Rw\Models\Rw;
use App\Domains\Village\Models\Village;
use App\Services\LoggerService;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class HouseholdForm extends Component
{
    public ?int $householdId = null;
    public string $no_kk = '';
    public string $hamlet_id = '';
    public string $rw_id = '';
    public string $rt_id = '';
    public string $head_citizen_id = '';
    public string $address = '';
    public bool $showModal = false;
    public bool $isEditing = false;

    protected function rules(): array
    {
        return [
            'no_kk' => ['required', 'digits:16', Rule::unique('households', 'no_kk')->ignore($this->householdId)],
            'hamlet_id' => ['required', 'exists:hamlets,id'],
            'rw_id' => ['required', 'exists:rws,id'],
            'rt_id' => ['required', 'exists:rts,id'],
            'head_citizen_id' => ['nullable', 'exists:citizens,id'],
            'address' => ['required', 'string'],
        ];
    }

    #[On('openHouseholdForm')]
    public function openModal(?int $householdId = null): void
    {
        $this->resetForm();

        if ($householdId) {
            $this->loadHousehold($householdId);
        }

        $this->showModal = true;
    }

    #[On('hamletSaved')]
    #[On('rwSaved')]
    #[On('rtSaved')]
    public function refreshAdministrativeReferences(): void
    {
        // Re-render to pick up newly created hamlet/RW/RT options.
    }

    public function loadHousehold(int $householdId): void
    {
        $household = Household::findOrFail($householdId);

        $this->householdId = $household->id;
        $this->no_kk = $household->no_kk;
        $this->hamlet_id = (string) $household->hamlet_id;
        $this->rw_id = (string) $household->rw_id;
        $this->rt_id = (string) $household->rt_id;
        $this->head_citizen_id = (string) ($household->head_citizen_id ?? '');
        $this->address = $household->address;
        $this->isEditing = true;
    }

    public function updatedHamletId($value): void
    {
        $this->hamlet_id = (string) $value;
        $this->rw_id = '';
        $this->rt_id = '';
    }

    public function updatedRwId($value): void
    {
        $this->rw_id = (string) $value;
        $this->rt_id = '';
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->reset([
            'householdId',
            'no_kk',
            'hamlet_id',
            'rw_id',
            'rt_id',
            'head_citizen_id',
            'address',
        ]);

        $this->showModal = false;
        $this->isEditing = false;
        $this->resetErrorBag();
    }

    public function save(): void
    {
        $validated = $this->validate();
        $villageId = Village::query()->value('id');

        $household = Household::updateOrCreate(
            ['id' => $this->householdId],
            [
                'village_id' => $villageId,
                'no_kk' => $validated['no_kk'],
                'hamlet_id' => $validated['hamlet_id'],
                'rw_id' => $validated['rw_id'],
                'rt_id' => $validated['rt_id'],
                'head_citizen_id' => $validated['head_citizen_id'] ?: null,
                'address' => $validated['address'],
            ]
        );

        if (!empty($validated['head_citizen_id'])) {
            Citizen::whereKey($validated['head_citizen_id'])->update([
                'household_id' => $household->id,
                'family_relationship' => 'Kepala Keluarga',
            ]);
        }

        LoggerService::logUserAction($this->isEditing ? 'update' : 'create', 'Household', $household->id, [
            'no_kk' => $household->no_kk,
            'head_citizen_id' => $household->head_citizen_id,
        ]);

        session()->flash('message', $this->isEditing ? 'Data KK berhasil diperbarui.' : 'Data KK berhasil ditambahkan.');

        $this->closeModal();
        $this->dispatch('householdSaved');
    }

    public function render()
    {
        $hamlets = Hamlet::query()->orderBy('name')->get(['id', 'name']);
        $rws = Rw::query()
            ->when($this->hamlet_id !== '', fn ($query) => $query->where('hamlet_id', $this->hamlet_id))
            ->orderBy('number')
            ->get(['id', 'hamlet_id', 'number']);
        $rts = Rt::query()
            ->when($this->rw_id !== '', fn ($query) => $query->where('rw_id', $this->rw_id))
            ->orderBy('number')
            ->get(['id', 'rw_id', 'number']);
        $citizens = Citizen::query()
            ->orderBy('full_name')
            ->get(['id', 'nik', 'full_name', 'household_id']);

        return view('livewire.admin.households.household-form', compact('hamlets', 'rws', 'rts', 'citizens'));
    }
}
