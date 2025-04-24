<?php
session_start();
require_once '../config/config.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Lấy thông tin đơn hàng cần sửa
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $sql = "SELECT o.*, c.name as customer_name, p.name as product_name 
            FROM orders o
            LEFT JOIN customers c ON o.customer_id = c.id
            LEFT JOIN products p ON o.product_id = p.id 
            WHERE o.id = '$edit_id'";
    $result = mysqli_query($conn, $sql);
    $edit_order = mysqli_fetch_assoc($result);
}

// Xử lý nút hủy
if (isset($_GET['cancel'])) {
    header("Location: order.php");
    exit;
}

// Xử lý cập nhật trạng thái đơn hàng
if (isset($_POST['edit_submit'])) {
    $id = $_GET['edit'];
    $status = $_POST['status'];
    
    $sql = "UPDATE orders SET status = '$status' WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        include 'components/alert_success.php';
        echo "<script>showSuccessAlert('Cập nhật đơn hàng thành công!');</script>";
    } else {
        include 'components/alert_danger.php';
        echo "<script>showDangerAlert('Cập nhật đơn hàng thất bại!');</script>" . mysqli_error($conn);
    }
}

// Xử lý xóa đơn hàng
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM orders WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        include 'components/alert_success.php';
        echo "<script>showSuccessAlert('Xóa đơn hàng thành công!');</script>";
    } else {
        include 'components/alert_danger.php';
        echo "<script>showDangerAlert('Xóa đơn hàng thất bại!');</script>" . mysqli_error($conn);
    }
}

// Lấy danh sách đơn hàng
$sql = "SELECT o.*, c.name as customer_name, p.name as product_name 
        FROM orders o
        LEFT JOIN customers c ON o.customer_id = c.id
        LEFT JOIN products p ON o.product_id = p.id 
        ORDER BY o.created_at DESC";
$orders = mysqli_query($conn, $sql);

$page_title = "Quản lý đơn hàng";
?>

<?php include 'components/head.php'; ?>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php include 'components/menubar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <?php include 'components/header.php'; ?>

            <div class="content">
                <!-- Form cập nhật trạng thái đơn hàng -->
                <?php if (isset($_GET['edit'])): ?>
                <div class="form-container">
                    <h2>Cập nhật trạng thái đơn hàng #<?php echo $edit_order['id']; ?></h2>
                    <form method="POST">
                        <div class="form-group">
                            <label for="status">Trạng thái đơn hàng</label>
                            <select id="status" name="status" required>
                                <option value="pending" <?php echo ($edit_order['status'] == 'pending') ? 'selected' : ''; ?>>
                                    Chờ xử lý
                                </option>  
                                <option value="pending" <?php echo ($edit_order['status'] == 'confirmed') ? 'selected' : ''; ?>>
                                    Đã hoàn thành
                                </option>                              
                                <option value="shipping" <?php echo ($edit_order['status'] == 'shipping') ? 'selected' : ''; ?>>
                                    Đang giao hàng
                                </option>
                                <option value="completed" <?php echo ($edit_order['status'] == 'completed') ? 'selected' : ''; ?>>
                                    Đã hoàn thành
                                </option>
                                <option value="cancelled" <?php echo ($edit_order['status'] == 'cancelled') ? 'selected' : ''; ?>>
                                    Đã hủy
                                </option>                                
                            </select>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" name="edit_submit" class="btn btn-primary">Cập nhật</button>
                            <a href="order.php?cancel=1" class="btn btn-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
                <?php endif; ?>

                <!-- Bảng danh sách đơn hàng -->
                <div class="table-container">
                    <div class="table-header">
                        <h2>Danh sách đơn hàng</h2>
                        <div class="table-actions">
                            <input type="text" id="searchInput" placeholder="Tìm kiếm...">
                        </div>
                    </div>
                    
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Khách hàng</th>
                                <th>Sản phẩm</th>
                                <th>Tổng tiền</th>
                                <th>Địa chỉ</th>
                                <th>Số điện thoại</th>
                                <th>Trạng thái</th>
                                <th>Ngày đặt</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($order = mysqli_fetch_assoc($orders)): ?>
                            <tr>
                                <td>#<?php echo $order['id']; ?></td>
                                <td><?php echo $order['fullname']; ?></td>
                                <td><?php echo $order['product_name']; ?></td>
                                <td><?php echo number_format($order['total_amount'], 0, ',', '.'); ?>đ</td>
                                <td><?php echo $order['address']; ?></td>
                                <td><?php echo $order['phone']; ?></td>
                                <td>
                                    <span class="status <?php echo $order['status']; ?>">
                                        <?php
                                        switch($order['status']) {
                                            case 'pending':
                                                echo 'Chờ xử lý';
                                                break;
                                            case 'processing':
                                                echo 'Đang xử lý';
                                                break;
                                            case 'shipping':
                                                echo 'Đang giao hàng';
                                                break;
                                            case 'completed':
                                                echo 'Đã hoàn thành';
                                                break;
                                            case 'cancelled':
                                                echo 'Đã hủy';
                                                break;
                                            default:
                                                echo 'Không xác định';
                                        }
                                        ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                <td>
                                    <a href="order.php?edit=<?php echo $order['id']; ?>" class="btn btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="order.php?delete=<?php echo $order['id']; ?>" 
                                       class="btn btn-delete"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<style>
    /* Styles cho trạng thái đơn hàng */
    .status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        text-align: center;
        display: inline-block;
        min-width: 120px;
    }

    .status.pending {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }

    .status.confirmed {
        background-color: #cce5ff;
        color: #004085;
        border: 1px solid #b8daff;
    }

    .status.shipping {
        background-color: #e2e3ff;
        color: #2c2e7f;
        border: 1px solid #d4d6ff;
    }

    .status.completed {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status.cancelled {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }    
</style>