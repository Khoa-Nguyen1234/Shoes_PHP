<?php
include '../../database/dbhelper.php';
$id = $_GET['id'];
if($id) {
    $sql = "DELETE FROM blogs WHERE id = $id";
    execute($sql);
}
header('Location: ../sidebar/blog.php');
?>
