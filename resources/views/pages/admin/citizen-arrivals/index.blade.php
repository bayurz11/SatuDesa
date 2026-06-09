@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <livewire:admin.citizen-arrivals.citizen-arrival-list />
        <livewire:admin.citizen-arrivals.citizen-arrival-form />
    </div>
@endsection
