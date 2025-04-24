<?php
 session_start();
 require_once 'config/config.php';

$sql = "SELECT p.* 
        FROM products p
        INNER JOIN categories c ON p.category_id = c.id
        WHERE c.name = 'watch'
        ORDER BY p.id DESC" ;
$watchs = mysqli_query($conn, $sql);

$page_title = "Sản phẩm watch";
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

    <!-- product iphone -->
    <div class="sanpham">
      <a href="#">
        <h2>watch</h2>
      </a>
      <div class="products">
        <?php foreach ($watchs as $watch):?>
        <div class="product">
          <a href="product_detail.php?id=<?php echo $watch['id']; ?>">
            <img src="<?php echo str_replace('../', '', $watch['image']); ?>" width="240" height="240" />
            <h3><?php echo $watch['name'];?></h3>
            <span><?php echo number_format($watch['price'], 0, ',', '.');?>đ</span>
          </a>
        </div>
        <?php endforeach;?>
      </div>
    </div>
    <?php include 'web/components/footer.php';?>
</body>
</html>
    