<?php 
session_start();
require_once 'config/config.php';

// Lấy danh sách sản phẩm từ database
$sql = "SELECT p.* 
        FROM products p
        INNER JOIN categories c ON p.category_id = c.id
        WHERE c.name = 'iphone'
        ORDER BY p.id DESC
        LIMIT 4";
$iphone_products = mysqli_query($conn, $sql );

$sql = "SELECT p.* 
        FROM products p
        INNER JOIN categories c ON p.category_id = c.id
        WHERE c.name = 'ipad'
        ORDER BY p.id DESC
        LIMIT 4";
$ipad_products = mysqli_query($conn, $sql );

$sql = "SELECT p.* 
        FROM products p
        INNER JOIN categories c ON p.category_id = c.id
        WHERE c.name = 'watch'
        ORDER BY p.id DESC
        LIMIT 4";
$watch_products = mysqli_query($conn, $sql );

$sql = "SELECT P.*
        FROM products p
        INNER JOIN categories c ON p.category_id = c.id
        WHERE c.name = 'macbook'
        ORDER BY p.id DESC
        LIMIT 4";
$macbook_products = mysqli_query($conn, $sql );

$sql = "SELECT * FROM news WHERE status = 'active' ORDER BY created_at DESC LIMIT 4";
$news = mysqli_query($conn, $sql);

$page_title = "Trang chủ";
include 'web/components/head.php';
?>
  <body>
    <!-- header -->
    <?php include 'web/components/header.php'; ?>

    <!-- slidebar -->
    <div class="slider">
      <div class="slides">
        <img src="web/assets/main/banner iP16sr_PC.png" alt="Ảnh 1" class="slide" />
        <img src="web/assets/main/banner iPdsr_PC.png" alt="Ảnh 2" class="slide" />
        <img src="web/assets/main/banner Mbsr_PC.png" alt="Ảnh 3" class="slide" />
      </div>
      <button class="prev" onclick="prevSlide()">❮</button>
      <button class="next" onclick="nextSlide()">❯</button>
    </div>

    <!-- product iphone-->
    <div class="sanpham">
      <a href="page_iphone.php">
        <h2>iphone</h2>
      </a>
      <div class="products">
        <?php foreach ($iphone_products as $product): ?>
        <div class="product">
          <a href="product_detail.php?id=<?php echo $product['id']; ?>">
            <img src="<?php echo str_replace('../', '', $product['image']); ?>" width="240" height="240" />
            <h3><?php echo $product['name']; ?></h3>
            <span><?php echo number_format($product['price'], 0, ',', '.'); ?> đ</span>
          </a>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="btn-wrapper">
         <a  class="btnThem" href="page_iphone.php">Xem tất cả iPhone</a>
      </div>
    </div>

    <!-- product ipad-->
    <div class="sanpham">
      <a href="page_ipad.php">
        <h2>ipad</h2>
      </a>
      <div class="products">
        <?php foreach ($ipad_products as $product): ?>
        <div class="product">   
          <a href="product_detail.php?id=<?php echo $product['id']; ?>">       
            <img src="<?php echo str_replace('../', '', $product['image']); ?>" width="240" height="240" />
            <h3><?php echo $product['name']; ?></h3>          
            <span><?php echo number_format($product['price'], 0, ',', '.'); ?> đ</span>
          </a>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="btn-wrapper">
         <a  class="btnThem" href="page_ipad.php">Xem tất cả iPhone</a>
      </div>
    </div>

    <!-- product watch-->
    <div class="sanpham">
       <a href="page_watch.php">
        <h2>Watch</h2>
      </a>
      <div class="products">
        <?php foreach ($watch_products as $product): ?>
        <div class="product">
          <a href="product_detail.php?id=<?php echo $product['id']; ?>">
            <img src="<?php echo str_replace('../', '', $product['image']); ?>" width="240" height="240" />
            <h3><?php echo $product['name']; ?></h3>
            <span><?php echo number_format($product['price'], 0, ',', '.'); ?> đ</span>
          </a>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="btn-wrapper">
        <a class="btnThem" href="page_watch.php">Xem tất cả iPhone</a>
      </div>
    </div>

    <!-- product macbook -->
     <div class="sanpham">
       <a href="page_macbook.php">
        <h2>Macbook</h2>
      </a>
      <div class="products">
        <?php foreach ($macbook_products as $product): ?>
        <div class="product">
          <a href="product_detail.php?id=<?php echo $product['id']; ?>">
            <img src="<?php echo str_replace('../', '', $product['image']); ?>" width="240" height="240" />
            <h3><?php echo $product['name']; ?></h3>
            <span><?php echo number_format($product['price'], 0, ',', '.'); ?> đ</span>
          </a>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="btn-wrapper">
        <a class="btnThem" href="page_macbook.php">Xem tất cả Macbook</a>
      </div>
    </div>

    <div class="banner">
      <img src="web/assets/main/banner.jpeg" width="100%" height="100%" />
    </div>

    <!-- Newsfeed -->
    <div class="tintuc">
      <a href="page_new.php">
        <h2>Newsfeed</h2>
      </a>

      <div class="newsfeed">
        <?php foreach ($news as $new): ?>
        <div class="new">
          <a href="news.php?id=<?php echo $new['id']; ?>">
            <div class="img_news">
              <img src="<?php echo str_replace('../', '', $new['image']); ?>" width="385px" height="176px" />
            </div>
            <div class="title_new">
              <h5><?php echo $new['title']; ?></h5>
              <div class="date_new">
                <p style="font-size: 12px; display: flex; justify-content: flex-end; margin-top: 8px"><?php echo $new['created_at']; ?></p>
              </div>
            </div>
          </a>
        </div>
        <?php endforeach; ?>        
      </div>
    </div>

    <!-- footer -->
    <?php include 'web/components/footer.php';?>
    <script src="web/js/script.js"></script>
  </body>
</html>
