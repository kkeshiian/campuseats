<?php
if (isset($_GET['id_admin']) && ($_GET['id_pembeli'])) {
    $id_admin = (int) $_GET['id_admin'];
    $id_user = (int) $_GET['id_pembeli'];
}
require_once '../../middleware/role_auth.php';

require_role('Admin');

include "../../database/koneksi.php";
include "../../database/model.php";

if (isset($_POST['submit'])) {
    $id_admin = $_GET['id_admin'];
    $nama = $_POST['nama'];
    $password_admin = $_POST['password']; // dari input form

    $id_user = (int) $_GET['id_pembeli']; // user yang ingin diubah
    $username_user = $_POST['username'];
    $new_password = $_POST['new_password'];

    // Cek autentikasi admin
    $query_ambil_data_admin = "SELECT * FROM admin WHERE id_admin = '$id_admin'";
    $result_pertama = mysqli_query($koneksi, $query_ambil_data_admin);
    $id_user_admin = mysqli_fetch_assoc($result_pertama);


    $query = "SELECT * FROM user WHERE id_user = '{$id_user_admin['id_user']}'";
    $result = mysqli_query($koneksi, $query);
    $admin = mysqli_fetch_assoc($result);

    if ($admin && password_verify($password_admin, $admin['password'])) {
        // Password admin cocok, update password pengguna
        $update_result = updatePasswordPengguna($koneksi, $id_user, $username_user, $new_password);

        if ($update_result) {
            header("Location: kelola_pengguna.php?id_admin=$id_admin");
            exit;
        } else {
            $error_message = "Gagal memperbarui password pengguna.";
            echo"alert($error_message)";
        }
    } else {
        $error_message = "Autentikasi admin gagal. Nama atau password salah.";
    }
}



?>

<!-- admin/dashboard.php -->
<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <title>Authorzation Admin</title>
</head>
<body class="min-h-screen flex flex-col">
  <?php include '../../partials/navbar-admin.php'; ?>

  <main class="w-[90%] mx-auto mt-6">
    <h2 class="text-2xl font-bold mb-6">Change User Password by Admin</h2>
    <?php
    $ambil_data_admin = mysqli_query($koneksi, 
    "SELECT * FROM admin WHERE id_admin='$id_admin'");
    $row_admin = mysqli_fetch_assoc($ambil_data_admin);
    $row_admin_user = $row_admin['id_user'];

    $ambil_data_user = mysqli_query($koneksi, "
    SELECT username FROM user WHERE id_user = '$row_admin_user'
    ");
    $username = mysqli_fetch_assoc($ambil_data_user);

    ?>

    <!-- authentication profile admin -->
    <form method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow border">
        <h2 class="text-2xl font-bold mb-6">Authentication Admin</h2>
        <input type="hidden" name="id_admin" value="<?= $id_admin ?>" />  
        <!-- Admin Name -->
        <div>
          <label class="block font-semibold mb-1">Admin Name</label>
          <input type="text" name="nama" value="<?= htmlspecialchars($username['username']) ?>" class="input input-bordered w-full" required />
        </div>

        <!-- password -->
        <div>
          <label class="block font-semibold mb-1">Admin Password</label>
          <input type="password" name="password" value="" class="input input-bordered w-full" required />
        </div><hr><br>

        <h2 class="text-2xl font-bold mb-6">Authentication User</h2>
        <input type="hidden" name="id_user" value="<?= $id_user ?>" />  
        <!-- Admin Name -->
        <div>
          <label class="block font-semibold mb-1">Username User</label>
          <input type="text" name="username" value="" class="input input-bordered w-full" required />
        </div>

        <!-- password -->
        <div>
          <label class="block font-semibold mb-1">Change Password User</label>
          <input type="password" name="new_password" value="" class="input input-bordered w-full" required />
        </div>

        <!-- Button -->
         <div class="flex ">
            <!-- back button -->
            <div class="flex justify-end">
                <button type="button" onclick="window.location.href='kelola_pengguna.php?id_admin=<?= $id_admin ?>'" class="btn bg-kuning text-white hover:bg-yellow-600"><--Back</button>
            </div>

            <!-- update button -->
            <div class="flex justify-end">
                <button type="submit" name="submit" class="btn bg-kuning text-white hover:bg-yellow-600">Save Changes</button>
            </div>
         </div>

      </form>
</body>
</html>
