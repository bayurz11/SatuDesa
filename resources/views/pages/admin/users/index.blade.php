@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <livewire:admin.users.user-list />
    <livewire:admin.users.user-form />
</div>
@endsection
