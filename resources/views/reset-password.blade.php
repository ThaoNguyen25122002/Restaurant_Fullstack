<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Reset Password</h1>
    <a href='{{$resetUrl}}'>Link reset</a>
</body>
</html> -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - KFC</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #d32f2f;
            padding: 20px;
            text-align: center;
            color: white;
        }

        .header img {
            max-width: 150px;
        }

        .content {
            padding: 20px;
        }

        .content h1 {
            font-size: 24px;
            color: #333;
        }

        .content p {
            font-size: 16px;
            color: #666;
        }

        .reset-btn {
            display: inline-block;
            background-color: #d32f2f;
            color: white;
            padding: 12px 20px;
            margin: 20px 0;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .reset-btn:hover {
            background-color: #bf0000;
        }

        .footer {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
            font-size: 14px;
            color: #999;
        }

    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/bf/KFC_logo.svg/800px-KFC_logo.svg.png" alt="KFC Logo">
        </div>
        <div class="content">
            <h1>Reset Your Password</h1>
            <p>Xin chào,</p>
            <p>Bạn vừa yêu cầu đặt lại mật khẩu cho tài khoản KFC của mình. Để đặt lại mật khẩu, vui lòng nhấn vào nút bên dưới.</p>
            <a href="{{ $resetUrl }}" class="reset-btn">Đặt lại mật khẩu</a>
            <p>Nếu bạn không yêu cầu thay đổi mật khẩu, vui lòng bỏ qua email này. Mật khẩu của bạn sẽ không bị thay đổi.</p>
        </div>
        <div class="footer">
            <p>&copy; 2024 KFC. All rights reserved.</p>
        </div>
    </div>
</body>
</html>