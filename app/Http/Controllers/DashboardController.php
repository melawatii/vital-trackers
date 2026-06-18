<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VitalCategory;
use App\Models\VitalRecord;
use App\Models\VitalType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard with aggregated stats and chart data.
     */
    public function index()
    {
        $now       = Carbon::now();
        $thisMonth = $now->startOfMonth()->copy();
        $lastMonth = $now->copy()->subMonth()->startOfMonth();
        $lastMonthEnd = $now->copy()->subMonth()->endOfMonth();

        // ── Summary Stats ─────────────────────────────────────────────────────

        $totalRecords      = VitalRecord::count();
        $recordsThisMonth  = VitalRecord::where('recorded_at', '>=', $thisMonth)->count();
        $recordsLastMonth  = VitalRecord::whereBetween('recorded_at', [$lastMonth, $lastMonthEnd])->count();
        $totalUsers        = User::count();
        $totalCategories   = VitalCategory::count();

        // Average value of all records (numeric value field)
        $avgValue = VitalRecord::avg('value') ?? 0;

        // Growth percentages vs last month
        $recordsGrowth  = $recordsLastMonth > 0
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

        // ── Records Over Time (last 30 days, daily count) ─────────────────────

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

        // ── Records by Category (for donut chart) ────────────────────────────

        $categoriesMap    = VitalCategory::all()->keyBy('id');
        $recordsByCategory = VitalRecord::all()
            ->groupBy('category_id')
            ->map(fn($group) => $group->count())
            ->sortDesc()
            ->take(6);

        $donutData = $recordsByCategory->map(function ($count, $catId) use ($categoriesMap, $totalRecords) {
            $cat = $categoriesMap->get((string) $catId);
            return [
                'name'       => $cat?->name ?? 'Unknown',
                'count'      => $count,
                'percentage' => $totalRecords > 0 ? round(($count / $totalRecords) * 100, 1) : 0,
            ];
        })->values();

        // ── Recent Vital Records (latest 5) ───────────────────────────────────

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

        $typesMap = VitalType::all()->keyBy('id');
        $usersMap = User::all()->keyBy('id');

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

        // ── Top Users by Record Count ─────────────────────────────────────────

        $userRecordCounts = VitalRecord::all()
            ->groupBy('user_id')
            ->map(fn($g) => $g->count())
            ->sortDesc()
            ->take(5);

        $maxCount  = $userRecordCounts->max() ?: 1;
        $topUsers  = $userRecordCounts->map(function ($count, $userId) use ($usersMap, $maxCount) {
            $user = $usersMap->get((string) $userId);
            return [
                'name'       => $user?->name ?? 'Unknown',
                'count'      => $count,
                'percentage' => round(($count / $maxCount) * 100),
            ];
        })->values();

        // ── System Overview ───────────────────────────────────────────────────

        $system = [
            'db_status'       => 'Healthy',
            'active_sessions' => 8,   // placeholder — replace with real session count
            'storage_used'    => '42.6 GB',
            'storage_total'   => '100 GB',
            'storage_pct'     => 42,
            'uptime'          => '15d 6h 24m',
        ];

        // ── Import Summary (placeholder — replace with real Import model) ─────

        $imports = [
            'total'     => 18,
            'completed' => 15,
            'partial'   => 2,
            'failed'    => 1,
        ];

        return view('dashboard.index', compact(
            'stats',
            'chartData',
            'donutData',
            'recentRecords',
            'topUsers',
            'system',
            'imports'
        ));
    }
}
