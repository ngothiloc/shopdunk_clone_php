<?php
session_start();
require_once '../config/config.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$page_title = "Trang quản lý";
?>
 <?php include 'components/head.php'; ?>
  <body>
    <div class="container">
      <!-- Sidebar -->
      <?php include 'components/menubar.php';?>

      <!-- Main Content -->
      <div class="main-content">
        <?php include 'components/header.php';?>

        <div class="content">
          <div class="cards">
            <div class="card">
              <div class="card-icon">
                <i class="fas fa-list"></i>
              </div>
              <div class="card-info">
                <h3>Danh mục</h3>
                <p>10 danh mục</p>
              </div>
            </div>
            <div class="card">
              <div class="card-icon">
                <i class="fas fa-box"></i>
              </div>
              <div class="card-info">
                <h3>Sản phẩm</h3>
                <p>50 sản phẩm</p>
              </div>
            </div>
            <div class="card">
              <div class="card-icon">
                <i class="fas fa-newspaper"></i>
              </div>
              <div class="card-info">
                <h3>Tin tức</h3>
                <p>20 bài viết</p>
              </div>
            </div>
            <div class="card">
              <div class="card-icon">
                <i class="fas fa-users"></i>
              </div>
              <div class="card-info">
                <h3>Khách hàng</h3>
                <p>100 khách hàng</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="js/script.js"></script>
  </body>
</html>
