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
            <p class="text-sm text-slate-500 mt-1">Manage vital sign types and their measurement configurations.</p>
        </div>
        <a href="{{ route('vital-types.create') }}"
           style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#2563eb;color:#fff;font-size:.875rem;font-weight:600;border-radius:12px;text-decoration:none;box-shadow:0 2px 8px rgba(37,99,235,.25);transition:background .15s"
           onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
            <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div style="width:48px;height:48px;background:#eff6ff;border-radius:14px;display:flex;align-items:center;justify-content:center">
                <svg style="width:22px;height:22px;color:#3b82f6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div style="width:48px;height:48px;background:#f0fdf4;border-radius:14px;display:flex;align-items:center;justify-content:center">
                <svg style="width:22px;height:22px;color:#22c55e" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div style="width:48px;height:48px;background:#fffbeb;border-radius:14px;display:flex;align-items:center;justify-content:center">
                <svg style="width:22px;height:22px;color:#f59e0b" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div style="width:48px;height:48px;background:#f5f3ff;border-radius:14px;display:flex;align-items:center;justify-content:center">
                <svg style="width:22px;height:22px;color:#8b5cf6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    style="padding:6px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.875rem;outline:none;background:#fff;cursor:pointer">
                    <option value="10">10</option>
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-slate-400">entries per page</span>
            </div>

            <!-- Search + Filter -->
            <div style="display:flex;align-items:center;gap:8px">
                <div style="position:relative">
                    <svg style="width:14px;height:14px;position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#94a3b8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input id="dt-search" type="text" placeholder="Search..."
                        style="padding:7px 12px 7px 32px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.875rem;outline:none;width:176px;font-family:'Plus Jakarta Sans',sans-serif;transition:border-color .15s"
                        onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'" />
                </div>
                <button style="padding:7px;border:1.5px solid #e2e8f0;border-radius:8px;background:#fff;color:#64748b;cursor:pointer;display:flex;align-items:center;justify-content:center">
                    <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                </button>
            </div>

        </div>
        <!-- End: Table Toolbar -->

        <!-- Begin: Table Loading Spinner -->
        <div id="dt-loading" style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:80px 0;gap:12px">
            <div class="spin"></div>
            <p style="font-size:.75rem;color:#94a3b8">Loading vital types…</p>
        </div>
        <!-- End: Table Loading Spinner -->

        <!-- Begin: DataTable Wrapper -->
        <div id="dt-wrapper" style="display:none">
            <table id="vital-types-table" class="w-full">
                <thead>
                    <tr>
                        <th class="w-12">#</th>
                        <th>Vital Type Name</th>
                        <th>Category</th>
                        <th>Input Type</th>
                        <th>Unit</th>
                        <th>Normal Range</th>
                        <th>Status</th>
                        <th class="text-right pr-5">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <!-- End: DataTable Wrapper -->

        <!-- Begin: Table Footer / Pagination -->
        <div class="flex items-center justify-between px-5 py-3 border-t border-slate-50">
            <p id="dt-info" style="font-size:.75rem;color:#94a3b8"></p>
            <div id="dt-pagination" style="display:flex;align-items:center;gap:4px"></div>
        </div>
        <!-- End: Table Footer / Pagination -->

    </div>
    <!-- End: DataTable Card -->

@endsection

@push('scripts')
<script>
$(function () {

    // Initialize server-side DataTable
    var table = $('#vital-types-table').DataTable({
        processing : true,
        serverSide : true,
        ajax       : '{{ route("vital-types.datatable") }}',
        pageLength : 25,
        dom        : 'rt',
        columns    : [
            { data: 'DT_RowIndex',   orderable: false, searchable: false },
            { data: 'name_html',     orderable: false },
            { data: 'category' },
            { data: 'input_badge',   orderable: false },
            { data: 'unit' },
            { data: 'normal_range',  orderable: false },
            { data: 'status_html',   orderable: false },
            { data: 'actions',       orderable: false, searchable: false, className: 'text-right' },
        ],
        initComplete: function () {
            $('#dt-loading').hide();
            $('#dt-wrapper').show();
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

    // Delete row via AJAX with SweetAlert2 confirmation
    $(document).on('click', '.btn-delete-type', function () {
        var url  = $(this).data('url');
        var name = $(this).closest('tr').find('td:nth-child(2) span').text().trim();

        Swal.fire({
            title            : 'Delete vital type?',
            html             : '<p style="font-size:.875rem;color:#475569">You are about to delete <strong>' + name + '</strong>. This cannot be undone.</p>',
            icon             : 'warning',
            showCancelButton : true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText : 'Cancel',
            confirmButtonColor: '#ef4444',
            customClass      : { popup: 'rounded-2xl' },
        }).then(function (result) {
            if (!result.isConfirmed) return;

            Swal.fire({ title: 'Deleting…', allowOutsideClick: false, didOpen: function() { Swal.showLoading(); } });

            $.ajax({
                url    : url,
                type   : 'DELETE',
                data   : { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function (res) {
                    Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 2000, showConfirmButton: false });
                    table.ajax.reload(null, false);
                },
                error: function () {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong. Please try again.' });
                },
            });
        });
    });

    // Render custom pagination buttons
    function renderPagination(settings) {
        var api  = new $.fn.dataTable.Api(settings);
        var info = api.page.info();
        var $el  = $('#dt-pagination').empty();

        function btn(label, page, disabled, active) {
            var base = 'width:32px;height:32px;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:600;border-radius:8px;cursor:pointer;border:1.5px solid #e2e8f0;transition:all .15s;';
            var style = active
                ? base + 'background:#2563eb;color:#fff;border-color:#2563eb'
                : disabled
                    ? base + 'background:#fff;color:#cbd5e1;cursor:not-allowed'
                    : base + 'background:#fff;color:#475569';

            var $b = $('<button style="' + style + '">' + label + '</button>').prop('disabled', disabled || active);
            if (!disabled && !active) {
                $b.on('click', function () { api.page(page).draw('page'); });
            }
            return $b;
        }

        $el.append(btn('&#8249;', info.page - 1, info.page === 0, false));
        for (var i = 0; i < info.pages; i++) {
            $el.append(btn(i + 1, i, false, i === info.page));
        }
        $el.append(btn('&#8250;', info.page + 1, info.page === info.pages - 1, false));
    }

    // Update info text
    function renderInfo(settings) {
        var api  = new $.fn.dataTable.Api(settings);
        var info = api.page.info();
        $('#dt-info').text('Showing ' + (info.start + 1) + ' to ' + Math.min(info.end, info.recordsDisplay) + ' of ' + info.recordsDisplay + ' entries');
    }
});
</script>
@endpush
