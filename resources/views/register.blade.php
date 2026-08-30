<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account - Pharmacy System</title>
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
      overflow: hidden;
    }

    .left-side {
      flex: 1;
      background: url('background-pharmacy.jpg') center center/cover no-repeat;
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
      background: rgba(0, 0, 0, 0.4);
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
      letter-spacing: 1px;
    }

    .left-card p {
      font-size: 1.05rem;
      color: #e0f7ef;
      line-height: 1.6;
    }

    @keyframes slideFadeIn {
      from { opacity: 0; transform: translateX(-40px); }
      to { opacity: 1; transform: translateX(0); }
    }

    .form-box {
      width: 460px;
      background: rgba(255, 255, 255, 0.97);
      padding: 60px 50px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      box-shadow: -3px 0 12px rgba(0, 0, 0, 0.15);
      border-top-left-radius: 20px;
      border-bottom-left-radius: 20px;
      animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateX(40px); }
      to { opacity: 1; transform: translateX(0); }
    }

    .form-box img.logo {
      width: 130px;
      margin-bottom: 20px;
      transition: opacity 0.3s ease;
    }

    .form-box img.logo:hover { opacity: 0.85; }

    .form-box h2 {
      color: #0b8f66;
      margin-bottom: 30px;
      font-size: 24px;
      font-weight: 600;
      text-align: center;
    }

    .input-group {
      width: 100%;
      position: relative;
      margin: 12px 0;
    }

    .input-group input {
      width: 100%;
      padding: 14px 16px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background-color: #f5f9ff;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
      font-size: 15px;
      height: 48px;
    }

    .input-group input:focus {
      border-color: #0b8f66;
      box-shadow: 0 0 5px rgba(11, 143, 102, 0.3);
      outline: none;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #0b8f66;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      margin-top: 18px;
      transition: all 0.3s ease;
    }

    button:hover {
      background-color: #08704f;
      transform: scale(1.02);
    }

    .login-link {
      margin-top: 20px;
      font-size: 15px;
    }

    .login-link a {
      color: #0b8f66;
      text-decoration: none;
      font-weight: 500;
    }

    .login-link a:hover {
      text-decoration: underline;
      color: #08704f;
    }

    p.footer {
      margin-top: 30px;
      color: #666;
      font-size: 13px;
      text-align: center;
    }

    .alert {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border-radius: 6px;
      font-size: 14px;
      text-align: center;
    }

    .alert-success {
      background: #e7f9ef;
      color: #0b8f66;
      border: 1px solid #b7e4c7;
    }

    .alert-error {
      background: #fdeaea;
      color: #c1121f;
      border: 1px solid #f5c2c2;
    }

    @media (max-width: 768px) {
      body { flex-direction: column; }
      .left-side { height: 40%; }
      .form-box {
        width: 100%;
        height: 60%;
        border-radius: 0;
        box-shadow: none;
      }
      .left-card { padding: 30px; }
      .left-card h1 { font-size: 1.8rem; }
      .left-card p { font-size: 1rem; }
    }
  </style>
</head>
<body>
  <div class="left-side">
    <div class="left-card">
      <h1>Join Us!</h1>
      <p>Create your account to access the Pharmacy Management System.</p>
    </div>
  </div>

  <div class="form-box">
    <img src="logo-pharmacy.jpg" alt="Pharmacy Logo" class="logo">
    <h2>Create Account</h2>

    {{-- ✅ Success Message --}}
    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ❌ Validation Errors --}}
    @if ($errors->any())
      <div class="alert alert-error">
        <ul style="list-style:none; padding:0; margin:0;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST">
      @csrf
      <div class="input-group">
        {{-- Add this to your register.blade.php form --}}
<div class="input-group">
    <input type="text" name="full_name" placeholder="Full Name (Optional)" value="{{ old('full_name') }}">
</div>
        <input type="text" name="username" placeholder="Username" value="{{ old('username') }}" required>
      </div>
      <div class="input-group">
        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
      </div>
      <div class="input-group">
        <input type="password" name="password" placeholder="Password" required>
      </div>
      <div class="input-group">
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
      </div>
      <button type="submit">Create Account</button>
    </form>

    <div class="login-link">
      Already have an account? <a href="{{ route('login') }}">Log in</a>
    </div>

    <p class="footer">© 2025 Pharmacy Management System</p>
  </div>
</body>
</html>
