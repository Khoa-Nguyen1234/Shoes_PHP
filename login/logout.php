<?php
session_start();

$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

if (isset($_COOKIE['name']) || isset($_COOKIE['email']) || isset($_COOKIE['password'])) {
    setcookie("name", "", time() - 30 * 24 * 60 * 60, '/');
    setcookie("email", "", time() - 30 * 24 * 60 * 60, '/');
    setcookie("password", "", time() - 30 * 24 * 60 * 60, '/');
    header('Location: ../index.php');
    exit();
}
?>
