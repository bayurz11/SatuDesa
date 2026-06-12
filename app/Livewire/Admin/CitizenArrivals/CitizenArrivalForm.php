<?php

namespace App\Livewire\Admin\CitizenArrivals;

use App\Domains\Citizen\Models\Citizen;
use App\Domains\Citizen\Models\CitizenArrival;
use App\Domains\Household\Models\Household;
use App\Domains\Village\Models\Village;
use App\Livewire\Concerns\AuthorizesPermissions;
use App\Services\LoggerService;
use App\Support\CitizenReferenceData;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class CitizenArrivalForm extends Component
{
    use AuthorizesPermissions;

    public ?int $arrivalId = null;
    public ?int $citizenId = null;
    public ?int $household_id = null;
    public string $nik = '';
    public string $full_name = '';
    public string $gender = 'L';
    public string $birth_place = '';
    public string $birth_date = '';
    public string $religion = '';
    public string $marital_status = '';
    public string $occupation = '';
    public string $education = '';
    public string $citizenship = 'WNI';
    public string $address = '';
    public string $arrival_date = '';
    public string $origin_address = '';
    public string $origin_region = '';
    public string $origin_no_kk = '';
    public string $moved_member_count = '';
    public string $moving_certificate_number = '';
    public string $arrival_classification = '';
    public string $arrival_reason = '';
    public string $reporter_name = '';
    public string $reporter_relation = '';
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
            'birth_place' => ['nullable', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'religion' => ['nullable', Rule::in(CitizenReferenceData::religionOptions())],
            'marital_status' => ['nullable', Rule::in(CitizenReferenceData::maritalStatusOptions())],
            'occupation' => ['nullable', Rule::in(CitizenReferenceData::occupationOptions())],
            'education' => ['nullable', Rule::in(CitizenReferenceData::educationOptions())],
            'citizenship' => ['required', Rule::in(CitizenReferenceData::citizenshipOptions())],
            'address' => ['nullable', 'string'],
            'arrival_date' => ['required', 'date'],
            'origin_address' => ['nullable', 'string'],
            'origin_region' => ['nullable', 'string', 'max:255'],
            'origin_no_kk' => ['nullable', 'string', 'max:255'],
            'moved_member_count' => ['nullable', 'integer', 'min:1', 'max:99'],
            'moving_certificate_number' => ['nullable', 'string', 'max:255'],
            'arrival_classification' => ['nullable', Rule::in(CitizenReferenceData::arrivalClassificationOptions())],
            'arrival_reason' => ['nullable', Rule::in(CitizenReferenceData::arrivalReasonOptions())],
            'reporter_name' => ['nullable', 'string', 'max:255'],
            'reporter_relation' => ['nullable', Rule::in(CitizenReferenceData::reporterRelationOptions())],
            'notes' => ['nullable', 'string'],
        ];
    }

    #[On('openCitizenArrivalForm')]
    public function openModal(?int $arrivalId = null): void
    {
        $this->authorizePermission($arrivalId ? 'citizen_arrivals.edit' : 'citizen_arrivals.create');
        $this->resetForm();

        if ($arrivalId) {
            $this->loadArrival($arrivalId);
        }

        $this->showModal = true;
    }

    public function loadArrival(int $arrivalId): void
    {
        $this->authorizePermission('citizen_arrivals.edit');
        $arrival = CitizenArrival::with('citizen')->findOrFail($arrivalId);

        $this->arrivalId = $arrival->id;
        $this->citizenId = $arrival->citizen_id;
        $this->household_id = $arrival->household_id;
        $this->nik = $arrival->citizen->nik;
        $this->full_name = $arrival->citizen->full_name;
        $this->gender = $arrival->citizen->gender;
        $this->birth_place = $arrival->citizen->birth_place ?? '';
        $this->birth_date = $arrival->citizen->birth_date?->format('Y-m-d') ?? '';
        $this->religion = $arrival->citizen->religion ?? '';
        $this->marital_status = $arrival->citizen->marital_status ?? '';
        $this->occupation = $arrival->citizen->occupation ?? '';
        $this->education = $arrival->citizen->education ?? '';
        $this->citizenship = $arrival->citizen->citizenship ?? 'WNI';
        $this->address = $arrival->citizen->address ?? '';
        $this->arrival_date = $arrival->arrival_date?->format('Y-m-d') ?? '';
        $this->origin_address = $arrival->origin_address ?? '';
        $this->origin_region = $arrival->origin_region ?? '';
        $this->origin_no_kk = $arrival->origin_no_kk ?? '';
        $this->moved_member_count = (string) ($arrival->moved_member_count ?? '');
        $this->moving_certificate_number = $arrival->moving_certificate_number ?? '';
        $this->arrival_classification = $arrival->arrival_classification ?? '';
        $this->arrival_reason = $arrival->arrival_reason ?? '';
        $this->reporter_name = $arrival->reporter_name ?? '';
        $this->reporter_relation = $arrival->reporter_relation ?? '';
        $this->notes = $arrival->notes ?? '';
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
            'arrivalId',
            'citizenId',
            'household_id',
            'nik',
            'full_name',
            'birth_place',
            'birth_date',
            'religion',
            'marital_status',
            'occupation',
            'education',
            'address',
            'arrival_date',
            'origin_address',
            'origin_region',
            'origin_no_kk',
            'moved_member_count',
            'moving_certificate_number',
            'arrival_classification',
            'arrival_reason',
            'reporter_name',
            'reporter_relation',
            'notes',
        ]);

        $this->gender = 'L';
        $this->citizenship = 'WNI';
        $this->showModal = false;
        $this->isEditing = false;
        $this->resetErrorBag();
    }

    public function save(): void
    {
        $this->authorizeCrudAction($this->isEditing, 'citizen_arrivals.create', 'citizen_arrivals.edit');
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
                'religion' => $validated['religion'],
                'marital_status' => $validated['marital_status'],
                'occupation' => $validated['occupation'],
                'education' => $validated['education'],
                'citizenship' => $validated['citizenship'],
                'address' => $validated['address'],
                'status' => 'active',
            ]
        );

        $arrival = CitizenArrival::updateOrCreate(
            ['id' => $this->arrivalId],
            [
                'village_id' => $villageId,
                'citizen_id' => $citizen->id,
                'household_id' => $validated['household_id'],
                'arrival_date' => $validated['arrival_date'],
                'origin_address' => $validated['origin_address'],
                'origin_region' => $validated['origin_region'],
                'origin_no_kk' => $validated['origin_no_kk'],
                'moved_member_count' => $validated['moved_member_count'] !== '' ? (int) $validated['moved_member_count'] : null,
                'moving_certificate_number' => $validated['moving_certificate_number'],
                'arrival_classification' => $validated['arrival_classification'],
                'arrival_reason' => $validated['arrival_reason'],
                'reporter_name' => $validated['reporter_name'],
                'reporter_relation' => $validated['reporter_relation'],
                'notes' => $validated['notes'],
            ]
        );

        LoggerService::logUserAction($this->isEditing ? 'update' : 'create', 'CitizenArrival', $arrival->id, [
            'citizen_id' => $citizen->id,
            'citizen_name' => $citizen->full_name,
        ]);

        session()->flash('message', $this->isEditing ? 'Data pindah datang berhasil diperbarui.' : 'Data pindah datang berhasil ditambahkan.');

        $this->closeModal();
        $this->dispatch('citizenArrivalSaved');
    }

    public function render()
    {
        $this->authorizePermission('citizen_arrivals.view');
        $households = Household::query()->orderBy('no_kk')->get(['id', 'no_kk', 'address']);

        return view('livewire.admin.citizen-arrivals.citizen-arrival-form', [
            'households' => $households,
            'genderOptions' => CitizenReferenceData::genderOptions(),
            'religionOptions' => CitizenReferenceData::religionOptions(),
            'occupationOptions' => CitizenReferenceData::occupationOptions(),
            'educationOptions' => CitizenReferenceData::educationOptions(),
            'citizenshipOptions' => CitizenReferenceData::citizenshipOptions(),
            'maritalStatusOptions' => CitizenReferenceData::maritalStatusOptions(),
            'arrivalClassificationOptions' => CitizenReferenceData::arrivalClassificationOptions(),
            'arrivalReasonOptions' => CitizenReferenceData::arrivalReasonOptions(),
            'reporterRelationOptions' => CitizenReferenceData::reporterRelationOptions(),
        ]);
    }
}
