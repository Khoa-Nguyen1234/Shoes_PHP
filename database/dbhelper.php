<?php
require_once('config.php');
function execute($sql, $params = [])
{
    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    $stmt = $con->prepare($sql);
    if ($params) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $stmt->close();
    mysqli_close($con);
}
function executeResult($sql, $params = [])
{
    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    $stmt = $con->prepare($sql);
    if ($params) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];
    while ($row = mysqli_fetch_array($result, 1)) {
        $data[] = $row;
    }
    $stmt->close();
    mysqli_close($con);
    return $data;
}
function executeSingleResult($sql, $params = [])
{
    $results = executeResult($sql, $params);
    return $results ? $results[0] : null;
}

function getDBConnection() {
    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    if (mysqli_connect_errno()) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    return $con;
}
