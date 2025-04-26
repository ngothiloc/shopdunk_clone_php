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

// Lấy ID sản phẩm từ URL
$product_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Truy vấn thông tin sản phẩm
$sql = "SELECT p.*, c.name as category_name 
        FROM products p
        INNER JOIN categories c ON p.category_id = c.id
        WHERE p.id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header("Location: index.php");
    exit();
}

// Lấy thông tin khách hàng
$user_sql = "SELECT * FROM customers WHERE id = ?";
$user_stmt = mysqli_prepare($conn, $user_sql);
mysqli_stmt_bind_param($user_stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($user_stmt);
$user_result = mysqli_stmt_get_result($user_stmt);
$user = mysqli_fetch_assoc($user_result);

// Xử lý đặt hàng
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gender = $_POST['gender'];
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $note = $_POST['note'];
    $total_amount = $product['price'];

    // Kiểm tra điều khoản
    if (!isset($_POST['terms']) || $_POST['terms'] != 'on') {
        echo "<script>showDangerAlert('Vui lòng đồng ý với điều khoản và điều kiện!');</script>";
    } else {
        // Thêm đơn hàng vào database
        $order_sql = "INSERT INTO orders (customer_id, product_id, gender, fullname, phone, address, note, total_amount, status) 
                     VALUES ('$_SESSION[user_id]', '$product_id', '$gender', '$fullname', '$phone', '$address', '$note', '$total_amount', 'pending')";
        
        if (mysqli_query($conn, $order_sql)) {
            echo "<script>
                showSuccessAlert('Đặt hàng thành công!');
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 1500);
            </script>";
        } else {
            echo "<script>showDangerAlert('Có lỗi xảy ra, vui lòng thử lại!');</script>";
        }
    }
}

$page_title = "Đặt hàng - " . $product['name'];
include 'web/components/head.php';
?>
<body>
    <!-- header -->
    <?php include 'web/components/header.php';?>
    <div class="order_container">
        <form method="POST" action="" class="order-summary">
            <div class="product-header">
                <div class="product-info">
                    <div class="product-image">
                        <img src="<?php echo str_replace('../', '', $product['image']); ?>" alt="<?php echo $product['name']; ?>">
                    </div>
                    <div class="product-details">
                        <h2 class="product-name"><?php echo $product['name']; ?></h2>
                    </div>
                </div>
                <div class="product-price"><?php echo number_format($product['price'], 0, ',', '.'); ?>₫</div>
            </div>

            <div class="order-item-summary">
                Tạm tính (1 sản phẩm): <span class="order-total"><?php echo number_format($product['price'], 0, ',', '.'); ?>₫</span>
            </div>

            <div class="customer-info">
                <h3 class="section-title">Thông tin khách hàng</h3>
                <div class="form-row">
                    <div class="form-group gender-select">
                        <label>
                            <input type="radio" name="gender" value="male" <?php echo ($user['gender'] == 'male') ? 'checked' : ''; ?> required> Anh
                        </label>
                        <label>
                            <input type="radio" name="gender" value="female" <?php echo ($user['gender'] == 'female') ? 'checked' : ''; ?>> Chị
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="fullname">Họ và Tên</label>
                    <input type="text" id="fullname" name="fullname" placeholder="Nhập họ và tên" value="<?php echo $user['name']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="tel" id="phone" name="phone" placeholder="Nhập số điện thoại" value="<?php echo $user['phone']; ?>" required>
                </div>
            </div>

            <div class="shipping-info">
                <div class="form-group">
                    <label for="address">Địa chỉ cụ thể</label>
                    <input type="text" id="address" name="address" placeholder="Nhập địa chỉ cụ thể" value="<?php echo $user['address']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="note">Nhập ghi chú (nếu có)</label>
                    <textarea id="note" name="note" placeholder="Nhập ghi chú"></textarea>
                </div>
            </div>

            <div class="total-section">
                <div class="total-amount">
                    Tổng tiền: <span class="total-price"><?php echo number_format($product['price'], 0, ',', '.'); ?>₫</span>
                </div>
                <div class="terms-and-conditions">
                    <label class="checkbox-item">
                        <input type="checkbox" id="terms" name="terms">
                        Tôi đã đọc và đồng ý với điều khoản và điều kiện của website
                    </label>
                </div>
                <button type="submit" class="checkout-button">Tiến hành đặt hàng</button>
            </div>
        </form>
    </div>
    <style>
        .order_container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .order-summary {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 450px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin: 50px;
        }

        .product-header,
        .order-item-summary {
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .product-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-info {
            display: flex;
            align-items: center;
        }

        .product-image {
            width: 70px;
            margin-right: 15px;
        }

        .product-image img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }

        .product-name {
            font-size: 1em;
            margin-bottom: 5px;
        }

        .product-price {
            font-weight: bold;
            color: #333;
            font-size: 1em;
        }

        .order-item-summary {
            display: flex;
            justify-content: space-between;
            font-size: 0.9em;
        }

        .order-total {
            font-weight: bold;
            color: #ff0000;
        }

        .section-title {
            font-size: 1em;
            margin-top: 15px;
            margin-bottom: 10px;
            color: #333;
        }

        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.85em;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group input[type="tel"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 0.85em;
        }

        .select-wrapper {
            position: relative;
            width: 100%;
        }

        .form-group select {
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 8px center;
            background-size: 16px;
            padding-right: 30px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 60px;
        }

        .gender-select label {
            display: inline-block;
            margin-right: 15px;
            font-size: 0.9em;
        }

        .shipping-options label {
            display: inline-block;
            margin-right: 15px;
            font-size: 0.9em;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            font-size: 0.85em;
            color: #555;
        }

        .checkbox-item input[type="checkbox"] {
            margin-right: 5px;
            vertical-align: middle;
        }

        .dropdown {
            position: relative;
        }

        .total-section {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px solid #333;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .total-amount {
            display: flex;
            justify-content: space-between;
            font-size: 1em;
            font-weight: bold;
            color: #333;
            align-items: center;
        }

        .total-price {
            color: #d00;
        }

        .terms-and-conditions {
            font-size: 0.8em;
            color: #555;
        }

        .terms-and-conditions .checkbox-item {
            display: flex;
            align-items: center;
        }

        .terms-and-conditions .checkbox-item input[type="checkbox"] {
            margin-right: 5px;
        }

        .terms-and-conditions .checkbox-item a {
            color: #007bff;
            text-decoration: none;
        }

        .terms-and-conditions .checkbox-item a:hover {
            text-decoration: underline;
        }

        .checkout-button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;                         
            font-size: 1em;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .checkout-button:hover {
            background-color: #0056b3;
        }
    </style>
    <?php include 'web/components/footer.php';?>
</body>
</html>