@extends('layouts.app')

@section('title', 'Edit Vital Record')

@php
    // Breadcrumb data for navbar
    $breadcrumbs = [
        ['label' => 'Transactions'],
        ['label' => 'Vital Records', 'url' => route('vital-records.index')],
        ['label' => 'Edit'],
    ];
@endphp

@section('content')

    <!-- Begin: Edit Form -->
    <form action="{{ route('vital-records.update', $record->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('vital-records._form')
    </form>
    <!-- End: Edit Form -->

@endsection
