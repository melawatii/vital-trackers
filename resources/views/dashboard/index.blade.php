@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<!-- Begin: Dashboard Page -->
<div class="space-y-8">

    <!-- Begin: Page Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>

            <h1 class="text-[40px] font-bold text-[#0F2A66]">
                Dashboard
            </h1>

            <p class="mt-2 text-[#6B7A99]">
                Monitor health records and vital sign analytics.
            </p>

        </div>

        <div>

            <button
                class="
                    h-12
                    px-5
                    rounded-2xl
                    border
                    border-[#E8EEF8]
                    bg-white
                    text-[#0F2A66]
                    font-medium
                    shadow-sm
                "
            >
                {{ now()->format('F d, Y') }}
            </button>

        </div>

    </div>
    <!-- End: Page Header -->


    <!-- Begin: Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <!-- Begin: Card -->
        <div
            class="
                bg-white
                rounded-[24px]
                border
                border-[#E8EEF8]
                p-7
                shadow-sm
            "
        >

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-[#7D8FB3] text-sm">
                        Total Records
                    </p>

                    <h2 class="mt-3 text-[42px] font-bold text-[#0F2A66]">
                        {{ $stats['total_records'] ?? 1248 }}
                    </h2>

                </div>

                <div
                    class="
                        w-14
                        h-14
                        rounded-2xl
                        bg-blue-50
                        flex
                        items-center
                        justify-center
                    "
                >
                    📊
                </div>

            </div>

        </div>
        <!-- End: Card -->


        <!-- Begin: Card -->
        <div
            class="
                bg-white
                rounded-[24px]
                border
                border-[#E8EEF8]
                p-7
                shadow-sm
            "
        >

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-[#7D8FB3] text-sm">
                        Normal Records
                    </p>

                    <h2 class="mt-3 text-[42px] font-bold text-[#22C55E]">
                        {{ $stats['normal_records'] ?? 980 }}
                    </h2>

                </div>

                <div
                    class="
                        w-14
                        h-14
                        rounded-2xl
                        bg-green-50
                        flex
                        items-center
                        justify-center
                    "
                >
                    ✅
                </div>

            </div>

        </div>
        <!-- End: Card -->


        <!-- Begin: Card -->
        <div
            class="
                bg-white
                rounded-[24px]
                border
                border-[#E8EEF8]
                p-7
                shadow-sm
            "
        >

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-[#7D8FB3] text-sm">
                        Danger Records
                    </p>

                    <h2 class="mt-3 text-[42px] font-bold text-[#EF4444]">
                        {{ $stats['danger_records'] ?? 168 }}
                    </h2>

                </div>

                <div
                    class="
                        w-14
                        h-14
                        rounded-2xl
                        bg-red-50
                        flex
                        items-center
                        justify-center
                    "
                >
                    ⚠️
                </div>

            </div>

        </div>
        <!-- End: Card -->


        <!-- Begin: Card -->
        <div
            class="
                bg-white
                rounded-[24px]
                border
                border-[#E8EEF8]
                p-7
                shadow-sm
            "
        >

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-[#7D8FB3] text-sm">
                        Vital Categories
                    </p>

                    <h2 class="mt-3 text-[42px] font-bold text-[#8B5CF6]">
                        {{ $stats['categories'] ?? 12 }}
                    </h2>

                </div>

                <div
                    class="
                        w-14
                        h-14
                        rounded-2xl
                        bg-violet-50
                        flex
                        items-center
                        justify-center
                    "
                >
                    🩺
                </div>

            </div>

        </div>
        <!-- End: Card -->

    </div>
    <!-- End: Statistics Cards -->


    <!-- Begin: Analytics Section -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <!-- Begin: Monthly Analytics -->
        <div
            class="
                xl:col-span-2
                bg-white
                rounded-[24px]
                border
                border-[#E8EEF8]
                p-8
                shadow-sm
            "
        >

            <div class="mb-8">

                <h2 class="text-xl font-bold text-[#0F2A66]">
                    Monthly Analytics
                </h2>

                <p class="text-[#7D8FB3] mt-1">
                    Monthly vital record overview.
                </p>

            </div>

            <div
                id="monthlyAnalyticsChart"
                class="h-[350px]"
            ></div>

        </div>
        <!-- End: Monthly Analytics -->


        <!-- Begin: Distribution -->
        <div
            class="
                bg-white
                rounded-[24px]
                border
                border-[#E8EEF8]
                p-8
                shadow-sm
            "
        >

            <div>

                <h2 class="text-xl font-bold text-[#0F2A66]">
                    Vital Distribution
                </h2>

                <p class="text-[#7D8FB3] mt-1">
                    Distribution by category.
                </p>

            </div>

            <div
                id="distributionChart"
                class="mt-8"
            ></div>

        </div>
        <!-- End: Distribution -->

    </div>
    <!-- End: Analytics Section -->


    <!-- Begin: Recent Activity -->
    <div
        class="
            bg-white
            rounded-[24px]
            border
            border-[#E8EEF8]
            shadow-sm
            overflow-hidden
        "
    >

        <div class="px-8 py-6 border-b border-[#E8EEF8]">

            <h2 class="text-xl font-bold text-[#0F2A66]">
                Recent Activities
            </h2>

        </div>

        <div class="divide-y divide-[#E8EEF8]">

            <div class="px-8 py-5 flex items-center justify-between">

                <div>

                    <p class="font-medium text-[#0F2A66]">
                        Blood Pressure record added
                    </p>

                    <p class="text-sm text-[#7D8FB3] mt-1">
                        Today at 08:15
                    </p>

                </div>

                <span
                    class="
                        px-4
                        py-1.5
                        rounded-full
                        bg-green-50
                        text-green-600
                        text-sm
                    "
                >
                    Normal
                </span>

            </div>

            <div class="px-8 py-5 flex items-center justify-between">

                <div>

                    <p class="font-medium text-[#0F2A66]">
                        Heart Rate updated
                    </p>

                    <p class="text-sm text-[#7D8FB3] mt-1">
                        Today at 10:30
                    </p>

                </div>

                <span
                    class="
                        px-4
                        py-1.5
                        rounded-full
                        bg-yellow-50
                        text-yellow-600
                        text-sm
                    "
                >
                    Warning
                </span>

            </div>

        </div>

    </div>
    <!-- End: Recent Activity -->

</div>
<!-- End: Dashboard Page -->

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>

    const analyticsChart = new ApexCharts(
        document.querySelector("#monthlyAnalyticsChart"),
        {
            chart: {
                type: 'area',
                height: 350,
                toolbar: {
                    show: false
                }
            },

            series: [{
                name: 'Records',
                data: [120, 160, 210, 180, 260, 310]
            }],

            colors: ['#3B82F6'],

            stroke: {
                curve: 'smooth',
                width: 4
            },

            fill: {
                type: 'gradient',
                gradient: {
                    opacityFrom: 0.35,
                    opacityTo: 0.05,
                }
            },

            grid: {
                borderColor: '#EEF2F7'
            },

            xaxis: {
                categories: [
                    'Jan',
                    'Feb',
                    'Mar',
                    'Apr',
                    'May',
                    'Jun'
                ]
            }
        }
    );

    analyticsChart.render();

    const distributionChart = new ApexCharts(
        document.querySelector("#distributionChart"),
        {
            chart: {
                type: 'donut',
                height: 320
            },

            series: [44, 25, 18, 13],

            labels: [
                'Blood Pressure',
                'Heart Rate',
                'Temperature',
                'Blood Sugar'
            ],

            colors: [
                '#3B82F6',
                '#22C55E',
                '#F59E0B',
                '#EF4444'
            ],

            legend: {
                position: 'bottom'
            },

            stroke: {
                width: 0
            },

            dataLabels: {
                enabled: false
            }
        }
    );

    distributionChart.render();

</script>

@endpush
