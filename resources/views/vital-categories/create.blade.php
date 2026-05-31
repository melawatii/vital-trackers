@extends('layouts.app')

@section('title', 'Create Vital Category')

@php
    // Breadcrumb data for navbar
    $breadcrumbs = [
        ['label' => 'Master Data'],
        ['label' => 'Vital Categories', 'url' => route('vital-categories.index')],
        ['label' => 'Create'],
    ];
@endphp

@section('content')

    <!-- Begin: Create Form -->
    <form action="{{ route('vital-categories.store') }}" method="POST">
        @csrf
        @include('vital-categories._form')
    </form>
    <!-- End: Create Form -->

@endsection
