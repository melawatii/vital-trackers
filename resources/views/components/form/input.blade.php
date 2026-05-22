<!-- Begin: Form Group -->
<div class="space-y-2">

    <!-- Begin: Label -->
    <label class="text-sm font-medium text-slate-600">
        {{ $label }}
    </label>
    <!-- End: Label -->

    <!-- Begin: Input -->
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ $value ?? '' }}"
        class="form-input"
    >
    <!-- End: Input -->

</div>
<!-- End: Form Group -->