<?php
session_start();
require_once('database/config.php');
require_once('database/dbhelper.php');
if (!isset($_COOKIE['email'])) {
    header('Location: login.php');
    die();
}
$email = $_COOKIE['email'];
$query = "SELECT * FROM user WHERE email = '$email'";
$user = executeSingleResult($query);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $numberphone = $_POST['numberphone'];
    $house_number = $_POST['house_number'];
    $street_name  = $_POST['street_name'];
    $ward         = $_POST['ward'];
    $district     = $_POST['district'];
    $city         = $_POST['city'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $avatarPath = '';
    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $targetDir = "image/upload/";
        $fileName = basename($_FILES["profile_pic"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg','png','jpeg','gif');
        if(in_array($fileType, $allowTypes)){
            if(move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetFilePath)){
                $avatarPath = $targetFilePath;
            }
        }
    }
    $updateQuery = "UPDATE user SET name = '$name', email = '$email', numberphone = '$numberphone', gender = '$gender', dob = '$dob', house_number = '$house_number', street_name = '$street_name', ward = '$ward', district = '$district', city = '$city' ";
    if(!empty($avatarPath)) {
        $updateQuery .= ", profile_pic = '$avatarPath'";
    }
    $updateQuery .= " WHERE email = '$email'";
    execute($updateQuery);
    header('Location: profile.php');
    die();
}
include 'layout/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="./css/profile.css">
</head>
<body>
<form action="update-profile.php" method="post" enctype="multipart/form-data">
    <div class="profile-container">
        <div class="avatar-section">
            <div class="avatar-image">
                <img src="<?= isset($user['profile_pic']) ? $user['profile_pic'] : 'path_to_user_image_or_placeholder.jpg' ?>" alt="User Avatar">
            </div>
            <h3><?= $user['name'] ?></h3>
            <br>
            <label for="profile_pic">Thay đổi Avatar:</label>
            <br>
            <input type="file" name="profile_pic" id="profile_pic">
        </div>
        <div class="profile-main">
            <h2>Thông Tin Cá Nhân</h2>
                <div class="input-group">
                    <label for="name">Tên:</label>
                    <input type="text" name="name" id="name" value="<?= $user['name'] ?>">
                </div>
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="<?= $user['email'] ?>">
                </div>
                <div class="input-group">
                    <label for="numberphone">Số điện thoại:</label>
                    <input type="text" name="numberphone" id="numberphone" value="<?= $user['numberphone'] ?>" pattern="^\d{10}$" title="Vui lòng nhập đúng 10 số">
                </div>
                <div class="input-group">
                    <label for="house_number">Số nhà:</label>
                    <input type="text" name="house_number" id="house_number" value="<?= isset($user['house_number']) ? $user['house_number'] : '' ?>" required>
                </div>
                <div class="input-group">
                    <label for="street_name">Tên đường:</label>
                    <input type="text" name="street_name" id="street_name" value="<?= isset($user['street_name']) ? $user['street_name'] : '' ?>" required>
                </div>
                <div class="input-group">
                    <label for="ward">Phường:</label>
                    <input type="text" name="ward" id="ward" value="<?= isset($user['ward']) ? $user['ward'] : '' ?>" required>
                </div>
                <div class="input-group">
                    <label for="district">Quận:</label>
                    <input type="text" name="district" id="district" value="<?= isset($user['district']) ? $user['district'] : '' ?>" required>
                </div>
                <div class="input-group">
                    <label for="city">Thành phố:</label>
                    <input type="text" name="city" id="city" value="<?= isset($user['city']) ? $user['city'] : '' ?>" required>
                </div>
                <div class="input-group">
                    <label for="gender">Giới tính:</label>
                    <select name="gender" id="gender">
                        <option value="Nam" <?= $user['gender'] == 'Nam' ? 'selected' : '' ?>>Nam</option>
                        <option value="Nữ" <?= $user['gender'] == 'Nữ' ? 'selected' : '' ?>>Nữ</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="dob">Ngày sinh:</label>
                    <input type="date" name="dob" id="dob" value="<?= $user['dob'] ?>">
                </div>
                <button type="submit">Cập nhật</button>
        </div>
    </div>
</form>
<?php include 'layout/footer.php'; ?>
</body>
</html>
