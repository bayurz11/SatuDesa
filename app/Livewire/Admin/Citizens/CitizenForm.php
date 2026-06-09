<?php

namespace App\Livewire\Admin\Citizens;

use App\Domains\Citizen\Models\Citizen;
use App\Domains\Hamlet\Models\Hamlet;
use App\Domains\Household\Models\Household;
use App\Domains\Rt\Models\Rt;
use App\Domains\Rw\Models\Rw;
use App\Services\LoggerService;
use App\Support\CitizenReferenceData;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class CitizenForm extends Component
{
    public ?int $citizenId = null;
    public ?int $household_id = null;
    public string $nik = '';
    public string $full_name = '';
    public string $gender = 'L';
    public string $birth_place = '';
    public string $birth_date = '';
    public string $religion = '';
    public string $marital_status = '';
    public string $family_relationship = '';
    public string $occupation = '';
    public string $education = '';
    public string $citizenship = 'WNI';
    public string $address = '';
    public string $status = 'active';
    public bool $is_head_of_household = false;
    public string $hamlet_id = '';
    public string $rw_id = '';
    public string $rt_id = '';
    public bool $showModal = false;
    public bool $isEditing = false;

    protected function rules(): array
    {
        return [
            'household_id' => ['nullable', 'exists:households,id'],
            'nik' => ['required', 'digits:16', Rule::unique('citizens', 'nik')->ignore($this->citizenId)],
            'full_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:50'],
            'birth_place' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'religion' => ['nullable', 'string', 'max:255'],
            'marital_status' => ['nullable', 'string', 'max:255'],
            'family_relationship' => ['nullable', Rule::in(CitizenReferenceData::familyRelationshipOptions())],
            'occupation' => ['nullable', 'string', 'max:255'],
            'education' => ['nullable', 'string', 'max:255'],
            'citizenship' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'status' => ['required', 'string', 'max:50'],
            'hamlet_id' => ['nullable', 'exists:hamlets,id'],
            'rw_id' => ['nullable', 'exists:rws,id'],
            'rt_id' => ['nullable', 'exists:rts,id'],
        ];
    }

    #[On('openCitizenForm')]
    public function openModal(?int $citizenId = null): void
    {
        $this->resetForm();

        if ($citizenId) {
            $this->loadCitizen($citizenId);
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

    public function loadCitizen(int $citizenId): void
    {
        $citizen = Citizen::findOrFail($citizenId);

        $this->citizenId = $citizen->id;
        $this->household_id = $citizen->household_id;
        $this->nik = $citizen->nik;
        $this->full_name = $citizen->full_name;
        $this->gender = $citizen->gender;
        $this->birth_place = $citizen->birth_place ?? '';
        $this->birth_date = $citizen->birth_date?->format('Y-m-d') ?? '';
        $this->religion = $citizen->religion ?? '';
        $this->marital_status = $citizen->marital_status ?? '';
        $this->family_relationship = $citizen->family_relationship ?? '';
        $this->occupation = $citizen->occupation ?? '';
        $this->education = $citizen->education ?? '';
        $this->citizenship = $citizen->citizenship ?? 'WNI';
        $this->address = $citizen->address ?? '';
        $this->status = $citizen->status;
        $this->hamlet_id = (string) ($citizen->household?->hamlet_id ?? '');
        $this->rw_id = (string) ($citizen->household?->rw_id ?? '');
        $this->rt_id = (string) ($citizen->household?->rt_id ?? '');
        $this->is_head_of_household = $citizen->household?->head_citizen_id === $citizen->id;
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
            'citizenId',
            'household_id',
            'nik',
            'full_name',
            'birth_place',
            'birth_date',
            'religion',
            'marital_status',
            'family_relationship',
            'occupation',
            'education',
            'citizenship',
            'address',
            'hamlet_id',
            'rw_id',
            'rt_id',
        ]);

        $this->gender = 'L';
        $this->citizenship = 'WNI';
        $this->status = 'active';
        $this->is_head_of_household = false;
        $this->showModal = false;
        $this->isEditing = false;
        $this->resetErrorBag();
    }

    public function save(): void
    {
        $validated = $this->validate();

        $citizen = Citizen::updateOrCreate(
            ['id' => $this->citizenId],
            collect($validated)->except(['hamlet_id', 'rw_id', 'rt_id'])->toArray()
        );

        if (!empty($validated['household_id'])) {
            $household = Household::find($validated['household_id']);

            if ($household) {
                if (!empty($validated['hamlet_id'])) {
                    $household->hamlet_id = $validated['hamlet_id'];
                }

                if (!empty($validated['rw_id'])) {
                    $household->rw_id = $validated['rw_id'];
                }

                if (!empty($validated['rt_id'])) {
                    $household->rt_id = $validated['rt_id'];
                }

                if ($this->is_head_of_household || $validated['family_relationship'] === 'Kepala Keluarga') {
                    $household->head_citizen_id = $citizen->id;
                    $citizen->update(['family_relationship' => 'Kepala Keluarga']);
                } elseif ($household->head_citizen_id === $citizen->id) {
                    $household->head_citizen_id = null;
                }

                $household->save();
            }
        }

        LoggerService::logUserAction($this->isEditing ? 'update' : 'create', 'Citizen', $citizen->id, [
            'nik' => $citizen->nik,
            'full_name' => $citizen->full_name,
            'status' => $citizen->status,
            'household_id' => $citizen->household_id,
        ]);

        session()->flash('message', $this->isEditing ? 'Data penduduk berhasil diperbarui.' : 'Data penduduk berhasil ditambahkan.');

        $this->closeModal();
        $this->dispatch('citizenSaved');
    }

    public function render()
    {
        $households = Household::query()
            ->orderBy('no_kk')
            ->get(['id', 'no_kk', 'address']);

        $genderOptions = CitizenReferenceData::genderOptions();
        $religionOptions = CitizenReferenceData::religionOptions();
        $occupationOptions = CitizenReferenceData::occupationOptions();
        $educationOptions = CitizenReferenceData::educationOptions();
        $citizenshipOptions = CitizenReferenceData::citizenshipOptions();
        $maritalStatusOptions = CitizenReferenceData::maritalStatusOptions();
        $familyRelationshipOptions = CitizenReferenceData::familyRelationshipOptions();
        $statusOptions = CitizenReferenceData::statusOptions();
        $hamlets = Hamlet::query()->orderBy('name')->get(['id', 'name']);
        $rws = Rw::query()
            ->when($this->hamlet_id !== '', fn ($query) => $query->where('hamlet_id', $this->hamlet_id))
            ->orderBy('number')
            ->get(['id', 'hamlet_id', 'number']);
        $rts = Rt::query()
            ->when($this->rw_id !== '', fn ($query) => $query->where('rw_id', $this->rw_id))
            ->orderBy('number')
            ->get(['id', 'rw_id', 'number']);

        return view('livewire.admin.citizens.citizen-form', compact(
            'households',
            'genderOptions',
            'religionOptions',
            'occupationOptions',
            'educationOptions',
            'citizenshipOptions',
            'maritalStatusOptions',
            'familyRelationshipOptions',
            'statusOptions',
            'hamlets',
            'rws',
            'rts'
        ));
    }
}
