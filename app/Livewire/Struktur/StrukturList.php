<?php

namespace App\Livewire\Struktur;

use Livewire\Component;
use Livewire\WithPagination;
use App\Shared\Traits\WithAlerts;
use Illuminate\Support\Facades\Storage;
use App\Domains\Struktur\Models\Struktur;

class StrukturList extends Component
{
    use WithPagination, WithAlerts;

    // Filters & state
    public string $search = '';
    public string $levelFilter = '';
    public bool $showInactive = false;
    public int $perPage = 10;

    // Sorting
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    protected array $allowedSorts = ['nama', 'jabatan', 'level', 'created_at', 'is_active'];
    protected array $allowedPerPage = [10, 25, 50];

    // Persist query string
    protected $queryString = [
        'search'        => ['except' => ''],
        'levelFilter'   => ['except' => ''],
        'showInactive'  => ['except' => false],
        'perPage'       => ['except' => 10],
        'sortField'     => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    // Refresh after create/update
    protected $listeners = [
        'struktur:saved' => 'refreshList',
    ];

    public function refreshList(): void
    {
        $this->resetPage();
    }

    /* ===== Pagination resets on filter changes ===== */
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingLevelFilter()
    {
        $this->resetPage();
    }
    public function updatingShowInactive()
    {
        $this->resetPage();
    }
    public function updatingPerPage()
    {
        $this->resetPage();
    }

    /* ===== Sorting ===== */
    public function sortBy(string $field): void
    {
        if (! in_array($field, $this->allowedSorts, true)) return;

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    /* ===== Actions ===== */
    public function toggleStatus(int $id): void
    {
        $item = Struktur::findOrFail($id);
        $item->update(['is_active' => ! $item->is_active]);
        $this->showSuccessToast('Status updated!');
    }

    public function delete(int $id): void
    {
        $item = Struktur::findOrFail($id);

        if ($item->foto && Storage::disk('public')->exists($item->foto)) {
            Storage::disk('public')->delete($item->foto);
        }

        $item->delete();
        $this->showSuccessToast('Data deleted!');
        $this->resetPage();
    }

    /* ===== Render ===== */
    public function render()
    {
        $data = Struktur::query()
            ->when($this->search, function ($q) {
                $term = "%{$this->search}%";
                $q->where(function ($w) use ($term) {
                    $w->where('nama', 'like', $term)
                        ->orWhere('jabatan', 'like', $term);
                });
            })
            ->when($this->levelFilter !== '', fn($q) => $q->where('level', $this->levelFilter))
            ->when(!$this->showInactive, fn($q) => $q->where('is_active', true))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(in_array($this->perPage, $this->allowedPerPage, true) ? $this->perPage : 10);

        return view('livewire.struktur.struktur-list', compact('data'));
    }
}
