<?php
require_once('../config/koneksi.php');
require_once('../config/midtrans-config.php');

$notif = json_decode(file_get_contents("php://input"));
$order_id = $notif->order_id;
$transaction_status = $notif->transaction_status;

if ($transaction_status == 'settlement') {
    // 1. Update status pembayaran
    mysqli_query($conn, "UPDATE pembayaran SET status='dibayar' WHERE id_pesanan = '$order_id'");

    // 2. Ambil detail pesanan
    $sql = "SELECT dp.id_menu, m.id_penjual, dp.jumlah, dp.subtotal
            FROM detail_penjualan dp
            JOIN menu m ON dp.id_menu = m.id_menu
            WHERE dp.id_pesanan = '$order_id'";
    $result = mysqli_query($conn, $sql);

    $penjual_data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $id_penjual = $row['id_penjual'];
        if (!isset($penjual_data[$id_penjual])) {
            $penjual_data[$id_penjual] = [
                'jumlah_menu' => 0,
                'jumlah_pesanan' => 0
            ];
        }
        $penjual_data[$id_penjual]['jumlah_menu'] += $row['jumlah'];
        $penjual_data[$id_penjual]['jumlah_pesanan'] += $row['subtotal'];
    }

    // 3. Simpan laporan_penjualan
    foreach ($penjual_data as $id_penjual => $data) {
        $jumlah_menu = $data['jumlah_menu'];
        $jumlah_pesanan = $data['jumlah_pesanan'];
        $tanggal = date('Y-m-d H:i:s');

        mysqli_query($conn, "INSERT INTO laporan_penjualan (id_penjual, jumlah_pesanan, jumlah_menu, tanggal_laporan)
                             VALUES ('$id_penjual', '$jumlah_pesanan', '$jumlah_menu', '$tanggal')");

        $id_laporan = mysqli_insert_id($conn);

        // 4. Update detail_penjualan dan pesanan dengan id_laporan
        mysqli_query($conn, "UPDATE detail_penjualan 
                             JOIN menu ON detail_penjualan.id_menu = menu.id_menu
                             SET id_laporan = '$id_laporan'
                             WHERE id_pesanan = '$order_id' AND menu.id_penjual = '$id_penjual'");

        mysqli_query($conn, "UPDATE pesanan SET id_laporan = '$id_laporan' WHERE id_pesanan = '$order_id'");
    }
}
