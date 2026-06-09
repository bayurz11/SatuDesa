<?php

namespace App\Livewire\Admin\Posts;

use App\Domains\Post\Models\Post;
use App\Domains\Post\Models\PostCategory;
use App\Services\LoggerService;
use App\Shared\Traits\WithAlerts;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class PostList extends Component
{
    use WithPagination, WithAlerts;

    public $type = Post::TYPE_NEWS;
    public $permissionPrefix = 'posts';
    public $contentLabel = 'Berita';
    public $contentLabelPlural = 'Berita';
    public $search = '';
    public $status = '';
    public $categoryId = '';
    public $perPage = 10;
    public $sortField = 'published_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'categoryId' => ['except' => ''],
    ];

    #[On('postSaved')]
    public function refreshPosts(): void
    {
        $this->dispatch('$refresh');
    }

    public function mount(
        string $type = Post::TYPE_NEWS,
        string $permissionPrefix = 'posts',
        string $contentLabel = 'Berita',
        string $contentLabelPlural = 'Berita'
    ): void {
        $this->type = $type;
        $this->permissionPrefix = $permissionPrefix;
        $this->contentLabel = $contentLabel;
        $this->contentLabelPlural = $contentLabelPlural;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingCategoryId()
    {
        $this->resetPage();
    }

    public function setStatusFilter($status = '')
    {
        $this->status = $status;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'status', 'categoryId']);
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = $field === 'published_at' ? 'desc' : 'asc';
        }
    }

    public function publishPost($postId)
    {
        if (!auth()->user()->hasPermission($this->permissionName('publish'))) {
            $this->showErrorToast("Anda tidak memiliki izin untuk publish {$this->contentLabelLower()}.");
            return;
        }

        $post = Post::query()->where('type', $this->type)->findOrFail($postId);
        $post->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        LoggerService::logUserAction('publish', 'Post', $postId, [
            'post_title' => $post->title,
        ]);

        $this->showSuccessToast(ucfirst($this->contentLabelLower()) . ' berhasil dipublish.');
        $this->dispatch('$refresh');
    }

    public function moveToDraft($postId)
    {
        if (!auth()->user()->hasPermission($this->permissionName('edit'))) {
            $this->showErrorToast("Anda tidak memiliki izin untuk mengubah status {$this->contentLabelLower()}.");
            return;
        }

        $post = Post::query()->where('type', $this->type)->findOrFail($postId);
        $post->update([
            'status' => 'draft',
            'published_at' => null,
        ]);

        LoggerService::logUserAction('move_to_draft', 'Post', $postId, [
            'post_title' => $post->title,
        ]);

        $this->showSuccessToast(ucfirst($this->contentLabelLower()) . ' dipindahkan ke draft.');
        $this->dispatch('$refresh');
    }

    public function confirmDeletePost($postId)
    {
        $post = Post::query()->where('type', $this->type)->findOrFail($postId);

        $this->showConfirm(
            'Hapus ' . $this->contentLabel,
            "Hapus {$this->contentLabelLower()} '{$post->title}'? Data dapat dipulihkan hanya dari database backup.",
            'deletePost',
            ['postId' => $postId],
            'Ya, hapus',
            'Batal'
        );
    }

    public function deletePost($params)
    {
        if (!auth()->user()->hasPermission($this->permissionName('delete'))) {
            $this->showErrorToast("Anda tidak memiliki izin untuk menghapus {$this->contentLabelLower()}.");
            return;
        }

        $postId = $params['postId'];
        $post = Post::query()->where('type', $this->type)->findOrFail($postId);

        LoggerService::logUserAction('delete', 'Post', $postId, [
            'post_title' => $post->title,
            'status' => $post->status,
        ], LoggerService::LEVEL_WARNING);

        $post->delete();

        $this->showSuccessToast(ucfirst($this->contentLabelLower()) . ' berhasil dihapus.');
        $this->dispatch('$refresh');
    }

    public function permissionName(string $action): string
    {
        return $this->permissionPrefix . '.' . $action;
    }

    public function contentLabelLower(): string
    {
        return strtolower($this->contentLabel);
    }

    public function render()
    {
        $baseQuery = Post::query()
            ->where('type', $this->type)
            ->with([
                'category:id,name',
                'author:id,name',
                'village:id,name',
            ])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('excerpt', 'like', '%'.$this->search.'%')
                        ->orWhere('content', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->status, fn ($query) => $query->where('status', $this->status))
            ->when($this->categoryId, fn ($query) => $query->where('category_id', $this->categoryId));

        $posts = (clone $baseQuery)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'published' => (clone $baseQuery)->where('status', 'published')->count(),
            'draft' => (clone $baseQuery)->where('status', 'draft')->count(),
            'review' => (clone $baseQuery)->where('status', 'review')->count(),
        ];

        $categories = PostCategory::orderBy('name')->get(['id', 'name']);

        return view('livewire.admin.posts.post-list', compact('posts', 'stats', 'categories'));
    }
}
