<?php
require_once('../../database/config.php');
require_once('../../database/dbhelper.php');

if (isset($_POST['id_user']) && isset($_POST['role'])) {
    $id_user = $_POST['id_user'];
    $role = $_POST['role'];
    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $stmt = $con->prepare("UPDATE user SET role = ? WHERE id_user = ?");
    $stmt->bind_param("si", $role, $id_user);
    $stmt->execute();
    $stmt->close();
    $con->close();

    echo '<script language="javascript">
        alert("Role updated successfully!");
        window.location = "../sidebar/user.php";
    </script>';
} else {
    echo '<script language="javascript">
        alert("Invalid request!");
        window.location = "../sidebar/user.php";
    </script>';
}
?>
