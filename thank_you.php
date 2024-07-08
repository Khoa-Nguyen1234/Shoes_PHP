<?php 
session_start();
include 'layout/header.php'; 
?>
<div class="thankyou-container">
    <h1>Cảm ơn bạn đã đặt hàng!</h1>
    <p>Chúng tôi sẽ xử lý đơn hàng và liên hệ với bạn sớm nhất.</p>
    <p>
        <strong>Thông tin đặt hàng của bạn:</strong><br>
        Họ và tên: <?= $_SESSION['fullname'] ?><br>
        Email: <?= $_SESSION['email'] ?><br>
        SĐT: <?= $_SESSION['phone'] ?><br>
        Địa chỉ: <?= $_SESSION['address'] ?><br>
    </p>
    <a href="product.php">Tiếp tục mua hàng</a>
</div>
<?php include 'layout/footer.php'; ?>
