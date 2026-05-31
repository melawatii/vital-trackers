@extends('layouts.app')
@section('title', 'Edit Vital Record')

@section('content')
<h1 class="text-2xl font-bold mb-4">Create New Vital Record</h1>

<form action="{{ route('vital-records.update', $vitalRecord->_id) }}" method="POST">
@method('PUT')
    @csrf
    <!-- User -->
    <label>User</label>
    <select name="user_id" required>
        @foreach($users as $user)
            <option value="{{ $user->_id }}">{{ $user->name }}</option>
        @endforeach
    </select>

    <!-- Category -->
    <label>Category</label>
    <select name="category_id" required>
        @foreach($categories as $category)
            <option value="{{ $category->_id }}">{{ $category->name }}</option>
        @endforeach
    </select>

    <!-- Vital Type -->
    <label>Type</label>
    <select name="vital_type_id" required>
        @foreach($types as $type)
            <option value="{{ $type->_id }}">{{ $type->name }}</option>
        @endforeach
    </select>

    <!-- Value -->
    <label>Value</label>
    <input type="number" name="value" required>

    <!-- Unit -->
    <label>Unit</label>
    <input type="text" name="unit" required>

    <!-- Status -->
    <label>Status</label>
    <select name="status" required>
        <option value="normal">Normal</option>
        <option value="high">High</option>
        <option value="low">Low</option>
    </select>

    <!-- Note -->
    <label>Note</label>
    <textarea name="note"></textarea>

    <!-- Measured At -->
    <label>Date & Time</label>
    <input type="datetime-local" name="measured_at" required>

    <button type="submit" class="btn btn-primary">Save Record</button>
</form>
@endsection
