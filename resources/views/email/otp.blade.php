<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0b8f66;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #0b8f66;
            margin: 0;
        }
        .code {
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            color: #0b8f66;
            background: #f0f0f0;
            padding: 15px;
            border-radius: 8px;
            letter-spacing: 5px;
            margin: 20px 0;
        }
        .verify-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 12px 20px;
            background: #0b8f66;
            color: white !important;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }
        .verify-btn:hover {
            background: #08704f;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .warning {
            color: #ff6b6b;
            font-size: 12px;
            text-align: center;
            margin-top: 15px;
        }
        hr {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pharmacy System</h1>
        </div>
        
        <p>Hello <strong>{{ $username }}</strong>,</p>
        
        <p>Your One-Time Password (OTP) for login verification is:</p>
        
        <div class="code">
            {{ $code }}
        </div>
        
        <!-- ✅ MAGIC LINK FOR AUTO-FILL -->
        <a href="{{ url('/verify-otp?code=' . $code) }}" class="verify-btn">
            🔐 Verify Now (Auto-fill)
        </a>
        
        <hr>
        
        <p style="font-size: 12px; text-align: center;">
            Or copy this code manually: <strong>{{ $code }}</strong>
        </p>
        
        <p>This code will expire in <strong>10 minutes</strong>.</p>
        
        <p>If you did not request this OTP, please ignore this email and secure your account.</p>
        
        <div class="warning">
            ⚠️ Do not share this OTP with anyone.
        </div>
        
        <div class="footer">
            &copy; {{ date('Y') }} Pharmacy Management System. All rights reserved.
        </div>
    </div>
</body> 
</html>