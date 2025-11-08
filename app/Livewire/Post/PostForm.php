<?php

namespace App\Livewire\Post;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Domains\Tag\Models\Tag;
use Illuminate\Validation\Rule;
use App\Domains\Post\Models\Post;

use App\Shared\Traits\WithAlerts;
use Illuminate\Support\Facades\Storage;
use App\Domains\Category\Models\Category;

class PostForm extends Component
{
    use WithFileUploads, WithAlerts;

    public bool $showModal = false;
    public bool $isEditing = false;

    // fields
    public ?string $postId = null;
    public ?string $category_id = null;
    public string $content_type = 'announcement';
    public string $title = '';
    public string $slug = '';
    public ?string $summary = null;
    public ?string $body_html = null;

    // announcement
    public ?string $location = null;
    public ?string $organizer = null;
    public ?string $start_at = null;
    public ?string $end_at = null;
    public bool $is_all_day = false;

    // news
    public ?string $author_name = null;
    public ?int $read_minutes = null;
    public ?string $source_url = null;

    // media & publish
    public $cover;                // UploadedFile|null (baru)
    public ?string $cover_path = null; // path relatif yang disimpan ke DB, mis: "storage/covers/xxxx.jpg"
    public string $status = 'draft';
    public ?string $published_at = null;

    // tags
    public array $tag_ids = [];

    protected $listeners = ['openPostForm' => 'openForm'];

    public function openForm(?string $id = null): void
    {
        $this->resetValidation();

        if ($id) {
            $post = Post::with('tags:id')->findOrFail($id);
            $this->fill($post->only([
                'id',
                'category_id',
                'content_type',
                'title',
                'slug',
                'summary',
                'body_html',
                'location',
                'organizer',
                'author_name',
                'read_minutes',
                'source_url',
                'cover_path', // ← path lama akan terisi di properti ini
                'status',
            ]));

            $this->postId       = $post->id;
            $this->is_all_day   = (bool) $post->is_all_day;
            $this->start_at     = optional($post->start_at)->format('Y-m-d\TH:i');
            $this->end_at       = optional($post->end_at)->format('Y-m-d\TH:i');
            $this->published_at = optional($post->published_at)->format('Y-m-d\TH:i');
            $this->tag_ids      = $post->tags->pluck('id')->all();
            $this->isEditing    = true;
        } else {
            $this->reset([
                'postId',
                'category_id',
                'content_type',
                'title',
                'slug',
                'summary',
                'body_html',
                'location',
                'organizer',
                'author_name',
                'read_minutes',
                'source_url',
                'cover',
                'cover_path',
                'status',
                'start_at',
                'end_at',
                'is_all_day',
                'published_at',
                'tag_ids'
            ]);
            $this->content_type = 'announcement';
            $this->status       = 'draft';
            $this->isEditing    = false;
        }

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function updatedTitle(): void
    {
        if (blank($this->slug)) $this->slug = Str::slug($this->title);
    }

    protected function rules(): array
    {
        return [
            'category_id'  => ['nullable', 'string'],
            'content_type' => ['required', Rule::in(['announcement', 'news'])],
            'title'        => ['required', 'string', 'max:200'],
            'slug'         => ['nullable', 'string', 'max:220', Rule::unique('posts', 'slug')->ignore($this->postId)],
            'summary'      => ['nullable', 'string'],
            'body_html'    => ['nullable', 'string'],

            // announcement
            'location'     => ['nullable', 'string', 'max:200'],
            'organizer'    => ['nullable', 'string', 'max:160'],
            'start_at'     => ['nullable', 'date'],
            'end_at'       => ['nullable', 'date', 'after_or_equal:start_at'],
            'is_all_day'   => ['boolean'],

            // news
            'author_name'  => ['nullable', 'string', 'max:160'],
            'read_minutes' => ['nullable', 'integer', 'min:0'],
            'source_url'   => ['nullable', 'url'],

            // publish
            'status'       => ['required', Rule::in(['draft', 'scheduled', 'published', 'archived'])],
            'published_at' => ['nullable', 'date'],

            // tags
            'tag_ids'      => ['array'],
            'tag_ids.*'    => ['string'],

            // cover (baru)
            'cover'        => ['nullable', 'image', 'max:4096'], // 4MB
        ];
    }

    public function save(): void
    {
        $data = $this->validate();

        // Isi slug bila kosong
        if (blank($data['slug']) && filled($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // === Handle upload cover mirip StrukturForm ===
        if ($this->cover) {
            // Pastikan folder tujuan ada
            Storage::disk('public_path')->makeDirectory('storage/covers');

            // Nama file unik
            $ext = strtolower($this->cover->getClientOriginalExtension() ?: 'jpg');
            $namaFile = Str::random(16) . '.' . $ext;

            // Simpan ke public/storage/covers (disk public_path)
            // NB: storeAs pakai path relatif terhadap root disk
            //     Di sini kita simpan ke "storage/covers/xxx.jpg" agar langsung bisa di-asset()
            $relative = $this->cover->storeAs('storage/covers', $namaFile, 'public_path'); // "storage/covers/xxxx.jpg"

            // Tulis path ke DB (siap dipakai asset())
            $data['cover_path'] = $relative;

            // Hapus cover lama jika update
            if ($this->isEditing && $this->cover_path) {
                // cover_path berbentuk "storage/covers/xxxx.jpg" → jadikan relatif dari public/
                $old = ltrim($this->cover_path, '/'); // "storage/covers/xxxx.jpg"
                if (Storage::disk('public_path')->exists($old)) {
                    Storage::disk('public_path')->delete($old);
                }
            }
        }
        // === end handle cover ===

        // Konversi datetime HTML5 (Y-m-d\TH:i) → biarkan cast model yg urus (string OK)
        $data['start_at']     = $this->start_at ?: null;
        $data['end_at']       = $this->end_at ?: null;
        $data['published_at'] = $this->published_at ?: null;

        if ($this->isEditing) {
            $post = Post::findOrFail($this->postId);
            $post->update($data);
        } else {
            $post = Post::create($data);
        }

        // sync tags
        $post->tags()->sync($this->tag_ids ?? []);

        $this->showSuccessToast($this->isEditing ? 'Post diperbarui!' : 'Post ditambahkan!');
        $this->showModal = false;
        $this->dispatch('post:saved');
    }

    public function render()
    {
        $categories = Category::orderBy('name')->get(['id', 'name']);
        $tags       = Tag::active()->orderBy('name')->get(['id', 'name']);
        return view('livewire.post.post-form', compact('categories', 'tags'));
    }
}
