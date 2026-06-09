<?php

namespace App\Livewire\Admin;

use App\Support\UploadStorage;
use App\Shared\Traits\WithAlerts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileForm extends Component
{
    use WithAlerts, WithFileUploads;

    public $name = '';
    public $email = '';
    public $current_email = '';
    public $avatar = null;
    public $avatarPreviewUrl = null;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name ?? '';
        $this->email = $user->email ?? '';
        $this->current_email = $user->email ?? '';
        $this->avatar = null;
        $this->avatarPreviewUrl = $user?->avatar_url;
    }

    public function resetForm()
    {
        $this->mount();
        $this->resetErrorBag();
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'avatar' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();

        if ($this->avatar) {
            if ($user->avatar_path) {
                Storage::disk(UploadStorage::disk())->delete($user->avatar_path);
            }

            $user->avatar_path = $this->avatar->store('avatars', UploadStorage::disk());
        }
        
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'avatar_path' => $user->avatar_path,
        ]);

        $this->current_email = $this->email;
        $freshUser = $user->fresh();
        $this->avatarPreviewUrl = $freshUser->avatar_url;
        $this->avatar = null;
        $this->showSuccessToast('Profile updated successfully!');
        $this->dispatch(
            'profileUpdated',
            avatarUrl: $freshUser->avatar_url,
            name: $freshUser->name,
            email: $freshUser->email,
            initials: strtoupper(substr($freshUser->name, 0, 2))
        );
        $this->dispatch('$refresh');
    }

    public function render()
    {
        return view('livewire.admin.profile-form');
    }
}
