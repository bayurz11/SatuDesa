<?php

namespace App\Livewire\Admin\CitizenDeaths;

use App\Domains\Citizen\Models\CitizenDeath;
use App\Livewire\Concerns\AuthorizesPermissions;
use App\Services\LoggerService;
use App\Shared\Traits\WithAlerts;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CitizenDeathList extends Component
{
    use WithAlerts;
    use AuthorizesPermissions;
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    #[On('citizenDeathSaved')]
    public function refreshList(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function confirmDeleteDeath(int $deathId): void
    {
        $this->authorizePermission('citizen_deaths.delete');
        $death = CitizenDeath::with('citizen')->findOrFail($deathId);
        $citizenName = $death->citizen?->full_name ?? 'data ini';

        $this->showConfirm(
            'Hapus Riwayat Kematian',
            "Hapus riwayat kematian untuk '{$citizenName}'? Status penduduk akan dikembalikan menjadi aktif.",
            'deleteDeath',
            ['deathId' => $deathId],
            'Ya, hapus',
            'Batal'
        );
    }

    public function deleteDeath(array $params): void
    {
        $this->authorizePermission('citizen_deaths.delete');
        $deathId = $params['deathId'];
        $death = CitizenDeath::with('citizen')->findOrFail($deathId);
        $citizen = $death->citizen;

        LoggerService::logUserAction('delete', 'CitizenDeath', $death->id, [
            'citizen_id' => $death->citizen_id,
            'citizen_name' => $citizen?->full_name,
        ]);

        $death->delete();

        if ($citizen) {
            $citizen->update(['status' => 'active']);
        }

        $this->showSuccessToast('Riwayat kematian berhasil dihapus dan status penduduk diaktifkan kembali.');
        $this->resetPage();
    }

    public function render()
    {
        $this->authorizePermission('citizen_deaths.view');
        $deaths = CitizenDeath::query()
            ->with('citizen:id,nik,full_name')
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery
                        ->where('cause_of_death', 'like', '%' . $this->search . '%')
                        ->orWhere('death_place', 'like', '%' . $this->search . '%')
                        ->orWhereHas('citizen', function ($citizenQuery) {
                            $citizenQuery
                                ->where('full_name', 'like', '%' . $this->search . '%')
                                ->orWhere('nik', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->latest('death_date')
            ->paginate($this->perPage);

        return view('livewire.admin.citizen-deaths.citizen-death-list', compact('deaths'));
    }
}
