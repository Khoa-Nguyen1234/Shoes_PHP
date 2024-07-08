<?php
session_start();
require_once('../database/config.php');
require_once('../database/dbhelper.php');
$previous_page = $_SERVER['HTTP_REFERER'] ?? '../index.php';

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $stmt = $con->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        setcookie("name", $user['name'], time() + 30 * 24 * 60 * 60, '/');
        setcookie("email", $email, time() + 30 * 24 * 60 * 60, '/');

        if ($user['role'] === 'admin' || $user['role'] === 'employee') {
            echo '<script language="javascript">
                alert("Đăng nhập thành công!"); 
                window.location = "../admin/sidebar/dashboard.php";
            </script>';
        } else {
            echo '<script language="javascript">
                alert("Đăng nhập thành công!"); 
                window.location = "../index.php";
            </script>';
        }
    } else {
        echo '<script language="javascript">
            alert("Tài khoản và mật khẩu không chính xác !");
            window.location = "login.php";
        </script>';
    }

    $stmt->close();
    $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - SHOESHOP</title>
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
            <div class="form-box login">
                <form action="login.php" method="post">
                    <h2>Đăng nhập</h2>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-envelope' ></i></span>
                        <input type="email" name="email" required>
                        <label>Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-lock-alt' ></i></span>
                        <input type="password" name="password" required>
                        <label>Mật khẩu</label>
                    </div>
                    <div class="remember-forgot">
                        <label><input type="checkbox">Ghi nhớ</label>
                        <a href="">Quên mật khẩu?</a>
                    </div>
                    <button type="submit" class="btn">Đăng nhập</button>
                    <div class="login-register">
                        <p>Bạn chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
