<?php
if (isset($_GET['id_penjual'])) {
    $id_per_penjual = (int) $_GET['id_penjual'];
}

include "../../database/koneksi.php";
include "../../database/model.php";

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
    <title>Kelola Menu</title>
  </head>
  <body class="min-h-screen flex flex-col">
    <?php include '../../partials/navbar-penjual.php'; ?>

    <main class="w-[90%] mx-auto mt-6">
      <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold mb-4">Manage Menu</h2>
        <!-- Tombol Tambah Menu -->
        <div class="mb-6">
          <a href="tambah-menu.php?id_penjual=<?= $id_per_penjual ?>" class="btn bg-kuning text-white font-semibold rounded-lg px-4 py-2 hover:bg-yellow-600">
            + Add Menu
          </a>
        </div>
      </div>

      <!-- Tabel Daftar Menu -->
      <div class="overflow-x-auto bg-white border">
        <?php
        $ambil_data_menu = mysqli_query($koneksi, "SELECT id_menu, nama_menu AS menu, harga FROM menu WHERE id_penjual = '$id_per_penjual'");

        if (mysqli_num_rows($ambil_data_menu) == 0) {
          echo "<p class='text-xl mx-auto m-4 text-center'>Belum ada menu yang ditambahkan.</p>";
        } else {
          echo "
            <table class='table w-full'>
              <thead class='bg-kuning text-white'>
                <tr class='text-center'>
                  <th>No</th>
                  <th>Menu Name</th>
                  <th>Price</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
          ";

          $no = 1;
          while ($menu = mysqli_fetch_assoc($ambil_data_menu)) {
            $harga = number_format($menu['harga'], 0, ',', '.');
            echo "
              <tr class='text-center'>
                <td>$no</td>
                <td>{$menu['menu']}</td>
                <td>Rp $harga</td>
                <td class='text-center'>
                  <a href='edit-menu.php?id_menu={$menu['id_menu']}&id_penjual=$id_per_penjual' class='btn btn-sm bg-blue-500 text-white mr-2'>Edit</a>
                  <a href='hapus-menu.php?id_menu={$menu['id_menu']}&id_penjual=$id_per_penjual' class='btn btn-sm bg-red-500 text-white' onclick='return confirm(\"Are you sure you want to delete this menu item?\")'>Delete</a>
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

    </main>
  </body>
</html>
