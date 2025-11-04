<?php

namespace App\Livewire\VisiMisi;


use Livewire\Component;
use Livewire\WithPagination;
use App\Shared\Traits\WithAlerts;
use App\Domains\Visimisi\Models\Visimisi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Shared\Services\CacheService;
use App\Shared\Services\LoggerService;

class VisiMisiList extends Component
{
    use WithPagination, WithAlerts;

    public string $search = '';
    public bool $showInactive = false;
    public int $perPage = 10;
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

    protected array $allowedSorts = ['kategori', 'isi', 'created_at', 'is_active'];
    protected array $allowedPerPage = [10, 25, 50];

    protected $queryString = [
        'search' => ['except' => ''],
        'showInactive' => ['except' => false],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
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

    public function sortBy(string $field): void
    {
        if (!in_array($field, $this->allowedSorts)) return;
        if ($this->sortField === $field)
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        else
            $this->sortField = $field;
    }

    public function toggleStatus($id)
    {
        $item = Visimisi::findOrFail($id);
        $item->update(['is_active' => !$item->is_active]);
        $this->showSuccessToast("Status updated!");
    }

    public function delete($id)
    {
        $item = Visimisi::findOrFail($id);
        if ($item->gambar && Storage::disk('public')->exists($item->gambar))
            Storage::disk('public')->delete($item->gambar);
        $item->delete();
        $this->showSuccessToast("Data deleted!");
    }

    public function render()
    {
        $data = Visimisi::query()
            ->when($this->search, fn($q) => $q->where('isi', 'like', "%{$this->search}%"))
            ->when(!$this->showInactive, fn($q) => $q->where('is_active', true))
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.visi-misi.visi-misi-list', compact('data'));
    }
}
