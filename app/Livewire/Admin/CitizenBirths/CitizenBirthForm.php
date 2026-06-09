<?php

namespace App\Livewire\Admin\CitizenBirths;

use App\Domains\Citizen\Models\Citizen;
use App\Domains\Citizen\Models\CitizenBirth;
use App\Domains\Household\Models\Household;
use App\Domains\Village\Models\Village;
use App\Services\LoggerService;
use App\Support\CitizenReferenceData;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class CitizenBirthForm extends Component
{
    public ?int $birthId = null;
    public ?int $citizenId = null;
    public ?int $household_id = null;
    public string $nik = '';
    public string $full_name = '';
    public string $gender = 'L';
    public string $birth_place = '';
    public string $birth_date = '';
    public string $birth_time = '';
    public string $birth_weight = '';
    public string $birth_length = '';
    public string $birth_type = '';
    public string $birth_order = '';
    public string $father_nik = '';
    public string $father_name = '';
    public string $mother_nik = '';
    public string $mother_name = '';
    public string $birth_attendant = '';
    public string $birth_certificate_number = '';
    public string $reporter_name = '';
    public string $reporter_relation = '';
    public string $witness_1_name = '';
    public string $witness_2_name = '';
    public string $notes = '';
    public bool $showModal = false;
    public bool $isEditing = false;

    protected function rules(): array
    {
        return [
            'household_id' => ['nullable', 'exists:households,id'],
            'nik' => ['required', 'string', 'max:255', Rule::unique('citizens', 'nik')->ignore($this->citizenId)],
            'full_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', Rule::in(array_keys(CitizenReferenceData::genderOptions()))],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'birth_time' => ['nullable', 'date_format:H:i'],
            'birth_weight' => ['nullable', 'string', 'max:50'],
            'birth_length' => ['nullable', 'string', 'max:50'],
            'birth_type' => ['nullable', Rule::in(CitizenReferenceData::birthTypeOptions())],
            'birth_order' => ['nullable', 'integer', 'min:1', 'max:20'],
            'father_nik' => ['nullable', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_nik' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'birth_attendant' => ['nullable', Rule::in(CitizenReferenceData::birthAttendantOptions())],
            'birth_certificate_number' => ['nullable', 'string', 'max:255'],
            'reporter_name' => ['nullable', 'string', 'max:255'],
            'reporter_relation' => ['nullable', Rule::in(CitizenReferenceData::reporterRelationOptions())],
            'witness_1_name' => ['nullable', 'string', 'max:255'],
            'witness_2_name' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ];
    }

    #[On('openCitizenBirthForm')]
    public function openModal(?int $birthId = null): void
    {
        $this->resetForm();

        if ($birthId) {
            $this->loadBirth($birthId);
        }

        $this->showModal = true;
    }

    public function loadBirth(int $birthId): void
    {
        $birth = CitizenBirth::with('citizen')->findOrFail($birthId);

        $this->birthId = $birth->id;
        $this->citizenId = $birth->citizen_id;
        $this->household_id = $birth->household_id;
        $this->nik = $birth->citizen->nik;
        $this->full_name = $birth->citizen->full_name;
        $this->gender = $birth->citizen->gender;
        $this->birth_place = $birth->citizen->birth_place ?? '';
        $this->birth_date = $birth->citizen->birth_date?->format('Y-m-d') ?? '';
        $this->birth_time = $birth->birth_time ?? '';
        $this->birth_weight = $birth->birth_weight ?? '';
        $this->birth_length = $birth->birth_length ?? '';
        $this->birth_type = $birth->birth_type ?? '';
        $this->birth_order = (string) ($birth->birth_order ?? '');
        $this->father_nik = $birth->father_nik ?? '';
        $this->father_name = $birth->father_name ?? '';
        $this->mother_nik = $birth->mother_nik ?? '';
        $this->mother_name = $birth->mother_name ?? '';
        $this->birth_attendant = $birth->birth_attendant ?? '';
        $this->birth_certificate_number = $birth->birth_certificate_number ?? '';
        $this->reporter_name = $birth->reporter_name ?? '';
        $this->reporter_relation = $birth->reporter_relation ?? '';
        $this->witness_1_name = $birth->witness_1_name ?? '';
        $this->witness_2_name = $birth->witness_2_name ?? '';
        $this->notes = $birth->notes ?? '';
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
            'birthId',
            'citizenId',
            'household_id',
            'nik',
            'full_name',
            'birth_place',
            'birth_date',
            'birth_time',
            'birth_weight',
            'birth_length',
            'birth_type',
            'birth_order',
            'father_nik',
            'father_name',
            'mother_nik',
            'mother_name',
            'birth_attendant',
            'birth_certificate_number',
            'reporter_name',
            'reporter_relation',
            'witness_1_name',
            'witness_2_name',
            'notes',
        ]);

        $this->gender = 'L';
        $this->showModal = false;
        $this->isEditing = false;
        $this->resetErrorBag();
    }

    public function save(): void
    {
        $validated = $this->validate();
        $villageId = Village::query()->value('id');

        $citizen = Citizen::updateOrCreate(
            ['id' => $this->citizenId],
            [
                'household_id' => $validated['household_id'],
                'nik' => $validated['nik'],
                'full_name' => $validated['full_name'],
                'gender' => $validated['gender'],
                'birth_place' => $validated['birth_place'],
                'birth_date' => $validated['birth_date'],
                'status' => 'active',
            ]
        );

        $birth = CitizenBirth::updateOrCreate(
            ['id' => $this->birthId],
            [
                'village_id' => $villageId,
                'citizen_id' => $citizen->id,
                'household_id' => $validated['household_id'],
                'father_nik' => $validated['father_nik'],
                'mother_nik' => $validated['mother_nik'],
                'father_name' => $validated['father_name'],
                'mother_name' => $validated['mother_name'],
                'birth_time' => $validated['birth_time'],
                'birth_weight' => $validated['birth_weight'],
                'birth_length' => $validated['birth_length'],
                'birth_order' => $validated['birth_order'] !== '' ? (int) $validated['birth_order'] : null,
                'birth_type' => $validated['birth_type'],
                'birth_attendant' => $validated['birth_attendant'],
                'birth_certificate_number' => $validated['birth_certificate_number'],
                'reporter_name' => $validated['reporter_name'],
                'reporter_relation' => $validated['reporter_relation'],
                'witness_1_name' => $validated['witness_1_name'],
                'witness_2_name' => $validated['witness_2_name'],
                'notes' => $validated['notes'],
            ]
        );

        LoggerService::logUserAction($this->isEditing ? 'update' : 'create', 'CitizenBirth', $birth->id, [
            'citizen_id' => $citizen->id,
            'citizen_name' => $citizen->full_name,
        ]);

        session()->flash('message', $this->isEditing ? 'Data kelahiran berhasil diperbarui.' : 'Data kelahiran berhasil ditambahkan.');

        $this->closeModal();
        $this->dispatch('citizenBirthSaved');
    }

    public function render()
    {
        $households = Household::query()->orderBy('no_kk')->get(['id', 'no_kk', 'address']);
        $genderOptions = CitizenReferenceData::genderOptions();
        $birthTypeOptions = CitizenReferenceData::birthTypeOptions();
        $birthAttendantOptions = CitizenReferenceData::birthAttendantOptions();
        $reporterRelationOptions = CitizenReferenceData::reporterRelationOptions();

        return view('livewire.admin.citizen-births.citizen-birth-form', compact(
            'households',
            'genderOptions',
            'birthTypeOptions',
            'birthAttendantOptions',
            'reporterRelationOptions'
        ));
    }
}
