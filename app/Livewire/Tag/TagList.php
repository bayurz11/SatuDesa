<?php

namespace App\Livewire\Tag;

use Livewire\Component;
use Livewire\WithPagination;
use App\Shared\Traits\WithAlerts;
use App\Domains\Post\Models\Tag;

class TagList extends Component
{
    use WithPagination, WithAlerts;

    public string $search = '';
    public bool $showInactive = false;
    public int $perPage = 10;

    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    protected array $allowedSorts = ['name', 'slug', 'created_at', 'is_active'];
    protected array $allowedPerPage = [10, 25, 50];

    protected $queryString = [
        'search'        => ['except' => ''],
        'showInactive'  => ['except' => false],
        'perPage'       => ['except' => 10],
        'sortField'     => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    protected $listeners = [
        'tag:saved' => 'refreshList',
    ];

    public function refreshList(): void
    {
        $this->resetPage();
    }
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
        if (!in_array($field, $this->allowedSorts, true)) return;

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function toggleStatus(string $id): void // ULID = string
    {
        $item = Tag::findOrFail($id);
        $item->update(['is_active' => !$item->is_active]);
        $this->showSuccessToast('Status tag diperbarui!');
    }

    public function delete(string $id): void
    {
        $item = Tag::findOrFail($id);
        $item->delete(); // hard delete, karena tabel tidak soft deletes
        $this->showSuccessToast('Tag dihapus!');
        $this->resetPage();
    }

    public function render()
    {
        $sortField     = in_array($this->sortField, $this->allowedSorts, true) ? $this->sortField : 'created_at';
        $sortDirection = $this->sortDirection === 'asc' ? 'asc' : 'desc';
        $perPage       = in_array($this->perPage, $this->allowedPerPage, true) ? $this->perPage : 10;

        $data = Tag::query()
            ->when($this->search, fn($q) => $q->search($this->search))
            ->when(!$this->showInactive, fn($q) => $q->where('is_active', true))
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        return view('livewire.tag.tag-list', compact('data'));
    }
}
