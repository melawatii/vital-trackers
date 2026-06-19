@extends('layouts.guest')

@section('content')

<!-- Begin: Card -->
<div class="bg-white rounded-3xl shadow-xl p-8">

    <!-- Begin: Header -->
    <div class="mb-6">

        <!-- Begin: Title -->
        <h1 class="text-3xl font-bold text-slate-800">
            Confirm Password
        </h1>
        <!-- End: Title -->

        <!-- Begin: Description -->
        <p class="text-slate-400 mt-2 leading-relaxed">
            Please confirm your password before continuing.
        </p>
        <!-- End: Description -->

    </div>
    <!-- End: Header -->

    <!-- Begin: Form -->
    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">

        <!-- Begin: CSRF Token -->
        @csrf
        <!-- End: CSRF Token -->

        <!-- Begin: Password Field Group -->
        <div>

            <!-- Begin: Label -->
            <label class="block text-sm font-medium text-slate-600 mb-2">
                Password
            </label>
            <!-- End: Label -->

            <!-- Begin: Input -->
            <input
                type="password"
                name="password"
                required
                autocomplete="current-password"
                class="w-full rounded-2xl border border-slate-200 px-4 py-3 focus:border-blue-500 focus:ring focus:ring-blue-100 outline-none"
                placeholder="Input your password"
            >
            <!-- End: Input -->

            @error('password')
                <!-- Begin: Error Message -->
                <p class="text-sm text-red-500 mt-2">
                    {{ $message }}
                </p>
                <!-- End: Error Message -->
            @enderror

        </div>
        <!-- End: Password Field Group -->

        <!-- Begin: Submit Button -->
        <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-2xl font-semibold transition"
        >
            Confirm Password
        </button>
        <!-- End: Submit Button -->

    </form>
    <!-- End: Form -->

</div>
<!-- End: Card -->

@endsection
