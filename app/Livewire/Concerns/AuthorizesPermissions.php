<?php

namespace App\Livewire\Concerns;

use Symfony\Component\HttpKernel\Exception\HttpException;

trait AuthorizesPermissions
{
    protected function authorizePermission(string $permission): void
    {
        $user = auth()->user();

        if (! $user || ! $user->hasPermission($permission)) {
            throw new HttpException(403, 'You do not have permission to perform this action.');
        }
    }

    protected function authorizeAllPermissions(array $permissions): void
    {
        $user = auth()->user();

        if (! $user || ! $user->hasAllPermissions($permissions)) {
            throw new HttpException(403, 'You do not have permission to perform this action.');
        }
    }

    protected function authorizeCrudAction(bool $isEditing, string $createPermission, string $editPermission): void
    {
        $this->authorizePermission($isEditing ? $editPermission : $createPermission);
    }
}
