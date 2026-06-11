@extends('layouts.app')

@section('title', 'Create User')

@php
    // Breadcrumb data for navbar
    $breadcrumbs = [
        ['label' => 'Master Data (Admin)'],
        ['label' => 'Users', 'url' => route('users.index')],
        ['label' => 'Create'],
    ];
@endphp

@section('content')

    <!-- Begin: Create User Form -->
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        @include('users._form')
    </form>
    <!-- End: Create User Form -->

@endsection