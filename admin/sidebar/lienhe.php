<?php
require_once('../../database/dbhelper.php');
$contacts = executeResult("SELECT * FROM lien_he");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách liên hệ</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="main.js"></script>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="main-content">
    <header>
        <h1>
            Danh sách liên hệ
        </h1>
        <div class="search-wrapper">
            <span class="las la-search"></span>
            <input type="search" placeholder="Search contact..." />
        </div>
        <div class="user-wrapper">
            <div>
                <h4>Admin</h4>
            </div>
        </div>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Nội dung</th>
                    <th>Ngày gửi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $contact) : ?>
                    <tr>
                        <td><?= $contact['id'] ?></td>
                        <td><?= $contact['hoten'] ?></td>
                        <td><?= $contact['email'] ?></td>
                        <td><?= $contact['sdt'] ?></td>
                        <td><?= $contact['noidung'] ?></td>
                        <td><?= $contact['ngaygui'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</div>
</body>
</html>
