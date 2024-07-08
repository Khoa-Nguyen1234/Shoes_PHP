<?php
require_once('../../database/dbhelper.php');
$promo_id = isset($_GET['id']) ? $_GET['id'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';
if ($search) {
    $users = executeResult("SELECT email FROM user WHERE email LIKE '%$search%'");
} else {
    $users = executeResult("SELECT email FROM user");
}
$assigned_users = executeResult("SELECT user_email FROM user_promo_codes WHERE promo_id = ?", [$promo_id]);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_emails = $_POST['user_email'];
    $promo_id = $_POST['promo_id'];
    $action = $_POST['action'];
    foreach ($user_emails as $email) {
        if ($action == 'adduser_promo') {
            $sql = "INSERT IGNORE INTO user_promo_codes (user_email, promo_id) VALUES (?, ?)";
            execute($sql, [$email, $promo_id]);
        } elseif ($action == 'deleteuser_promo') {
            $sql = "DELETE FROM user_promo_codes WHERE user_email = ? AND promo_id = ?";
            execute($sql, [$email, $promo_id]);
        }
    }
    header('Location: ../sidebar/promo.php');
    die();
}
$promo_id = isset($_GET['id']) ? $_GET['id'] : '';
$users = executeResult("SELECT email FROM user");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gán mã giảm giá</title>
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
            Gán mã giảm giá cho người dùng
        </h1>
    </header>
    <main>
        <div>
            <label for="search_user">Tìm kiếm người dùng:</label>
            <input type="text" id="search_user" placeholder="Nhập email người dùng...">
            <button onclick="filterUsers()">Tìm kiếm</button>
        </div>
        <form action="adduser_promo.php" method="post">
            <div>
                <label for="user_email">Chọn người dùng:</label>
                <select multiple id="user_email" name="user_email[]" class="user-select">
                    <?php
                        foreach ($users as $user) {
                            $isAssigned = in_array($user['email'], array_column($assigned_users, 'user_email')) ? 'class="assigned-promo"' : '';
                            echo "<option value='{$user['email']}' {$isAssigned}>{$user['email']}</option>";
                        }
                    ?>
                </select>
            </div>
            <input type="hidden" name="promo_id" value="<?= $promo_id ?>">
            <button type="submit" name="action" value="adduser_promo">Gán mã</button>
            <button type="submit" name="action" value="deleteuser_promo">Hủy gán cho người dùng đã chọn</button>
        </form>
    </main>
</div>
<script>
    function filterUsers() {
        var searchValue = document.getElementById('search_user').value.toLowerCase();
        var options = document.querySelectorAll('#user_email option');
        options.forEach(option => {
            if (option.textContent.toLowerCase().includes(searchValue)) {
                option.style.display = "";
            } else {
                option.style.display = "none";
            }
        });
    }
</script>
</body>
</html>
