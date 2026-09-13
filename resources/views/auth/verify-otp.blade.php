<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        use App\Models\Setting;
        $pharmacyName = Setting::get('pharmacy_name', 'Pharmacy');
        $pharmacyLogo = Setting::get('pharmacy_logo', '');
        $logoExists = $pharmacyLogo && file_exists(storage_path('app/public/' . $pharmacyLogo));
    @endphp
    <title>OTP Verification · {{ $pharmacyName }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: "Inter", "Segoe UI", system-ui, -apple-system, sans-serif; }
        body { display: flex; min-height: 100vh; background: #f0f5fe; }
        .left-side {
            flex: 1;
            background: url('background-pharmacy.jpg') center center / cover no-repeat;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            padding: 20px;
            overflow: hidden;
            isolation: isolate;
        }
        .left-side::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 20, 30, 0.55);
            backdrop-filter: blur(2px);
            z-index: 0;
        }
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            opacity: 0.35;
            z-index: 0;
            animation: floatOrb 18s infinite alternate ease-in-out;
            pointer-events: none;
        }
        .orb-1 { width: 300px; height: 300px; background: #4dd0a8; top: -5%; left: -10%; animation-duration: 22s; }
        .orb-2 { width: 400px; height: 400px; background: #3f8ef0; bottom: -15%; right: -10%; animation-duration: 28s; animation-delay: -5s; }
        .orb-3 { width: 180px; height: 180px; background: #b48aff; top: 40%; right: 5%; animation-duration: 16s; animation-delay: -2s; opacity: 0.25; }
        @keyframes floatOrb {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(30px, -40px) scale(1.2); }
        }
        .left-card {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px) saturate(180%);
            -webkit-backdrop-filter: blur(12px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.20);
            border-radius: 40px;
            padding: 40px 48px;
            max-width: 420px;
            animation: slideFadeIn 1s cubic-bezier(0.23, 1, 0.32, 1), softFloat 4s infinite alternate ease-in-out;
            box-shadow: 0 25px 50px -8px rgba(0,0,0,0.3), inset 0 2px 0 rgba(255,255,255,0.2);
            transition: transform 0.3s ease, box-shadow 0.4s ease;
            will-change: transform;
        }
        .left-card:hover { transform: scale(1.02) translateY(-4px); box-shadow: 0 35px 70px -10px rgba(0,0,0,0.5), 0 0 0 2px rgba(255,255,255,0.1); }
        @keyframes softFloat {
            0% { transform: translateY(0px); }
            100% { transform: translateY(-12px); }
        }
        .left-card h1 {
            font-size: 2.6rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #d4fae6, #a8f0d0);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 12px;
            text-shadow: 0 2px 20px rgba(0,180,120,0.2);
            animation: textGlow 3s infinite alternate;
        }
        @keyframes textGlow {
            0% { text-shadow: 0 0 10px rgba(0,255,200,0.1); }
            100% { text-shadow: 0 0 30px rgba(0,255,200,0.4), 0 0 60px rgba(0,200,150,0.2); }
        }
        .left-card p {
            font-size: 1.1rem;
            font-weight: 400;
            color: rgba(255,255,255,0.85);
            line-height: 1.6;
            backdrop-filter: blur(4px);
            padding: 0 4px;
        }
        @keyframes slideFadeIn {
            0% { opacity: 0; transform: translateX(-50px) scale(0.96); }
            100% { opacity: 1; transform: translateX(0) scale(1); }
        }
        .otp-box {
            width: 440px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: -8px 0 30px rgba(0, 0, 0, 0.04), 0 25px 50px -12px rgba(0,0,0,0.15);
            border-top-left-radius: 36px;
            border-bottom-left-radius: 36px;
            animation: fadeInRight 0.9s cubic-bezier(0.23, 1, 0.32, 1);
            border-right: 1px solid rgba(255,255,255,0.4);
            transition: box-shadow 0.3s ease;
        }
        .otp-box:hover { box-shadow: -8px 0 40px rgba(0, 0, 0, 0.06), 0 30px 60px -12px rgba(0,0,0,0.20); }
        @keyframes fadeInRight {
            0% { opacity: 0; transform: translateX(50px) scale(0.97); }
            100% { opacity: 1; transform: translateX(0) scale(1); }
        }
        .otp-box img.logo {
            width: 110px;
            height: 110px;
            margin-bottom: 14px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 12px 28px -8px rgba(0,80,60,0.2);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 2px solid rgba(255,255,255,0.6);
            animation: logoEntrance 0.9s cubic-bezier(0.34, 1.56, 0.64, 1), logoPulse 3s infinite alternate 0.5s;
            will-change: transform;
        }
        .otp-box img.logo:hover {
            transform: scale(1.12) rotate(-4deg) translateY(-6px);
            box-shadow: 0 20px 40px -8px rgba(0,140,100,0.4);
            animation-play-state: paused;
        }
        @keyframes logoEntrance {
            0% { opacity: 0; transform: scale(0.2) rotate(-20deg) translateY(40px); }
            60% { transform: scale(1.1) rotate(3deg) translateY(-10px); }
            100% { opacity: 1; transform: scale(1) rotate(0) translateY(0); }
        }
        @keyframes logoPulse {
            0% { transform: scale(1) translateY(0); box-shadow: 0 12px 28px -8px rgba(0,80,60,0.2); }
            100% { transform: scale(1.04) translateY(-6px); box-shadow: 0 20px 40px -6px rgba(0,140,100,0.35); }
        }
        .otp-box h2 {
            color: #0d7a5a;
            font-weight: 650;
            font-size: 22px;
            letter-spacing: -0.01em;
            margin-bottom: 8px;
            text-align: center;
            background: linear-gradient(145deg, #0b8f66, #0b6b4f);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: titlePulse 2.5s infinite alternate;
        }
        @keyframes titlePulse {
            0% { opacity: 0.9; transform: scale(1); }
            100% { opacity: 1; transform: scale(1.02); }
        }
        .otp-box .sub-text {
            color: #5a6f68;
            margin-bottom: 22px;
            font-size: 14px;
            text-align: center;
            line-height: 1.6;
        }
        .otp-box .sub-text strong { color: #0b8f66; font-weight: 600; }
        .otp-input {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 22px;
            width: 100%;
        }
        .otp-input input {
            width: 56px;
            height: 68px;
            text-align: center;
            font-size: 28px;
            font-weight: 700;
            border: 2px solid rgba(0, 0, 0, 0.08);
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            transition: all 0.25s ease;
            color: #0b3d2e;
            caret-color: #0b8f66;
            box-shadow: inset 0 2px 6px rgba(0,0,0,0.02), 0 2px 4px rgba(0,0,0,0.02);
        }
        .otp-input input:focus {
            border-color: #0b8f66;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 18px rgba(11, 143, 102, 0.20), inset 0 1px 0 #fff;
            outline: none;
            transform: scale(1.04) translateY(-2px);
        }
        .otp-input input:focus-visible { outline: none; }
        .otp-input input.otp-complete {
            border-color: #28a745;
            background: rgba(40, 167, 69, 0.08);
            box-shadow: 0 0 0 4px rgba(40, 167, 69, 0.12);
        }
        /* ✅ NEW: disabled / expired state */
        .otp-input input:disabled {
            background: rgba(0, 0, 0, 0.04);
            border-color: rgba(0, 0, 0, 0.05);
            color: #aaa;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        .verifying-overlay {
            display: none;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px;
            margin-bottom: 14px;
            color: #0b8f66;
            font-weight: 500;
            font-size: 14px;
            background: rgba(11, 143, 102, 0.06);
            border-radius: 30px;
            width: 100%;
            animation: alertPop 0.3s ease;
        }
        .verifying-overlay .spinner {
            width: 20px;
            height: 20px;
            border: 3px solid rgba(11, 143, 102, 0.15);
            border-top-color: #0b8f66;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        .remember-me {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin: 4px 0 18px 0;
            gap: 10px;
        }
        .remember-me input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #0b8f66;
            border-radius: 4px;
            transition: all 0.2s;
        }
        .remember-me input:checked { transform: scale(1.05); }
        .remember-me label {
            color: #4a5f57;
            font-size: 14px;
            cursor: pointer;
            font-weight: 500;
            user-select: none;
        }
        .btn-verify {
            background: #0b7a33;
            color: white;
            border: none;
            padding: 14px 0;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            width: 100%;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .btn-verify:hover {
            background: #056b28;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(11, 122, 51, 0.3);
        }
        .btn-verify:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        .alert {
            padding: 10px 16px;
            border-radius: 30px;
            width: 100%;
            text-align: center;
            font-weight: 500;
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255,255,255,0.3);
            animation: alertPop 0.5s ease;
            margin-bottom: 14px;
            font-size: 14px;
        }
        .alert-error { background: rgba(248, 215, 218, 0.7); color: #7f2a31; border-color: #f5c6cb; }
        .alert-info { background: rgba(209, 236, 241, 0.7); color: #0c5460; border-color: #bee5eb; }
        .alert-success { background: rgba(212, 237, 218, 0.7); color: #0e542a; border-color: #b7dfb9; }
        @keyframes alertPop {
            0% { opacity: 0; transform: translateY(-12px) scale(0.95); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        .timer {
            font-size: 14px;
            color: #6f8279;
            margin-top: 4px;
            font-weight: 500;
        }
        .timer #countdown { color: #0b8f66; font-weight: 700; }
        .resend-link {
            color: #0b8f66;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            border-bottom: 2px solid transparent;
            padding-bottom: 2px;
            display: none;
        }
        .resend-link:hover {
            border-bottom-color: #0b8f66;
            color: #065a3f;
            transform: scale(1.02);
        }
        .back-link {
            margin-top: 18px;
            text-align: center;
            width: 100%;
        }
        .back-link a {
            color: #0b8f66;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s ease;
            border-bottom: 1.5px solid transparent;
            padding-bottom: 2px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .back-link a:hover {
            border-bottom-color: #0b8f66;
            color: #065a3f;
            transform: translateX(-3px);
        }
        .footer-copy {
            margin-top: 22px;
            color: #4f6b62;
            font-size: 12px;
            letter-spacing: 0.3px;
            opacity: 0.6;
            transition: opacity 0.3s;
        }
        .footer-copy:hover { opacity: 1; }
        @media (max-width: 820px) {
            body { flex-direction: column; }
            .left-side { height: 38vh; border-radius: 0 0 40px 40px; }
            .left-card { padding: 28px 24px; max-width: 90%; animation: slideFadeIn 1s cubic-bezier(0.23, 1, 0.32, 1), softFloatMobile 4s infinite alternate ease-in-out; }
            @keyframes softFloatMobile {
                0% { transform: translateY(0px); }
                100% { transform: translateY(-8px); }
            }
            .left-card h1 { font-size: 2.2rem; }
            .otp-box {
                width: 100%;
                height: auto;
                padding: 36px 24px;
                border-radius: 40px 40px 0 0;
                box-shadow: 0 -8px 30px rgba(0,0,0,0.04);
                backdrop-filter: blur(24px);
                margin-top: -20px;
                border: 1px solid rgba(255,255,255,0.3);
            }
            .otp-box img.logo { width: 90px; height: 90px; animation: logoEntranceMobile 0.9s cubic-bezier(0.34, 1.56, 0.64, 1), logoPulseMobile 3s infinite alternate 0.5s; }
            @keyframes logoEntranceMobile {
                0% { opacity: 0; transform: scale(0.2) rotate(-20deg) translateY(40px); }
                60% { transform: scale(1.1) rotate(3deg) translateY(-10px); }
                100% { opacity: 1; transform: scale(1) rotate(0) translateY(0); }
            }
            @keyframes logoPulseMobile {
                0% { transform: scale(1) translateY(0); }
                100% { transform: scale(1.04) translateY(-6px); }
            }
            .otp-input input { width: 48px; height: 58px; font-size: 24px; }
            .orb-1, .orb-2, .orb-3 { display: none; }
        }
        @media (max-width: 480px) {
            .left-card { padding: 20px 16px; }
            .left-card h1 { font-size: 1.8rem; }
            .otp-box { padding: 28px 16px; }
            .otp-input input { width: 42px; height: 50px; font-size: 20px; gap: 8px; }
            .otp-input { gap: 8px; }
        }
    </style>
</head>
<body>

    <!-- LEFT SIDE -->
    <div class="left-side">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="left-card">
            <h1>Verify Your Identity</h1>
            <p>Please enter the 6-digit verification code sent to your email to complete your login.</p>
        </div>
    </div>

    <!-- OTP BOX -->
    <div class="otp-box">
        @if($logoExists)
            <img src="{{ asset('storage/' . $pharmacyLogo) }}" alt="{{ $pharmacyName }} Logo" class="logo" loading="lazy">
        @else
            <img src="{{ asset('logo-pharmacy.jpg') }}" alt="Pharmacy Logo" class="logo" loading="lazy">
        @endif

        <h2>{{ $pharmacyName }} · Verify OTP</h2>

        <p class="sub-text">
            We've sent a 6-digit verification code to <br><strong>{{ $user->email ?? session('temp_user.email') ?? 'your email' }}</strong>
        </p>

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if (session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="verifying-overlay" id="verifyingOverlay">
            <div class="spinner"></div>
            <span>Verifying code...</span>
        </div>

        <form action="{{ route('otp.verify.post') }}" method="POST" id="otpForm">
            @csrf
            <div class="otp-input">
                <input type="text" maxlength="1" class="otp-digit" data-index="0" autofocus inputmode="numeric" pattern="[0-9]">
                <input type="text" maxlength="1" class="otp-digit" data-index="1" inputmode="numeric" pattern="[0-9]">
                <input type="text" maxlength="1" class="otp-digit" data-index="2" inputmode="numeric" pattern="[0-9]">
                <input type="text" maxlength="1" class="otp-digit" data-index="3" inputmode="numeric" pattern="[0-9]">
                <input type="text" maxlength="1" class="otp-digit" data-index="4" inputmode="numeric" pattern="[0-9]">
                <input type="text" maxlength="1" class="otp-digit" data-index="5" inputmode="numeric" pattern="[0-9]">
            </div>
            <input type="hidden" name="otp" id="otp-hidden">

            <div class="remember-me">
                <input type="checkbox" name="remember" id="remember" value="1" checked>
                <label for="remember">Don't ask again on this device for 30 days</label>
            </div>

            <button type="submit" class="btn-verify" id="verifyBtn">
                <i class="fas fa-check me-2"></i> Verify OTP
            </button>
        </form>

        <div class="timer" id="timer">Resend available in <span id="countdown">60</span> seconds</div>
        <a href="#" id="resendOtp" class="resend-link"><i class="fas fa-redo" style="margin-right: 5px;"></i> Resend OTP Code</a>

        <div class="back-link">
            <a href="{{ route('login') }}"><i class="fas fa-arrow-left"></i> Back to Login</a>
        </div>

        <form id="resendForm" action="{{ route('otp.resend') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <p class="footer-copy">© {{ date('Y') }} {{ $pharmacyName }}. All rights reserved.</p>
    </div>

    <script>
    (function() {
        const digits = document.querySelectorAll('.otp-digit');
        const hiddenInput = document.getElementById('otp-hidden');
        const form = document.getElementById('otpForm');
        const overlay = document.getElementById('verifyingOverlay');
        const verifyBtn = document.getElementById('verifyBtn');
        let isSubmitting = false;

        // ✅ Timer references
        const timerElement = document.getElementById('countdown');
        const resendLink = document.getElementById('resendOtp');
        const timerDiv = document.getElementById('timer');
        let countdownInterval = null;
        let timeLeft = 60;

        function updateHiddenInput() {
            let otp = '';
            digits.forEach(digit => { otp += digit.value; });
            hiddenInput.value = otp;
            return otp;
        }

        function checkAndSubmit() {
            // ✅ Huwag mag-submit kung disabled na ang inputs (expired na ang OTP)
            if (digits[0].disabled) return;

            let otp = updateHiddenInput();
            let filled = true;
            for (let i = 0; i < 6; i++) {
                if (digits[i].value.length !== 1) {
                    filled = false;
                    break;
                }
            }

            if (filled && !isSubmitting) {
                isSubmitting = true;
                overlay.style.display = 'flex';
                digits.forEach(d => d.classList.add('otp-complete'));
                verifyBtn.disabled = true;
                verifyBtn.innerHTML = '<i class="fas fa-spinner fa-pulse me-2"></i> Verifying...';

                setTimeout(() => {
                    form.submit();
                }, 400);
            }
        }

        // ✅ I-enable / i-disable ang OTP inputs
        function setOtpInputsEnabled(enabled) {
            digits.forEach(d => {
                d.disabled = !enabled;
                if (!enabled) {
                    d.classList.remove('otp-complete');
                }
            });
            verifyBtn.disabled = !enabled;
            if (enabled) {
                verifyBtn.innerHTML = '<i class="fas fa-check me-2"></i> Verify OTP';
            }
        }

        // ✅ Simulan ang countdown
        function startCountdown() {
            // Clear any existing interval
            if (countdownInterval) clearInterval(countdownInterval);

            timeLeft = 60;
            timerElement.textContent = timeLeft;
            timerDiv.style.display = 'block';
            resendLink.style.display = 'none';

            countdownInterval = setInterval(() => {
                if (timeLeft <= 0) {
                    clearInterval(countdownInterval);
                    countdownInterval = null;
                    timerDiv.style.display = 'none';
                    resendLink.style.display = 'inline-block';

                    // ✅ I-disable ang OTP inputs at verify button pag expired na
                    setOtpInputsEnabled(false);
                    isSubmitting = false;
                    overlay.style.display = 'none';
                } else {
                    timerElement.textContent = timeLeft;
                    timeLeft--;
                }
            }, 1000);
        }

        digits.forEach((digit, index) => {
            digit.addEventListener('input', function(e) {
                this.value = this.value.replace(/\D/g, '');
                if (this.value.length === 1 && index < 5) {
                    digits[index + 1].focus();
                }
                checkAndSubmit();
            });

            digit.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && this.value.length === 0 && index > 0) {
                    digits[index - 1].focus();
                    digits.forEach(d => d.classList.remove('otp-complete'));
                    overlay.style.display = 'none';
                    isSubmitting = false;
                    verifyBtn.disabled = false;
                    verifyBtn.innerHTML = '<i class="fas fa-check me-2"></i> Verify OTP';
                }
                if (e.key === 'ArrowLeft' && index > 0) {
                    e.preventDefault();
                    digits[index - 1].focus();
                }
                if (e.key === 'ArrowRight' && index < 5) {
                    e.preventDefault();
                    digits[index + 1].focus();
                }
            });

            digit.addEventListener('paste', function(e) {
                e.preventDefault();
                if (digits[0].disabled) return; // ✅ Huwag mag-paste kung disabled
                const paste = (e.clipboardData || window.clipboardData).getData('text');
                if (paste && paste.length === 6 && /^\d+$/.test(paste)) {
                    for(let i = 0; i < 6 && i < paste.length; i++) {
                        if(digits[i]) {
                            digits[i].value = paste[i];
                        }
                    }
                    if (digits[5]) digits[5].focus();
                    checkAndSubmit();
                }
            });

            digit.addEventListener('focus', function() {
                this.select();
            });
        });

        form.addEventListener('submit', function() {
            verifyBtn.disabled = true;
            verifyBtn.innerHTML = '<i class="fas fa-spinner fa-pulse me-2"></i> Verifying...';
        });

        function getParameterByName(name) {
            const url = window.location.href;
            name = name.replace(/[\[\]]/g, '\\$&');
            const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
            const results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

        const otpCode = getParameterByName('code');
        if (otpCode && otpCode.length === 6 && /^\d+$/.test(otpCode)) {
            for (let i = 0; i < otpCode.length && i < digits.length; i++) {
                digits[i].value = otpCode[i];
            }
            updateHiddenInput();
            setTimeout(function() {
                overlay.style.display = 'flex';
                digits.forEach(d => d.classList.add('otp-complete'));
                verifyBtn.disabled = true;
                verifyBtn.innerHTML = '<i class="fas fa-spinner fa-pulse me-2"></i> Verifying...';
                setTimeout(() => {
                    form.submit();
                }, 400);
            }, 600);
        }

        // ✅ Resend click — i-enable ulit at i-restart ang countdown
        resendLink.addEventListener('click', function(e) {
            e.preventDefault();

            // I-enable ulit ang OTP inputs at i-clear
            digits.forEach(d => {
                d.value = '';
                d.disabled = false;
                d.classList.remove('otp-complete');
            });
            hiddenInput.value = '';
            isSubmitting = false;
            overlay.style.display = 'none';

            // I-restart ang countdown
            startCountdown();

            // I-focus ang unang input
            digits[0].focus();

            // I-submit ang resend form
            document.getElementById('resendForm').submit();
        });

        // ✅ Simulan ang countdown sa page load
        startCountdown();
    })();
    </script>
</body>
</html>