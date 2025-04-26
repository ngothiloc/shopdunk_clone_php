<?php
session_start();
require_once '../config/config.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Lấy thông tin danh mục khi sửa
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $sql = "SELECT * FROM categories WHERE id = '$edit_id'";
    $result = mysqli_query($conn, $sql);
    $edit_category = mysqli_fetch_assoc($result);
}

// Xử lý nút hủy
if (isset($_GET['cancel'])) {
    header("Location: categories.php");
    exit;
}

// Xử lý thêm danh mục
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    
    $sql = "INSERT INTO categories (name, description, status) VALUES ('$name', '$description', '$status')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        include 'components/alert_success.php';
        echo "<script>showSuccessAlert('Thêm danh mục thành công!');</script>";
    } else {
        include 'components/alert_danger.php';
        echo "<script>showDangerAlert('Thêm danh mục thất bại!');</script>" . mysqli_error($conn);
    }
}

// Xử lý sửa danh mục
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    
    $sql = "UPDATE categories SET name = '$name', description = '$description', status = '$status' WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        include 'components/alert_success.php';
        echo "<script>showSuccessAlert('Cập nhật danh mục thành công!');</script>";
    } else {
        include 'components/alert_danger.php';
        echo "<script>showDangerAlert('Cập nhật danh mục thất bại!');</script>" . mysqli_error($conn);
    }
}

// Xử lý xóa danh mục
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM categories WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        include 'components/alert_success.php';
        echo "<script>showSuccessAlert('Xóa danh mục thành công!');</script>";
    } else {
        include 'components/alert_danger.php';
        echo "<script>showDangerAlert('Xóa danh mục thất bại!');</script>" . mysqli_error($conn);
    }
}

// Lấy danh sách danh mục
$sql = "SELECT * FROM categories ORDER BY id DESC";
$categories = mysqli_query($conn, $sql);

$page_title = "Quản lý danh mục";
?>

<?php include 'components/head.php'; ?>
<body>
    <div class="container">
        <?php include 'components/menubar.php'; ?>

        <div class="main-content">
            <?php include 'components/header.php'; ?>

            <div class="content">
                <!-- Form thêm/sửa danh mục -->
                <div class="form-container">
                    <h2><?php echo isset($_GET['edit']) ? 'Sửa danh mục' : 'Thêm danh mục mới'; ?></h2>
                    <form method="POST">                        
                        <input type="hidden" name="id" value="<?php echo isset($edit_category) ? $edit_category['id'] : ''; ?>">

                        <div class="form-group">
                            <label for="name">Tên danh mục</label>
                            <input type="text" id="name" name="name" 
                                   value="<?php echo isset($edit_category) ? $edit_category['name'] : ''; ?>" 
                                   required>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea id="description" name="description" rows="3"><?php 
                                echo isset($edit_category) ? $edit_category['description'] : ''; 
                            ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select id="status" name="status">
                                <option value="active" <?php echo (isset($edit_category) && $edit_category['status'] == 'active') ? 'selected' : ''; ?>>
                                    Hoạt động
                                </option>
                                <option value="inactive" <?php echo (isset($edit_category) && $edit_category['status'] == 'inactive') ? 'selected' : ''; ?>>
                                    Không hoạt động
                                </option>
                            </select>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" name="<?php echo isset($_GET['edit']) ? 'edit' : 'add'; ?>" class="btn btn-primary">
                                <?php echo isset($_GET['edit']) ? 'Lưu' : 'Thêm mới'; ?>
                            </button>
                            <a href="categories.php?cancel=1" class="btn btn-secondary">Hủy</a>
                        </div>
                    </form>
                </div>

                <!-- Bảng danh sách danh mục -->
                <div class="table-container">
                    <div class="table-header">
                        <h2>Danh sách danh mục</h2>
                        <div class="table-actions">
                            <input type="text" id="searchInput" placeholder="Tìm kiếm...">
                            <button class="btn btn-primary" id="addCategoryBtn">
                                <i class="fas fa-plus"></i> Thêm mới
                            </button>
                        </div>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên danh mục</th>
                                <th>Mô tả</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?php echo $category['id']; ?></td>
                                <td><?php echo $category['name']; ?></td>
                                <td><?php echo $category['description']; ?></td>
                                <td>
                                    <span class="status <?php echo $category['status']; ?>">
                                        <?php echo $category['status'] == 'active' ? 'Hoạt động' : 'Không hoạt động'; ?>
                                    </span>
                                </td>
                                <td><?php echo $category['created_at']; ?></td>
                                <td>
                                    <a href="categories.php?edit=<?php echo $category['id']; ?>" class="btn btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="categories.php?delete=<?php echo $category['id']; ?>" 
                                       class="btn btn-delete"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>