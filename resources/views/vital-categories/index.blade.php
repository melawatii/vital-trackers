@extends('layouts.app')

@section('title', 'Vital Categories')

@php
    // Breadcrumb data passed to navbar
    $breadcrumbs = [
        ['label' => 'Master Data', 'url' => '#'],
        ['label' => 'Vital Categories', 'url' => route('vital-categories.index')],
    ];
@endphp

@section('content')

    {{-- Loading overlay --}}
    @include('components.loading-overlay')

    {{-- ── Page Header ──────────────────────────────────────────── --}}
    <!-- Begin: Page Header -->
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Vital Categories</h1>
            <p class="text-sm text-gray-500 mt-0.5">Manage vital sign categories used in the system.</p>
        </div>
        <a href="{{ route('vital-categories.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm shadow-blue-200 transition-all duration-150 active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add New Category
        </a>
    </div>
    <!-- End: Page Header -->

    {{-- ── Stats Cards ──────────────────────────────────────────── --}}
    <!-- Begin: Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        {{-- Total Categories --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center justify-between shadow-sm">
            <div>
                <p class="text-xs font-medium text-gray-400 mb-1">Total Categories</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                <p class="text-xs text-gray-400 mt-1">All vital categories</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
            </div>
        </div>

        {{-- Active Categories --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center justify-between shadow-sm">
            <div>
                <p class="text-xs font-medium text-gray-400 mb-1">Active Categories</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['active'] }}</p>
                <p class="text-xs text-gray-400 mt-1">Currently active</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        {{-- Inactive Categories --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center justify-between shadow-sm">
            <div>
                <p class="text-xs font-medium text-gray-400 mb-1">Inactive Categories</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['inactive'] }}</p>
                <p class="text-xs text-gray-400 mt-1">Currently inactive</p>
            </div>
            <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        {{-- Total Types --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center justify-between shadow-sm">
            <div>
                <p class="text-xs font-medium text-gray-400 mb-1">Total Types</p>
                <p class="text-3xl font-bold text-gray-900">
                    {{ class_exists(\App\Models\VitalType::class) ? \App\Models\VitalType::count() : 0 }}
                </p>
                <p class="text-xs text-gray-400 mt-1">Vital types created</p>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
        </div>

    </div>
    <!-- End: Stats Cards -->

    {{-- ── Data Table Card ──────────────────────────────────────── --}}
    <!-- Begin: DataTable Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- Table wrapper --}}
        <div class="p-5">
            <table id="vitalCategoriesTable" class="w-full text-sm" style="width:100%">
                <thead>
                    <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide border-b border-gray-100">
                        <th class="pb-3 pr-4 w-10">#</th>
                        <th class="pb-3 pr-4">Category Name</th>
                        <th class="pb-3 pr-4">Description</th>
                        <th class="pb-3 pr-4">Status</th>
                        <th class="pb-3 pr-4">Created At</th>
                        <th class="pb-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>
    <!-- End: DataTable Card -->

@endsection

@push('styles')
<style>
    /* ── DataTable overrides to match design ── */
    #vitalCategoriesTable_wrapper .dataTables_length label,
    #vitalCategoriesTable_wrapper .dataTables_filter label {
        @apply text-sm text-gray-600 flex items-center gap-2;
    }

    #vitalCategoriesTable_wrapper .dataTables_length select,
    #vitalCategoriesTable_wrapper .dataTables_filter input {
        @apply border border-gray-200 rounded-lg px-3 py-1.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent;
    }

    #vitalCategoriesTable_wrapper .dataTables_info {
        @apply text-xs text-gray-400 mt-3;
    }

    #vitalCategoriesTable_wrapper .dataTables_paginate {
        @apply mt-3 flex items-center gap-1 justify-end;
    }

    #vitalCategoriesTable_wrapper .dataTables_paginate .paginate_button {
        @apply w-8 h-8 rounded-lg text-sm text-gray-500 flex items-center justify-center cursor-pointer hover:bg-gray-100 transition-colors;
    }

    #vitalCategoriesTable_wrapper .dataTables_paginate .paginate_button.current {
        @apply bg-blue-600 text-white font-semibold hover:bg-blue-700;
    }

    #vitalCategoriesTable_wrapper .dataTables_paginate .paginate_button.disabled {
        @apply opacity-40 cursor-not-allowed;
    }

    #vitalCategoriesTable tbody tr {
        @apply border-b border-gray-50 hover:bg-gray-50 transition-colors;
    }

    #vitalCategoriesTable tbody td {
        @apply py-3.5 pr-4 text-gray-700;
    }

    /* Status badges */
    .status-badge {
        @apply inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold;
    }
    .status-badge::before {
        content: '';
        @apply w-1.5 h-1.5 rounded-full inline-block;
    }
    .status-active {
        @apply bg-green-50 text-green-700;
    }
    .status-active::before { @apply bg-green-500; }
    .status-inactive {
        @apply bg-orange-50 text-orange-600;
    }
    .status-inactive::before { @apply bg-orange-400; }

    /* Icon wrappers */
    .category-icon-wrap {
        @apply w-8 h-8 rounded-lg inline-flex items-center justify-center text-base;
    }

    /* Table top controls spacing */
    #vitalCategoriesTable_wrapper > div:first-child {
        @apply flex items-center justify-between mb-4;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function () {

    // ── Initialize DataTable with server-side processing ──────
    const table = $('#vitalCategoriesTable').DataTable({
        processing: true,        // show built-in processing indicator
        serverSide: true,        // delegate filtering/sorting/pagination to server
        ajax: {
            url: '{{ route('vital-categories.data') }}',
            type: 'GET',
            // Show / hide loading overlay during AJAX calls
            beforeSend: () => window.showLoading(),
            complete:   () => window.hideLoading(),
            error: (xhr) => {
                window.hideLoading();
                Swal.fire('Error', 'Failed to load data. Please refresh the page.', 'error');
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, width: '40px' },
            {
                data: 'name',
                name: 'name',
                render: function (data, type, row) {
                    // Render icon + name together
                    const iconMap = {
                        droplet:   '💧', heart: '💚', thermometer: '🌡️',
                        blooddrop: '🩸', lungs: '🫁',  scale: '⚖️',
                        oxygen:    '🫧', brain: '🧠',
                    };
                    const icon = iconMap[row.icon] || '📋';
                    return `<div class="flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center text-base">${icon}</span>
                                <span class="font-semibold text-gray-800">${data}</span>
                            </div>`;
                }
            },
            { data: 'description', name: 'description', className: 'text-gray-500 max-w-xs truncate' },
            { data: 'status_badge', name: 'status', orderable: true, searchable: false },
            {
                data: 'created_at', name: 'created_at',
                render: (data) => {
                    if (!data) return '—';
                    const d = new Date(data);
                    return d.toLocaleDateString('en-US', { year:'numeric', month:'short', day:'numeric', hour:'2-digit', minute:'2-digit' });
                }
            },
            { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-right' },
        ],
        order: [[0, 'asc']],
        pageLength: 25,
        language: {
            processing: '<div class="flex items-center gap-2 text-blue-600 text-sm"><div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div> Loading...</div>',
            emptyTable: '<div class="py-12 text-center text-gray-400 text-sm">No vital categories found.</div>',
            zeroRecords: '<div class="py-8 text-center text-gray-400 text-sm">No matching records found.</div>',
        },
        drawCallback: function () {
            // Bind delete buttons after each draw
            bindDeleteButtons();
        }
    });

    // ── Delete button handler ──────────────────────────────────
    function bindDeleteButtons() {
        $(document).off('click', '.btn-delete').on('click', '.btn-delete', function () {
            const id  = $(this).data('id');
            const url = $(this).data('url');

            Swal.fire({
                title: 'Delete Category?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#EF4444',
                cancelButtonColor:  '#6B7280',
                reverseButtons: true,
            }).then((result) => {
                if (!result.isConfirmed) return;

                window.showLoading();

                $.ajax({
                    url,
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: (res) => {
                        window.hideLoading();
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 1500, showConfirmButton: false });
                            table.ajax.reload(null, false); // reload without resetting pagination
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: () => {
                        window.hideLoading();
                        Swal.fire('Error', 'Failed to delete. Please try again.', 'error');
                    }
                });
            });
        });
    }

});
</script>
@endpush
