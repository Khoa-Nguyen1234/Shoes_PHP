<?php
include '../../database/dbhelper.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');

function truncateContent($content, $limit = 100) {
    if (strlen($content) <= $limit) {
        return $content;
    }
    $lastSpace = strrpos(substr($content, 0, $limit), ' ');
    return substr($content, 0, $lastSpace) . '...';
}

function isValidImageURL($url) {
    $extensions = ['jpeg', 'jpg', 'png', 'gif'];
    $path_parts = pathinfo($url);
    return in_array(strtolower($path_parts['extension']), $extensions);
}

$products = executeResult("SELECT * FROM product");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="main.js"></script>
</head>
<body>
<?php include 'sidebar.php'; ?>
    <div class="main-content">
        <header>
            <h1>
                Sản phẩm
            </h1>
            <div class="search-wrapper">
                <span class="las la-search"></span>
                <input type="text" placeholder="Tìm kiếm..." />
            </div>
            <div class="user-wrapper">
                <div>
                    <h4>Admin</h4>
                </div>
            </div>
        </header>
        <main>
            <div class="add-product-link">
                <a href="../product/add.php">Thêm sản phẩm mới</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Giá tiền</th>
                        <th>Số lượng</th>
                        <th>Hình ảnh</th>
                        <th>Nội dung</th>
                        <th>Ngày thêm</th>
                        <th>Cập nhật</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) : ?>
                        <tr>
                            <td><?= $product['id'] ?></td>
                            <td><?= $product['name'] ?></td>
                            <td><?= $product['price'] ?></td>
                            <td><?= $product['amount'] ?></td>
                            <td>
                                <?php if (!empty($product['img']) && isValidImageURL($product['img'])) : ?>
                                    <img src="<?= '/DACN/admin/product/' . $product['img'] ?>" alt="Product Image" class="product-img">
                                <?php else : ?>
                                    No Image
                                <?php endif; ?>
                            </td>
                            <td><?= truncateContent($product['content']) ?></td>
                            <td><?= $product['created_at'] ?></td>
                            <td><?= $product['updated_at'] ?></td>
                            <td>
                                <a href="../product/edit.php?id=<?= $product['id'] ?>">Edit</a> | 
                                <a href="../product/delete.php?id=<?= $product['id'] ?>" onclick="return confirm('Bạn có muốn xóa sản phẩm này không?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>