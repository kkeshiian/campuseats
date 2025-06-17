<?php
include "../../database/koneksi.php";
include "../../database/model.php";

require_once '../../middleware/role_auth.php';
require_role('pembeli');

if (isset($_GET['id_pembeli'])) {
  $id_per_pembeli = $_GET['id_pembeli'];
}
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

  <h2 class="text-2xl font-bold mx-auto m-4" data-aos="fade-up" data-aos-duration="1000">Purchase History</h2>

  <div class="w-[90%] mx-auto mb-10" data-aos="fade-up" data-aos-duration="1000">
    <div class="overflow-x-auto bg-white border border-black rounded-lg shadow-md">
      <?php
      $ambil_data = mysqli_query($koneksi, "SELECT * FROM riwayat_pembelian WHERE id_pembeli='$id_pembeli' ORDER BY order_id, nama_kantin, tanggal");
    
      if (mysqli_num_rows($ambil_data) == 0) {
        echo "<p class='text-base mx-auto m-4 text-center text-gray-500'>No order history yet.</p>";
        return;
      } else{
          echo "
            <table class='table w-full'>
              <thead class='bg-kuning text-white'>
                <tr>
                 <th>No</th>
                  <th>Order ID</th>
                  <th>Canteen</th>
                  <th>Menu</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Total</th>
                  <th>Status</th>
                  <th>Method</th>
                  <th>Status</th>
                  <th>Date & Time</th>
                </tr>
              </thead>
              <tbody>";
                  history_pembeli($koneksi, $id_per_pembeli);
          echo "</tbody></table>";
      }
      ?>
    </div>
  </div>


</body>

<script>
  AOS.init({
  });
</script>

</html>
