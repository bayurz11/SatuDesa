<?php

namespace App\Livewire\Content;

use Livewire\Component;
use Livewire\WithPagination;
use App\Domains\Post\Models\Post;
use App\Domains\Category\Models\Category;

class ContentHub extends Component
{
    use WithPagination;

    public string $mode = 'announcement';

    public string $search = '';
    public ?string $category = null;
    public int $perPage = 10;
    public string $sortField = 'published_at';
    public string $sortDirection = 'desc';

    /** Bisa di-set dari luar; default true */
    public bool $showPagination = true;

    /** 🔦 Khusus beranda: featured + 4 lainnya (tanpa paginasi) */
    public bool $homeSpotlight = false;
    public int $spotlightLimit = 5; // featured + 4

    protected $queryString = [
        'search'        => ['except' => ''],
        'category'      => ['except' => null],
        'perPage'       => ['except' => 10],
        'sortField'     => ['except' => 'published_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function mount(string $mode = 'announcement', bool $showPagination = true): void
    {
        $this->mode = in_array($mode, ['announcement', 'news', 'potensi'], true) ? $mode : 'announcement';

        $this->perPage = match ($this->mode) {
            'news', 'potensi' => 6,
            'announcement'    => 3,
            default           => 10,
        };

        // Backward-compat untuk ?q= lama
        if (request()->filled('q') && empty($this->search)) {
            $this->search = (string) request()->query('q');
        }

        // Deteksi beranda -> aktifkan spotlight, hilangkan pagination
        $isHome = request()->routeIs('beranda'); // pastikan nama route beranda = 'beranda'
        $this->homeSpotlight = $isHome;
        $this->showPagination = $showPagination && ! $isHome;
    }

    /** Reset page saat filter berubah */
    public function updatingSearch()
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

    public function paginationView()
    {
        return 'livewire.content.pagination.pagination';
    }

    protected function baseQuery()
    {
        return Post::query()
            ->with(['category:id,name,slug', 'tags:id,name,slug'])
            ->where('status', 'published')
            ->when($this->mode !== 'potensi', fn($q) => $q->where('content_type', $this->mode))
            ->when($this->mode === 'potensi', fn($q) => $q->where('content_type', 'potensi'))

            // 🔎 cari pakai scope search() kalau ada; fallback LIKE
            ->when($this->search, function ($q) {
                if (method_exists(Post::class, 'search')) {
                    $q->search($this->search);
                    return;
                }
                $t = '%' . $this->search . '%';
                $q->where(function ($w) use ($t) {
                    $w->where('title', 'like', $t)
                        ->orWhere('summary', 'like', $t)
                        ->orWhere('body_html', 'like', $t)
                        ->orWhereHas('tags', fn($tq) => $tq->where('name', 'like', $t))
                        ->orWhereHas('category', fn($cq) => $cq->where('name', 'like', $t));
                });
            })

            ->when($this->category, fn($q) => $q->where('category_id', $this->category))
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function render()
    {
        $categories = Category::orderBy('sort_order')->get(['id', 'name']);

        // 🔦 Spotlight untuk beranda (tanpa pagination)
        $spotlight = $this->homeSpotlight
            ? cache()->remember(
                "home:spotlight:{$this->mode}:{$this->spotlightLimit}:" . md5($this->search . '|' . $this->category),
                60,
                fn() => (clone $this->baseQuery())->take($this->spotlightLimit)->get()
            )
            : collect();

        // List biasa (index) pakai paginate
        $items = $this->homeSpotlight
            ? collect()
            : $this->baseQuery()->paginate($this->perPage);

        [$title, $subtitle] = match ($this->mode) {
            'announcement' => ['Pengumuman', 'Informasi & agenda resmi desa'],
            'news'         => ['Berita Desa', 'Kabar terbaru seputar Desa Mentuda'],
            'potensi'      => ['Potensi Desa', 'Ekonomi, wisata, pertanian, perikanan & kreatif'],
            default        => ['Konten', ''],
        };

        return view('livewire.content.content-hub', compact('items', 'spotlight', 'categories', 'title', 'subtitle'))
            ->with('showPagination', $this->showPagination)
            ->with('homeSpotlight', $this->homeSpotlight);
    }
}
