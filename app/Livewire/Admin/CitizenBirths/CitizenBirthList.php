<?php

namespace App\Livewire\Admin\CitizenBirths;

use App\Domains\Citizen\Models\CitizenBirth;
use App\Livewire\Concerns\AuthorizesPermissions;
use App\Services\LoggerService;
use App\Shared\Traits\WithAlerts;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CitizenBirthList extends Component
{
    use WithAlerts;
    use AuthorizesPermissions;
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    #[On('citizenBirthSaved')]
    public function refreshList(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function confirmDeleteBirth(int $birthId): void
    {
        $this->authorizePermission('citizen_births.delete');
        $birth = CitizenBirth::with('citizen')->findOrFail($birthId);
        $childName = $birth->citizen?->full_name ?? 'data ini';

        $this->showConfirm(
            'Hapus Riwayat Kelahiran',
            "Hapus riwayat kelahiran untuk '{$childName}'? Tindakan ini tidak dapat dibatalkan.",
            'deleteBirth',
            ['birthId' => $birthId],
            'Ya, hapus',
            'Batal'
        );
    }

    public function deleteBirth(array $params): void
    {
        $this->authorizePermission('citizen_births.delete');
        $birthId = $params['birthId'];
        $birth = CitizenBirth::with('citizen')->findOrFail($birthId);

        LoggerService::logUserAction('delete', 'CitizenBirth', $birth->id, [
            'citizen_id' => $birth->citizen_id,
            'citizen_name' => $birth->citizen?->full_name,
        ]);

        $birth->delete();

        $this->showSuccessToast('Riwayat kelahiran berhasil dihapus.');
        $this->resetPage();
    }

    public function render()
    {
        $this->authorizePermission('citizen_births.view');
        $births = CitizenBirth::query()
            ->with(['citizen:id,nik,full_name,gender,birth_place,birth_date', 'household:id,no_kk'])
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery
                        ->where('father_name', 'like', '%' . $this->search . '%')
                        ->orWhere('mother_name', 'like', '%' . $this->search . '%')
                        ->orWhereHas('citizen', function ($citizenQuery) {
                            $citizenQuery
                                ->where('full_name', 'like', '%' . $this->search . '%')
                                ->orWhere('nik', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->latest('created_at')
            ->paginate($this->perPage);

        return view('livewire.admin.citizen-births.citizen-birth-list', compact('births'));
    }
}
