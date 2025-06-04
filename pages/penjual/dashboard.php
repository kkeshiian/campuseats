<?php
require_once '../../middleware/role_auth.php';

require_role('penjual');
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

      <!-- Statistik -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white border border-black rounded-lg p-4 text-center">
          <h3 class="text-lg font-semibold">Kantin Pak Jangkung</h3>
          <p class="text-xl font-bold text-kuning">Fakultas Teknik</p>
        </div>
        <div class="bg-white border border-black rounded-lg p-4 text-center">
          <h3 class="text-lg font-semibold">Today's income</h3>
          <p class="text-xl font-bold text-kuning">Rp 125.000</p>
        </div>
        <div class="bg-white border border-black rounded-lg p-4 text-center">
          <h3 class="text-lg font-semibold">Today's orders</h3>
          <p class="text-xl font-bold text-kuning">8 Orders</p>
        </div>
      </div>

      <!-- List Pesanan Masuk -->
      <div class="mb-8">
        <h3 class="text-xl font-semibold mb-2">Incoming orders</h3>
        <div class="space-y-4">
          <?php
          $pesanan = [
            ["id" => 1, "nama" => "Nasi Goreng", "jumlah" => 2, "total" => 30000, "status" => "Menunggu"],
            ["id" => 2, "nama" => "Mie Ayam", "jumlah" => 1, "total" => 12000, "status" => "Sedang Dimasak"],
          ];
          foreach ($pesanan as $p) {
            echo '  
            <div class="bg-white border border-black rounded-lg p-4 flex justify-between items-center">
              <div>
                <p class="font-bold text-xl mb-1">'.$p["nama"].'</p>
                <p class="text-sm text-gray-500">Quantity: '.$p["jumlah"].'</p>
                <p class="text-sm text-gray-500">Total: Rp '.number_format($p["total"]).'</p>
              </div>
              <form method="post" action="update_status.php">
                <input type="hidden" name="id" value="'.$p["id"].'">
                <fieldset class="fieldset w-36 md:w-64">
                    <legend class="fieldset-legend">Order Status</legend>
                    <select name="status" class="select">
                        <option disabled selected>Waiting</option>
                        <option>Being Cooked</option>
                        <option>Ready for Pickup</option>
                    </select>
                    <button type="submit" class="btn btn-sm bg-kuning w-full text-white rounded-lg">Update</button>
                </fieldset>
              </form>
            </div>';
          }
          ?>
        </div>
      </div>
    </main>
  </body>
</html>