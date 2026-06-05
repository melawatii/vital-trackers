{{-- ============================================================ --}}
{{-- Vital Category Form Partial                                --}}
{{-- Shared by create.blade.php and edit.blade.php.            --}}
{{-- $vitalCategory is null on create, model instance on edit. --}}
{{-- ============================================================ --}}

@php
    $isEdit = isset($vitalCategory);
    $name   = old('name',        $vitalCategory->name        ?? '');
    $desc   = old('description', $vitalCategory->description ?? '');
    $icon   = old('icon',        $vitalCategory->icon        ?? 'droplet');
    $status = old('status',      $vitalCategory->status      ?? 'active');

    // Available icon options: key => [emoji, bg-color hex]
    $icons = [
        'droplet'     => ['💧', '#eff6ff'],
        'heart'       => ['💚', '#f0fdf4'],
        'thermometer' => ['🌡️', '#fefce8'],
        'blooddrop'   => ['🩸', '#fff1f2'],
        'lungs'       => ['🫁', '#eef2ff'],
        'scale'       => ['⚖️', '#f8fafc'],
        'oxygen'      => ['🫧', '#ecfeff'],
        'brain'       => ['🧠', '#fdf4ff'],
    ];
@endphp

<!-- Begin: Page Header -->
<div class="flex items-start justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">
            {{ $isEdit ? 'Edit Vital Category' : 'Create Vital Category' }}
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            {{ $isEdit ? 'Update the vital sign category details.' : 'Add a new vital sign category to organize health data effectively.' }}
        </p>
    </div>
    <a href="{{ route('vital-categories.index') }}"
       style="display:inline-flex;align-items:center;gap:8px;padding:10px 16px;background:#fff;border:1.5px solid #e2e8f0;border-radius:12px;font-size:.875rem;font-weight:600;color:#475569;text-decoration:none;transition:background .15s"
       onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
        <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Categories
    </a>
</div>
<!-- End: Page Header -->

<!-- Begin: Section Category Information -->
<div style="background:#fff;border-radius:16px;border:1.5px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,.04);padding:24px;margin-bottom:16px">

    <!-- Begin: Section Title -->
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px">
        <span style="width:20px;height:20px;background:#2563eb;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <svg style="width:11px;height:11px" fill="white" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
        </span>
        <h2 style="font-size:.9375rem;font-weight:700;color:#1e293b">Crategory Information</h2>
    </div>
    <p style="font-size:.75rem;color:#94a3b8;margin-bottom:20px;padding-left:28px">Basic details about the vital category.</p>
    <!-- End: Section Title -->

    <!-- Begin: Fields Grid -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">

        <!-- Begin: Field Category Name -->
        <div>
            <label for="name" class="form-label">
                Category Name <span style="color:#ef4444">*</span>
            </label>
            <input type="text" id="name" name="name"
                   value="{{ $name }}"
                   placeholder="e.g., Blood Pressure"
                   class="form-input {{ $errors->has('name') ? 'is-error' : '' }}" />
            @error('name')
                <p class="form-error">{{ $message }}</p>
            @else
                <p class="form-hint">Enter a descriptive name for the category.</p>
            @enderror
        </div>
        <!-- End: Field Category Name -->

        <!-- Begin: Field Description -->
        <div>
            <label for="description" class="form-label">
                Description <span style="color:#ef4444">*</span>
            </label>
            <textarea id="description" name="description" rows="4"
                      placeholder="e.g., Blood pressure monitoring and tracking"
                      style="resize:none"
                      class="form-input {{ $errors->has('description') ? 'is-error' : '' }}">{{ $desc }}</textarea>
            @error('description')
                <p class="form-error">{{ $message }}</p>
            @else
                <p class="form-hint">Provide a clear description of this category.</p>
            @enderror
        </div>
        <!-- End: Field Description -->

    </div>
    <!-- End: Fields Grid -->

</div>
<!-- End: Section Category Information -->

<!-- Begin: Section Category Icon -->
<div style="background:#fff;border-radius:16px;border:1.5px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,.04);padding:24px;margin-bottom:16px">

    <!-- Begin: Section Title -->
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px">
        <span style="width:20px;height:20px;background:#2563eb;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <svg style="width:11px;height:11px" fill="white" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
            </svg>
        </span>
        <h2 style="font-size:.9375rem;font-weight:700;color:#1e293b">Category Icon</h2>
    </div>
    <p style="font-size:.75rem;color:#94a3b8;margin-bottom:20px;padding-left:28px">Choose an icon to represent this category.</p>
    <!-- End: Section Title -->

    <!-- Begin: Icon Grid -->
    <div style="display:flex;flex-wrap:wrap;gap:12px" id="iconGrid">

        @foreach($icons as $key => [$emoji, $bg])
            <!-- Begin: Icon Option {{ $key }} -->
            <label style="cursor:pointer" title="{{ $key }}">
                <input type="radio" name="icon" value="{{ $key }}"
                       class="sr-only icon-radio"
                       {{ $icon === $key ? 'checked' : '' }} />
                <div class="icon-box {{ $icon === $key ? 'selected' : '' }}"
                     style="background:{{ $bg }}">
                    <span style="font-size:1.5rem;line-height:1;user-select:none">{{ $emoji }}</span>
                    <!-- Begin: Checkmark -->
                    <span class="icon-check">
                        <svg style="width:11px;height:11px" fill="none" stroke="white" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                    <!-- End: Checkmark -->
                </div>
            </label>
            <!-- End: Icon Option {{ $key }} -->
        @endforeach

    </div>
    <!-- End: Icon Grid -->

    @error('icon')
        <p class="form-error" style="margin-top:8px">{{ $message }}</p>
    @enderror

</div>
<!-- End: Section Category Icon -->

<!-- Begin: Section Status -->
<div style="background:#fff;border-radius:16px;border:1.5px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,.04);padding:24px;margin-bottom:24px">

    <!-- Begin: Section Title -->
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px">
        <span style="width:20px;height:20px;background:#2563eb;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <svg style="width:11px;height:11px" fill="white" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
        </span>
        <h2 style="font-size:.9375rem;font-weight:700;color:#1e293b">Status</h2>
    </div>
    <p style="font-size:.75rem;color:#94a3b8;margin-bottom:20px;padding-left:28px">Set the initial status for this category.</p>
    <!-- End: Section Title -->

    <!-- Begin: Status Radio Grid -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">

        <!-- Begin: Option Active -->
        <label style="cursor:pointer" id="label-active">
            <input type="radio" name="status" value="active"
                   class="sr-only status-radio"
                   {{ $status === 'active' ? 'checked' : '' }} />
            <div class="status-card {{ $status === 'active' ? 'selected' : '' }}" id="card-active">
                <div style="display:flex;align-items:center;gap:12px">
                    <div class="radio-dot {{ $status === 'active' ? 'checked' : '' }}" id="dot-active">
                        <div class="radio-dot-inner"></div>
                    </div>
                    <div>
                        <p style="font-size:.875rem;font-weight:600;color:#1e293b;display:flex;align-items:center;gap:8px">
                            Active
                            <span style="font-size:.7rem;font-weight:700;background:#dcfce7;color:#15803d;padding:2px 8px;border-radius:20px">Recommended</span>
                        </p>
                        <p style="font-size:.75rem;color:#94a3b8;margin-top:2px">Category will be available for use</p>
                    </div>
                </div>
            </div>
        </label>
        <!-- End: Option Active -->

        <!-- Begin: Option Inactive -->
        <label style="cursor:pointer" id="label-inactive">
            <input type="radio" name="status" value="inactive"
                   class="sr-only status-radio"
                   {{ $status === 'inactive' ? 'checked' : '' }} />
            <div class="status-card {{ $status === 'inactive' ? 'selected' : '' }}" id="card-inactive">
                <div style="display:flex;align-items:center;gap:12px">
                    <div class="radio-dot {{ $status === 'inactive' ? 'checked' : '' }}" id="dot-inactive">
                        <div class="radio-dot-inner"></div>
                    </div>
                    <div>
                        <p style="font-size:.875rem;font-weight:600;color:#1e293b">Inactive</p>
                        <p style="font-size:.75rem;color:#94a3b8;margin-top:2px">Category will be disabled temporarily</p>
                    </div>
                </div>
            </div>
        </label>
        <!-- End: Option Inactive -->

    </div>
    <!-- End: Status Radio Grid -->

    @error('status')
        <p class="form-error" style="margin-top:8px">{{ $message }}</p>
    @enderror

</div>
<!-- End: Section Status -->

<!-- Begin: Form Action Buttons -->
<div style="display:flex;justify-content:flex-end;align-items:center;gap:12px">

    <a href="{{ route('vital-categories.index') }}"
       style="padding:10px 20px;font-size:.875rem;font-weight:600;color:#4b5563;background:#fff;border:1.5px solid #e5e7eb;border-radius:12px;text-decoration:none;transition:background .15s"
       onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">
        Cancel
    </a>

    <button type="submit" id="submitBtn"
            style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;background:#2563eb;color:#fff;font-size:.875rem;font-weight:600;border-radius:12px;border:none;cursor:pointer;box-shadow:0 2px 8px rgba(37,99,235,.25);transition:background .15s;font-family:'Plus Jakarta Sans',sans-serif"
            onmouseover="this.style.background='#1d4ed8'" onmouseout="if(!this.disabled)this.style.background='#2563eb'">
        <!-- Begin: Submit Spinner (hidden by default) -->
        <svg id="submitSpinner" style="display:none;width:16px;height:16px;animation:spin .65s linear infinite" fill="none" viewBox="0 0 24 24">
            <circle style="opacity:.25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
            <path style="opacity:.75" fill="white" d="M4 12a8 8 0 018-8v8H4z"></path>
        </svg>
        <!-- End: Submit Spinner -->
        <!-- Begin: Submit Icon -->
        <svg id="submitIcon" style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
        </svg>
        <!-- End: Submit Icon -->
        <span id="submitText">{{ $isEdit ? 'Update Category' : 'Save Category' }}</span>
    </button>

</div>
<!-- End: Form Action Buttons -->

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Icon picker ───────────────────────────────────────────
    document.querySelectorAll('.icon-radio').forEach(function (radio) {
        radio.addEventListener('change', function () {
            // Reset all icon boxes
            document.querySelectorAll('.icon-box').forEach(function (box) {
                box.classList.remove('selected');
            });
            // Select current
            if (this.checked) {
                this.closest('label').querySelector('.icon-box').classList.add('selected');
            }
        });
    });

    // ── Status radio cards ────────────────────────────────────
    document.querySelectorAll('.status-radio').forEach(function (radio) {
        radio.addEventListener('change', function () {
            var value = this.value;

            // Reset all cards and dots
            ['active', 'inactive'].forEach(function (v) {
                var card = document.getElementById('card-' + v);
                var dot  = document.getElementById('dot-'  + v);
                if (card) card.classList.remove('selected');
                if (dot)  { dot.classList.remove('checked'); }
            });

            // Apply selected state
            var card = document.getElementById('card-' + value);
            var dot  = document.getElementById('dot-'  + value);
            if (card) card.classList.add('selected');
            if (dot)  dot.classList.add('checked');
        });
    });

    // ── Submit button loading state ───────────────────────────
    var form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function () {
            var btn     = document.getElementById('submitBtn');
            var spinner = document.getElementById('submitSpinner');
            var icon    = document.getElementById('submitIcon');
            var text    = document.getElementById('submitText');

            if (btn) {
                btn.disabled = true;
                btn.style.background  = '#1d4ed8';
                btn.style.opacity     = '.8';
                btn.style.cursor      = 'not-allowed';
                if (spinner) spinner.style.display = 'block';
                if (icon)    icon.style.display    = 'none';
                if (text)    text.textContent       = '{{ $isEdit ? "Updating..." : "Saving..." }}';
            }
        });
    }

});
</script>
@endpush
