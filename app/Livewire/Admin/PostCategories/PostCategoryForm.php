<?php

namespace App\Livewire\Admin\PostCategories;

use App\Domains\Post\Models\PostCategory;
use App\Domains\Village\Models\Village;
use App\Livewire\Concerns\AuthorizesPermissions;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class PostCategoryForm extends Component
{
    use AuthorizesPermissions;

    public $categoryId;
    public $village_id = '';
    public $name = '';
    public $slug = '';
    public $description = '';
    public $showModal = false;
    public $isEditing = false;

    protected function rules()
    {
        return [
            'village_id' => 'nullable|exists:villages,id',
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('post_categories', 'slug')->ignore($this->categoryId),
            ],
            'description' => 'nullable|string|max:500',
        ];
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function loadCategory($categoryId)
    {
        $this->authorizePermission('post_categories.edit');
        $category = PostCategory::findOrFail($categoryId);

        $this->categoryId = $category->id;
        $this->village_id = $category->village_id ? (string) $category->village_id : '';
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description ?? '';
        $this->isEditing = true;
    }

    #[On('openPostCategoryForm')]
    public function openModal($categoryId = null)
    {
        $this->authorizePermission($categoryId ? 'post_categories.edit' : 'post_categories.create');
        $this->resetForm();

        if ($categoryId) {
            $this->loadCategory($categoryId);
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->categoryId = null;
        $this->village_id = '';
        $this->name = '';
        $this->slug = '';
        $this->description = '';
        $this->isEditing = false;
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->authorizeCrudAction($this->isEditing, 'post_categories.create', 'post_categories.edit');
        $this->slug = Str::slug($this->slug ?: $this->name);
        $this->validate();

        $payload = [
            'village_id' => $this->village_id ?: null,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
        ];

        if ($this->isEditing) {
            PostCategory::findOrFail($this->categoryId)->update($payload);
        } else {
            PostCategory::create($payload);
        }

        session()->flash('message', $this->isEditing ? 'Kategori berita berhasil diperbarui.' : 'Kategori berita berhasil dibuat.');

        $this->closeModal();
        $this->dispatch('postCategorySaved');
    }

    public function render()
    {
        $this->authorizePermission('post_categories.view');
        $villages = Village::orderBy('name')->get(['id', 'name']);

        return view('livewire.admin.post-categories.post-category-form', compact('villages'));
    }
}
