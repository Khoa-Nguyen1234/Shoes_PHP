<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../../database/dbhelper.php');
date_default_timezone_set('Asia/Ho_Chi_Minh');

$id = $name = $price = $amount = $img = $content = "";
$allowUpload = true;

$target_dir =  "uploads/"; 

if (!file_exists($target_dir)) {
    mkdir($target_dir, 0755, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $amount = $_POST['amount'];
    $content = $_POST['content'];

    if (isset($_FILES["img"])) {
        $target_file = $target_dir . basename($_FILES["img"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $maxFileSize = 800000;
        $allowedExtensions = ['jpg', 'png', 'jpeg', 'gif'];

        $check = getimagesize($_FILES["img"]["tmp_name"]);
        if ($check === false) {
            echo "Không phải file ảnh.";
            $allowUpload = false;
        }

        if ($_FILES["img"]["size"] > $maxFileSize) {
            echo "Không được upload ảnh lớn hơn $maxFileSize (bytes).";
            $allowUpload = false;
        }

        if (!in_array($imageFileType, $allowedExtensions)) {
            echo "Chỉ được upload các định dạng JPG, PNG, JPEG, GIF";
            $allowUpload = false;
        }

        if ($allowUpload) {
            if (!move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                echo "Lỗi khi di chuyển ảnh. ";
                print_r(error_get_last());
            } else {
                $img = "uploads/" . basename($_FILES["img"]["name"]); 
            }
        }
    } else {
        $img = $_POST['old_img']; 
    }

    if (!empty($name)) {
        $updated_at = date('Y-m-d H:i:s');
        $sql = "UPDATE product SET name='$name', price='$price', amount='$amount', img='$img', content='$content', updated_at='$updated_at' WHERE id=$id";
        execute($sql);
        header('Location: ../sidebar/product.php');
        die();
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = 'SELECT * FROM product WHERE id=' . $id;
    $product = executeSingleResult($sql);
    if ($product != null) {
        $name = $product['name'];
        $price = $product['price'];
        $amount = $product['amount'];
        $img = $product['img'];
        $content = $product['content'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../css/product.css">
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
                Sửa sản phẩm
            </h1>
            <div class="search-wrapper">
                <span class="las la-search"></span>
                <input type="search" placeholder="Search products..." />
            </div>
            <div class="user-wrapper">
                <div>
                    <h4>Admin</h4>
                </div>
            </div>
        </header>
        <main>
            <form action="edit.php" method="post" class="product-form" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Tên Sản Phẩm:</label>
                    <input type="text" id="id" name="id" value="<?= $id ?>" hidden="true">
                    <input required="true" type="text" class="form-control" id="name" name="name" value="<?= $name ?>">
                </div>
                <div class="form-group">
                    <label for="name">Giá Sản Phẩm:</label>
                    <input required="true" type="text" class="form-control" id="price" name="price" value="<?= $price ?>">
                </div>
                <div class="form-group">
                    <label for="name">Số Lượng Sản Phẩm:</label>
                    <input required="true" type="amount" class="form-control" id="amount" name="amount" value="<?= $amount ?>">
                </div>
                <div class="form-group">
                    <label for="img">Hình ảnh:</label>
                    <input type="file" class="form-control-file" id="img" name="img" onchange="previewImage(event)">
                    <input type="hidden" name="old_img" value="<?= $img ?>">
                    <?php if (!empty($img)) : ?>
                        <img src="<?= $img ?>" style="max-width: 200px" id="img_preview">
                    <?php else: ?>
                        <img id="img_preview" style="max-width: 200px; display:none;">
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Nội dung</label>
                    <textarea class="form-control" id="content" rows="3" name="content"><?= $content ?></textarea>
                </div>
                <button class="btn btn-success">Lưu</button>
                <?php
                    $previous = "javascript:history.go(-1)";
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        $previous = $_SERVER['HTTP_REFERER'];
                    }
                ?>
                <button onclick="goBack()" class="btn btn-warning">Back</button>
            </form>
        </main>
    </div>
    <script type="text/javascript">
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('img_preview');
                output.src = reader.result;
                output.style.display = 'block';
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function goBack() {
            window.location.href = '../sidebar/product.php';
        }

        $(function() {
            $('#content').summernote({
                height: 200
            });
        });
    </script>
</body>
</html>