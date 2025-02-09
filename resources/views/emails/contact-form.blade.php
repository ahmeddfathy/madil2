<!DOCTYPE html>
<html dir="rtl">
<head>
    <title>رسالة جديدة من نموذج الاتصال</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #4CAF50;
            margin-bottom: 30px;
        }
        h2 {
            color: #2E7D32;
            margin: 0;
            font-size: 24px;
        }
        .info-item {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .label {
            color: #1B5E20;
            font-weight: bold;
            margin-left: 10px;
        }
        .message-section {
            background-color: #E8F5E9;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .message-header {
            color: #2E7D32;
            margin-top: 0;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>رسالة جديدة من نموذج الاتصال</h2>
        </div>

        <div class="info-item">
            <span class="label">الاسم:</span>
            {{ $name }}
        </div>

        <div class="info-item">
            <span class="label">البريد الإلكتروني:</span>
            {{ $email }}
        </div>

        <div class="info-item">
            <span class="label">رقم الجوال:</span>
            {{ $phone }}
        </div>

        <div class="message-section">
            <h3 class="message-header">الرسالة:</h3>
            <p>{{ $userMessage }}</p>
        </div>
    </div>
</body>
</html>
