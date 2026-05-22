{{-- ============================================================ --}}
{{-- Sidebar Component                                          --}}
{{-- Contains logo, navigation links grouped by section,       --}}
{{-- and a motivational footer card.                           --}}
{{-- ============================================================ --}}

<aside id="sidebar"
    class="w-64 min-h-screen bg-white border-r border-gray-100 flex flex-col transition-all duration-300 z-30 shrink-0">

    {{-- ── Logo ─────────────────────────────────────────────── --}}
    <!-- Begin: Sidebar Logo -->
    <div class="flex items-center gap-3 px-5 py-5 border-b border-gray-100">
        <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </div>
        <div>
            <span class="text-gray-900 font-bold text-base">Vital</span>
            <span class="text-blue-600 font-bold text-base">Trackers</span>
        </div>
    </div>
    <!-- End: Sidebar Logo -->

    {{-- ── Navigation ───────────────────────────────────────── --}}
    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">

        {{-- Dashboard link --}}
        <!-- Begin: Nav Dashboard -->
        <a href="{{ url('/dashboard') }}"
            class="sidebar-link {{ request()->is('dashboard') ? 'sidebar-link--active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>
        <!-- End: Nav Dashboard -->

        {{-- Transactions section --}}
        <!-- Begin: Nav Transactions Section -->
        <p class="sidebar-section-title">TRANSACTIONS</p>

        <a href="{{ url('/vital-records') }}"
            class="sidebar-link {{ request()->is('vital-records*') ? 'sidebar-link--active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            Vital Records
        </a>

        <a href="{{ url('/vital-records/create') }}"
            class="sidebar-link {{ request()->is('vital-records/create') ? 'sidebar-link--active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add New Record
        </a>

        <a href="{{ url('/import') }}"
            class="sidebar-link {{ request()->is('import*') ? 'sidebar-link--active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
            </svg>
            Import Data
        </a>

        {{-- Reports with sub indicator --}}
        <a href="{{ url('/reports') }}"
            class="sidebar-link {{ request()->is('reports*') ? 'sidebar-link--active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 ２h-２a２ ２ ０ ０１-２ -２z" />
            </svg>
            Reports
            <svg class="w-4 h-4 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
        <!-- End: Nav Transactions Section -->

        {{-- Master Data (Admin) section --}}
        <!-- Begin: Nav Master Data Section -->
        <p class="sidebar-section-title">MASTER DATA (ADMIN)</p>

        <a href="{{ url('/users') }}"
            class="sidebar-link {{ request()->is('users*') ? 'sidebar-link--active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Users
        </a>

        <a href="{{ url('/vital-categories') }}"
            class="sidebar-link {{ request()->is('vital-categories*') ? 'sidebar-link--active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            Vital Categories
        </a>

        <a href="{{ url('/vital-types') }}"
            class="sidebar-link {{ request()->is('vital-types*') ? 'sidebar-link--active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            Vital Types
        </a>
        <!-- End: Nav Master Data Section -->

        {{-- System section --}}
        <!-- Begin: Nav System Section -->
        <p class="sidebar-section-title">SYSTEM</p>

        <a href="{{ url('/profile') }}"
            class="sidebar-link {{ request()->is('profile*') ? 'sidebar-link--active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            Profile
        </a>

        <a href="{{ url('/settings') }}"
            class="sidebar-link {{ request()->is('settings*') ? 'sidebar-link--active' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Settings
        </a>

        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit"
                class="sidebar-link w-full text-left text-red-500 hover:bg-red-50 hover:text-red-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
            </button>
        </form>
        <!-- End: Nav System Section -->

    </nav>

    {{-- ── Motivational Footer Card ────────────────────────── --}}
    <!-- Begin: Sidebar Stay Healthy Card -->
    <div class="mx-3 mb-4 p-4 bg-blue-50 rounded-2xl relative overflow-hidden">
        <p class="text-sm font-bold text-gray-800">Stay Healthy!</p>
        <p class="text-xs text-gray-500 mt-1 leading-relaxed max-w-[120px]">
            Consistent tracking helps you understand your health better every day.
        </p>
        {{-- Decorative character illustration --}}
        <div class="absolute bottom-0 right-2 w-16 h-16 opacity-80">
            <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="40" cy="20" r="12" fill="#93C5FD" />
                <rect x="28" y="34" width="24" height="28" rx="8" fill="#60A5FA" />
                <rect x="18" y="36" width="12" height="6" rx="3" fill="#93C5FD" />
                <rect x="50" y="36" width="12" height="6" rx="3" fill="#93C5FD" />
                <rect x="30" y="62" width="8" height="14" rx="4" fill="#93C5FD" />
                <rect x="42" y="62" width="8" height="14" rx="4" fill="#93C5FD" />
                <circle cx="36" cy="20" r="2" fill="#1E40AF" />
                <circle cx="44" cy="20" r="2" fill="#1E40AF" />
                <path d="M36 27 Q40 30 44 27" stroke="#1E40AF" stroke-width="1.5" stroke-linecap="round" fill="none" />
            </svg>
        </div>
        <div class="mt-3">
            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </div>
    </div>
    <!-- End: Sidebar Stay Healthy Card -->

</aside>

{{-- ── Sidebar inline styles ──────────────────────────────── --}}
<style>
    .sidebar-link {
        @apply flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 transition-all duration-150 hover:bg-blue-50 hover:text-blue-600;
    }

    .sidebar-link--active {
        @apply bg-blue-50 text-blue-600 font-semibold;
    }

    .sidebar-section-title {
        @apply text-[10px] font-semibold text-gray-400 tracking-widest px-3 pt-4 pb-1;
    }
</style>
