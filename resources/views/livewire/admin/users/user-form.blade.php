<div>
    @if($showModal)
        <div class="app-modal-overlay" data-modal-overlay wire:click="closeModal">
            <div class="app-modal-shell">
                <div class="app-modal-panel max-w-3xl"
                    wire:click.stop>
                    <div class="border-b border-slate-200 bg-gradient-to-r from-slate-50 via-blue-50 to-indigo-50 px-6 py-5">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold text-gray-900">
                                {{ $isEditing ? 'Edit User' : 'Create User' }}
                            </h3>
                            <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="mt-1 text-sm text-slate-500">
                            {{ $isEditing ? 'Perbarui detail akun dan akses pengguna.' : 'Tambahkan akun baru dan tentukan role aksesnya.' }}
                        </p>
                    </div>

                    <form wire:submit="save" class="flex min-h-0 flex-1 flex-col">
                        <div class="app-modal-body space-y-6 px-6 py-6">
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input wire:model="name" type="text" id="name" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('name') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input wire:model="email" type="email" id="email" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('email') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">
                                        Password {{ $isEditing ? '(leave blank to keep current)' : '' }}
                                    </label>
                                    <input wire:model="password" type="password" id="password" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('password') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                    <input wire:model="password_confirmation" type="password" id="password_confirmation" class="mt-2 block w-full rounded-xl border border-gray-300 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('password_confirmation') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-4">
                                <label class="flex items-center">
                                    <input wire:model="is_active" type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700">Active</span>
                                </label>
                            </div>

                            <div>
                                <label class="mb-3 block text-sm font-medium text-gray-700">Roles</label>
                                <div class="max-h-64 space-y-3 overflow-y-auto rounded-2xl border border-gray-300 p-4">
                                    @foreach($roles as $role)
                                        <label class="flex items-start rounded-xl border border-transparent p-2 transition hover:border-blue-100 hover:bg-blue-50/60">
                                            <input 
                                                wire:model="selectedRoles" 
                                                type="checkbox" 
                                                value="{{ $role->id }}" 
                                                class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                            >
                                            <div class="ml-3">
                                                <span class="text-sm font-semibold text-gray-900">{{ $role->display_name }}</span>
                                                @if($role->description)
                                                    <p class="text-xs text-gray-500">{{ $role->description }}</p>
                                                @endif
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                @error('selectedRoles') <span class="mt-1 block text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="app-modal-footer px-6 py-4">
                            <button type="button" wire:click="closeModal" class="rounded-xl bg-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Cancel
                            </button>
                            <button type="submit" class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                {{ $isEditing ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
