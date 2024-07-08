<?php 
session_start();
include 'layout/header.php'; 
require_once('database/config.php');
require_once('database/dbhelper.php');
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php
$productId = $_GET['id'];
$product = executeSingleResult("SELECT * FROM product WHERE id='$productId'");
$relatedProducts = executeResult("SELECT * FROM product WHERE id!='$productId' LIMIT 5");
?>
<div class="prod-detail-container">
    <div class="prod-detail-product-details">
        <div class="prod-detail-main-images">
            <img src="/DACN/admin/product/<?= $product['img'] ?>" alt="<?= $product['name'] ?>" class="prod-detail-main-image">
        </div>
        <div class="prod-detail-info">
            <h2><?= $product['name'] ?></h2>
            <p><?= $product['content'] ?></p>
            <p class="price">Giá bán: <?= $product['price'] ?> VND</p>
            <div class="buy-section">
                <input type="number" name="quantity" value="1" min="1">
                <a href="product.php?action=addToCart&id=<?= $product['id'] ?>" class="prod-detail-btn-buy btn-buy">Thêm vào giỏ hàng</a>
            </div>
        </div>
        <a href="">abc</a>
        <div class="prod-detail-related-products">
            <h3>Sản phẩm liên quan</h3>
            <ul>
                <?php foreach ($relatedProducts as $relatedProduct) : ?>
                <li>
                    <a href="details.php?id=<?= $relatedProduct['id'] ?>">
                        <img src="/DACN/admin/product/<?= $relatedProduct['img'] ?>" alt="<?= $relatedProduct['name'] ?>">
                        <div class="prod-detail-product-info">
                            <h4><?= $relatedProduct['name'] ?></h4>
                            <p><?= $relatedProduct['price'] ?> VND</p>
                        </div>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
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
