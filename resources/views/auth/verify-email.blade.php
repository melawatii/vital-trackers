<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email | Vital Trackers</title>

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

        .layout { display: flex; min-height: 100vh; }

        /* ══════════════════════════════
           LEFT PANEL
        ══════════════════════════════ */
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

        .blob-tr {
            position: absolute; top: -90px; right: -80px;
            width: 320px; height: 320px; border-radius: 50%;
            background: rgba(186,214,255,0.50);
        }
        .blob-ml {
            position: absolute; top: 38%; left: -55px;
            width: 190px; height: 190px; border-radius: 50%;
            background: rgba(255,255,255,0.18);
        }

        /* dot grid */
        .dot-grid {
            position: absolute; top: 36%; left: 40px;
            display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px;
            opacity: .35; z-index: 1;
        }
        .dot-grid span {
            width: 5px; height: 5px; border-radius: 50%;
            background: #4a7ed8; display: block;
        }

        /* logo */
        .logo-row {
            display: flex; align-items: center; gap: 10px;
            position: relative; z-index: 2;
        }
        .logo-name { font-size: 1rem; font-weight: 700; color: #1e40af; }

        /* hero */
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
            color: #475569; line-height: 1.7; max-width: 300px;
        }

        /* illustration */
        .illustration {
            position: relative; z-index: 2;
            flex: 1; display: flex;
            align-items: flex-end; justify-content: center;
        }
        .illustration svg { width: 100%; max-width: 420px; }

        /* ══════════════════════════════
           RIGHT PANEL
        ══════════════════════════════ */
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

        /* envelope icon circle */
        .env-circle {
            width: 96px; height: 96px;
            border-radius: 50%;
            background: #eff6ff;
            display: flex; align-items: center; justify-content: center;
            position: relative;
            margin-bottom: 28px;
            flex-shrink: 0;
        }
        /* decorative dots */
        .env-circle::before {
            content: '';
            position: absolute;
            width: 9px; height: 9px; border-radius: 50%;
            background: #bfdbfe;
            top: 10px; right: -4px;
        }
        .env-circle::after {
            content: '';
            position: absolute;
            width: 6px; height: 6px; border-radius: 50%;
            background: #bfdbfe;
            bottom: 14px; right: -12px;
        }
        .dot-tl {
            position: absolute;
            width: 7px; height: 7px; border-radius: 50%;
            background: #bfdbfe;
            top: 8px; left: -8px;
        }
        .dot-bl {
            position: absolute;
            width: 5px; height: 5px; border-radius: 50%;
            background: #bfdbfe;
            bottom: 16px; left: -10px;
        }

        /* envelope SVG in circle */
        .env-svg-wrap {
            position: relative; width: 52px; height: 42px;
        }
        .env-svg-wrap svg.env-icon {
            width: 52px; height: 42px; display: block;
        }
        /* checkmark badge on envelope */
        .check-badge {
            position: absolute; top: -10px; right: -10px;
            width: 22px; height: 22px;
            background: #3b82f6; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 6px rgba(37,99,235,.30);
        }
        .check-badge svg { width: 12px; height: 12px; color: #fff; }

        /* heading */
        .card-heading { margin-bottom: 24px; }
        .card-heading h2 {
            font-size: 1.65rem; font-weight: 800; color: #1e293b;
        }
        .card-heading p {
            margin-top: 10px; font-size: .88rem; color: #64748b;
            line-height: 1.65; max-width: 340px;
        }

        /* info box */
        .info-box {
            width: 100%;
            display: flex; align-items: flex-start; gap: 12px;
            background: #f0f6ff;
            border: 1px solid #dbeafe;
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 22px;
            text-align: left;
        }
        .info-box svg { width: 18px; height: 18px; color: #3b82f6; flex-shrink: 0; margin-top: 1px; }
        .info-box p  { font-size: .83rem; color: #3b5bd4; line-height: 1.55; }

        /* alert banners */
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

        /* forms */
        .card form { width: 100%; }

        /* resend button */
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
            margin-bottom: 0;
        }
        .btn-submit:hover:not(:disabled) {
            filter: brightness(1.08);
            transform: translateY(-1px);
            box-shadow: 0 10px 28px rgba(37,99,235,.36);
        }
        .btn-submit:active:not(:disabled) { transform: translateY(0); }
        .btn-submit:disabled { opacity: .72; cursor: not-allowed; }
        .btn-submit svg.btn-icon { width: 18px; height: 18px; flex-shrink: 0; }

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

        /* cooldown badge */
        .cooldown-text {
            display: none;
            font-size: .78rem; color: #94a3b8;
            margin-top: 8px; text-align: center;
        }

        /* divider */
        .divider {
            display: flex; align-items: center; gap: 14px;
            margin: 20px 0 18px;
            font-size: .8rem; color: #94a3b8; width: 100%;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1;
            height: 1px; background: #e2e8f0;
        }

        /* back link */
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

        <!-- dot grid decoration -->
        <div class="dot-grid">
            @for ($i = 0; $i < 35; $i++)
                <span></span>
            @endfor
        </div>

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
            <h1>Almost There!</h1>
            <p>Please verify your email address to activate your account and start managing your health records.</p>
        </div>

        <!-- Illustration -->
        <div class="illustration">
            <svg viewBox="0 0 420 300" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- desk -->
                <rect x="0" y="258" width="420" height="42" fill="#ccdff5"/>

                <!-- plant pot -->
                <rect x="16" y="222" width="38" height="38" rx="8" fill="#b8cfe8"/>
                <rect x="11" y="217" width="48" height="10" rx="5" fill="#cee0f5"/>
                <rect x="33" y="170" width="5" height="50" rx="2.5" fill="#68b88a"/>
                <ellipse cx="35" cy="184" rx="22" ry="14" fill="#7ac89a" transform="rotate(-26 35 184)"/>
                <ellipse cx="35" cy="168" rx="19" ry="12" fill="#8dd4a8" transform="rotate(22 35 168)"/>
                <ellipse cx="35" cy="154" rx="17" ry="11" fill="#a0deba" transform="rotate(-12 35 154)"/>

                <!-- envelope body -->
                <rect x="110" y="80" width="195" height="182" rx="16" fill="#7aafe8"/>
                <!-- back flap -->
                <path d="M110 96 L207 162 L305 96" fill="none" stroke="#5a94d8" stroke-width="1.5"/>
                <!-- top flap (open, folded back) -->
                <path d="M110 80 L207 152 L305 80 Z" fill="#a0c8f5"/>

                <!-- letter / card inside -->
                <rect x="136" y="108" width="144" height="118" rx="10" fill="white" opacity=".94"/>
                <!-- lines on letter -->
                <rect x="152" y="172" width="112" height="7" rx="3.5" fill="#dbeafe"/>
                <rect x="152" y="186" width="88" height="7" rx="3.5" fill="#dbeafe" opacity=".6"/>
                <!-- check circle on letter -->
                <circle cx="208" cy="145" r="24" fill="#3b82f6"/>
                <circle cx="208" cy="145" r="24" fill="white" fill-opacity=".15"/>
                <path d="M197 145 l8 8 16-16" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>

                <!-- pen holder cup -->
                <rect x="325" y="210" width="52" height="50" rx="10" fill="white" opacity=".85"/>
                <rect x="325" y="210" width="52" height="14" rx="8" fill="#cddff5"/>
                <!-- pens -->
                <rect x="342" y="165" width="7" height="52" rx="3.5" fill="#5b8fe8"/>
                <rect x="342" y="160" width="7" height="10" rx="2" fill="#90baf0"/>
                <rect x="355" y="170" width="7" height="45" rx="3.5" fill="#4a7ed8"/>
                <rect x="355" y="165" width="7" height="10" rx="2" fill="#7aaef0"/>

                <!-- send / paper-plane circle -->
                <circle cx="296" cy="242" r="28" fill="#3b82f6"/>
                <circle cx="296" cy="242" r="28" fill="white" fill-opacity=".12"/>
                <!-- paper plane icon -->
                <path d="M283 242 L314 230 L302 257 L296 245 Z" fill="white"/>
                <path d="M296 245 L305 237" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
        </div>
    </div>

    <!-- ════════════ RIGHT PANEL ════════════ -->
    <div class="right-panel">
        <div class="card">

            <!-- Envelope icon with check badge -->
            <div class="env-circle">
                <span class="dot-tl"></span>
                <span class="dot-bl"></span>
                <div class="env-svg-wrap">
                    <!-- open envelope -->
                    <svg class="env-icon" viewBox="0 0 52 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0" y="8" width="52" height="34" rx="6" fill="#90baf0"/>
                        <path d="M0 14 L26 30 L52 14" fill="none" stroke="#b8d4f8" stroke-width="1.5"/>
                        <path d="M0 8 L26 26 L52 8Z" fill="#b8d4f8"/>
                        <!-- small white letter peaking -->
                        <rect x="12" y="14" width="28" height="20" rx="4" fill="white" opacity=".9"/>
                        <rect x="17" y="20" width="18" height="3" rx="1.5" fill="#bfdbfe"/>
                        <rect x="17" y="26" width="13" height="3" rx="1.5" fill="#bfdbfe" opacity=".6"/>
                    </svg>
                    <!-- check badge -->
                    <div class="check-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Heading -->
            <div class="card-heading">
                <h2>Verify Your Email</h2>
                <p>We've sent a verification link to your email address. Please check your inbox and click the link to verify your account.</p>
            </div>

            <!-- Session success -->
            @if (session('status') == 'verification-link-sent')
                <div class="alert-banner success">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    A new verification link has been sent to your email address.
                </div>
            @endif

            <!-- Info box -->
            <div class="info-box">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p>If you didn't receive the email, you can request a new verification link.</p>
            </div>

            <!-- Resend form -->
            <form method="POST" action="{{ route('verification.send') }}" id="resend-form">
                @csrf
                <button type="submit" class="btn-submit" id="resend-btn">
                    <span class="spinner" id="spinner"></span>
                    <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span id="btn-text">Resend Verification Email</span>
                </button>
                <p class="cooldown-text" id="cooldown-text"></p>
            </form>

            <!-- Divider -->
            <div class="divider">or</div>

            <!-- Back to login (via logout) -->
            <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display:inline;">
                @csrf
            </form>
            <a href="#" class="back-link" onclick="document.getElementById('logout-form').submit(); return false;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Login
            </a>

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

    /* ─── Resend with loading + 60s cooldown ─── */
    const resendForm    = document.getElementById('resend-form');
    const resendBtn     = document.getElementById('resend-btn');
    const spinner       = document.getElementById('spinner');
    const btnText       = document.getElementById('btn-text');
    const cooldownText  = document.getElementById('cooldown-text');
    let   cooldownTimer = null;

    resendForm.addEventListener('submit', e => {
        // If already in cooldown, block
        if (resendBtn.disabled) { e.preventDefault(); return; }

        resendBtn.disabled = true;
        resendBtn.classList.add('loading');
        spinner.style.display = 'block';
        btnText.textContent = 'Sending…';

        showToast({ type: 'info', title: 'Please wait', message: 'Sending verification link to your inbox…', duration: 3500 });

        // After 3s simulate complete (actual result handled by page reload from Laravel)
        // Start 60s cooldown after submit — page will reload from Laravel anyway,
        // but this guards multiple rapid clicks if something blocks the submit.
        let secs = 60;
        cooldownText.style.display = 'block';
        cooldownText.textContent = `You can resend again in ${secs}s`;
        cooldownTimer = setInterval(() => {
            secs--;
            if (secs <= 0) {
                clearInterval(cooldownTimer);
                resendBtn.disabled = false;
                resendBtn.classList.remove('loading');
                spinner.style.display = 'none';
                btnText.textContent = 'Resend Verification Email';
                cooldownText.style.display = 'none';
            } else {
                cooldownText.textContent = `You can resend again in ${secs}s`;
                btnText.textContent = `Resend in ${secs}s`;
            }
        }, 1000);
    });

    /* ─── Laravel session toasts ─── */
    @if (session('status') == 'verification-link-sent')
        document.addEventListener('DOMContentLoaded', () => {
            showToast({ type: 'success', title: 'Email Sent!', message: 'A new verification link has been sent to your email address.', duration: 0 });
        });
    @endif
</script>

</body>
</html>