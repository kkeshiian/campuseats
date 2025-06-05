<?php
if (isset($_GET['id_penjual'])) {
    $id_per_penjual = (int) $_GET['id_penjual'];
}
require_once '../../middleware/role_auth.php';

require_role('penjual');
?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/campuseats/dist/output.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
    <title>CampusEats!</title>
  </head>
  <body class="min-h-screen flex flex-col">
    <?php include '../../partials/navbar-penjual.php'; ?>

    <main class="w-[90%] mx-auto mt-6 max-w-xl">
      <h2 class="text-2xl font-bold mb-4 text-center">Add New Menu</h2>

      <form action="proses_tambah_menu.php" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded-lg shadow border">
        <input type="hidden" name="id_penjual" value="<?= $id_per_penjual ?>" />
      <!-- Nama Menu -->
        <div>
          <label class="block font-semibold mb-1">Menu Name</label>
          <input type="text" name="nama" class="input input-bordered w-full" required />
        </div>

        <!-- Harga -->
        <div>
          <label class="block font-semibold mb-1">Price (Rp)</label>
          <input type="number" name="harga" class="input input-bordered w-full" required min="0" />
        </div>

        <!-- Upload Gambar -->
        <div>
          <label class="block font-semibold mb-1">Menu Picture</label>
          <input type="file" name="gambar" accept="image/*" class="file-input file-input-bordered w-full" required />
        </div>

        <!-- Tombol Simpan -->
        <div class="flex justify-end">
          <button type="submit" name="submit" class="btn bg-kuning text-white hover:bg-yellow-600">Add Menu</button>
        </div>
      </form>
    </main>
  </body>
</html>
