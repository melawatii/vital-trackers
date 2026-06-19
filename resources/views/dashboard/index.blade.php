@extends('layouts.app')

@section('title', 'Dashboard')

@php
    // Breadcrumb data for navbar
    $breadcrumbs = [];

    // Donut chart color palette
    $donutColors = ['#3b82f6','#22c55e','#f59e0b','#8b5cf6','#ef4444','#94a3b8'];

    // Date range label for header
    $dateRange = now()->startOfMonth()->format('d M Y') . ' – ' . now()->endOfMonth()->format('d M Y');
@endphp

@section('content')

    <!-- Begin: Page Header -->
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>
            <p class="text-sm text-slate-500 mt-1">
                Welcome back, {{ auth()->user()->name ?? 'User' }}! Here's what's happening with your vital records.
            </p>
        </div>
        <div style="display:flex;align-items:center;gap:12px">
            <!-- Date Range Preset Filter -->
            <select id="dateRangeFilter" style="padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.8125rem;font-weight:600;color:#475569;background:#fff;cursor:pointer;outline:none;font-family:'Plus Jakarta Sans',sans-serif">
                <option value="this-month">This Month</option>
                <option value="last-month">Last Month</option>
                <option value="last-3-months">Last 3 Months</option>
                <option value="last-6-months">Last 6 Months</option>
                <option value="this-year">This Year</option>
                <option value="custom">Custom Range</option>
            </select>

            <!-- Custom Date Range (Hidden by default) -->
            <div id="customDateRange" style="display:none;gap:8px;align-items:center;flex-wrap:wrap">
                <input type="date" id="startDate" style="padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.8125rem;background:#fff;font-family:'Plus Jakarta Sans',sans-serif" />
                <span style="color:#94a3b8">–</span>
                <input type="date" id="endDate" style="padding:8px 12px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.8125rem;background:#fff;font-family:'Plus Jakarta Sans',sans-serif" />
                <button id="applyCustomDate" style="padding:8px 14px;background:#3b82f6;color:#fff;border:none;border-radius:8px;font-size:.8125rem;font-weight:600;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif">Apply</button>
                <button id="cancelCustomDate" style="padding:8px 14px;background:#f1f5f9;color:#475569;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.8125rem;font-weight:600;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif">Cancel</button>
            </div>

            <!-- Display Selected Date Range -->
            <div id="selectedDateDisplay" style="display:inline-flex;align-items:center;gap:8px;padding:8px 14px;background:#fff;border:1.5px solid #e2e8f0;border-radius:10px;font-size:.8125rem;font-weight:600;color:#475569">
                <svg style="width:14px;height:14px;color:#94a3b8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span id="dateRangeText">{{ $dateRange }}</span>
            </div>
        </div>
    </div>
    <!-- End: Page Header -->

    <!-- Begin: Stats Cards Row -->
    <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:16px;margin-bottom:20px">

        <!-- Begin: Card Total Records -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px">
                <p style="font-size:.8125rem;font-weight:500;color:#64748b">Total Records</p>
                <div style="width:38px;height:38px;background:#eff6ff;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg style="width:18px;height:18px;color:#3b82f6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
            <p style="font-size:1.625rem;font-weight:800;color:#0f172a;margin-bottom:6px" data-stat="total-records">{{ number_format($stats['total_records']) }}</p>
            <div style="display:flex;align-items:center;gap:4px">
                <span style="display:inline-flex;align-items:center;gap:2px;font-size:.72rem;font-weight:700;color:#22c55e;background:#f0fdf4;padding:2px 6px;border-radius:20px">
                    <svg style="width:10px;height:10px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    +{{ $stats['records_growth'] }}%
                </span>
                <span style="font-size:.72rem;color:#94a3b8">vs last month</span>
            </div>
        </div>
        <!-- End: Card Total Records -->

        <!-- Begin: Card Records This Month -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px">
                <p style="font-size:.8125rem;font-weight:500;color:#64748b">Records This Month</p>
                <div style="width:38px;height:38px;background:#f0fdf4;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg style="width:18px;height:18px;color:#22c55e" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p style="font-size:1.625rem;font-weight:800;color:#0f172a;margin-bottom:6px">{{ number_format($stats['records_this_month']) }}</p>
            <div style="display:flex;align-items:center;gap:4px">
                <span style="display:inline-flex;align-items:center;gap:2px;font-size:.72rem;font-weight:700;color:#22c55e;background:#f0fdf4;padding:2px 6px;border-radius:20px">
                    <svg style="width:10px;height:10px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    +9.8%
                </span>
                <span style="font-size:.72rem;color:#94a3b8">vs last month</span>
            </div>
        </div>
        <!-- End: Card Records This Month -->

        <!-- Begin: Card Total Users -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px">
                <p style="font-size:.8125rem;font-weight:500;color:#64748b">Total Users</p>
                <div style="width:38px;height:38px;background:#f5f3ff;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg style="width:18px;height:18px;color:#8b5cf6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <p style="font-size:1.625rem;font-weight:800;color:#0f172a;margin-bottom:6px">{{ number_format($stats['total_users']) }}</p>
            <div style="display:flex;align-items:center;gap:4px">
                <span style="display:inline-flex;align-items:center;gap:2px;font-size:.72rem;font-weight:700;color:#22c55e;background:#f0fdf4;padding:2px 6px;border-radius:20px">
                    <svg style="width:10px;height:10px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    +4.3%
                </span>
                <span style="font-size:.72rem;color:#94a3b8">vs last month</span>
            </div>
        </div>
        <!-- End: Card Total Users -->

        <!-- Begin: Card Categories -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px">
                <p style="font-size:.8125rem;font-weight:500;color:#64748b">Categories</p>
                <div style="width:38px;height:38px;background:#fffbeb;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg style="width:18px;height:18px;color:#f59e0b" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </div>
            </div>
            <p style="font-size:1.625rem;font-weight:800;color:#0f172a;margin-bottom:6px">{{ $stats['categories'] }}</p>
            <div style="display:flex;align-items:center;gap:4px">
                <span style="display:inline-flex;align-items:center;gap:2px;font-size:.72rem;font-weight:700;color:#22c55e;background:#f0fdf4;padding:2px 6px;border-radius:20px">
                    <svg style="width:10px;height:10px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    +2
                </span>
                <span style="font-size:.72rem;color:#94a3b8">vs last month</span>
            </div>
        </div>
        <!-- End: Card Categories -->

        <!-- Begin: Card Avg Value -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px">
                <p style="font-size:.8125rem;font-weight:500;color:#64748b">Avg. Value (All)</p>
                <div style="width:38px;height:38px;background:#fff1f2;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg style="width:18px;height:18px;color:#f43f5e" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
            </div>
            <p style="font-size:1.625rem;font-weight:800;color:#0f172a;margin-bottom:6px" data-stat="avg-value">{{ $stats['avg_value'] }}</p>
            <div style="display:flex;align-items:center;gap:4px">
                <span style="display:inline-flex;align-items:center;gap:2px;font-size:.72rem;font-weight:700;color:#22c55e;background:#f0fdf4;padding:2px 6px;border-radius:20px">
                    <svg style="width:10px;height:10px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    +27.1%
                </span>
                <span style="font-size:.72rem;color:#94a3b8">vs last month</span>
            </div>
        </div>
        <!-- End: Card Avg Value -->

    </div>
    <!-- End: Stats Cards Row -->

    <!-- Begin: Charts Row -->
    <div style="display:grid;grid-template-columns:1fr 380px;gap:16px;margin-bottom:20px">

        <!-- Begin: Records Over Time Chart Card -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:4px">
                <div>
                    <p style="font-size:.9375rem;font-weight:700;color:#1e293b">Records Over Time</p>
                    <p style="font-size:.75rem;color:#94a3b8;margin-top:2px">Number of records created per day</p>
                </div>
                <select id="chartPeriodFilter" style="padding:5px 10px;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.75rem;font-weight:600;color:#374151;background:#fff;cursor:pointer;outline:none;font-family:'Plus Jakarta Sans',sans-serif">
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                </select>
            </div>
            <!-- Begin: Line Chart Canvas -->
            <div style="height:220px;margin-top:16px">
                <canvas id="lineChart"></canvas>
            </div>
            <!-- End: Line Chart Canvas -->
        </div>
        <!-- End: Records Over Time Chart Card -->

        <!-- Begin: Records by Category Donut Card -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div style="margin-bottom:4px">
                <p style="font-size:.9375rem;font-weight:700;color:#1e293b">Records by Category</p>
                <p style="font-size:.75rem;color:#94a3b8;margin-top:2px">Distribution of records by category</p>
            </div>
            <!-- Begin: Donut Chart + Legend -->
            <div style="display:flex;align-items:center;gap:16px;margin-top:16px">
                <div style="position:relative;flex-shrink:0">
                    <canvas id="donutChart" width="160" height="160"></canvas>
                    <!-- Begin: Donut Center Label -->
                    <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;pointer-events:none">
                        <p style="font-size:1.125rem;font-weight:800;color:#0f172a;line-height:1">{{ number_format($stats['total_records']) }}</p>
                        <p style="font-size:.65rem;color:#94a3b8;margin-top:2px">Total</p>
                    </div>
                    <!-- End: Donut Center Label -->
                </div>
                <!-- Begin: Donut Legend -->
                <div style="flex:1;display:flex;flex-direction:column;gap:8px" data-donut-legend>
                    @foreach($donutData as $i => $cat)
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:8px">
                            <div style="display:flex;align-items:center;gap:6px;min-width:0">
                                <span style="width:8px;height:8px;border-radius:50%;background:{{ $donutColors[$i % count($donutColors)] }};flex-shrink:0;display:inline-block"></span>
                                <span style="font-size:.75rem;color:#475569;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $cat['name'] }}</span>
                            </div>
                            <div style="display:flex;align-items:center;gap:5px;flex-shrink:0">
                                <span style="font-size:.75rem;font-weight:700;color:#0f172a">{{ number_format($cat['count']) }}</span>
                                <span style="font-size:.7rem;color:#94a3b8">({{ $cat['percentage'] }}%)</span>
                            </div>
                        </div>
                    @endforeach
                    @if($donutData->isEmpty())
                        <p style="font-size:.8rem;color:#94a3b8;text-align:center;padding:16px 0">No data yet</p>
                    @endif
                </div>
                <!-- End: Donut Legend -->
            </div>
            <!-- End: Donut Chart + Legend -->
        </div>
        <!-- End: Records by Category Donut Card -->

    </div>
    <!-- End: Charts Row -->

    <!-- Begin: Recent Records + Top Users Row -->
    <div style="display:grid;grid-template-columns:1fr 380px;gap:16px;margin-bottom:20px">

        <!-- Begin: Recent Vital Records Card -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
                <div>
                    <p style="font-size:.9375rem;font-weight:700;color:#1e293b">Recent Vital Records</p>
                    <p style="font-size:.75rem;color:#94a3b8;margin-top:2px">Latest 5 vital records added</p>
                </div>
                <a href="{{ route('vital-records.index') }}"
                   style="padding:6px 14px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.8rem;font-weight:600;color:#475569;text-decoration:none"
                   onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                    View All
                </a>
            </div>

            <!-- Begin: Records List -->
            <div>
                @forelse($recentRecords as $rec)
                    <!-- Begin: Record Row -->
                    <div style="display:flex;align-items:center;gap:14px;padding:11px 0;border-bottom:1px solid #f8fafc">
                        <div style="width:40px;height:40px;background:#f8fafc;border:1.5px solid #f1f5f9;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0">
                            {{ $rec['icon'] }}
                        </div>
                        <div style="flex:1;min-width:0">
                            <p style="font-size:.875rem;font-weight:600;color:#0f172a">{{ $rec['type_name'] }}</p>
                            <p style="font-size:.75rem;color:#3b82f6;font-weight:500;margin-top:1px">{{ $rec['value'] }}</p>
                        </div>
                        <p style="font-size:.8rem;color:#64748b;flex-shrink:0">{{ $rec['user_name'] }}</p>
                        <p style="font-size:.72rem;color:#94a3b8;flex-shrink:0;text-align:right;min-width:130px">{{ $rec['recorded_at'] }}</p>
                        @if($rec['status'] === 'normal')
                            <span style="flex-shrink:0;padding:3px 10px;border-radius:20px;font-size:.7rem;font-weight:700;background:#f0fdf4;color:#15803d">Normal</span>
                        @else
                            <span style="flex-shrink:0;padding:3px 10px;border-radius:20px;font-size:.7rem;font-weight:700;background:#fff1f2;color:#be123c">High</span>
                        @endif
                    </div>
                    <!-- End: Record Row -->
                @empty
                    <p style="text-align:center;color:#94a3b8;font-size:.875rem;padding:32px 0">No records yet.</p>
                @endforelse
            </div>
            <!-- End: Records List -->

        </div>
        <!-- End: Recent Vital Records Card -->

        <!-- Begin: Top Users Card -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
                <div>
                    <p style="font-size:.9375rem;font-weight:700;color:#1e293b">Top Users (by Records)</p>
                    <p style="font-size:.75rem;color:#94a3b8;margin-top:2px">Users with the most records</p>
                </div>
                <a href="{{ route('users.index') }}"
                   style="padding:6px 14px;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.8rem;font-weight:600;color:#475569;text-decoration:none"
                   onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                    View All
                </a>
            </div>

            <!-- Begin: Top Users List -->
            <div style="display:flex;flex-direction:column;gap:14px">
                @forelse($topUsers as $i => $u)
                    <!-- Begin: User Row -->
                    <div style="display:flex;align-items:center;gap:10px">
                        <span style="font-size:.75rem;font-weight:700;color:#94a3b8;width:14px;text-align:center;flex-shrink:0">{{ $i + 1 }}</span>
                        @php $initials = collect(explode(' ', $u['name']))->map(fn($w) => strtoupper($w[0] ?? ''))->take(2)->join(''); @endphp
                        <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#60a5fa,#2563eb);display:flex;align-items:center;justify-content:center;font-size:.65rem;font-weight:700;color:#fff;flex-shrink:0">
                            {{ $initials }}
                        </div>
                        <div style="flex:1;min-width:0">
                            <p style="font-size:.8125rem;font-weight:600;color:#0f172a;margin-bottom:4px">{{ $u['name'] }}</p>
                            <div style="height:4px;background:#f1f5f9;border-radius:4px;overflow:hidden">
                                <div style="height:100%;background:#2563eb;border-radius:4px;width:{{ $u['percentage'] }}%"></div>
                            </div>
                        </div>
                        <span style="font-size:.8rem;font-weight:700;color:#0f172a;flex-shrink:0;min-width:36px;text-align:right">{{ number_format($u['count']) }}</span>
                    </div>
                    <!-- End: User Row -->
                @empty
                    <p style="text-align:center;color:#94a3b8;font-size:.875rem;padding:24px 0">No data yet.</p>
                @endforelse
            </div>
            <!-- End: Top Users List -->

        </div>
        <!-- End: Top Users Card -->

    </div>
    <!-- End: Recent Records + Top Users Row -->

@endsection

@push('scripts')
{{-- Chart.js via CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Chart data passed from PHP controller
    var lineLabels = @json($chartData->pluck('date'));
    var lineCounts = @json($chartData->pluck('count'));
    var donutLabels = @json($donutData->pluck('name'));
    var donutCounts = @json($donutData->pluck('count'));
    var donutColors = @json($donutColors);

    // Store the Chart.js instance globally for updates
    var lineChartInstance = null;
    var donutChartInstance = null;

    // Store current date range for filtering
    var currentDateRange = {
        startDate: null,
        endDate: null,
    };

    // Helper function to calculate date ranges
    function getDateRangeByPeriod(period) {
        var now = new Date();
        var startDate, endDate;

        switch (period) {
            case 'this-month':
                startDate = new Date(now.getFullYear(), now.getMonth(), 1);
                endDate = new Date(now.getFullYear(), now.getMonth() + 1, 0);
                break;
            case 'last-month':
                startDate = new Date(now.getFullYear(), now.getMonth() - 1, 1);
                endDate = new Date(now.getFullYear(), now.getMonth(), 0);
                break;
            case 'last-3-months':
                startDate = new Date(now.getFullYear(), now.getMonth() - 3, 1);
                endDate = new Date(now.getFullYear(), now.getMonth() + 1, 0);
                break;
            case 'last-6-months':
                startDate = new Date(now.getFullYear(), now.getMonth() - 6, 1);
                endDate = new Date(now.getFullYear(), now.getMonth() + 1, 0);
                break;
            case 'this-year':
                startDate = new Date(now.getFullYear(), 0, 1);
                endDate = new Date(now.getFullYear(), 11, 31);
                break;
            default:
                startDate = new Date(now.getFullYear(), now.getMonth(), 1);
                endDate = new Date(now.getFullYear(), now.getMonth() + 1, 0);
        }

        return { startDate, endDate };
    }

    // Helper function to format date
    function formatDate(date) {
        var options = { day: '2-digit', month: 'short', year: 'numeric' };
        return date.toLocaleDateString('en-US', options);
    }

    // Helper function to convert date to YYYY-MM-DD format
    function formatDateForAPI(date) {
        var year = date.getFullYear();
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var day = String(date.getDate()).padStart(2, '0');
        return year + '-' + month + '-' + day;
    }

    // Update date display
    function updateDateDisplay(startDate, endDate) {
        var dateText = formatDate(startDate) + ' – ' + formatDate(endDate);
        document.getElementById('dateRangeText').textContent = dateText;
        currentDateRange.startDate = startDate;
        currentDateRange.endDate = endDate;
    }

    // ── Date Range Filter: Listen for dropdown changes ─────────────────────────
    var dateRangeFilter = document.getElementById('dateRangeFilter');
    var customDateRangeDiv = document.getElementById('customDateRange');
    if (dateRangeFilter) {
        dateRangeFilter.addEventListener('change', function () {
            if (this.value === 'custom') {
                // Show custom date range inputs
                customDateRangeDiv.style.display = 'flex';
                // Set default dates to today
                var today = new Date();
                document.getElementById('startDate').valueAsDate = new Date(today.getFullYear(), today.getMonth(), 1);
                document.getElementById('endDate').valueAsDate = today;
            } else {
                customDateRangeDiv.style.display = 'none';
                var range = getDateRangeByPeriod(this.value);
                updateDateDisplay(range.startDate, range.endDate);
                loadDashboardData();
            }
        });
    }

    // Apply custom date range
    var applyCustomDateBtn = document.getElementById('applyCustomDate');
    if (applyCustomDateBtn) {
        applyCustomDateBtn.addEventListener('click', function () {
            var startDateInput = document.getElementById('startDate').value;
            var endDateInput = document.getElementById('endDate').value;

            if (!startDateInput || !endDateInput) {
                alert('Please select both start and end dates');
                return;
            }

            // Parse dates directly from input (YYYY-MM-DD format)
            var startParts = startDateInput.split('-');
            var endParts = endDateInput.split('-');
            
            var startDate = new Date(parseInt(startParts[0]), parseInt(startParts[1]) - 1, parseInt(startParts[2]));
            var endDate = new Date(parseInt(endParts[0]), parseInt(endParts[1]) - 1, parseInt(endParts[2]));

            if (startDate > endDate) {
                alert('Start date must be before end date');
                return;
            }

            updateDateDisplay(startDate, endDate);
            loadDashboardData();
            dateRangeFilter.value = 'custom'; // Keep custom selected
        });
    }

    // Cancel custom date range
    var cancelCustomDateBtn = document.getElementById('cancelCustomDate');
    if (cancelCustomDateBtn) {
        cancelCustomDateBtn.addEventListener('click', function () {
            customDateRangeDiv.style.display = 'none';
            dateRangeFilter.value = 'this-month'; // Reset to default
        });
    }

    // Load dashboard data with current filters
    function loadDashboardData() {
        var period = document.getElementById('chartPeriodFilter').value;
        var startDate = currentDateRange.startDate ? formatDateForAPI(currentDateRange.startDate) : null;
        var endDate = currentDateRange.endDate ? formatDateForAPI(currentDateRange.endDate) : null;

        // Build query parameters for chart data
        var chartParams = new URLSearchParams();
        chartParams.append('period', period);
        if (startDate) chartParams.append('start_date', startDate);
        if (endDate) chartParams.append('end_date', endDate);

        // Build query parameters for stats
        var statsParams = new URLSearchParams();
        if (startDate) statsParams.append('start_date', startDate);
        if (endDate) statsParams.append('end_date', endDate);

        // Fetch chart data from the API
        fetch('/dashboard/chart-data?' + chartParams.toString())
            .then(response => response.json())
            .then(data => {
                // Update chart data
                if (lineChartInstance) {
                    lineChartInstance.data.labels = data.labels;
                    lineChartInstance.data.datasets[0].data = data.counts;
                    lineChartInstance.update();
                }
            })
            .catch(error => console.error('Error fetching chart data:', error));

        // Fetch stats data from the API
        fetch('/dashboard/stats?' + statsParams.toString())
            .then(response => response.json())
            .then(data => {
                // Update stats cards
                if (data.stats) {
                    document.querySelectorAll('[data-stat="total-records"]').forEach(el => {
                        el.textContent = new Intl.NumberFormat('en-US').format(data.stats.total_records);
                    });
                    document.querySelectorAll('[data-stat="avg-value"]').forEach(el => {
                        el.textContent = data.stats.avg_value;
                    });
                }

                // Update donut chart
                if (data.donutData && donutChartInstance) {
                    var donutLabels = data.donutData.map(d => d.name);
                    var donutCounts = data.donutData.map(d => d.count);

                    donutChartInstance.data.labels = donutLabels;
                    donutChartInstance.data.datasets[0].data = donutCounts;
                    donutChartInstance.update();

                    // Update donut legend
                    var legendHtml = '';
                    data.donutData.forEach((item, i) => {
                        legendHtml += `
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px">
                                <div style="display:flex;align-items:center;gap:6px;min-width:0">
                                    <span style="width:8px;height:8px;border-radius:50%;background:${donutColors[i % donutColors.length]};flex-shrink:0;display:inline-block"></span>
                                    <span style="font-size:.75rem;color:#475569;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${item.name}</span>
                                </div>
                                <div style="display:flex;align-items:center;gap:5px;flex-shrink:0">
                                    <span style="font-size:.75rem;font-weight:700;color:#0f172a">${item.count}</span>
                                    <span style="font-size:.7rem;color:#94a3b8">(${item.percentage}%)</span>
                                </div>
                            </div>
                        `;
                    });

                    var legendContainer = document.querySelector('[data-donut-legend]');
                    if (legendContainer) {
                        legendContainer.innerHTML = legendHtml;
                    }
                }
            })
            .catch(error => console.error('Error fetching stats data:', error));
    }

    // ── Line Chart: Records Over Time ─────────────────────────────────────────
    var lineEl = document.getElementById('lineChart');
    if (lineEl) {
        lineChartInstance = new Chart(lineEl, {
            type: 'line',
            data: {
                labels  : lineLabels,
                datasets: [{
                    label           : 'Records',
                    data            : lineCounts,
                    borderColor     : '#3b82f6',
                    backgroundColor : 'rgba(59,130,246,.07)',
                    borderWidth     : 2,
                    pointRadius     : 3,
                    pointHoverRadius: 5,
                    pointBackgroundColor: '#3b82f6',
                    tension         : 0.4,
                    fill            : true,
                }],
            },
            options: {
                responsive         : true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales : {
                    x: {
                        grid : { display: false },
                        ticks: {
                            font : { size: 10, family: 'Plus Jakarta Sans' },
                            color: '#94a3b8',
                            maxTicksLimit: 7,
                        },
                    },
                    y: {
                        grid     : { color: '#f1f5f9' },
                        ticks    : { font: { size: 10, family: 'Plus Jakarta Sans' }, color: '#94a3b8' },
                        beginAtZero: true,
                    },
                },
            },
        });
    }

    // ── Chart Period Filter: Listen for dropdown changes ─────────────────────────
    var periodFilter = document.getElementById('chartPeriodFilter');
    if (periodFilter) {
        periodFilter.addEventListener('change', function () {
            loadDashboardData();
        });
    }

    // ── Donut Chart: Records by Category ─────────────────────────────────────
    var donutEl = document.getElementById('donutChart');
    if (donutEl) {
        donutChartInstance = new Chart(donutEl, {
            type: 'doughnut',
            data: {
                labels  : donutLabels,
                datasets: [{
                    data           : donutCounts.length ? donutCounts : [1],
                    backgroundColor: donutCounts.length ? donutColors : ['#f1f5f9'],
                    borderWidth    : 0,
                    hoverOffset    : 4,
                }],
            },
            options: {
                responsive: false,
                cutout    : '68%',
                plugins   : {
                    legend : { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (ctx) {
                                return ' ' + ctx.label + ': ' + ctx.formattedValue;
                            },
                        },
                    },
                },
            },
        });
    }

    // Initialize with current month and load filtered data
    var range = getDateRangeByPeriod('this-month');
    currentDateRange.startDate = range.startDate;
    currentDateRange.endDate = range.endDate;
    updateDateDisplay(range.startDate, range.endDate);
    loadDashboardData();

});
</script>
@endpush
