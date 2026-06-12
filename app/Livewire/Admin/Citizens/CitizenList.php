<?php

namespace App\Livewire\Admin\Citizens;

use App\Domains\Citizen\Models\Citizen;
use App\Domains\Household\Models\Household;
use App\Imports\CitizensImport;
use App\Livewire\Concerns\AuthorizesPermissions;
use App\Services\LoggerService;
use App\Shared\Traits\WithAlerts;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class CitizenList extends Component
{
    use WithAlerts;
    use AuthorizesPermissions;
    use WithFileUploads;
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public string $gender = '';
    public int $perPage = 10;
    public string $sortField = 'full_name';
    public string $sortDirection = 'asc';
    public $importFile;

    #[On('citizenSaved')]
    public function refreshList(): void
    {
        $this->resetPage();
    }

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'gender' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingGender(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'status', 'gender']);
        $this->resetPage();
    }

    public function importCitizens(): void
    {
        $this->authorizeAllPermissions(['citizens.create', 'citizens.edit']);
        $this->validate([
            'importFile' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:5120'],
        ]);

        $import = new CitizensImport();
        Excel::import($import, $this->importFile);

        $this->importFile = null;
        $this->resetPage();

        if ($import->errors !== []) {
            session()->flash(
                'error',
                'Import selesai dengan catatan. Dibuat: ' . $import->created . ', diperbarui: ' . $import->updated . '. ' . implode(' | ', array_slice($import->errors, 0, 3))
            );

            return;
        }

        session()->flash(
            'message',
            'Import penduduk berhasil. Dibuat: ' . $import->created . ', diperbarui: ' . $import->updated . '.'
        );
    }

    public function confirmDeleteCitizen(int $citizenId): void
    {
        $this->authorizePermission('citizens.delete');
        $citizen = Citizen::findOrFail($citizenId);

        $this->showConfirm(
            'Hapus Data Penduduk',
            "Hapus data penduduk '{$citizen->full_name}' dengan NIK {$citizen->nik}? Tindakan ini tidak dapat dibatalkan.",
            'deleteCitizen',
            ['citizenId' => $citizenId],
            'Ya, hapus',
            'Batal'
        );
    }

    public function deleteCitizen(array $params): void
    {
        $this->authorizePermission('citizens.delete');
        $citizenId = $params['citizenId'];
        $citizen = Citizen::findOrFail($citizenId);

        LoggerService::logUserAction('delete', 'Citizen', $citizen->id, [
            'nik' => $citizen->nik,
            'full_name' => $citizen->full_name,
        ]);

        $citizen->delete();

        $this->showSuccessToast('Data penduduk berhasil dihapus.');
        $this->resetPage();
    }

    public function render()
    {
        $this->authorizePermission('citizens.view');
        $baseQuery = Citizen::query()
            ->select([
                'id',
                'household_id',
                'nik',
                'full_name',
                'gender',
                'birth_place',
                'birth_date',
                'family_relationship',
                'occupation',
                'education',
                'citizenship',
                'religion',
                'marital_status',
                'status',
                'address',
                'created_at',
                'updated_at',
            ])
            ->with([
                'household:id,no_kk,address,head_citizen_id',
            ])
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery
                        ->where('full_name', 'like', '%' . $this->search . '%')
                        ->orWhere('nik', 'like', '%' . $this->search . '%')
                        ->orWhere('occupation', 'like', '%' . $this->search . '%')
                        ->orWhereHas('household', function ($householdQuery) {
                            $householdQuery->where('no_kk', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->status !== '', fn ($query) => $query->where('status', $this->status))
            ->when($this->gender !== '', fn ($query) => $query->where('gender', $this->gender));

        $citizens = (clone $baseQuery)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $stats = [
            'total_citizens' => (clone $baseQuery)->count(),
            'active_citizens' => (clone $baseQuery)->where('status', 'active')->count(),
            'male_citizens' => (clone $baseQuery)->whereIn('gender', ['L', 'Laki-laki'])->count(),
            'female_citizens' => (clone $baseQuery)->whereIn('gender', ['P', 'Perempuan'])->count(),
            'total_households' => Household::query()->count(),
        ];

        return view('livewire.admin.citizens.citizen-list', compact('citizens', 'stats'));
    }
}
