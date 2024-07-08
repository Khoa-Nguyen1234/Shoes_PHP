<?php
require_once('../../database/dbhelper.php');
$id = $_GET['id'];
if (isset($_POST['code']) && isset($_POST['discount_amount']) && isset($_POST['discount_type']) && isset($_POST['expiry_date'])) {
    $code = $_POST['code'];
    $discount_amount = $_POST['discount_amount'];
    $discount_type = $_POST['discount_type'];
    $expiry_date = $_POST['expiry_date'];
    $min_order_value = $_POST['min_order_value'];
    $sql = "UPDATE promo_codes SET code = '$code', discount_amount = $discount_amount, discount_type = '$discount_type', expiry_date = '$expiry_date', min_order_value = $min_order_value WHERE id = $id";
    execute($sql);
    header('Location: ../sidebar/promo.php');
}
$promo = executeSingleResult("SELECT * FROM promo_codes WHERE id = $id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa mã giảm giá</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="main.js"></script>
</head>
<body>
<div class="sidebar">
        <div class="sidebar-brand">
            <h1>Admin</h1>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="../sidebar/dashboard.php">
                        <span class="las la-igloo"></span>
                        <span>Trang chủ</span>
                    </a>
                </li>
                <li>
                    <a href="../sidebar/user.php">
                        <span class="las la-users"></span>
                        <span>Tài khoản</span>
                    </a>
                </li>
                <li>
                    <a href="../sidebar/product.php">
                        <span class="las la-clipboard-list"></span>
                        <span>Sản phẩm</span>
                    </a>
                </li>
                <li>
                    <a href="../sidebar/orders.php">
                        <span class="las la-shopping-bag"></span>
                        <span>Đơn hàng</span>
                    </a>
                </li>
                <li>
                    <a href="../sidebar/promo.php">
                        <span class="las la-tag"></span>
                        <span>Mã khuyến mãi</span>
                    </a>
                </li>
                <li>
                    <a href="../sidebar/lienhe.php">
                        <span class="las la-envelope"></span>
                        <span>Liên hệ</span>
                    </a>
                </li>
                <li>
                    <a href="../sidebar/blog.php">
                        <span class="fas la-newspaper"></span>
                        <span>Blog</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
<div class="main-content">
    <header>
        <h1>
            Sửa mã giảm giá
        </h1>
        <div class="search-wrapper">
            <span class="las la-search"></span>
            <input type="search" placeholder="Search promo..." />
        </div>
        <div class="user-wrapper">
            <div>
                <h4>Admin</h4>
            </div>
        </div>
    </header>
    <main>
        <form method="post" class="promo-form">
            <div class="form-group">
                <label for="code">Mã:</label>
                <input type="text" id="code" name="code" required class="form-control" value="<?= $promo['code'] ?>">
            </div>
            <div class="form-group">
                <label for="discount_amount">Giảm giá:</label>
                <input type="number" id="discount_amount" name="discount_amount" required class="form-control" value="<?= number_format($promo['discount_amount'], 0, '', '') ?>">
            </div>
            <div class="form-group">
                <label for="discount_type">Kiểu giảm giá:</label>
                <select name="discount_type" class="form-control">
                    <option value="fixed" <?= $promo['discount_type'] == 'fixed' ? 'selected' : '' ?>>Cố định</option>
                </select>  
            </div>
            <div class="form-group">
                <label for="min_order_value">Hạn mức tối thiểu:</label>
                <input type="number" id="min_order_value" name="min_order_value" required class="form-control" value="<?= number_format($promo['min_order_value'], 0, '', '') ?>">
            </div>
            <div class="form-group">
                <label for="expiry_date">Ngày hết hạn:</label>
                <input type="date" id="expiry_date" name="expiry_date" class="form-control" value="<?= $promo['expiry_date'] ?>">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Cập nhật</button>
                <button type="button" class="btn btn-warning" id="btnBack">Trở về</button>
            </div>
        </form>
    </main>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById('expiry_date').setAttribute('min', today);

        document.getElementById('btnBack').addEventListener('click', function() {
            window.location.href = "../sidebar/promo.php"; 
        });
    });
</script>
</body>
</html>
