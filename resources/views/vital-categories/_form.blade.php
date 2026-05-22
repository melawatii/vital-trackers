{{-- ============================================================ --}}
{{-- Vital Category Form Partial                                --}}
{{-- Shared by create.blade.php and edit.blade.php.            --}}
{{-- $vitalCategory is null on create, model instance on edit. --}}
{{-- ============================================================ --}}

@php
    $isEdit  = isset($vitalCategory);
    $name    = old('name',        $vitalCategory->name        ?? '');
    $desc    = old('description', $vitalCategory->description ?? '');
    $icon    = old('icon',        $vitalCategory->icon        ?? 'droplet');
    $status  = old('status',      $vitalCategory->status      ?? 'active');

    // Available icons: identifier => [emoji, label, bg-color class]
    $icons = [
        'droplet'     => ['💧', 'Water / BP',    'bg-blue-50'],
        'heart'       => ['💚', 'Heart Rate',     'bg-green-50'],
        'thermometer' => ['🌡️', 'Temperature',   'bg-yellow-50'],
        'blooddrop'   => ['🩸', 'Blood Sugar',   'bg-red-50'],
        'lungs'       => ['🫁', 'Respiratory',   'bg-indigo-50'],
        'scale'       => ['⚖️', 'Weight',         'bg-gray-50'],
        'oxygen'      => ['🫧', 'Oxygen',         'bg-cyan-50'],
        'brain'       => ['🧠', 'Mental',         'bg-pink-50'],
    ];
@endphp

{{-- ── Section: Category Information ─────────────────────────── --}}
<!-- Begin: Section Category Information -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-5">

    {{-- Section header --}}
    <div class="flex items-center gap-2 mb-1">
        <span class="w-5 h-5 bg-blue-600 rounded-full flex items-center justify-center">
            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
        </span>
        <h2 class="text-base font-bold text-gray-800">Crategory Information</h2>
    </div>
    <p class="text-xs text-gray-400 mb-5 ml-7">Basic details about the vital category.</p>

    {{-- Name + Description row --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        {{-- Category Name --}}
        <!-- Begin: Field Category Name -->
        <div>
            <label for="name" class="form-label">
                Category Name <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ $name }}"
                placeholder="e.g., Blood Pressure"
                class="form-input @error('name') form-input--error @enderror"
            />
            <p class="form-hint">Enter a descriptive name for the category.</p>
            @error('name')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>
        <!-- End: Field Category Name -->

        {{-- Description --}}
        <!-- Begin: Field Description -->
        <div>
            <label for="description" class="form-label">
                Description <span class="text-red-500">*</span>
            </label>
            <textarea
                id="description"
                name="description"
                rows="4"
                placeholder="e.g., Blood pressure monitoring and tracking"
                class="form-input resize-none @error('description') form-input--error @enderror"
            >{{ $desc }}</textarea>
            <p class="form-hint">Provide a clear description of this category.</p>
            @error('description')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>
        <!-- End: Field Description -->

    </div>

</div>
<!-- End: Section Category Information -->

{{-- ── Section: Category Icon ──────────────────────────────────── --}}
<!-- Begin: Section Category Icon -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-5">

    <div class="flex items-center gap-2 mb-1">
        <span class="w-5 h-5 bg-blue-600 rounded-full flex items-center justify-center">
            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
            </svg>
        </span>
        <h2 class="text-base font-bold text-gray-800">Category Icon</h2>
    </div>
    <p class="text-xs text-gray-400 mb-5 ml-7">Choose an icon to represent this category.</p>

    {{-- Icon grid --}}
    <!-- Begin: Icon Selector Grid -->
    <div class="flex flex-wrap gap-3" id="iconGrid">
        @foreach ($icons as $key => [$emoji, $label, $bg])
            <label
                class="icon-option cursor-pointer"
                title="{{ $label }}"
            >
                <input type="radio" name="icon" value="{{ $key }}" class="sr-only"
                    {{ $icon === $key ? 'checked' : '' }} />
                <div class="icon-option__box {{ $bg }} {{ $icon === $key ? 'icon-option__box--selected' : '' }}">
                    <span class="text-2xl leading-none">{{ $emoji }}</span>
                    {{-- Checkmark overlay --}}
                    <span class="icon-option__check {{ $icon === $key ? 'opacity-100' : 'opacity-0' }}">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                </div>
            </label>
        @endforeach
    </div>
    <!-- End: Icon Selector Grid -->

    @error('icon')
        <p class="form-error mt-2">{{ $message }}</p>
    @enderror

</div>
<!-- End: Section Category Icon -->

{{-- ── Section: Status ─────────────────────────────────────────── --}}
<!-- Begin: Section Status -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">

    <div class="flex items-center gap-2 mb-1">
        <span class="w-5 h-5 bg-blue-600 rounded-full flex items-center justify-center">
            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        </span>
        <h2 class="text-base font-bold text-gray-800">Status</h2>
    </div>
    <p class="text-xs text-gray-400 mb-5 ml-7">Set the initial status for this category.</p>

    {{-- Status radio options --}}
    <!-- Begin: Status Radio Options -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        {{-- Active --}}
        <label class="status-option cursor-pointer">
            <input type="radio" name="status" value="active" class="sr-only"
                {{ $status === 'active' ? 'checked' : '' }} />
            <div class="status-option__box {{ $status === 'active' ? 'status-option__box--selected' : '' }}"
                id="status-active-box">
                <div class="flex items-center gap-3">
                    {{-- Custom radio dot --}}
                    <span class="w-5 h-5 rounded-full border-2 {{ $status === 'active' ? 'border-blue-600 bg-blue-600' : 'border-gray-300' }} flex items-center justify-center shrink-0 transition-all">
                        <span class="w-2 h-2 rounded-full bg-white {{ $status === 'active' ? 'opacity-100' : 'opacity-0' }} transition-opacity"></span>
                    </span>
                    <div>
                        <p class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                            Active
                            <span class="text-xs font-medium bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Recommended</span>
                        </p>
                        <p class="text-xs text-gray-400">Category will be available for use</p>
                    </div>
                </div>
            </div>
        </label>

        {{-- Inactive --}}
        <label class="status-option cursor-pointer">
            <input type="radio" name="status" value="inactive" class="sr-only"
                {{ $status === 'inactive' ? 'checked' : '' }} />
            <div class="status-option__box {{ $status === 'inactive' ? 'status-option__box--selected' : '' }}"
                id="status-inactive-box">
                <div class="flex items-center gap-3">
                    <span class="w-5 h-5 rounded-full border-2 {{ $status === 'inactive' ? 'border-blue-600 bg-blue-600' : 'border-gray-300' }} flex items-center justify-center shrink-0 transition-all">
                        <span class="w-2 h-2 rounded-full bg-white {{ $status === 'inactive' ? 'opacity-100' : 'opacity-0' }} transition-opacity"></span>
                    </span>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Inactive</p>
                        <p class="text-xs text-gray-400">Category will be disabled temporarily</p>
                    </div>
                </div>
            </div>
        </label>

    </div>
    <!-- End: Status Radio Options -->

    @error('status')
        <p class="form-error mt-2">{{ $message }}</p>
    @enderror

</div>
<!-- End: Section Status -->

{{-- ── Form Action Buttons ──────────────────────────────────────── --}}
<!-- Begin: Form Actions -->
<div class="flex items-center justify-end gap-3">
    <a href="{{ route('vital-categories.index') }}"
        class="px-5 py-2.5 text-sm font-semibold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
        Cancel
    </a>
    <button type="submit" id="submitBtn"
        class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-sm shadow-blue-200 transition-all duration-150 active:scale-95">
        {{-- Loading spinner (hidden by default) --}}
        <svg id="submitSpinner" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        <svg class="w-4 h-4" id="submitIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
        </svg>
        {{ $isEdit ? 'Update Category' : 'Save Category' }}
    </button>
</div>
<!-- End: Form Actions -->

{{-- ── Form Styles ─────────────────────────────────────────────── --}}
<style>
    /* Form field utilities */
    .form-label  { @apply block text-sm font-semibold text-gray-700 mb-1.5; }
    .form-hint   { @apply text-xs text-gray-400 mt-1; }
    .form-error  { @apply text-xs text-red-500 mt-1; }
    .form-input  { @apply w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-800 bg-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all; }
    .form-input--error { @apply border-red-400 focus:ring-red-400; }

    /* Icon selector */
    .icon-option__box {
        @apply relative w-16 h-16 rounded-2xl flex items-center justify-center border-2 border-transparent transition-all duration-150 hover:border-blue-300 hover:shadow-md;
    }
    .icon-option__box--selected { @apply border-blue-500 shadow-md shadow-blue-100; }
    .icon-option__check {
        @apply absolute -top-1.5 -right-1.5 w-5 h-5 bg-blue-600 rounded-full flex items-center justify-center transition-opacity;
    }

    /* Status option boxes */
    .status-option__box {
        @apply p-4 rounded-xl border-2 border-gray-100 hover:border-blue-200 transition-all duration-150;
    }
    .status-option__box--selected { @apply border-blue-500 bg-blue-50/30; }
</style>

{{-- ── Form interactivity scripts ──────────────────────────────── --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    // ── Icon selector: highlight selected icon on click ───────
    document.querySelectorAll('#iconGrid .icon-option input[type=radio]').forEach(radio => {
        radio.addEventListener('change', function () {
            // Reset all boxes
            document.querySelectorAll('.icon-option__box').forEach(box => {
                box.classList.remove('icon-option__box--selected');
                box.querySelector('.icon-option__check').classList.replace('opacity-100', 'opacity-0');
            });

            // Highlight selected
            if (this.checked) {
                const box   = this.closest('.icon-option').querySelector('.icon-option__box');
                const check = box.querySelector('.icon-option__check');
                box.classList.add('icon-option__box--selected');
                check.classList.replace('opacity-0', 'opacity-100');
            }
        });
    });

    // ── Status radio: update visual state on change ───────────
    document.querySelectorAll('.status-option input[type=radio]').forEach(radio => {
        radio.addEventListener('change', function () {
            // Reset all status boxes
            document.querySelectorAll('.status-option__box').forEach(box => {
                box.classList.remove('status-option__box--selected');
            });
            document.querySelectorAll('.status-option .w-5').forEach(dot => {
                dot.classList.remove('border-blue-600', 'bg-blue-600');
                dot.classList.add('border-gray-300');
                dot.querySelector('span').classList.replace('opacity-100', 'opacity-0');
            });

            // Apply selected state
            if (this.checked) {
                const box = this.closest('.status-option').querySelector('.status-option__box');
                const dot = this.closest('.status-option').querySelector('.w-5');
                box.classList.add('status-option__box--selected');
                dot.classList.remove('border-gray-300');
                dot.classList.add('border-blue-600', 'bg-blue-600');
                dot.querySelector('span').classList.replace('opacity-0', 'opacity-100');
            }
        });
    });

    // ── Show loading spinner on form submit ───────────────────
    const form = document.querySelector('form[data-loading]');
    if (form) {
        form.addEventListener('submit', () => {
            const btn     = document.getElementById('submitBtn');
            const spinner = document.getElementById('submitSpinner');
            const icon    = document.getElementById('submitIcon');
            if (btn && spinner && icon) {
                btn.disabled = true;
                btn.classList.add('opacity-75', 'cursor-not-allowed');
                spinner.classList.remove('hidden');
                icon.classList.add('hidden');
            }
        });
    }

});
</script>
