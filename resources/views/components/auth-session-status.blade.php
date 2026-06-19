{{-- Define the expected component properties --}}
@props(['status'])

{{-- Conditionally render the status message block if a status string is provided --}}
@if ($status)
    <!-- Begin: Status Message -->
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }}>
        {{ $status }}
    </div>
    <!-- End: Status Message -->
@endif
