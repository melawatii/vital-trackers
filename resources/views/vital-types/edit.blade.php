@extends('layouts.app')

@section('title', 'Edit Vital Type')

@php
    // Breadcrumb data for navbar
    $breadcrumbs = [
        ['label' => 'Master Data'],
        ['label' => 'Vital Types', 'url' => route('vital-types.index')],
        ['label' => 'Edit'],
    ];
@endphp

@section('content')

    <!-- Begin: Edit Form -->
    <form action="{{ route('vital-types.update', $vitalType->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('vital-types._form')
    </form>
    <!-- End: Edit Form -->

@endsection
