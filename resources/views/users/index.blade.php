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
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Users</h1>
            <p class="text-sm text-slate-500 mt-0.5">Manage system users and their access.</p>
        </div>
        <a href="{{ route('users.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold rounded-xl shadow-sm shadow-blue-200 transition-all duration-150 active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Add New User
        </a>
    </div>
    <!-- End: Page Header -->

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
            <p class="text-xs text-slate-400">Loading users…</p>
        </div>
        <!-- End: Table Loading Spinner -->

        <!-- Begin: DataTable Wrapper -->
        <div id="dt-wrapper" class="hidden">
            <table id="users-table" class="w-full">
                <thead>
                    <tr>
                        <th class="w-12">#</th>
                        <th class="cursor-pointer hover:bg-slate-50 select-none">Full Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Login</th>
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
    const table = $('#users-table').DataTable({
        processing : true,
        serverSide : true,
        ajax       : '{{ route("users.datatable") }}',
        pageLength : 25,
        dom        : 'rt', // hide default controls
        columns    : [
            {
                data      : 'DT_RowIndex',
                orderable : false,
                searchable: false,
            },
            { data: 'name', orderable: true, render: function(data, type, row) { return row.name_html; } },
            { data: 'username' },
            { data: 'email' },
            { data: 'role_html',   orderable: false },
            { data: 'status_html', orderable: false },
            { data: 'last_login',  orderable: false },
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

    // Delete user via AJAX with SweetAlert2 confirmation
    $(document).on('click', '.btn-delete-user', function () {
        const url  = $(this).data('url');
        const name = $(this).data('name');

        Swal.fire({
            title            : 'Delete user?',
            html             : `<p class="text-sm text-slate-600">You are about to delete <strong>${name}</strong>. This action cannot be undone.</p>`,
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
                error: xhr => {
                    const msg = xhr.responseJSON?.message || 'Something went wrong.';
                    Swal.fire({ icon: 'error', title: 'Error', text: msg });
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
