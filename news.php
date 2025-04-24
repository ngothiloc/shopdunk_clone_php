<?php
session_start();
require_once 'config/config.php';

// Lấy ID tin tức từ URL
$news_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Truy vấn thông tin tin tức
$sql = "SELECT * FROM news WHERE id = ? AND status = 'active'";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $news_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$news = mysqli_fetch_assoc($result);

if (!$news) {
    header("Location: index.php");
    exit;
}

$page_title = $news['title'];
include 'web/components/head.php';
?>
<body>
    <!-- header -->
    <?php include 'web/components/header.php'; ?>
    
    <div class="news-detail-container">
        <div class="news-detail-breadcrumb">
            <a href="index.php">Trang chủ</a> > 
            <a href="news.php">Tin tức</a> > 
            <?php echo $news['title']; ?>
        </div>

        <div class="news-detail-content">
            <h1 class="news-detail-title"><?php echo $news['title']; ?></h1>
            
            <div class="news-detail-meta">
                <span class="news-detail-date">
                    <i class="far fa-calendar-alt"></i>
                    Ngày đăng: <?php echo date('d/m/Y H:i', strtotime($news['created_at'])); ?>
                </span>
            </div>

            <?php if($news['image']): ?>
            <div class="news-detail-image">
                <img src="<?php echo str_replace('../', '', $news['image']); ?>" alt="<?php echo $news['title']; ?>" />
            </div>
            <?php endif; ?>

            <div class="news-detail-text">
                <?php echo nl2br($news['content']); ?>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php include 'web/components/footer.php';?>

    <style>
        .news-detail-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .news-detail-breadcrumb {
            margin-bottom: 20px;
            font-size: 14px;
            color: #666;
        }

        .news-detail-breadcrumb a {
            color: #007bff;
            text-decoration: none;
        }

        .news-detail-breadcrumb a:hover {
            text-decoration: underline;
        }

        .news-detail-content {
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .news-detail-title {
            font-size: 32px;
            color: #1d1d1f;
            margin-bottom: 20px;
            line-height: 1.3;
        }

        .news-detail-meta {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .news-detail-date {
            color: #666;
            font-size: 14px;
        }

        .news-detail-date i {
            margin-right: 5px;
        }

        .news-detail-image {
            margin-bottom: 30px;
            border-radius: 10px;
            overflow: hidden;
        }

        .news-detail-image img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.3s ease;
        }

        .news-detail-image img:hover {
            transform: scale(1.02);
        }

        .news-detail-text {
            font-size: 16px;
            line-height: 1.8;
            color: #333;
        }

        .news-detail-text p {
            margin-bottom: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .news-detail-container {
                margin: 20px auto;
            }

            .news-detail-content {
                padding: 20px;
            }

            .news-detail-title {
                font-size: 24px;
            }

            .news-detail-text {
                font-size: 15px;
                line-height: 1.6;
            }
        }

        @media (max-width: 480px) {
            .news-detail-container {
                padding: 0 15px;
            }

            .news-detail-title {
                font-size: 20px;
            }

            .news-detail-content {
                padding: 15px;
            }
        }
    </style>
</body>
</html>