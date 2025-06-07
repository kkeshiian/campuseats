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
    <h2 class="text-2xl font-bold mb-6">Profile Admin</h2>
    <?php
    $ambil_data_admin = mysqli_query($koneksi, 
    "SELECT * FROM admin WHERE id_admin='$id_admin'");
    $row_admin = mysqli_fetch_assoc($ambil_data_admin);
    ?>

    <!-- profile admin -->
    <form method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded-lg shadow border">
        <input type="hidden" name="id_admin" value="<?= $id_admin ?>" />  
        <!-- Admin Name -->
        <div>
          <label class="block font-semibold mb-1">Admin Name</label>
          <input type="text" name="nama" value="<?= htmlspecialchars($row_admin['nama']) ?>" class="input input-bordered w-full" required />
        </div>

        <!-- Jabatan -->
        <div>
          <label class="block font-semibold mb-1">Admin Role</label>
          <input type="text" name="jabatan" value="<?= htmlspecialchars($row_admin['jabatan']) ?>" class="input input-bordered w-full" required />
        </div>

        <!-- Button -->
         <div class="flex ">
            <!-- back button -->
            <div class="flex justify-end">
                <button type="button" onclick="window.location.href='dashboard.php?id_admin=<?= $id_admin ?>'" class="btn bg-kuning text-white hover:bg-yellow-600"><-- Back</button>
            </div>

            <!-- update button -->
            <div class="flex justify-end">
                <button type="submit" name="submit" class="btn bg-kuning text-white hover:bg-yellow-600">Save Changes</button>
            </div>
         </div>

      </form>
</body>
</html>
