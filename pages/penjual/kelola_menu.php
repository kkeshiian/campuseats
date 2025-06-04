<?php
require_once '../../middleware/role_auth.php';

// Pastikan user sudah login dan role-nya penjual
require_role('penjual');
?>


<!DOCTYPE html>
<html data-theme="light" class="bg-background">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/campuseats/dist/output.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
    <title>Kelola Menu</title>
  </head>
  <body class="min-h-screen flex flex-col">
    <?php include '../../partials/navbar-penjual.php'; ?>

    <main class="w-[90%] mx-auto mt-6">
      <h2 class="text-2xl font-bold mb-4">Kelola Menu</h2>

      <!-- Tombol Tambah Menu -->
      <div class="mb-6">
        <a href="tambah-menu.php" class="btn bg-kuning text-white font-semibold rounded-lg px-4 py-2 hover:bg-yellow-600">
          + Tambah Menu
        </a>
      </div>

      <!-- Tabel Daftar Menu -->
      <div class="overflow-x-auto bg-white border">
        <table class="table w-full">
          <thead class="bg-kuning text-white">
            <tr>
              <th>No</th>
              <th>Nama Menu</th>
              <th>Harga</th>
              <th>Kategori</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $menu = [
              ["id" => 1, "nama" => "Nasi Goreng", "harga" => 15000, "kategori" => "Makanan"],
              ["id" => 2, "nama" => "Es Teh", "harga" => 5000, "kategori" => "Minuman"],
              ["id" => 3, "nama" => "Nasi Goreng", "harga" => 15000, "kategori" => "Makanan"],
              ["id" => 4, "nama" => "Es Teh", "harga" => 5000, "kategori" => "Minuman"],
              ["id" => 5, "nama" => "Nasi Goreng", "harga" => 15000, "kategori" => "Makanan"],
            ];
            $no = 1;
            foreach ($menu as $m) {
              echo '
              <tr>
                <td>'.$no++.'</td>
                <td>'.$m["nama"].'</td>
                <td>Rp '.number_format($m["harga"]).'</td>
                <td>'.$m["kategori"].'</td>
                <td>
                  <a href="edit-menu.php?id='.$m["id"].'" class="btn btn-sm bg-blue-500 text-white mr-2">Edit</a>
                  <a href="hapus-menu.php?id='.$m["id"].'" class="btn btn-sm bg-red-500 text-white" onclick="return confirm(\'Yakin ingin hapus menu ini?\')">Hapus</a>
                </td>
              </tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
    </main>
  </body>
</html>
