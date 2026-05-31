<!DOCTYPE html>
<html lang="en">

<!-- Begin: Head -->
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Dashboard') – Vital Trackers</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ── DataTable resets ─────────────────────────────── */
        table.dataTable { border-collapse: collapse !important; width: 100% !important; }
        table.dataTable thead th {
            background: #f8fafc;
            font-size: 0.72rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 13px 16px;
            border-bottom: 1px solid #f1f5f9 !important;
            white-space: nowrap;
        }
        table.dataTable tbody td {
            padding: 14px 16px;
            font-size: 0.875rem;
            color: #374151;
            border-bottom: 1px solid #f8fafc;
            vertical-align: middle;
        }
        table.dataTable tbody tr:last-child td { border-bottom: none; }
        table.dataTable tbody tr:hover td { background: #f9fafb; }
        #dt-wrapper .dataTables_processing {
            background: rgba(255,255,255,.9);
            border: none;
            box-shadow: none;
            font-size: 0.8rem;
            color: #94a3b8;
        }

        /* ── Page loading overlay ─────────────────────────── */
        #page-loading {
            position: fixed; inset: 0;
            background: rgba(255,255,255,.8);
            backdrop-filter: blur(3px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity .3s;
        }
        #page-loading.hidden { opacity: 0; pointer-events: none; }
        .spin {
            width: 34px; height: 34px;
            border: 3px solid #dbeafe;
            border-top-color: #3b82f6;
            border-radius: 50%;
            animation: spin .6s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Sidebar ──────────────────────────────────────── */
        .sidebar-link { @apply flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-all duration-150; }
        .sidebar-link.active { @apply bg-blue-50 text-blue-600; }
        .sidebar-section-label { @apply text-[10px] font-semibold text-slate-400 uppercase tracking-widest px-3 mb-1 mt-5; }

        /* ── Form utilities ───────────────────────────────── */
        .form-label  { @apply block text-sm font-semibold text-gray-700 mb-1.5; }
        .form-hint   { @apply text-xs text-gray-400 mt-1; }
        .form-error  { @apply text-xs text-red-500 mt-1; }
        .form-input  {
            @apply w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 bg-white
                   placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all;
        }
        .form-input--error { @apply border-red-400 focus:ring-red-400; }

        /* ── Icon picker ──────────────────────────────────── */
        .icon-option__box {
            @apply relative w-16 h-16 rounded-2xl flex items-center justify-center
                   border-2 border-transparent transition-all duration-150
                   hover:border-blue-300 hover:shadow-md cursor-pointer;
        }
        .icon-option__box--selected { @apply border-blue-500 shadow-md shadow-blue-100; }
        .icon-option__check {
            @apply absolute -top-1.5 -right-1.5 w-5 h-5 bg-blue-600 rounded-full
                   flex items-center justify-center transition-opacity;
        }

        /* ── Status option ────────────────────────────────── */
        .status-option__box {
            @apply p-4 rounded-xl border-2 border-gray-100
                   hover:border-blue-200 transition-all duration-150 cursor-pointer;
        }
        .status-option__box--selected { @apply border-blue-500 bg-blue-50/40; }
    </style>
</head>
<!-- End: Head -->

<!-- Begin: Body -->
<body class="bg-slate-50 text-slate-800 antialiased">

    <!-- Begin: Page Loading Overlay -->
    <div id="page-loading">
        <div class="flex flex-col items-center gap-3">
            <div class="spin"></div>
            <p class="text-xs text-slate-400 font-medium tracking-wide">Loading…</p>
        </div>
    </div>
    <!-- End: Page Loading Overlay -->

    <!-- Begin: App Shell -->
    <div class="flex h-screen overflow-hidden">

        <!-- Begin: Sidebar -->
        @include('components.sidebar')
        <!-- End: Sidebar -->

        <!-- Begin: Main Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            <!-- Begin: Navbar -->
            @include('components.navbar')
            <!-- End: Navbar -->

            <!-- Begin: Main Content -->
            <main class="flex-1 overflow-y-auto p-6 space-y-6">

                <!-- Begin: Flash Alert Success -->
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                         class="flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif
                <!-- End: Flash Alert Success -->

                <!-- Begin: Flash Alert Error -->
                @if(session('error'))
                    <div class="flex items-center gap-3 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif
                <!-- End: Flash Alert Error -->

                @yield('content')

            </main>
            <!-- End: Main Content -->

            <!-- Begin: Footer -->
            <footer class="px-6 py-3 border-t border-slate-100 flex items-center justify-between shrink-0">
                <p class="text-xs text-slate-400">© 2026 Vital Trackers. All rights reserved.</p>
                <p class="text-xs text-slate-400">Version 1.0.0</p>
            </footer>
            <!-- End: Footer -->

        </div>
        <!-- End: Main Wrapper -->

    </div>
    <!-- End: App Shell -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Alpine.js (flash message transitions) -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        // Hide page loading overlay once DOM is ready
        document.addEventListener('DOMContentLoaded', () => {
            const el = document.getElementById('page-loading');
            el.classList.add('hidden');
            setTimeout(() => el.remove(), 350);
        });
    </script>

    @stack('scripts')

</body>
<!-- End: Body -->

</html>
