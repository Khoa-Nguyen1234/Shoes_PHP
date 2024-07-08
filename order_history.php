<?php 
include 'layout/header.php'; 
require_once('./database/dbhelper.php'); // Ensure database helper is included

if (!isset($_COOKIE['email'])) {
    header("Location: login/login.php");
    exit();
}

$email = $_COOKIE['email'];
$user = executeSingleResult("SELECT id_user FROM user WHERE email = ?", [$email]);
if (!$user) {
    die('User not found!');
}
$id_user = $user['id_user'];
$page = 1;
$limit = 10; 
if (isset($_GET['page'])) {
    $page = (int) $_GET['page'];
}
$offset = ($page - 1) * $limit;
$orders = executeResult("SELECT * FROM orders WHERE id_user = ? ORDER BY order_date DESC LIMIT ? OFFSET ?", [$id_user, $limit, $offset]);
$totalOrders = executeSingleResult("SELECT COUNT(id) as total FROM orders WHERE id_user = ?", [$id_user]);
$totalPages = ceil($totalOrders['total'] / $limit);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel_order_id'])) {
    $cancel_order_id = $_POST['cancel_order_id'];
    
    execute("UPDATE orders SET status = 'đã hủy' WHERE id = ? AND id_user = ?", [$cancel_order_id, $id_user]);
    
    header("Location: order_history.php");
    exit();
}
?>

<div class="order-history-container">
    <h1>Lịch sử đơn hàng</h1>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Sản phẩm</th>
                <th>Giảm giá</th>
                <th>Tổng tiền</th>
                <th>Ngày đặt</th>
                <th>Trạng thái</th>
                <th>Hủy đơn hàng</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $stt = ($page - 1) * $limit + 1;
            foreach ($orders as $order) : ?>
                <tr>
                    <td><?= $stt++ ?></td>
                    <td><?= htmlspecialchars($order['product_name']) ?></td>
                    <td><?= htmlspecialchars($order['discount']) ?></td>
                    <td><?= htmlspecialchars($order['total_cost']) ?></td>
                    <td><?= htmlspecialchars($order['order_date']) ?></td>
                    <td><?= isset($order['status']) ? htmlspecialchars($order['status']) : 'chờ xác nhận' ?></td>
                    <td>
                        <?php if ($order['status'] != 'đã hủy' && $order['status'] != 'đã nhận') : ?>
                            <form action="order_history.php" method="post" style="display:inline;">
                                <input type="hidden" name="cancel_order_id" value="<?= $order['id'] ?>">
                                <input type="submit" value="Hủy đơn hàng">
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>
<?php include 'layout/footer.php'; ?>
