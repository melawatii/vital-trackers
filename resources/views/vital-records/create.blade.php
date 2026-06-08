@extends('layouts.app')

@section('title', 'Create Vital Record')

@php
    // Breadcrumb data for navbar
    $breadcrumbs = [
        ['label' => 'Transactions'],
        ['label' => 'Vital Records', 'url' => route('vital-records.index')],
        ['label' => 'Create'],
    ];
    // Load all active vital types directly on create page
@endphp

@section('content')

    <!-- Begin: Create Form -->
    <form action="{{ route('vital-records.store') }}" method="POST">
        @csrf
        @include('vital-records._form', ['users' => $users ?? []])
    </form>
    <!-- End: Create Form -->

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var select = document.getElementById('field-type');
        if (!select) {
            return;
        }

        var setCategoryId = function () {
            var opt = select.options[select.selectedIndex];
            var catId = opt ? opt.getAttribute('data-category-id') : '';
            var hidden = document.getElementById('hidden-category-id');
            if (hidden) {
                hidden.value = catId || '';
            }
        };

        select.addEventListener('change', function () {
            setCategoryId();
            onTypeChange();
        });

        setCategoryId();
    });
</script>
@endpush
