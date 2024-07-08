<?php
session_start();
require_once('../database/config.php');
require_once('../database/dbhelper.php');
$message = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['name'], $_POST['email'], $_POST['password'], $_POST['repassword'], $_POST['numberphone'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repassword = $_POST['repassword'];
        $numberphone = $_POST['numberphone'];
        if ($password !== $repassword) {
            $message = "Nhập không trùng mật khẩu, vui lòng đăng ký lại!";
        } else {
            $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
            $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $message = "Email đã được sử dụng!";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO user (name, email, password, numberphone) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $name, $email, $hashed_password, $numberphone);
                $stmt->execute();
                $message = "Bạn đăng ký thành công!";
            }
        }
    } else {
        $message = "Hãy nhập đủ thông tin!";
    }
    echo '<script language="javascript">
            alert("'.$message.'");
          </script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - SHOESHOP</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>  
    <div class="background"></div>
    <div class="container">
        <div class="content">
            <h2 class="logo">SHOESHOP</h2>
            <div class="text-sci">
                <h2>Xin chào<br> <span>Đến với cửa hàng của chúng tôi.</span></h2>
                <div class="social-icons">
                    <a href="#"><i class='bx bxl-facebook'></i></a>
                    <a href="#"><i class='bx bxl-instagram' ></i></a>
                    <a href="#"><i class='bx bxl-tiktok' ></i></a>
                </div>
            </div>
        </div>
        <div class="logreg-box">
            <div class="form-box register">
                <form action="register.php" method="post">
                    <h2>Đăng ký</h2>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-user'></i></span>
                        <input type="text" name="name" required>
                        <label>Họ và tên</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-envelope'></i></span>
                        <input type="email" name="email" required>
                        <label>Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-lock-alt'></i></span>
                        <input type="password" name="password" required>
                        <label>Mật khẩu</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-lock-alt'></i></span>
                        <input type="password" name="repassword" required>
                        <label>Nhập lại mật khẩu</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-phone'></i></span>
                        <input type="text" name="numberphone" required>
                        <label>Số điện thoại</label>
                    </div>
                    <div class="remember-forgot">
                        <label><input type="checkbox">Tôi đồng ý với các điều khoản & điều kiện</label>
                    </div>
                    <button type="submit" class="btn">Đăng ký</button>
                    <div class="login-register">
                        <p>Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
