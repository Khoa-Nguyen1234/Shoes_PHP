<?php
require_once('../../database/dbhelper.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM promo_codes WHERE id = $id";
    execute($sql);
}
header('Location: ../sidebar/promo.php');
?>
