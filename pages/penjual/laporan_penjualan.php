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
    $tanggal_akhir = (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('d M Y');
    $tanggal_awal = date('d M Y', strtotime('-6 days'));

    $sql = "SELECT nama_kantin FROM penjual WHERE id_penjual = $id_per_penjual";
    $result = mysqli_query($koneksi, $sql);
    $row = mysqli_fetch_assoc($result);
    $nama_kantin_penjual = $row['nama_kantin'];

    $query = "SELECT SUM(quantity) AS qty, SUM(total) AS total 
              FROM riwayat_pembelian 
              WHERE nama_kantin = '$nama_kantin_penjual' 
              AND tanggal >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND status = 'selesai'";
    $ambil_data = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($ambil_data);

    $best_day_query = "SELECT DAYNAME(tanggal) AS hari, SUM(total) AS total_hari 
                      FROM riwayat_pembelian 
                      WHERE nama_kantin = '$nama_kantin_penjual' 
                      AND tanggal >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                      AND status = 'selesai'
                      GROUP BY hari 
                      ORDER BY total_hari DESC 
                      LIMIT 1";


    $best_day_result = mysqli_query($koneksi, $best_day_query);
    $best_day = mysqli_fetch_assoc($best_day_result);

    // kode php untuk bagian chart
          $weekly_sales_query = "
        SELECT DAYNAME(tanggal) as hari, SUM(total) as total 
        FROM riwayat_pembelian 
        WHERE nama_kantin = '$nama_kantin_penjual' 
          AND tanggal >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) AND status = 'selesai'
        GROUP BY hari
      ";

      $weekly_sales_result = mysqli_query($koneksi, $weekly_sales_query);

      // Map hari ke index Senin-Minggu
      $hari_mapping = [
        'Monday' => 0,
        'Tuesday' => 1,
        'Wednesday' => 2,
        'Thursday' => 3,
        'Friday' => 4,
        'Saturday' => 5,
        'Sunday' => 6
      ];

      // Isi default 0 untuk semua hari
      $sales_data = array_fill(0, 7, 0);

      while ($row = mysqli_fetch_assoc($weekly_sales_result)) {
        $hari_index = $hari_mapping[$row['hari']] ?? null;
        if ($hari_index !== null) {
          $sales_data[$hari_index] = (int)$row['total'];
        }
      }

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
    const salesData = <?= json_encode($sales_data) ?>;
  </script>
    <script>
      const isMobile = window.innerWidth < 768;
      const weeklyChart = new Chart(document.getElementById('weeklyChart'), {
        type: 'bar',
        data: {
          labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
          datasets: [{
            label: isMobile ? '' : 'Sales (Rp)',
            data: salesData,
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
    </script>

    <script>
  AOS.init({
  });
</script>
</body>
</html>
