<?php
session_start();
require_once('../database/config.php');
require_once('../database/dbhelper.php');
$message = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $password = $_POST["password"];
    $password_new = $_POST["password-new"];
    $password_renew = $_POST["repassword-new"];
    if ($password_new !== $password_renew) {
        $message = "Nhập không trùng mật khẩu, vui lòng nhập lại!";
    } else {
        $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
        if (isset($_COOKIE['email'])) {
            $email = $_COOKIE['email'];
            $stmt = $conn->prepare("SELECT password FROM user WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $hashed_new_password = password_hash($password_new, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE user SET password = ? WHERE email = ?");
                $stmt->bind_param("ss", $hashed_new_password, $email);
                $stmt->execute();          
                setcookie("password", $hashed_new_password, time() + 30 * 24 * 60 * 60, '/');              
                $message = "Đổi mật khẩu thành công!";
            } else {
                $message = "Mật khẩu hiện tại không chính xác!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - SHOESHOP</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="background"></div>
    <div class="container">
        <div class="content">
            <h2 class="logo"><i class="bx bxl-firebase"></i>SHOESHOP</h2>
            <div class="text-sci">
                <h2>Xin chào<br> <span>Đến với cửa hàng của chúng tôi.</span></h2>
                <div class="social-icons">
                    <a href="#"><i class='bx bxl-facebook'></i></a>
                    <a href="#"><i class='bx bxl-instagram'></i></a>
                    <a href="#"><i class='bx bxl-tiktok'></i></a>
                </div>
            </div>
        </div>
        <div class="logreg-box">
            <div class="form-box login">
                <form action="changePass.php" method="post">
                    <h2>Đổi mật khẩu</h2>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-lock-alt'></i></span>
                        <input type="password" name="password" required placeholder="Mật khẩu hiện tại">
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-lock-alt'></i></span>
                        <input type="password" name="password-new" required placeholder="Mật khẩu mới">
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-lock-alt'></i></span>
                        <input type="password" name="repassword-new" required placeholder="Nhập lại mật khẩu mới">
                    </div>
                    <div class="remember-forgot">
                        <label><input type="checkbox">Tôi đồng ý với các điều khoản & điều kiện</label>
                    </div>
                    <button type="submit" class="btn">Đổi mật khẩu</button>
                </form>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <?php if ($message): ?>
        <script>
            alert('<?php echo $message; ?>');
        </script>
    <?php endif; ?>
</body>
</html>
