<?php
session_start();
require_once '../config/config.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Lấy thông tin sản phẩm cần sửa
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $sql = "SELECT * FROM products WHERE id = '$edit_id'";
    $result = mysqli_query($conn, $sql);
    $edit_product = mysqli_fetch_assoc($result);
}

// Xử lý nút hủy
if (isset($_GET['cancel'])) {
    header("Location: products.php");
    exit;
}

// Xử lý thêm sản phẩm
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    // Xử lý upload ảnh
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../uploads/products/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Tạo tên file duy nhất
        $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;

        // Di chuyển file vào thư mục đích
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $target_file;
        } else {
            echo 'Có lỗi xảy ra khi upload ảnh.';
        }
    }

    // Thêm sản phẩm mới
    $sql = "INSERT INTO products (name, category_id, price, quantity, description, image, status) 
            VALUES ('$name', '$category_id', '$price', '$quantity', '$description', '$image', '$status')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        include 'components/alert_success.php';
        echo "<script>showSuccessAlert('Thêm sản phẩm thành công!');</script>";
    } else {
        include 'components/alert_danger.php';
        echo "<script>showDangerAlert('Thêm sản phẩm thất bại!');</script>" . mysqli_error($conn);
    }
}

// Xử lý sửa sản phẩm
if (isset($_POST['edit_submit'])) {
// Get product ID from URL parameter since we're not using form ID field
    $id = $_GET['edit'];
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    // Xử lý upload ảnh
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../uploads/products/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Tạo tên file duy nhất
        $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;

        // Di chuyển file vào thư mục đích
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $target_file;
        } else {
            echo 'Có lỗi xảy ra khi upload ảnh.';
        }
    }

    // Cập nhật sản phẩm
    $sql = "UPDATE products SET name = '$name', category_id = '$category_id', price = '$price', quantity = '$quantity', description = '$description', status = '$status' ";
    if (!empty($image)) {
        $sql .= ", image = '$image' ";
    }
    $sql .= "WHERE id = '$id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        include 'components/alert_success.php';
        echo "<script>showSuccessAlert('Cập nhật sản phẩm thành công!');</script>";
    } else {
        include 'components/alert_danger.php';
        echo "<script>showDangerAlert('Cập nhật sản phẩm thất bại!');</script>" . mysqli_error($conn);
    }
}

// Xử lý xóa sản phẩm
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM products WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        include 'components/alert_success.php';
        echo "<script>showSuccessAlert('Xoá sản phẩm thành công!');</script>";
    } else {
        include 'components/alert_danger.php';
        echo "<script>showDangerAlert('Xoá sản phẩm thất bại!');</script>" . mysqli_error($conn);
    }
}

// Lấy danh sách danh mục từ database
$sql = "SELECT id, name FROM categories WHERE status = 'active' ORDER BY name ASC";
$categories =  mysqli_query($conn, $sql );

// Lấy danh sách sản phẩm
$sql = "SELECT p.*, c.name as category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        ORDER BY p.id DESC";
$products = mysqli_query($conn, $sql );

$page_title = "Quản lý sản phẩm";
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
          <!-- Form thêm/sửa sản phẩm -->
          <div class="form-container">
            <h2><?php echo isset($_GET['edit']) ? 'Sửa sản phẩm' : 'Thêm sản phẩm mới'; ?></h2>
            <form method="POST" enctype="multipart/form-data">
              <?php if (isset($edit_product)): ?>
                <input type="hidden" name="id" value="<?php echo $edit_product['id']; ?>">
              <?php endif; ?>
              
              <div class="form-group">
                <label for="name">Tên sản phẩm</label>
                <input type="text" id="name" name="name" required
                       value="<?php echo isset($edit_product) ? $edit_product['name'] : ''; ?>">
              </div>
              
              <div class="form-group">
                <label for="category_id">Danh mục</label>
                <select id="category_id" name="category_id" required>
                  <option value="">Chọn danh mục</option>
                  <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>"
                            <?php echo (isset($edit_product) && $edit_product['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                      <?php echo $category['name']; ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              
              <div class="form-group">
                <label for="price">Giá</label>
                <input type="number" id="price" name="price" required
                       value="<?php echo isset($edit_product) ? $edit_product['price'] : ''; ?>">
              </div>
              
              <div class="form-group">
                <label for="quantity">Số lượng</label>
                <input type="number" id="quantity" name="quantity" required
                       value="<?php echo isset($edit_product) ? $edit_product['quantity'] : '0'; ?>">
              </div>
              
              <div class="form-group">
                <label for="description">Mô tả</label>
                <textarea id="description" name="description" rows="3"><?php echo isset($edit_product) ? $edit_product['description'] : ''; ?></textarea>
              </div>
              
              <div class="form-group">
                <label for="image">Hình ảnh</label>
                <input type="file" id="image" name="image" accept="image/*">
                <?php if (isset($edit_product) && !empty($edit_product['image'])): ?>
                  <img src="<?php echo $edit_product['image']; ?>" alt="Current image" style="max-width: 100px; margin-top: 10px;">
                <?php endif; ?>
              </div>
              
              <div class="form-group">
                <label for="status">Trạng thái</label>
                <select id="status" name="status">
                  <option value="active" <?php echo (isset($edit_product) && $edit_product['status'] == 'active') ? 'selected' : ''; ?>>Còn hàng</option>
                  <option value="inactive" <?php echo (isset($edit_product) && $edit_product['status'] == 'inactive') ? 'selected' : ''; ?>>Hết hàng</option>
                </select>
              </div>          
              
              <div class="form-actions">
                <?php if (isset($_GET['edit'])): ?>
                    <button type="submit" name="edit_submit" class="btn btn-primary">Cập nhật</button>
                <?php else: ?>
                    <button type="submit" name="submit" class="btn btn-primary">Lưu</button>
                <?php endif; ?>
                <a href="products.php?cancel=1" class="btn btn-secondary">Hủy</a>
              </div>
            </form>
          </div>

          <!-- Bảng danh sách sản phẩm -->
          <div class="table-container">
            <div class="table-header">
              <h2>Danh sách sản phẩm</h2>
              <div class="table-actions">
                <input type="text" id="searchInput" placeholder="Tìm kiếm...">
                <a href="products.php" class="btn btn-primary">
                  <i class="fas fa-plus"></i> Thêm mới
                </a>
              </div>
            </div>
            
            <table class="data-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Hình ảnh</th>
                  <th>Tên sản phẩm</th>
                  <th>Danh mục</th>
                  <th>Giá</th>
                  <th>Số lượng</th>
                  <th>Trạng thái</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                  <td><?php echo $product['id']; ?></td>
                  <td>
                    <div class="product-image-container">
                      <?php if (!empty($product['image'])): ?>
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-image" width="80px" height="100%">
                      <?php else: ?>
                        <img src="https://via.placeholder.com/80" alt="No image" class="product-image" width="80px" height="100px">
                      <?php endif; ?>
                    </div>
                  </td>
                  <td><?php echo $product['name']; ?></td>
                  <td><?php echo $product['category_name']; ?></td>
                  <td><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</td>
                  <td><?php echo $product['quantity']; ?></td>
                  <td>
                    <span class="status <?php echo $product['status']; ?>">
                      <?php echo $product['status'] == 'active' ? 'Còn hàng' : 'Hết hàng'; ?>
                    </span>
                  </td>
                  <td>
                    <a href="products.php?edit=<?php echo $product['id']; ?>" class="btn btn-edit">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="products.php?delete=<?php echo $product['id']; ?>" class="btn btn-delete" 
                       onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
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
