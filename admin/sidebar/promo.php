<?php
include '../../database/dbhelper.php';
$promos = executeResult("SELECT * FROM promo_codes");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách mã giảm giá</title>
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
            Danh sách mã giảm giá
        </h1>
        <div class="search-wrapper">
            <span class="las la-search"></span>
            <input type="search" placeholder="Search promo..." />
        </div>
        <div class="user-wrapper">
            <div>
                <h4>Admin</h4>
            </div>
        </div>
    </header>
    <main>
        <div style="margin-bottom: 20px;">
            <a href="../promo/add_promo.php" class="btn btn-success">Thêm mã giảm giá</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mã giảm giá</th>
                    <th>Giảm giá</th>
                    <th>Kiểu giảm giá</th>
                    <th>Ngày hết hạn</th>
                    <th>Hạn mức tối thiểu</th>
                    <th>Gán cho người dùng</th>
                    <th>Hủy tất cả</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($promos as $promo) : ?>
                    <tr>
                        <td><?= $promo['id'] ?></td>
                        <td><?= $promo['code'] ?></td>
                        <td><?= intval($promo['discount_amount']) ?></td>
                        <td><?= 'Cố định' ?></td>
                        <td><?= date("d-m-Y", strtotime($promo['expiry_date'])) ?></td>
                        <td><?= number_format($promo['min_order_value'], 0, ',', '.') ?> VNĐ</td>
                        <td><a href="../promo/adduser_promo.php?id=<?= $promo['id'] ?>">Gán cho người dùng</a></td>
                        <td><a href="../promo/deleteuser_promo.php?id=<?= $promo['id'] ?>">Hủy gán</a></td>
                        <td><a href="../promo/edit_promo.php?id=<?= $promo['id'] ?>">Sửa</a></td>
                        <td><a href="../promo/delete_promo.php?id=<?= $promo['id'] ?>">Xóa</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</div>
</body>
</html>
