<?php
 session_start();
 require_once 'config/config.php';

$sql = "SELECT * FROM news ORDER BY id DESC" ;
       
$news = mysqli_query($conn, $sql);

$page_title = "Sản phẩm macbook";
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

    <!-- product macbook -->
    <div class="tintuc">
      <a href="news.php">
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
    <?php include 'web/components/footer.php';?>
</body>
</html>
    