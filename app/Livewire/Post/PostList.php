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

    public string $search = '';
    public ?string $category = null;
    public ?string $type = null;     // announcement|news
    public ?string $status = null;   // draft|scheduled|published|archived
    public int $perPage = 10;

    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    protected array $allowedSorts = ['title', 'content_type', 'status', 'published_at', 'created_at'];
    protected array $allowedPerPage = [10, 25, 50];

    protected $queryString = [
        'search'        => ['except' => ''],
        'category'      => ['except' => null],
        'type'          => ['except' => null],
        'status'        => ['except' => null],
        'perPage'       => ['except' => 10],
        'sortField'     => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    protected $listeners = [
        'post:saved' => 'refreshList',
    ];

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

    public function sortBy(string $field): void
    {
        if (! in_array($field, $this->allowedSorts, true)) return;
        $this->sortDirection = ($this->sortField === $field && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $this->sortField = $field;
    }

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

    public function render()
    {
        $sortField     = in_array($this->sortField, $this->allowedSorts, true) ? $this->sortField : 'created_at';
        $sortDirection = $this->sortDirection === 'asc' ? 'asc' : 'desc';
        $perPage       = in_array($this->perPage, $this->allowedPerPage, true) ? $this->perPage : 10;

        $data = Post::query()
            ->with(['category:id,name', 'tags:id,name'])
            ->when($this->search, fn($q) => $q->search($this->search))
            ->when($this->category, fn($q) => $q->where('category_id', $this->category))
            ->when($this->type, fn($q) => $q->where('content_type', $this->type))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        $categories = Category::query()->orderBy('name')->get(['id', 'name']);

        return view('livewire.post.post-list', compact('data', 'categories'));
    }
}
