<?php
if (isset($_GET['id_penjual'])) {
    $id_per_penjual = (int) $_GET['id_penjual'];
}

if (isset($_GET['id_menu'])) {
    $id_per_menu = (int) $_GET['id_menu'];
}

include "../../database/koneksi.php";
include "../../database/model.php";

require_once '../../middleware/role_auth.php';

require_role('penjual');
?>

<?php

$ambil_data = mysqli_query($koneksi,"
SELECT nama_menu AS menu, harga FROM menu WHERE id_menu = '$id_per_menu'
");

$data = mysqli_fetch_assoc($ambil_data);

?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <title>Edit Menu - CampusEats!</title>
</head>
<body class="min-h-screen flex flex-col">
  <?php include '../../partials/navbar-penjual.php'; ?>

  <main class="w-[90%] mx-auto mt-6 max-w-xl">
    <h2 class="text-2xl font-bold mb-4 text-center">Edit Menu</h2>

    <form action="proses_edit_menu.php" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded-lg shadow border">
      <input type="hidden" name="id_menu" value="<?= $id_per_menu ?>" />
      <input type="hidden" name="id_penjual" value="<?= $id_per_penjual ?>" />

      <!-- Nama Menu -->
      <div>
        <label class="block font-semibold mb-1">Menu Name</label>
        <input type="text" name="nama" class="input input-bordered w-full" required value="<?= htmlspecialchars($data['menu']) ?>" />
      </div>

      <!-- Harga -->
      <div>
        <label class="block font-semibold mb-1">Price (Rp)</label>
        <input type="number" name="harga" class="input input-bordered w-full" required min="0" value="<?= htmlspecialchars($data['harga']) ?>" />
      </div>

      <!-- Gambar Lama & Upload Gambar Baru -->
      <div>
        <label class="block font-semibold mb-1">Change Picture</label>
        <input type="file" name="gambar" accept="image/*" class="file-input file-input-bordered w-full" />
      </div>

      <!-- Tombol Simpan -->
      <div class="flex justify-end">
        <button type="submit" class="btn bg-kuning text-white hover:bg-yellow-600">Save Changes</button>
      </div>
    </form>
  </main>
</body>
</html>