<!DOCTYPE html>
<html lang="en">
<?php
require_once('database/config.php');
require_once('database/dbhelper.php');
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css">
    <title>shoeshop </title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- header section start -->
    <header>
        <a href="index.php"><img src="" alt="" width="170px"></a>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Trang Chủ</a></li>
                <li><a href="product.php">Sản Phẩm</a></li>
                <li><a href="blog.php">blog</a></li>
                <li><a href="lienhe.php">Liên Hệ</a></li>
            </ul>
        </nav>
        <div class="icons">
            <a href="#search" id="search-icon">
                <i class="bx bx-search-alt-2"></i>
            </a>
            <a href="cart.php">
                <i class="bx bxs-cart-alt"></i>
            </a>
            <div class="login">
                <?php
                if (isset($_COOKIE['name'])) {
                    $name = $_COOKIE['name'];
                    echo '<a href="#" class="user-dropdown"><i class="bx bxs-user"></i> ' . $name . '</a>';
                    if ($_COOKIE['email'] == 'Admin' || $_COOKIE['email'] == 'admin') {
                        echo '
                        <div class="logout">
                            <a href="admin/"><i class="fas fa-user-edit"></i>Admin</a>
                            <a href="login/logout.php"><i class="fas fa-sign-out-alt"></i>Đăng xuất</a>
                        </div>';
                    } else {
                        echo '
                        <div class="logout">
                            <a href="profile.php"><i class="fas fa-user-circle"></i>Thông tin cá nhân</a>
                            <a href="order_history.php"><i class="fas fa-history"></i>Lịch sử đơn hàng</a>
                            <a href="promocode.php"><i class="fas fa-tag"></i>Mã khuyến mãi</a>
                            <a href="login/changePass.php"><i class="fas fa-exchange-alt"></i>Đổi mật khẩu</a>
                            <a href="login/logout.php"><i class="fas fa-sign-out-alt"></i>Đăng xuất</a>
                        </div>';
                    }
                } else {
                    echo '<a href="login/login.php"><i class="bx bxs-user"></i> Đăng nhập</a>';
                }
                ?>
            </div>
            <a href="#menu">
                <div class="bx bx-menu"></div>
            </a>
        </div>    
    </header>
    <!-- header section end -->
    <!-- home section start -->
    <div class="slider-container" id="home">
        <div class="slider">
            <div class="slideBox active">
                <div class="imgBox">
                    <img src="image/banner/banner.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- home section end -->
