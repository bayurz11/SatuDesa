<?php

namespace App\Livewire\Admin\Posts;

use App\Domains\Post\Models\Post;
use App\Domains\Post\Models\PostCategory;
use App\Domains\Village\Models\Village;
use App\Services\LoggerService;
use App\Shared\Traits\WithAlerts;
use App\Support\StoredContentSanitizer;
use App\Support\UploadStorage;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class PostForm extends Component
{
    use WithAlerts, WithFileUploads;

    public $type = Post::TYPE_NEWS;
    public $permissionPrefix = 'posts';
    public $contentLabel = 'Berita';
    public $contentLabelPlural = 'Berita';
    public $postId;
    public $village_id = '';
    public $category_id = '';
    public $title = '';
    public $slug = '';
    public $excerpt = '';
    public $content = '';
    public $cover_image = null;
    public $existing_cover_image_url = null;
    public $cover_image_alt = '';
    public $cover_image_caption = '';
    public $is_featured = false;
    public $meta_title = '';
    public $meta_description = '';
    public $metaTitleLocked = true;
    public $metaDescriptionLocked = true;
    public $tags = [];
    public $newTag = '';
    public $status = 'draft';
    public $published_at = '';
    public $event_at = '';
    public $event_location = '';
    public $showModal = false;
    public $isEditing = false;

    protected function rules()
    {
        return [
            'village_id' => 'required|exists:villages,id',
            'category_id' => 'required|exists:post_categories,id',
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('posts', 'slug')->ignore($this->postId),
            ],
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
            'cover_image_alt' => 'nullable|string|max:255',
            'cover_image_caption' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:320',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'newTag' => 'nullable|string|max:50',
            'status' => 'required|in:draft,review,published',
            'published_at' => 'nullable|date',
            'event_at' => 'nullable|date',
            'event_location' => 'nullable|string|max:255',
        ];
    }

    public function mount(
        string $type = Post::TYPE_NEWS,
        string $permissionPrefix = 'posts',
        string $contentLabel = 'Berita',
        string $contentLabelPlural = 'Berita',
        $postId = null
    )
    {
        $this->type = $type;
        $this->permissionPrefix = $permissionPrefix;
        $this->contentLabel = $contentLabel;
        $this->contentLabelPlural = $contentLabelPlural;
        $this->village_id = (string) Village::orderBy('name')->value('id');
        $this->category_id = $this->defaultCategoryId();

        if ($postId) {
            $this->loadPost($postId);
        }
    }

    public function updatedTitle($value)
    {
        $this->slug = Str::slug($value);
        $this->cover_image_alt = $this->cover_image_alt ?: $value;

        if ($this->metaTitleLocked) {
            $this->meta_title = Str::limit(trim($value), 60, '');
        }
    }

    public function updatedExcerpt($value)
    {
        if ($this->metaDescriptionLocked) {
            $this->meta_description = Str::limit(trim(strip_tags((string) $value)), 160, '');
        }
    }

    public function updatedMetaTitle($value)
    {
        $this->metaTitleLocked = blank($value) || $value === Str::limit(trim($this->title), 60, '');
    }

    public function updatedMetaDescription($value)
    {
        $autoDescription = Str::limit(trim(strip_tags((string) $this->excerpt)), 160, '');
        $this->metaDescriptionLocked = blank($value) || $value === $autoDescription;
    }

    public function resetMetaTitle()
    {
        $this->metaTitleLocked = true;
        $this->meta_title = Str::limit(trim($this->title), 60, '');
    }

    public function resetMetaDescription()
    {
        $this->metaDescriptionLocked = true;
        $this->meta_description = Str::limit(trim(strip_tags((string) $this->excerpt)), 160, '');
    }

    public function loadPost($postId)
    {
        $post = Post::query()->where('type', $this->type)->findOrFail($postId);

        $this->postId = $post->id;
        $this->village_id = (string) $post->village_id;
        $this->category_id = (string) $post->category_id;
        $this->title = $post->title;
        $this->slug = $post->slug;
        $this->excerpt = $post->excerpt ?? '';
        $this->content = $post->editor_content;
        $this->cover_image = null;
        $this->existing_cover_image_url = $post->cover_image_url;
        $this->cover_image_alt = $post->cover_image_alt ?? '';
        $this->cover_image_caption = $post->cover_image_caption ?? '';
        $this->is_featured = (bool) $post->is_featured;
        $this->meta_title = $post->meta_title ?? '';
        $this->meta_description = $post->meta_description ?? '';
        $this->metaTitleLocked = ($this->meta_title ?: '') === Str::limit(trim((string) $post->title), 60, '');
        $this->metaDescriptionLocked = ($this->meta_description ?: '') === Str::limit(trim(strip_tags((string) ($post->excerpt ?? ''))), 160, '');
        $this->tags = collect($post->tags ?? [])->map(fn ($tag) => trim((string) $tag))->filter()->values()->all();
        $this->newTag = '';
        $this->status = $post->status;
        $this->published_at = optional($post->published_at)?->format('Y-m-d\TH:i');
        $this->event_at = optional($post->event_at)?->format('Y-m-d\TH:i');
        $this->event_location = $post->event_location ?? '';
        $this->isEditing = true;
    }

    #[On('openPostForm')]
    public function openModal($postId = null)
    {
        $this->resetForm();

        if ($postId) {
            $this->loadPost($postId);
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
        $this->postId = null;
        $this->village_id = (string) Village::orderBy('name')->value('id');
        $this->category_id = $this->defaultCategoryId();
        $this->title = '';
        $this->slug = '';
        $this->excerpt = '';
        $this->content = '';
        $this->cover_image = null;
        $this->existing_cover_image_url = null;
        $this->cover_image_alt = '';
        $this->cover_image_caption = '';
        $this->is_featured = false;
        $this->meta_title = '';
        $this->meta_description = '';
        $this->metaTitleLocked = true;
        $this->metaDescriptionLocked = true;
        $this->tags = [];
        $this->newTag = '';
        $this->status = 'draft';
        $this->published_at = '';
        $this->event_at = '';
        $this->event_location = '';
        $this->isEditing = false;
        $this->resetErrorBag();
    }

    public function addTag()
    {
        $incomingTags = collect(explode(',', $this->newTag))
            ->map(fn ($tag) => trim($tag))
            ->filter()
            ->values()
            ->all();

        if ($incomingTags === []) {
            $this->newTag = '';
            return;
        }

        $mergedTags = collect([...$this->tags, ...$incomingTags])
            ->map(fn ($tag) => trim((string) $tag))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $this->tags = $mergedTags;
        $this->newTag = '';
        $this->resetValidation(['newTag', 'tags']);
    }

    public function removeTag($index)
    {
        $tags = collect($this->tags)
            ->values()
            ->all();

        unset($tags[$index]);

        $this->tags = array_values($tags);
    }

    public function save()
    {
        $permissionAction = $this->isEditing ? 'edit' : 'create';
        if (! auth()->user()->hasPermission($this->permissionName($permissionAction))) {
            $this->showErrorToast("Anda tidak memiliki izin untuk menyimpan {$this->contentLabelLower()}.");
            return;
        }

        $this->slug = Str::slug($this->slug ?: $this->title);
        $this->addTag();
        $this->validate();

        $post = $this->isEditing
            ? Post::query()->where('type', $this->type)->findOrFail($this->postId)
            : new Post();

        $coverImagePath = $post->cover_image_path;

        if ($this->cover_image) {
            if ($coverImagePath) {
                Storage::disk(UploadStorage::disk())->delete($coverImagePath);
            }

            $coverImagePath = $this->cover_image->store('posts/covers', UploadStorage::disk());
        }

        $publishedAt = $this->status === 'published'
            ? ($this->published_at ?: now()->format('Y-m-d\TH:i'))
            : null;

        $tagItems = collect($this->tags)
            ->map(fn ($tag) => trim((string) $tag))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $payload = [
            'village_id' => (int) $this->village_id,
            'category_id' => (int) $this->category_id,
            'author_id' => auth()->id(),
            'type' => $this->type,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'content_raw' => $this->content,
            'content_safe' => StoredContentSanitizer::clean($this->content),
            'cover_image_path' => $coverImagePath,
            'cover_image_alt' => $this->cover_image_alt ?: $this->title,
            'cover_image_caption' => $this->cover_image_caption,
            'is_featured' => (bool) $this->is_featured,
            'meta_title' => $this->meta_title ?: $this->title,
            'meta_description' => $this->meta_description ?: $this->excerpt,
            'tags' => $tagItems,
            'status' => $this->status,
            'published_at' => $publishedAt,
            'event_at' => $this->type === Post::TYPE_ANNOUNCEMENT ? ($this->event_at ?: null) : null,
            'event_location' => $this->type === Post::TYPE_ANNOUNCEMENT ? ($this->event_location ?: null) : null,
        ];

        if ($this->isEditing) {
            $post->update($payload);
        } else {
            $post = Post::create($payload);
        }

        LoggerService::logUserAction($this->isEditing ? 'update' : 'create', 'Post', $post->id, [
            'post_title' => $post->title,
            'status' => $post->status,
            'is_featured' => (bool) $post->is_featured,
        ]);

        $successMessage = $this->isEditing
            ? ucfirst($this->contentLabelLower()) . ' berhasil diperbarui.'
            : ucfirst($this->contentLabelLower()) . ' berhasil dibuat.';

        $this->showSuccessToast($successMessage);

        $this->closeModal();
        $this->dispatch('postSaved');
    }

    public function render()
    {
        $villages = Village::orderBy('name')->get(['id', 'name']);
        $categories = PostCategory::orderBy('name')->get(['id', 'name', 'description']);

        return view('livewire.admin.posts.post-form', compact('villages', 'categories'));
    }

    public function permissionName(string $action): string
    {
        return $this->permissionPrefix . '.' . $action;
    }

    public function contentLabelLower(): string
    {
        return strtolower($this->contentLabel);
    }

    public function eventDayLabel(): string
    {
        if (blank($this->event_at)) {
            return '-';
        }

        return Carbon::parse($this->event_at)->locale('id')->translatedFormat('l');
    }

    protected function defaultCategoryId(): string
    {
        if ($this->type !== Post::TYPE_ANNOUNCEMENT) {
            return '';
        }

        return (string) (PostCategory::query()->where('slug', 'pengumuman')->value('id') ?? '');
    }
}
