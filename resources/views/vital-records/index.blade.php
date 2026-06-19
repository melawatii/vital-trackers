@extends('layouts.app')

@section('title', 'Vital Records')

@php
    // Breadcrumb data for navbar
    $breadcrumbs = [
        ['label' => 'Transactions'],
        ['label' => 'Vital Records'],
    ];
@endphp

@section('content')

    <!-- Begin: Page Header -->
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Vital Records</h1>
            <p class="text-sm text-slate-500 mt-0.5">Monitor and manage all recorded vital sign measurements.</p>
        </div>
        <a href="{{ route('vital-records.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-xl shadow-sm shadow-blue-200 transition-all duration-150 active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Record
        </a>
    </div>
    <!-- End: Page Header -->

    <!-- Begin: Stats Cards Row -->
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">

        <!-- Begin: Card Total Records -->
        <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center justify-between shadow-sm">
            <div>
                <p class="text-sm text-slate-500 font-medium">Total Records</p>
                <p class="text-3xl font-bold text-slate-900 mt-1">{{ number_format($stats['total']) }}</p>
                <p class="text-xs text-slate-400 mt-1">All time records</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
        <!-- End: Card Total Records -->

        <!-- Begin: Card This Month -->
        <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center justify-between shadow-sm">
            <div>
                <p class="text-sm text-slate-500 font-medium">This Month</p>
                <p class="text-3xl font-bold text-slate-900 mt-1">{{ number_format($stats['this_month']) }}</p>
                <p class="text-xs text-slate-400 mt-1">Active monitoring</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
        </div>
        <!-- End: Card This Month -->

        <!-- Begin: Card Danger Records -->
        <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center justify-between shadow-sm">
            <div>
                <p class="text-sm text-slate-500 font-medium">Danger Records</p>
                <p class="text-3xl font-bold text-slate-900 mt-1">{{ number_format($stats['danger']) }}</p>
                <p class="text-xs text-slate-400 mt-1">Require attention</p>
            </div>
            <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </div>
        <!-- End: Card Danger Records -->

        <!-- Begin: Card Unique Users -->
        <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center justify-between shadow-sm">
            <div>
                <p class="text-sm text-slate-500 font-medium">Unique Users</p>
                <p class="text-3xl font-bold text-slate-900 mt-1">{{ number_format($stats['unique_users']) }}</p>
                <p class="text-xs text-slate-400 mt-1">Monitored users</p>
            </div>
            <div class="w-12 h-12 bg-violet-50 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        </div>
        <!-- End: Card Unique Users -->

    </div>
    <!-- End: Stats Cards Row -->

    <!-- Begin: DataTable Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

        <!-- Begin: Table Toolbar -->
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-50">

            <!-- Entries per page -->
            <div class="flex items-center gap-2 text-sm text-slate-600">
                <select id="dt-length"
                    class="px-3 py-1.5 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white">
                    <option value="10">10</option>
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-slate-400">entries per page</span>
            </div>

            <!-- Search + Filter icon -->
            <div class="flex items-center gap-2">
                <div class="relative">
                    <svg class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input id="dt-search" type="text" placeholder="Search..."
                        class="pl-8 pr-3 py-1.5 border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-400 w-44 transition" />
                </div>
                <button class="p-2 rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                </button>
            </div>

        </div>
        <!-- End: Table Toolbar -->

        <!-- Begin: Table Loading Spinner -->
        <div id="dt-loading" class="flex flex-col items-center justify-center py-20 gap-3">
            <div class="spin"></div>
            <p class="text-xs text-slate-400">Loading records…</p>
        </div>
        <!-- End: Table Loading Spinner -->

        <!-- Begin: DataTable Wrapper -->
        <div id="dt-wrapper" class="hidden">
            <table id="vital-records-table" class="w-full">
                <thead>
                    <tr>
                        <th class="w-12">#</th>
                        <th>Date & Time</th>
                        <th>User</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Unit</th>
                        <th>Status</th>
                        <th>Note</th>
                        <th class="w-24 text-right pr-5">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <!-- End: DataTable Wrapper -->

        <!-- Begin: Table Footer / Pagination -->
        <div class="flex items-center justify-between px-5 py-3.5 border-t border-slate-50">
            <p id="dt-info" class="text-xs text-slate-400"></p>
            <div id="dt-pagination" class="flex items-center gap-1"></div>
        </div>
        <!-- End: Table Footer / Pagination -->

    </div>
    <!-- End: DataTable Card -->

@endsection

@push('scripts')
<script>
$(function () {

    // Initialize server-side DataTable
    const table = $('#vital-records-table').DataTable({
        processing : true,
        serverSide : true,
        ajax       : '{{ route("vital-records.datatable") }}',
        pageLength : 25,
        dom        : 'rt', // hide default controls
        columns    : [
            {
                data      : 'DT_RowIndex',
                orderable : false,
                searchable: false,
            },
            { data: 'recorded_at' },
            { data: 'user_html',   orderable: false },
            { data: 'category',    orderable: false },
            { data: 'type' },
            { data: 'value',       orderable: false },
            { data: 'unit' },
            { data: 'status_html', orderable: false },
            { data: 'note',        orderable: false },
            {
                data      : 'actions',
                orderable : false,
                searchable: false,
                className : 'text-right',
            },
        ],

        // Show table once first draw completes
        initComplete: function () {
            $('#dt-loading').hide();
            $('#dt-wrapper').removeClass('hidden');
        },

        drawCallback: function (settings) {
            renderPagination(settings);
            renderInfo(settings);
        },
    });

    // Sync custom search input with DataTable
    $('#dt-search').on('keyup', function () {
        table.search(this.value).draw();
    });

    // Sync custom page-length select
    $('#dt-length').on('change', function () {
        table.page.len(parseInt(this.value)).draw();
    });

    // Delete record via AJAX with SweetAlert2 confirmation
    $(document).on('click', '.btn-delete-record', function () {
        const url  = $(this).data('url');
        const name = $(this).closest('tr').find('td:nth-child(3)').text().trim();

        Swal.fire({
            title            : 'Delete record?',
            html             : `<p class="text-sm text-slate-600">You are about to delete this vital record. This cannot be undone.</p>`,
            icon             : 'warning',
            showCancelButton : true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText : 'Cancel',
            confirmButtonColor: '#ef4444',
            customClass      : { popup: 'rounded-2xl text-left' },
        }).then(result => {
            if (!result.isConfirmed) return;

            // Show progress
            Swal.fire({ title: 'Deleting…', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

            $.ajax({
                url    : url,
                type   : 'DELETE',
                data   : { _token: $('meta[name="csrf-token"]').attr('content') },
                success: res => {
                    Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 2000, showConfirmButton: false });
                    table.ajax.reload(null, false);
                },
                error: () => {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong. Please try again.' });
                },
            });
        });
    });

    // Render custom pagination buttons
    function renderPagination(settings) {
        const api  = new $.fn.dataTable.Api(settings);
        const info = api.page.info();
        const $el  = $('#dt-pagination').empty();

        const btn = (label, page, disabled, active) => {
            const base = 'w-8 h-8 flex items-center justify-center text-xs font-semibold rounded-lg transition';
            const cls  = active
                ? `${base} bg-blue-500 text-white`
                : disabled
                    ? `${base} border border-slate-200 text-slate-300 cursor-not-allowed`
                    : `${base} border border-slate-200 text-slate-600 hover:bg-slate-50`;

            return $(`<button class="${cls}">${label}</button>`)
                .prop('disabled', disabled || active)
                .on('click', () => api.page(page).draw('page'));
        };

        // Prev arrow
        $el.append(btn('&lsaquo;', info.page - 1, info.page === 0, false));

        // Page numbers
        for (let i = 0; i < info.pages; i++) {
            $el.append(btn(i + 1, i, false, i === info.page));
        }

        // Next arrow
        $el.append(btn('&rsaquo;', info.page + 1, info.page === info.pages - 1, false));
    }

    // Update "Showing X to Y of Z entries" text
    function renderInfo(settings) {
        const api  = new $.fn.dataTable.Api(settings);
        const info = api.page.info();
        const from = info.start + 1;
        const to   = Math.min(info.end, info.recordsDisplay);
        $('#dt-info').text(`Showing ${from} to ${to} of ${info.recordsDisplay} entries`);
    }
});
</script>
@endpush
