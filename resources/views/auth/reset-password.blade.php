<!DOCTYPE html>
<!-- Begin: HTML Document -->
<html lang="en">

<!-- Begin: Head -->
<head>
    <!-- Begin: Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- End: Meta Tags -->

    <!-- Begin: Title -->
    <title>Reset Password | Vital Trackers</title>
    <!-- End: Title -->

    <!-- Begin: Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- End: Vite Assets -->

    <!-- Begin: Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- End: Fonts -->

    <!-- Begin: Custom Styles -->
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            width: 100%; height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow: hidden;
        }

        /* ════════════════════════════════
           LAYOUT
        ════════════════════════════════ */
        .layout {
            display: flex;
            width: 100vw;
            height: 100vh;
        }

        /* ── LEFT  40% ── */
        .left {
            width: 40%;
            height: 100%;
            background: linear-gradient(160deg, #D6E8FF 0%, #EBF3FF 50%, #C8DCFF 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            padding: 48px 64px;
            overflow: hidden;
        }

        /* decorative blobs */
        .left::before {
            content: '';
            position: absolute; bottom: -120px; left: -120px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(37,99,235,.10) 0%, transparent 65%);
            border-radius: 50%; pointer-events: none;
        }
        .left::after {
            content: '';
            position: absolute; top: -80px; right: 80px;
            width: 360px; height: 360px;
            background: radial-gradient(circle, rgba(37,99,235,.07) 0%, transparent 65%);
            border-radius: 50%; pointer-events: none;
        }

        /* brand */
        .brand {
            display: flex; align-items: center; gap: 10px;
            font-size: 15px; font-weight: 700; color: #1E3A5F;
            position: relative; z-index: 1;
            flex-shrink: 0;
        }
        .brand-icon {
            width: 34px; height: 34px;
            background: #2563EB; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
        }
        .brand-icon svg { width: 20px; height: 20px; }

        /* hero body */
        .left-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative; z-index: 1;
        }

        .left-headline {
            font-size: clamp(32px, 3.2vw, 48px);
            font-weight: 800;
            color: #1A355E;
            line-height: 1.15;
            margin-bottom: 18px;
        }
        .left-sub {
            font-size: 15px; color: #4A6FA5;
            line-height: 1.75; max-width: 320px;
        }

        /* illustration area */
        .illus {
            margin-top: 48px;
            display: flex;
            align-items: flex-end;
            gap: 24px;
        }

        .illus-main {
            width: clamp(200px, 22vw, 300px);
            height: clamp(200px, 22vw, 300px);
            flex-shrink: 0;
        }
        .illus-main svg { width: 100%; height: 100%; }

        .dots-card {
            background: #fff;
            border-radius: 18px;
            padding: 18px 24px;
            display: flex; align-items: center; gap: 14px;
            box-shadow: 0 12px 40px rgba(37,99,235,.14);
            flex-shrink: 0;
            margin-bottom: 16px;
        }
        .dot-row { display: flex; gap: 12px; align-items: center; }
        .dot {
            width: 26px; height: 26px; border-radius: 50%;
            background: #BFDBFE;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; color: #2563EB; font-weight: 700;
        }
        .check-badge {
            width: 34px; height: 34px; border-radius: 50%;
            background: #2563EB;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 16px; font-weight: 700;
        }

        /* ── RIGHT  60% ── */
        .right {
            width: 60%;
            height: 100%;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
            flex-shrink: 0;
        }

        .form-box {
            width: 100%;
            max-width: 420px;
            padding: 40px 48px;
        }

        /* icon circle */
        .form-icon {
            width: 72px; height: 72px;
            background: #EBF3FF;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 24px;
        }
        .form-icon svg { width: 38px; height: 38px; }

        .form-title {
            font-size: 26px; font-weight: 800;
            color: #1A355E; margin-bottom: 8px;
        }
        .form-subtitle {
            font-size: 14px; color: #64748B;
            line-height: 1.65; margin-bottom: 32px;
        }

        /* fields */
        .field { margin-bottom: 20px; }
        .field label {
            display: block;
            font-size: 13px; font-weight: 600;
            color: #334155; margin-bottom: 8px;
        }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 16px; top: 50%;
            transform: translateY(-50%);
            color: #94A3B8; display: flex; pointer-events: none;
        }
        .input-icon svg { width: 17px; height: 17px; }

        .field input {
            width: 100%;
            padding: 14px 46px;
            border: 1.5px solid #E2E8F0;
            border-radius: 14px;
            font-size: 14px; font-family: inherit;
            color: #1E3A5F; background: #FAFCFF;
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .field input::placeholder { color: #94A3B8; }
        .field input:focus {
            border-color: #2563EB;
            box-shadow: 0 0 0 4px rgba(37,99,235,.09);
            background: #fff;
        }
        .field input.is-error { border-color: #ef4444; }
        .field input.is-error:focus { box-shadow: 0 0 0 4px rgba(239,68,68,.08); }

        .toggle-pw {
            position: absolute; right: 14px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: #94A3B8; padding: 4px; display: flex;
            transition: color .2s;
        }
        .toggle-pw:hover { color: #2563EB; }
        .toggle-pw svg { width: 17px; height: 17px; }

        .field-error {
            font-size: 12px; color: #ef4444;
            margin-top: 6px; font-weight: 500;
        }

        /* strength */
        .strength-wrap { margin-top: 10px; }
        .strength-bars { display: flex; gap: 6px; margin-bottom: 5px; }
        .strength-bar {
            flex: 1; height: 4px; border-radius: 99px;
            background: #E2E8F0; transition: background .3s;
        }
        .strength-bar.weak   { background: #ef4444; }
        .strength-bar.medium { background: #f59e0b; }
        .strength-bar.strong { background: #22c55e; }
        .strength-label { font-size: 12px; font-weight: 600; color: #94A3B8; }
        .strength-label.weak   { color: #ef4444; }
        .strength-label.medium { color: #f59e0b; }
        .strength-label.strong { color: #22c55e; }

        /* submit */
        .btn-submit {
            width: 100%; padding: 15px;
            background: #2563EB; color: #fff;
            border: none; border-radius: 14px;
            font-size: 15px; font-weight: 700; font-family: inherit;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            box-shadow: 0 4px 18px rgba(37,99,235,.30);
            transition: background .2s, box-shadow .2s, transform .15s;
            margin-top: 28px;
        }
        .btn-submit:hover {
            background: #1D4ED8;
            box-shadow: 0 8px 28px rgba(37,99,235,.38);
            transform: translateY(-1px);
        }
        .btn-submit:active { transform: none; }
        .btn-submit:disabled { opacity: .65; cursor: not-allowed; transform: none; }
        .btn-submit svg { width: 17px; height: 17px; }
        .btn-spinner {
            width: 17px; height: 17px;
            border: 2.5px solid rgba(255,255,255,.35);
            border-top-color: #fff; border-radius: 50%;
            animation: spin .7s linear infinite;
        }

        /* divider + back */
        .divider {
            display: flex; align-items: center; gap: 12px;
            margin: 20px 0 0; color: #CBD5E1; font-size: 12px;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px; background: #E2E8F0;
        }
        .back-login {
            display: flex; align-items: center; justify-content: center;
            gap: 6px; margin-top: 16px;
            font-size: 13px; color: #64748B;
            text-decoration: none; transition: color .2s;
        }
        .back-login:hover { color: #2563EB; }
        .back-login svg { width: 14px; height: 14px; }
        .blade-error { font-size: 12px; color: #ef4444; margin-top: 6px; font-weight: 500; }

        /* ════════════════════════════════
           TOAST
        ════════════════════════════════ */
        #toast {
            position: fixed; top: 24px; right: 24px; z-index: 9999;
            display: flex; align-items: center; gap: 12px;
            padding: 14px 20px; border-radius: 14px;
            font-size: 14px; font-weight: 600;
            box-shadow: 0 8px 32px rgba(0,0,0,.12);
            opacity: 0; transform: translateY(-12px);
            transition: opacity .35s, transform .35s;
            pointer-events: none; max-width: 360px;
            background: #fff;
        }
        #toast.show   { opacity: 1; transform: translateY(0); pointer-events: auto; }
        #toast.success{ color: #16a34a; border-left: 4px solid #16a34a; }
        #toast.error  { color: #dc2626; border-left: 4px solid #dc2626; }
        #toast.info   { color: #2563eb; border-left: 4px solid #2563eb; }
        .toast-close {
            margin-left: auto; background: none; border: none;
            cursor: pointer; color: inherit; opacity: .5; font-size: 15px; padding: 2px 4px;
        }
        .toast-close:hover { opacity: 1; }

        /* ════════════════════════════════
           LOADING OVERLAY
        ════════════════════════════════ */
        #loading-overlay {
            display: none; position: fixed; inset: 0; z-index: 9998;
            background: rgba(235,243,255,.75); backdrop-filter: blur(5px);
            align-items: center; justify-content: center;
        }
        #loading-overlay.active { display: flex; }
        .spinner-card {
            background: #fff; border-radius: 20px;
            padding: 32px 44px;
            display: flex; flex-direction: column; align-items: center; gap: 16px;
            box-shadow: 0 20px 60px rgba(37,99,235,.16);
        }
        .spinner {
            width: 44px; height: 44px;
            border: 4px solid #DBEAFE; border-top-color: #2563EB;
            border-radius: 50%; animation: spin .8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .spinner-label { font-size: 14px; font-weight: 600; color: #64748B; }

        /* ════════════════════════════════
           RESPONSIVE
        ════════════════════════════════ */
        @media (max-width: 900px) {
            html, body { overflow: auto; }
            .layout { flex-direction: column; height: auto; min-height: 100vh; }
            .left { width: 100%; height: auto; padding: 36px 28px; }
            .illus-main { width: 160px; height: 160px; }
            .right { width: 100%; height: auto; }
            .form-box { padding: 36px 28px; }
        }
    </style>
    <!-- End: Custom Styles -->
</head>
<!-- End: Head -->

<!-- Begin: Body -->
<body>

    <!-- Begin: Loading Overlay -->
    <div id="loading-overlay">
        <div class="spinner-card">
            <div class="spinner"></div>
            <span class="spinner-label">Resetting password…</span>
        </div>
    </div>
    <!-- End: Loading Overlay -->

    <!-- Begin: Toast Notification -->
    <div id="toast" role="alert">
        <span id="toast-icon"></span>
        <span id="toast-msg"></span>
        <button class="toast-close" onclick="closeToast()">✕</button>
    </div>
    <!-- End: Toast Notification -->

    <!-- Begin: Main Layout -->
    <div class="layout">

        <!-- Begin: Left Panel -->
        <div class="left">

            <!-- Begin: Brand -->
            <div class="brand">
                <div class="brand-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 12h3l3-8 4 16 3-9 2 5 3-4h2"/>
                    </svg>
                </div>
                Vital Trackers
            </div>
            <!-- End: Brand -->

            <!-- Begin: Hero Text & Illustration -->
            <div class="left-body">
                <h1 class="left-headline">Create a New<br>Password</h1>
                <p class="left-sub">Your new password must be strong and unique to keep your account safe and secure.</p>

                <div class="illus">
                    <!-- Begin: Shield Illustration -->
                    <div class="illus-main">
                        <svg viewBox="0 0 260 280" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <ellipse cx="120" cy="140" rx="110" ry="115" fill="rgba(37,99,235,.06)"/>
                            <ellipse cx="120" cy="140" rx="90"  ry="95"  fill="rgba(37,99,235,.07)"/>
                            <path d="M120 22L42 56v56c0 44 32 82 78 92 46-10 78-48 78-92V56L120 22z" fill="rgba(37,99,235,.18)"/>
                            <path d="M120 36L56 67v45c0 37 27 69 64 78 37-9 64-41 64-78V67L120 36z" fill="rgba(37,99,235,.30)"/>
                            <path d="M120 52L70 79v38c0 31 22 58 50 65 28-7 50-34 50-65V79L120 52z" fill="#2563EB" opacity=".85"/>
                            <rect x="101" y="106" width="38" height="30" rx="7" fill="#fff"/>
                            <path d="M109 106V98a11 11 0 0122 0v8" stroke="#fff" stroke-width="4" stroke-linecap="round" fill="none"/>
                            <circle cx="120" cy="121" r="4.5" fill="#2563EB"/>
                            <rect x="118" y="121" width="4" height="8" rx="2" fill="#2563EB"/>
                            <rect x="18" y="218" width="22" height="28" rx="5" fill="#93C5FD"/>
                            <ellipse cx="29" cy="246" rx="15" ry="5" fill="#60A5FA"/>
                            <path d="M29 218 Q18 196 6 194 Q11 210 29 218z"  fill="#4CAF50" opacity=".85"/>
                            <path d="M29 218 Q40 194 54 196 Q48 212 29 218z"  fill="#66BB6A" opacity=".80"/>
                            <path d="M29 210 Q20 190 10 188 Q15 204 29 210z"  fill="#81C784" opacity=".75"/>
                            <rect x="204" y="162" width="5" height="70" rx="2.5" fill="#CBD5E1"/>
                            <path d="M190 162 h34 l-8-36 h-18z" fill="#fff" stroke="#E2E8F0" stroke-width="1.5"/>
                            <rect x="196" y="232" width="22" height="7" rx="3.5" fill="#CBD5E1"/>
                        </svg>
                    </div>
                    <!-- End: Shield Illustration -->

                    <!-- Begin: Password Dots Card -->
                    <div class="dots-card">
                        <div class="dot-row">
                            <div class="dot">✱</div>
                            <div class="dot">✱</div>
                            <div class="dot">✱</div>
                            <div class="dot">✱</div>
                            <div class="check-badge">✓</div>
                        </div>
                    </div>
                    <!-- End: Password Dots Card -->
                </div>
            </div>
            <!-- End: Hero Text & Illustration -->

        </div>
        <!-- End: Left Panel -->

        <!-- Begin: Right Panel -->
        <div class="right">

            <!-- Begin: Form Box -->
            <div class="form-box">

                <!-- Begin: Form Icon -->
                <div class="form-icon">
                    <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="7" y="19" width="26" height="17" rx="5" fill="#BFDBFE"/>
                        <path d="M13 19V13a7 7 0 0114 0v6" stroke="#2563EB" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                        <circle cx="20" cy="28" r="3.5" fill="#2563EB"/>
                        <rect x="18.5" y="28" width="3" height="5" rx="1.5" fill="#2563EB"/>
                        <path d="M30 8 A13 13 0 0 1 38 20" stroke="#2563EB" stroke-width="2.5" stroke-linecap="round" fill="none"/>
                        <polyline points="27,6 30,8 28,11" stroke="#2563EB" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                </div>
                <!-- End: Form Icon -->

                <!-- Begin: Form Title -->
                <h2 class="form-title">Reset Your Password</h2>
                <p class="form-subtitle">Enter your new password below.<br>Make sure it's strong and secure.</p>
                <!-- End: Form Title -->

                <!-- Begin: Reset Password Form -->
                <form id="reset-form" method="POST" action="{{ route('password.store') }}" novalidate>

                    <!-- Begin: CSRF & Hidden Inputs -->
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <input type="hidden" name="email" value="{{ old('email', $request->email) }}">
                    <!-- End: CSRF & Hidden Inputs -->

                    <!-- Begin: New Password Field -->
                    <div class="field">
                        <label for="password">New Password</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
                                </svg>
                            </span>
                            <input type="password" id="password" name="password"
                                placeholder="Enter new password" required autofocus
                                class="{{ $errors->has('password') ? 'is-error' : '' }}">
                            <button type="button" class="toggle-pw" onclick="togglePw('password','icon-pw1')" tabindex="-1">
                                <svg id="icon-pw1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        <!-- End: New Password Field -->

                        <!-- Begin: Password Strength Meter -->
                        <div class="strength-wrap" id="strength-wrap" style="display:none">
                            <div class="strength-bars">
                                <div class="strength-bar" id="bar1"></div>
                                <div class="strength-bar" id="bar2"></div>
                                <div class="strength-bar" id="bar3"></div>
                                <div class="strength-bar" id="bar4"></div>
                            </div>
                            <span class="strength-label" id="strength-label"></span>
                        </div>
                        <!-- End: Password Strength Meter -->

                        @error('password')
                            <p class="blade-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Begin: Confirm Password Field -->
                    <div class="field">
                        <label for="password_confirmation">Confirm New Password</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
                                </svg>
                            </span>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                placeholder="Confirm new password" required>
                            <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation','icon-pw2')" tabindex="-1">
                                <svg id="icon-pw2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        <div id="confirm-error" class="field-error" style="display:none">Passwords do not match.</div>
                    </div>
                    <!-- End: Confirm Password Field -->

                    <!-- Begin: Submit Button -->
                    <button type="submit" class="btn-submit" id="btn-submit">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
                        </svg>
                        Reset Password
                    </button>
                    <!-- End: Submit Button -->

                </form>
                <!-- End: Reset Password Form -->

                <!-- Begin: Divider -->
                <div class="divider">or</div>
                <!-- End: Divider -->

                <!-- Begin: Back to Login Link -->
                <a href="{{ route('login') }}" class="back-login">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                    Back to Login
                </a>
                <!-- End: Back to Login Link -->

            </div>
            <!-- End: Form Box -->

        </div>
        <!-- End: Right Panel -->

    </div>
    <!-- End: Main Layout -->

    <!-- Begin: Laravel Session Flashes -->
    @if (session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', () =>
                showToast('success', '✓', '{{ session('status') }}'));
        </script>
    @endif
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', () =>
                showToast('error', '✕', '{{ $errors->first() }}'));
        </script>
    @endif
    <!-- End: Laravel Session Flashes -->

    <!-- Begin: Scripts -->
    <script>
        /* ── Show/hide password ── */
        // SVG path strings for eye open and eye closed states
        const EYE_OPEN   = `<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/>`;
        const EYE_CLOSED = `<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>`;

        // Toggle password visibility and swap the eye icon
        function togglePw(fieldId, iconId) {
            const el = document.getElementById(fieldId);
            const show = el.type === 'password';
            el.type = show ? 'text' : 'password';
            document.getElementById(iconId).innerHTML = show ? EYE_CLOSED : EYE_OPEN;
        }

        /* ── Password strength meter ── */
        const pwInput      = document.getElementById('password');
        const strengthWrap = document.getElementById('strength-wrap');
        const strengthLbl  = document.getElementById('strength-label');
        const bars = ['bar1','bar2','bar3','bar4'].map(id => document.getElementById(id));

        // Calculate password strength based on length, case, numbers, and special chars
        function calcStrength(v) {
            let s = 0;
            if (v.length >= 8)  s++;
            if (v.length >= 12) s++;
            if (/[A-Z]/.test(v) && /[a-z]/.test(v)) s++;
            if (/[0-9]/.test(v)) s++;
            if (/[^A-Za-z0-9]/.test(v)) s++;

            // Map score to strength level, filled bars, and label
            if (s <= 1) return { level:'weak',   filled:1, label:'Weak' };
            if (s <= 2) return { level:'medium', filled:2, label:'Medium' };
            if (s <= 3) return { level:'medium', filled:3, label:'Good' };
            return             { level:'strong', filled:4, label:'Strong' };
        }

        // Update strength meter UI on input
        pwInput.addEventListener('input', function() {
            if (!this.value) { strengthWrap.style.display = 'none'; return; }
            strengthWrap.style.display = 'block';
            const { level, filled, label } = calcStrength(this.value);
            bars.forEach((b, i) => { b.className = 'strength-bar' + (i < filled ? ' '+level : ''); });
            strengthLbl.className = 'strength-label ' + level;
            strengthLbl.textContent = 'Password strength: ' + label;
        });

        /* ── Confirm password match ── */
        const confirmInput = document.getElementById('password_confirmation');
        const confirmErr   = document.getElementById('confirm-error');

        // Check if confirm password matches the original password on input
        confirmInput.addEventListener('input', function() {
            const mismatch = this.value && this.value !== pwInput.value;
            confirmErr.style.display = mismatch ? 'block' : 'none';
            this.classList.toggle('is-error', mismatch);
        });

        /* ── Form submission ── */
        // Validate inputs before submission and trigger loading state
        document.getElementById('reset-form').addEventListener('submit', function(e) {
            const pw  = pwInput.value.trim();
            const cpw = confirmInput.value.trim();

            // Basic client-side validation
            if (!pw || !cpw)   { e.preventDefault(); showToast('error','✕','Please fill in all fields.'); return; }
            if (pw !== cpw)    { e.preventDefault(); showToast('error','✕','Passwords do not match.'); return; }
            if (pw.length < 8) { e.preventDefault(); showToast('error','✕','Password must be at least 8 characters.'); return; }

            // Show loading overlay and disable submit button
            document.getElementById('loading-overlay').classList.add('active');
            const btn = document.getElementById('btn-submit');
            btn.disabled = true;
            btn.innerHTML = '<div class="btn-spinner"></div> Resetting…';
        });

        /* ── Toast notification system ── */
        let _tt = null;

        // Display a toast notification with a specific type, icon, and message
        function showToast(type, icon, msg, dur = 4500) {
            const t = document.getElementById('toast');
            document.getElementById('toast-icon').textContent = icon;
            document.getElementById('toast-msg').textContent  = msg;
            t.className = 'show ' + type;
            clearTimeout(_tt);
            _tt = setTimeout(closeToast, dur);
        }

        // Hide the toast notification
        function closeToast() {
            document.getElementById('toast').classList.remove('show');
        }
    </script>
    <!-- End: Scripts -->

</body>
<!-- End: Body -->
</html>
<!-- End: HTML Document -->
