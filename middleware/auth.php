<?php
session_start();

$allowedPaths = [
    '/campuseats/index.php',
    '/campuseats/pages/auth/login.php',
    '/campuseats/pages/auth/register.php'
];

$currentPath = $_SERVER['PHP_SELF'];

if (!isset($_SESSION['id_user']) && !in_array($currentPath, $allowedPaths)) {
    header("Location: /campuseats/pages/auth/login.php");
    exit();
}

function require_login() {
    if (!isset($_SESSION['id_user'])) {
        header("Location: /campuseats/pages/auth/login.php");
        exit();
    }
}
?>
