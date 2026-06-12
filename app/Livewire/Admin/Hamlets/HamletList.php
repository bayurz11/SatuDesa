<?php

namespace App\Livewire\Admin\Hamlets;

use App\Domains\Hamlet\Models\Hamlet;
use App\Livewire\Concerns\AuthorizesPermissions;
use App\Services\LoggerService;
use App\Shared\Traits\WithAlerts;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class HamletList extends Component
{
    use WithAlerts;
    use AuthorizesPermissions;
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    #[On('hamletSaved')]
    public function refreshList(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function confirmDeleteHamlet(int $hamletId): void
    {
        $this->authorizePermission('hamlets.delete');
        $hamlet = Hamlet::findOrFail($hamletId);

        $this->showConfirm(
            'Hapus Dusun',
            "Hapus data dusun '{$hamlet->name}'? Tindakan ini tidak dapat dibatalkan.",
            'deleteHamlet',
            ['hamletId' => $hamletId],
            'Ya, hapus',
            'Batal'
        );
    }

    public function deleteHamlet(array $params): void
    {
        $this->authorizePermission('hamlets.delete');
        $hamlet = Hamlet::findOrFail($params['hamletId']);

        LoggerService::logUserAction('delete', 'Hamlet', $hamlet->id, [
            'name' => $hamlet->name,
            'code' => $hamlet->code,
        ]);

        $hamlet->delete();

        $this->showSuccessToast('Data dusun berhasil dihapus.');
        $this->resetPage();
    }

    public function render()
    {
        $this->authorizePermission('hamlets.view');
        $hamlets = Hamlet::query()
            ->withCount('rws')
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery
                        ->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('code', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('name')
            ->paginate($this->perPage);

        $stats = [
            'total_hamlets' => Hamlet::query()->count(),
            'with_code' => Hamlet::query()->whereNotNull('code')->count(),
            'without_code' => Hamlet::query()->whereNull('code')->count(),
            'total_rws' => $hamlets->sum('rws_count'),
        ];

        return view('livewire.admin.hamlets.hamlet-list', compact('hamlets', 'stats'));
    }
}
