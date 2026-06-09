@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <livewire:admin.posts.post-list
            type="announcement"
            permissionPrefix="announcements"
            contentLabel="Pengumuman"
            contentLabelPlural="Pengumuman" />
        <livewire:admin.posts.post-form
            type="announcement"
            permissionPrefix="announcements"
            contentLabel="Pengumuman"
            contentLabelPlural="Pengumuman" />
    </div>
@endsection
