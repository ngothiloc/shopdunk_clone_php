<?php
session_start();
require_once 'config/config.php';
include 'admin/components/alert_success.php';
include 'admin/components/alert_danger.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $username = $_POST['username'];

    // Kiểm tra mật khẩu xác nhận
    if ($password !== $confirm_password) {
        echo "<script>showDangerAlert('Mật khẩu xác nhận không khớp!');</script>";
    } else {
        // Kiểm tra email đã tồn tại
        $check_sql = "SELECT * FROM customers WHERE email = ? OR username = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ss", $email, $username);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            echo "<script>showDangerAlert('Email hoặc tên đăng nhập đã được sử dụng!');</script>";
        } else {
            // Thêm khách hàng mới
            $sql = "INSERT INTO customers (name, email, password, status, username) 
                   VALUES (?, ?, ?, 'active', ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $name, $email, $password, $username);
            
            if ($stmt->execute()) {
                echo "<script>
                    showSuccessAlert('Đăng ký thành công! Vui lòng đăng nhập.');
                    setTimeout(function() {
                        window.location.href = 'signin.php';
                    }, 1500);
                </script>";
            } else {
                echo "<script>showDangerAlert('Đăng ký thất bại! Vui lòng thử lại.');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký | Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
</head>
<body>
    <div class="login-container">
        <div class="apple-logo">
            <i class="fab fa-apple"></i>
        </div>
        <h2 class="login-title">Đăng ký tài khoản Store</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Họ và tên</label>
                <input type="text" id="name" name="name" placeholder="Nhập họ và tên" required>
            </div>

            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" id="username" name="username" placeholder="Nhập tên đăng nhập" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="apple@example.com" required>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Xác nhận mật khẩu</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
            </div>

            <button type="submit" class="submit-btn">Đăng ký</button>
        </form>

        <div class="social-login">
            <a href="#" class="social-btn">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-btn">
                <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-btn">
                <i class="fab fa-twitter"></i>
            </a>
        </div>

        <div class="form-footer">
            <p>Đã có tài khoản?</p>
            <a href="signin.php">Đăng nhập ngay</a>
        </div>
    </div>

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

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }

        .apple-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .apple-logo i {
            font-size: 40px;
            color: #000;
        }

        .login-title {
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

        .form-group input, .form-group select {
            width: 100%;
            padding: 15px;
            border: 2px solid #d2d2d7;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f5f5f7;
        }

        .form-group input:focus, .form-group select:focus {
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

        .social-login {
            margin-top: 30px;
            text-align: center;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .social-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 1px solid #d2d2d7;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .social-btn i {
            font-size: 20px;
            color: #1d1d1f;
        }

        .social-btn:hover {
            border-color: #0066cc;
            transform: translateY(-2px);
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-size: 14px;
        }
        
        .alert-danger {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }
        
        .alert-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }
    </style>
</body>
</html>