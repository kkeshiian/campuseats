<?php
if (isset($_GET['id_admin'])) {
    $id_admin = (int) $_GET['id_admin'];
}
require_once '../../middleware/role_auth.php';

require_role('Admin');

include "../../database/koneksi.php";
include "../../database/model.php";
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
    <h2 class="text-2xl font-bold mb-6">Dashboard Admin</h2>
    <?php
    $ambil_data_admin = mysqli_query($koneksi, 
    "SELECT * FROM admin WHERE id_admin='$id_admin'");
    $row_admin = mysqli_fetch_assoc($ambil_data_admin);


    $ambil_data_user = mysqli_query($koneksi, 
        "SELECT Role, COUNT(*) AS jumlah
        FROM user
        GROUP BY Role;");

    $role_counts = [
        'admin' => 0,
        'penjual' => 0,
        'pembeli' => 0
    ];

    while ($row = mysqli_fetch_assoc($ambil_data_user)) {
        $role = strtolower($row['Role']); // antisipasi huruf kapital
        $role_counts[$role] = $row['jumlah'];
    }


    ?>
    <!-- profile admin -->
    <div class="grid grid-cols-2 md:grid-cols-2 gap-2 mb-10">
      <div class="bg-white border border-black rounded-lg p-4 text-center shadow">
        <h2 class="mt-3 mb-5">Nama admin: <?= $row_admin['nama'] ?> </h2>
        <h2 class="mt-3 mb-10">Jabatan: <?= $row_admin['jabatan'] ?> </h2>
        <a href='profile_admin.php?id_admin=<?=$id_admin?>'>
          <button class="bg-yellow-500 text-white p-2 px-4 rounded hover:bg-yellow-600 transition">
            Edit Profile
          </button>
        </a>
      </div>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-2 md:grid-cols-2 gap-2 mb-2">
      <div class="bg-white border border-black rounded-lg p-4 text-center shadow">
        <h3 class="text-lg font-semibold">Total Pengguna Aktif</h3>
        <p class="text-2xl font-bold text-blue-600"><?= $role_counts['pembeli'] ?></p>
      </div>
      <div class="bg-white border border-black rounded-lg p-4 text-center shadow">
        <h3 class="text-lg font-semibold">Total Penjual Aktif</h3>
        <p class="text-2xl font-bold text-green-600"><?= $role_counts['penjual'] ?></p>
      </div>
    </div>

    <!-- Navigasi Kelola -->
     <?php

     ?>
    <div class="grid grid-cols-2 md:grid-cols-2 gap-2">
      <!-- kelola pengguna -->
      <a href='kelola_pengguna.php?id_admin=<?=$id_admin?>' class="bg-white border border-black rounded-lg p-4 text-center hover:bg-gray-100 transition">
        <h4 class="text-lg font-semibold mb-2">Manage CampusEats's User</h4>
        <p class="text-gray-600 text-sm">Look and delete Campuseats's User data.</p>
      </a>
      <!-- kelola kantin -->
      <a href="kelola_kantin.php?id_admin=<?=$id_admin?>" class="bg-white border border-black rounded-lg p-4 text-center hover:bg-gray-100 transition">
        <h4 class="text-lg font-semibold mb-2">Manage Campuseats's Canteen</h4>
        <p class="text-gray-600 text-sm">Add, edit, and delete Campuseats's Canteen data.</p>
      </a>
    </div>
  </main>
</body>
</html>
