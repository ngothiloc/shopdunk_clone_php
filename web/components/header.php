<style>
  .account-dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  right: 0;
  color: while;
  background-color: #fff;
  min-width: 160px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  border-radius: 8px;
  z-index: 1;
}

.dropdown-content a {
  color: #1d1d1f;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown-content a:hover {
  background-color: #f5f5f7;
}

.account-dropdown:hover .dropdown-content {
  display: block;
}

.account-button {
  display: flex;
  align-items: center;
  gap: 8px;
  background: none;
  border: none;
  cursor: pointer;
  color:rgb(255, 255, 255);
  padding: 8px;
}

.account-button span {
  font-size: 14px;
}
</style>
<nav class="main-nav">
  <div class="left-section">
    <a href="index.php" class="logo-link">
      <img
        src="web/assets/headerbanhang/logo-shopdunk.png"
        alt="ShopDunk Logo"
      />
    </a>
  </div>
  <div class="menu">
    <ul class="menu">
      <li class="menu-item"><a href="page_iphone.php">iPhone</a></li>
      <li class="menu-item"><a href="page_ipad.php">iPad</a></li>
      <li class="menu-item"><a href="page_macbook.php">Mac</a></li>
      <li class="menu-item"><a href="page_watch.php">Watch</a></li>
      <li class="menu-item"><a href="page_new.php">Newsfeed</a></li>
    </ul>
  </div>
  <div class="right-section">
    <button class="search-button">
      <i class="fas fa-search"></i>
    </button>
    <a href="#" class="cart-link">
      <i class="fas fa-shopping-bag"></i>
      <span class="cart-count">0</span>
    </a>
    <?php if(isset($_SESSION['user_id'])): ?>
      <div class="account-dropdown">
        <button class="account-button">
          <i class="fas fa-user"></i>
          <span><?php echo $_SESSION['user_name']; ?></span>
        </button>
        <div class="dropdown-content">
          <a href="profile.php">Tài khoản của tôi</a>
          <!-- <a href="orders.php">Đơn hàng</a> -->
          <a href="logout.php">Đăng xuất</a>
        </div>
      </div>
    <?php else: ?>
      <a href="signin.php" class="account-button">
        <i class="fas fa-user"></i>
        <span>Đăng nhập</span>
      </a>
    <?php endif; ?>
  </div>
</nav>