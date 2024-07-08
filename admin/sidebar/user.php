<?php
include '../../database/dbhelper.php';
$users = executeResult("SELECT * FROM user");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
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
                Tài Khoản
            </h1>
            <div class="search-wrapper">
                <span class="las la-search"></span>
                <input type="search" placeholder="Search users..." />
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
                    <th>Stt</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Giới tính</th>
                    <th>Ngày sinh</th>
                    <th>Quyền</th>
                    <th>Phân Quyền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= $user['id_user'] ?></td>
                            <td><?= $user['name'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['numberphone'] ?></td>
                            <td><?= $user['gender'] ?></td>
                            <td>
                                <?php 
                                    $date = DateTime::createFromFormat('Y-m-d', $user['dob']);
                                    echo $date ? $date->format('d/m/Y') : $user['dob'];
                                ?>
                            </td>
                            <td><?= $user['role'] ?></td>
                            <td>
                                <form action="../user/change_role.php" method="post" style="display: inline;">
                                    <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
                                    <select name="role" required>
                                        <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="employee" <?= $user['role'] == 'employee' ? 'selected' : '' ?>>Employee</option>
                                        <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                                    </select>
                                    <button type="submit">Cập nhật</button>
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
