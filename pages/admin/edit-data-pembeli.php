<?php
if (isset($_GET['id_admin']) && isset($_GET['id_pembeli'])) {
    $id_admin = (int) $_GET['id_admin'];
    $id_user = (int) $_GET['id_pembeli'];
}
require_once '../../middleware/role_auth.php';

require_role('Admin');

include "../../database/koneksi.php";
include "../../database/model.php";

$error_message = '';

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
        }
    } else {
        $error_message = "Autentikasi admin gagal. Nama atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <title>Authorization Admin</title>
</head>
<body class="min-h-screen flex flex-col">
  <?php include '../../partials/navbar-admin.php'; ?>

  <main class="mx-auto mt-6 px-4 w-full max-w-screen-xl">
    <h2 class="text-2xl font-bold mb-6 ml-6">Change User Password by Admin</h2>

    <?php if ($error_message): ?>
      <div class="alert alert-error mb-6">
        <?= htmlspecialchars($error_message) ?>
      </div>
    <?php endif; ?>

    <?php
      $ambil_data_admin = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin='$id_admin'");
      $row_admin = mysqli_fetch_assoc($ambil_data_admin);
      $row_admin_user = $row_admin['id_user'];

      $ambil_data_user = mysqli_query($koneksi, "SELECT username FROM user WHERE id_user = '$row_admin_user'");
      $username = mysqli_fetch_assoc($ambil_data_user);
    ?>

    
    <form method="POST" class="bg-white p-6 rounded-lg shadow border w-full mx-auto px-6" style="max-width: 1200px;">
      <div class="flex flex-wrap gap-6">
        <!-- Authentication Admin -->
        <div class="flex-1 min-w-[300px] space-y-6">
          <h3 class="text-xl font-semibold border-b pb-2 mb-4">Authentication Admin</h3>
          <input type="hidden" name="id_admin" value="<?= $id_admin ?>" />
          <div>
            <label class="block font-semibold mb-1" for="nama">Admin Name</label>
            <input id="nama" type="text" name="nama" value="<?= htmlspecialchars($username['username']) ?>" class="input input-bordered w-full" required />
          </div>
          <div>
            <label class="block font-semibold mb-1" for="password">Admin Password</label>
            <input id="password" type="password" name="password" class="input input-bordered w-full" required />
          </div>
        </div>

        <!-- Authentication User -->
        <div class="flex-1 min-w-[300px] space-y-6">
          <h3 class="text-xl font-semibold border-b pb-2 mb-4">Authentication User</h3>
          <input type="hidden" name="id_user" value="<?= $id_user ?>" />
          <div>
            <label class="block font-semibold mb-1" for="username">Username User</label>
            <input id="username" type="text" name="username" class="input input-bordered w-full" required />
          </div>
          <div>
            <label class="block font-semibold mb-1" for="new_password">Change Password User</label>
            <input id="new_password" type="password" name="new_password" class="input input-bordered w-full" required />
          </div>
        </div>
      </div>

      <div class="flex justify-end mt-6">
        <button type="submit" name="submit" class="btn bg-kuning text-white hover:bg-kuning rounded-lg">Save Changes</button>
      </div>
    </form>
  </main>
</body>
</html>
