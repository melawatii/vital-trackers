<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Vital Trackers') – Vital Trackers</title>

    {{-- Tailwind CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- jQuery & DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    {{-- SweetAlert2 for delete confirmation --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('styles')
</head>

<body class="bg-gray-50 font-sans antialiased">

    {{-- Page wrapper --}}
    <div class="flex h-screen overflow-hidden">

        {{-- ───────────────────────────────────────────────── --}}
        {{-- Sidebar Component                                 --}}
        {{-- ───────────────────────────────────────────────── --}}
        @include('components.sidebar')

        {{-- Main content area --}}
        <div class="flex flex-col flex-1 overflow-hidden">

            {{-- ───────────────────────────────────────────── --}}
            {{-- Navbar Component                              --}}
            {{-- ───────────────────────────────────────────── --}}
            @include('components.navbar')

            {{-- Scrollable page content --}}
            <main class="flex-1 overflow-y-auto p-6">

                {{-- Flash messages --}}
                @include('components.flash-messages')

                {{-- Page slot --}}
                @yield('content')

            </main>

            {{-- Footer --}}
            @include('components.footer')

        </div>
    </div>

    @stack('scripts')

</body>

</html>
