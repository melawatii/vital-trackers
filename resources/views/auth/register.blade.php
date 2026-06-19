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
    <title>Register | Vital Trackers</title>
    <!-- End: Title -->

    <!-- Begin: Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- End: Fonts -->

    <!-- Begin: Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- End: Vite Assets -->

    <!-- Begin: Custom Styles -->
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: #f0f6ff;
            overflow-x: hidden;
        }

        /* ── LAYOUT ── */
        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* ══════════════════════════════════════
           LEFT PANEL
        ══════════════════════════════════════ */
        .left-panel {
            display: none;
            width: 44%;
            flex-shrink: 0;
            background: linear-gradient(160deg, #c8dfff 0%, #d8ebff 40%, #b8d4ff 100%);
            position: relative;
            overflow: hidden;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 52px 0;
        }
        @media (min-width: 1024px) { .left-panel { display: flex; } }

        /* blobs */
        .blob-tr {
            position: absolute; top: -80px; right: -80px;
            width: 320px; height: 320px; border-radius: 50%;
            background: rgba(186,214,255,0.55);
        }
        .blob-bl {
            position: absolute; bottom: 120px; left: -60px;
            width: 200px; height: 200px; border-radius: 50%;
            background: rgba(255,255,255,0.25);
        }

        /* logo row */
        .logo-row {
            display: flex; align-items: center; gap: 10px;
            position: relative; z-index: 2;
        }
        .logo-icon {
            width: 38px; height: 38px;
        }
        .logo-name {
            font-size: 1rem; font-weight: 700; color: #1e40af;
        }

        /* hero text */
        .hero {
            position: relative; z-index: 2;
            margin-top: 52px;
        }
        .hero h1 {
            font-size: clamp(2rem, 3.5vw, 2.8rem);
            font-weight: 800; color: #1e293b; line-height: 1.2;
        }
        .hero p {
            margin-top: 16px; font-size: .95rem; color: #475569;
            line-height: 1.7; max-width: 340px;
        }

        /* feature list */
        .features {
            margin-top: 40px; display: flex; flex-direction: column; gap: 20px;
            position: relative; z-index: 2;
        }
        .feature-item {
            display: flex; align-items: flex-start; gap: 14px;
        }
        .feature-icon {
            width: 46px; height: 46px; flex-shrink: 0;
            border-radius: 14px;
            background: rgba(255,255,255,0.75);
            box-shadow: 0 2px 10px rgba(37,99,235,.10);
            display: flex; align-items: center; justify-content: center;
        }
        .feature-icon svg { width: 20px; height: 20px; color: #2563eb; }
        .feature-text h4 { font-size: .87rem; font-weight: 700; color: #1e293b; }
        .feature-text p  { font-size: .8rem; color: #64748b; margin-top: 3px; line-height: 1.5; }

        /* illustration at the bottom */
        .illustration {
            position: relative; z-index: 2;
            display: flex; align-items: flex-end; justify-content: center;
            margin-top: 32px;
            /* flush to bottom */
        }
        .illustration svg {
            width: 100%;
            max-width: 420px;
        }

        /* ══════════════════════════════════════
           RIGHT PANEL
        ══════════════════════════════════════ */
        .right-panel {
            flex: 1;
            display: flex; align-items: center; justify-content: center;
            padding: 40px 24px;
            background: #f0f6ff;
        }

        .card {
            width: 100%; max-width: 580px;
            background: #fff;
            border-radius: 28px;
            box-shadow: 0 12px 48px rgba(37,99,235,.09);
            padding: 44px 48px;
        }
        @media (max-width: 600px) { .card { padding: 32px 20px; border-radius: 20px; } }

        .card-heading { margin-bottom: 32px; }
        .card-heading h2 { font-size: 1.8rem; font-weight: 800; color: #1e293b; }
        .card-heading p  { margin-top: 6px; font-size: .88rem; color: #64748b; }

        /* alert banner */
        .alert-banner {
            border-radius: 14px; padding: 14px 16px;
            font-size: .84rem; font-weight: 500;
            margin-bottom: 20px;
            display: flex; align-items: flex-start; gap: 10px;
            line-height: 1.5;
        }
        .alert-banner.error { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }
        .alert-banner svg { width:16px; height:16px; flex-shrink:0; margin-top:1px; }

        /* 2-col grid for fields */
        .fields-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px 18px;
        }
        @media (max-width: 520px) { .fields-grid { grid-template-columns: 1fr; } }

        .field-full { grid-column: 1 / -1; }

        /* form group */
        .form-group { display: flex; flex-direction: column; }
        .form-label {
            font-size: .8rem; font-weight: 600; color: #475569;
            margin-bottom: 7px;
        }

        /* input wrapper */
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; pointer-events: none;
        }
        .input-icon svg { width: 17px; height: 17px; display: block; }

        .form-input {
            width: 100%;
            padding: 13px 14px 13px 42px;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            font-family: inherit; font-size: .88rem; color: #1e293b;
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .form-input::placeholder { color: #94a3b8; }
        .form-input:focus {
            border-color: #60a5fa; background: #fff;
            box-shadow: 0 0 0 4px rgba(96,165,250,.12);
        }
        .form-input.has-error { border-color: #f87171; }

        /* password toggle */
        .pw-toggle {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: #94a3b8; display: flex; align-items: center;
            padding: 4px; transition: color .2s;
        }
        .pw-toggle:hover { color: #60a5fa; }
        .pw-toggle svg { width: 17px; height: 17px; display: block; }

        /* select / role */
        .select-wrap { position: relative; }
        .select-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; pointer-events: none;
        }
        .select-icon svg { width: 17px; height: 17px; display: block; }
        .chevron-icon {
            position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; pointer-events: none;
        }
        .chevron-icon svg { width: 17px; height: 17px; display: block; }

        .form-select {
            width: 100%;
            padding: 13px 40px 13px 42px;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            font-family: inherit; font-size: .88rem; color: #1e293b;
            outline: none; appearance: none;
            cursor: pointer;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .form-select:focus {
            border-color: #60a5fa; background: #fff;
            box-shadow: 0 0 0 4px rgba(96,165,250,.12);
        }
        .form-select option[value=""] { color: #94a3b8; }

        /* field error */
        .field-error { font-size: .77rem; color: #ef4444; margin-top: 5px; }

        /* terms checkbox */
        .terms-row {
            display: flex; align-items: flex-start; gap: 10px;
            margin-top: 20px; margin-bottom: 22px;
        }
        .terms-row input[type="checkbox"] {
            width: 17px; height: 17px; flex-shrink: 0;
            margin-top: 2px; cursor: pointer;
            accent-color: #2563eb;
            border-radius: 5px;
        }
        .terms-row label {
            font-size: .83rem; color: #475569; line-height: 1.6; cursor: pointer;
        }
        .terms-row a { color: #2563eb; font-weight: 600; text-decoration: none; }
        .terms-row a:hover { text-decoration: underline; }

        /* submit button */
        .btn-submit {
            width: 100%; padding: 15px;
            border-radius: 14px; border: none;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: #fff;
            font-family: inherit; font-size: .92rem; font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(37,99,235,.30);
            transition: filter .2s, transform .15s, box-shadow .2s;
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .btn-submit:hover:not(:disabled) {
            filter: brightness(1.08);
            transform: translateY(-1px);
            box-shadow: 0 10px 28px rgba(37,99,235,.38);
        }
        .btn-submit:active:not(:disabled) { transform: translateY(0); }
        .btn-submit:disabled { opacity: .72; cursor: not-allowed; }
        .btn-submit svg.btn-icon { width: 18px; height: 18px; }

        /* spinner */
        .spinner {
            display: none;
            width: 18px; height: 18px;
            border: 2.5px solid rgba(255,255,255,.35);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .7s linear infinite;
            flex-shrink: 0;
        }
        .btn-submit.loading .spinner { display: block; }
        .btn-submit.loading .btn-icon { display: none; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* login link */
        .login-link {
            text-align: center; margin-top: 20px;
            font-size: .83rem; color: #64748b;
        }
        .login-link a { color: #2563eb; font-weight: 700; text-decoration: none; }
        .login-link a:hover { text-decoration: underline; }

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
            border-radius: 16px;
            background: #fff;
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
            color: #94a3b8; font-size: 1.1rem; line-height: 1; padding: 0;
            transition: color .2s;
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
    <!-- End: Custom Styles -->
</head>
<!-- End: Head -->

<!-- Begin: Body -->
<body>

<!-- Begin: Toast Container -->
<div id="toast-container"></div>
<!-- End: Toast Container -->

<!-- Begin: Main Layout -->
<div class="layout">

    <!-- Begin: Left Panel -->
    <div class="left-panel">

        <!-- Begin: Background Blobs -->
        <div class="blob-tr"></div>
        <div class="blob-bl"></div>
        <!-- End: Background Blobs -->

        <!-- Begin: Logo -->
        <div class="logo-row">
            <svg class="logo-icon" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="40" height="40" rx="10" fill="white" fill-opacity="0.7"/>
                <path d="M20 30.5C20 30.5 8 23.5 8 15.5C8 12.467 10.467 10 13.5 10C15.524 10 17.291 11.09 18.25 12.727C19.209 11.09 20.976 10 23 10C26.033 10 28.5 12.467 28.5 15.5C28.5 23.5 20 30.5 20 30.5Z" fill="#2563eb" stroke="#2563eb" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 19h4l2-5 3 9 2-7 2 3h3" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="logo-name">Vital Trackers</span>
        </div>
        <!-- End: Logo -->

        <!-- Begin: Hero Text -->
        <div class="hero">
            <h1>Create<br>Account</h1>
            <p>Join Vital Trackers and start managing your health records, monitor vital signs, and track your wellness journey.</p>
        </div>
        <!-- End: Hero Text -->

        <!-- Begin: Features List -->
        <div class="features">
            <!-- Begin: Feature Item 1 -->
            <div class="feature-item">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div class="feature-text">
                    <h4>Secure &amp; Private</h4>
                    <p>Your data is encrypted and always protected.</p>
                </div>
            </div>
            <!-- End: Feature Item 1 -->

            <!-- Begin: Feature Item 2 -->
            <div class="feature-item">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="feature-text">
                    <h4>Track Your Health</h4>
                    <p>Monitor vital signs and wellness activity anytime.</p>
                </div>
            </div>
            <!-- End: Feature Item 2 -->

            <!-- Begin: Feature Item 3 -->
            <div class="feature-item">
                <div class="feature-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div class="feature-text">
                    <h4>Personalized for You</h4>
                    <p>Get insights and summaries tailored to your health.</p>
                </div>
            </div>
            <!-- End: Feature Item 3 -->
        </div>
        <!-- End: Features List -->

        <!-- Begin: Illustration -->
        <div class="illustration">
            <svg viewBox="0 0 420 260" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- desk surface -->
                <rect x="0" y="220" width="420" height="40" rx="0" fill="#ccdff5"/>
                <!-- plant pot -->
                <rect x="18" y="195" width="38" height="30" rx="6" fill="#b8cfe8"/>
                <rect x="14" y="190" width="46" height="10" rx="5" fill="#cddff5"/>
                <!-- plant leaves -->
                <ellipse cx="37" cy="165" rx="22" ry="14" fill="#7dc99a" transform="rotate(-25 37 165)"/>
                <ellipse cx="37" cy="150" rx="20" ry="12" fill="#90d4ab" transform="rotate(20 37 150)"/>
                <ellipse cx="37" cy="138" rx="18" ry="11" fill="#a3deba" transform="rotate(-10 37 138)"/>
                <rect x="35" y="148" width="4" height="45" rx="2" fill="#6ab88a"/>

                <!-- clipboard -->
                <rect x="120" y="95" width="110" height="130" rx="10" fill="#5b8fe8"/>
                <rect x="155" y="82" width="40" height="22" rx="8" fill="#8bb4f0" stroke="#5b8fe8" stroke-width="3"/>
                <rect x="130" y="118" width="90" height="8" rx="4" fill="#a8c4f8"/>
                <!-- heart on clipboard -->
                <path d="M175 145c0 0-18-12-18-24a12 12 0 0124 0 12 12 0 0124 0c0 12-18 24-18 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                <!-- ecg line -->
                <path d="M130 170 l12 0 l5-15 l8 30 l6-20 l6 8 l10 0 l5-10 l8 10 l12 0" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                <rect x="130" y="190" width="90" height="8" rx="4" fill="#a8c4f8" opacity=".6"/>
                <rect x="130" y="203" width="70" height="8" rx="4" fill="#a8c4f8" opacity=".4"/>

                <!-- binder 1 -->
                <rect x="248" y="110" width="42" height="115" rx="8" fill="#4a7ed8"/>
                <rect x="248" y="104" width="42" height="16" rx="6" fill="#6a9ae8"/>
                <rect x="282" y="125" width="5" height="80" rx="2.5" fill="rgba(255,255,255,.2)"/>

                <!-- binder 2 -->
                <rect x="298" y="125" width="38" height="100" rx="8" fill="#6a9ae8"/>
                <rect x="298" y="119" width="38" height="14" rx="5" fill="#8ab4f0"/>
                <rect x="328" y="138" width="4" height="70" rx="2" fill="rgba(255,255,255,.2)"/>

                <!-- shield -->
                <path d="M350 150 C350 140 370 130 390 135 L390 165 C390 185 370 200 350 205 C330 200 310 185 310 165 L310 135 C330 130 350 140 350 150Z" fill="#3b82f6" opacity=".85"/>
                <path d="M340 172 l8 8 16-18" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <!-- End: Illustration -->

    </div>
    <!-- End: Left Panel -->

    <!-- Begin: Right Panel -->
    <div class="right-panel">

        <!-- Begin: Card -->
        <div class="card">

            <!-- Begin: Heading -->
            <div class="card-heading">
                <h2>Create Your Account</h2>
                <p>Please fill in the details to get started.</p>
            </div>
            <!-- End: Heading -->

            <!-- Begin: Laravel Errors Alert -->
            @if ($errors->any())
                <div class="alert-banner error">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif
            <!-- End: Laravel Errors Alert -->

            <!-- Begin: Register Form -->
            <form method="POST" action="{{ route('register') }}" id="register-form">

                <!-- Begin: CSRF Token -->
                @csrf
                <!-- End: CSRF Token -->

                <!-- Begin: Fields Grid -->
                <div class="fields-grid">

                    <!-- Begin: Full Name Input Group -->
                    <div class="form-group">
                        <label class="form-label" for="name">Full Name</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-input {{ $errors->has('name') ? 'has-error' : '' }}"
                                placeholder="Enter your full name"
                                required
                                autofocus
                            >
                        </div>
                        @error('name')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- End: Full Name Input Group -->

                    <!-- Begin: Username Input Group -->
                    <div class="form-group">
                        <label class="form-label" for="username">Username</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A5.002 5.002 0 0112 15c1.02 0 1.962.31 2.741.84M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </span>
                            <input
                                type="text"
                                id="username"
                                name="username"
                                value="{{ old('username') }}"
                                class="form-input {{ $errors->has('username') ? 'has-error' : '' }}"
                                placeholder="Choose a username"
                                required
                            >
                        </div>
                        @error('username')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- End: Username Input Group -->

                    <!-- Begin: Hidden Role & Email Input Group -->
                    <input type="hidden" id="role" name="role" value="user">
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
                            >
                        </div>
                        @error('email')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- End: Hidden Role & Email Input Group -->

                    <!-- Begin: Password Input Group -->
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-input {{ $errors->has('password') ? 'has-error' : '' }}"
                                placeholder="Create a password"
                                required
                            >
                            <button type="button" class="pw-toggle" data-target="password" aria-label="Toggle password">
                                <svg class="eye-show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg class="eye-hide" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- End: Password Input Group -->

                    <!-- Begin: Confirm Password Input Group -->
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-input"
                                placeholder="Confirm your password"
                                required
                            >
                            <button type="button" class="pw-toggle" data-target="password_confirmation" aria-label="Toggle confirm password">
                                <svg class="eye-show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg class="eye-hide" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <!-- End: Confirm Password Input Group -->

                </div>
                <!-- End: Fields Grid -->

                <!-- Begin: Terms & Conditions -->
                <div class="terms-row">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        I agree to the <a href="#">Terms &amp; Conditions</a> and <a href="#">Privacy Policy</a>.
                    </label>
                </div>
                <!-- End: Terms & Conditions -->

                <!-- Begin: Submit Button -->
                <button type="submit" class="btn-submit" id="submit-btn">
                    <span class="spinner" id="spinner"></span>
                    <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    <span id="btn-text">Create Account</span>
                </button>
                <!-- End: Submit Button -->

                <!-- Begin: Login Link -->
                <p class="login-link">
                    Already have an account? <a href="{{ route('login') }}">Login here</a>
                </p>
                <!-- End: Login Link -->

            </form>
            <!-- End: Register Form -->

        </div>
        <!-- End: Card -->

    </div>
    <!-- End: Right Panel -->

</div>
<!-- End: Main Layout -->

<!-- Begin: Scripts -->
<script>
    /* ─── Toast Utility ─── */
    // Function to dynamically generate and display toast notifications with auto-dismiss capability
    function showToast({ type = 'info', title, message, duration = 5000 }) {
        const icons = {
            success: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`,
            error:   `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>`,
            info:    `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
        };
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <span class="toast-icon">${icons[type]}</span>
            <div class="toast-body">
                <div class="toast-title">${title}</div>
                <div class="toast-msg">${message}</div>
            </div>
            <button class="toast-close">×</button>
        `;
        document.getElementById('toast-container').appendChild(toast);

        // Auto-dismiss logic
        const dismiss = () => {
            toast.classList.add('hiding');
            toast.addEventListener('animationend', () => toast.remove(), { once: true });
        };
        toast.querySelector('.toast-close').addEventListener('click', dismiss);
        if (duration > 0) setTimeout(dismiss, duration);
    }

    /* ─── Password Toggles ─── */
    // Attach event listeners to all password toggle buttons to show/hide password text
    document.querySelectorAll('.pw-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = document.getElementById(btn.dataset.target);
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.querySelector('.eye-show').style.display = show ? 'none'  : 'block';
            btn.querySelector('.eye-hide').style.display = show ? 'block' : 'none';
        });
    });

    /* ─── Loading State on Submit ─── */
    // Handle form submission: validate inputs, check terms, trigger loading state, and show info toast
    const form      = document.getElementById('register-form');
    const submitBtn = document.getElementById('submit-btn');
    const spinner   = document.getElementById('spinner');
    const btnText   = document.getElementById('btn-text');

    form.addEventListener('submit', e => {
        const name     = document.getElementById('name').value.trim();
        const email    = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const confirm  = document.getElementById('password_confirmation').value;
        const role     = document.getElementById('role').value;
        const terms    = document.getElementById('terms').checked;

        // Basic client-side validation
        if (!name || !email || !password || !confirm || !role) {
            e.preventDefault();
            showToast({ type: 'error', title: 'Incomplete Form', message: 'Please fill in all required fields.' });
            return;
        }
        if (password !== confirm) {
            e.preventDefault();
            showToast({ type: 'error', title: 'Password Mismatch', message: 'Password and confirmation do not match.' });
            return;
        }
        if (!terms) {
            e.preventDefault();
            showToast({ type: 'error', title: 'Terms Required', message: 'Please agree to the Terms & Conditions.' });
            return;
        }

        // Show loading state
        submitBtn.disabled = true;
        submitBtn.classList.add('loading');
        spinner.style.display = 'block';
        btnText.textContent = 'Creating Account…';
        showToast({ type: 'info', title: 'Please wait', message: 'Setting up your account…', duration: 4000 });
    });

    /* ─── Laravel Error Toasts ─── */
    // Intercept Laravel session errors/status on DOM load and convert them to toast notifications
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', () => {
            @foreach ($errors->all() as $error)
                showToast({ type: 'error', title: 'Registration Error', message: '{{ addslashes($error) }}' });
            @endforeach
        });
    @endif

    @if (session('status'))
        document.addEventListener('DOMContentLoaded', () => {
            showToast({ type: 'success', title: 'Success', message: '{{ addslashes(session('status')) }}' });
        });
    @endif
</script>
<!-- End: Scripts -->

</body>
<!-- End: Body -->
</html>
<!-- End: HTML Document -->
