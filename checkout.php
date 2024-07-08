<?php 
ob_start(); 
session_start();
include 'layout/header.php'; 
require_once('database/config.php');
require_once('database/dbhelper.php');
if (!isset($_POST['action'])) {
    unset($_SESSION['applied_promo_code']);
    unset($_SESSION['discount']);
    unset($_SESSION['final_total']);
    unset($_SESSION['applied_promo_id']);
}
$totalCost = isset($_SESSION['totalCost']) ? $_SESSION['totalCost'] : 0;
$discount = isset($_SESSION['discount']) ? $_SESSION['discount'] : 0;
$finalTotal = isset($_SESSION['final_total']) ? $_SESSION['final_total'] : $totalCost;
$cartItems = [];
if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $productIds = implode(",", array_keys($_SESSION['cart']));
    $cartProducts = executeResult("SELECT * FROM product WHERE id IN ({$productIds})");
    foreach($cartProducts as $product) {
        $product['quantity'] = $_SESSION['cart'][$product['id']];
        $cartItems[] = $product;
    }
}
$userEmail = $_COOKIE['email'];
$user = executeResult("SELECT id_user FROM user WHERE email = '$userEmail'");
if (count($user) == 0) {
    die('User not found!');
}
$id_user = $user[0]['id_user'];
$availablePromos = executeResult("SELECT * FROM promo_codes p JOIN user_promo_codes up ON p.id = up.promo_id WHERE up.user_email = '{$userEmail}' AND (p.expiry_date > NOW() OR p.expiry_date IS NULL) AND p.min_order_value <= {$totalCost}");
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'apply_promo' && isset($_POST['promo_code']) && $_POST['promo_code'] != "" && $_POST['promo_code'] !== "Không sử dụng mã") {
        $code = $_POST['promo_code'];
        $result = executeResult("SELECT * FROM promo_codes WHERE code = '$code' AND (expiry_date > NOW() OR expiry_date IS NULL) LIMIT 1");
        if(count($result) > 0) {
            $promo = $result[0];
            if($promo['discount_type'] == 'percentage') {
                $discount = $totalCost * ($promo['discount_amount'] / 100);
            } else {
                $discount = $promo['discount_amount'];
            }
            $finalTotal = $totalCost - $discount;
            $_SESSION['discount'] = $discount;
            $_SESSION['final_total'] = $finalTotal;
            $_SESSION['applied_promo_id'] = $promo['id'];
        }
    }
    if ($_POST['action'] == 'checkout' && isset($_POST['fullname'])) {
        $orderTotalCost = $totalCost - $discount;
        $appliedPromoId = isset($_SESSION['applied_promo_id']) ? $_SESSION['applied_promo_id'] : 'NULL';
        $productNames = array_column($cartItems, 'name');
        $productQuantities = array_column($cartItems, 'quantity');
        $productNamesString = implode(", ", $productNames);
        $productQuantitiesString = implode(", ", $productQuantities);
        $sql = "INSERT INTO orders (id_user, user_fullname, user_email, user_phone, user_address, total_cost, discount, promo_id, product_name, product_quantity) VALUES ('$id_user', '{$_POST['fullname']}', '{$_POST['email']}', '{$_POST['phone']}', '{$_POST['address']}', '{$orderTotalCost}', '{$discount}', {$appliedPromoId}, '{$productNamesString}', '{$productQuantitiesString}')";
        execute($sql);
        if(isset($_SESSION['applied_promo_id'])) {
            execute("DELETE FROM user_promo_codes WHERE user_email = '{$userEmail}' AND promo_id = {$_SESSION['applied_promo_id']}");
            unset($_SESSION['applied_promo_id']);
        }
        unset($_SESSION['cart']); 
        $_SESSION['fullname'] = $_POST['fullname'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['phone'] = $_POST['phone'];
        $_SESSION['address'] = $_POST['address'];
        header("Location: thank_you.php");
        die();
    }
}
?>
<div class="checkout-container">
    <div class="heading">
        <h1>Thanh toán</h1>
    </div>
    <div class="checkout-content">
        <div>
            <form action="checkout.php" method="post">
                <input type="hidden" name="action" value="checkout">
                Họ và tên: <input type="text" name="fullname" required><br>
                Email: <input type="email" name="email" required><br>
                SĐT: <input type="tel" name="phone" required><br>
                Địa chỉ: <input type="text" name="address" required><br>
                <input type="submit" value="Thanh toán">
            </form>
        </div>
        <div class="cart-items">
            <h3>Sản phẩm trong giỏ hàng:</h3>
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Tên</th>
                        <th>Hình ảnh</th>
                        <th>Số lượng</th>
                        <th>Giá tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($cartItems as $item): ?>
                        <tr>
                            <td><?php echo $item["name"]; ?></td>
                            <td><img src='admin/product/<?php echo $item["img"]; ?>' alt='<?php echo $item["name"]; ?>' width='50'></td>
                            <td><?php echo $item["quantity"]; ?></td>
                            <td><?php echo number_format($item["price"], 0, ',', '.'); ?> VNĐ</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <form method="post" action="checkout.php" class="promo-form">
                <input type="hidden" name="action" value="apply_promo">
                <label for="promo_code_input">Chọn mã khuyến mãi:</label>
                <select name="promo_code" id="promo_code_input">
                    <option value="">Không sử dụng mã</option>
                    <?php foreach($availablePromos as $promo): ?>
                        <option value="<?= $promo['code'] ?>"><?= $promo['code'] ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Áp dụng</button>
            </form>
            <h4>Mã được chọn: <?= isset($_POST['promo_code']) ? $_POST['promo_code'] : 'Chưa chọn' ?></h4>
            <?php if ($discount > 0): ?>
                <h4>Discount: <?= number_format(intval($discount), 0, ',', '.'); ?> VNĐ</h4>
            <?php endif; ?>
            <h4>Tổng tiền: <?= number_format($totalCost - $discount, 0, ',', '.'); ?> VNĐ</h4>
        </div>
    </div>
</div>
<?php include 'layout/footer.php'; ?>
<?php ob_end_flush(); ?>
