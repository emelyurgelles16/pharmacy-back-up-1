<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <div style="max-width: 500px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #0b8f66;">Reset Your Password</h2>
        
        <p>Hello <strong>{{ $username }}</strong>,</p>
        
        <p>We received a request to reset your password.</p>
        
        <p>Click the button below to reset your password:</p>
        
        <p>
            <a href="{{ $resetUrl }}" 
               style="display: inline-block; 
                      background-color: #0b8f66; 
                      color: white; 
                      padding: 12px 24px; 
                      text-decoration: none; 
                      border-radius: 5px;">
                Reset Password
            </a>
        </p>
        
        <p>Or copy and paste this link into your browser:</p>
        <p style="color: #0b8f66;">{{ $resetUrl }}</p>
        
        <p>This link will expire in 60 minutes.</p>
        
        <p>If you did not request this, please ignore this email.</p>
        
        <hr>
        <p style="font-size: 12px; color: gray;">&copy; AERPharmacy System</p>
    </div>
</body>
</html>