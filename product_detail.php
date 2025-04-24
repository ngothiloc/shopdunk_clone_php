<?php 
session_start();
require_once 'config/config.php';

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
    exit;
}

$page_title = $product['name'];
include 'web/components/head.php';
?>
<body>
    <!-- header -->
    <?php include 'web/components/header.php'; ?>
    <div class="product-detail-breadcrumb">
        <a href="index.php">Trang chủ</a> > 
        <a href="#"><?php echo $product['category_name']; ?></a> > 
        <?php echo $product['name']; ?>
    </div>

    <div class="product-detail-container">
        <div class="product-detail-image">
            <img src="<?php echo str_replace('../', '', $product['image']); ?>" alt="<?php echo $product['name']; ?>" />
        </div>
        <div class="product-detail-info">
            <h1 class="product-detail-title">
                <?php echo $product['name']; ?>
            </h1>

            <div class="product-detail-price-wrapper">
                <span class="product-detail-price"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</span>
            </div>

            <div class="product-detail-meta">
                <p class="product-detail-meta-item">
                    <span class="product-detail-meta-label">Trạng thái:</span>
                    <span class="product-detail-status <?php echo $product['quantity'] > 0 ? 'product-detail-status-active' : 'product-detail-status-inactive'; ?>">
                        <?php echo $product['quantity'] > 0 ? 'Còn hàng' : 'Hết hàng'; ?>
                    </span>
                </p>
                <p class="product-detail-meta-item">
                    <span class="product-detail-meta-label">Số lượng:</span>
                    <span class="product-detail-quantity"><?php echo $product['quantity']; ?> sản phẩm</span>
                </p>
                <p class="product-detail-meta-item">
                    <span class="product-detail-meta-label">Ngày tạo:</span>
                    <span class="product-detail-date"><?php echo date('d/m/Y', strtotime($product['created_at'])); ?></span>
                </p>
                <p class="product-detail-meta-item">
                    <span class="product-detail-meta-label">Danh mục:</span>
                    <span class="product-detail-category"><?php echo $product['category_name']; ?></span>
                </p>
            </div>

            <div class="product-detail-description">
                <h3 class="product-detail-description-title">Mô tả sản phẩm</h3>
                <p class="product-detail-description-content">
                    <?php echo nl2br($product['description']); ?>
                </p>
            </div>

            <div class="product-detail-promotions">
                <h3 class="product-detail-promotions-title">Ưu đãi</h3>
                <div class="product-detail-promotion-item">
                    <i class="fas fa-check-circle" style="color: #0066cc"></i>
                    <span>Giảm đến 200.000đ khi thanh toán qua Kredivo</span>
                </div>
                <div class="product-detail-promotion-item">
                    <i class="fas fa-check-circle" style="color: #0066cc"></i>
                    <span>Dây đeo Apple Watch chính hãng Apple giảm 100.000đ</span>
                </div>
                <div class="product-detail-promotion-item">
                    <i class="fas fa-check-circle" style="color: #0066cc"></i>
                    <span>Mua combo phụ kiện Non Apple giảm đến 200.000đ</span>
                </div>
            </div>

            <!-- <button class="product-detail-buy-btn">MUA NGAY</button> -->
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="order.php?id=<?php echo $product_id; ?>" class="product-detail-buy-btn">MUA NGAY</a>
            <?php else: ?>
                <a href="signin.php" onclick="alert('Vui lòng đăng nhập để mua hàng!');" class="product-detail-buy-btn">MUA NGAY</a>
            <?php endif; ?>
        </div>
    </div>
    <?php include 'web/components/footer.php';?>
</body>
</html>
