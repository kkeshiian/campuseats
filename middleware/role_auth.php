<?php
session_start();

function require_login() {
    if (!isset($_SESSION['id_user'])) {
        header("Location: /campuseats/pages/auth/login.php");
        exit();
    }
}

function require_role($role) {
    require_login();

    if (!isset($_SESSION['Role']) || strtolower($_SESSION['Role']) !== strtolower($role)) {
        header("HTTP/1.1 403 Forbidden");
        echo "Access denied. You don't have permission to access this page.";
        exit();
    }

}
