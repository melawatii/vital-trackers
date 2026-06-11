@extends('layouts.app')

@section('title', 'Edit User')

@php
    // Breadcrumb data for navbar
    $breadcrumbs = [
        ['label' => 'Master Data (Admin)'],
        ['label' => 'Users', 'url' => route('users.index')],
        ['label' => 'Edit'],
    ];
@endphp

@section('content')

    <!-- Begin: Edit User Form -->
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('users._form')
    </form>
    <!-- End: Edit User Form -->

@endsection