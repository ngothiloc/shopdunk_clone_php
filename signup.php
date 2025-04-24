<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký | Apple Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f5f5f7;
        }

        .signup-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }

        .apple-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .apple-logo i {
            font-size: 40px;
            color: #000;
        }

        .signup-title {
            text-align: center;
            margin-bottom: 30px;
            color: #1d1d1f;
            font-size: 28px;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #1d1d1f;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #d2d2d7;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f5f5f7;
        }

        .form-group input:focus {
            outline: none;
            border-color: #0066cc;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(0,102,204,0.1);
        }

        .submit-btn {
            width: 100%;
            padding: 16px;
            background: #0066cc;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .submit-btn:hover {
            background: #0052a3;
            transform: translateY(-1px);
        }

        .form-footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #d2d2d7;
        }

        .form-footer p {
            color: #86868b;
            margin-bottom: 10px;
        }

        .form-footer a {
            color: #0066cc;
            text-decoration: none;
            font-weight: 500;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        .terms {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #86868b;
        }

        .terms a {
            color: #0066cc;
            text-decoration: none;
        }

        .terms a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="apple-logo">
            <i class="fab fa-apple"></i>
        </div>
        <h2 class="signup-title">Tạo Apple ID</h2>
        <form action="register_process.php" method="POST">
            <div class="form-group">
                <label for="fullname">Họ và tên</label>
                <input type="text" id="fullname" name="fullname" placeholder="Nhập họ và tên của bạn" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="apple@example.com" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" placeholder="Tối thiểu 8 ký tự" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Xác nhận mật khẩu</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
            </div>
            <button type="submit" class="submit-btn">Tạo tài khoản</button>
        </form>
        <div class="terms">
            <p>Bằng cách tạo tài khoản, bạn đồng ý với <a href="#">Điều khoản dịch vụ</a> và <a href="#">Chính sách bảo mật</a> của chúng tôi</p>
        </div>
        <div class="form-footer">
            <p>Đã có tài khoản Apple ID?</p>
            <a href="signin.php">Đăng nhập ngay</a>
        </div>
    </div>
</body>
</html>