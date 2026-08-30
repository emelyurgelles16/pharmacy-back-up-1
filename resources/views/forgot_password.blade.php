<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Pharmacy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        body {
            display: flex;
            height: 100vh;
            background: #f8fcff;
        }

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
        }

        .left-side::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 0;
        }

        .left-card {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 16px;
            padding: 35px 45px;
            max-width: 400px;
            animation: slideFadeIn 1s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .left-card h1 {
            font-size: 2.3rem;
            font-weight: 700;
            color: #aef1d9;
            margin-bottom: 10px;
        }

        .left-card p {
            font-size: 1.05rem;
            color: #e0f7ef;
            line-height: 1.6;
        }

        @keyframes slideFadeIn {
            from {
                opacity: 0;
                transform: translateX(-40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .right-side {
            width: 420px;
            background: rgba(255, 255, 255, 0.95);
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: -3px 0 12px rgba(0, 0, 0, 0.15);
            border-top-left-radius: 16px;
            border-bottom-left-radius: 16px;
            animation: fadeIn 0.8s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateX(40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .right-side h2 {
            color: #0b8f66;
            margin-bottom: 20px;
            font-size: 22px;
            font-weight: 600;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        input {
            width: 85%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
            background-color: #f5f9ff;
            font-size: 14px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input:focus {
            border-color: #0b8f66;
            box-shadow: 0 0 4px rgba(11, 143, 102, 0.3);
            outline: none;
            background-color: #e8fff5;
        }

        button {
            width: 85%;
            padding: 10px;
            border: none;
            border-radius: 6px;
            background-color: #0b8f66;
            color: white;
            font-size: 15px;
            cursor: pointer;
            margin-top: 14px;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #08704f;
            transform: scale(1.02);
        }

        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .links {
            margin-top: 15px;
            text-align: center;
        }

        .links a {
            text-decoration: none;
            color: #0b8f66;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .links a:hover {
            text-decoration: underline;
            color: #08704f;
        }

        .alert {
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            width: 85%;
            text-align: center;
            font-size: 14px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        /* ✅ Countdown Timer */
        .timer-container {
            width: 85%;
            margin-top: 10px;
            text-align: center;
        }

        .timer-container .timer-bar {
            width: 100%;
            height: 6px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 6px;
        }

        .timer-container .timer-bar .timer-progress {
            height: 100%;
            background: linear-gradient(90deg, #0b8f66, #08704f);
            border-radius: 4px;
            transition: width 1s linear;
            width: 100%;
        }

        .timer-container .timer-text {
            font-size: 13px;
            color: #6c757d;
        }

        .timer-container .timer-text strong {
            color: #0b8f66;
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            .left-side {
                height: 40%;
            }
            .right-side {
                width: 100%;
                height: 60%;
                border-radius: 0;
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <!-- LEFT SIDE -->
    <div class="left-side">
        <div class="left-card">
            <h1>Reset Your Password</h1>
            <p>Enter your registered email address and we'll send you instructions to reset your password.</p>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="right-side">
        <h2>Forgot Password</h2>

        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif

        <form method="POST" action="{{ route('forgot.password.submit') }}" id="forgotForm">
            @csrf
            <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required>
            <input type="email" name="email" placeholder="Email address" value="{{ old('email') }}" required>
            <button type="submit" id="submitBtn">Send Reset Link</button>

            @error('username')
                <p style="color:red; font-size:12px; margin-top:5px;">{{ $message }}</p>
            @enderror
            @error('email')
                <p style="color:red; font-size:12px; margin-top:5px;">{{ $message }}</p>
            @enderror

            <div class="links">
                <a href="{{ route('login') }}"><i class="fas fa-arrow-left"></i> Back to Login</a>
            </div>
        </form>

        {{-- ✅ COUNTDOWN TIMER --}}
        <div class="timer-container" id="timerContainer" style="display: none;">
            <div class="timer-text">
                <i class="fas fa-clock"></i> Please wait <strong id="timerSeconds">60</strong> seconds before trying again.
            </div>
            <div class="timer-bar">
                <div class="timer-progress" id="timerProgress"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('forgotForm');
            const submitBtn = document.getElementById('submitBtn');
            const timerContainer = document.getElementById('timerContainer');
            const timerSeconds = document.getElementById('timerSeconds');
            const timerProgress = document.getElementById('timerProgress');

            // ✅ Check if there's an error message about waiting
            const errorMsg = document.querySelector('.alert-error');
            if (errorMsg && errorMsg.textContent.includes('Please wait')) {
                startCountdown();
            }

            // ✅ Also check if there's a "success" message (don't show timer)
            const successMsg = document.querySelector('.alert-success');
            if (successMsg) {
                // Success - no timer needed
            }

            function startCountdown() {
                let seconds = 60;
                timerContainer.style.display = 'block';
                submitBtn.disabled = true;
                submitBtn.textContent = 'Wait...';
                submitBtn.style.background = '#ccc';

                const interval = setInterval(function() {
                    seconds--;
                    timerSeconds.textContent = seconds;
                    timerProgress.style.width = (seconds / 60) * 100 + '%';

                    if (seconds <= 0) {
                        clearInterval(interval);
                        timerContainer.style.display = 'none';
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Send Reset Link';
                        submitBtn.style.background = '#0b8f66';
                    }
                }, 1000);
            }

            // ✅ If there's an error, check if it's the rate limit error
            if (errorMsg) {
                const text = errorMsg.textContent;
                if (text.includes('Please wait') || text.includes('minute')) {
                    // Extract seconds if available
                    const match = text.match(/(\d+)\s*second/);
                    if (match) {
                        let secs = parseInt(match[1]);
                        if (secs > 0 && secs <= 60) {
                            startCountdown();
                        } else {
                            startCountdown();
                        }
                    } else {
                        startCountdown();
                    }
                }
            }

            // ✅ Form submit - show loading state
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            });
        });
    </script>
</body>

</html>