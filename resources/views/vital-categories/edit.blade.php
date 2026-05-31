@extends('layouts.app')

@section('title', 'Edit Vital Category')

@php
    // Breadcrumb data for navbar
    $breadcrumbs = [
        ['label' => 'Master Data'],
        ['label' => 'Vital Categories', 'url' => route('vital-categories.index')],
        ['label' => 'Edit'],
    ];
@endphp

@section('content')

    <!-- Begin: Edit Form -->
    <form action="{{ route('vital-categories.update', $vitalCategory->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('vital-categories._form')
    </form>
    <!-- End: Edit Form -->

@endsection
