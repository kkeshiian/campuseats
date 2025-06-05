<?php
include "../../database/koneksi.php";
include "../../database/model.php";

if (isset($_GET['id_penjual'])) {
    $id_per_penjual = (int) $_GET['id_penjual'];
}
require_once '../../middleware/role_auth.php';

require_role('penjual');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $order_id = $_POST['id'];
    $status = $_POST['status'];
    $menu = $_POST['menu'];
    
    if (updateStatusPesanan($koneksi, $order_id, $status, $menu)) {
        header("Location: dashboard.php?id_penjual=" . $id_per_penjual);
        exit();
    }
}

  
?>




<!-- Halaman 1: Dashboard Utama -->
<!DOCTYPE html>
<html data-theme="light" class="bg-background">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/campuseats/dist/output.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
    <title>Dashboard Penjual</title>

  </head>
  <body class="min-h-screen flex flex-col">
    <?php include '../../partials/navbar-penjual.php'; ?>

    <main class="w-[90%] mx-auto mt-6">
      <h2 class="text-2xl font-bold mb-4">Seller Dashboard</h2>
      Date: <h4 id="tanggalHariIni" class="text-2xl font-bold mb-4"></h4>

      <!-- Statistik -->
      <?php
      date_default_timezone_set('Asia/Jakarta');
      $tanggal_hari_ini = date('Y-m-d');
      $ambil_data = mysqli_query($koneksi, "SELECT id_fakultas, nama_kantin FROM penjual WHERE id_penjual = '$id_per_penjual'");
      $ambil_data_nama_fakultas  = mysqli_query($koneksi, "SELECT nama_fakultas FROM fakultas JOIN penjual ON penjual.id_fakultas = fakultas.id_fakultas WHERE penjual.id_penjual = '$id_per_penjual'");
      $data = mysqli_fetch_assoc($ambil_data);
      $nama_kantin = $data['nama_kantin'];

      $data_fakultas = mysqli_fetch_assoc($ambil_data_nama_fakultas);
      $nama_fakultas = $data_fakultas['nama_fakultas'];

      $ambil_data_riwayat_pembelian = mysqli_query($koneksi,
    "SELECT quantity AS qty, total, status, menu, order_id, tanggal FROM riwayat_pembelian WHERE nama_kantin = '$nama_kantin'");
      $total_keseluruhan = 0;
      $total_orderan = 0;
      $daftar_pesanan_hari_ini = []; 


      while ($row = mysqli_fetch_assoc($ambil_data_riwayat_pembelian)) {
          $tanggal_order = date('Y-m-d', strtotime($row['tanggal']));

          if ($tanggal_order === $tanggal_hari_ini) {
              $total_keseluruhan += $row['total'];
              $total_orderan += $row['qty'];
              $daftar_pesanan_hari_ini[] = $row;
          }

      }
      ?>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white border border-black rounded-lg p-4 text-center">
          <h3 class="text-lg font-semibold"><?=$nama_kantin?></h3>
          <p class="text-xl font-bold text-kuning"><?=$nama_fakultas?></p>
        </div>
        <div class="bg-white border border-black rounded-lg p-4 text-center">
          <h3 class="text-lg font-semibold">Today's income</h3>
          <p class="text-xl font-bold text-kuning"><?=number_format($total_keseluruhan, 0, ',', '.')?></p>
        </div>
        <div class="bg-white border border-black rounded-lg p-4 text-center">
          <h3 class="text-lg font-semibold">Today's orders</h3>
          <p class="text-xl font-bold text-kuning"><?=$total_orderan?> Orders</p>
        </div>
      </div>

      <!-- List Pesanan Masuk -->
      <div class="mb-8">
        <h3 class="text-xl font-semibold mb-2">Incoming orders</h3>
        <div class="space-y-4">
        <?php foreach ($daftar_pesanan_hari_ini as $pesanan): ?>
          <div class="bg-white border border-black rounded-lg p-4 flex justify-between items-center">
            <div>
              <p class="font-bold text-xl mb-1"><?= $pesanan["menu"] ?></p>
              <p class="text-l mt-1 mb-1">Order ID: <?= $pesanan["order_id"] ?></p>
              <p class="text-sm text-gray-500">Quantity: <?= $pesanan["qty"] ?></p>
              <p class="text-sm text-gray-500">Total: Rp <?= number_format($pesanan["total"]) ?></p>
            </div>
            <form method="post">
              <input type="hidden" name="id" value="<?= $pesanan["order_id"] ?>">
              <input type="hidden" name="menu" value="<?= $pesanan["menu"] ?>">

              <fieldset class="fieldset w-36 md:w-64">
                <legend class="fieldset-legend">Order Status</legend>
                <select name="status" id="status" required
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2 
                        focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                        dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                  <option value="">-- Pilih Status Pesanan --</option>
                  <?php
                  $statuses = ["menunggu" => "Menunggu", "diproses" => "Diproses", "siap" => "Siap diambil", "selesai" => "Selesai"];
                  foreach ($statuses as $value => $label) {
                      $selected = ($pesanan["status"] == $value) ? "selected" : "";
                      echo "<option value='$value' $selected>$label</option>";
                  }
                  ?>
                </select>
              </fieldset>
              <button type="submit" name="submit" class="btn btn-sm bg-kuning w-full text-white rounded-lg">Update</button>
            </form>
          </div>
        <?php endforeach; ?>

        </div>
      </div>
    </main>
  </body>
  <script>
    const hariIni = new Date();
    const opsiFormat = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
    const tanggalFormatted = hariIni.toLocaleDateString('id-ID', opsiFormat);

    document.getElementById("tanggalHariIni").textContent = tanggalFormatted;
  </script>
</html>