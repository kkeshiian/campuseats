<!DOCTYPE html>
<html data-theme="light" class="bg-background">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/campuseats/dist/output.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  </head>
  <body class="min-h-screen flex flex-col">
    <?php 
    $activePage = 'history';
    include '../../partials/navbar.php'; 
    ?>

    <h2 class="text-2xl font-bold mx-auto m-4">Riwayat Pembelian</h2>

    <div class="w-[90%] mx-auto">
      <!-- Sedang Diproses -->
      <h3 class="text-xl font-semibold mb-2">Sedang Diproses</h3>
      <div class="grid grid-cols-1 gap-4 mb-6">
        <?php
        $diproses = [
          [
            "kantin" => "Kantin Bu Rina",
            "menus" => [
              ["nama" => "Nasi Goreng Spesial", "jumlah" => 1],
              ["nama" => "Es Teh", "jumlah" => 2],
            ],
            "total" => 21000,
            "status" => "Sedang Dimasak"
          ],
          [
            "kantin" => "Kantin Pak Darto",
            "menus" => [
              ["nama" => "Ayam Bakar", "jumlah" => 2],
              ["nama" => "Jus Alpukat", "jumlah" => 1],
            ],
            "total" => 45000,
            "status" => "Menunggu Konfirmasi"
          ]
        ];

        foreach ($diproses as $order) {
          echo '<div class="bg-white shadow-md rounded-lg p-4 border border-black">';
          echo '<div class="flex justify-between">';
          echo '<div>';
          echo '<h4 class="text-lg font-bold mb-1">' . $order["kantin"] . '</h4>';
          foreach ($order["menus"] as $menu) {
            echo '<p class="text-sm">• ' . $menu["nama"] . ' (x' . $menu["jumlah"] . ')</p>';
          }
          echo '<p class="text-sm mt-1 font-semibold">Total: Rp ' . number_format($order["total"]) . '</p>';
          echo '</div>';
          echo '<div class="text-right">';
          echo '<span class="badge badge-warning text-white">' . $order["status"] . '</span>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
        ?>
      </div>

      <!-- Sudah Selesai -->
      <h3 class="text-xl font-semibold mb-2">Selesai</h3>
      <div class="grid grid-cols-1 gap-4 mb-10">
        <?php
        $selesai = [
          [
            "kantin" => "Kantin Bu Rina",
            "menus" => [
              ["nama" => "Mie Ayam", "jumlah" => 1],
              ["nama" => "Es Jeruk", "jumlah" => 1],
            ],
            "total" => 17000,
            "status" => "Selesai"
          ],
          [
            "kantin" => "Kantin Pak Darto",
            "menus" => [
              ["nama" => "Sate Ayam", "jumlah" => 2],
            ],
            "total" => 30000,
            "status" => "Selesai"
          ]
        ];

        foreach ($selesai as $order) {
          echo '<div class="bg-white shadow-md rounded-lg p-4 border border-black">';
          echo '<div class="flex justify-between">';
          echo '<div>';
          echo '<h4 class="text-lg font-bold mb-1">' . $order["kantin"] . '</h4>';
          foreach ($order["menus"] as $menu) {
            echo '<p class="text-sm">• ' . $menu["nama"] . ' (x' . $menu["jumlah"] . ')</p>';
          }
          echo '<p class="text-sm mt-1 font-semibold">Total: Rp ' . number_format($order["total"]) . '</p>';
          echo '</div>';
          echo '<div class="text-right">';
          echo '<span class="badge badge-success text-white">' . $order["status"] . '</span>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
        ?>
      </div>
    </div>
  </body>
</html>
