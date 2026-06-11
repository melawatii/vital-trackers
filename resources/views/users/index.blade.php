@extends('layouts.app')

@section('title', 'Users')

@php
    // Breadcrumb data for navbar
    $breadcrumbs = [
        ['label' => 'Master Data (Admin)'],
        ['label' => 'Users'],
    ];
@endphp

@section('content')

    <!-- Begin: Page Header -->
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Users</h1>
            <p class="text-sm text-slate-500 mt-1">Manage system users and their access.</p>
        </div>
        <a href="{{ route('users.create') }}"
           style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#2563eb;color:#fff;font-size:.875rem;font-weight:600;border-radius:12px;text-decoration:none;box-shadow:0 2px 8px rgba(37,99,235,.25);transition:background .15s"
           onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
            <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Add New User
        </a>
    </div>
    <!-- End: Page Header -->

    <!-- Begin: DataTable Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

        <!-- Begin: Table Toolbar -->
        <div style="display:flex;align-items:center;gap:10px;padding:16px 20px;border-bottom:1px solid #f8fafc;flex-wrap:wrap">

            {{-- Search --}}
            <div style="position:relative;flex:1;min-width:220px;max-width:400px">
                <svg style="width:14px;height:14px;position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input id="dt-search" type="text" placeholder="Search by name, email, or username..."
                       style="width:100%;padding:9px 12px 9px 34px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:.8125rem;outline:none;font-family:'Plus Jakarta Sans',sans-serif;transition:border-color .15s"
                       onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'" />
            </div>

            {{-- Filter: Role --}}
            <select id="filter-role"
                    style="padding:9px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:.8125rem;font-weight:500;color:#374151;background:#fff;cursor:pointer;outline:none;font-family:'Plus Jakarta Sans',sans-serif">
                <option value="">All Roles</option>
                <option value="admin">Administrator</option>
                <option value="user">User</option>
            </select>

            {{-- Filter: Status --}}
            <select id="filter-status"
                    style="padding:9px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:.8125rem;font-weight:500;color:#374151;background:#fff;cursor:pointer;outline:none;font-family:'Plus Jakarta Sans',sans-serif">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>

            {{-- More Filters button --}}
            <button style="display:inline-flex;align-items:center;gap:6px;padding:9px 14px;border:1.5px solid #e2e8f0;border-radius:10px;font-size:.8125rem;font-weight:600;color:#64748b;background:#fff;cursor:pointer;margin-left:auto">
                <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                More Filters
            </button>

        </div>
        <!-- End: Table Toolbar -->

        <!-- Begin: Table Loading Spinner -->
        <div id="dt-loading" style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:80px 0;gap:12px">
            <div class="spin"></div>
            <p style="font-size:.75rem;color:#94a3b8">Loading users…</p>
        </div>
        <!-- End: Table Loading Spinner -->

        <!-- Begin: DataTable Wrapper -->
        <div id="dt-wrapper" style="display:none">
            <table id="users-table" class="w-full">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th class="text-right pr-5">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <!-- End: DataTable Wrapper -->

        <!-- Begin: Table Footer / Pagination -->
        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid #f8fafc">
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
    var table = $('#users-table').DataTable({
        processing : true,
        serverSide : true,
        ajax       : '{{ route("users.datatable") }}',
        pageLength : 25,
        dom        : 'rt',
        columns    : [
            { data: 'name_html',   orderable: false },
            { data: 'username' },
            { data: 'email' },
            { data: 'role_html',   orderable: false },
            { data: 'status_html', orderable: false },
            { data: 'last_login',  orderable: false },
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

    // Sync custom search input
    $('#dt-search').on('keyup', function () {
        table.search(this.value).draw();
    });

    // Filter by role — client-side column search
    $('#filter-role').on('change', function () {
        table.column(3).search(this.value).draw();
    });

    // Filter by status — client-side column search
    $('#filter-status').on('change', function () {
        table.column(4).search(this.value).draw();
    });

    // Delete user via AJAX with SweetAlert2 confirmation
    $(document).on('click', '.btn-delete-user', function () {
        var url  = $(this).data('url');
        var name = $(this).data('name');

        Swal.fire({
            title            : 'Delete user?',
            html             : '<p style="font-size:.875rem;color:#475569">You are about to delete <strong>' + name + '</strong>. This action cannot be undone.</p>',
            icon             : 'warning',
            showCancelButton : true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText : 'Cancel',
            confirmButtonColor: '#ef4444',
            customClass      : { popup: 'rounded-2xl' },
        }).then(function (result) {
            if (!result.isConfirmed) return;

            Swal.fire({ title: 'Deleting…', allowOutsideClick: false, didOpen: function () { Swal.showLoading(); } });

            $.ajax({
                url    : url,
                type   : 'DELETE',
                data   : { _token: $('meta[name="csrf-token"]').attr('content') },
                success: function (res) {
                    Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 2000, showConfirmButton: false });
                    table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    var msg = xhr.responseJSON?.message || 'Something went wrong.';
                    Swal.fire({ icon: 'error', title: 'Error', text: msg });
                },
            });
        });
    });

    // Custom pagination renderer
    function renderPagination(settings) {
        var api  = new $.fn.dataTable.Api(settings);
        var info = api.page.info();
        var $el  = $('#dt-pagination').empty();

        function btn(label, page, disabled, active) {
            var base  = 'min-width:32px;height:32px;padding:0 8px;display:inline-flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:600;border-radius:8px;cursor:pointer;border:1.5px solid #e2e8f0;transition:all .15s;font-family:inherit;';
            var style = active
                ? base + 'background:#2563eb;color:#fff;border-color:#2563eb'
                : disabled
                    ? base + 'background:#fff;color:#cbd5e1;cursor:not-allowed'
                    : base + 'background:#fff;color:#475569';
            var $b = $('<button style="' + style + '">' + label + '</button>').prop('disabled', disabled || active);
            if (!disabled && !active) $b.on('click', function () { api.page(page).draw('page'); });
            return $b;
        }

        var pages = info.pages;
        var cur   = info.page;

        $el.append(btn('&#8249;', cur - 1, cur === 0, false));

        // Page numbers with ellipsis
        for (var i = 0; i < pages; i++) {
            if (i === 0 || i === pages - 1 || (i >= cur - 1 && i <= cur + 1)) {
                $el.append(btn(i + 1, i, false, i === cur));
            } else if (i === cur - 2 || i === cur + 2) {
                $el.append($('<span style="padding:0 4px;color:#94a3b8;line-height:32px">…</span>'));
            }
        }

        $el.append(btn('&#8250;', cur + 1, cur === pages - 1, false));
    }

    function renderInfo(settings) {
        var api  = new $.fn.dataTable.Api(settings);
        var info = api.page.info();
        $('#dt-info').text('Showing ' + (info.start + 1) + ' to ' + Math.min(info.end, info.recordsDisplay) + ' of ' + info.recordsDisplay + ' results');
    }
});
</script>
@endpush