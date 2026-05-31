{{--
 | Sidebar Component
 | Fixed left sidebar with logo, grouped navigation links,
 | and a motivational "Stay Healthy" card at the bottom.
 --}}

<aside id="sidebar"
    class="w-[268px]
            bg-white
            border-r
            border-[#E8EEF8]
            flex
            flex-col">

    <!-- Begin: Sidebar Logo -->
    <div class="flex items-center gap-2.5 px-4 py-4 border-b border-gray-100">
        {{-- Brand icon --}}
        <div class="w-8 h-8 bg-blue-600 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </div>
        {{-- Brand name: "Vital" dark, "Trackers" blue --}}
        <div>
            <span class="text-gray-900 font-bold text-[15px] tracking-tight">Vital</span><span class="text-blue-600 font-bold text-[15px] tracking-tight">Trackers</span>
        </div>
    </div>
    <!-- End: Sidebar Logo -->

    <!-- Begin: Sidebar Navigation -->
    <nav class="flex-1 px-2.5 py-3 overflow-y-auto">

        <!-- Begin: Nav Item Dashboard -->
        <a href="{{ url('/dashboard') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150 mb-0.5
                {{ request()->is('dashboard') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
            <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Dashboard</span>
        </a>
        <!-- End: Nav Item Dashboard -->

        <!-- Begin: Nav Section Label Transactions -->
        <p class="text-[10px] font-semibold text-gray-400 tracking-widest px-3 pt-4 pb-1.5 uppercase">Transactions</p>
        <!-- End: Nav Section Label Transactions -->

        <!-- Begin: Nav Item Vital Records -->
        <a href="{{ url('/vital-records') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150 mb-0.5
                {{ request()->is('vital-records*') && !request()->is('vital-records/create') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
            <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span>Vital Records</span>
        </a>
        <!-- End: Nav Item Vital Records -->

        <!-- Begin: Nav Item Add New Record -->
        <a href="{{ url('/vital-records/create') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150 mb-0.5
                {{ request()->is('vital-records/create') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
            {{-- Plus-circle icon --}}
            <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Add New Record</span>
        </a>
        <!-- End: Nav Item Add New Record -->

        <!-- Begin: Nav Item Import Data -->
        <a href="{{ url('/import') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150 mb-0.5
                {{ request()->is('import*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
            <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
            </svg>
            <span>Import Data</span>
        </a>
        <!-- End: Nav Item Import Data -->

        <!-- Begin: Nav Item Reports -->
        {{-- Chevron-right indicates this item has sub-pages --}}
        <a href="{{ url('/reports') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150 mb-0.5
                {{ request()->is('reports*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
            <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <span>Reports</span>
            <svg class="w-3.5 h-3.5 ml-auto shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
        <!-- End: Nav Item Reports -->

        <!-- Begin: Nav Section Label Master Data -->
        <p class="text-[10px] font-semibold text-gray-400 tracking-widest px-3 pt-4 pb-1.5 uppercase">Master Data (Admin)</p>
        <!-- End: Nav Section Label Master Data -->

        <!-- Begin: Nav Item Users -->
        <a href="{{ url('/users') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150 mb-0.5
                {{ request()->is('users*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
            <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>Users</span>
        </a>
        <!-- End: Nav Item Users -->

        <!-- Begin: Nav Item Vital Categories -->
        <a href="{{ route('vital-categories.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150 mb-0.5
                {{ request()->is('vital-categories*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
            {{-- Four-square / grid icon --}}
            <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span>Vital Categories</span>
        </a>
        <!-- End: Nav Item Vital Categories -->

        <!-- Begin: Nav Item Vital Types -->
        <a href="{{ url('/vital-types') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150 mb-0.5
                {{ request()->is('vital-types*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
            <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span>Vital Types</span>
        </a>
        <!-- End: Nav Item Vital Types -->

        <!-- Begin: Nav Section Label System -->
        <p class="text-[10px] font-semibold text-gray-400 tracking-widest px-3 pt-4 pb-1.5 uppercase">System</p>
        <!-- End: Nav Section Label System -->

        <!-- Begin: Nav Item Profile -->
        <a href="{{ url('/profile') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150 mb-0.5
                {{ request()->is('profile*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
            <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>Profile</span>
        </a>
        <!-- End: Nav Item Profile -->

        <!-- Begin: Nav Item Settings -->
        <a href="{{ url('/settings') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium transition-all duration-150 mb-0.5
                {{ request()->is('settings*') ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
            <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Settings</span>
        </a>
        <!-- End: Nav Item Settings -->

        <!-- Begin: Nav Item Logout -->
        {{-- POST form to properly invalidate session on logout --}}
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium
                       text-gray-600 hover:bg-red-50 hover:text-red-500 transition-all duration-150">
                <svg class="w-[18px] h-[18px] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Logout</span>
            </button>
        </form>
        <!-- End: Nav Item Logout -->

    </nav>
    <!-- End: Sidebar Navigation -->

    <!-- Begin: Stay Healthy Card -->
    {{--
        Motivational card pinned to the sidebar bottom.
        Positions text top-left, character illustration bottom-right,
        and a heart badge bottom-left.
    --}}
    <div class="mx-2.5 mb-3 p-4 bg-blue-50 rounded-2xl relative overflow-hidden" style="min-height: 118px;">

        <!-- Begin: Stay Healthy Card Text -->
        <p class="text-sm font-bold text-gray-800 relative z-10">Stay Healthy!</p>
        <p class="text-[11px] leading-relaxed text-gray-500 mt-1 relative z-10" style="max-width: 108px;">
            Consistent tracking helps you understand your health better every day.
        </p>
        <!-- End: Stay Healthy Card Text -->

        <!-- Begin: Stay Healthy Card Character -->
        {{-- SVG character illustration, anchored bottom-right --}}
        <div class="absolute bottom-0 right-0 z-0" style="width:76px; height:96px;">
            <svg viewBox="0 0 76 96" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                {{-- Head --}}
                <circle cx="38" cy="17" r="13" fill="#BFDBFE"/>
                {{-- Body --}}
                <rect x="25" y="31" width="26" height="27" rx="9" fill="#60A5FA"/>
                {{-- Left arm --}}
                <rect x="11" y="34" width="15" height="7" rx="3.5" fill="#93C5FD"/>
                {{-- Right arm (raised, holding heart) --}}
                <rect x="50" y="27" width="15" height="7" rx="3.5" fill="#93C5FD" transform="rotate(-25 50 27)"/>
                {{-- Left leg --}}
                <rect x="27" y="57" width="9" height="17" rx="4.5" fill="#93C5FD"/>
                {{-- Right leg --}}
                <rect x="40" y="57" width="9" height="17" rx="4.5" fill="#93C5FD"/>
                {{-- Eyes --}}
                <circle cx="34" cy="16" r="2.2" fill="#1E40AF"/>
                <circle cx="42" cy="16" r="2.2" fill="#1E40AF"/>
                {{-- Smile --}}
                <path d="M34 23 Q38 27 42 23" stroke="#1E40AF" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                {{-- Heart in raised hand --}}
                <path d="M66 20 C66 18.2 64.4 16.5 62.5 18 C60.6 16.5 59 18.2 59 20 C59 21.8 62.5 25 62.5 25 C62.5 25 66 21.8 66 20Z" fill="#F87171"/>
            </svg>
        </div>
        <!-- End: Stay Healthy Card Character -->

        <!-- Begin: Stay Healthy Card Heart Badge -->
        {{-- Small white heart icon badge in bottom-left --}}
        <div class="absolute bottom-3 left-4 z-10">
            <div class="w-7 h-7 bg-white rounded-lg shadow-sm flex items-center justify-center">
                <svg class="w-[15px] h-[15px] text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
        </div>
        <!-- End: Stay Healthy Card Heart Badge -->

    </div>
    <!-- End: Stay Healthy Card -->

</aside>
