<!-- Begin: Form Fields -->
<div class="space-y-4">

    <select name="category_id" required class="w-full rounded-2xl border border-slate-200 px-4 py-3">
        @foreach(App\Models\VitalCategory::active()->get() as $category)
            <option value="{{ $category->id }}"
                {{ isset($type) && $type->category_id==$category->id?'selected':'' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>

    <input type="text" name="name" placeholder="Type Name"
        class="w-full rounded-2xl border border-slate-200 px-4 py-3"
        value="{{ old('name', $type->name ?? '') }}" required>

    <input type="text" name="unit" placeholder="Unit"
        class="w-full rounded-2xl border border-slate-200 px-4 py-3"
        value="{{ old('unit', $type->unit ?? '') }}" required>

    <input type="text" name="input_type" placeholder="Input Type"
        class="w-full rounded-2xl border border-slate-200 px-4 py-3"
        value="{{ old('input_type', $type->input_type ?? '') }}" required>

    <div class="grid grid-cols-3 gap-4">
        <input type="number" step="0.01" name="normal_min" placeholder="Normal Min"
            class="rounded-2xl border border-slate-200 px-4 py-3"
            value="{{ old('normal_min', $type->normal_min ?? '') }}">
        <input type="number" step="0.01" name="normal_max" placeholder="Normal Max"
            class="rounded-2xl border border-slate-200 px-4 py-3"
            value="{{ old('normal_max', $type->normal_max ?? '') }}">
        <input type="number" step="0.01" name="danger_max" placeholder="Danger Max"
            class="rounded-2xl border border-slate-200 px-4 py-3"
            value="{{ old('danger_max', $type->danger_max ?? '') }}">
    </div>

    <select name="is_active" class="w-full rounded-2xl border border-slate-200 px-4 py-3">
        <option value="1" {{ (isset($type) && $type->is_active)?'selected':'' }}>Active</option>
        <option value="0" {{ (isset($type) && !$type->is_active)?'selected':'' }}>Inactive</option>
    </select>

    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl w-full">
        {{ isset($type)?'Update Type':'Create Type' }}
    </button>

</div>
<!-- End: Form Fields -->
