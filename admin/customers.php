<?php
session_start();
require_once '../config/config.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Lấy thông tin khách hàng cần sửa
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $sql = "SELECT * FROM customers WHERE id = '$edit_id'";
    $result = mysqli_query($conn, $sql);
    $edit_customer = mysqli_fetch_assoc($result);
}

// Xử lý nút hủy
if (isset($_GET['cancel'])) {
    header("Location: customers.php");
    exit;
}

// Xử lý thêm khách hàng
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $status = $_POST['status'];
    
    $sql = "INSERT INTO customers (name, email, phone, address, status) 
            VALUES ('$name', '$email', '$phone', '$address', '$status')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        include 'components/alert_success.php';
        echo "<script>showSuccessAlert('Thêm khách hàng thành công!');</script>";
    } else {
        include 'components/alert_danger.php';
        echo "<script>showDangerAlert('Thêm khách hàng thất bại!');</script>" . mysqli_error($conn);
    }
}

// Xử lý sửa khách hàng
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $status = $_POST['status'];
    
    $sql = "UPDATE customers SET 
            name = '$name',
            email = '$email',
            phone = '$phone',
            address = '$address',
            status = '$status'
            WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        include 'components/alert_success.php';
        echo "<script>showSuccessAlert('Cập nhật khách hàng thành công!');</script>";
    } else {
        include 'components/alert_danger.php';
        echo "<script>showDangerAlert('Cập nhật khách hàng thất bại!');</script>" . mysqli_error($conn);
    }
}

// Xử lý xóa khách hàng
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM customers WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        include 'components/alert_success.php';
        echo "<script>showSuccessAlert('Xóa khách hàng thành công!');</script>";
    } else {
        include 'components/alert_danger.php';
        echo "<script>showDangerAlert('Xóa khách hàng thất bại!');</script>" . mysqli_error($conn);
    }
}

// Lấy danh sách khách hàng
$sql = "SELECT * FROM customers ORDER BY id DESC";
$customers = mysqli_query($conn, $sql);

$page_title = "Quản lý khách hàng";
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
                <!-- Form thêm/sửa khách hàng -->
                <div class="form-container">
                    <h2><?php echo isset($_GET['edit']) ? 'Sửa khách hàng' : 'Thêm khách hàng mới'; ?></h2>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo isset($edit_customer) ? $edit_customer['id'] : ''; ?>">
                        
                        <div class="form-group">
                            <label for="name">Họ tên</label>
                            <input type="text" id="name" name="name" 
                                   value="<?php echo isset($edit_customer) ? $edit_customer['name'] : ''; ?>" 
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" 
                                   value="<?php echo isset($edit_customer) ? $edit_customer['email'] : ''; ?>"
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="number" id="phone" name="phone" 
                                   value="<?php echo isset($edit_customer) ? $edit_customer['phone'] : ''; ?>"
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <textarea id="address" name="address" rows="3"><?php 
                                echo isset($edit_customer) ? $edit_customer['address'] : ''; 
                            ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select id="status" name="status">
                                <option value="active" <?php echo (isset($edit_customer) && $edit_customer['status'] == 'active') ? 'selected' : ''; ?>>
                                    Hoạt động
                                </option>
                                <option value="inactive" <?php echo (isset($edit_customer) && $edit_customer['status'] == 'inactive') ? 'selected' : ''; ?>>
                                    Không hoạt động
                                </option>
                            </select>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" name="<?php echo isset($_GET['edit']) ? 'edit' : 'add'; ?>" class="btn btn-primary">
                                <?php echo isset($_GET['edit']) ? 'Lưu' : 'Thêm mới'; ?>
                            </button>
                            <a href="customers.php?cancel=1" class="btn btn-secondary">Hủy</a>
                        </div>
                    </form>
                </div>

                <!-- Bảng danh sách khách hàng -->
                <div class="table-container">
                    <div class="table-header">
                        <h2>Danh sách khách hàng</h2>
                        <div class="table-actions">
                            <input type="text" id="searchInput" placeholder="Tìm kiếm...">
                            <a href="customers.php" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Thêm mới
                            </a>
                        </div>
                    </div>
                    
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Họ tên</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($customer = mysqli_fetch_assoc($customers)): ?>
                            <tr>
                                <td><?php echo $customer['id']; ?></td>
                                <td><?php echo $customer['name']; ?></td>
                                <td><?php echo $customer['email']; ?></td>
                                <td><?php echo $customer['phone']; ?></td>
                                <td><?php echo $customer['address']; ?></td>
                                <td>
                                    <span class="status <?php echo $customer['status']; ?>">
                                        <?php echo $customer['status'] == 'active' ? 'Hoạt động' : 'Không hoạt động'; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="customers.php?edit=<?php echo $customer['id']; ?>" class="btn btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="customers.php?delete=<?php echo $customer['id']; ?>" 
                                       class="btn btn-delete"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?');">
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
    <script src="js/script.js"></script>
</body>
</html>
