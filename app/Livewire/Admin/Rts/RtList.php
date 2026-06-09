<?php

namespace App\Livewire\Admin\Rts;

use App\Domains\Rt\Models\Rt;
use App\Services\LoggerService;
use App\Shared\Traits\WithAlerts;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class RtList extends Component
{
    use WithAlerts;
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    #[On('rtSaved')]
    public function refreshList(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function confirmDeleteRt(int $rtId): void
    {
        $rt = Rt::with('rw.hamlet')->findOrFail($rtId);

        $this->showConfirm(
            'Hapus RT',
            "Hapus RT {$rt->number} pada RW {$rt->rw?->number}? Tindakan ini tidak dapat dibatalkan.",
            'deleteRt',
            ['rtId' => $rtId],
            'Ya, hapus',
            'Batal'
        );
    }

    public function deleteRt(array $params): void
    {
        $rt = Rt::findOrFail($params['rtId']);

        LoggerService::logUserAction('delete', 'Rt', $rt->id, [
            'rw_id' => $rt->rw_id,
            'number' => $rt->number,
        ]);

        $rt->delete();

        $this->showSuccessToast('Data RT berhasil dihapus.');
        $this->resetPage();
    }

    public function render()
    {
        $rts = Rt::query()
            ->with(['rw:id,hamlet_id,number', 'rw.hamlet:id,name'])
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery
                        ->where('number', 'like', '%' . $this->search . '%')
                        ->orWhereHas('rw', function ($rwQuery) {
                            $rwQuery
                                ->where('number', 'like', '%' . $this->search . '%')
                                ->orWhereHas('hamlet', function ($hamletQuery) {
                                    $hamletQuery->where('name', 'like', '%' . $this->search . '%');
                                });
                        });
                });
            })
            ->orderBy('number')
            ->paginate($this->perPage);

        $stats = [
            'total_rts' => Rt::query()->count(),
            'rws_covered' => Rt::query()->distinct('rw_id')->count('rw_id'),
        ];

        return view('livewire.admin.rts.rt-list', compact('rts', 'stats'));
    }
}
