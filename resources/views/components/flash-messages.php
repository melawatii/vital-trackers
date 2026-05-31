{{-- Success Message --}}
@if(session('success'))
    <div
        class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-green-700 shadow-sm"
    >
        {{ session('success') }}
    </div>
@endif

{{-- Error Message --}}
@if(session('error'))
    <div
        class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-700 shadow-sm"
    >
        {{ session('error') }}
    </div>
@endif

{{-- Validation Errors --}}
@if($errors->any())
    <div
        class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 shadow-sm"
    >
        <ul class="list-disc pl-5 text-red-700 space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
