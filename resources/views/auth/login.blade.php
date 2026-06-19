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
    <title>Login | Vital Trackers</title>
    <!-- End: Title -->

    <!-- Begin: Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('build/assets/logo.png') }}">
    <!-- End: Fonts -->

    <!-- Begin: Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- End: Vite Assets -->

    <!-- Begin: Custom Styles -->
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: #eef4ff;
            overflow: hidden;
        }

        /* ── LAYOUT ── */
        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            display: none;
            position: relative;
            width: 46%;
            flex-shrink: 0;
            background: linear-gradient(145deg, #ddeeff 0%, #eaf3ff 50%, #cfe5ff 100%);
            overflow: hidden;
        }

        @media (min-width: 1024px) { .left-panel { display: flex; flex-direction: column; justify-content: space-between; } }

        /* decorative blobs */
        .blob-tl {
            position: absolute; top: -100px; left: -100px;
            width: 380px; height: 380px; border-radius: 50%;
            background: rgba(255,255,255,0.35);
        }
        .blob-br {
            position: absolute; bottom: -90px; right: -90px;
            width: 280px; height: 280px; border-radius: 50%;
            background: rgba(186,214,255,0.4);
        }

        .left-content {
            position: relative; z-index: 2;
            display: flex; flex-direction: column; justify-content: space-between;
            height: 100%; padding: 52px 56px;
        }

        /* logo icon */
        .logo-box {
            width: 58px; height: 58px; border-radius: 18px;
            background: rgba(255,255,255,0.75);
            box-shadow: 0 2px 12px rgba(37,99,235,.10);
            display: flex; align-items: center; justify-content: center;
        }
        .logo-box svg { width: 28px; height: 28px; color: #2563eb; }

        /* hero text */
        .hero-text { margin-top: 56px; }
        .hero-text h1 {
            font-size: clamp(2.4rem, 4vw, 3.5rem);
            font-weight: 800;
            color: #1e293b;
            line-height: 1.15;
        }
        .hero-text p {
            margin-top: 20px;
            font-size: 1.05rem;
            line-height: 1.75;
            color: #475569;
            max-width: 400px;
        }

        /* LEFT — hero image area */
        .hero-image {
            flex: 1;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            padding-bottom: 20px;
            margin-top: 32px;
        }
        .hero-image-inner {
            width: 100%;
            max-width: 420px;
            height: 240px;
            border-radius: 28px;
            background: rgba(255,255,255,0.45);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255,255,255,0.6);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        /* decorative "desk" illustration */
        .desk-scene {
            position: absolute; bottom: 0; left: 0; right: 0;
            height: 80px;
            background: linear-gradient(to right, #b8d6f5, #c8e2ff);
            border-radius: 0 0 28px 28px;
        }
        .plant-svg { position: absolute; bottom: 72px; left: 32px; }
        .folders-svg { position: absolute; bottom: 72px; right: 40px; }

        /* trust badge */
        .trust-badge {
            display: flex; align-items: center; gap: 16px;
            background: rgba(255,255,255,0.55);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.5);
            border-radius: 24px;
            padding: 18px 22px;
            margin-top: 24px;
        }
        .badge-icon-wrap {
            width: 50px; height: 50px; flex-shrink: 0;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(37,99,235,.10);
            display: flex; align-items: center; justify-content: center;
        }
        .badge-icon-wrap svg { width: 22px; height: 22px; color: #2563eb; }
        .badge-text h3 { font-size: .9rem; font-weight: 700; color: #334155; }
        .badge-text p  { font-size: .8rem; color: #64748b; margin-top: 3px; }

        /* ── RIGHT PANEL ── */
        .right-panel {
            flex: 1;
            display: flex; align-items: center; justify-content: center;
            padding: 40px 24px;
        }

        .card {
            width: 100%; max-width: 480px;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(10px);
            border: 1px solid #dbeafe;
            border-radius: 32px;
            box-shadow: 0 16px 64px rgba(37,99,235,.09);
            padding: 44px 48px;
        }
        @media (max-width: 480px) { .card { padding: 32px 24px; border-radius: 24px; } }

        .card-heading { margin-bottom: 36px; }
        .card-heading h2 {
            font-size: 2.1rem; font-weight: 800; color: #1e293b;
        }
        .card-heading p {
            margin-top: 8px; font-size: .93rem; color: #64748b;
        }

        /* form */
        .form-group { margin-bottom: 22px; }
        .form-label {
            display: block; font-size: .82rem; font-weight: 600;
            color: #475569; margin-bottom: 8px;
        }

        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 18px; top: 50%; transform: translateY(-50%);
            color: #94a3b8;
        }
        .input-icon svg { width: 18px; height: 18px; display: block; }

        .form-input {
            width: 100%;
            padding: 15px 18px 15px 46px;
            border-radius: 16px;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            font-family: inherit;
            font-size: .93rem;
            color: #1e293b;
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .form-input::placeholder { color: #94a3b8; }
        .form-input:focus {
            border-color: #60a5fa;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(96,165,250,.13);
        }

        /* password toggle */
        .pw-toggle {
            position: absolute; right: 16px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: #94a3b8; display: flex; align-items: center;
            padding: 4px; transition: color .2s;
        }
        .pw-toggle:hover { color: #60a5fa; }
        .pw-toggle svg { width: 18px; height: 18px; display: block; }

        /* error */
        .field-error { font-size: .8rem; color: #ef4444; margin-top: 6px; }

        /* remember / forgot row */
        .row-extras {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 28px; font-size: .85rem;
        }
        .remember-label {
            display: flex; align-items: center; gap: 8px;
            color: #64748b; cursor: pointer;
        }
        .remember-label input[type="checkbox"] {
            width: 16px; height: 16px;
            border-radius: 5px;
            accent-color: #2563eb;
            cursor: pointer;
        }
        .forgot-link {
            color: #2563eb; font-weight: 600; text-decoration: none;
            transition: color .2s;
        }
        .forgot-link:hover { color: #1d4ed8; }

        /* submit button */
        .btn-submit {
            width: 100%;
            padding: 16px;
            border-radius: 16px;
            border: none;
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
            color: #fff;
            font-family: inherit;
            font-size: .95rem;
            font-weight: 700;
            letter-spacing: .02em;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(59,130,246,.30);
            transition: transform .15s, box-shadow .15s, filter .2s;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            position: relative; overflow: hidden;
        }
        .btn-submit:hover:not(:disabled) {
            filter: brightness(1.07);
            transform: translateY(-1px);
            box-shadow: 0 12px 32px rgba(59,130,246,.38);
        }
        .btn-submit:active:not(:disabled) { transform: translateY(0); }
        .btn-submit:disabled { opacity: .75; cursor: not-allowed; }

        /* spinner */
        .spinner {
            display: none;
            width: 18px; height: 18px;
            border: 2.5px solid rgba(255,255,255,.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }
        .btn-submit.loading .spinner { display: block; }
        .btn-submit.loading .btn-text { opacity: .85; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* register link */
        .register-link {
            text-align: center; margin-top: 24px;
            font-size: .85rem; color: #64748b;
        }
        .register-link a {
            color: #2563eb; font-weight: 700; text-decoration: none;
            transition: color .2s;
        }
        .register-link a:hover { color: #1d4ed8; }

        /* ── NOTIFICATION TOAST ── */
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
            border-left: 4px solid #3b82f6;
            pointer-events: all;
            animation: slideIn .35s cubic-bezier(.34,1.56,.64,1) forwards;
            font-size: .875rem;
        }
        .toast.toast-error { border-left-color: #ef4444; }
        .toast.toast-success { border-left-color: #22c55e; }
        .toast.toast-info { border-left-color: #3b82f6; }
        .toast-icon { flex-shrink: 0; margin-top: 1px; }
        .toast-icon svg { width: 18px; height: 18px; display: block; }
        .toast.toast-error .toast-icon svg { color: #ef4444; }
        .toast.toast-success .toast-icon svg { color: #22c55e; }
        .toast.toast-info .toast-icon svg { color: #3b82f6; }
        .toast-body { flex: 1; }
        .toast-title { font-weight: 700; color: #1e293b; margin-bottom: 2px; }
        .toast-msg { color: #64748b; line-height: 1.45; }
        .toast-close {
            background: none; border: none; cursor: pointer;
            color: #94a3b8; font-size: 1.1rem; line-height: 1;
            padding: 0; margin-left: 4px;
            transition: color .2s;
        }
        .toast-close:hover { color: #475569; }
        .toast.hiding { animation: slideOut .3s ease forwards; }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(60px) scale(.95); }
            to   { opacity: 1; transform: translateX(0)   scale(1); }
        }
        @keyframes slideOut {
            from { opacity: 1; transform: translateX(0); max-height: 200px; margin-bottom: 0; }
            to   { opacity: 0; transform: translateX(60px); max-height: 0; margin-bottom: -12px; padding: 0; }
        }

        /* flash from Laravel session */
        .alert-banner {
            border-radius: 14px;
            padding: 13px 16px;
            font-size: .85rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px;
        }
        .alert-banner.error { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .alert-banner.success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        .alert-banner svg { width: 16px; height: 16px; flex-shrink: 0; }
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
        <div class="blob-tl"></div>
        <div class="blob-br"></div>
        <!-- End: Background Blobs -->

        <!-- Begin: Left Content -->
        <div class="left-content">

            <!-- Begin: Top Section (Logo & Hero) -->
            <div>

                <!-- Begin: Logo -->
                <div class="logo-box">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <!-- End: Logo -->

                <!-- Begin: Hero Text -->
                <div class="hero-text">
                    <h1>Welcome<br>Back!</h1>
                    <p>Sign in to continue managing<br>vital records with ease.</p>
                </div>
                <!-- End: Hero Text -->

                <!-- Begin: Illustration Area -->
                <div class="hero-image">
                    <div class="hero-image-inner">

                        <!-- Begin: Plant SVG -->
                        <svg class="plant-svg" width="80" height="110" viewBox="0 0 80 110" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="22" y="78" width="36" height="28" rx="6" fill="#b8d4f0"/>
                            <rect x="18" y="73" width="44" height="10" rx="5" fill="#cce0f7"/>
                            <path d="M40 75 C40 60 40 45 40 30" stroke="#7ab8a0" stroke-width="3" stroke-linecap="round"/>
                            <ellipse cx="40" cy="50" rx="18" ry="10" fill="#a8d5b5" transform="rotate(-30 40 50)"/>
                            <ellipse cx="40" cy="38" rx="16" ry="9" fill="#b8dfc5" transform="rotate(25 40 38)"/>
                            <ellipse cx="40" cy="28" rx="14" ry="8" fill="#c8e8d0" transform="rotate(-15 40 28)"/>
                        </svg>
                        <!-- End: Plant SVG -->

                        <!-- Begin: Folders SVG -->
                        <svg class="folders-svg" width="100" height="110" viewBox="0 0 100 110" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="10" y="30" width="28" height="60" rx="6" fill="#89b4e8"/>
                            <rect x="10" y="24" width="16" height="10" rx="4" fill="#a8c8f0"/>
                            <rect x="42" y="20" width="28" height="70" rx="6" fill="#6fa0d8"/>
                            <rect x="42" y="14" width="16" height="10" rx="4" fill="#90bce8"/>
                            <rect x="74" y="35" width="22" height="55" rx="6" fill="#a8c8f0"/>
                            <rect x="74" y="29" width="14" height="10" rx="4" fill="#c0d8f8"/>
                        </svg>
                        <!-- End: Folders SVG -->

                        <div class="desk-scene"></div>
                    </div>
                </div>
                <!-- End: Illustration Area -->

            </div>
            <!-- End: Top Section (Logo & Hero) -->

            <!-- Begin: Trust Badge -->
            <div class="trust-badge">
                <div class="badge-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div class="badge-text">
                    <h3>Secure. Reliable. Always here</h3>
                    <p>for your health data.</p>
                </div>
            </div>
            <!-- End: Trust Badge -->

        </div>
        <!-- End: Left Content -->

    </div>
    <!-- End: Left Panel -->

    <!-- Begin: Right Panel -->
    <div class="right-panel">

        <!-- Begin: Card -->
        <div class="card">

            <!-- Begin: Heading -->
            <div class="card-heading">
                <h2>Login</h2>
                <p>Please enter your credentials to access your account.</p>
            </div>
            <!-- End: Heading -->

            <!-- Begin: Error Alert -->
            @if ($errors->any())
                <div class="alert-banner error">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $errors->first() }}
                </div>
            @endif
            <!-- End: Error Alert -->

            <!-- Begin: Session Status Alert -->
            @if (session('status'))
                <div class="alert-banner success">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('status') }}
                </div>
            @endif
            <!-- End: Session Status Alert -->

            <!-- Begin: Login Form -->
            <form method="POST" action="{{ route('login') }}" id="login-form">

                <!-- Begin: CSRF Token -->
                @csrf
                <!-- End: CSRF Token -->

                <!-- Begin: Email Input Group -->
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
                            class="form-input"
                            placeholder="Enter your email"
                            required
                            autofocus
                        >
                    </div>
                    @error('email')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- End: Email Input Group -->

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
                            class="form-input"
                            placeholder="Enter your password"
                            required
                        >
                        <button type="button" class="pw-toggle" id="toggle-pw" aria-label="Toggle password visibility">
                            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eye-off-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>
                <!-- End: Password Input Group -->

                <!-- Begin: Remember & Forgot Links -->
                <div class="row-extras">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Remember me
                    </label>
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                </div>
                <!-- End: Remember & Forgot Links -->

                <!-- Begin: Submit Button -->
                <button type="submit" class="btn-submit" id="submit-btn">
                    <span class="spinner" id="spinner"></span>
                    <span class="btn-text" id="btn-text">Login</span>
                </button>
                <!-- End: Submit Button -->

                <!-- Begin: Register Link -->
                <p class="register-link">
                    Don't have an account?
                    <a href="{{ route('register') }}">Register here</a>
                </p>
                <!-- End: Register Link -->

            </form>
            <!-- End: Login Form -->

        </div>
        <!-- End: Card -->

    </div>
    <!-- End: Right Panel -->

</div>
<!-- End: Main Layout -->

<!-- Begin: Scripts -->
<script>
    /* ─── Toast utility ─── */
    // Function to dynamically generate and display toast notifications with auto-dismiss capability
    function showToast({ type = 'info', title, message, duration = 4000 }) {
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
            <button class="toast-close" aria-label="Close">×</button>
        `;

        document.getElementById('toast-container').appendChild(toast);

        const dismiss = () => {
            toast.classList.add('hiding');
            toast.addEventListener('animationend', () => toast.remove(), { once: true });
        };

        toast.querySelector('.toast-close').addEventListener('click', dismiss);
        if (duration > 0) setTimeout(dismiss, duration);
    }

    /* ─── Password toggle ─── */
    // Toggle visibility of the password input field and swap the eye icon accordingly
    const pwInput   = document.getElementById('password');
    const toggleBtn = document.getElementById('toggle-pw');
    const eyeIcon   = document.getElementById('eye-icon');
    const eyeOff    = document.getElementById('eye-off-icon');

    toggleBtn.addEventListener('click', () => {
        const show = pwInput.type === 'password';
        pwInput.type    = show ? 'text' : 'password';
        eyeIcon.style.display  = show ? 'none'  : 'block';
        eyeOff.style.display   = show ? 'block' : 'none';
    });

    /* ─── Loading state on submit ─── */
    // Handle form submission: validate inputs, trigger loading state, and show info toast
    const form      = document.getElementById('login-form');
    const submitBtn = document.getElementById('submit-btn');
    const btnText   = document.getElementById('btn-text');
    const spinner   = document.getElementById('spinner');

    form.addEventListener('submit', (e) => {
        const email    = document.getElementById('email').value.trim();
        const password = pwInput.value;

        // Basic client-side validation
        if (!email || !password) {
            e.preventDefault();
            showToast({ type: 'error', title: 'Incomplete Form', message: 'Please fill in your email and password.' });
            return;
        }

        // Show loading state
        submitBtn.disabled = true;
        submitBtn.classList.add('loading');
        spinner.style.display = 'block';
        btnText.textContent   = 'Signing in…';

        showToast({ type: 'info', title: 'Please wait', message: 'Verifying your credentials…', duration: 3000 });
    });

    /* ─── Show Laravel errors as toast too ─── */
    // Intercept Laravel session errors/status on DOM load and convert them to toast notifications
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', () => {
            showToast({
                type: 'error',
                title: 'Login Failed',
                message: '{{ addslashes($errors->first()) }}'
            });
        });
    @endif

    @if (session('status'))
        document.addEventListener('DOMContentLoaded', () => {
            showToast({
                type: 'success',
                title: 'Success',
                message: '{{ addslashes(session('status')) }}'
            });
        });
    @endif
</script>
<!-- End: Scripts -->

</body>
<!-- End: Body -->
</html>
<!-- End: HTML Document -->
