<?php
session_start();
require_once('database/config.php');
require_once('database/dbhelper.php');
function formatAddress($user) {
    $addressParts = [];
    if (isset($user['house_number']) && $user['house_number'] != '') {
        $addressParts[] = 'Số ' . $user['house_number'];
    }
    if (isset($user['street_name']) && $user['street_name'] != '') {
        $addressParts[] = $user['street_name'];
    }
    if (isset($user['ward']) && $user['ward'] != '') {
        $addressParts[] = 'Phường ' . $user['ward'];
    }
    if (isset($user['district']) && $user['district'] != '') {
        $addressParts[] = 'Quận ' . $user['district'];
    }
    if (isset($user['city']) && $user['city'] != '') {
        $addressParts[] = $user['city'];
    }
    return implode(', ', $addressParts);
}
if (!isset($_COOKIE['email'])) {
    header('Location: login.php');
    die();
}
$email = $_COOKIE['email'];
$query = "SELECT * FROM user WHERE email = '$email'";
$user = executeSingleResult($query);
include 'layout/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Profile</title>
    <link rel="stylesheet" href="./css/profile.css">
</head>
<body>
<div class="profile-container">
    <div class="profile-sidebar">
        <div class="avatar-section">
            <div class="avatar-image">
                <img src="<?= isset($user['profile_pic']) ? $user['profile_pic'] : 'path_to_user_image_or_placeholder.jpg' ?>" alt="User Avatar">
            </div>
            <h3><?= $user['name'] ?></h3>
        </div>
    </div>
    <div class="profile-main">
        <h2>Thông Tin Cá Nhân</h2>
        <div class="profile-info">
            <strong>Tên:</strong> <?= $user['name'] ?><br>
            <strong>Email:</strong> <?= $user['email'] ?><br>
            <strong>Số điện thoại:</strong> <?= $user['numberphone'] ?><br>
            <strong>Địa chỉ:</strong> <?= formatAddress($user) ?><br>
            <strong>Giới tính:</strong> <?= $user['gender'] ?><br>
            <strong>Ngày sinh:</strong> <?= date_format(date_create($user['dob']), "d-m-Y") ?><br>
        </div>
        <a href="update-profile.php" class="edit-profile-link">Chỉnh sửa thông tin cá nhân</a>
    </div>
</div>
</body>
</html>
