@extends('layouts.app')

@section('title', 'Create Vital Type')

@php
    // Breadcrumb data for navbar
    $breadcrumbs = [
        ['label' => 'Master Data'],
        ['label' => 'Vital Types', 'url' => route('vital-types.index')],
        ['label' => 'Create'],
    ];
@endphp

@section('content')

    <!-- Begin: Create Form -->
    <form action="{{ route('vital-types.store') }}" method="POST">
        @csrf
        @include('vital-types._form')
    </form>
    <!-- End: Create Form -->

@endsection
