<?php

namespace App\Livewire\Admin\Users;

use App\Domains\User\Models\User;
use App\Domains\Role\Models\Role;
use App\Livewire\Concerns\AuthorizesPermissions;
use App\Services\LoggerService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class UserForm extends Component
{
    use AuthorizesPermissions;

    public $userId;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $is_active = true;
    public $selectedRoles = [];
    public $showModal = false;
    public $isEditing = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->userId),
            ],
            'password' => $this->isEditing ? 'nullable|min:8|confirmed' : 'required|min:8|confirmed',
            'is_active' => 'boolean',
            'selectedRoles' => 'array',
        ];
    }

    public function mount($userId = null)
    {
        $this->authorizePermission('users.view');

        if ($userId) {
            $this->loadUser($userId);
        }
    }

    public function loadUser($userId)
    {
        $this->authorizePermission('users.edit');

        $user = User::with('roles')->findOrFail($userId);

        if ($user->hasRole('super-admin') && ! auth()->user()?->hasRole('super-admin')) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah akun super-admin.');
        }
        
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->is_active = $user->is_active;
        $this->selectedRoles = $user->roles->pluck('id')->toArray();
        $this->isEditing = true;
    }

    #[On('openUserForm')]
    public function openModal($userId = null)
    {
        $this->authorizePermission($userId ? 'users.edit' : 'users.create');
        $this->resetForm();
        
        if ($userId) {
            $this->loadUser($userId);
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
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->is_active = true;
        $this->selectedRoles = [];
        $this->isEditing = false;
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->authorizeCrudAction($this->isEditing, 'users.create', 'users.edit');
        $this->validate();

        if ($this->isEditing) {
            $user = User::findOrFail($this->userId);

            if ($user->hasRole('super-admin') && ! auth()->user()?->hasRole('super-admin')) {
                abort(403, 'Anda tidak memiliki izin untuk mengubah akun super-admin.');
            }

            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'is_active' => $this->is_active,
            ]);
            
            if ($this->password) {
                $user->update(['password' => Hash::make($this->password)]);
            }
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'is_active' => $this->is_active,
            ]);
        }

        $user->roles()->sync($this->validatedRoleIds($user));

        LoggerService::logUserAction($this->isEditing ? 'update' : 'create', 'User', $user->id, [
            'target_user_email' => $user->email,
            'target_user_name' => $user->name,
            'is_active' => (bool) $user->is_active,
            'role_ids' => $this->selectedRoles,
        ]);

        session()->flash('message', $this->isEditing ? 'User updated successfully.' : 'User created successfully.');
        
        $this->closeModal();
        $this->dispatch('userSaved');
    }

    public function render()
    {
        $this->authorizePermission('users.view');
        $roles = $this->availableRoles();
        
        return view('livewire.admin.users.user-form', compact('roles'));
    }

    protected function availableRoles(): Collection
    {
        $user = auth()->user();

        if (! $user || ! $user->hasPermission('roles.edit')) {
            return collect();
        }

        return Role::query()
            ->where('is_active', true)
            ->when(! $user->hasRole('super-admin'), function ($query) {
                $query->where('name', '!=', 'super-admin');
            })
            ->orderBy('name')
            ->get();
    }

    protected function validatedRoleIds(User $targetUser): array
    {
        $actor = auth()->user();
        $selectedRoleIds = collect($this->selectedRoles)
            ->map(fn ($roleId) => (int) $roleId)
            ->filter()
            ->values();

        if (! $actor || ! $actor->hasPermission('roles.edit')) {
            if ($selectedRoleIds->isNotEmpty() && ! $this->isEditing) {
                $this->addError('selectedRoles', 'Anda tidak memiliki izin untuk menetapkan role.');
                throw \Illuminate\Validation\ValidationException::withMessages($this->getErrorBag()->toArray());
            }

            return $this->isEditing
                ? $targetUser->roles()->pluck('roles.id')->map(fn ($id) => (int) $id)->all()
                : [];
        }

        $allowedRoleIds = Role::query()
            ->where('is_active', true)
            ->when(! $actor->hasRole('super-admin'), function ($query) {
                $query->where('name', '!=', 'super-admin');
            })
            ->pluck('id')
            ->map(fn ($id) => (int) $id);

        if ($selectedRoleIds->diff($allowedRoleIds)->isNotEmpty()) {
            $this->addError('selectedRoles', 'Role yang dipilih tidak valid atau tidak boleh ditetapkan.');
            throw \Illuminate\Validation\ValidationException::withMessages($this->getErrorBag()->toArray());
        }

        $currentSuperAdminRoleIds = $targetUser->roles()
            ->where('name', 'super-admin')
            ->pluck('roles.id')
            ->map(fn ($id) => (int) $id);

        if (! $actor->hasRole('super-admin') && $currentSuperAdminRoleIds->isNotEmpty()) {
            return $targetUser->roles()->pluck('roles.id')->map(fn ($id) => (int) $id)->all();
        }

        return $selectedRoleIds->all();
    }
}
