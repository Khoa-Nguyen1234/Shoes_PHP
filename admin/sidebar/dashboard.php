<?php
include '../../database/dbhelper.php';

$users = executeResult("SELECT * FROM user");
$products = executeResult("SELECT * FROM product");
$orders = executeResult("SELECT * FROM orders WHERE status = 'đã nhận'"); 
$totalUsers = count($users);
$totalProducts = count($products);
$totalOrders = count($orders);

$revenueResult = executeResult("SELECT SUM(total_cost) as totalRevenue FROM orders WHERE status = 'đã nhận'"); 
$totalRevenue = $revenueResult[0]['totalRevenue'];

$currentYear = date("Y");
$monthlyRevenueData = [];
for ($month = 1; $month <= 12; $month++) {
    $result = executeResult("SELECT SUM(total_cost) as monthlyRevenue FROM orders WHERE YEAR(order_date) = $currentYear AND MONTH(order_date) = $month AND status = 'đã nhận'"); // Only include received orders
    $monthlyRevenue = isset($result[0]['monthlyRevenue']) ? $result[0]['monthlyRevenue'] : 0;
    $monthlyRevenueData[] = $monthlyRevenue;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page admin</title>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="main.js"></script>
</head>
<body>
<?php include 'sidebar.php'; ?>
    <div class="main-content">
        <header>
            <h1>
                <label for="">
                    <span class="las la-bars"></span>
                </label>
                Trang chủ
            </h1>
            <div class="search-wrapper"> 
                <span class="las la-search"></span>
                <input type="search" placeholder="Search here" />
            </div>
            <div class="user-wrapper">
                <div>
                    <h4>Admin</h4>
                </div>
            </div>
        </header>
        <main>
            <div class="cards">
                <div class="card-single">
                    <div>
                        <h1><?= $totalUsers ?></h1>
                        <span>Tài khoản</span>
                    </div>
                    <div>
                        <span class="las la-users"></span>
                    </div>
                </div>
                <div class="card-single">
                    <div>
                        <h1><?= $totalProducts ?></h1>
                        <span>Sản phẩm</span>
                    </div>
                    <div>
                        <span class="las la-clipboard"></span>
                    </div>
                </div>
                <div class="card-single">
                    <div>
                        <h1><?= $totalOrders ?></h1>
                        <span>Đơn hàng</span>
                    </div>
                    <div>
                        <span class="las la-shopping-bag"></span>
                    </div>
                </div>
                <div class="card-single">
                    <div>
                        <h1><?= number_format($totalRevenue) ?> Đ</h1>
                        <span>Tổng doanh thu</span>
                    </div>
                    <div>
                        <span class=""></span>
                    </div>
                </div>
            </div>
            <div class="chart-container" style="position: relative; height:50vh; width:70vw">
                <canvas id="revenueChart"></canvas>
            </div>
        </main>
    </div>
    <script>
        let ctx = document.getElementById('revenueChart').getContext('2d');
        let revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                datasets: [{
                    label: 'Doanh thu theo tháng',
                    data: <?php echo json_encode($monthlyRevenueData) ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        callback: function(value, index, values) {
                            return value + ' Đ';
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
