<header>
    <div class="header-title">
        <h1><?php echo isset($page_title) ? $page_title : 'Admin Panel'; ?></h1>
    </div>
    <div class="user-info">
        <span><?php echo $_SESSION['username']; ?></span>
        <img src="https://avatar.iran.liara.run/public/44" alt="Admin">
        <a href="components/logout.php" class="btn btn-logout">
            <i class="fas fa-sign-out-alt"></i> Đăng xuất
        </a>
    </div>
</header>