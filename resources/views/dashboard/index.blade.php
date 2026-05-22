@extends('layouts.app')

@section('title', 'Dashboard')

@php
    // Breadcrumb data passed to navbar
    $breadcrumbs = [
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Dashboard', 'url' => route('dashboard')],
    ];
@endphp

@section('content')

@endsection

@push('styles')

@endpush

@push('scripts')

@endpush
