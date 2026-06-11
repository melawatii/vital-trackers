{{-- ============================================================ --}}
{{-- User Form Partial                                          --}}
{{-- Shared by create.blade.php and edit.blade.php.            --}}
{{-- $user is null on create, model instance on edit.          --}}
{{-- ============================================================ --}}

@php
    $isEdit   = isset($user);
    $name     = old('name',     $user->name     ?? '');
    $username = old('username', $user->username ?? '');
    $email    = old('email',    $user->email    ?? '');
    $phone    = old('phone',    $user->phone    ?? '');
    $role     = old('role',     $user->role     ?? '');
    $status   = old('status',   $user->status   ?? 'active');

    // Available roles: value => [label, badge-bg, badge-color, description]
    $roles = [
        'admin' => ['Administrator', '#ede9fe', '#6d28d9', 'Full system access and configuration.'],
        'user'  => ['User',          '#dbeafe', '#1d4ed8', 'Standard access to view and input data.'],
    ];
@endphp

<!-- Begin: Page Header -->
<div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:24px">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">
            {{ $isEdit ? 'Edit User' : 'Create User' }}
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            {{ $isEdit ? 'Update user details and access level.' : 'Add a new user to the system and assign role and access.' }}
        </p>
    </div>
    <a href="{{ route('users.index') }}"
       style="display:inline-flex;align-items:center;gap:8px;padding:10px 16px;background:#fff;border:1.5px solid #e2e8f0;border-radius:12px;font-size:.875rem;font-weight:600;color:#475569;text-decoration:none;transition:background .15s"
       onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
        <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Users
    </a>
</div>
<!-- End: Page Header -->

<!-- Begin: Two Column Layout -->
<div style="display:grid;grid-template-columns:1fr 280px;gap:20px;align-items:start">

    <!-- Begin: Left Column -->
    <div>

        <!-- Begin: Section User Information -->
        <div style="background:#fff;border-radius:16px;border:1.5px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,.04);padding:24px;margin-bottom:16px">

            <!-- Begin: Section Title -->
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px">
                <span style="width:24px;height:24px;background:#2563eb;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg style="width:13px;height:13px" fill="white" viewBox="0 0 24 24">
                        <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                    </svg>
                </span>
                <h2 style="font-size:.9375rem;font-weight:700;color:#1e293b">User Information</h2>
            </div>
            <p style="font-size:.75rem;color:#94a3b8;margin-bottom:20px;padding-left:34px">Basic details of the user.</p>
            <!-- End: Section Title -->

            <!-- Begin: Fields Grid -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">

                <!-- Begin: Field Full Name -->
                <div>
                    <label class="form-label">Full Name <span style="color:#ef4444">*</span></label>
                    <input type="text" name="name" value="{{ $name }}"
                           placeholder="Enter full name"
                           class="form-input {{ $errors->has('name') ? 'is-error' : '' }}" />
                    @error('name') <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- End: Field Full Name -->

                <!-- Begin: Field Username -->
                <div>
                    <label class="form-label">Username <span style="color:#ef4444">*</span></label>
                    <input type="text" name="username" value="{{ $username }}"
                           placeholder="Enter username"
                           class="form-input {{ $errors->has('username') ? 'is-error' : '' }}" />
                    @error('username') <p class="form-error">{{ $message }}</p>
                    @else <p class="form-hint">Username must be unique.</p> @enderror
                </div>
                <!-- End: Field Username -->

                <!-- Begin: Field Email -->
                <div>
                    <label class="form-label">Email Address <span style="color:#ef4444">*</span></label>
                    <input type="email" name="email" value="{{ $email }}"
                           placeholder="Enter email address"
                           class="form-input {{ $errors->has('email') ? 'is-error' : '' }}" />
                    @error('email') <p class="form-error">{{ $message }}</p>
                    @else <p class="form-hint">Email must be unique.</p> @enderror
                </div>
                <!-- End: Field Email -->

                <!-- Begin: Field Password -->
                <div>
                    <label class="form-label">
                        Password <span style="color:#ef4444">*</span>
                        @if($isEdit) <span style="font-size:.7rem;color:#94a3b8;font-weight:400">(leave blank to keep current)</span> @endif
                    </label>
                    <div style="position:relative">
                        <input type="password" name="password" id="field-password"
                               placeholder="{{ $isEdit ? 'Enter new password' : 'Enter password' }}"
                               class="form-input {{ $errors->has('password') ? 'is-error' : '' }}"
                               style="padding-right:40px" />
                        <!-- Begin: Toggle Password Visibility -->
                        <button type="button" id="toggle-password"
                                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);color:#94a3b8;background:none;border:none;cursor:pointer;padding:2px"
                                onclick="togglePassword('field-password','toggle-password')">
                            <svg style="width:17px;height:17px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                        <!-- End: Toggle Password Visibility -->
                    </div>
                    @error('password') <p class="form-error">{{ $message }}</p>
                    @else <p class="form-hint">Minimum 8 characters.</p> @enderror
                </div>
                <!-- End: Field Password -->

                <!-- Begin: Field Confirm Password -->
                <div>
                    <label class="form-label">Confirm Password <span style="color:#ef4444">*</span></label>
                    <div style="position:relative">
                        <input type="password" name="password_confirmation" id="field-confirm"
                               placeholder="Confirm password"
                               class="form-input {{ $errors->has('password_confirmation') ? 'is-error' : '' }}"
                               style="padding-right:40px" />
                        <button type="button"
                                style="position:absolute;right:12px;top:50%;transform:translateY(-50%);color:#94a3b8;background:none;border:none;cursor:pointer;padding:2px"
                                onclick="togglePassword('field-confirm','this')">
                            <svg style="width:17px;height:17px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation') <p class="form-error">{{ $message }}</p>
                    @else <p class="form-hint">Password must match.</p> @enderror
                </div>
                <!-- End: Field Confirm Password -->

                <!-- Begin: Field Phone -->
                <div>
                    <label class="form-label">Phone Number (Optional)</label>
                    <input type="text" name="phone" value="{{ $phone }}"
                           placeholder="Enter phone number"
                           class="form-input {{ $errors->has('phone') ? 'is-error' : '' }}" />
                    @error('phone') <p class="form-error">{{ $message }}</p>
                    @else <p class="form-hint">Include country code (e.g., +62 812 3456 7890).</p> @enderror
                </div>
                <!-- End: Field Phone -->

            </div>
            <!-- End: Fields Grid -->

        </div>
        <!-- End: Section User Information -->

        <!-- Begin: Section Role & Access -->
        <div style="background:#fff;border-radius:16px;border:1.5px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,.04);padding:24px;margin-bottom:24px">

            <!-- Begin: Section Title -->
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px">
                <span style="width:24px;height:24px;background:#2563eb;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                    <svg style="width:13px;height:13px" fill="white" viewBox="0 0 24 24">
                        <path d="M17 11c.34 0 .67.03 1 .08V6.27L10.5 3 3 6.27v4.91c0 4.54 3.2 8.79 7.5 9.82.55-.13 1.08-.32 1.6-.55A6.99 6.99 0 0117 11z"/>
                        <path d="M17 13c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 1.38c.62 0 1.12.5 1.12 1.12s-.5 1.12-1.12 1.12-1.12-.5-1.12-1.12.5-1.12 1.12-1.12zm0 5.37c-.93 0-1.74-.46-2.24-1.17.05-.72 1.51-1.08 2.24-1.08s2.19.36 2.24 1.08c-.5.71-1.31 1.17-2.24 1.17z"/>
                    </svg>
                </span>
                <h2 style="font-size:.9375rem;font-weight:700;color:#1e293b">Role & Access</h2>
            </div>
            <p style="font-size:.75rem;color:#94a3b8;margin-bottom:20px;padding-left:34px">Define user role and system access level.</p>
            <!-- End: Section Title -->

            <!-- Begin: Role Select -->
            <div style="max-width:440px;margin-bottom:20px">
                <label class="form-label">Role <span style="color:#ef4444">*</span></label>
                <select name="role" id="field-role"
                        class="form-input {{ $errors->has('role') ? 'is-error' : '' }}"
                        style="cursor:pointer" onchange="updateRolePreview()">
                    <option value="">Select role</option>
                    @foreach($roles as $val => [$label, $bg, $color, $desc])
                        <option value="{{ $val }}" {{ $role === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('role') <p class="form-error">{{ $message }}</p>
                @else <p class="form-hint">Choose the appropriate role for this user.</p> @enderror
            </div>
            <!-- End: Role Select -->

            <!-- Begin: Status & Send Email Row -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">

                <!-- Begin: Status Radios -->
                <div>
                    <label class="form-label">Status <span style="color:#ef4444">*</span></label>
                    <div style="display:flex;gap:12px;margin-top:4px">

                        <!-- Begin: Option Active -->
                        <label style="cursor:pointer;flex:1">
                            <input type="radio" name="status" value="active" class="sr-only user-status-radio"
                                   {{ $status === 'active' ? 'checked' : '' }} />
                            <div class="status-card {{ $status === 'active' ? 'selected' : '' }}" id="usr-card-active">
                                <div style="display:flex;align-items:center;gap:8px">
                                    <div class="radio-dot {{ $status === 'active' ? 'checked' : '' }}" id="usr-dot-active">
                                        <div class="radio-dot-inner"></div>
                                    </div>
                                    <p style="font-size:.8125rem;font-weight:600;color:#1e293b">Active</p>
                                </div>
                            </div>
                        </label>
                        <!-- End: Option Active -->

                        <!-- Begin: Option Inactive -->
                        <label style="cursor:pointer;flex:1">
                            <input type="radio" name="status" value="inactive" class="sr-only user-status-radio"
                                   {{ $status === 'inactive' ? 'checked' : '' }} />
                            <div class="status-card {{ $status === 'inactive' ? 'selected' : '' }}" id="usr-card-inactive">
                                <div style="display:flex;align-items:center;gap:8px">
                                    <div class="radio-dot {{ $status === 'inactive' ? 'checked' : '' }}" id="usr-dot-inactive">
                                        <div class="radio-dot-inner"></div>
                                    </div>
                                    <p style="font-size:.8125rem;font-weight:600;color:#1e293b">Inactive</p>
                                </div>
                            </div>
                        </label>
                        <!-- End: Option Inactive -->

                    </div>
                </div>
                <!-- End: Status Radios -->

                @if(!$isEdit)
                <!-- Begin: Send Email Notification -->
                <div style="display:flex;align-items:center;padding-top:26px">
                    <label style="display:flex;align-items:flex-start;gap:10px;cursor:pointer">
                        <input type="checkbox" name="send_email" value="1"
                               style="width:16px;height:16px;margin-top:2px;accent-color:#2563eb;cursor:pointer"
                               {{ old('send_email') ? 'checked' : '' }} />
                        <div>
                            <p style="font-size:.875rem;font-weight:600;color:#1e293b">Send email notification</p>
                            <p style="font-size:.75rem;color:#94a3b8;margin-top:2px">Send login information to the user via email.</p>
                        </div>
                    </label>
                </div>
                <!-- End: Send Email Notification -->
                @endif

            </div>
            <!-- End: Status & Send Email Row -->

        </div>
        <!-- End: Section Role & Access -->

        <!-- Begin: Form Action Buttons -->
        <div style="display:flex;justify-content:flex-end;align-items:center;gap:12px">
            <a href="{{ route('users.index') }}"
               style="padding:10px 20px;font-size:.875rem;font-weight:600;color:#4b5563;background:#fff;border:1.5px solid #e5e7eb;border-radius:12px;text-decoration:none;transition:background .15s"
               onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">
                Cancel
            </a>
            <button type="submit" id="usr-submitBtn"
                    style="display:inline-flex;align-items:center;gap:8px;padding:10px 24px;background:#2563eb;color:#fff;font-size:.875rem;font-weight:600;border-radius:12px;border:none;cursor:pointer;box-shadow:0 2px 8px rgba(37,99,235,.25);transition:background .15s;font-family:'Plus Jakarta Sans',sans-serif"
                    onmouseover="this.style.background='#1d4ed8'" onmouseout="if(!this.disabled)this.style.background='#2563eb'">
                <!-- Begin: Submit Spinner -->
                <svg id="usr-spinner" style="display:none;width:16px;height:16px;animation:spin .65s linear infinite" fill="none" viewBox="0 0 24 24">
                    <circle style="opacity:.25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                    <path style="opacity:.75" fill="white" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <!-- End: Submit Spinner -->
                <!-- Begin: Submit Icon -->
                <svg id="usr-icon" style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <!-- End: Submit Icon -->
                <span id="usr-submitText">{{ $isEdit ? 'Update User' : 'Create User' }}</span>
            </button>
        </div>
        <!-- End: Form Action Buttons -->

    </div>
    <!-- End: Left Column -->

    <!-- Begin: Right Column -->
    <div style="display:flex;flex-direction:column;gap:16px;position:sticky;top:24px">

        <!-- Begin: User Guidelines Card -->
        <div style="background:#fff;border-radius:16px;border:1.5px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,.04);padding:20px">
            <p style="font-size:.9375rem;font-weight:700;color:#1e293b;margin-bottom:4px">User Guidelines</p>
            <p style="font-size:.75rem;color:#94a3b8;margin-bottom:16px">Ensure the information is accurate before creating the user.</p>
            <div style="display:flex;flex-direction:column;gap:10px">
                @foreach(['Use a valid and active email address.','Username must be unique.','Assign the correct role based on the user\'s responsibilities.','The user will receive an email with login information if notification is enabled.'] as $tip)
                    <div style="display:flex;align-items:flex-start;gap:8px">
                        <svg style="width:16px;height:16px;color:#22c55e;flex-shrink:0;margin-top:1px" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p style="font-size:.8125rem;color:#475569;line-height:1.5">{{ $tip }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- End: User Guidelines Card -->

        <!-- Begin: Role Overview Card -->
        <div style="background:#fff;border-radius:16px;border:1.5px solid #f1f5f9;box-shadow:0 1px 4px rgba(0,0,0,.04);padding:20px">
            <p style="font-size:.9375rem;font-weight:700;color:#1e293b;margin-bottom:4px">Role Overview</p>
            <p style="font-size:.75rem;color:#94a3b8;margin-bottom:16px">Summary of available system roles.</p>
            <div style="display:flex;flex-direction:column;gap:12px">

                <!-- Begin: Role Admin -->
                <div>
                    <span style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;background:#ede9fe;color:#6d28d9;margin-bottom:4px">Administrator</span>
                    <p style="font-size:.8rem;color:#64748b">Full system access and configuration.</p>
                </div>
                <!-- End: Role Admin -->

                <!-- Begin: Role User -->
                <div>
                    <span style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;background:#dbeafe;color:#1d4ed8;margin-bottom:4px">User</span>
                    <p style="font-size:.8rem;color:#64748b">Standard access to view and input data.</p>
                </div>
                <!-- End: Role User -->

            </div>
        </div>
        <!-- End: Role Overview Card -->

        <!-- Begin: Need Help Card -->
        <div style="background:#f8fafc;border-radius:16px;border:1.5px solid #f1f5f9;padding:20px;text-align:center">
            <div style="width:40px;height:40px;background:#dbeafe;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px">
                <svg style="width:20px;height:20px;color:#2563eb" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                </svg>
            </div>
            <p style="font-size:.875rem;font-weight:700;color:#1e293b;margin-bottom:4px">Need Help?</p>
            <p style="font-size:.75rem;color:#64748b;margin-bottom:12px">Check our documentation or contact support</p>
            <button style="padding:8px 16px;background:#fff;border:1.5px solid #e2e8f0;border-radius:8px;font-size:.8rem;font-weight:600;color:#2563eb;cursor:pointer;width:100%">
                View Help Center
            </button>
        </div>
        <!-- End: Need Help Card -->

    </div>
    <!-- End: Right Column -->

</div>
<!-- End: Two Column Layout -->

@push('scripts')
<script>
    /** Toggle password field visibility */
    function togglePassword(fieldId, btnEl) {
        var field = document.getElementById(fieldId);
        if (!field) return;
        field.type = field.type === 'password' ? 'text' : 'password';
    }

    // Status radio interactivity
    document.querySelectorAll('.user-status-radio').forEach(function (radio) {
        radio.addEventListener('change', function () {
            var val = this.value;
            ['active', 'inactive'].forEach(function (v) {
                var card = document.getElementById('usr-card-' + v);
                var dot  = document.getElementById('usr-dot-'  + v);
                if (card) card.classList.remove('selected');
                if (dot)  dot.classList.remove('checked');
            });
            var card = document.getElementById('usr-card-' + val);
            var dot  = document.getElementById('usr-dot-'  + val);
            if (card) card.classList.add('selected');
            if (dot)  dot.classList.add('checked');
        });
    });

    // Submit loading state
    var form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function () {
            var btn     = document.getElementById('usr-submitBtn');
            var spinner = document.getElementById('usr-spinner');
            var icon    = document.getElementById('usr-icon');
            var text    = document.getElementById('usr-submitText');
            if (btn) {
                btn.disabled = true; btn.style.opacity = '.8'; btn.style.cursor = 'not-allowed';
                if (spinner) spinner.style.display = 'block';
                if (icon)    icon.style.display    = 'none';
                if (text)    text.textContent      = '{{ $isEdit ? "Updating..." : "Creating..." }}';
            }
        });
    }
</script>
@endpush