<?php
session_start();
require_once('database/config.php');
require_once('database/dbhelper.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hoten = $_POST['hoten'] ?? '';
    $email = $_POST['email'] ?? '';
    $sdt = $_POST['sdt'] ?? '';
    $noidung = $_POST['noidung'] ?? '';

    if (!empty($hoten) && !empty($email) && !empty($sdt) && !empty($noidung)) {
        $con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $stmt = $con->prepare("INSERT INTO lien_he (hoten, email, sdt, noidung) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $hoten, $email, $sdt, $noidung);

        if ($stmt->execute()) {
            echo '<script language="javascript">
                alert("Liên hệ của bạn đã được gửi thành công!");
                window.location = "index.php";
            </script>';
        } else {
            echo '<script language="javascript">
                alert("Đã xảy ra lỗi khi gửi liên hệ. Vui lòng thử lại sau.");
                window.location = "index.php";
            </script>';
        }
        $stmt->close();
        $con->close();
    } else {
        echo '<script language="javascript">
            alert("Vui lòng điền đầy đủ thông tin.");
            window.location = "index.php";
        </script>';
    }
}
?>
<?php include 'layout/header.php'; ?>
<!-- lienhe section start -->
<div class="lienhe" id="lienhe">
    <div class="heading">
        <h1>Liên hệ đến<span> shoeshop</span></h1>
    </div>
    <form action="" method="POST">
        <div class="khung50">
            <input type="text" name="hoten" id="hoten" placeholder="Họ tên của bạn"/>
            <input type="text" name="email" id="email" placeholder="Email"/>
            <input type="text" name="sdt" id="sdt" placeholder="Số điện thoại" />
            <textarea name="noidung" id="noidung" cols="30" rows="7" placeholder="nội dung"></textarea>
        </div>
        <div>
            <button type="submit">Gửi</button>
        </div>
    </form>
</div>
<!-- lienhe section end -->
<?php include 'layout/footer.php'; ?>
