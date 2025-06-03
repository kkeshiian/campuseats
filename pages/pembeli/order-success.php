<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head><title>Pembayaran Sukses</title></head>
<body>
  <h1>Terima kasih!</h1>
  <p>Pembayaran untuk Order ID <?= $_SESSION['order_id'] ?> berhasil.</p>
</body>
</html>
