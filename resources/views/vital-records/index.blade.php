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

                <!-- BEGIN: Export Dropdown Button -->
                <div class="relative" id="export-dropdown-wrap">
                    <button
                        id="export-toggle-btn"
                        type="button"
                        class="inline-flex items-center gap-2 px-3 py-1.5 border border-slate-200 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 transition">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div
                        id="export-menu"
                        class="absolute right-0 mt-2 w-48 bg-white border border-slate-100 rounded-xl shadow-lg z-50 py-1.5"
                        style="display: none;">
                        <a
                            id="export-excel-btn"
                            href="{{ route('vital-records.export.excel') }}"
                            class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm3 1a1 1 0 000 2h6a1 1 0 100-2H7zm0 4a1 1 0 000 2h6a1 1 0 100-2H7zm0 4a1 1 0 100 2h3a1 1 0 100-2H7z" clip-rule="evenodd" />
                            </svg>
                            Export to Excel
                        </a>
                        <a
                            id="export-csv-btn"
                            href="{{ route('vital-records.export.csv') }}"
                            class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition">
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm2 2a1 1 0 011-1h8a1 1 0 011 1v8a1 1 0 01-1 1H6a1 1 0 01-1-1V6z" clip-rule="evenodd" />
                            </svg>
                            Export to CSV
                        </a>
                    </div>
                </div>
                <!-- END: Export Dropdown Button -->

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
            { data: 'recorded_at', orderable: true },
            { data: 'user_html',   orderable: false },
            { data: 'category',    orderable: false },
            { data: 'type',        orderable: true },
            { data: 'value',       orderable: false },
            { data: 'unit',        orderable: true },
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

    // Export dropdown toggle logic
    const toggleBtn = document.getElementById('export-toggle-btn');
    const menu      = document.getElementById('export-menu');
    const wrap      = document.getElementById('export-dropdown-wrap');

    if (!toggleBtn || !menu) return;

    // Toggle dropdown menu visibility
    toggleBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        const isOpen = menu.style.display === 'block';
        menu.style.display = isOpen ? 'none' : 'block';
    });

    // Close dropdown if clicked outside
    document.addEventListener('click', function (e) {
        if (wrap && !wrap.contains(e.target)) {
            menu.style.display = 'none';
        }
    });

    // Close dropdown after link is clicked (allow browser to process download)
    document.getElementById('export-excel-btn').addEventListener('click', function () {
        setTimeout(() => { menu.style.display = 'none'; }, 150);
    });

    document.getElementById('export-csv-btn').addEventListener('click', function () {
        setTimeout(() => { menu.style.display = 'none'; }, 150);
    });

    // Sync custom search input with DataTable
    $('#dt-search').on('keyup', function () {
        table.search(this.value).draw();
        updateExportUrls(this.value);
    });

    // Sync custom page-length select
    $('#dt-length').on('change', function () {
        table.page.len(parseInt(this.value)).draw();
    });

    // Update export URLs based on current search query
    function updateExportUrls(search) {
        const baseExcel = '{{ route("vital-records.export.excel") }}';
        const baseCsv = '{{ route("vital-records.export.csv") }}';
        const query = search ? '?search=' + encodeURIComponent(search) : '';

        $('#export-excel-btn').attr('href', baseExcel + query);
        $('#export-csv-btn').attr('href', baseCsv + query);
    }

    // Begin: Delete record via AJAX with redesigned confirmation popup.
    // Built as raw HTML inside Swal so every element is styled inline.
    $(document).on('click', '.btn-delete-record', function () {
        const url = $(this).data('url');

        Swal.fire({
            showConfirmButton: false,
            showCancelButton : false,
            showCloseButton  : false,
            customClass      : { popup: 'rounded-2xl' },
            width            : 380,
            padding          : '2rem 1.75rem',
            html: `
                <div style="display:flex;flex-direction:column;align-items:center;text-align:center">
                    <div style="width:60px;height:60px;border-radius:50%;border:2px solid #93c5fd;
                                display:flex;align-items:center;justify-content:center;margin-bottom:18px">
                        <svg style="width:26px;height:26px;color:#3b82f6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                d="M12 9v3.75m0 3.01h.008M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>

                    <p style="font-size:1.05rem;font-weight:700;color:#0f172a;margin:0 0 8px 0">Delete record?</p>

                    <p style="font-size:.85rem;color:#64748b;line-height:1.6;margin:0 0 22px 0">
                        You are about to delete this vital record.<br>
                        This action cannot be undone.
                    </p>

                    <div style="display:flex;gap:10px;width:100%">
                        <button id="swal-confirm-delete"
                                style="flex:1;background:#3b82f6;color:#fff;font-weight:600;font-size:.85rem;
                                       border:none;border-radius:10px;padding:10px 0;cursor:pointer">
                            Yes, delete
                        </button>
                        <button id="swal-cancel-delete"
                                style="flex:1;background:#fff;color:#334155;font-weight:600;font-size:.85rem;
                                       border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 0;cursor:pointer">
                            Cancel
                        </button>
                    </div>
                </div>
            `,
            didOpen: () => {
                document.getElementById('swal-confirm-delete').addEventListener('click', () => {
                    Swal.close();
                    performDelete(url, table);
                });
                document.getElementById('swal-cancel-delete').addEventListener('click', () => {
                    Swal.close();
                });
            },
        });
    });

    function performDelete(url, table) {
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
    }

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
