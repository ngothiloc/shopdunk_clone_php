<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="sidebar">
    <div class="logo">
        <h2>Admin Panel</h2>
    </div>
    <ul class="nav-links">
        <li <?php echo $current_page == 'index.php' ? 'class="active"' : ''; ?>>
            <a href="index.php">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li <?php echo $current_page == 'categories.php' ? 'class="active"' : ''; ?>>
            <a href="categories.php">
                <i class="fas fa-list"></i>
                <span>Quản lý danh mục</span>
            </a>
        </li>
        <li <?php echo $current_page == 'products.php' ? 'class="active"' : ''; ?>>
            <a href="products.php">
                <i class="fas fa-box"></i>
                <span>Quản lý sản phẩm</span>
            </a>
        </li>
        <li <?php echo $current_page == 'news.php' ? 'class="active"' : ''; ?>>
            <a href="news.php">
                <i class="fas fa-newspaper"></i>
                <span>Quản lý tin tức</span>
            </a>
        </li>
        <li <?php echo $current_page == 'customers.php' ? 'class="active"' : ''; ?>>
            <a href="customers.php">
                <i class="fas fa-users"></i>
                <span>Quản lý khách hàng</span>
            </a>
        </li>
        <li <?php echo $current_page == 'order.php' ? 'class="active"' : ''; ?>>
            <a href="order.php">
                <i class="fas fa-shopping-cart"></i>
                <span>Quản lý đơn hàng</span>
            </a>
        </li>
    </ul>
</div> 