<?php

namespace App\Livewire\Admin\PostCategories;

use App\Domains\Post\Models\PostCategory;
use App\Shared\Traits\WithAlerts;
use Livewire\Component;
use Livewire\WithPagination;

class PostCategoryList extends Component
{
    use WithPagination, WithAlerts;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function confirmDeleteCategory($categoryId)
    {
        $category = PostCategory::findOrFail($categoryId);

        if ($category->posts()->exists()) {
            $this->showErrorToast('Kategori ini masih dipakai oleh artikel berita.');
            return;
        }

        $this->showConfirm(
            'Hapus Kategori',
            "Hapus kategori '{$category->name}'? Tindakan ini tidak bisa dibatalkan.",
            'deleteCategory',
            ['categoryId' => $categoryId],
            'Ya, hapus',
            'Batal'
        );
    }

    public function deleteCategory($params)
    {
        if (!auth()->user()->hasPermission('post_categories.delete')) {
            $this->showErrorToast('Anda tidak memiliki izin untuk menghapus kategori.');
            return;
        }

        $category = PostCategory::findOrFail($params['categoryId']);

        if ($category->posts()->exists()) {
            $this->showErrorToast('Kategori ini masih dipakai oleh artikel berita.');
            return;
        }

        $category->delete();

        $this->showSuccessToast('Kategori berita berhasil dihapus.');
        $this->dispatch('$refresh');
    }

    public function render()
    {
        $categories = PostCategory::query()
            ->withCount('posts')
            ->with('village:id,name')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('slug', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.admin.post-categories.post-category-list', compact('categories'));
    }
}
