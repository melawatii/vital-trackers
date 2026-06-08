@extends('layouts.app')

@section('title', 'Vital Record Detail')

@php
    $breadcrumbs = [
        ['label' => 'Transactions'],
        ['label' => 'Vital Records', 'url' => route('vital-records.index')],
        ['label' => 'Detail'],
    ];
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
    $icon = $category ? ($iconMap[$category->icon] ?? '📋') : '📋';
@endphp

@section('content')

    <!-- Begin: Page Header -->
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Record Detail</h1>
            <p class="text-sm text-slate-500 mt-1">Viewing vital sign measurement record.</p>
        </div>
        <div style="display:flex;gap:10px">
            <a href="{{ route('vital-records.edit', $record->id) }}"
               style="display:inline-flex;align-items:center;gap:8px;padding:10px 16px;background:#eff6ff;border:1.5px solid #bfdbfe;border-radius:12px;font-size:.875rem;font-weight:600;color:#2563eb;text-decoration:none;transition:background .15s">
                <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Record
            </a>
            <a href="{{ route('vital-records.index') }}"
               style="display:inline-flex;align-items:center;gap:8px;padding:10px 16px;background:#fff;border:1.5px solid #e2e8f0;border-radius:12px;font-size:.875rem;font-weight:600;color:#475569;text-decoration:none">
                <svg style="width:15px;height:15px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
        </div>
    </div>
    <!-- End: Page Header -->

    <!-- Begin: Detail Card -->
    <div style="background:#fff;border-radius:16px;border:1.5px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,.04);padding:32px;max-width:700px">

        <!-- Begin: Record Identity Row -->
        <div style="display:flex;align-items:center;gap:16px;padding-bottom:24px;border-bottom:1px solid #f1f5f9;margin-bottom:24px">
            <div style="width:56px;height:56px;background:#eff6ff;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:1.75rem;flex-shrink:0">
                {{ $icon }}
            </div>
            <div style="flex:1">
                <p style="font-size:1.125rem;font-weight:700;color:#0f172a">{{ $type?->name ?? '–' }}</p>
                <p style="font-size:.875rem;color:#64748b;margin-top:2px">{{ $category?->name ?? '–' }}</p>
            </div>
            @if($record->status === 'normal')
                <span style="padding:5px 14px;border-radius:20px;font-size:.8125rem;font-weight:700;background:#dcfce7;color:#15803d">● Normal</span>
            @else
                <span style="padding:5px 14px;border-radius:20px;font-size:.8125rem;font-weight:700;background:#fff1f2;color:#be123c">● High / Low</span>
            @endif
        </div>
        <!-- End: Record Identity Row -->

        <!-- Begin: Detail Fields -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">

            <div>
                <p style="font-size:.75rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">Date & Time</p>
                <p style="font-size:.9375rem;font-weight:600;color:#1e293b">{{ $record->recorded_at?->format('M d, Y  h:i A') ?? '–' }}</p>
            </div>

            <div>
                <p style="font-size:.75rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">Recorded By</p>
                <p style="font-size:.9375rem;font-weight:600;color:#1e293b">{{ $user?->name ?? '–' }}</p>
            </div>

            <div>
                <p style="font-size:.75rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">Value</p>
                <p style="font-size:1.5rem;font-weight:800;color:#2563eb">{{ $record->value }} <span style="font-size:.875rem;font-weight:500;color:#94a3b8">{{ $record->unit }}</span></p>
            </div>

            <div>
                <p style="font-size:.75rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">Normal Range</p>
                <p style="font-size:.9375rem;font-weight:600;color:#1e293b">
                    {{ ($type && $type->normal_range_min !== null) ? $type->normal_range_min . ' – ' . $type->normal_range_max . ' ' . $record->unit : '–' }}
                </p>
            </div>

            <div style="grid-column:span 2">
                <p style="font-size:.75rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin-bottom:4px">Note</p>
                <p style="font-size:.9375rem;color:#475569;line-height:1.6">{{ $record->note ?: '–' }}</p>
            </div>

        </div>
        <!-- End: Detail Fields -->

    </div>
    <!-- End: Detail Card -->

@endsection
