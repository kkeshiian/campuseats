<?php

include "koneksi.php";

function registrasi($koneksi, $nama, $username, $password, $role) {
        mysqli_query($koneksi, "
            INSERT INTO user SET
            nama = '$nama',
            username = '$username',
            password = '$password',
            Role = '$role'       
        ");
}

function login($koneksi, $username, $password) {
    $username = mysqli_real_escape_string($koneksi, $username);
    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            return $user;
        }
    }

    return false;
}

?>
