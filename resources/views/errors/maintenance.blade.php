<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Mode</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #0b7a33, #056b28);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        .maintenance-card {
            background: white;
            border-radius: 24px;
            padding: 50px 40px;
            max-width: 550px;
            width: 100%;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: fadeIn 0.5s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .maintenance-icon {
            font-size: 80px;
            color: #ff9800;
            margin-bottom: 25px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        h1 {
            color: #1b5e20;
            font-size: 28px;
            margin-bottom: 15px;
            font-weight: 700;
        }
        .message-box {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
            border-left: 4px solid #ff9800;
        }
        .message-box p {
            color: #555;
            font-size: 16px;
            line-height: 1.6;
            margin: 0;
        }
        .info-text {
            color: #6c757d;
            font-size: 13px;
            margin-top: 20px;
        }
        .btn {
            background: #1b5e20;
            color: white;
            padding: 12px 30px;
            border-radius: 10px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background: #2e7d32;
            transform: translateY(-2px);
        }
        .status-badge {
            display: inline-block;
            background: #ff9800;
            color: white;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="maintenance-card">
        <div class="status-badge">
            <i class="fas fa-tools"></i> MAINTENANCE MODE
        </div>
        <div class="maintenance-icon">
            <i class="fas fa-tools"></i>
        </div>
        <h1>System Under Maintenance</h1>
        <div class="message-box">
            <p>{{ $message ?? 'System is currently undergoing maintenance. Please check back later.' }}</p>
        </div>
        <p class="info-text">
            <i class="fas fa-clock"></i> We're working hard to improve your experience.
            Please try again in a few minutes.
        </p>
        @if(auth()->check() && auth()->user()->hasRole('Admin'))
            <a href="{{ route('settings.index') }}" class="btn" style="margin-top: 20px;">
                <i class="fas fa-cog"></i> Go to Settings
            </a>
        @endif
    </div>
</body>
</html>