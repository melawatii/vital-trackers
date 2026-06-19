{{-- Top navbar partial – breadcrumb, search, notifications, user menu --}}

<!-- Begin: Navbar -->
<header class="h-[57px] shrink-0 bg-white border-b border-slate-100 flex items-center gap-4 px-5">

    <!-- Begin: Hamburger (mobile) -->
    <button class="p-1.5 rounded-lg text-slate-500 hover:bg-slate-100 transition lg:hidden">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
    <!-- End: Hamburger (mobile) -->

    <!-- Begin: Breadcrumb -->
    <nav class="flex items-center gap-1 text-sm">
        @foreach($breadcrumbs ?? [] as $i => $crumb)
            @if($i > 0)
                <span class="text-slate-300">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            @endif
            @if(isset($crumb['url']))
                <a href="{{ $crumb['url'] }}" class="text-slate-500 hover:text-slate-700 transition">{{ $crumb['label'] }}</a>
            @else
                <span class="{{ $loop->last ? 'text-slate-700 font-semibold' : 'text-slate-500' }}">{{ $crumb['label'] }}</span>
            @endif
        @endforeach
    </nav>
    <!-- End: Breadcrumb -->

    <!-- Begin: Right Controls -->
    <div class="ml-auto flex items-center gap-3">

        <!-- Notification bell -->
        <button class="relative p-2 rounded-lg text-slate-500 hover:bg-slate-100 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
        </button>

        <!-- User avatar + name -->
        <div class="flex items-center gap-2.5 pl-3 border-l border-slate-100">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-sm">
                <span class="text-white text-xs font-bold">JD</span>
            </div>
            <div class="hidden md:block leading-none">
                <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->name ?? 'Unknown User' }}</p>
                <p class="text-xs text-slate-400 mt-0.5">{{ auth()->user()->role }}</p>
            </div>
        </div>

    </div>
    <!-- End: Right Controls -->

</header>
<!-- End: Navbar -->
