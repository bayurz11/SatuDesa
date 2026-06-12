<?php

namespace App\Livewire\Admin\CitizenDeaths;

use App\Domains\Citizen\Models\Citizen;
use App\Domains\Citizen\Models\CitizenDeath;
use App\Domains\Village\Models\Village;
use App\Livewire\Concerns\AuthorizesPermissions;
use App\Services\LoggerService;
use App\Support\CitizenReferenceData;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class CitizenDeathForm extends Component
{
    use AuthorizesPermissions;

    public ?int $deathId = null;
    public ?int $citizen_id = null;
    public string $death_date = '';
    public string $death_time = '';
    public string $death_place = '';
    public string $cause_of_death = '';
    public string $certifier = '';
    public string $death_certificate_number = '';
    public string $reporter_name = '';
    public string $reporter_relation = '';
    public string $witness_1_name = '';
    public string $witness_2_name = '';
    public string $burial_place = '';
    public string $notes = '';
    public bool $showModal = false;
    public bool $isEditing = false;

    protected function rules(): array
    {
        return [
            'citizen_id' => ['required', 'exists:citizens,id'],
            'death_date' => ['required', 'date'],
            'death_time' => ['nullable', 'date_format:H:i'],
            'death_place' => ['nullable', 'string', 'max:255'],
            'cause_of_death' => ['nullable', Rule::in(CitizenReferenceData::deathCauseOptions())],
            'certifier' => ['nullable', 'string', 'max:255'],
            'death_certificate_number' => ['nullable', 'string', 'max:255'],
            'reporter_name' => ['nullable', 'string', 'max:255'],
            'reporter_relation' => ['nullable', Rule::in(CitizenReferenceData::reporterRelationOptions())],
            'witness_1_name' => ['nullable', 'string', 'max:255'],
            'witness_2_name' => ['nullable', 'string', 'max:255'],
            'burial_place' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ];
    }

    #[On('openCitizenDeathForm')]
    public function openModal(?int $deathId = null): void
    {
        $this->authorizePermission($deathId ? 'citizen_deaths.edit' : 'citizen_deaths.create');
        $this->resetForm();

        if ($deathId) {
            $this->loadDeath($deathId);
        }

        $this->showModal = true;
    }

    public function loadDeath(int $deathId): void
    {
        $this->authorizePermission('citizen_deaths.edit');
        $death = CitizenDeath::findOrFail($deathId);

        $this->deathId = $death->id;
        $this->citizen_id = $death->citizen_id;
        $this->death_date = $death->death_date?->format('Y-m-d') ?? '';
        $this->death_time = $death->death_time ?? '';
        $this->death_place = $death->death_place ?? '';
        $this->cause_of_death = $death->cause_of_death ?? '';
        $this->certifier = $death->certifier ?? '';
        $this->death_certificate_number = $death->death_certificate_number ?? '';
        $this->reporter_name = $death->reporter_name ?? '';
        $this->reporter_relation = $death->reporter_relation ?? '';
        $this->witness_1_name = $death->witness_1_name ?? '';
        $this->witness_2_name = $death->witness_2_name ?? '';
        $this->burial_place = $death->burial_place ?? '';
        $this->notes = $death->notes ?? '';
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
            'deathId',
            'citizen_id',
            'death_date',
            'death_time',
            'death_place',
            'cause_of_death',
            'certifier',
            'death_certificate_number',
            'reporter_name',
            'reporter_relation',
            'witness_1_name',
            'witness_2_name',
            'burial_place',
            'notes',
        ]);

        $this->showModal = false;
        $this->isEditing = false;
        $this->resetErrorBag();
    }

    public function save(): void
    {
        $this->authorizeCrudAction($this->isEditing, 'citizen_deaths.create', 'citizen_deaths.edit');
        $validated = $this->validate();
        $villageId = Village::query()->value('id');

        $death = CitizenDeath::updateOrCreate(
            ['id' => $this->deathId],
            array_merge($validated, ['village_id' => $villageId])
        );

        Citizen::whereKey($validated['citizen_id'])->update(['status' => 'deceased']);

        LoggerService::logUserAction($this->isEditing ? 'update' : 'create', 'CitizenDeath', $death->id, [
            'citizen_id' => $validated['citizen_id'],
        ]);

        session()->flash('message', $this->isEditing ? 'Data kematian berhasil diperbarui.' : 'Data kematian berhasil ditambahkan.');

        $this->closeModal();
        $this->dispatch('citizenDeathSaved');
    }

    public function render()
    {
        $this->authorizePermission('citizen_deaths.view');
        $citizens = Citizen::query()->orderBy('full_name')->get(['id', 'nik', 'full_name', 'status']);
        $deathCauseOptions = CitizenReferenceData::deathCauseOptions();
        $reporterRelationOptions = CitizenReferenceData::reporterRelationOptions();

        return view('livewire.admin.citizen-deaths.citizen-death-form', compact('citizens', 'deathCauseOptions', 'reporterRelationOptions'));
    }
}
