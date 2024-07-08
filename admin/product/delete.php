<?php
include '../../database/dbhelper.php';
$id = $_GET['id'];
if($id) {
    $sql = "DELETE FROM product WHERE id = $id";
    execute($sql);
}
header('Location: ../sidebar/product.php');
?>
