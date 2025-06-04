<?php
require_once '../../middleware/role_auth.php';
require_role('pembeli');
?>

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
  include '../../partials/navbar-pembeli.php'; 
  ?>

  <h2 class="text-2xl font-bold mx-auto m-4">Riwayat Pembelian</h2>

  <div class="w-[90%] mx-auto mb-10">
    <?php
    // Data dummy gabungan
    $riwayat = [
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
      ],
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
    ?>

    <div class="overflow-x-auto bg-white">
      <table class="table w-full">
        <thead class="bg-kuning text-white">
          <tr>
            <th>No</th>
            <th>Kantin</th>
            <th>Menu</th>
            <th>Total</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($riwayat as $order) {
            $badgeClass = match ($order["status"]) {
              'Selesai' => 'badge-success',
              'Sedang Dimasak' => 'badge-warning',
              'Menunggu Konfirmasi' => 'badge-info',
              default => 'badge-ghost',
            };
            echo '<tr>';
            echo '<td>' . $no++ . '</td>';
            echo '<td>' . htmlspecialchars($order["kantin"]) . '</td>';
            echo '<td>';
            foreach ($order["menus"] as $menu) {
              echo '• ' . $menu["nama"] . ' (x' . $menu["jumlah"] . ')<br>';
            }
            echo '</td>';
            echo '<td>Rp ' . number_format($order["total"], 0, ',', '.') . '</td>';
            echo '<td><span class="badge ' . $badgeClass . ' text-white">' . $order["status"] . '</span></td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
