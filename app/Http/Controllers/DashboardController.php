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

        // Summary Stats
        $totalRecords     = VitalRecord::count();
        $recordsThisMonth = VitalRecord::where('recorded_at', '>=', $thisMonth)->count();
        $recordsLastMonth = VitalRecord::whereBetween('recorded_at', [$lastMonth, $lastMonthEnd])->count();
        $totalUsers       = User::count();
        $totalCategories  = VitalCategory::count();

        // Calculate average value of all numeric records
        $avgValue = VitalRecord::avg('value') ?? 0;

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
        $chartData = collect(range(29, 0))->map(function ($daysAgo) {
            $date  = Carbon::now()->subDays($daysAgo)->startOfDay();
            $count = VitalRecord::where('recorded_at', '>=', $date)
                ->where('recorded_at', '<', $date->copy()->addDay())
                ->count();
            return [
                'date'  => $date->format('d M'),
                'count' => $count,
            ];
        });

        // Eager-load categories into a keyed map to avoid N+1 queries during grouping
        $categoriesMap     = VitalCategory::all()->keyBy('id');
        $recordsByCategory = VitalRecord::all()
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
        $recentRecords = VitalRecord::orderBy('recorded_at', 'desc')
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
        $userRecordCounts = VitalRecord::all()
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
}
