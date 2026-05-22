@extends('layouts.app')

@section('title', 'Create Vital Category')

@php
    // Breadcrumb data for navbar
    $breadcrumbs = [
        ['label' => 'Master Data',       'url' => '#'],
        ['label' => 'Vital Categories',  'url' => route('vital-categories.index')],
        ['label' => 'Create',            'url' => route('vital-categories.create')],
    ];
@endphp

@section('content')

    {{-- Loading overlay --}}
    @include('components.loading-overlay')

    {{-- ── Page Header ──────────────────────────────────────────── --}}
    <!-- Begin: Page Header -->
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Create Vital Category</h1>
            <p class="text-sm text-gray-500 mt-0.5">Add a new vital sign category to organize health data effectively.</p>
        </div>
        <a href="{{ route('vital-categories.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Categories
        </a>
    </div>
    <!-- End: Page Header -->

    {{-- ── Create Form ──────────────────────────────────────────── --}}
    <!-- Begin: Create Form -->
    <form
        method="POST"
        action="{{ route('vital-categories.store') }}"
        data-loading="true"
    >
        @csrf

        {{-- Shared form fields partial --}}
        @include('vital-categories._form')

    </form>
    <!-- End: Create Form -->

@endsection
