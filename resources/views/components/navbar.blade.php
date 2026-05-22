{{-- ============================================================ --}}
{{-- Navbar / Top Bar Component                                 --}}
{{-- Displays breadcrumb, search bar, notifications, and user  --}}
{{-- profile dropdown.                                          --}}
{{-- ============================================================ --}}

<header class="bg-white border-b border-gray-100 px-6 py-3 flex items-center gap-4 shrink-0">

    {{-- ── Hamburger toggle (mobile / collapsed sidebar) ───── --}}
    <!-- Begin: Navbar Toggle -->
    <button id="sidebarToggle" class="p-2 rounded-lg hover:bg-gray-100 transition-colors lg:hidden">
        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>
    <!-- End: Navbar Toggle -->

    {{-- ── Breadcrumb ───────────────────────────────────────── --}}
    <!-- Begin: Navbar Breadcrumb -->
    <nav class="flex items-center gap-1 text-sm text-gray-500 flex-1">
        @foreach ($breadcrumbs ?? [] as $crumb)
            @if (!$loop->last)
                <a href="{{ $crumb['url'] }}" class="hover:text-blue-600 transition-colors">{{ $crumb['label'] }}</a>
                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            @else
                <span class="text-gray-800 font-medium">{{ $crumb['label'] }}</span>
            @endif
        @endforeach
    </nav>
    <!-- End: Navbar Breadcrumb -->

    {{-- ── Search Bar ───────────────────────────────────────── --}}
    <!-- Begin: Navbar Search -->
    <div class="relative hidden md:flex items-center">
        <svg class="w-4 h-4 text-gray-400 absolute left-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input type="text" placeholder="Search category..."
            class="pl-9 pr-16 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg w-56 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" />
        <kbd
            class="absolute right-3 text-[10px] text-gray-400 bg-gray-100 border border-gray-200 rounded px-1 py-0.5">Ctrl+K</kbd>
    </div>
    <!-- End: Navbar Search -->

    {{-- ── Notification Bell ────────────────────────────────── --}}
    <!-- Begin: Navbar Notifications -->
    <div class="relative">
        <button class="relative p-2 rounded-lg hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            {{-- Notification badge --}}
            <span
                class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center">
                3
            </span>
        </button>
    </div>
    <!-- End: Navbar Notifications -->

    {{-- ── User Profile Dropdown ────────────────────────────── --}}
    <!-- Begin: Navbar User Dropdown -->
    <div class="relative" x-data="{ open: false }">
        <button @click="open = !open"
            class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-gray-100 transition-colors">
            <div
                class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm">
                {{ substr(auth()->user()->name ?? 'J', 0, 1) }}
            </div>
            <div class="hidden md:block text-left">
                <p class="text-xs font-semibold text-gray-800 leading-tight">{{ auth()->user()->name ?? 'John Doe' }}
                </p>
                <p class="text-[10px] text-gray-400 leading-tight">Admin</p>
            </div>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        {{-- Dropdown menu --}}
        <div x-show="open" @click.away="open = false" x-cloak
            class="absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
            <a href="#" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">Profile</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">Settings</a>
            <div class="border-t border-gray-100 my-1"></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50">Logout</button>
            </form>
        </div>
    </div>
    <!-- End: Navbar User Dropdown -->

</header>
