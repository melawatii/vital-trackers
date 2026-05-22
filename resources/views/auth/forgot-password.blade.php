<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Vital Trackers</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: #eef4ff;
            overflow-x: hidden;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* ══════════════════════════════════
           LEFT PANEL
        ══════════════════════════════════ */
        .left-panel {
            display: none;
            width: 44%;
            flex-shrink: 0;
            background: linear-gradient(155deg, #c8dfff 0%, #d8ebff 45%, #b8d4ff 100%);
            position: relative;
            overflow: hidden;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 52px 0;
        }
        @media (min-width: 1024px) { .left-panel { display: flex; } }

        /* blobs */
        .blob-tr {
            position: absolute; top: -90px; right: -90px;
            width: 340px; height: 340px; border-radius: 50%;
            background: rgba(186,214,255,0.50);
        }
        .blob-ml {
            position: absolute; top: 40%; left: -50px;
            width: 180px; height: 180px; border-radius: 50%;
            background: rgba(255,255,255,0.20);
        }

        /* logo */
        .logo-row {
            display: flex; align-items: center; gap: 10px;
            position: relative; z-index: 2;
        }
        .logo-name { font-size: 1rem; font-weight: 700; color: #1e40af; }

        /* hero text */
        .hero {
            position: relative; z-index: 2;
            margin-top: 52px;
        }
        .hero h1 {
            font-size: clamp(1.8rem, 3vw, 2.6rem);
            font-weight: 800; color: #1e293b; line-height: 1.2;
        }
        .hero p {
            margin-top: 16px; font-size: .93rem;
            color: #475569; line-height: 1.7; max-width: 320px;
        }

        /* illustration */
        .illustration {
            position: relative; z-index: 2;
            flex: 1;
            display: flex; align-items: flex-end; justify-content: center;
            padding-bottom: 0;
        }
        .illustration svg { width: 100%; max-width: 400px; }

        /* trust badge */
        .trust-badge {
            position: relative; z-index: 2;
            display: flex; align-items: flex-start; gap: 14px;
            background: rgba(255,255,255,0.60);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.55);
            border-radius: 20px;
            padding: 18px 20px;
            margin-bottom: 36px;
        }
        .badge-icon {
            width: 44px; height: 44px; flex-shrink: 0;
            border-radius: 12px;
            background: #2563eb;
            display: flex; align-items: center; justify-content: center;
        }
        .badge-icon svg { width: 20px; height: 20px; color: #fff; }
        .badge-text h4 { font-size: .87rem; font-weight: 700; color: #1e293b; }
        .badge-text p  { font-size: .78rem; color: #64748b; margin-top: 3px; line-height: 1.5; }

        /* ══════════════════════════════════
           RIGHT PANEL
        ══════════════════════════════════ */
        .right-panel {
            flex: 1;
            display: flex; align-items: center; justify-content: center;
            padding: 40px 24px;
            background: #eef4ff;
        }

        .card {
            width: 100%; max-width: 500px;
            background: #fff;
            border-radius: 28px;
            box-shadow: 0 12px 48px rgba(37,99,235,.09);
            padding: 48px 48px 44px;
            display: flex; flex-direction: column; align-items: center;
            text-align: center;
        }
        @media (max-width: 560px) { .card { padding: 36px 24px 32px; border-radius: 22px; } }

        /* mail icon circle */
        .mail-circle {
            width: 90px; height: 90px;
            border-radius: 50%;
            background: #eff6ff;
            display: flex; align-items: center; justify-content: center;
            position: relative;
            margin-bottom: 24px;
        }
        .mail-circle svg { width: 40px; height: 40px; color: #2563eb; }
        /* decorative dots */
        .mail-circle::before,
        .mail-circle::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: #bfdbfe;
        }
        .mail-circle::before { width: 9px; height: 9px; top: 8px; right: -4px; }
        .mail-circle::after  { width: 6px; height: 6px; bottom: 10px; right: -10px; }

        /* dot cluster top-left of circle */
        .dot-tl {
            position: absolute; width: 7px; height: 7px;
            background: #bfdbfe; border-radius: 50%;
            top: 6px; left: -8px;
        }

        .card-heading { margin-bottom: 28px; }
        .card-heading h2 { font-size: 1.65rem; font-weight: 800; color: #1e293b; }
        .card-heading p  { margin-top: 10px; font-size: .88rem; color: #64748b; line-height: 1.6; max-width: 320px; }

        /* alert */
        .alert-banner {
            width: 100%;
            border-radius: 14px; padding: 13px 16px;
            font-size: .84rem; font-weight: 500;
            margin-bottom: 20px;
            display: flex; align-items: flex-start; gap: 10px;
            text-align: left;
        }
        .alert-banner.success { background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0; }
        .alert-banner.error   { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }
        .alert-banner svg { width:16px; height:16px; flex-shrink:0; margin-top:1px; }

        /* form */
        .card form { width: 100%; }

        .form-group { margin-bottom: 20px; text-align: left; }
        .form-label {
            display: block; font-size: .82rem; font-weight: 600;
            color: #475569; margin-bottom: 8px;
        }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; pointer-events: none;
        }
        .input-icon svg { width: 17px; height: 17px; display: block; }

        .form-input {
            width: 100%;
            padding: 14px 16px 14px 46px;
            border-radius: 14px;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            font-family: inherit; font-size: .9rem; color: #1e293b;
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .form-input::placeholder { color: #94a3b8; }
        .form-input:focus {
            border-color: #60a5fa; background: #fff;
            box-shadow: 0 0 0 4px rgba(96,165,250,.12);
        }

        .field-error { font-size: .78rem; color: #ef4444; margin-top: 6px; }

        /* submit */
        .btn-submit {
            width: 100%; padding: 15px;
            border-radius: 14px; border: none;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: #fff;
            font-family: inherit; font-size: .93rem; font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(37,99,235,.28);
            transition: filter .2s, transform .15s, box-shadow .2s;
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .btn-submit:hover:not(:disabled) {
            filter: brightness(1.08);
            transform: translateY(-1px);
            box-shadow: 0 10px 28px rgba(37,99,235,.36);
        }
        .btn-submit:active:not(:disabled) { transform: translateY(0); }
        .btn-submit:disabled { opacity: .72; cursor: not-allowed; }
        .btn-submit svg.btn-icon { width: 18px; height: 18px; }

        .spinner {
            display: none;
            width: 18px; height: 18px;
            border: 2.5px solid rgba(255,255,255,.35);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }
        .btn-submit.loading .spinner { display: block; }
        .btn-submit.loading .btn-icon { display: none; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* divider */
        .divider {
            display: flex; align-items: center; gap: 14px;
            margin: 22px 0 18px;
            font-size: .8rem; color: #94a3b8;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1;
            height: 1px; background: #e2e8f0;
        }

        /* back to login */
        .back-link {
            display: inline-flex; align-items: center; gap: 8px;
            font-size: .88rem; font-weight: 700;
            color: #2563eb; text-decoration: none;
            transition: gap .2s, color .2s;
        }
        .back-link:hover { color: #1d4ed8; gap: 12px; }
        .back-link svg { width: 16px; height: 16px; }

        /* ── TOAST ── */
        #toast-container {
            position: fixed; top: 24px; right: 24px; z-index: 9999;
            display: flex; flex-direction: column; gap: 12px;
            pointer-events: none;
        }
        .toast {
            min-width: 300px; max-width: 380px;
            display: flex; align-items: flex-start; gap: 12px;
            padding: 16px 18px;
            border-radius: 16px; background: #fff;
            box-shadow: 0 8px 32px rgba(0,0,0,.12);
            pointer-events: all;
            animation: toastIn .35s cubic-bezier(.34,1.56,.64,1) forwards;
            font-size: .875rem;
        }
        .toast.toast-error   { border-left: 4px solid #ef4444; }
        .toast.toast-success { border-left: 4px solid #22c55e; }
        .toast.toast-info    { border-left: 4px solid #3b82f6; }
        .toast-icon svg { width: 18px; height: 18px; display: block; }
        .toast.toast-error   .toast-icon svg { color: #ef4444; }
        .toast.toast-success .toast-icon svg { color: #22c55e; }
        .toast.toast-info    .toast-icon svg { color: #3b82f6; }
        .toast-body { flex: 1; }
        .toast-title { font-weight: 700; color: #1e293b; margin-bottom: 2px; }
        .toast-msg   { color: #64748b; line-height: 1.45; }
        .toast-close {
            background: none; border: none; cursor: pointer;
            color: #94a3b8; font-size: 1.1rem; line-height: 1;
            padding: 0; transition: color .2s;
        }
        .toast-close:hover { color: #475569; }
        .toast.hiding { animation: toastOut .3s ease forwards; }
        @keyframes toastIn {
            from { opacity:0; transform:translateX(60px) scale(.95); }
            to   { opacity:1; transform:translateX(0) scale(1); }
        }
        @keyframes toastOut {
            from { opacity:1; transform:translateX(0); max-height:200px; }
            to   { opacity:0; transform:translateX(60px); max-height:0; padding:0; margin:0; }
        }
    </style>
</head>
<body>

<div id="toast-container"></div>

<div class="layout">

    <!-- ════════════ LEFT PANEL ════════════ -->
    <div class="left-panel">
        <div class="blob-tr"></div>
        <div class="blob-ml"></div>

        <!-- Logo -->
        <div class="logo-row">
            <svg width="38" height="38" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="40" height="40" rx="10" fill="white" fill-opacity="0.7"/>
                <path d="M20 30.5C20 30.5 8 23.5 8 15.5C8 12.467 10.467 10 13.5 10C15.524 10 17.291 11.09 18.25 12.727C19.209 11.09 20.976 10 23 10C26.033 10 28.5 12.467 28.5 15.5C28.5 23.5 20 30.5 20 30.5Z" fill="#2563eb" stroke="#2563eb" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 19h4l2-5 3 9 2-7 2 3h3" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="logo-name">Vital Trackers</span>
        </div>

        <!-- Hero -->
        <div class="hero">
            <h1>Reset Your<br>Password</h1>
            <p>No worries! Enter your email address and we'll send you a link to reset your password securely.</p>
        </div>

        <!-- Illustration -->
        <div class="illustration">
            <svg viewBox="0 0 400 280" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- desk -->
                <rect x="0" y="240" width="400" height="40" fill="#ccdff5" rx="0"/>

                <!-- plant pot -->
                <rect x="18" y="210" width="36" height="32" rx="7" fill="#b8cfe8"/>
                <rect x="13" y="205" width="46" height="10" rx="5" fill="#cee0f5"/>
                <!-- plant stem -->
                <rect x="34" y="165" width="4" height="44" rx="2" fill="#68b88a"/>
                <!-- leaves -->
                <ellipse cx="36" cy="178" rx="20" ry="13" fill="#7ac89a" transform="rotate(-28 36 178)"/>
                <ellipse cx="36" cy="163" rx="18" ry="12" fill="#8dd4a8" transform="rotate(22 36 163)"/>
                <ellipse cx="36" cy="150" rx="16" ry="10" fill="#a0deB8" transform="rotate(-12 36 150)"/>

                <!-- envelope body -->
                <rect x="120" y="110" width="180" height="135" rx="14" fill="#90bbf0"/>
                <!-- envelope flap open -->
                <path d="M120 124 L210 175 L300 124" fill="none" stroke="#b8d4f8" stroke-width="2"/>
                <!-- envelope flap top -->
                <path d="M120 110 L210 162 L300 110 Z" fill="#b8d4f8" stroke="#90bbf0" stroke-width="1"/>

                <!-- letter inside envelope -->
                <rect x="145" y="130" width="130" height="90" rx="8" fill="white" opacity=".92"/>
                <!-- lock icon on letter -->
                <rect x="192" y="160" width="36" height="30" rx="6" fill="#4a8ae0"/>
                <path d="M200 160 v-8 a10 10 0 0 1 20 0 v8" stroke="#4a8ae0" stroke-width="5" stroke-linecap="round" fill="none"/>
                <circle cx="210" cy="175" r="4" fill="white"/>
                <rect x="208" y="175" width="4" height="7" rx="2" fill="white"/>

                <!-- checkmark circle -->
                <circle cx="298" cy="128" r="22" fill="#3b82f6"/>
                <circle cx="298" cy="128" r="22" fill="white" opacity=".15"/>
                <path d="M288 128 l7 7 14-14" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>

                <!-- calendar -->
                <rect x="318" y="165" width="72" height="72" rx="10" fill="white" opacity=".88"/>
                <rect x="318" y="165" width="72" height="22" rx="10" fill="#ccdff5"/>
                <rect x="318" y="176" width="72" height="11" rx="0" fill="#ccdff5"/>
                <!-- rings -->
                <rect x="340" y="159" width="6" height="14" rx="3" fill="#94b8d8"/>
                <rect x="360" y="159" width="6" height="14" rx="3" fill="#94b8d8"/>
                <!-- grid dots -->
                <rect x="330" y="196" width="8" height="8" rx="2" fill="#b8d0e8"/>
                <rect x="345" y="196" width="8" height="8" rx="2" fill="#b8d0e8"/>
                <rect x="360" y="196" width="8" height="8" rx="2" fill="#b8d0e8"/>
                <rect x="330" y="210" width="8" height="8" rx="2" fill="#b8d0e8"/>
                <rect x="345" y="210" width="8" height="8" rx="2" fill="#ccdff5"/>
                <rect x="360" y="210" width="8" height="8" rx="2" fill="#b8d0e8"/>
                <rect x="330" y="224" width="8" height="8" rx="2" fill="#b8d0e8"/>
                <rect x="345" y="224" width="8" height="8" rx="2" fill="#b8d0e8"/>
            </svg>
        </div>

        <!-- Trust Badge -->
        <div class="trust-badge">
            <div class="badge-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <div class="badge-text">
                <h4>Secure &amp; Private</h4>
                <p>Your account is important to us.<br>We'll keep your data safe and protected.</p>
            </div>
        </div>
    </div>

    <!-- ════════════ RIGHT PANEL ════════════ -->
    <div class="right-panel">
        <div class="card">

            <!-- Mail icon -->
            <div class="mail-circle">
                <span class="dot-tl"></span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>

            <!-- Heading -->
            <div class="card-heading">
                <h2>Forgot Password?</h2>
                <p>Enter your email address and we'll send you a link to reset your password.</p>
            </div>

            <!-- Session status -->
            @if (session('status'))
                <div class="alert-banner success">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-banner error">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('password.email') }}" id="forgot-form">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email Address</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-input {{ $errors->has('email') ? 'has-error' : '' }}"
                            placeholder="Enter your email"
                            required
                            autofocus
                        >
                    </div>
                    @error('email')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit" id="submit-btn">
                    <span class="spinner" id="spinner"></span>
                    <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    <span id="btn-text">Send Reset Link</span>
                </button>

                <!-- Divider -->
                <div class="divider">or</div>

                <!-- Back to login -->
                <div style="text-align:center;">
                    <a href="{{ route('login') }}" class="back-link">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Login
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>

<script>
    /* ─── Toast ─── */
    function showToast({ type = 'info', title, message, duration = 5000 }) {
        const icons = {
            success: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`,
            error:   `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>`,
            info:    `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
        };
        const t = document.createElement('div');
        t.className = `toast toast-${type}`;
        t.innerHTML = `
            <span class="toast-icon">${icons[type]}</span>
            <div class="toast-body">
                <div class="toast-title">${title}</div>
                <div class="toast-msg">${message}</div>
            </div>
            <button class="toast-close">×</button>
        `;
        document.getElementById('toast-container').appendChild(t);
        const dismiss = () => {
            t.classList.add('hiding');
            t.addEventListener('animationend', () => t.remove(), { once: true });
        };
        t.querySelector('.toast-close').addEventListener('click', dismiss);
        if (duration > 0) setTimeout(dismiss, duration);
    }

    /* ─── Loading state ─── */
    const form      = document.getElementById('forgot-form');
    const submitBtn = document.getElementById('submit-btn');
    const spinner   = document.getElementById('spinner');
    const btnText   = document.getElementById('btn-text');

    form.addEventListener('submit', e => {
        const email = document.getElementById('email').value.trim();
        if (!email) {
            e.preventDefault();
            showToast({ type: 'error', title: 'Email Required', message: 'Please enter your email address.' });
            return;
        }
        submitBtn.disabled = true;
        submitBtn.classList.add('loading');
        spinner.style.display = 'block';
        btnText.textContent = 'Sending…';
        showToast({ type: 'info', title: 'Please wait', message: 'Sending password reset link to your email…', duration: 4000 });
    });

    /* ─── Laravel session toasts ─── */
    @if (session('status'))
        document.addEventListener('DOMContentLoaded', () => {
            showToast({ type: 'success', title: 'Link Sent!', message: '{{ addslashes(session('status')) }}', duration: 0 });
        });
    @endif

    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', () => {
            showToast({ type: 'error', title: 'Error', message: '{{ addslashes($errors->first()) }}' });
        });
    @endif
</script>

</body>
</html>