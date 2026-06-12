<?php

namespace App\Livewire\Admin\Households;

use App\Domains\Household\Models\Household;
use App\Livewire\Concerns\AuthorizesPermissions;
use App\Services\LoggerService;
use App\Shared\Traits\WithAlerts;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class HouseholdList extends Component
{
    use WithAlerts;
    use AuthorizesPermissions;
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    #[On('householdSaved')]
    public function refreshList(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function confirmDeleteHousehold(int $householdId): void
    {
        $this->authorizePermission('households.delete');
        $household = Household::findOrFail($householdId);

        $this->showConfirm(
            'Hapus Kartu Keluarga',
            "Hapus data KK {$household->no_kk}? Tindakan ini tidak dapat dibatalkan.",
            'deleteHousehold',
            ['householdId' => $householdId],
            'Ya, hapus',
            'Batal'
        );
    }

    public function deleteHousehold(array $params): void
    {
        $this->authorizePermission('households.delete');
        $household = Household::findOrFail($params['householdId']);

        LoggerService::logUserAction('delete', 'Household', $household->id, [
            'no_kk' => $household->no_kk,
            'head_citizen_id' => $household->head_citizen_id,
        ]);

        $household->delete();

        $this->showSuccessToast('Data KK berhasil dihapus.');
        $this->resetPage();
    }

    public function render()
    {
        $this->authorizePermission('households.view');
        $households = Household::query()
            ->with([
                'headCitizen:id,full_name,nik',
                'hamlet:id,name',
                'rw:id,number',
                'rt:id,number',
            ])
            ->withCount('citizens')
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery
                        ->where('no_kk', 'like', '%' . $this->search . '%')
                        ->orWhere('address', 'like', '%' . $this->search . '%')
                        ->orWhereHas('headCitizen', function ($headQuery) {
                            $headQuery
                                ->where('full_name', 'like', '%' . $this->search . '%')
                                ->orWhere('nik', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->latest('updated_at')
            ->paginate($this->perPage);

        $stats = [
            'total_households' => Household::query()->count(),
            'with_head' => Household::query()->whereNotNull('head_citizen_id')->count(),
            'without_head' => Household::query()->whereNull('head_citizen_id')->count(),
            'total_members' => Household::query()->withCount('citizens')->get()->sum('citizens_count'),
        ];

        return view('livewire.admin.households.household-list', compact('households', 'stats'));
    }
}
