<?php

namespace App\Livewire\Admin\Rws;

use App\Domains\Rw\Models\Rw;
use App\Services\LoggerService;
use App\Shared\Traits\WithAlerts;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class RwList extends Component
{
    use WithAlerts;
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    #[On('rwSaved')]
    public function refreshList(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function confirmDeleteRw(int $rwId): void
    {
        $rw = Rw::with('hamlet')->findOrFail($rwId);

        $this->showConfirm(
            'Hapus RW',
            "Hapus RW {$rw->number} di {$rw->hamlet?->name}? Tindakan ini tidak dapat dibatalkan.",
            'deleteRw',
            ['rwId' => $rwId],
            'Ya, hapus',
            'Batal'
        );
    }

    public function deleteRw(array $params): void
    {
        $rw = Rw::findOrFail($params['rwId']);

        LoggerService::logUserAction('delete', 'Rw', $rw->id, [
            'number' => $rw->number,
            'hamlet_id' => $rw->hamlet_id,
        ]);

        $rw->delete();

        $this->showSuccessToast('Data RW berhasil dihapus.');
        $this->resetPage();
    }

    public function render()
    {
        $rws = Rw::query()
            ->with(['hamlet:id,name'])
            ->withCount('rts')
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery
                        ->where('number', 'like', '%' . $this->search . '%')
                        ->orWhereHas('hamlet', function ($hamletQuery) {
                            $hamletQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->orderBy('number')
            ->paginate($this->perPage);

        $stats = [
            'total_rws' => Rw::query()->count(),
            'hamlets_covered' => Rw::query()->distinct('hamlet_id')->count('hamlet_id'),
            'total_rts' => $rws->sum('rts_count'),
        ];

        return view('livewire.admin.rws.rw-list', compact('rws', 'stats'));
    }
}
