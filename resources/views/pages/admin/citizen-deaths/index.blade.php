@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <livewire:admin.citizen-deaths.citizen-death-list />
        <livewire:admin.citizen-deaths.citizen-death-form />
    </div>
@endsection
