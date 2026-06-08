{{-- ============================================================ --}}
{{-- Vital Record Form Partial                                  --}}
{{-- Shared by create.blade.php and edit.blade.php.            --}}
{{-- $record is null on create, model instance on edit.        --}}
{{-- $categories = active VitalCategory collection.            --}}
{{-- $types      = VitalType collection for selected category. --}}
{{-- ============================================================ --}}

@php
    $isEdit     = isset($record);
    $typeId     = old('type_id',     $record->type_id     ?? '');
    $catId      = old('category_id', $record->category_id ?? '');
    $value      = old('value',       $record->value       ?? '');
    $unit       = old('unit',        $record->unit        ?? '');
    $status     = old('status',      $record->status      ?? 'normal');
    $note       = old('note',        $record->note        ?? '');
    $recordedAt = old('recorded_at',
        isset($record->recorded_at)
            ? \Carbon\Carbon::parse($record->recorded_at)->format('Y-m-d\TH:i')
            : now()->format('Y-m-d\TH:i')
    );
@endphp

<!-- Begin: Page Header -->
<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">
            {{ $isEdit ? 'Edit Vital Record' : 'Create New Vital Record' }}
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            {{ $isEdit ? 'Update this vital sign measurement.' : 'Add a new vital sign measurement to track your health.' }}
        </p>
    </div>
    <a href="{{ route('vital-records.index') }}"
       style="display:inline-flex;align-items:center;gap:8px;padding:10px 16px;background:#fff;border:1.5px solid #e2e8f0;border-radius:12px;font-size:.875rem;font-weight:600;color:#475569;text-decoration:none;transition:background .15s"
       onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
        <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Records
    </a>
</div>
<!-- End: Page Header -->

@if(auth()->check() && auth()->user()->role === 'admin' && isset($users) && count($users) > 0)
<!-- Begin: Admin User Selection Section -->
<div style="background:#fff3cd;border-radius:16px;border:1.5px solid #ffc107;box-shadow:0 1px 4px rgba(0,0,0,.04);padding:24px;margin-bottom:16px">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
        <svg style="width:20px;height:20px;color:#ff9800;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <h2 style="font-size:.9375rem;font-weight:700;color:#1e293b">Admin: Select User</h2>
    </div>
    <p style="font-size:.75rem;color:#7a6c00;margin-bottom:16px">Choose which user this record belongs to.</p>

    <div>
        <label class="form-label">For User <span style="color:#ef4444">*</span></label>
        <select name="user_id" id="field-user-id"
                class="form-input"
                style="cursor:pointer">
            <option value="">Select user (defaults to yourself)</option>
            @foreach($users as $u)
                <option value="{{ $u->_id }}"
                        {{ auth()->id() == $u->_id ? 'selected' : '' }}>
                    {{ $u->name }} {{ auth()->id() == $u->_id ? '(You)' : '' }}
                </option>
            @endforeach
        </select>
        <p class="form-hint">Leave empty to create record for yourself.</p>
    </div>
</div>
<!-- End: Admin User Selection Section -->
@endif

<!-- Begin: Two Column Layout -->
<div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start">

    <!-- Begin: Left Column (Sections) -->
    <div>

        <!-- Begin: Section 1 Basic Information -->
        <div style="background:#fff;border-radius:16px;border:1.5px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,.04);padding:24px;margin-bottom:16px">

            <!-- Begin: Section Title -->
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px">
                <span style="width:24px;height:24px;background:#2563eb;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.75rem;font-weight:700;color:#fff">1</span>
                <h2 style="font-size:.9375rem;font-weight:700;color:#1e293b">Basic Information</h2>
            </div>
            <p style="font-size:.75rem;color:#94a3b8;margin-bottom:20px;padding-left:34px">Select the type of measurement and when it was taken.</p>
            <!-- End: Section Title -->

            <!-- Begin: Fields Grid -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">

                <!-- Begin: Field Vital Type -->
                <div>
                    <label class="form-label">Vital Type <span style="color:#ef4444">*</span></label>
                    {{-- Category hidden helper for selected type --}}
                    <input type="hidden" name="category_id" id="hidden-category-id" value="{{ $catId }}" />

                    <select name="type_id" id="field-type"
                            class="form-input {{ $errors->has('type_id') ? 'is-error' : '' }}"
                            style="cursor:pointer" onchange="onTypeChange()">
                        <option value="">Select vital type</option>
                        @foreach($types ?? [] as $t)
                            <option value="{{ $t->id }}"
                                    data-category-id="{{ $t->category_id }}"
                                    data-unit="{{ $t->unit }}"
                                    data-nr-min="{{ $t->normal_range_min }}"
                                    data-nr-max="{{ $t->normal_range_max }}"
                                    {{ $typeId == $t->id ? 'selected' : '' }}>
                                {{ $t->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('type_id') <p class="form-error">{{ $message }}</p>
                    @else <p class="form-hint">Choose the vital sign you want to record.</p> @enderror
                </div>
                <!-- End: Field Vital Type -->

                <!-- Begin: Field Date & Time -->
                <div>
                    <label class="form-label">Date & Time <span style="color:#ef4444">*</span></label>
                    <input type="datetime-local" name="recorded_at"
                           value="{{ $recordedAt }}"
                           class="form-input {{ $errors->has('recorded_at') ? 'is-error' : '' }}" />
                    @error('recorded_at') <p class="form-error">{{ $message }}</p>
                    @else <p class="form-hint">When was this measurement taken?</p> @enderror
                </div>
                <!-- End: Field Date & Time -->

            </div>
            <!-- End: Fields Grid -->

        </div>
        <!-- End: Section 1 Basic Information -->

        <!-- Begin: Section 2 Measurement Details -->
        <div style="background:#fff;border-radius:16px;border:1.5px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,.04);padding:24px;margin-bottom:16px">

            <!-- Begin: Section Title -->
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px">
                <span style="width:24px;height:24px;background:#2563eb;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.75rem;font-weight:700;color:#fff">2</span>
                <h2 style="font-size:.9375rem;font-weight:700;color:#1e293b">Measurement Details</h2>
            </div>
            <p style="font-size:.75rem;color:#94a3b8;margin-bottom:20px;padding-left:34px">Enter the measurement value and unit.</p>
            <!-- End: Section Title -->

            <!-- Begin: Value + Unit Fields -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">

                <!-- Begin: Field Value -->
                <div>
                    <label class="form-label">Value <span style="color:#ef4444">*</span></label>
                    <input type="number" name="value" id="field-value" step="any"
                           value="{{ $value }}"
                           placeholder="e.g., 118"
                           class="form-input {{ $errors->has('value') ? 'is-error' : '' }}"
                           oninput="updatePreview()" />
                    @error('value') <p class="form-error">{{ $message }}</p>
                    @else <p class="form-hint">Enter the measured value.</p> @enderror
                </div>
                <!-- End: Field Value -->

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
                    </select>
                    @error('unit') <p class="form-error">{{ $message }}</p>
                    @else <p class="form-hint">Unit of measurement.</p> @enderror
                </div>
                <!-- End: Field Unit -->

            </div>
            <!-- End: Value + Unit Fields -->

            <!-- Begin: Normal Range Reference Box -->
            <div id="normal-range-box"
                 style="display:none;margin-top:16px;padding:12px 16px;background:#eff6ff;border:1.5px solid #bfdbfe;border-radius:10px">
                <div style="display:flex;align-items:center;gap:8px">
                    <svg style="width:15px;height:15px;color:#2563eb;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p style="font-size:.8125rem;font-weight:600;color:#1d4ed8">Normal Range Reference</p>
                </div>
                <p id="normal-range-text" style="font-size:.8125rem;color:#3b82f6;margin-top:4px;padding-left:23px">
                    Normal range for this vital type: –
                </p>
            </div>
            <!-- End: Normal Range Reference Box -->

        </div>
        <!-- End: Section 2 Measurement Details -->

        <!-- Begin: Section 3 Additional Information -->
        <div style="background:#fff;border-radius:16px;border:1.5px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,.04);padding:24px;margin-bottom:16px">

            <!-- Begin: Section Title -->
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px">
                <span style="width:24px;height:24px;background:#2563eb;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.75rem;font-weight:700;color:#fff">3</span>
                <h2 style="font-size:.9375rem;font-weight:700;color:#1e293b">Additional Information (Optional)</h2>
            </div>
            <p style="font-size:.75rem;color:#94a3b8;margin-bottom:20px;padding-left:34px">Add notes or other relevant information.</p>
            <!-- End: Section Title -->

            <!-- Begin: Field Note -->
            <div>
                <label class="form-label">Note</label>
                <textarea name="note" rows="3"
                          placeholder="e.g., Feeling good, after exercise, before breakfast..."
                          style="resize:vertical"
                          class="form-input {{ $errors->has('note') ? 'is-error' : '' }}">{{ $note }}</textarea>
                @error('note') <p class="form-error">{{ $message }}</p>
                @else <p class="form-hint">Any additional notes about this measurement.</p> @enderror
            </div>
            <!-- End: Field Note -->

        </div>
        <!-- End: Section 3 Additional Information -->

        <!-- Begin: Section 4 Status -->
        <div style="background:#fff;border-radius:16px;border:1.5px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,.04);padding:24px;margin-bottom:24px">

            <!-- Begin: Section Title -->
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px">
                <span style="width:24px;height:24px;background:#2563eb;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:.75rem;font-weight:700;color:#fff">4</span>
                <h2 style="font-size:.9375rem;font-weight:700;color:#1e293b">Status</h2>
            </div>
            <p style="font-size:.75rem;color:#94a3b8;margin-bottom:20px;padding-left:34px">Set the status of this measurement.</p>
            <!-- End: Section Title -->

            <!-- Begin: Status Radio Grid -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">

                <!-- Begin: Option Normal -->
                <label style="cursor:pointer">
                    <input type="radio" name="status" value="normal" class="sr-only rec-status-radio"
                           {{ $status === 'normal' ? 'checked' : '' }} />
                    <div class="status-card {{ $status === 'normal' ? 'selected' : '' }}" id="rec-card-normal">
                        <div style="display:flex;align-items:center;gap:10px">
                            <div class="radio-dot {{ $status === 'normal' ? 'checked' : '' }}" id="rec-dot-normal"
                                 style="{{ $status === 'normal' ? 'border-color:#22c55e;background:#22c55e' : '' }}">
                                <div class="radio-dot-inner"></div>
                            </div>
                            <div>
                                <p style="font-size:.875rem;font-weight:600;color:#1e293b">Normal</p>
                                <p style="font-size:.75rem;color:#22c55e;margin-top:2px">Measurement is within the normal range</p>
                            </div>
                        </div>
                    </div>
                </label>
                <!-- End: Option Normal -->

                <!-- Begin: Option High / Low -->
                <label style="cursor:pointer">
                    <input type="radio" name="status" value="high_low" class="sr-only rec-status-radio"
                           {{ $status === 'high_low' ? 'checked' : '' }} />
                    <div class="status-card {{ $status === 'high_low' ? 'selected' : '' }}" id="rec-card-high_low"
                         style="{{ $status === 'high_low' ? 'border-color:#f59e0b' : '' }}">
                        <div style="display:flex;align-items:center;gap:10px">
                            <div class="radio-dot {{ $status === 'high_low' ? 'checked' : '' }}" id="rec-dot-high_low"
                                 style="{{ $status === 'high_low' ? 'border-color:#f59e0b;background:#f59e0b' : '' }}">
                                <div class="radio-dot-inner"></div>
                            </div>
                            <div>
                                <p style="font-size:.875rem;font-weight:600;color:#1e293b">High / Low</p>
                                <p style="font-size:.75rem;color:#f59e0b;margin-top:2px">Measurement is outside the normal range</p>
                            </div>
                        </div>
                    </div>
                </label>
                <!-- End: Option High / Low -->

            </div>
            <!-- End: Status Radio Grid -->

            @error('status') <p class="form-error" style="margin-top:8px">{{ $message }}</p> @enderror

        </div>
        <!-- End: Section 4 Status -->

        <!-- Begin: Form Action Buttons -->
        <div style="display:flex;justify-content:flex-end;align-items:center;gap:12px">
            <a href="{{ route('vital-records.index') }}"
               style="padding:10px 20px;font-size:.875rem;font-weight:600;color:#4b5563;background:#fff;border:1.5px solid #e5e7eb;border-radius:12px;text-decoration:none;transition:background .15s"
               onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">
                Cancel
            </a>
            <button type="submit" id="rec-submitBtn"
                    style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;background:#2563eb;color:#fff;font-size:.875rem;font-weight:600;border-radius:12px;border:none;cursor:pointer;box-shadow:0 2px 8px rgba(37,99,235,.25);transition:background .15s;font-family:'Plus Jakarta Sans',sans-serif"
                    onmouseover="this.style.background='#1d4ed8'" onmouseout="if(!this.disabled)this.style.background='#2563eb'">
                <!-- Begin: Submit Spinner -->
                <svg id="rec-spinner" style="display:none;width:16px;height:16px;animation:spin .65s linear infinite" fill="none" viewBox="0 0 24 24">
                    <circle style="opacity:.25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                    <path style="opacity:.75" fill="white" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <!-- End: Submit Spinner -->
                <svg id="rec-icon" style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                <span id="rec-submitText">{{ $isEdit ? 'Update Record' : 'Save Record' }}</span>
            </button>
        </div>
        <!-- End: Form Action Buttons -->

    </div>
    <!-- End: Left Column -->

    <!-- Begin: Right Column – Record Preview -->
    <div style="position:sticky;top:24px">
        <div style="background:#fff;border-radius:16px;border:1.5px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,.04);padding:20px">

            <!-- Begin: Preview Header -->
            <p style="font-size:.9375rem;font-weight:700;color:#1e293b;margin-bottom:2px">Record Preview</p>
            <p style="font-size:.75rem;color:#94a3b8;margin-bottom:16px">Review your information before saving.</p>
            <!-- End: Preview Header -->

            <!-- Begin: Preview Card -->
            <div style="background:#f8fafc;border-radius:12px;padding:16px;margin-bottom:16px">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
                    <div id="prev-icon" style="width:40px;height:40px;background:#eff6ff;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0">
                        💧
                    </div>
                    <div>
                        <p id="prev-type-name" style="font-size:.875rem;font-weight:700;color:#0f172a">–</p>
                        <span id="prev-cat-name" style="display:inline-block;font-size:.7rem;font-weight:700;padding:2px 8px;border-radius:20px;background:#dbeafe;color:#1d4ed8">–</span>
                    </div>
                    <span id="prev-status-badge"
                        style="margin-left:auto;font-size:.7rem;font-weight:700;padding:2px 8px;border-radius:20px;background:#dcfce7;color:#15803d">Normal</span>
                </div>

                <div style="display:flex;flex-direction:column;gap:10px;font-size:.8125rem">

                    <div style="display:flex;align-items:center;gap:8px;color:#64748b">
                        <svg style="width:15px;height:15px;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Date & Time</span>
                        <span id="prev-datetime" style="margin-left:auto;font-weight:600;color:#0f172a">–</span>
                    </div>

                    <div style="display:flex;align-items:center;gap:8px;color:#64748b">
                        <svg style="width:15px;height:15px;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span>Value</span>
                        <span id="prev-value" style="margin-left:auto;font-weight:600;color:#0f172a">–</span>
                    </div>

                    <div style="display:flex;align-items:center;gap:8px;color:#64748b">
                        <svg style="width:15px;height:15px;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <span>Unit</span>
                        <span id="prev-unit" style="margin-left:auto;font-weight:600;color:#0f172a">–</span>
                    </div>

                    <div style="display:flex;align-items:center;gap:8px;color:#64748b">
                        <svg style="width:15px;height:15px;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Normal Range</span>
                        <span id="prev-range" style="margin-left:auto;font-weight:600;color:#0f172a">–</span>
                    </div>

                    <div style="display:flex;align-items:center;gap:8px;color:#64748b">
                        <svg style="width:15px;height:15px;flex-shrink:0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span>Status</span>
                        <div id="prev-status-row" style="margin-left:auto">
                            <span style="font-size:.72rem;font-weight:700;padding:2px 8px;border-radius:20px;background:#dcfce7;color:#15803d">Normal</span>
                        </div>
                    </div>

                    <div style="display:flex;align-items:flex-start;gap:8px;color:#64748b">
                        <svg style="width:15px;height:15px;flex-shrink:0;margin-top:1px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span>Note</span>
                        <span id="prev-note" style="margin-left:auto;font-weight:500;color:#94a3b8;text-align:right;max-width:140px">–</span>
                    </div>

                </div>
            </div>
            <!-- End: Preview Card -->

            <!-- Begin: Tips Box -->
            <div style="background:#f0fdf4;border-radius:10px;padding:12px;display:flex;gap:8px">
                <svg style="width:15px;height:15px;color:#22c55e;flex-shrink:0;margin-top:1px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                <div>
                    <p style="font-size:.75rem;font-weight:700;color:#15803d;margin-bottom:2px">Tips</p>
                    <p style="font-size:.72rem;color:#16a34a;line-height:1.5">Make sure the measurement is accurate and taken under normal conditions for best tracking results.</p>
                </div>
            </div>
            <!-- End: Tips Box -->

        </div>
    </div>
    <!-- End: Right Column -->

</div>
<!-- End: Two Column Layout -->

@push('scripts')
@php
    $preloadedTypesJs = [];
    foreach ($types ?? collect() as $t) {
        $preloadedTypesJs[] = [
            'id'               => (string) $t->id,
            'name'             => $t->name,
            'category_id'      => (string) $t->category_id,
            'unit'             => $t->unit,
            'normal_range_min' => $t->normal_range_min,
            'normal_range_max' => $t->normal_range_max,
        ];
    }

    $categoriesDataJs = [];
    foreach ($categories as $c) {
        $categoriesDataJs[] = ['id' => (string) $c->id, 'name' => $c->name, 'icon' => $c->icon];
    }
@endphp
<script>
    // Preloaded types for edit mode
    var preloadedTypes = @json($preloadedTypesJs);

    var selectedTypeId = '{{ $typeId }}';

    // Icon map for categories
    var iconMap = { droplet:'💧', heart:'💚', thermometer:'🌡️', blooddrop:'🩸', lungs:'🫁', scale:'⚖️', oxygen:'🫧', brain:'🧠' };

    // Category metadata from server (for preview)
    var categoriesData = @json($categoriesDataJs);

    // Store current type meta for preview
    var currentTypeMeta = {};

    /**
     * Called when vital type dropdown changes.
     * Updates unit, normal range box, and live preview.
     */
    function onTypeChange() {
        var sel = document.getElementById('field-type');
        var opt = sel.options[sel.selectedIndex];

        if (opt && opt.value) {
            var catId = opt.getAttribute('data-category-id') || '';
            var unit  = opt.getAttribute('data-unit')   || '';
            var nrMin = opt.getAttribute('data-nr-min') || '';
            var nrMax = opt.getAttribute('data-nr-max') || '';

            // Auto-set category_id from the selected type
            var hiddenCatId = document.getElementById('hidden-category-id');
            if (hiddenCatId) {
                hiddenCatId.value = catId;
            }

            // Auto-set unit select
            var unitSel = document.getElementById('field-unit');
            for (var i = 0; i < unitSel.options.length; i++) {
                if (unitSel.options[i].value === unit) { unitSel.selectedIndex = i; break; }
            }

            // Show normal range reference
            if (nrMin && nrMax) {
                var rangeText = 'Normal range for this vital type: ' + nrMin + ' - ' + nrMax + ' ' + unit;
                document.getElementById('normal-range-text').textContent = rangeText;
                document.getElementById('normal-range-box').style.display = 'block';
            } else {
                document.getElementById('normal-range-box').style.display = 'none';
            }

            currentTypeMeta = { name: opt.text, unit: unit, nrMin: nrMin, nrMax: nrMax };
        } else {
            document.getElementById('normal-range-box').style.display = 'none';
            currentTypeMeta = {};
        }

        updatePreview();
    }

    /** Update live record preview card */
    function updatePreview() {
        var value    = document.getElementById('field-value').value;
        var unitSel  = document.getElementById('field-unit');
        var unit     = unitSel.options[unitSel.selectedIndex]?.value || '–';
        var dtVal    = document.querySelector('[name="recorded_at"]').value;
        var noteEl   = document.querySelector('[name="note"]');
        var note     = noteEl ? noteEl.value : '';

        // Get current status from selected radio
        var statusRadio = document.querySelector('.rec-status-radio:checked');
        var status      = statusRadio ? statusRadio.value : 'normal';

        // Format datetime
        var dtDisplay = '–';
        if (dtVal) {
            var d = new Date(dtVal);
            dtDisplay = d.toLocaleDateString('en-US', { month:'short', day:'2-digit', year:'numeric' })
                + '  ' + d.toLocaleTimeString('en-US', { hour:'2-digit', minute:'2-digit' });
        }

        document.getElementById('prev-type-name').textContent = currentTypeMeta.name || '–';
        document.getElementById('prev-value').textContent     = value || '–';
        document.getElementById('prev-unit').textContent      = unit;
        document.getElementById('prev-datetime').textContent  = dtDisplay;
        document.getElementById('prev-note').textContent      = note || '–';
        document.getElementById('prev-range').textContent     =
            (currentTypeMeta.nrMin && currentTypeMeta.nrMax)
            ? currentTypeMeta.nrMin + ' - ' + currentTypeMeta.nrMax + ' ' + unit
            : '–';

        // Update status badge based on current status
        var statusBadge = document.getElementById('prev-status-badge');
        var statusRow   = document.getElementById('prev-status-row');
        if (status === 'normal') {
            statusBadge.textContent = 'Normal';
            statusBadge.style.background = '#dcfce7';
            statusBadge.style.color = '#15803d';
            statusRow.innerHTML = '<span style="font-size:.72rem;font-weight:700;padding:2px 8px;border-radius:20px;background:#dcfce7;color:#15803d">Normal</span>';
        } else {
            statusBadge.textContent = 'High/Low';
            statusBadge.style.background = '#fef3c7';
            statusBadge.style.color = '#d97706';
            statusRow.innerHTML = '<span style="font-size:.72rem;font-weight:700;padding:2px 8px;border-radius:20px;background:#fef3c7;color:#d97706">High/Low</span>';
        }

        // Category info for preview
        var catId   = document.getElementById('hidden-category-id').value;
        var catData = categoriesData.find(function(c) { return c.id == catId; });
        if (catData) {
            document.getElementById('prev-cat-name').textContent = catData.name;
            document.getElementById('prev-icon').textContent     = iconMap[catData.icon] || '📋';
        }
    }

    // Status radio interactivity
    document.querySelectorAll('.rec-status-radio').forEach(function (radio) {
        radio.addEventListener('change', function () {
            var val = this.value;
            ['normal', 'high_low'].forEach(function (v) {
                var card = document.getElementById('rec-card-' + v);
                var dot  = document.getElementById('rec-dot-' + v);
                card.classList.remove('selected');
                card.style.borderColor = '';
                dot.classList.remove('checked');
                dot.style.borderColor  = '';
                dot.style.background   = '';
            });

            var card = document.getElementById('rec-card-' + val);
            var dot  = document.getElementById('rec-dot-' + val);
            card.classList.add('selected');
            dot.classList.add('checked');

            // Color-code by status
            if (val === 'normal') {
                card.style.borderColor = '#22c55e';
                dot.style.borderColor  = '#22c55e';
                dot.style.background   = '#22c55e';
                document.getElementById('prev-status-badge').textContent       = 'Normal';
                document.getElementById('prev-status-badge').style.background  = '#dcfce7';
                document.getElementById('prev-status-badge').style.color       = '#15803d';
                document.getElementById('prev-status-row').innerHTML =
                    '<span style="font-size:.72rem;font-weight:700;padding:2px 8px;border-radius:20px;background:#dcfce7;color:#15803d">Normal</span>';
            } else {
                card.style.borderColor = '#f59e0b';
                dot.style.borderColor  = '#f59e0b';
                dot.style.background   = '#f59e0b';
                document.getElementById('prev-status-badge').textContent       = 'High/Low';
                document.getElementById('prev-status-badge').style.background  = '#fef3c7';
                document.getElementById('prev-status-badge').style.color       = '#d97706';
                document.getElementById('prev-status-row').innerHTML =
                    '<span style="font-size:.72rem;font-weight:700;padding:2px 8px;border-radius:20px;background:#fef3c7;color:#d97706">High/Low</span>';
            }
        });
    });

    // Listen on note changes for live preview
    var noteEl = document.querySelector('[name="note"]');
    if (noteEl) noteEl.addEventListener('input', updatePreview);

    // Listen on datetime changes
    var dtEl = document.querySelector('[name="recorded_at"]');
    if (dtEl) dtEl.addEventListener('change', updatePreview);

    // Listen on unit change
    var unitEl = document.getElementById('field-unit');
    if (unitEl) unitEl.addEventListener('change', updatePreview);

    // Submit loading state
    var form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function () {
            var btn     = document.getElementById('rec-submitBtn');
            var spinner = document.getElementById('rec-spinner');
            var icon    = document.getElementById('rec-icon');
            var text    = document.getElementById('rec-submitText');
            if (btn) {
                btn.disabled = true; btn.style.opacity = '.8'; btn.style.cursor = 'not-allowed';
                if (spinner) spinner.style.display = 'block';
                if (icon)    icon.style.display    = 'none';
                if (text)    text.textContent      = '{{ $isEdit ? "Updating..." : "Saving..." }}';
            }
        });
    }

    // Initialize preview on load (edit mode)
    document.addEventListener('DOMContentLoaded', function () {
        // Load preloaded types into select (edit mode)
        if (preloadedTypes.length > 0 && !document.getElementById('field-type').options.length > 1) {
            var sel = document.getElementById('field-type');
            preloadedTypes.forEach(function (t) {
                var opt = new Option(t.name, t.id, false, t.id == selectedTypeId);
                opt.setAttribute('data-category-id', t.category_id);
                opt.setAttribute('data-unit',   t.unit);
                opt.setAttribute('data-nr-min', t.normal_range_min || '');
                opt.setAttribute('data-nr-max', t.normal_range_max || '');
                sel.add(opt);
            });
        }
        onTypeChange();
        updatePreview();
    });
</script>
@endpush
