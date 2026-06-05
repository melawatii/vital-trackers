{{-- ============================================================ --}}
{{-- Vital Type Form Partial                                    --}}
{{-- Shared by create.blade.php and edit.blade.php.            --}}
{{-- $vitalType is null on create, model instance on edit.     --}}
{{-- $categories is a collection of active VitalCategory.      --}}
{{-- ============================================================ --}}

@php
    $isEdit  = isset($vitalType);
    $name    = old('name',             $vitalType->name             ?? '');
    $slug    = old('slug',             $vitalType->slug             ?? '');
    $catId   = old('category_id',      $vitalType->category_id      ?? '');
    $itype   = old('input_type',       $vitalType->input_type       ?? 'number');
    $unit    = old('unit',             $vitalType->unit             ?? '');
    $minVal  = old('min_value',        $vitalType->min_value        ?? '');
    $maxVal  = old('max_value',        $vitalType->max_value        ?? '');
    $nrMin   = old('normal_range_min', $vitalType->normal_range_min ?? '');
    $nrMax   = old('normal_range_max', $vitalType->normal_range_max ?? '');
    $sort    = old('sort_order',       $vitalType->sort_order       ?? 1);
    $note    = old('note',             $vitalType->note             ?? '');
    $status  = old('status',           $vitalType->status           ?? 'active');

    // Icon map for preview card
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
@endphp

<!-- Begin: Page Header -->
<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">
            {{ $isEdit ? 'Edit Vital Type' : 'Create Vital Type' }}
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            {{ $isEdit ? 'Update this vital sign type configuration.' : 'Add a new vital sign type and configure its measurement settings.' }}
        </p>
    </div>
    <a href="{{ route('vital-types.index') }}"
       style="display:inline-flex;align-items:center;gap:8px;padding:10px 16px;background:#fff;border:1.5px solid #e2e8f0;border-radius:12px;font-size:.875rem;font-weight:600;color:#475569;text-decoration:none;transition:background .15s"
       onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
        <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Vital Types
    </a>
</div>
<!-- End: Page Header -->

<!-- Begin: Two Column Layout (form left, preview right) -->
<div style="display:grid;grid-template-columns:1fr 280px;gap:20px;align-items:start">

    <!-- Begin: Left Column -->
    <div>

        <!-- Begin: Section Basic Information -->
        <div style="background:#fff;border-radius:16px;border:1.5px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,.04);padding:24px;margin-bottom:16px">

            <!-- Begin: Section Title -->
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px">
                <span style="width:20px;height:20px;background:#2563eb;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg style="width:11px;height:11px" fill="white" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </span>
                <h2 style="font-size:.9375rem;font-weight:700;color:#1e293b">Basic Information</h2>
            </div>
            <p style="font-size:.75rem;color:#94a3b8;margin-bottom:20px;padding-left:28px">Provide basic details about the vital type.</p>
            <!-- End: Section Title -->

            <!-- Begin: Fields Grid 2 Col -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">

                <!-- Begin: Field Vital Type Name -->
                <div>
                    <label class="form-label">Vital Type Name <span style="color:#ef4444">*</span></label>
                    <input type="text" name="name" id="field-name"
                           value="{{ $name }}"
                           placeholder="e.g., Heart Rate"
                           class="form-input {{ $errors->has('name') ? 'is-error' : '' }}"
                           oninput="updatePreview()" />
                    @error('name') <p class="form-error">{{ $message }}</p>
                    @else <p class="form-hint">Enter a clear and unique name.</p> @enderror
                </div>
                <!-- End: Field Vital Type Name -->

                <!-- Begin: Field Category -->
                <div>
                    <label class="form-label">Category <span style="color:#ef4444">*</span></label>
                    <select name="category_id" id="field-category"
                            class="form-input {{ $errors->has('category_id') ? 'is-error' : '' }}"
                            style="cursor:pointer" onchange="updatePreview()">
                        <option value="">Select category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                    data-icon="{{ $cat->icon }}"
                                    data-name="{{ $cat->name }}"
                                    {{ $catId == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="form-error">{{ $message }}</p>
                    @else <p class="form-hint">Choose the appropriate vital sign category.</p> @enderror
                </div>
                <!-- End: Field Category -->

                <!-- Begin: Field Slug -->
                <div>
                    <label class="form-label">Slug <span style="color:#ef4444">*</span></label>
                    <input type="text" name="slug" id="field-slug"
                           value="{{ $slug }}"
                           placeholder="e.g., heart-rate"
                           class="form-input {{ $errors->has('slug') ? 'is-error' : '' }}" />
                    @error('slug') <p class="form-error">{{ $message }}</p>
                    @else <p class="form-hint">URL-friendly identifier (auto-generated if empty).</p> @enderror
                </div>
                <!-- End: Field Slug -->

                <!-- Begin: Field Unit -->
                <div>
                    <label class="form-label">Unit <span style="color:#ef4444">*</span></label>
                    <select name="unit" id="field-unit"
                            class="form-input {{ $errors->has('unit') ? 'is-error' : '' }}"
                            style="cursor:pointer" onchange="updatePreview()">
                        <option value="">Select unit</option>
                        @foreach(['BPM','mmHg','°C','°F','mg/dL','mmol/L','kg','lbs','%','bpm','rpm','steps'] as $u)
                            <option value="{{ $u }}" {{ $unit === $u ? 'selected' : '' }}>{{ $u }}</option>
                        @endforeach
                        @if($unit && !in_array($unit, ['BPM','mmHg','°C','°F','mg/dL','mmol/L','kg','lbs','%','bpm','rpm','steps']))
                            <option value="{{ $unit }}" selected>{{ $unit }}</option>
                        @endif
                    </select>
                    @error('unit') <p class="form-error">{{ $message }}</p>
                    @else <p class="form-hint">Unit of measurement for this vital type.</p> @enderror
                </div>
                <!-- End: Field Unit -->

            </div>
            <!-- End: Fields Grid 2 Col -->

        </div>
        <!-- End: Section Basic Information -->

        <!-- Begin: Section Input Configuration -->
        <div style="background:#fff;border-radius:16px;border:1.5px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,.04);padding:24px;margin-bottom:16px">

            <!-- Begin: Section Title -->
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px">
                <span style="width:20px;height:20px;background:#2563eb;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg style="width:11px;height:11px" fill="white" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                    </svg>
                </span>
                <h2 style="font-size:.9375rem;font-weight:700;color:#1e293b">Input Configuration</h2>
            </div>
            <p style="font-size:.75rem;color:#94a3b8;margin-bottom:20px;padding-left:28px">Configure how data is entered and validated.</p>
            <!-- End: Section Title -->

            <!-- Begin: Fields Grid 4 Col -->
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1.2fr;gap:16px">

                <!-- Begin: Field Input Type -->
                <div>
                    <label class="form-label">Input Type <span style="color:#ef4444">*</span></label>
                    <select name="input_type"
                            class="form-input {{ $errors->has('input_type') ? 'is-error' : '' }}"
                            style="cursor:pointer">
                        @foreach(['number' => 'Number', 'text' => 'Text', 'boolean' => 'Boolean', 'scale' => 'Scale'] as $val => $label)
                            <option value="{{ $val }}" {{ $itype === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('input_type') <p class="form-error">{{ $message }}</p>
                    @else <p class="form-hint">Select the type of input method.</p> @enderror
                </div>
                <!-- End: Field Input Type -->

                <!-- Begin: Field Minimum Value -->
                <div>
                    <label class="form-label">Minimum Value <span style="color:#ef4444">*</span></label>
                    <input type="number" name="min_value" step="any"
                           value="{{ $minVal }}"
                           placeholder="e.g., 40"
                           class="form-input {{ $errors->has('min_value') ? 'is-error' : '' }}"
                           oninput="updatePreview()" />
                    @error('min_value') <p class="form-error">{{ $message }}</p>
                    @else <p class="form-hint">Lowest allowed value.</p> @enderror
                </div>
                <!-- End: Field Minimum Value -->

                <!-- Begin: Field Maximum Value -->
                <div>
                    <label class="form-label">Maximum Value <span style="color:#ef4444">*</span></label>
                    <input type="number" name="max_value" step="any"
                           value="{{ $maxVal }}"
                           placeholder="e.g., 120"
                           class="form-input {{ $errors->has('max_value') ? 'is-error' : '' }}" />
                    @error('max_value') <p class="form-error">{{ $message }}</p>
                    @else <p class="form-hint">Highest allowed value.</p> @enderror
                </div>
                <!-- End: Field Maximum Value -->

                <!-- Begin: Field Normal Range -->
                <div>
                    <label class="form-label">Normal Range <span style="color:#ef4444">*</span></label>
                    <div style="display:flex;align-items:center;gap:6px">
                        <input type="number" name="normal_range_min" step="any"
                               value="{{ $nrMin }}"
                               placeholder="40"
                               id="nr-min"
                               class="form-input {{ $errors->has('normal_range_min') ? 'is-error' : '' }}"
                               style="min-width:0" oninput="updatePreview()" />
                        <span style="color:#94a3b8;font-weight:600;flex-shrink:0">-</span>
                        <input type="number" name="normal_range_max" step="any"
                               value="{{ $nrMax }}"
                               placeholder="120"
                               id="nr-max"
                               class="form-input {{ $errors->has('normal_range_max') ? 'is-error' : '' }}"
                               style="min-width:0" oninput="updatePreview()" />
                    </div>
                    @error('normal_range_min') <p class="form-error">{{ $message }}</p>
                    @elseif($errors->has('normal_range_max')) <p class="form-error">{{ $errors->first('normal_range_max') }}</p>
                    @else <p class="form-hint">Normal healthy range for reference.</p> @enderror
                </div>
                <!-- End: Field Normal Range -->

            </div>
            <!-- End: Fields Grid 4 Col -->

        </div>
        <!-- End: Section Input Configuration -->

        <!-- Begin: Section Additional Settings -->
        <div style="background:#fff;border-radius:16px;border:1.5px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,.04);padding:24px;margin-bottom:24px">

            <!-- Begin: Section Title -->
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px">
                <span style="width:20px;height:20px;background:#2563eb;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg style="width:11px;height:11px" fill="white" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </span>
                <h2 style="font-size:.9375rem;font-weight:700;color:#1e293b">Additional Settings</h2>
            </div>
            <p style="font-size:.75rem;color:#94a3b8;margin-bottom:20px;padding-left:28px">Set status and other preferences.</p>
            <!-- End: Section Title -->

            <!-- Begin: Status + Sort Order + Note Row -->
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:20px">

                <!-- Begin: Status Radios -->
                <div>
                    <label class="form-label">Status <span style="color:#ef4444">*</span></label>
                    <div style="display:flex;flex-direction:column;gap:10px;margin-top:4px">

                        <!-- Begin: Option Active -->
                        <label style="cursor:pointer" id="lbl-active">
                            <input type="radio" name="status" value="active"
                                   class="sr-only vt-status-radio"
                                   {{ $status === 'active' ? 'checked' : '' }} />
                            <div class="status-card {{ $status === 'active' ? 'selected' : '' }}" id="vt-card-active">
                                <div style="display:flex;align-items:flex-start;gap:10px">
                                    <div class="radio-dot {{ $status === 'active' ? 'checked' : '' }}" id="vt-dot-active" style="margin-top:2px">
                                        <div class="radio-dot-inner"></div>
                                    </div>
                                    <div>
                                        <p style="font-size:.8125rem;font-weight:600;color:#1e293b;display:flex;align-items:center;gap:6px">
                                            Active
                                            <span style="font-size:.65rem;font-weight:700;background:#dcfce7;color:#15803d;padding:1px 7px;border-radius:20px">Recommended</span>
                                        </p>
                                        <p style="font-size:.7rem;color:#94a3b8;margin-top:2px">This vital type is active and available for use.</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <!-- End: Option Active -->

                        <!-- Begin: Option Inactive -->
                        <label style="cursor:pointer">
                            <input type="radio" name="status" value="inactive"
                                   class="sr-only vt-status-radio"
                                   {{ $status === 'inactive' ? 'checked' : '' }} />
                            <div class="status-card {{ $status === 'inactive' ? 'selected' : '' }}" id="vt-card-inactive">
                                <div style="display:flex;align-items:flex-start;gap:10px">
                                    <div class="radio-dot {{ $status === 'inactive' ? 'checked' : '' }}" id="vt-dot-inactive" style="margin-top:2px">
                                        <div class="radio-dot-inner"></div>
                                    </div>
                                    <div>
                                        <p style="font-size:.8125rem;font-weight:600;color:#1e293b">Inactive</p>
                                        <p style="font-size:.7rem;color:#94a3b8;margin-top:2px">This vital type is inactive and hidden.</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <!-- End: Option Inactive -->

                    </div>
                    @error('status') <p class="form-error" style="margin-top:6px">{{ $message }}</p> @enderror
                </div>
                <!-- End: Status Radios -->

                <!-- Begin: Field Sort Order -->
                <div>
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" min="0"
                           value="{{ $sort }}"
                           class="form-input {{ $errors->has('sort_order') ? 'is-error' : '' }}" />
                    @error('sort_order') <p class="form-error">{{ $message }}</p>
                    @else <p class="form-hint">Display order in lists (lower numbers appear first).</p> @enderror
                </div>
                <!-- End: Field Sort Order -->

                <!-- Begin: Field Note -->
                <div>
                    <label class="form-label">Note (Optional)</label>
                    <textarea name="note" rows="4"
                              placeholder="Add any additional notes..."
                              style="resize:none"
                              class="form-input {{ $errors->has('note') ? 'is-error' : '' }}">{{ $note }}</textarea>
                    @error('note') <p class="form-error">{{ $message }}</p>
                    @else <p class="form-hint">Additional information about this vital type.</p> @enderror
                </div>
                <!-- End: Field Note -->

            </div>
            <!-- End: Status + Sort Order + Note Row -->

        </div>
        <!-- End: Section Additional Settings -->

        <!-- Begin: Form Action Buttons -->
        <div style="display:flex;justify-content:flex-end;align-items:center;gap:12px">
            <a href="{{ route('vital-types.index') }}"
               style="padding:10px 20px;font-size:.875rem;font-weight:600;color:#4b5563;background:#fff;border:1.5px solid #e5e7eb;border-radius:12px;text-decoration:none;transition:background .15s"
               onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">
                Cancel
            </a>
            <button type="submit" id="vt-submitBtn"
                    style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;background:#2563eb;color:#fff;font-size:.875rem;font-weight:600;border-radius:12px;border:none;cursor:pointer;box-shadow:0 2px 8px rgba(37,99,235,.25);transition:background .15s;font-family:'Plus Jakarta Sans',sans-serif"
                    onmouseover="this.style.background='#1d4ed8'" onmouseout="if(!this.disabled)this.style.background='#2563eb'">
                <!-- Begin: Submit Spinner -->
                <svg id="vt-spinner" style="display:none;width:16px;height:16px;animation:spin .65s linear infinite" fill="none" viewBox="0 0 24 24">
                    <circle style="opacity:.25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                    <path style="opacity:.75" fill="white" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <!-- End: Submit Spinner -->
                <!-- Begin: Submit Icon -->
                <svg id="vt-icon" style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                <!-- End: Submit Icon -->
                <span id="vt-submitText">{{ $isEdit ? 'Update Vital Type' : 'Save Vital Type' }}</span>
            </button>
        </div>
        <!-- End: Form Action Buttons -->

    </div>
    <!-- End: Left Column -->

    <!-- Begin: Right Column – Preview Card -->
    <div style="position:sticky;top:24px">
        <div style="background:#fff;border-radius:16px;border:1.5px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,.04);padding:20px">

            <!-- Begin: Preview Header -->
            <p style="font-size:.9375rem;font-weight:700;color:#1e293b;margin-bottom:4px">Preview</p>
            <p style="font-size:.75rem;color:#94a3b8;margin-bottom:16px">How this vital type will appear.</p>
            <!-- End: Preview Header -->

            <!-- Begin: Preview Card Body -->
            <div style="background:#f8fafc;border-radius:12px;padding:16px;margin-bottom:16px">
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px">
                    <div id="prev-icon" style="width:42px;height:42px;background:#fff1f2;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0">
                        💚
                    </div>
                    <div style="flex:1;min-width:0">
                        <p id="prev-name" style="font-size:.9375rem;font-weight:700;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                            {{ $name ?: 'Heart Rate' }}
                        </p>
                        <span id="prev-status-badge"
                            style="display:inline-block;font-size:.7rem;font-weight:700;padding:2px 8px;border-radius:20px;{{ $status === 'active' ? 'background:#dcfce7;color:#15803d' : 'background:#fef3c7;color:#d97706' }}">
                            {{ ucfirst($status) }}
                        </span>
                    </div>
                </div>
                <div style="display:inline-block;background:#dbeafe;color:#1d4ed8;font-size:.72rem;font-weight:700;padding:3px 10px;border-radius:20px;margin-bottom:12px">
                    <span id="prev-unit">{{ $unit ?: 'BPM' }}</span>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;font-size:.8125rem">
                    <div style="color:#64748b">Category</div>
                    <div id="prev-category" style="text-align:right;font-weight:600;color:#0f172a">{{ $categories->where('id', $catId)->first()?->name ?? 'Heart Rate' }}</div>
                    <div style="color:#64748b">Type</div>
                    <div style="text-align:right;font-weight:600;color:#0f172a">Number</div>
                    <div style="color:#64748b">Unit</div>
                    <div id="prev-unit-row" style="text-align:right;font-weight:600;color:#0f172a">{{ $unit ?: 'BPM' }}</div>
                    <div style="color:#64748b">Range</div>
                    <div id="prev-range" style="text-align:right;font-weight:600;color:#0f172a">
                        {{ ($nrMin !== '' && $nrMax !== '') ? $nrMin . ' - ' . $nrMax : '40 - 120' }}
                    </div>
                </div>
            </div>
            <!-- End: Preview Card Body -->

        </div>
    </div>
    <!-- End: Right Column -->

</div>
<!-- End: Two Column Layout -->

@push('scripts')
<script>
    // Icon map for preview
    var iconMap = {
        'droplet'     : '💧',
        'heart'       : '💚',
        'thermometer' : '🌡️',
        'blooddrop'   : '🩸',
        'lungs'       : '🫁',
        'scale'       : '⚖️',
        'oxygen'      : '🫧',
        'brain'       : '🧠',
    };

    // Auto-generate slug from name input
    document.getElementById('field-name').addEventListener('input', function () {
        var slugField = document.getElementById('field-slug');
        if (!slugField.dataset.manual) {
            slugField.value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
        }
    });
    document.getElementById('field-slug').addEventListener('input', function () {
        this.dataset.manual = 'true';
    });

    // Update live preview card
    function updatePreview() {
        var name     = document.getElementById('field-name').value || 'Vital Type Name';
        var unit     = document.getElementById('field-unit').value || 'Unit';
        var nrMin    = document.getElementById('nr-min').value;
        var nrMax    = document.getElementById('nr-max').value;
        var catSel   = document.getElementById('field-category');
        var catOpt   = catSel.options[catSel.selectedIndex];
        var catName  = catOpt && catOpt.value ? catOpt.getAttribute('data-name') : '-';
        var catIcon  = catOpt && catOpt.value ? catOpt.getAttribute('data-icon') : 'heart';
        var range    = (nrMin && nrMax) ? nrMin + ' - ' + nrMax : '40 - 120';

        document.getElementById('prev-name').textContent     = name;
        document.getElementById('prev-unit').textContent     = unit;
        document.getElementById('prev-unit-row').textContent = unit;
        document.getElementById('prev-range').textContent    = range;
        document.getElementById('prev-category').textContent = catName;
        document.getElementById('prev-icon').textContent     = iconMap[catIcon] || '📋';
    }

    // Status radio interactivity
    document.querySelectorAll('.vt-status-radio').forEach(function (radio) {
        radio.addEventListener('change', function () {
            var val = this.value;
            ['active', 'inactive'].forEach(function (v) {
                var card = document.getElementById('vt-card-' + v);
                var dot  = document.getElementById('vt-dot-' + v);
                card.classList.remove('selected');
                dot.classList.remove('checked');
            });
            document.getElementById('vt-card-' + val).classList.add('selected');
            document.getElementById('vt-dot-' + val).classList.add('checked');

            // Update preview status badge
            var badge = document.getElementById('prev-status-badge');
            if (val === 'active') {
                badge.textContent = 'Active';
                badge.style.background = '#dcfce7';
                badge.style.color      = '#15803d';
            } else {
                badge.textContent = 'Inactive';
                badge.style.background = '#fef3c7';
                badge.style.color      = '#d97706';
            }
        });
    });

    // Submit button loading state
    var vtForm = document.querySelector('form');
    if (vtForm) {
        vtForm.addEventListener('submit', function () {
            var btn     = document.getElementById('vt-submitBtn');
            var spinner = document.getElementById('vt-spinner');
            var icon    = document.getElementById('vt-icon');
            var text    = document.getElementById('vt-submitText');
            if (btn) {
                btn.disabled          = true;
                btn.style.opacity     = '.8';
                btn.style.cursor      = 'not-allowed';
                btn.style.background  = '#1d4ed8';
                if (spinner) spinner.style.display = 'block';
                if (icon)    icon.style.display    = 'none';
                if (text)    text.textContent       = '{{ $isEdit ? "Updating..." : "Saving..." }}';
            }
        });
    }
</script>
@endpush
