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
  <title>{{ $pharmacyName }} · Login</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    /* ----- reset & base ----- */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Inter", "Segoe UI", system-ui, -apple-system, sans-serif;
    }

    body {
      display: flex;
      min-height: 100vh;
      background: #f0f5fe;
      transition: background 0.3s ease;
    }

    /* ----- left side (glassmorphism + floating orbs) ----- */
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

    /* animated floating orbs (2026 vibe) */
    .orb {
      position: absolute;
      border-radius: 50%;
      filter: blur(70px);
      opacity: 0.35;
      z-index: 0;
      animation: floatOrb 18s infinite alternate ease-in-out;
      pointer-events: none;
    }
    .orb-1 {
      width: 300px;
      height: 300px;
      background: #4dd0a8;
      top: -5%;
      left: -10%;
      animation-duration: 22s;
    }
    .orb-2 {
      width: 400px;
      height: 400px;
      background: #3f8ef0;
      bottom: -15%;
      right: -10%;
      animation-duration: 28s;
      animation-delay: -5s;
    }
    .orb-3 {
      width: 180px;
      height: 180px;
      background: #b48aff;
      top: 40%;
      right: 5%;
      animation-duration: 16s;
      animation-delay: -2s;
      opacity: 0.25;
    }

    @keyframes floatOrb {
      0% { transform: translate(0, 0) scale(1); }
      100% { transform: translate(30px, -40px) scale(1.2); }
    }

    /* LEFT CARD — enhanced with floating + bounce + glow */
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
    .left-card:hover {
      transform: scale(1.02) translateY(-4px);
      box-shadow: 0 35px 70px -10px rgba(0,0,0,0.5), 0 0 0 2px rgba(255,255,255,0.1);
    }

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

    /* ----- right side (login box) — neubrutalism + glass ----- */
    .login-box {
      width: 440px;
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(20px) saturate(180%);
      -webkit-backdrop-filter: blur(20px) saturate(180%);
      padding: 52px 40px;
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
    .login-box:hover {
      box-shadow: -8px 0 40px rgba(0, 0, 0, 0.06), 0 30px 60px -12px rgba(0,0,0,0.20);
    }

    @keyframes fadeInRight {
      0% { opacity: 0; transform: translateX(50px) scale(0.97); }
      100% { opacity: 1; transform: translateX(0) scale(1); }
    }

    /* LOGO — enhanced with jump + spin + pulse */
    .login-box img.logo {
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
    .login-box img.logo:hover {
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

    .login-box h2 {
      color: #0d7a5a;
      font-weight: 650;
      font-size: 20px;
      letter-spacing: -0.01em;
      margin-bottom: 28px;
      text-align: center;
      background: linear-gradient(145deg, #0b8f66, #0b6b4f);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    .login-box form {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 100%;
      gap: 6px;
    }

    /* input-group with floating label effect (2026) */
    .input-group {
      width: 100%;
      position: relative;
      margin: 6px 0;
    }

    .input-group input {
      width: 100%;
      padding: 12px 16px;
      border: 1.5px solid rgba(0, 0, 0, 0.06);
      border-radius: 18px;
      background: rgba(255, 255, 255, 0.6);
      backdrop-filter: blur(4px);
      -webkit-backdrop-filter: blur(4px);
      transition: all 0.25s ease;
      font-size: 14px;
      height: 50px;
      color: #152b24;
      font-weight: 500;
      box-shadow: inset 0 2px 6px rgba(0,0,0,0.01), 0 2px 4px rgba(0,0,0,0.02);
    }

    .input-group input:focus {
      border-color: #0b8f66;
      background: rgba(255, 255, 255, 0.9);
      box-shadow: 0 4px 14px rgba(11, 143, 102, 0.18), inset 0 1px 0 #fff;
      outline: none;
      transform: scale(1.01);
    }

    .input-group .input-icon {
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: #0b8f66;
      opacity: 0.5;
      font-size: 15px;
      transition: opacity 0.3s ease;
      pointer-events: none;
    }
    .input-group input:focus + .input-icon {
      opacity: 1;
    }

    /* modern button */
    .login-box button {
      width: 100%;
      padding: 12px;
      background: #0b8f66;
      color: white;
      border: none;
      border-radius: 40px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 16px;
      transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
      letter-spacing: 0.3px;
      box-shadow: 0 8px 20px -6px rgba(11, 143, 102, 0.35);
      position: relative;
      overflow: hidden;
    }

    .login-box button::after {
      content: "";
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at 30% 50%, rgba(255,255,255,0.25), transparent 70%);
      opacity: 0;
      transition: opacity 0.4s ease;
    }
    .login-box button:hover::after {
      opacity: 1;
    }

    .login-box button:hover {
      background: #08704f;
      transform: translateY(-2px) scale(1.01);
      box-shadow: 0 14px 28px -8px rgba(11, 143, 102, 0.5);
    }
    .login-box button:active {
      transform: scale(0.97);
    }

    /* alerts with glass */
    .alert {
      padding: 12px 18px;
      border-radius: 30px;
      margin-bottom: 14px;
      width: 100%;
      text-align: center;
      font-weight: 500;
      backdrop-filter: blur(6px);
      border: 1px solid rgba(255,255,255,0.3);
      animation: alertPop 0.5s ease;
    }
    @keyframes alertPop {
      0% { opacity: 0; transform: translateY(-12px) scale(0.95); }
      100% { opacity: 1; transform: translateY(0) scale(1); }
    }
    .alert-success {
      background: rgba(212, 237, 218, 0.7);
      color: #0e542a;
      border-color: #b7dfb9;
    }
    .alert-error {
      background: rgba(248, 215, 218, 0.7);
      color: #7f2a31;
      border-color: #f5c6cb;
    }

    /* forgot password link */
    .forgot-link {
      text-align: center;
      margin-top: 14px;
    }
    .forgot-link a {
      color: #0b8f66;
      text-decoration: none;
      font-size: 13px;
      font-weight: 500;
      transition: all 0.2s ease;
      border-bottom: 1.5px solid transparent;
      padding-bottom: 2px;
    }
    .forgot-link a:hover {
      border-bottom-color: #0b8f66;
      color: #065a3f;
    }

    .footer-copy {
      margin-top: 28px;
      color: #4f6b62;
      font-size: 12px;
      letter-spacing: 0.3px;
      opacity: 0.7;
      transition: opacity 0.3s;
    }
    .footer-copy:hover {
      opacity: 1;
    }

    /* responsive */
    @media (max-width: 820px) {
      body {
        flex-direction: column;
      }
      .left-side {
        height: 40vh;
        border-radius: 0 0 40px 40px;
      }
      .left-card {
        padding: 28px 24px;
        max-width: 90%;
        animation: slideFadeIn 1s cubic-bezier(0.23, 1, 0.32, 1), softFloatMobile 4s infinite alternate ease-in-out;
      }
      @keyframes softFloatMobile {
        0% { transform: translateY(0px); }
        100% { transform: translateY(-8px); }
      }
      .left-card h1 {
        font-size: 2.2rem;
      }
      .login-box {
        width: 100%;
        height: auto;
        padding: 36px 24px;
        border-radius: 40px 40px 0 0;
        box-shadow: 0 -8px 30px rgba(0,0,0,0.04);
        backdrop-filter: blur(24px);
        margin-top: -20px;
        border: 1px solid rgba(255,255,255,0.3);
      }
      .login-box img.logo {
        width: 90px;
        height: 90px;
        animation: logoEntranceMobile 0.9s cubic-bezier(0.34, 1.56, 0.64, 1), logoPulseMobile 3s infinite alternate 0.5s;
      }
      @keyframes logoEntranceMobile {
        0% { opacity: 0; transform: scale(0.2) rotate(-20deg) translateY(40px); }
        60% { transform: scale(1.1) rotate(3deg) translateY(-10px); }
        100% { opacity: 1; transform: scale(1) rotate(0) translateY(0); }
      }
      @keyframes logoPulseMobile {
        0% { transform: scale(1) translateY(0); }
        100% { transform: scale(1.04) translateY(-6px); }
      }
      .orb-1, .orb-2, .orb-3 {
        display: none;
      }
    }

    @media (max-width: 480px) {
      .left-card {
        padding: 20px 16px;
      }
      .left-card h1 {
        font-size: 1.8rem;
      }
      .login-box {
        padding: 28px 16px;
      }
      .input-group input {
        height: 44px;
        font-size: 13px;
        padding: 8px 14px;
      }
      .login-box button {
        font-size: 15px;
        padding: 10px;
      }
    }
  </style>
</head>
<body>
  <!-- left side with orbs -->
  <div class="left-side">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="left-card">
      <h1>Welcome to {{ $pharmacyName }}!</h1>
      <p>Log in with your username and password to access the Pharmacy Management System.</p>
    </div>
  </div>

  <!-- login box -->
  <div class="login-box">
    @if($logoExists)
      <img src="{{ asset('storage/' . $pharmacyLogo) }}" alt="{{ $pharmacyName }} Logo" class="logo" loading="lazy">
    @else
      <img src="{{ asset('logo-pharmacy.jpg') }}" alt="Pharmacy Logo" class="logo" loading="lazy">
    @endif

    <h2>{{ $pharmacyName }} · System Login</h2>

    @if (session('error'))
      <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
      @csrf

      <div class="input-group">
        <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required autocomplete="email">
        <i class="fas fa-envelope input-icon"></i>
      </div>

      <div class="input-group">
        <input type="password" id="password" name="password" placeholder="Password" required autocomplete="current-password">
        <i class="fas fa-lock input-icon"></i>
      </div>

      <button type="submit">
        <span>Log In</span>
        <i class="fas fa-arrow-right" style="margin-left: 8px; font-size: 13px; opacity: 0.7;"></i>
      </button>

      <div class="forgot-link">
        <a href="{{ route('forgot.password') }}">
          <i class="fas fa-key" style="margin-right: 5px; font-size: 11px;"></i> Forgot Password?
        </a>
      </div>
    </form>

    {{-- REMOVED: Create an Account and Forgot Password links --}}

    <p class="footer-copy">© {{ date('Y') }} {{ $pharmacyName }}. All rights reserved.</p>
  </div>

  <script>
    (function() {
      // toggle password visibility
      const toggleBtn = document.querySelector("#togglePassword");
      const passwordField = document.querySelector("#password");
      if (toggleBtn && passwordField) {
        toggleBtn.addEventListener("click", function () {
          const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
          passwordField.setAttribute("type", type);
          this.classList.toggle("fa-eye-slash");
        });
      }

      // extra: floating label effect
      const inputs = document.querySelectorAll(".input-group input");
      inputs.forEach(input => {
        input.addEventListener("focus", function() {
          this.closest(".input-group")?.classList.add("focused");
        });
        input.addEventListener("blur", function() {
          this.closest(".input-group")?.classList.remove("focused");
        });
      });
    })();
  </script>
</body>
</html>