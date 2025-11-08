<?php

namespace App\Livewire\Content;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Post\Models\Post; // model Post yang sudah kamu buat
use App\Domains\Category\Models\Category;

class ContentHub extends Component
{
    use WithPagination;

    /** @var 'announcement'|'news'|'potensi' */
    public string $mode = 'announcement';

    // Filter UI (opsional)
    public ?string $q = null;
    public ?string $category = null;
    public int $perPage = 10;
    public string $sortField = 'published_at';
    public string $sortDirection = 'desc';

    protected $queryString = [
        'q'             => ['except' => null],
        'category'      => ['except' => null],
        'perPage'       => ['except' => 10],
        'sortField'     => ['except' => 'published_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function mount(string $mode = 'announcement')
    {
        // Validasi mode
        $this->mode = in_array($mode, ['announcement', 'news', 'potensi']) ? $mode : 'announcement';

        // Default page size sesuai halaman
        if ($this->mode === 'news') $this->perPage = 12;
        if ($this->mode === 'announcement') $this->perPage = 9;
        if ($this->mode === 'potensi') $this->perPage = 12;
    }

    public function updatingQ()
    {
        $this->resetPage();
    }
    public function updatingCategory()
    {
        $this->resetPage();
    }
    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        $allowed = ['published_at', 'created_at', 'title'];
        if (!in_array($field, $allowed, true)) return;

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    protected function baseQuery()
    {
        $q = Post::query()
            ->with(['category:id,name,slug', 'tags:id,name,slug'])
            ->where('status', 'published')
            ->when($this->mode !== 'potensi', fn($x) => $x->where('content_type', $this->mode))
            // kalau potensi desa itu juga disimpan di posts, pakai content_type khusus, misal 'potensi'
            ->when($this->mode === 'potensi',  fn($x) => $x->where('content_type', 'potensi'))
            ->when($this->q, function ($x) {
                $term = "%{$this->q}%";
                $x->where(function ($w) use ($term) {
                    $w->where('title', 'like', $term)
                        ->orWhere('summary', 'like', $term)
                        ->orWhere('body_html', 'like', $term);
                });
            })
            ->when($this->category, fn($x) => $x->where('category_id', $this->category))
            ->orderBy($this->sortField, $this->sortDirection);

        // Hanya tampilkan yang sudah terbit
        $q->whereNotNull('published_at')->where('published_at', '<=', now());

        return $q;
    }

    public function render()
    {
        $categories = Category::orderBy('sort_order')->get(['id', 'name']);

        $items = $this->baseQuery()->paginate($this->perPage);

        // Tentukan judul & subjudul berdasarkan mode
        [$title, $subtitle] = match ($this->mode) {
            'announcement' => ['Pengumuman', 'Informasi & agenda resmi desa'],
            'news'         => ['Berita Desa', 'Kabar terbaru seputar Desa Mentuda'],
            'potensi'      => ['Potensi Desa', 'Ekonomi, wisata, pertanian, perikanan & kreatif'],
            default        => ['Konten', ''],
        };

        return view('livewire.content.content-hub', compact('items', 'categories', 'title', 'subtitle'));
    }
}
