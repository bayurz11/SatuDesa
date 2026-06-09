@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <livewire:admin.citizens.citizen-list />
        <livewire:admin.citizens.citizen-form />
    </div>
@endsection
