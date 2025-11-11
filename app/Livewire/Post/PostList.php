<?php

namespace App\Livewire\Post;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Post\Models\Post;
use App\Shared\Traits\WithAlerts;
use App\Domains\Category\Models\Category;

class PostList extends Component
{
    use WithPagination, WithAlerts;

    /** Filters (query string) */
    public string $search = '';
    public ?string $category = null;         // category_id (umum)
    public ?string $type = null;             // announcement | news | potensi
    public ?string $status = null;           // draft | scheduled | published | archived
    public ?string $potensiCategory = null;  // filter khusus potensi_category
    public int $perPage = 10;

    /** Sorting */
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    protected array $allowedSorts = [
        'title',
        'content_type',
        'status',
        'published_at',
        'created_at',
        'updated_at',
        'potensi_category', // tambahkan agar bisa sort kategori potensi
    ];
    protected array $allowedPerPage = [10, 25, 50, 100];

    protected $queryString = [
        'search'          => ['except' => ''],
        'category'        => ['except' => null],
        'type'            => ['except' => null],
        'status'          => ['except' => null],
        'potensiCategory' => ['except' => null],
        'perPage'         => ['except' => 10],
        'sortField'       => ['except' => 'created_at'],
        'sortDirection'   => ['except' => 'desc'],
    ];

    protected $listeners = [
        'post:saved' => 'refreshList',
    ];

    /** ===== lifecycle for pagination reset on filter change ===== */
    public function refreshList(): void
    {
        $this->resetPage();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingCategory()
    {
        $this->resetPage();
    }
    public function updatingType()
    {
        $this->resetPage();
    }
    public function updatingStatus()
    {
        $this->resetPage();
    }
    public function updatingPerPage()
    {
        $this->resetPage();
    }
    public function updatingPotensiCategory()
    {
        $this->resetPage();
    }

    /** ===== sorting ===== */
    public function sortBy(string $field): void
    {
        if (! in_array($field, $this->allowedSorts, true)) return;
        $this->sortDirection = ($this->sortField === $field && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $this->sortField = $field;
    }

    /** ===== actions ===== */
    public function togglePublish(string $id): void
    {
        $post = Post::findOrFail($id);

        if ($post->status === 'published') {
            $post->update(['status' => 'draft', 'published_at' => null]);
            $this->showSuccessToast('Dipindah ke Draft.');
        } else {
            $post->update(['status' => 'published', 'published_at' => now()]);
            $this->showSuccessToast('Dipublikasikan.');
        }
    }

    public function delete(string $id): void
    {
        Post::findOrFail($id)->delete();
        $this->showSuccessToast('Post dihapus.');
        $this->resetPage();
    }

    /** ===== sanitasi ringan agar aman ===== */
    protected function sanitizedSortField(): string
    {
        return in_array($this->sortField, $this->allowedSorts, true) ? $this->sortField : 'created_at';
    }
    protected function sanitizedSortDirection(): string
    {
        return $this->sortDirection === 'asc' ? 'asc' : 'desc';
    }
    protected function sanitizedPerPage(): int
    {
        return in_array($this->perPage, $this->allowedPerPage, true) ? $this->perPage : 10;
    }
    protected function sanitizedType(): ?string
    {
        if (in_array($this->type, ['announcement', 'news', 'potensi'], true)) return $this->type;
        return null;
    }

    public function render()
    {
        $sortField     = $this->sanitizedSortField();
        $sortDirection = $this->sanitizedSortDirection();
        $perPage       = $this->sanitizedPerPage();
        $type          = $this->sanitizedType();

        $data = Post::query()
            ->with(['category:id,name', 'tags:id,name'])
            // search fulltext sederhana (model sudah cover field potensi juga)
            ->when($this->search, fn($q) => $q->search($this->search))
            // filter category_id umum
            ->when($this->category, fn($q) => $q->where('category_id', $this->category))
            // filter content_type
            ->when($type, fn($q) => $q->where('content_type', $type))
            // filter status
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            // filter khusus potensi_category (hanya berlaku saat type=potensi)
            ->when(
                $type === 'potensi' && $this->potensiCategory,
                fn($q) =>
                $q->where('potensi_category', $this->potensiCategory)
            )
            // sorting aman
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        // daftar kategori umum (dropdown kategori biasa)
        $categories = Category::query()->orderBy('name')->get(['id', 'name']);

        // daftar kategori potensi (distinct) untuk filter tambahan di UI (opsional)
        $potensiCategories = Post::query()
            ->where('content_type', 'potensi')
            ->whereNotNull('potensi_category')
            ->select('potensi_category')
            ->distinct()
            ->orderBy('potensi_category')
            ->pluck('potensi_category');

        return view('livewire.post.post-list', [
            'data'              => $data,
            'categories'        => $categories,
            'potensiCategories' => $potensiCategories,
        ]);
    }
}
