<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password - Pharmacy</title>
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
      background: url('/background-pharmacy.jpg') center center / cover no-repeat;
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
      background: rgba(0, 0, 0, 0.2);
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
      width: 480px;
      background: rgba(255, 255, 255, 0.95);
      padding: 40px 35px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      box-shadow: -3px 0 12px rgba(0, 0, 0, 0.15);
      border-top-left-radius: 16px;
      border-bottom-left-radius: 16px;
      animation: fadeIn 0.8s ease;
      overflow-y: auto;
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
      margin-bottom: 10px;
      font-size: 24px;
      font-weight: 600;
      text-align: center;
    }

    .subtitle {
      text-align: center;
      color: #666;
      margin-bottom: 25px;
      font-size: 14px;
    }

    form {
      display: flex;
      flex-direction: column;
      width: 100%;
    }

    .input-group {
      position: relative;
      width: 100%;
      margin-bottom: 15px;
    }

    .input-group input {
      width: 100%;
      padding: 12px 40px 12px 15px;
      border-radius: 8px;
      border: 1px solid #ddd;
      background-color: #f5f9ff;
      font-size: 14px;
      transition: all 0.3s ease;
    }

    .input-group input:focus {
      border-color: #0b8f66;
      box-shadow: 0 0 4px rgba(11, 143, 102, 0.3);
      outline: none;
      background-color: #e8fff5;
    }

    .input-group input.error {
      border-color: #dc3545;
      background-color: #fff5f5;
    }

    .input-group input.success {
      border-color: #28a745;
      background-color: #f0fff4;
    }

    .input-group i {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #999;
    }

    .input-group i.success-icon {
      right: 40px;
      color: #28a745;
      cursor: default;
    }

    /* Password Requirements */
    .password-requirements {
      background: #f8f9fa;
      border-radius: 8px;
      padding: 12px 15px;
      margin-bottom: 20px;
      font-size: 12px;
    }

    .password-requirements p {
      margin-bottom: 8px;
      font-weight: 600;
      color: #333;
    }

    .requirement {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 5px;
      color: #666;
      font-size: 12px;
    }

    .requirement i {
      width: 16px;
      font-size: 12px;
    }

    .requirement.valid {
      color: #28a745;
    }

    .requirement.invalid {
      color: #dc3545;
    }

    /* Password Match Indicator */
    .match-status {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-top: -10px;
      margin-bottom: 15px;
      font-size: 12px;
    }

    .match-status i {
      font-size: 14px;
    }

    .match-status .match {
      color: #28a745;
    }

    .match-status .no-match {
      color: #dc3545;
    }

    button {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      background-color: #0b8f66;
      color: white;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      margin-top: 10px;
      transition: all 0.3s ease;
    }

    button:hover:not(:disabled) {
      background-color: #08704f;
      transform: scale(1.02);
    }

    button:disabled {
      background-color: #ccc;
      cursor: not-allowed;
    }

    .links {
      margin-top: 20px;
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

    .error-message {
      color: #dc3545;
      font-size: 12px;
      margin-top: 5px;
      text-align: center;
    }

    .success-message {
      color: #28a745;
      font-size: 12px;
      margin-top: 5px;
      text-align: center;
    }

    @media (max-width: 768px) {
      body {
        flex-direction: column;
      }

      .left-side {
        height: 35%;
      }

      .right-side {
        width: 100%;
        height: 65%;
        border-radius: 0;
        box-shadow: none;
        padding: 25px;
      }
      
    }
  </style>
</head>

<body>
  <div class="left-side">
    <div class="left-card">
      <h1>Reset Password</h1>
      <p>Enter and confirm your new password to regain access to your Pharmacy account securely.</p>
    </div>
  </div>

  <div class="right-side">
    <h2>Set New Password</h2>
    <p class="subtitle">Create a strong password for your account</p>
    <p class="subtitle" style="color: #0b8f66;">Resetting password for: <strong>{{ $username ?? '' }}</strong></p>

    {{-- Display error or success messages --}}
    @if (session('error'))
      <p class="error-message">{{ session('error') }}</p>
    @endif
    @if (session('success'))
      <p class="success-message">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('reset.password.submit') }}" id="resetPasswordForm">
      @csrf

      <input type="hidden" name="token" value="{{ $token ?? '' }}">
      <input type="hidden" name="email" value="{{ $email ?? '' }}">
      <input type="hidden" name="username" value="{{ $username ?? '' }}">

      <!-- New Password Field -->
      <div class="input-group">
        <input type="password" id="password" name="password" placeholder="New password" required>
        <i class="fa fa-eye" id="togglePassword"></i>
      </div>

      <!-- Password Requirements -->
      <div class="password-requirements">
        <p>Password must contain:</p>
        <div class="requirement" id="req-length">
          <i class="fa fa-circle"></i> <span>At least 8 characters</span>
        </div>
        <div class="requirement" id="req-upper">
          <i class="fa fa-circle"></i> <span>At least 1 uppercase letter (A-Z)</span>
        </div>
        <div class="requirement" id="req-lower">
          <i class="fa fa-circle"></i> <span>At least 1 lowercase letter (a-z)</span>
        </div>
        <div class="requirement" id="req-number">
          <i class="fa fa-circle"></i> <span>At least 1 number (0-9)</span>
        </div>
      </div>

      <!-- Confirm Password Field -->
      <div class="input-group">
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" required>
        <i class="fa fa-eye" id="toggleConfirm"></i>
      </div>

      <!-- Password Match Status -->
      <div class="match-status" id="match-status" style="display: none;">
        <i class="fa"></i> <span></span>
      </div>

      @error('password')
        <p class="error-message">{{ $message }}</p>
      @enderror

      <button type="submit" id="submitBtn" disabled>Reset Password</button>

      <div class="links">
        <a href="{{ route('login') }}">← Back to Login</a>
      </div>
    </form>
  </div>

  <script>
    const password = document.getElementById('password');
    const confirm = document.getElementById('password_confirmation');
    const submitBtn = document.getElementById('submitBtn');
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirm = document.getElementById('toggleConfirm');
    const matchStatus = document.getElementById('match-status');

    // Requirements elements
    const reqLength = document.getElementById('req-length');
    const reqUpper = document.getElementById('req-upper');
    const reqLower = document.getElementById('req-lower');
    const reqNumber = document.getElementById('req-number');

    // Check password requirements
    function checkRequirements() {
      const val = password.value;
      
      // Length check
      const isValidLength = val.length >= 8;
      updateRequirement(reqLength, isValidLength);
      
      // Uppercase check
      const isValidUpper = /[A-Z]/.test(val);
      updateRequirement(reqUpper, isValidUpper);
      
      // Lowercase check
      const isValidLower = /[a-z]/.test(val);
      updateRequirement(reqLower, isValidLower);
      
      // Number check
      const isValidNumber = /[0-9]/.test(val);
      updateRequirement(reqNumber, isValidNumber);
      
      const allValid = isValidLength && isValidUpper && isValidLower && isValidNumber;
      
      // Update password input styling
      if (val.length > 0) {
        if (allValid) {
          password.classList.add('success');
          password.classList.remove('error');
        } else {
          password.classList.add('error');
          password.classList.remove('success');
        }
      } else {
        password.classList.remove('success', 'error');
      }
      
      checkMatch();
      return allValid;
    }
    
    function updateRequirement(element, isValid) {
      const icon = element.querySelector('i');
      if (isValid) {
        element.classList.add('valid');
        element.classList.remove('invalid');
        icon.classList.remove('fa-circle');
        icon.classList.add('fa-check-circle');
      } else {
        element.classList.add('invalid');
        element.classList.remove('valid');
        icon.classList.remove('fa-check-circle');
        icon.classList.add('fa-circle');
      }
    }
    
    // Check if passwords match
    function checkMatch() {
      const passwordVal = password.value;
      const confirmVal = confirm.value;
      
      if (confirmVal.length === 0) {
        matchStatus.style.display = 'none';
        confirm.classList.remove('success', 'error');
        return false;
      }
      
      const isMatch = passwordVal === confirmVal;
      matchStatus.style.display = 'flex';
      
      if (isMatch && passwordVal.length > 0) {
        matchStatus.innerHTML = '<i class="fa fa-check-circle match"></i> <span class="match">Passwords match!</span>';
        confirm.classList.add('success');
        confirm.classList.remove('error');
      } else {
        matchStatus.innerHTML = '<i class="fa fa-times-circle no-match"></i> <span class="no-match">Passwords do not match</span>';
        confirm.classList.add('error');
        confirm.classList.remove('success');
      }
      
      return isMatch;
    }
    
    // Enable/disable submit button
    function updateSubmitButton() {
      const requirementsValid = checkRequirements();
      const passwordsMatch = password.value === confirm.value && confirm.value.length > 0;
      const hasPassword = password.value.length > 0;
      
      submitBtn.disabled = !(requirementsValid && passwordsMatch && hasPassword);
    }
    
    // Event listeners
    password.addEventListener('input', () => {
      checkRequirements();
      updateSubmitButton();
    });
    
    confirm.addEventListener('input', () => {
      checkMatch();
      updateSubmitButton();
    });
    
    // Toggle password visibility
    togglePassword.addEventListener('click', () => {
      const type = password.type === 'password' ? 'text' : 'password';
      password.type = type;
      togglePassword.classList.toggle('fa-eye-slash');
    });
    
    toggleConfirm.addEventListener('click', () => {
      const type = confirm.type === 'password' ? 'text' : 'password';
      confirm.type = type;
      toggleConfirm.classList.toggle('fa-eye-slash');
    });
    
    // Initial check
    checkRequirements();
  </script>
</body>

</html>