@extends('layouts.app')

@section('title','Vital Types')

@section('content')

<!-- Begin: Page Header -->
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-slate-900">Vital Types</h1>
    <a href="{{ route('vital-types.create') }}" class="px-5 py-2 bg-blue-600 text-white rounded-xl">Add Type</a>
</div>
<!-- End: Page Header -->

<!-- Begin: Table Card -->
<div class="bg-white rounded-2xl border shadow-sm overflow-hidden">

    <table class="w-full">
        <thead class="bg-slate-50">
            <tr>
                <th class="p-4 text-left">#</th>
                <th class="p-4 text-left">Name</th>
                <th class="p-4 text-left">Category</th>
                <th class="p-4 text-left">Unit</th>
                <th class="p-4 text-left">Input Type</th>
                <th class="p-4 text-left">Normal Range</th>
                <th class="p-4 text-left">Danger Max</th>
                <th class="p-4 text-left">Status</th>
                <th class="p-4 text-center">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($types as $type)
                <tr class="border-t">
                    <td class="p-4">{{ $loop->iteration }}</td>
                    <td class="p-4 font-semibold">{{ $type->name }}</td>
                    <td class="p-4">{{ $type->category?->name }}</td>
                    <td class="p-4">{{ $type->unit }}</td>
                    <td class="p-4">{{ $type->input_type }}</td>
                    <td class="p-4">{{ $type->normal_min }} - {{ $type->normal_max }}</td>
                    <td class="p-4">{{ $type->danger_max }}</td>
                    <td class="p-4">
                        @if($type->is_active)
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">Active</span>
                        @else
                            <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full">Inactive</span>
                        @endif
                    </td>
                    <td class="p-4">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('vital-types.edit',$type->id) }}" class="px-3 py-2 bg-blue-100 rounded-lg">Edit</a>

                            <form action="{{ route('vital-types.destroy',$type->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-2 bg-red-100 rounded-lg" type="submit">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center py-10">No data available</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
<!-- End: Table Card -->

@endsection
