<?php 
session_start();
include 'layout/header.php'; 
require_once('database/config.php');
require_once('database/dbhelper.php');
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php
if(isset($_GET['action']) && $_GET['action'] == 'addToCart' && isset($_GET['id'])) {
    $productId = $_GET['id'];
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if(!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 1;
    } else {
        $_SESSION['cart'][$productId]++;
    }
    echo "Success";
    die();
}
$products = executeResult("SELECT * FROM product");
?>
<!-- product section start -->
<div class="products-section">
    <div class="heading">
        <h1>Sản phẩm của<span> shoeshop</span></h1>
    </div>
    <div class="container">
        <div class="products-grid">
            <?php foreach ($products as $product) : ?>
            <div class="product-item">
                <a href="details.php?id=<?= $product['id'] ?>" class="product-link">
                    <?php 
                    $imagePath = '/DACN/admin/product/' . $product['img'];
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $imagePath) && !empty($product['img'])) : ?>
                        <img src="<?= $imagePath ?>" alt="Product Image" class="product-img">
                    <?php else : ?>
                        <img src="admin/uploads/default.jpg" alt="Default Image" class="product-img">
                    <?php endif; ?>
                    <h3><?= $product['name'] ?></h3>
                </a>
                <p class="price"><?= $product['price'] ?> VND</p>
                <a href="product.php?action=addToCart&id=<?= $product['id'] ?>" class="btn-buy">Thêm vào giỏ hàng</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- product section end -->
<script>
    $(document).ready(function() {
        $(".btn-buy").click(function(event) {
            event.preventDefault(); 
            let href = $(this).attr('href');
            $.get(href, function(response, status) {
                if (status === "success" && response === "Success") {
                    alert("Sản phẩm đã được thêm vào giỏ hàng!");
                }
            });
        });
    });
</script>
<?php include 'layout/footer.php'; ?>
