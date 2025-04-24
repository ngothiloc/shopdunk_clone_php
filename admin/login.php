<?php
session_start();

// Xử lý đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Kiểm tra thông tin đăng nhập
    if ($username === "admin" && $password === "admin123") {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $error = "Tên đăng nhập hoặc mật khẩu không đúng";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng nhập Admin</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family: "Nunito", sans-serif;
        background-color: #f8f9fc;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .login-container {
        width: 100%;
        max-width: 500px;
        padding: 20px;
      }

      .card {
        background-color: white;
        border-radius: 5px;
        box-shadow: 0 2px 20px 0 rgba(58, 59, 69, 0.15);
        padding: 20px;
      }

      .card-header {
        text-align: center;
        margin-bottom: 20px;
      }

      .card-header h1 {
        color: #4e73df;
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 10px;
      }

      .card-header p {
        color: #858796;
        font-size: 14px;
      }

      .form-group {
        margin-bottom: 20px;
      }

      .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #5a5c69;
        font-weight: 500;
      }

      .input-group {
        position: relative;
      }

      .input-group input {
        width: 100%;
        padding: 12px 15px;
        padding-left: 40px;
        border: 1px solid #d1d3e2;
        border-radius: 5px;
        font-size: 14px;
        transition: border-color 0.15s ease-in-out;
      }

      .input-group input:focus {
        outline: none;
        border-color: #4e73df;
      }

      .input-group i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #858796;
      }

      .btn {
        display: inline-block;
        padding: 12px 15px;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
        width: 100%;
      }

      .btn-primary {
        background-color: #4e73df;
        color: white;
      }

      .btn-primary:hover {
        background-color: #2e59d9;
      }

      .text-center {
        text-align: center;
      }

      .mt-3 {
        margin-top: 15px;
      }

      .text-muted {
        color: #858796;
        font-size: 14px;
      }

      .error {
        color: #e74a3b;
        font-size: 14px;
        margin-bottom: 15px;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <div class="login-container">
      <div class="card">
        <div class="card-header">
          <h1>Admin Panel</h1>
          <p>Đăng nhập để tiếp tục</p>
        </div>

        <form method="POST">
          <div class="form-group">
            <label for="username">Tên đăng nhập</label>
            <div class="input-group">
              <i class="fas fa-user"></i>
              <input
                type="text"               
                name="username"
                id="username"
                placeholder="Nhập tên đăng nhập"
                required
              />
            </div>
          </div>
          <div class="form-group">
            <label for="password">Mật khẩu</label>
            <div class="input-group">
              <i class="fas fa-lock"></i>
              <input
                type="password"
                id="password"
                name="password"
                placeholder="Nhập mật khẩu"
                required
              />
            </div>
          </div>
          <?php if (isset($error)): ?>
            <div class="error">
              <?php echo $error; ?>
            </div>
          <?php endif; ?>
          <button type="submit" class="btn btn-primary">Đăng nhập</button>
          <div class="text-center mt-3">
            <a href="#" class="text-muted">Quên mật khẩu?</a>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
