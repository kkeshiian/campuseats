<?php
if (isset($_GET['id_admin'])) {
    $id_admin = (int) $_GET['id_admin'];
}
require_once '../../middleware/role_auth.php';

require_role('Admin');

include "../../database/koneksi.php";
include "../../database/model.php";

if (isset($_POST['submit'])) {
    $id_admin = $_POST['id_admin'];
    $nama= $_POST['nama'];
    $jabatan=$_POST['jabatan'];

    $hasil = updateInfoAdmin($koneksi, $id_admin, $nama, $jabatan);
    header("Location: profile_admin.php?id_admin=$id_admin");
    exit;
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
  <title>Dashboard Admin</title>
</head>
<body class="min-h-screen flex flex-col">
  <?php include '../../partials/navbar-admin.php'; ?>

  <main class="w-[90%] mx-auto mt-6">
    <h2 class="text-2xl font-bold mb-2">Manage User</h2>
    <button type="button" onclick="window.location.href='dashboard.php?id_admin=<?= $id_admin ?>'" class="mb-4 btn bg-kuning text-white hover:bg-yellow-600"><-- Back</button>

    <?php
    $ambil_data_user = mysqli_query($koneksi, 
    "SELECT * FROM user WHERE Role='pembeli'");
    ?>
    <!-- daftar pengguna -->
    <div class="overflow-x-auto bg-white border">
        <?php
        if (mysqli_num_rows($ambil_data_user) == 0) {
          echo "<p class='text-xl mx-auto m-4 text-center'>Tidak ada data user yang ditemukan.</p>";
        } else {
          echo "
            <table class='table w-full text-center'>
              <thead class='bg-kuning text-white'>
                <tr class='text-center'>
                  <th>No</th>
                  <th>Full name</th>
                  <th>Username</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
          ";

          $no = 1;
          while ($row_user = mysqli_fetch_assoc($ambil_data_user)) {
            echo "
              <tr class='text-center'>
                <td>$no</td>
                <td>{$row_user['nama']}</td>
                <td>{$row_user['username']}</td>
                <td class='text-center p-3'>
                  <a href='hapus-pembeli.php?id_pembeli={$row_user['id_user']}&id_admin=$id_admin' class='btn btn-sm bg-red-500 text-white' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
                  <a href='edit-data-pembeli.php?id_pembeli={$row_user['id_user']}&id_admin=$id_admin' class='btn btn-sm bg-yellow-500 text-white' onclick='return confirm(\"Are you sure you want to change this user?\")'>Authorization</a>
                  </td>
              </tr>
            ";
            $no++;
          }

          echo "
              </tbody>
            </table>
          ";
        }
        ?>

    </div>


</body>
</html>
