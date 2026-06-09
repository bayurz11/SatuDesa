<?php

namespace App\Livewire\Admin\Audit;

use App\Domains\Audit\Models\AuditLog;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class AuditLogList extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $level = '';
    public $perPage = 15;

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'level' => ['except' => ''],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategory(): void
    {
        $this->resetPage();
    }

    public function updatingLevel(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'category', 'level']);
        $this->resetPage();
    }

    protected function visibleEntities(): ?array
    {
        $user = auth()->user();

        if (! $user || ! $user->hasPermission('system.logs')) {
            abort(403, 'Anda tidak memiliki izin untuk melihat audit log.');
        }

        if ($user->hasRole('super-admin')) {
            return null;
        }

        $entities = [];

        if ($user->hasAnyPermission(['posts.view', 'post_categories.view'])) {
            $entities = [...$entities, 'Post', 'PostCategory', 'Potential'];
        }

        if ($user->hasPermission('users.view')) {
            $entities[] = 'User';
        }

        if ($user->hasAnyPermission(['roles.view', 'permissions.view'])) {
            $entities = [...$entities, 'Role', 'Permission'];
        }

        return array_values(array_unique($entities));
    }

    protected function availableCategories(): Collection
    {
        return AuditLog::query()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
    }

    protected function availableLevels(): Collection
    {
        return AuditLog::query()
            ->select('level')
            ->distinct()
            ->orderBy('level')
            ->pluck('level');
    }

    public function render()
    {
        $visibleEntities = $this->visibleEntities();

        $baseQuery = AuditLog::query()
            ->with('user:id,name,email')
            ->when($visibleEntities !== null, function ($query) use ($visibleEntities) {
                $query->where(function ($subQuery) use ($visibleEntities) {
                    $subQuery->whereIn('entity_type', $visibleEntities)
                        ->orWhereNull('entity_type');
                });
            })
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('message', 'like', '%' . $this->search . '%')
                        ->orWhere('user_email', 'like', '%' . $this->search . '%')
                        ->orWhere('entity_type', 'like', '%' . $this->search . '%')
                        ->orWhere('action', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->category, fn ($query) => $query->where('category', $this->category))
            ->when($this->level, fn ($query) => $query->where('level', $this->level));

        $logs = (clone $baseQuery)
            ->latest('logged_at')
            ->paginate($this->perPage);

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'today' => (clone $baseQuery)->whereDate('logged_at', today())->count(),
            'warnings' => (clone $baseQuery)->whereIn('level', ['warning', 'error', 'critical', 'alert', 'emergency'])->count(),
            'user_actions' => (clone $baseQuery)->where('category', 'user_action')->count(),
        ];

        $categories = $this->availableCategories();
        $levels = $this->availableLevels();

        return view('livewire.admin.audit.audit-log-list', compact('logs', 'stats', 'categories', 'levels'));
    }
}
