<?php
session_start();
require_once '../config/config.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Lấy thông tin tin tức cần sửa
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $sql = "SELECT * FROM news WHERE id = '$edit_id'";
    $result = mysqli_query($conn, $sql);
    $edit_news = mysqli_fetch_assoc($result);
}

// Xử lý nút hủy
if (isset($_GET['cancel'])) {
    header("Location: news.php");
    exit;
}

// Xử lý thêm tin tức
if (isset($_POST['submit'])) {
    $title = $_POST['newsTitle'];
    $content = $_POST['newsContent'];
    $status = $_POST['newsStatus'];

    // Xử lý upload ảnh
    $image = '';
    if (isset($_FILES['newsImage']) && $_FILES['newsImage']['error'] == 0) {
        $target_dir = "../uploads/news/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_extension = strtolower(pathinfo($_FILES['newsImage']['name'], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;

        if (move_uploaded_file($_FILES['newsImage']['tmp_name'], $target_file)) {
            $image = $target_file;
        } else {
            echo 'Có lỗi xảy ra khi upload ảnh.';
        }
    }

    $sql = "INSERT INTO news (title, content, image, status, created_at) 
            VALUES ('$title', '$content', '$image', '$status', NOW())";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        include 'components/alert_success.php';
        echo "<script>showSuccessAlert('Thêm tin tức thành công!');</script>";
    } else {
        include 'components/alert_danger.php';
        echo "<script>showDangerAlert('Thêm tin tức thất bại!');</script>" . mysqli_error($conn);
    }
}

// Xử lý sửa tin tức
if (isset($_POST['edit_submit'])) {
    $id = $_GET['edit'];
    $title = $_POST['newsTitle'];
    $content = $_POST['newsContent'];
    $status = $_POST['newsStatus'];

    // Xử lý upload ảnh
    $image = '';
    if (isset($_FILES['newsImage']) && $_FILES['newsImage']['error'] == 0) {
        $target_dir = "../uploads/news/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_extension = strtolower(pathinfo($_FILES['newsImage']['name'], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;

        if (move_uploaded_file($_FILES['newsImage']['tmp_name'], $target_file)) {
            $image = $target_file;
        } else {
            echo 'Có lỗi xảy ra khi upload ảnh.';
        }
    }

    $sql = "UPDATE news SET title = '$title', content = '$content', status = '$status'";
    if (!empty($image)) {
        $sql .= ", image = '$image'";
    }
    $sql .= " WHERE id = '$id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        include 'components/alert_success.php';
        echo "<script>showSuccessAlert('Cập nhật tin tức thành công!');</script>";
    } else {
        include 'components/alert_danger.php';
        echo "<script>showDangerAlert('Cập nhật tin tức thất bại!');</script>" . mysqli_error($conn);
    }
}

// Xử lý xóa tin tức
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM news WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        include 'components/alert_success.php';
        echo "<script>showSuccessAlert('Xóa tin tức thành công!');</script>";
    } else {
        include 'components/alert_danger.php';
        echo "<script>showDangerAlert('Xóa tin tức thất bại!');</script>" . mysqli_error($conn);
    }
}

// Lấy danh sách tin tức
$sql = "SELECT * FROM news ORDER BY created_at DESC";
$news_list = mysqli_query($conn, $sql);

$page_title = "Quản lý tin tức";
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
                <!-- Form thêm/sửa tin tức -->
                <div class="form-container">
                    <h2><?php echo isset($_GET['edit']) ? 'Sửa tin tức' : 'Thêm tin tức mới'; ?></h2>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="newsTitle">Tiêu đề</label>
                            <input type="text" id="newsTitle" name="newsTitle" required
                                   value="<?php echo isset($edit_news) ? $edit_news['title'] : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="newsImage">Hình ảnh</label>
                            <input type="file" id="newsImage" name="newsImage" accept="image/*">
                            <?php if (isset($edit_news) && !empty($edit_news['image'])): ?>
                                <img src="<?php echo $edit_news['image']; ?>" alt="Current image" style="max-width: 100px; margin-top: 10px;">
                            <?php endif; ?>
                        </div>
                        
                        <div class="form-group">
                            <label for="newsContent">Nội dung</label>
                            <textarea id="newsContent" name="newsContent" rows="10" required><?php 
                                echo isset($edit_news) ? $edit_news['content'] : ''; 
                            ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="newsStatus">Trạng thái</label>
                            <select id="newsStatus" name="newsStatus">
                                <option value="active" <?php echo (isset($edit_news) && $edit_news['status'] == 'active') ? 'selected' : ''; ?>>
                                    Hiển thị
                                </option>
                                <option value="inactive" <?php echo (isset($edit_news) && $edit_news['status'] == 'inactive') ? 'selected' : ''; ?>>
                                    Ẩn
                                </option>
                            </select>
                        </div>
                        
                        <div class="form-actions">
                            <?php if (isset($_GET['edit'])): ?>
                                <button type="submit" name="edit_submit" class="btn btn-primary">Cập nhật</button>
                            <?php else: ?>
                                <button type="submit" name="submit" class="btn btn-primary">Lưu</button>
                            <?php endif; ?>
                            <a href="news.php?cancel=1" class="btn btn-secondary">Hủy</a>
                        </div>
                    </form>
                </div>

                <!-- Bảng danh sách tin tức -->
                <div class="table-container">
                    <div class="table-header">
                        <h2>Danh sách tin tức</h2>
                        <div class="table-actions">
                            <input type="text" id="searchInput" placeholder="Tìm kiếm...">
                            <a href="news.php" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Thêm mới
                            </a>
                        </div>
                    </div>
                    
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th>Tiêu đề</th>
                                <th>Ngày đăng</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($news = mysqli_fetch_assoc($news_list)): ?>
                            <tr>
                                <td><?php echo $news['id']; ?></td>
                                <td>
                                    <?php if (!empty($news['image'])): ?>
                                        <img src="<?php echo $news['image']; ?>" alt="<?php echo $news['title']; ?>" class="news-image" width="50">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/50" alt="No image" class="news-image">
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $news['title']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($news['created_at'])); ?></td>
                                <td>
                                    <span class="status <?php echo $news['status']; ?>">
                                        <?php echo $news['status'] == 'active' ? 'Hiển thị' : 'Ẩn'; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="news.php?edit=<?php echo $news['id']; ?>" class="btn btn-edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="news.php?delete=<?php echo $news['id']; ?>" class="btn btn-delete"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa tin tức này?')">
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
