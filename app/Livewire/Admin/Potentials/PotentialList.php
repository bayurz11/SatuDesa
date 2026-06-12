<?php

namespace App\Livewire\Admin\Potentials;

use App\Domains\Potential\Models\Potential;
use App\Domains\Potential\Models\PotentialCategory;
use App\Livewire\Concerns\AuthorizesPermissions;
use App\Services\LoggerService;
use App\Shared\Traits\WithAlerts;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class PotentialList extends Component
{
    use WithPagination, WithAlerts, AuthorizesPermissions;

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

    #[On('potentialSaved')]
    public function refreshPotentials(): void
    {
        $this->dispatch('$refresh');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingCategoryId(): void
    {
        $this->resetPage();
    }

    public function setStatusFilter(string $status = ''): void
    {
        $this->status = $status;
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'status', 'categoryId']);
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';

            return;
        }

        $this->sortField = $field;
        $this->sortDirection = $field === 'published_at' ? 'desc' : 'asc';
    }

    public function publishPotential(int $potentialId): void
    {
        $this->authorizePermission('system.settings');
        $potential = Potential::findOrFail($potentialId);
        $potential->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        LoggerService::logUserAction('publish', 'Potential', $potentialId, [
            'potential_title' => $potential->title,
        ]);

        $this->showSuccessToast('Potensi desa berhasil dipublish.');
        $this->dispatch('$refresh');
    }

    public function moveToDraft(int $potentialId): void
    {
        $this->authorizePermission('system.settings');
        $potential = Potential::findOrFail($potentialId);
        $potential->update([
            'status' => 'draft',
            'published_at' => null,
        ]);

        LoggerService::logUserAction('move_to_draft', 'Potential', $potentialId, [
            'potential_title' => $potential->title,
        ]);

        $this->showSuccessToast('Potensi desa dipindahkan ke draft.');
        $this->dispatch('$refresh');
    }

    public function confirmDeletePotential(int $potentialId): void
    {
        $this->authorizePermission('system.settings');
        $potential = Potential::findOrFail($potentialId);

        $this->showConfirm(
            'Hapus Potensi Desa',
            "Hapus data potensi '{$potential->title}'? Tindakan ini tidak dapat dibatalkan dari halaman admin.",
            'deletePotential',
            ['potentialId' => $potentialId],
            'Ya, hapus',
            'Batal'
        );
    }

    public function deletePotential(array $params): void
    {
        $this->authorizePermission('system.settings');
        $potentialId = $params['potentialId'];
        $potential = Potential::findOrFail($potentialId);

        LoggerService::logUserAction('delete', 'Potential', $potentialId, [
            'potential_title' => $potential->title,
            'status' => $potential->status,
        ], LoggerService::LEVEL_WARNING);

        $potential->delete();

        $this->showSuccessToast('Potensi desa berhasil dihapus.');
        $this->dispatch('$refresh');
    }

    public function render()
    {
        $this->authorizePermission('system.settings');
        $baseQuery = Potential::query()
            ->with([
                'category:id,name',
                'village:id,name',
            ])
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery
                        ->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('excerpt', 'like', '%' . $this->search . '%')
                        ->orWhere('content', 'like', '%' . $this->search . '%')
                        ->orWhere('location_name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, fn ($query) => $query->where('status', $this->status))
            ->when($this->categoryId, fn ($query) => $query->where('category_id', $this->categoryId));

        $potentials = (clone $baseQuery)
            ->orderBy($this->sortField, $this->sortDirection)
            ->orderByDesc('is_featured')
            ->paginate($this->perPage);

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'published' => (clone $baseQuery)->where('status', 'published')->count(),
            'review' => (clone $baseQuery)->where('status', 'review')->count(),
            'draft' => (clone $baseQuery)->where('status', 'draft')->count(),
            'featured' => (clone $baseQuery)->where('is_featured', true)->count(),
        ];

        $categories = PotentialCategory::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('livewire.admin.potentials.potential-list', compact('potentials', 'stats', 'categories'));
    }
}
