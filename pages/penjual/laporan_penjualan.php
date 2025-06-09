<?php
if (isset($_GET['id_penjual'])) {
    $id_per_penjual = (int) $_GET['id_penjual'];
}else{
  header("Location: /campuseats/pages/auth/logout.php");
  exit();
}
require_once '../../middleware/role_auth.php';

require_role('penjual');

include "../../database/koneksi.php";
include "../../database/model.php";
?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <title>Weekly Sales Report</title>
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

</head>
<body class="min-h-screen flex flex-col">

  <?php include '../../partials/navbar-penjual.php'; ?>

  <main class="w-[90%] mx-auto mt-6 flex-grow max-w-6xl">
    <h2 class="text-2xl font-bold mb-4" data-aos="fade-right" data-aos-duration="1000">Weekly Sales Report</h2>

    <!-- Summary -->
    <!-- Kode PHP -->
  <?php
  date_default_timezone_set('Asia/Jakarta');

  $tanggal_akhir = (new DateTime('now'))->format('d M Y');
  $tanggal_awal = date('d M Y', strtotime('-6 days'));

  // Ambil nama kantin
  $sql = "SELECT nama_kantin FROM penjual WHERE id_penjual = $id_per_penjual";
  $result = mysqli_query($koneksi, $sql);
  $row = mysqli_fetch_assoc($result);
  $nama_kantin_penjual = $row['nama_kantin'];

  // Total transaksi 7 hari terakhir
  $query = "SELECT SUM(quantity) AS qty, SUM(total) AS total 
            FROM riwayat_pembelian 
            WHERE nama_kantin = '$nama_kantin_penjual' 
            AND tanggal >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) 
            AND status = 'Done'";
  $ambil_data = mysqli_query($koneksi, $query);
  $data = mysqli_fetch_assoc($ambil_data);

  // Best day berdasarkan total
  $best_day_query = "SELECT DAYNAME(tanggal) AS hari, SUM(total) AS total_hari 
                    FROM riwayat_pembelian 
                    WHERE nama_kantin = '$nama_kantin_penjual' 
                    AND tanggal >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
                    AND status = 'Done'
                    GROUP BY hari 
                    ORDER BY total_hari DESC 
                    LIMIT 1";
  $best_day_result = mysqli_query($koneksi, $best_day_query);
  $best_day = mysqli_fetch_assoc($best_day_result);

  // ==== BAGIAN UNTUK CHART 7 HARI TERAKHIR ====
  $sales_data = [];
  $labels = [];

  for ($i = 6; $i >= 0; $i--) {
      $date_obj = new DateTime("-$i days", new DateTimeZone('Asia/Jakarta'));
      $date = $date_obj->format('Y-m-d');
      $day_label = $date_obj->format('D');
      $labels[] = $day_label;

      $query = "SELECT SUM(total) as total FROM riwayat_pembelian 
                WHERE nama_kantin = '$nama_kantin_penjual' 
                AND DATE(tanggal) = '$date' 
                AND status = 'Done'";

      $result = mysqli_query($koneksi, $query);
      if (!$result) {
          die("Query error: " . mysqli_error($koneksi));
      }
      $row = mysqli_fetch_assoc($result);
      $sales_data[] = (int)($row['total'] ?? 0);
  }


  // Nanti di bagian HTML/JS Chart, kamu bisa pakai:
  ?>


    <div data-aos="fade-up" data-aos-duration="1000">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-6">
      <div class="bg-white shadow rounded-lg p-4 border border-black">
        <h3 class="text-sm text-black font-medium">Total Orders This Week</h3>
        <p class="text-xl font-bold text-kuning"><?= $data['qty'] ?? 0 ?></p>
      </div>
      <div class="bg-white shadow rounded-lg p-4 border border-black">
        <h3 class="text-sm text-black font-medium">Total Income</h3>
        <p class="text-xl font-bold text-kuning">Rp <?= number_format($data['total'] ?? 0, 0, ',', '.') ?></p>
      </div>
      <div class="bg-white shadow rounded-lg p-4 border border-black">
        <h3 class="text-sm text-black font-medium">Best Selling Day</h3>
        <p class="text-xl font-bold text-kuning"><?= $best_day['hari'] ?? '—' ?></p>
      </div>
      <!-- keterangan 7 hari terakhir itu dari tanggal berapa ke tanggal berapa -->
      <div class="bg-white shadow rounded-lg p-4 border border-black">
        <h3 class="text-sm text-black font-medium">7 Days Latest</h3>
        <p class="text-xl font-bold text-kuning"><?= $tanggal_awal . ' - ' . $tanggal_akhir ?></p>
      </div>
    </div>

    <!-- Chart -->
    <div class="bg-white p-4 rounded-lg shadow border border-black mb-6">
      <h3 class="text-lg font-semibold mb-4">Sales in the Last 7 Days</h3>
      <canvas id="weeklyChart" height="80"></canvas>
    </div>
    </div>

</div>

  </main>
  <script>
    const chartLabels = <?= json_encode($labels) ?>;
    const chartData = <?= json_encode($sales_data) ?>;
  </script>
    <script>
      window.addEventListener('DOMContentLoaded', () => {
        const isMobile = window.innerWidth < 768;
        const ctx = document.getElementById('weeklyChart').getContext('2d');
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: chartLabels,
            datasets: [{
              label: isMobile ? '' : 'Sales (Rp)',
              data: chartData,
              borderColor: '#facc15',
              backgroundColor: '#fde68a',
              fill: true,
              tension: 0.4,
              pointRadius: 5,
              pointBackgroundColor: '#facc15'
            }]
          },
          options: {
            responsive: true,
            scales: {
              y: {
                display: !isMobile,
                beginAtZero: true,
                ticks: {
                  callback: function(value) {
                    return 'Rp ' + value.toLocaleString();
                  }
                }
              }
            },
            plugins: {
              legend: {
                display: !isMobile
              }
            }
          }
        });
      });

    </script>

    <script>
  AOS.init({
  });
</script>
</body>
</html>