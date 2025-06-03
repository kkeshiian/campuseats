<?php
require_once '../../middleware/role_auth.php';

require_role('pembeli');
?>

<?php
session_start();
// if (!isset($_SESSION['order_id'])) {
//   header("Location: ../../cart.php");
//   exit;
// }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pembayaran Sukses</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>  
  <?php 
  include '../../partials/navbar.php'; 
  ?>

  <!-- Konten utama setelah navbar -->
  <div class="flex justify-center items-center pt-24 px-4">
    <div class="bg-white shadow-md rounded-xl p-8 max-w-md w-full text-center">
      
      <svg class="mx-auto mb-4 text-green-500 w-16 h-16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
      </svg>

      <h1 class="text-2xl font-bold text-gray-800 mb-2">Pembayaran Berhasil!</h1>
      <p class="text-gray-600 mb-4">
        Terima kasih atas pembelian Anda.<br>
        Pembayaran untuk <strong>Order ID #<?= htmlspecialchars($_SESSION['order_id']) ?></strong> telah berhasil diproses.
      </p>

      <a href="../../index.php" class="inline-block mt-4 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded transition duration-300">
        Kembali ke Beranda
      </a>

    </div>
  </div>

</body>
</html>
