<?php 
ob_start();
session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: login/login.php');
    exit();
}
include 'layout/header.php'; 
require_once('database/config.php');
require_once('database/dbhelper.php');
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $productId = $_GET['id'];
    unset($_SESSION['cart'][$productId]);
    header('Location: cart.php');
    die();
}
if (isset($_POST['productId']) && isset($_POST['quantity'])) {
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];
    $_SESSION['cart'][$productId] = $quantity;
    header('Location: cart.php');
    die();
}
$cartItems = [];
if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $productIds = implode(",", array_keys($_SESSION['cart']));
    $cartProducts = executeResult("SELECT * FROM product WHERE id IN ({$productIds})");
    foreach($cartProducts as $product) {
        $product['quantity'] = $_SESSION['cart'][$product['id']];
        $cartItems[] = $product;
    }
}
$totalCost = 0;
foreach ($cartItems as $item) {
    $itemTotal = $item["quantity"] * $item["price"];
    $totalCost += $itemTotal;
}
$_SESSION['totalCost'] = $totalCost;
?>
<div class="cart-container">
    <div class="heading">
        <h1>Giỏ hàng</h1>
    </div>
    <?php
    if(count($cartItems) > 0) {
    ?>
    <table class="cart-table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên Sản Phẩm</th>
                <th>Ảnh</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng tiền</th>
                <th>Xóa</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stt = 0; 
            foreach ($cartItems as $item) {
                $itemTotal = $item["quantity"] * $item["price"];
                echo "<tr>";
                echo "<td>" . (++$stt) . "</td>";  
                echo "<td>{$item['name']}</td>";
                echo "<td><img src='admin/product/{$item['img']}' alt='' width='50'></td>";
                echo "<td>\${$item['price']}</td>";
                echo "<form method='post'>";
                echo "<td><input type='number' name='quantity' value='{$item['quantity']}' min='1' style='width: 40px;' onchange='this.form.submit()'>
                        <input type='hidden' name='productId' value='{$item['id']}'></td>";
                echo "</form>";
                echo "<td>\${$itemTotal}</td>";
                echo "<td><a href='cart.php?action=delete&id={$item['id']}'>Xóa</a></td>";
                echo "</tr>";
            }
            ?>
            <tr>
                <td colspan="5"></td>
                <td>Tổng tiền: $<?= $totalCost ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <div class="checkout">
        <a href="checkout.php" class="checkout-btn">Thanh toán</a>
    </div>
    <?php
    } else {
        echo '<p>Chưa có sản phẩm trong giỏ hàng, vui lòng thêm sản phẩm <a href="product.php">tại đây</a>.</p>';
    }
    ?>
</div>
<?php 
include 'layout/footer.php'; 
ob_end_flush();
?>
