@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <livewire:admin.posts.post-list />
        <livewire:admin.posts.post-form />
    </div>
@endsection
