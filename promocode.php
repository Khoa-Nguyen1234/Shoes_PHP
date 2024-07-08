<?php
require_once('database/dbhelper.php');
include 'layout/header.php';
if (!isset($_COOKIE['email'])) {
    header('Location: login.php');
    die();
}
$email = $_COOKIE['email'];
$user = executeSingleResult("SELECT id_user FROM user WHERE email = '$email'");
$userId = $user['id_user'];
$promos = executeResult("SELECT pc.* FROM promo_codes pc JOIN user_promo_codes up ON pc.id = up.promo_id WHERE up.user_email = '$email' AND pc.is_active = 1");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách mã giảm giá</title>
</head>
<body>
<div class="promo-container">
    <h2>Danh sách mã giảm giá</h2>
    <table>
        <thead>
            <tr>
                <th>Mã giảm giá</th>
                <th>Giảm giá</th>
                <th>Ngày hết hạn</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($promos as $promo) : ?>
                <tr>
                    <td><?= $promo['code'] ?></td>
                    <td><?= number_format(intval($promo['discount_amount']), 0, ',', '.'); ?> VNĐ</td>
                    <td><?= date("d-m-Y", strtotime($promo['expiry_date'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'layout/footer.php'; ?>
</body>
</html>
