<?php

namespace App\Livewire\Category;

use Livewire\Component;
use Livewire\WithPagination;
use App\Shared\Traits\WithAlerts;
use App\Domains\Category\Models\Category;

class CategoryList extends Component
{
    use WithPagination, WithAlerts;

    /* ===== Filters & State ===== */
    public string $search = '';
    public bool $showInactive = false;
    public int $perPage = 10;

    /* ===== Sorting ===== */
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

    // Batasi field yang bisa di-sort & pilihan per halaman
    protected array $allowedSorts = ['name', 'slug', 'sort_order', 'created_at', 'is_active'];
    protected array $allowedPerPage = [10, 25, 50];

    /* ===== Query String Persist ===== */
    protected $queryString = [
        'search'        => ['except' => ''],
        'showInactive'  => ['except' => false],
        'perPage'       => ['except' => 10],
        'sortField'     => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    /* ===== Listeners (refresh setelah create/update) ===== */
    protected $listeners = [
        'post-category:saved' => 'refreshList',
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
    public function toggleStatus(string $id): void
    {
        // ULID → string
        $item = Category::findOrFail($id);
        $item->update(['is_active' => ! $item->is_active]);

        $this->showSuccessToast('Status kategori diperbarui!');
    }

    public function delete(string $id): void
    {
        $item = Category::findOrFail($id);
        $item->delete();

        $this->showSuccessToast('Kategori berhasil dihapus!');
        $this->resetPage();
    }

    /* ===== Render ===== */
    public function render()
    {
        $query = Category::query()
            ->when($this->search, fn($q) => $q->search($this->search))
            ->when(!$this->showInactive, fn($q) => $q->where('is_active', true));

        // Validasi sort & perPage
        $sortField = in_array($this->sortField, $this->allowedSorts, true) ? $this->sortField : 'created_at';
        $sortDirection = $this->sortDirection === 'asc' ? 'asc' : 'desc';
        $perPage = in_array($this->perPage, $this->allowedPerPage, true) ? $this->perPage : 10;

        $data = $query->orderBy($sortField, $sortDirection)->paginate($perPage);

        return view('livewire.category.category-list', compact('data'));
    }
}
