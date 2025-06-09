<?php
require_once '../../middleware/role_auth.php';
$orderId = $_GET['order_id'] ?? 'UNKNOWN';
require_role('pembeli');

if (isset($_GET['id_pembeli'])) {
  $id_per_pembeli = $_GET['id_pembeli'];
}

?>

<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pembayaran Sukses</title>
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
</head>
<body>  
  <?php 
  include '../../partials/navbar-pembeli.php'; 
  ?>

  <!-- Konten utama setelah navbar -->
  <div class="flex justify-center items-center pt-24 px-4">
    <div class="bg-white shadow-md rounded-xl p-8 max-w-md w-full text-center border border-black">
      
      <svg class="mx-auto mb-4 text-green-500 w-16 h-16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
      </svg>

      <h1 class="text-2xl font-bold text-gray-800 mb-2">Payment Successful!</h1>
      <p class="text-gray-600 mb-4">
       Thank you for your purchase.<br>
       Your order <strong>#<?= htmlspecialchars($orderId) ?></strong> has been placed.

      </p>

      <a href="/campuseats/pages/pembeli/history.php?id_pembeli=<?= $id_per_pembeli ?>" class="inline-block mt-4 bg-kuning hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded transition duration-300">
        Track Your Order
      </a>

    </div>
  </div>

</body>
</html>