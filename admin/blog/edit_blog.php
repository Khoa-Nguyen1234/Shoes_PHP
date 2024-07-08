<?php
include '../../database/dbhelper.php';
$message = "";
if ($_GET['id']) {
    $id = $_GET['id'];
    $blog = executeSingleResult("SELECT * FROM blogs WHERE id = $id");
} else {
    header('Location: blog.php');
    die();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image_path = $blog['image_path'];
    if ($_FILES['image']['name']) {
        $image_path = '../../image/blog/' . basename($_FILES['image']['name']);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
            $message = "Failed to upload image.";
        }
    }
    if (!$message) {
        $sql = "UPDATE blogs SET title = ?, content = ?, image_path = ? WHERE id = ?";
        execute($sql, [$title, $content, $image_path, $id]);
        $message = "Blog updated successfully!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>
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
        <h1>Edit Blog</h1>
        <div class="search-wrapper">
            <span class="las la-search"></span>
            <input type="search" placeholder="Search blog..." />
        </div>
        <div class="user-wrapper">
            <div>
                <h4>Admin</h4>
            </div>
        </div>
    </header>
    <main>
        <div class="admin-section">
            <?php if ($message): ?>
                <p class="message"><?= $message; ?></p>
            <?php endif; ?>
            <form action="edit_blog.php?id=<?= $id ?>" method="post" enctype="multipart/form-data">
                <label>Tên Blog:</label>
                <input type="text" name="title" required value="<?= $blog['title'] ?>">
                <label>Nội dung:</label>
                <textarea name="content" rows="10" required><?= $blog['content'] ?></textarea>
                <label>Hình ảnh:</label>
                <input type="file" name="image">
                <button type="submit">Sửa Blog</button>
            </form>
        </div>
    </main>
</div>
</body>
</html>
