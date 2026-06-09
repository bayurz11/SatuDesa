@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <livewire:admin.households.household-list />
        <livewire:admin.households.household-form />
    </div>
@endsection
