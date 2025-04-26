<?php
session_start();
require_once 'config/config.php';
include 'admin/components/alert_success.php';
include 'admin/components/alert_danger.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Lấy thông tin khách hàng
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM customers WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Xử lý cập nhật thông tin
if (isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];
    $address = $_POST['address'];

    // Kiểm tra định dạng số điện thoại
    if (!preg_match('/^0\d{9}$/', $phone)) {
        echo "<script>showDangerAlert('Số điện thoại không hợp lệ! Vui lòng nhập số bắt đầu bằng 0 và có 10 chữ số.');</script>";
    } else {
        $update_sql = "UPDATE customers SET name=?, email=?, phone=?, gender=?, birthdate=?, address=? WHERE id=?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "ssssssi", $name, $email, $phone, $gender, $birthdate, $address, $user_id);
        
        if (mysqli_stmt_execute($update_stmt)) {
            echo "<script>
                showSuccessAlert('Cập nhật thông tin thành công!');
                setTimeout(function() {
                    window.location.href = 'profile.php';
                }, 1000);
            </script>";                  
        } else {
            echo "<script>showDangerAlert('Có lỗi xảy ra, vui lòng thử lại!');</script>";
        }
    }
}

// Xử lý đổi mật khẩu
if (isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Kiểm tra độ dài mật khẩu mới
    if (strlen($new_password) < 6) {
        echo "<script>showDangerAlert('Mật khẩu mới phải có ít nhất 6 ký tự!');</script>";
    } else {
        // Kiểm tra mật khẩu cũ
        if ($old_password == $user['password']) {
            if ($new_password === $confirm_password) {
                $password_sql = "UPDATE customers SET password=? WHERE id=?";
                $password_stmt = mysqli_prepare($conn, $password_sql);
                mysqli_stmt_bind_param($password_stmt, "si", $new_password, $user_id);
                
                if (mysqli_stmt_execute($password_stmt)) {
                    echo "<script>showSuccessAlert('Đổi mật khẩu thành công!');</script>";
                } else {
                    echo "<script>showDangerAlert('Có lỗi xảy ra, vui lòng thử lại!');</script>";
                }
            } else {
                echo "<script>showDangerAlert('Mật khẩu mới không khớp!');</script>";
            }
        } else {
            echo "<script>showDangerAlert('Mật khẩu cũ không đúng!');</script>";
        }
    }
}

$page_title = "Thông tin cá nhân";
include 'web/components/head.php';
?>
<body>
    <?php include 'web/components/header.php'; ?>
    
    <div class="profile-container">
        <div class="profile-header">
            <h1>Thông tin cá nhân</h1>
            <p>Quản lý thông tin cá nhân của bạn</p>
        </div>

        <div class="profile-content">
            <div class="profile-section">
                <h2>Thông tin chung</h2>
                <form method="POST" class="profile-info">
                    <div class="info-group">
                        <label>Họ và tên:</label>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                    </div>
                    <div class="info-group">
                        <label>Tên đăng nhập:</label>
                        <span><?php echo htmlspecialchars($user['username']); ?></span>
                    </div>
                    <div class="info-group">
                        <label>Email:</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="info-group">
                        <label>Số điện thoại:</label>
                        <input type="tel" name="phone" pattern="0[0-9]{9}" title="Số điện thoại phải bắt đầu bằng số 0 và có 10 chữ số" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                    </div>
                    <div class="info-group">
                        <label>Giới tính:</label>
                        <select name="gender" required>
                            <option value="male" <?php echo $user['gender'] == 'male' ? 'selected' : ''; ?>>Nam</option>
                            <option value="female" <?php echo $user['gender'] == 'female' ? 'selected' : ''; ?>>Nữ</option>
                        </select>
                    </div>
                    <div class="info-group">
                        <label>Ngày sinh:</label>
                        <input type="date" name="birthdate" value="<?php echo $user['birthdate']; ?>" required>
                    </div>
                    <div class="info-group">
                        <label>Địa chỉ:</label>
                        <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
                    </div>
                    <div class="profile-actions">
                        <button type="submit" name="update_profile" class="edit-btn">Cập nhật thông tin</button>
                    </div>
                </form>
            </div>

            <div class="profile-section">
                <h2>Đổi mật khẩu</h2>
                <form method="POST" class="password-form">
                    <div class="info-group">
                        <label>Mật khẩu cũ:</label>
                        <input type="password" name="old_password" required>
                    </div>
                    <div class="info-group">
                        <label>Mật khẩu mới:</label>
                        <input type="password" name="new_password" required>
                    </div>
                    <div class="info-group">
                        <label>Nhập lại mật khẩu mới:</label>
                        <input type="password" name="confirm_password" required>
                    </div>
                    <div class="profile-actions">
                        <button type="submit" name="change_password" class="change-pass-btn">Đổi mật khẩu</button>
                    </div>
                </form>
            </div>

            <div class="profile-section">
                <h2>Lịch sử đơn hàng</h2>
                <?php
                // Lấy lịch sử đơn hàng
                $order_sql = "SELECT o.*, p.name as product_name, p.image as product_image 
                            FROM orders o 
                            JOIN products p ON o.product_id = p.id 
                            WHERE o.customer_id = ? 
                            ORDER BY o.created_at DESC";
                $order_stmt = mysqli_prepare($conn, $order_sql);
                mysqli_stmt_bind_param($order_stmt, "i", $user_id);
                mysqli_stmt_execute($order_stmt);
                $orders = mysqli_stmt_get_result($order_stmt);
                ?>
                <div class="order-history">
                    <?php if (mysqli_num_rows($orders) > 0): ?>
                        <?php while ($order = mysqli_fetch_assoc($orders)): ?>
                            <div class="order-item">
                                <div class="order-image">
                                    <img src="<?php echo str_replace('../', '', $order['product_image']); ?>" alt="<?php echo $order['product_name']; ?>">
                                </div>
                                <div class="order-details">
                                    <h3><?php echo htmlspecialchars($order['product_name']); ?></h3>
                                    <p class="order-date">Ngày đặt: <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></p>
                                    <p class="order-price">Tổng tiền: <?php echo number_format($order['total_amount'], 0, ',', '.'); ?>₫</p>
                                    <p class="order-status">Trạng thái: 
                                        <span class="status-<?php echo $order['status']; ?>">
                                            <?php
                                            switch($order['status']) {
                                                case 'pending': echo 'Chờ xác nhận'; break;
                                                case 'confirmed': echo 'Đã xác nhận'; break;
                                                case 'shipping': echo 'Đang giao hàng'; break;
                                                case 'completed': echo 'Đã hoàn thành'; break;
                                                case 'cancelled': echo 'Đã hủy'; break;
                                            }
                                            ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="no-orders">Bạn chưa có đơn hàng nào</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <style>
        .profile-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;            
        }

        .profile-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .profile-header h1 {
            font-size: 32px;
            color: #1d1d1f;
            margin-bottom: 10px;
        }

        .profile-header p {
            color: #86868b;
        }

        .profile-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .profile-section h2 {
            font-size: 24px;
            color: #1d1d1f;
            margin-bottom: 20px;
        }

        .info-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px 0;
            border-bottom: 1px solid #f5f5f7;
        }

        .info-group label {
            width: 200px;
            color: #86868b;
            font-weight: 500;
        }

        .info-group span {
            flex: 1;
            color: #1d1d1f;
        }

        .profile-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .info-group input, .info-group select, .info-group textarea {
            flex: 1;
            padding: 12px 16px;
            border: 2px solid #e5e5e7;
            border-radius: 12px;
            font-size: 15px;
            color: #1d1d1f;
            transition: all 0.3s ease;
            background: #fff;
        }

        .info-group input:focus, .info-group select:focus, .info-group textarea:focus {
            border-color: #0066cc;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
        }

        .info-group select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='10' height='6' viewBox='0 0 10 6' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L5 5L9 1' stroke='%23666666' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 40px;
        }

        .edit-btn, .change-pass-btn {
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .edit-btn {
            background: #0066cc;
            color: white;
        }

        .change-pass-btn {
            background: #f5f5f7;
            color: #1d1d1f;
        }

        .edit-btn:hover {
            background: #0052a3;
            transform: translateY(-1px);
        }

        .change-pass-btn:hover {
            background: #e5e5e5;
            transform: translateY(-1px);
        }

        /* .password-form {
            max-width: 100%;
        } */

        .order-history {
            margin-top: 20px;
        }

        .order-item {
            display: flex;
            gap: 20px;
            padding: 20px;
            border-bottom: 1px solid #f5f5f7;
        }

        .order-image {
            width: 100px;
            height: 100px;
        }

        .order-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .order-details {
            flex: 1;
        }

        .order-details h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .order-date, .order-price {
            color: #86868b;
            margin-bottom: 5px;
        }

        .order-status {
            margin-top: 10px;
        }

        .status-pending { color: #ff9500; }
        .status-confirmed { color: #007aff; }
        .status-shipping { color: #5856d6; }
        .status-completed { color: #34c759; }
        .status-cancelled { color: #ff3b30; }

        .no-orders {
            text-align: center;
            color: #86868b;
            padding: 30px 0;
        }
    </style>

    <?php include 'web/components/footer.php'; ?>
</body>
</html>
