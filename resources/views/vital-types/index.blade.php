@extends('layouts.app')

@section('title', 'Vital Types')

@php
    // Breadcrumb data for navbar
    $breadcrumbs = [
        ['label' => 'Master Data'],
        ['label' => 'Vital Types'],
    ];
@endphp

@section('content')

    <!-- Begin: Page Header -->
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Vital Types</h1>
            <p class="text-sm text-slate-500 mt-0.5">Manage vital sign types and their measurement configurations.</p>
        </div>
        <a href="{{ route('vital-types.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-xl shadow-sm shadow-blue-200 transition-all duration-150 active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Add New Vital Type
        </a>
    </div>
    <!-- End: Page Header -->

        <!-- Begin: Stats Cards Row -->
        <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">

            <!-- Begin: Card Total Types -->
            <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center justify-between shadow-sm">
                <div>
                    <p class="text-sm text-slate-500 font-medium">Total Types</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['total'] }}</p>
                    <p class="text-xs text-slate-400 mt-1">All vital types</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </div>
            </div>
            <!-- End: Card Total Types -->

            <!-- Begin: Card Active Types -->
            <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center justify-between shadow-sm">
                <div>
                    <p class="text-sm text-slate-500 font-medium">Active Types</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['active'] }}</p>
                    <p class="text-xs text-slate-400 mt-1">Currently active</p>
                </div>
                <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <!-- End: Card Active Types -->

            <!-- Begin: Card Inactive Types -->
            <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center justify-between shadow-sm">
                <div>
                    <p class="text-sm text-slate-500 font-medium">Inactive Types</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['inactive'] }}</p>
                    <p class="text-xs text-slate-400 mt-1">Currently inactive</p>
                </div>
                <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <!-- End: Card Inactive Types -->

            <!-- Begin: Card Numeric Types -->
            <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center justify-between shadow-sm">
                <div>
                    <p class="text-sm text-slate-500 font-medium">Numeric Types</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1">{{ $stats['numeric'] }}</p>
                    <p class="text-xs text-slate-400 mt-1">Number input types</p>
                </div>
                <div class="w-12 h-12 bg-violet-50 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                    </svg>
                </div>
            </div>
            <!-- End: Card Numeric Types -->

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
            <p class="text-xs text-slate-400">Loading vital types…</p>
        </div>
        <!-- End: Table Loading Spinner -->

        <!-- Begin: DataTable Wrapper -->
        <div id="dt-wrapper" class="hidden">
            <table id="vital-types-table" class="w-full">
                <thead>
                    <tr>
                        <th class="w-12">#</th>
                        <th class="cursor-pointer hover:bg-slate-50 select-none">Vital Type Name</th>
                        <th>Category</th>
                        <th>Input Type</th>
                        <th>Unit</th>
                        <th>Normal Range</th>
                        <th>Status</th>
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
    const table = $('#vital-types-table').DataTable({
        processing : true,
        serverSide : true,
        ajax       : '{{ route("vital-types.datatable") }}',
        pageLength : 25,
        dom        : 'rt', // hide default controls
        columns    : [
            {
                data      : 'DT_RowIndex',
                orderable : false,
                searchable: false,
            },
            { data: 'name', orderable: true, render: function(data, type, row) { return row.name_html; } },
            { data: 'category' },
            { data: 'input_badge',   orderable: false },
            { data: 'unit' },
            { data: 'normal_range',  orderable: false },
            { data: 'status_html',   orderable: false },
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

    // Begin: Delete vital type via AJAX with redesigned confirmation popup.
    // Built as raw HTML inside Swal so every element is styled inline.
    $(document).on('click', '.btn-delete-type', function () {
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

                    <!-- Outlined circle icon -->
                    <div style="width:60px;height:60px;border-radius:50%;border:2px solid #93c5fd;
                                display:flex;align-items:center;justify-content:center;margin-bottom:18px">
                        <svg style="width:26px;height:26px;color:#3b82f6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                d="M12 9v3.75m0 3.01h.008M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>

                    <!-- Title -->
                    <p style="font-size:1.05rem;font-weight:700;color:#0f172a;margin:0 0 8px 0">Delete vital type?</p>

                    <!-- Description -->
                    <p style="font-size:.85rem;color:#64748b;line-height:1.6;margin:0 0 22px 0">
                        You are about to delete this vital type.<br>
                        This action cannot be undone.
                    </p>

                    <!-- Action buttons -->
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
                table.ajax.reload(null, false);
                Swal.close();

                Swal.fire({
                    showConfirmButton: true,
                    confirmButtonText: 'Back to List',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white rounded-2xl px-8 py-3 font-semibold',
                    },
                    buttonsStyling: false,
                    width: 420,
                    padding: '2rem 1.75rem',
                    html: `
                        <div style="display:flex;flex-direction:column;align-items:center;text-align:center;gap:18px">
                            <div style="width:72px;height:72px;border-radius:50%;background:#eff6ff;display:flex;align-items:center;justify-content:center">
                                <svg style="width:30px;height:30px;color:#2563eb" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.5 13.5l3 3 6-6" stroke="#2563eb" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="12" cy="12" r="9" stroke="#2563eb" stroke-width="1.75" fill="none" opacity="0.25"/>
                                </svg>
                            </div>
                            <div>
                                <p style="font-size:1.3rem;font-weight:700;color:#0f172a;margin:0">Deleted!</p>
                                <p style="font-size:.95rem;color:#475569;line-height:1.7;margin:.75rem 0 0 0">
                                    Record deleted successfully.<br>
                                    The data has been removed.
                                </p>
                            </div>
                        </div>
                    `,
                });
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
