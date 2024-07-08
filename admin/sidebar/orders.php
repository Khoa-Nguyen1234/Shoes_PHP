<?php 
include '../../database/dbhelper.php';
$conn = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status']) && isset($_POST['order_id'])) {
    $status = $_POST['status'];
    $order_id = $_POST['order_id'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    if ($stmt === false) {
        die("Failed to prepare SQL statement: " . $conn->error);
    }
    $stmt->bind_param("ss", $status, $order_id);
    $stmt->execute();
    $stmt->close();
    mysqli_close($conn);
    header('Location: orders.php');
    exit();
}

$orders = executeResult("SELECT * FROM orders ORDER BY order_date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="main.js"></script>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="main-content">
    <header>
        <h1>Đơn hàng</h1>
        <div class="search-wrapper">
            <span class="las la-search"></span>
            <input type="search" placeholder="Search orders..." />
        </div>
        <div class="user-wrapper">
            <div><h4>Admin</h4></div>
        </div>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên khách hàng</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng sản phẩm</th>
                    <th>Giảm giá</th>
                    <th>Tổng tiền</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td><?= htmlspecialchars($order['id']) ?></td>
                        <td><?= htmlspecialchars($order['user_fullname']) ?></td>
                        <td><?= htmlspecialchars($order['user_email']) ?></td>
                        <td><?= htmlspecialchars($order['user_phone']) ?></td>
                        <td><?= htmlspecialchars($order['user_address']) ?></td>
                        <td><?= htmlspecialchars($order['product_name']) ?></td>
                        <td><?= htmlspecialchars($order['product_quantity']) ?></td>
                        <td><?= number_format($order['discount'], 0, ',', '.') ?></td>
                        <td><?= number_format($order['total_cost'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($order['order_date']) ?></td>
                        <td>
                            <form action="./orders.php" method="post">
                                <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id']) ?>">
                                <select name="status">
                                    <option value="chờ xác nhận" <?= (isset($order['status']) && $order['status'] == 'chờ xác nhận') ? 'selected' : '' ?>>chờ xác nhận</option>
                                    <option value="đã xác nhận" <?= (isset($order['status']) && $order['status'] == 'đã xác nhận') ? 'selected' : '' ?>>đã xác nhận</option>
                                    <option value="đang giao" <?= (isset($order['status']) && $order['status'] == 'đang giao') ? 'selected' : '' ?>>đang giao</option>
                                    <option value="đã nhận" <?= (isset($order['status']) && $order['status'] == 'đã nhận') ? 'selected' : '' ?>>đã nhận</option>
                                    <option value="đã hủy" <?= (isset($order['status']) && $order['status'] == 'đã hủy') ? 'selected' : '' ?>>đã hủy</option>
                                </select>
                                <input type="submit" value="Cập nhật">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</div>
</body>
</html>
