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
    <div style="display:flex;align-items:flex-start;justify-content:space-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Vital Records</h1>
            <p class="text-sm text-slate-500 mt-1">Monitor and manage all recorded vital sign measurements.</p>
        </div>
        <div style="display:flex;align-items:center;gap:10px">

            {{-- Import Data button --}}
            <button style="display:inline-flex;align-items:center;gap:6px;padding:9px 16px;background:#fff;border:1.5px solid #e2e8f0;border-radius:10px;font-size:.875rem;font-weight:600;color:#475569;cursor:pointer"
                    onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
                <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Import Data
            </button>

            {{-- Export button --}}
            <button style="display:inline-flex;align-items:center;gap:6px;padding:9px 16px;background:#fff;border:1.5px solid #e2e8f0;border-radius:10px;font-size:.875rem;font-weight:600;color:#475569;cursor:pointer"
                    onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
                <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export
                <svg style="width:13px;height:13px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            {{-- Add New Record button --}}
            <a href="{{ route('vital-records.create') }}"
               style="display:inline-flex;align-items:center;gap:8px;padding:9px 20px;background:#2563eb;color:#fff;font-size:.875rem;font-weight:600;border-radius:10px;text-decoration:none;box-shadow:0 2px 8px rgba(37,99,235,.25);transition:background .15s"
               onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Record
            </a>

        </div>
    </div>
    <!-- End: Page Header -->

    <!-- Begin: Stats Cards Row -->
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">

        <!-- Begin: Card Total Records -->
        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
            <div style="display:flex;align-items:flex-start;justify-content:space-between">
                <div>
                    <p class="text-sm text-slate-500 font-medium">Total Records</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1">{{ number_format($stats['total']) }}</p>
                    <p class="text-xs text-slate-400 mt-1">All time records</p>
                </div>
                <div style="width:48px;height:48px;background:#eff6ff;border-radius:14px;display:flex;align-items:center;justify-content:center">
                    <svg style="width:22px;height:22px;color:#3b82f6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
            {{-- Mini sparkline decoration --}}
            <div style="margin-top:12px;height:2px;background:linear-gradient(90deg,#bfdbfe,#3b82f6);border-radius:2px;opacity:.6"></div>
        </div>
        <!-- End: Card Total Records -->

        <!-- Begin: Card This Month -->
        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
            <div style="display:flex;align-items:flex-start;justify-content:space-between">
                <div>
                    <p class="text-sm text-slate-500 font-medium">This Month</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1">{{ number_format($stats['this_month']) }}</p>
                    <p class="text-xs text-slate-400 mt-1">Active monitoring</p>
                </div>
                <div style="width:48px;height:48px;background:#f0fdf4;border-radius:14px;display:flex;align-items:center;justify-content:center">
                    <svg style="width:22px;height:22px;color:#22c55e" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
            <div style="margin-top:12px;height:2px;background:linear-gradient(90deg,#bbf7d0,#22c55e);border-radius:2px;opacity:.6"></div>
        </div>
        <!-- End: Card This Month -->

        <!-- Begin: Card Danger Records -->
        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
            <div style="display:flex;align-items:flex-start;justify-content:space-between">
                <div>
                    <p class="text-sm text-slate-500 font-medium">Danger Records</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1">{{ number_format($stats['danger']) }}</p>
                    <p class="text-xs text-slate-400 mt-1">Require attention</p>
                </div>
                <div style="width:48px;height:48px;background:#fffbeb;border-radius:14px;display:flex;align-items:center;justify-content:center">
                    <svg style="width:22px;height:22px;color:#f59e0b" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
            <div style="margin-top:12px;height:2px;background:linear-gradient(90deg,#fde68a,#f59e0b);border-radius:2px;opacity:.6"></div>
        </div>
        <!-- End: Card Danger Records -->

        <!-- Begin: Card Unique Users -->
        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
            <div style="display:flex;align-items:flex-start;justify-content:space-between">
                <div>
                    <p class="text-sm text-slate-500 font-medium">Unique Users</p>
                    <p class="text-3xl font-bold text-slate-900 mt-1">{{ number_format($stats['unique_users']) }}</p>
                    <p class="text-xs text-slate-400 mt-1">Monitored users</p>
                </div>
                <div style="width:48px;height:48px;background:#f5f3ff;border-radius:14px;display:flex;align-items:center;justify-content:center">
                    <svg style="width:22px;height:22px;color:#8b5cf6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <div style="margin-top:12px;height:2px;background:linear-gradient(90deg,#ddd6fe,#8b5cf6);border-radius:2px;opacity:.6"></div>
        </div>
        <!-- End: Card Unique Users -->

    </div>
    <!-- End: Stats Cards Row -->

    <!-- Begin: DataTable Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

        <!-- Begin: Table Toolbar -->
        <div style="display:flex;align-items:center;gap:10px;padding:16px 20px;border-bottom:1px solid #f8fafc;flex-wrap:wrap">

            {{-- Filter: All Categories --}}
            <select id="filter-category"
                    style="padding:7px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.8125rem;font-weight:600;color:#374151;background:#fff;cursor:pointer;outline:none;font-family:'Plus Jakarta Sans',sans-serif">
                <option value="">⊞ All Categories</option>
            </select>

            {{-- Filter: All Types --}}
            <select id="filter-type"
                    style="padding:7px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.8125rem;font-weight:600;color:#374151;background:#fff;cursor:pointer;outline:none;font-family:'Plus Jakarta Sans',sans-serif">
                <option value="">↑ All Types</option>
            </select>

            {{-- Filter: All Status --}}
            <select id="filter-status"
                    style="padding:7px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.8125rem;font-weight:600;color:#374151;background:#fff;cursor:pointer;outline:none;font-family:'Plus Jakarta Sans',sans-serif">
                <option value="">⚑ All Status</option>
                <option value="normal">Normal</option>
                <option value="high_low">High / Low</option>
            </select>

            {{-- Search --}}
            <div style="margin-left:auto;display:flex;align-items:center;gap:8px">
                <div style="position:relative">
                    <svg style="width:14px;height:14px;position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#94a3b8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input id="dt-search" type="text" placeholder="Search records..."
                           style="padding:7px 12px 7px 32px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.8125rem;outline:none;width:180px;font-family:'Plus Jakarta Sans',sans-serif"
                           onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'" />
                </div>
                <button style="display:inline-flex;align-items:center;gap:6px;padding:7px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.8125rem;font-weight:600;color:#64748b;background:#fff;cursor:pointer">
                    <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filters
                </button>
            </div>

        </div>
        <!-- End: Table Toolbar -->

        <!-- Begin: Table Loading Spinner -->
        <div id="dt-loading" style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:80px 0;gap:12px">
            <div class="spin"></div>
            <p style="font-size:.75rem;color:#94a3b8">Loading records…</p>
        </div>
        <!-- End: Table Loading Spinner -->

        <!-- Begin: DataTable Wrapper -->
        <div id="dt-wrapper" style="display:none">
            <table id="vital-records-table" class="w-full">
                <thead>
                    <tr>
                        <th style="width:40px;padding:12px 16px">
                            <input type="checkbox" id="select-all" style="cursor:pointer;width:15px;height:15px">
                        </th>
                        <th style="width:40px">#</th>
                        <th>Date & Time</th>
                        <th>User</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Unit</th>
                        <th>Status</th>
                        <th>Note</th>
                        <th class="text-right pr-5">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <!-- End: DataTable Wrapper -->

        <!-- Begin: Table Footer / Pagination -->
        <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 20px;border-top:1px solid #f8fafc">
            <p id="dt-info" style="font-size:.75rem;color:#94a3b8"></p>
            <div style="display:flex;align-items:center;gap:8px">
                <div id="dt-pagination" style="display:flex;align-items:center;gap:4px"></div>
                <span style="font-size:.75rem;color:#94a3b8">Rows per page:</span>
                <select id="dt-length"
                        style="padding:4px 8px;border:1.5px solid #e2e8f0;border-radius:6px;font-size:.75rem;outline:none;font-family:'Plus Jakarta Sans',sans-serif">
                    <option value="10">10</option>
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>
        <!-- End: Table Footer / Pagination -->

    </div>
    <!-- End: DataTable Card -->

@endsection

@push('scripts')
<script>
$(function () {

    // Initialize server-side DataTable
    var table = $('#vital-records-table').DataTable({
        processing : true,
        serverSide : true,
        ajax       : '{{ route("vital-records.datatable") }}',
        pageLength : 25,
        dom        : 'rt',
        columns    : [
            { data: null, orderable: false, searchable: false,
              render: function() { return '<input type="checkbox" class="row-check" style="cursor:pointer;width:15px;height:15px">'; } },
            { data: 'DT_RowIndex',  orderable: false, searchable: false },
            { data: 'recorded_at', orderable: true },
            { data: 'user_html',   orderable: false },
            { data: 'category',    orderable: false },
            { data: 'type' },
            { data: 'value',       orderable: false },
            { data: 'unit' },
            { data: 'status_html', orderable: false },
            { data: 'note',        orderable: false },
            { data: 'actions',     orderable: false, searchable: false, className: 'text-right' },
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

    // Custom search
    $('#dt-search').on('keyup', function () { table.search(this.value).draw(); });

    // Custom page length
    $('#dt-length').on('change', function () { table.page.len(parseInt(this.value)).draw(); });

    // Select-all checkbox
    $('#select-all').on('change', function () {
        var checked = this.checked;
        $('.row-check').prop('checked', checked);
    });

    // Delete record via AJAX
    $(document).on('click', '.btn-delete-record', function () {
        var url = $(this).data('url');

        Swal.fire({
            title            : 'Delete record?',
            html             : '<p style="font-size:.875rem;color:#475569">This vital record will be permanently deleted.</p>',
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
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong.' });
                },
            });
        });
    });

    // Custom pagination
    function renderPagination(settings) {
        var api  = new $.fn.dataTable.Api(settings);
        var info = api.page.info();
        var $el  = $('#dt-pagination').empty();

        function btn(label, page, disabled, active) {
            var base  = 'width:30px;height:30px;display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:600;border-radius:6px;cursor:pointer;border:1.5px solid #e2e8f0;transition:all .15s;font-family:inherit;';
            var style = active
                ? base + 'background:#2563eb;color:#fff;border-color:#2563eb'
                : disabled
                    ? base + 'background:#fff;color:#cbd5e1;cursor:not-allowed'
                    : base + 'background:#fff;color:#475569';
            var $b = $('<button style="' + style + '">' + label + '</button>').prop('disabled', disabled || active);
            if (!disabled && !active) $b.on('click', function () { api.page(page).draw('page'); });
            return $b;
        }

        $el.append(btn('&#8249;', info.page - 1, info.page === 0, false));

        // Show limited page numbers with ellipsis
        var pages = info.pages;
        var cur   = info.page;
        var toShow = [];
        if (pages <= 5) {
            for (var i = 0; i < pages; i++) toShow.push(i);
        } else {
            toShow = [0, 1];
            if (cur > 2) toShow.push('...');
            if (cur > 1 && cur < pages - 1) toShow.push(cur);
            if (cur < pages - 3) toShow.push('...');
            toShow.push(pages - 2, pages - 1);
            toShow = [...new Set(toShow)];
        }

        toShow.forEach(function (p) {
            if (p === '...') {
                $el.append($('<span style="padding:0 4px;color:#94a3b8;font-size:.75rem">…</span>'));
            } else {
                $el.append(btn(p + 1, p, false, p === cur));
            }
        });

        $el.append(btn('&#8250;', info.page + 1, info.page === info.pages - 1, false));
    }

    function renderInfo(settings) {
        var api  = new $.fn.dataTable.Api(settings);
        var info = api.page.info();
        $('#dt-info').text('Showing ' + (info.start + 1) + ' to ' + Math.min(info.end, info.recordsDisplay) + ' of ' + info.recordsDisplay + ' entries');
    }
});
</script>
@endpush
