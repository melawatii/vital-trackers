<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VitalCategory;
use App\Models\VitalRecord;
use App\Models\VitalType;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Controller responsible for displaying the main dashboard with aggregated statistics.
 */
class DashboardController extends Controller
{
    /**
     * Display the main dashboard with aggregated stats and chart data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Initialize date boundaries for current and previous month comparisons
        $now          = Carbon::now();
        $thisMonth    = $now->startOfMonth()->copy();
        $lastMonth    = $now->copy()->subMonth()->startOfMonth();
        $lastMonthEnd = $now->copy()->subMonth()->endOfMonth();

        // Build record query by role: admin sees everything, users see only their own records
        $recordQuery = VitalRecord::query();
        if (!auth()->user()->isAdmin()) {
            $recordQuery->where('user_id', auth()->id());
        }

        // Summary Stats
        $totalRecords     = (clone $recordQuery)->count();
        $recordsThisMonth = (clone $recordQuery)->where('recorded_at', '>=', $thisMonth)->count();
        $recordsLastMonth = (clone $recordQuery)->whereBetween('recorded_at', [$lastMonth, $lastMonthEnd])->count();
        $totalUsers       = auth()->user()->isAdmin() ? User::count() : 1;
        $totalCategories  = auth()->user()->isAdmin()
            ? VitalCategory::count()
            : count((clone $recordQuery)->distinct('category_id')->pluck('category_id')->toArray());

        // Calculate average value of filtered records
        $avgValue = (clone $recordQuery)->avg('value') ?? 0;

        // Calculate growth percentage compared to last month, avoiding division by zero
        $recordsGrowth = $recordsLastMonth > 0
            ? round((($recordsThisMonth - $recordsLastMonth) / $recordsLastMonth) * 100, 1)
            : 0;

        $stats = [
            'total_records'      => $totalRecords,
            'records_this_month' => $recordsThisMonth,
            'total_users'        => $totalUsers,
            'categories'         => $totalCategories,
            'avg_value'          => round($avgValue, 1),
            'records_growth'     => $recordsGrowth,
        ];

        // Generate daily counts for the last 30 days for the area/line chart
        $chartData = collect(range(29, 0))->map(function ($daysAgo) use ($recordQuery) {
            $date  = Carbon::now()->subDays($daysAgo)->startOfDay();
            $count = (clone $recordQuery)
                ->where('recorded_at', '>=', $date)
                ->where('recorded_at', '<', $date->copy()->addDay())
                ->count();
            return [
                'date'  => $date->format('d M'),
                'count' => $count,
            ];
        });

        // Eager-load categories into a keyed map to avoid N+1 queries during grouping
        $categoriesMap     = VitalCategory::all()->keyBy('id');
        $recordsByCategory = (clone $recordQuery)->get()
            ->groupBy('category_id')
            ->map(fn($group) => $group->count())
            ->sortDesc()
            ->take(6);

        // Map the grouped records to include category names and percentages for the donut chart
        $donutData = $recordsByCategory->map(function ($count, $catId) use ($categoriesMap, $totalRecords) {
            $cat = $categoriesMap->get((string) $catId);
            return [
                'name'       => $cat?->name ?? 'Unknown',
                'count'      => $count,
                'percentage' => $totalRecords > 0 ? round(($count / $totalRecords) * 100, 1) : 0,
            ];
        })->values();

        // Map category icons to their respective emoji representations for the UI
        $iconMap = [
            'droplet'     => '💧',
            'heart'       => '💚',
            'thermometer' => '🌡️',
            'blooddrop'   => '🩸',
            'lungs'       => '🫁',
            'scale'       => '⚖️',
            'oxygen'      => '🫧',
            'brain'       => '🧠',
        ];

        // Eager-load types and users into keyed maps to prevent N+1 queries
        $typesMap = VitalType::all()->keyBy('id');
        $usersMap = User::all()->keyBy('id');

        // Fetch the 5 most recent records and format them for the dashboard table
        $recentRecords = (clone $recordQuery)
            ->orderBy('recorded_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($r) use ($categoriesMap, $typesMap, $usersMap, $iconMap) {
                $cat  = $categoriesMap->get((string) $r->category_id);
                $type = $typesMap->get((string) $r->type_id);
                $user = $usersMap->get((string) $r->user_id);
                return [
                    'icon'        => $cat ? ($iconMap[$cat->icon] ?? '📋') : '📋',
                    'type_name'   => $type?->name ?? '–',
                    'value'       => $r->value . ' ' . $r->unit,
                    'user_name'   => $user?->name ?? '–',
                    'recorded_at' => $r->recorded_at?->format('d M Y, h:i A') ?? '–',
                    'status'      => $r->status ?? 'normal',
                ];
            });

        // Aggregate record counts per user and take the top 5
        $userRecordCounts = (clone $recordQuery)
            ->get()
            ->groupBy('user_id')
            ->map(fn($g) => $g->count())
            ->sortDesc()
            ->take(5);

        $maxCount = $userRecordCounts->max() ?: 1;

        // Calculate the proportional width percentage for the top users chart bars
        $topUsers = $userRecordCounts->map(function ($count, $userId) use ($usersMap, $maxCount) {
            $user = $usersMap->get((string) $userId);
            return [
                'name'       => $user?->name ?? 'Unknown',
                'count'      => $count,
                'percentage' => round(($count / $maxCount) * 100),
            ];
        })->values();

        return view('dashboard.index', compact(
            'stats',
            'chartData',
            'donutData',
            'recentRecords',
            'topUsers'
        ));
    }

    /**
     * Get dashboard stats and chart data filtered by date range.
     * Used by AJAX requests from date range filters.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDashboardStats(Request $request)
    {
        // Get optional date range parameters
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Build record query by role
        $recordQuery = VitalRecord::query();
        if (!auth()->user()->isAdmin()) {
            $recordQuery->where('user_id', auth()->id());
        }

        // Apply date filters if provided
        if ($startDate) {
            $recordQuery->where('recorded_at', '>=', Carbon::parse($startDate)->startOfDay());
        }
        if ($endDate) {
            $recordQuery->where('recorded_at', '<=', Carbon::parse($endDate)->endOfDay());
        }

        // Summary Stats
        $totalRecords = (clone $recordQuery)->count();
        $avgValue = (clone $recordQuery)->avg('value') ?? 0;

        $stats = [
            'total_records' => $totalRecords,
            'avg_value'     => round($avgValue, 1),
        ];

        // Eager-load categories into a keyed map to avoid N+1 queries during grouping
        $categoriesMap     = VitalCategory::all()->keyBy('id');
        $recordsByCategory = (clone $recordQuery)->get()
            ->groupBy('category_id')
            ->map(fn($group) => $group->count())
            ->sortDesc()
            ->take(6);

        // Map the grouped records to include category names and percentages for the donut chart
        $donutData = $recordsByCategory->map(function ($count, $catId) use ($categoriesMap, $totalRecords) {
            $cat = $categoriesMap->get((string) $catId);
            return [
                'name'       => $cat?->name ?? 'Unknown',
                'count'      => $count,
                'percentage' => $totalRecords > 0 ? round(($count / $totalRecords) * 100, 1) : 0,
            ];
        })->values();

        return response()->json([
            'stats'     => $stats,
            'donutData' => $donutData,
        ]);
    }

    /**
     * Get chart data filtered by date range and period (daily, weekly, monthly).
     * Used by AJAX requests from chart filters.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChartData(Request $request)
    {
        // Validate period parameter
        $period = $request->query('period', 'daily');
        if (!in_array($period, ['daily', 'weekly', 'monthly'])) {
            $period = 'daily';
        }

        // Get optional date range parameters
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Build record query by role
        $recordQuery = VitalRecord::query();
        if (!auth()->user()->isAdmin()) {
            $recordQuery->where('user_id', auth()->id());
        }

        // Apply date filters if provided
        if ($startDate) {
            $recordQuery->where('recorded_at', '>=', Carbon::parse($startDate)->startOfDay());
        }
        if ($endDate) {
            $recordQuery->where('recorded_at', '<=', Carbon::parse($endDate)->endOfDay());
        }

        // Generate chart data based on period
        $chartData = match ($period) {
            'daily' => $this->getDailyChartData($recordQuery, $startDate, $endDate),
            'weekly' => $this->getWeeklyChartData($recordQuery, $startDate, $endDate),
            'monthly' => $this->getMonthlyChartData($recordQuery, $startDate, $endDate),
            default => $this->getDailyChartData($recordQuery, $startDate, $endDate),
        };

        return response()->json([
            'labels' => $chartData->pluck('date')->values(),
            'counts' => $chartData->pluck('count')->values(),
        ]);
    }

    /**
     * Generate daily chart data for the last 30 days or within date range.
     *
     * @param mixed $recordQuery
     * @param string|null $startDate
     * @param string|null $endDate
     * @return \Illuminate\Support\Collection
     */
    private function getDailyChartData($recordQuery, $startDate = null, $endDate = null)
    {
        // Determine the date range
        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();
        } else {
            $start = Carbon::now()->subDays(29)->startOfDay();
            $end = Carbon::now()->endOfDay();
        }

        // Generate data points for each day in the range
        $result = [];
        $current = $start->copy();
        
        while ($current <= $end) {
            $dayEnd = $current->copy()->endOfDay();
            $count = (clone $recordQuery)
                ->where('recorded_at', '>=', $current)
                ->where('recorded_at', '<=', $dayEnd)
                ->count();
            
            $result[] = [
                'date'  => $current->format('d M'),
                'count' => $count,
            ];
            
            $current->addDay();
        }
        
        return collect($result);
    }

    /**
     * Generate weekly chart data for the last 12 weeks or within date range.
     *
     * @param mixed $recordQuery
     * @param string|null $startDate
     * @param string|null $endDate
     * @return \Illuminate\Support\Collection
     */
    private function getWeeklyChartData($recordQuery, $startDate = null, $endDate = null)
    {
        // Determine the date range
        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfWeek();
            $end = Carbon::parse($endDate)->endOfWeek();
        } else {
            $start = Carbon::now()->subWeeks(11)->startOfWeek();
            $end = Carbon::now()->endOfWeek();
        }

        // Generate data points for each week in the range
        $result = [];
        $current = $start->copy();
        
        while ($current <= $end) {
            $weekEnd = $current->copy()->endOfWeek();
            $count = (clone $recordQuery)
                ->where('recorded_at', '>=', $current)
                ->where('recorded_at', '<=', $weekEnd)
                ->count();
            
            $result[] = [
                'date'  => 'W' . $current->weekOfYear,
                'count' => $count,
            ];
            
            $current->addWeek();
        }
        
        return collect($result);
    }

    /**
     * Generate monthly chart data for the last 12 months or within date range.
     *
     * @param mixed $recordQuery
     * @param string|null $startDate
     * @param string|null $endDate
     * @return \Illuminate\Support\Collection
     */
    private function getMonthlyChartData($recordQuery, $startDate = null, $endDate = null)
    {
        // Determine the date range
        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfMonth();
            $end = Carbon::parse($endDate)->endOfMonth();
        } else {
            $start = Carbon::now()->subMonths(11)->startOfMonth();
            $end = Carbon::now()->endOfMonth();
        }

        // Generate data points for each month in the range
        $result = [];
        $current = $start->copy();
        
        while ($current <= $end) {
            $monthEnd = $current->copy()->endOfMonth();
            $count = (clone $recordQuery)
                ->where('recorded_at', '>=', $current)
                ->where('recorded_at', '<=', $monthEnd)
                ->count();
            
            $result[] = [
                'date'  => $current->format('M Y'),
                'count' => $count,
            ];
            
            $current->addMonth();
        }
        
        return collect($result);
    }
}
