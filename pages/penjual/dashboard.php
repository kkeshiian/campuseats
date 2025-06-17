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
        header("Location: dashboard.php?id_penjual=" . $id_per_penjual . "&status=done");
        exit();
    }
} 
?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/campuseats/dist/output.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
    <title>Seller Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  </head>
  <body class="min-h-screen flex flex-col">
    <?php 
    $activePage = 'dashboard_seller';
    include '../../partials/navbar-penjual.php'; ?>

    <main class="w-[90%] mx-auto mt-6">
      <h2 class="text-2xl font-bold mb-4" data-aos="fade-right" data-aos-duration="1000">Seller Dashboard</h2>
      

      <!-- Statistik -->
      <?php
      date_default_timezone_set('Asia/Jakarta');
      $tanggal_hari_ini = date('Y-m-d');
      $ambil_data = mysqli_query($koneksi, "SELECT id_fakultas, nama_kantin, gambar FROM penjual WHERE id_penjual = '$id_per_penjual'");
      $ambil_data_nama_fakultas  = mysqli_query($koneksi, "SELECT nama_fakultas FROM fakultas JOIN penjual ON penjual.id_fakultas = fakultas.id_fakultas WHERE penjual.id_penjual = '$id_per_penjual'");
      $data = mysqli_fetch_assoc($ambil_data);
      $nama_kantin = $data['nama_kantin'];

      $data_fakultas = mysqli_fetch_assoc($ambil_data_nama_fakultas);
      $nama_fakultas = $data_fakultas['nama_fakultas'];

      $ambil_data_riwayat_pembelian = mysqli_query($koneksi,
    "SELECT quantity AS qty, total, status, menu, order_id, tanggal, notes, tipe, status_pembayaran FROM riwayat_pembelian WHERE nama_kantin = '$nama_kantin' ORDER BY tanggal DESC");
      $total_keseluruhan = 0;
      $total_orderan = 0;
      $daftar_pesanan_hari_ini = []; 

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


      while ($row = mysqli_fetch_assoc($ambil_data_riwayat_pembelian)) {
          $tanggal_order = date('Y-m-d', strtotime($row['tanggal']));

          if ($tanggal_order === $tanggal_hari_ini) {
              $total_keseluruhan += $row['total'];
              $total_orderan += $row['qty'];
              $daftar_pesanan_hari_ini[] = $row;
          }

      }
      
      ?>
      <div data-aos="fade-up" data-aos-duration="1000">
        Date: <h4 id="tanggalHariIni" class="text-2xl font-bold mb-4"></h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="flex items-center gap-4 bg-white border border-black rounded-lg p-4 text-center">
          <div class="mx-auto">
            <h3 class="text-lg font-semibold text-black"><?=$nama_fakultas?></h3>
            <p class="text-2xl font-bold text-kuning"><?=$nama_kantin?></p>
          </div>
        </div>
        <div class="bg-white border border-black rounded-lg p-4 text-center flex items-center">
          <div class="mx-auto">
            <h3 class="text-lg font-semibold">Today's income</h3>
            <p class="text-2xl font-bold text-kuning">Rp <?=number_format($data['total'], 0, ',', '.')?></p>
          </div>
        </div>
        <div class="bg-white border border-black rounded-lg p-4 text-center  flex items-center">
          <div class="mx-auto">
            <h3 class="text-lg font-semibold">Today's orders</h3>
            <p class="text-2xl font-bold text-kuning"><?=$total_orderan?> Orders</p>
          </div>
        </div>
      </div>

      <!-- List Pesanan Masuk -->
        <div class="mb-8">
          <h3 class="text-xl font-semibold mb-4 text-center md:text-left">Incoming Orders</h3>
          <div class="space-y-6">
            <?php if (count($daftar_pesanan_hari_ini) === 0): ?>
              <p class="text-gray-500 text-base text-center">No orders yet</p>
            <?php else: ?>
              <?php foreach ($daftar_pesanan_hari_ini as $pesanan): ?>
                <div class="bg-white border border-black rounded-lg p-4 flex flex-col md:flex-row md:justify-between md:items-center gap-4 shadow-sm hover:shadow-md transition">
                  
                  <!-- Left (Order Info) -->
                  <div class="flex-1 space-y-1 text-sm md:text-base">
                    <p class="font-bold text-lg md:text-xl text-black"><?= $pesanan["menu"] ?></p>

                    <p class="text-gray-500">Order ID: <span class="text-black"><?= $pesanan["order_id"] ?></span></p>
                    <p class="text-gray-500">Date: <span class="text-black"><?= $pesanan["tanggal"] ?></span></p>
                    <p class="text-gray-500">Type Payment: <span class="text-black"><?= $pesanan["tipe"] ?></span></p>
                    <p class="text-gray-500">Payment Status: <span class="text-black"><?= $pesanan["status_pembayaran"] ?></span></p>
                    <p class="text-gray-500">Quantity: <span class="text-black"><?= $pesanan["qty"] ?></span></p>
                    <p class="text-gray-500">Total: <span class="text-black">Rp <?= number_format($pesanan["total"]) ?></span></p>

                    <p class="text-gray-500 font-medium">Note:
                      <span class="text-black">
                        <?= empty($pesanan["notes"]) ? "-" : htmlspecialchars($pesanan["notes"]) ?>
                      </span>
                    </p>
                  </div>

                  <!-- Right (Form) -->
                  <form method="post" class="form-konfirmasi-status w-full md:w-64">
                    <input type="hidden" name="id" value="<?= $pesanan["order_id"] ?>">
                    <input type="hidden" name="menu" value="<?= $pesanan["menu"] ?>">

                    <fieldset class="mb-2">
                      <?php $isDone = $pesanan["status"] === "Done"; ?>
                      <label for="status" class="block text-sm font-semibold mb-1">Order Status</label>
                      <select name="status" id="status" required class="select select-bordered w-full"
                        <?= $isDone ? 'disabled' : '' ?>>
                        <option value="">Waiting to Confirm</option>
                        <?php
                          $statuses = ["Being Cooked", "Ready to Pickup", "Done"];
                          foreach ($statuses as $status) {
                              $selected = ($pesanan["status"] == $status) ? "selected" : "";
                              echo "<option value='$status' $selected>$status</option>";
                          }
                        ?>
                      </select>
                    </fieldset>

                    <button type="submit" name="submit"
                      class="btn btn-sm w-full bg-kuning text-white rounded-lg mt-1 hover:bg-yellow-600"
                      <?= $isDone ? 'disabled' : '' ?>>
                      Update
                    </button>

                    <?php if ($isDone): ?>
                      <p class="text-sm text-gray-500 mt-1 italic">Order has been marked as Done.</p>
                    <?php endif; ?>
                  </form>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </main>

  <script>
    function konfirmasiSebelumSubmit(form) {
        const statusSelect = form.querySelector('select[name="status"]');
        const selectedStatus = statusSelect.value;

        if (selectedStatus === "Done") {
            const konfirmasi = confirm("Are you sure you want to change this order status to 'Done'? You can't change it again afterward.");
            return konfirmasi;
        }

        return true;
    }
  </script>

  <script>
    document.querySelectorAll('.form-konfirmasi-status').forEach(function(form) {
      form.addEventListener('submit', function(e) {
        const statusSelect = form.querySelector('select[name="status"]');
        const selectedStatus = statusSelect.value;

        if (selectedStatus === "Done") {
          e.preventDefault();

          Swal.fire({
            title: 'Are you sure you want to change the status to Done?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FFB43B',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'Cancel'
          }).then((result) => {
            if (result.isConfirmed) {
              form.submit(); // submit form yang sedang diproses
            }
          });
        }
      });
    });
  </script>




  <script>
    const hariIni = new Date();
    const opsiFormat = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
    const tanggalFormatted = hariIni.toLocaleDateString('id-ID', opsiFormat);

    document.getElementById("tanggalHariIni").textContent = tanggalFormatted;
  </script>

  <script>
    AOS.init({
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
<script>
  const notyf = new Notyf({
    duration: 3000,
    position: { x: 'right', y: 'top' },
    types: [
      {
        type: 'success',
        background: '#FFB43B',
        icon: { className: 'notyf__icon--success', tagName: 'i' }
      },
      {
        type: 'error',
        background: '#d63031',
        icon: { className: 'notyf__icon--error', tagName: 'i' }
      }
    ]
  });

  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('success') === '1') {
    notyf.success('Successfully logged in as Seller!');
    // Hapus parameter agar toast tidak muncul lagi saat reload
    window.history.replaceState({}, document.title, window.location.pathname + window.location.search.replace(/([&?])success=1/, '').replace(/([&?])$/, ''));
  }
</script>
</body>
</html>