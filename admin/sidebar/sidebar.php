<?php
session_start();
$role = $_SESSION['role'] ?? '';
?>
<div class="sidebar">
    <div class="sidebar-brand">
        <h1>Admin</h1>
    </div>
    <div class="sidebar-menu">
        <ul>
            <li>
                <a href="dashboard.php">
                    <span class="las la-igloo"></span>
                    <span>Trang chủ</span>
                </a>
            </li>
            <?php if ($role === 'admin') : ?>
            <li>
                <a href="user.php">
                    <span class="las la-users"></span>
                    <span>Tài khoản</span>
                </a>
            </li>
            <?php endif; ?>
            <li>
                <a href="product.php">
                    <span class="las la-clipboard-list"></span>
                    <span>Sản phẩm</span>
                </a>
            </li>
            <li>
                <a href="orders.php">
                    <span class="las la-shopping-bag"></span>
                    <span>Đơn hàng</span>
                </a>
            </li>
            <li>
                <a href="promo.php">
                    <span class="las la-tag"></span>
                    <span>Mã khuyến mãi</span>
                </a>
            </li>
            <li>
                <a href="lienhe.php">
                    <span class="las la-envelope"></span>
                    <span>Liên hệ</span>
                </a>
            </li>
            <li>
                <a href="blog.php">
                    <span class="fas la-newspaper"></span>
                    <span>Blog</span>
                </a>
            </li>
        </ul>
    </div>
</div>
