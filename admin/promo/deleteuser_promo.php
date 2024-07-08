<?php
require_once('../../database/dbhelper.php');
$promo_id = isset($_GET['id']) ? $_GET['id'] : '';
if ($promo_id) {
    $sql = "DELETE FROM user_promo_codes WHERE promo_id = ?";
    execute($sql, [$promo_id]);
    header('Location: ../sidebar/promo.php');
    die();
}
