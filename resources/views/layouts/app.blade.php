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

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('build/assets/logo.png') }}">

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ── Sidebar links ────────────────────────────────── */
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            color: #475569;
            text-decoration: none;
            transition: all .15s;
            width: 100%;
            background: transparent;
            border: none;
            cursor: pointer;
            text-align: left;
        }
        .sidebar-link:hover { background: #eff6ff; color: #2563eb; }
        .sidebar-link.active { background: #eff6ff; color: #2563eb; }
        .sidebar-section-label {
            font-size: 10px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .1em;
            padding: 20px 12px 6px;
            display: block;
        }

        /* ── Form fields ──────────────────────────────────── */
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }
        .form-hint  { font-size: 0.75rem; color: #9ca3af; margin-top: 4px; }
        .form-error { font-size: 0.75rem; color: #ef4444; margin-top: 4px; }
        .form-input {
            width: 100%;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 10px 16px;
            font-size: 0.875rem;
            color: #1f2937;
            background: #fff;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .form-input::placeholder { color: #d1d5db; }
        .form-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,.15); }
        .form-input.is-error { border-color: #f87171; }
        .form-input.is-error:focus { box-shadow: 0 0 0 3px rgba(248,113,113,.15); }

        /* ── Icon picker ──────────────────────────────────── */
        .icon-box {
            position: relative;
            width: 64px;
            height: 64px;
            border-radius: 16px;
            border: 2px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: border-color .15s, box-shadow .15s;
            user-select: none;
        }
        .icon-box:hover { border-color: #93c5fd; box-shadow: 0 2px 8px rgba(59,130,246,.12); }
        .icon-box.selected {
            border-color: #3b82f6;
            box-shadow: 0 2px 12px rgba(59,130,246,.2);
        }
        .icon-check {
            position: absolute;
            top: -7px;
            right: -7px;
            width: 20px;
            height: 20px;
            background: #2563eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity .15s;
        }
        .icon-box.selected .icon-check { opacity: 1; }

        /* ── Status radio cards ───────────────────────────── */
        .status-card {
            padding: 16px;
            border-radius: 12px;
            border: 2px solid #f1f5f9;
            cursor: pointer;
            transition: border-color .15s, background .15s;
        }
        .status-card:hover { border-color: #bfdbfe; }
        .status-card.selected { border-color: #3b82f6; background: rgba(239,246,255,.5); }
        .radio-dot {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all .15s;
        }
        .radio-dot.checked { border-color: #2563eb; background: #2563eb; }
        .radio-dot-inner {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #fff;
            opacity: 0;
            transition: opacity .15s;
        }
        .radio-dot.checked .radio-dot-inner { opacity: 1; }

        /* ── DataTable overrides ──────────────────────────── */
        table.dataTable { border-collapse: collapse !important; width: 100% !important; }
        table.dataTable thead th {
            background: #f8fafc;
            font-size: 0.72rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .06em;
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

        /* ── Page loading overlay ─────────────────────────── */
        #page-loading {
            position: fixed; inset: 0;
            background: rgba(255,255,255,.85);
            backdrop-filter: blur(3px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity .3s;
        }
        .spin {
            width: 34px; height: 34px;
            border: 3px solid #dbeafe;
            border-top-color: #3b82f6;
            border-radius: 50%;
            animation: spin .65s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<!-- End: Head -->

<!-- Begin: Body -->
<body class="bg-slate-50 text-slate-800 antialiased">

    <!-- Begin: Page Loading Overlay -->
    <div id="page-loading">
        <div style="display:flex;flex-direction:column;align-items:center;gap:12px">
            <div class="spin"></div>
            <p style="font-size:.75rem;color:#94a3b8;font-weight:500">Loading…</p>
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
            <main class="flex-1 overflow-y-auto p-6 space-y-5">

                <!-- Begin: Flash Alert Success -->
                @if(session('success'))
                    <div class="flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700">
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

    <script>
        // Hide page loading overlay once DOM is ready
        document.addEventListener('DOMContentLoaded', () => {
            const el = document.getElementById('page-loading');
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 300);
        });
    </script>

    @stack('scripts')

</body>
<!-- End: Body -->

</html>
