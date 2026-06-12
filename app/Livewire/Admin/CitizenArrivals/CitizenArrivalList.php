<?php

namespace App\Livewire\Admin\CitizenArrivals;

use App\Domains\Citizen\Models\CitizenArrival;
use App\Livewire\Concerns\AuthorizesPermissions;
use App\Services\LoggerService;
use App\Shared\Traits\WithAlerts;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CitizenArrivalList extends Component
{
    use WithAlerts;
    use AuthorizesPermissions;
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    #[On('citizenArrivalSaved')]
    public function refreshList(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function confirmDeleteArrival(int $arrivalId): void
    {
        $this->authorizePermission('citizen_arrivals.delete');
        $arrival = CitizenArrival::with('citizen')->findOrFail($arrivalId);
        $citizenName = $arrival->citizen?->full_name ?? 'data ini';

        $this->showConfirm(
            'Hapus Riwayat Pindah Datang',
            "Hapus riwayat pindah datang untuk '{$citizenName}'? Tindakan ini tidak dapat dibatalkan.",
            'deleteArrival',
            ['arrivalId' => $arrivalId],
            'Ya, hapus',
            'Batal'
        );
    }

    public function deleteArrival(array $params): void
    {
        $this->authorizePermission('citizen_arrivals.delete');
        $arrivalId = $params['arrivalId'];
        $arrival = CitizenArrival::with('citizen')->findOrFail($arrivalId);

        LoggerService::logUserAction('delete', 'CitizenArrival', $arrival->id, [
            'citizen_id' => $arrival->citizen_id,
            'citizen_name' => $arrival->citizen?->full_name,
        ]);

        $arrival->delete();

        $this->showSuccessToast('Riwayat pindah datang berhasil dihapus.');
        $this->resetPage();
    }

    public function render()
    {
        $this->authorizePermission('citizen_arrivals.view');
        $arrivals = CitizenArrival::query()
            ->with(['citizen:id,nik,full_name,status,address', 'household:id,no_kk'])
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery
                        ->where('origin_region', 'like', '%' . $this->search . '%')
                        ->orWhere('arrival_reason', 'like', '%' . $this->search . '%')
                        ->orWhereHas('citizen', function ($citizenQuery) {
                            $citizenQuery
                                ->where('full_name', 'like', '%' . $this->search . '%')
                                ->orWhere('nik', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->latest('arrival_date')
            ->paginate($this->perPage);

        return view('livewire.admin.citizen-arrivals.citizen-arrival-list', compact('arrivals'));
    }
}
