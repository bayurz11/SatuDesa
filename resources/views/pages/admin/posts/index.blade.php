@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <livewire:admin.posts.post-list
            type="news"
            permissionPrefix="posts"
            contentLabel="Berita"
            contentLabelPlural="Berita" />
        <livewire:admin.posts.post-form
            type="news"
            permissionPrefix="posts"
            contentLabel="Berita"
            contentLabelPlural="Berita" />
    </div>
@endsection
