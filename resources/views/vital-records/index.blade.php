@extends('layouts.app')
@section('title', 'Vital Records')

@section('content')
<!-- Begin: Page Header -->
<h2 class="text-2xl font-bold text-gray-900 mb-4">Vital Records</h2>
<!-- End: Page Header -->

<!-- Begin: Flash Messages -->
@include('components.flash-messages')
<!-- End: Flash Messages -->

<!-- Begin: Add Button -->
<a href="{{ route('vital-records.create') }}" class="btn btn-primary mb-4">+ Add New Record</a>
<!-- End: Add Button -->

<!-- Begin: Table -->
<table class="min-w-full table-auto bg-white" id="recordsTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Date & Time</th>
            <th>User</th>
            <th>Category</th>
            <th>Type</th>
            <th>Value</th>
            <th>Unit</th>
            <th>Status</th>
            <th>Note</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($records as $index => $record)
        <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $record->measured_at->format('M d, Y H:i') }}</td>
            <td>{{ $record->user?->name }}</td>
            <td>{{ $record->category?->name }}</td>
            <td>{{ $record->type?->name }}</td>
            <td>{{ $record->value }}</td>
            <td>{{ $record->unit }}</td>
            <td>
                <span class="{{ $record->status === 'normal' ? 'text-green-600' : 'text-red-600' }}">
                    {{ ucfirst($record->status) }}
                </span>
            </td>
            <td>{{ $record->note }}</td>
            <td>
                <a href="{{ route('vital-records.edit', $record->_id) }}" class="text-blue-500">Edit</a>
                <form action="{{ route('vital-records.destroy', $record->_id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<!-- End: Table -->
@endsection
