<?php
if (isset($_GET['id_menu'])) {
    $id_per_menu = (int) $_GET['id_menu'];
}else{
  header("Location: /campuseats/pages/auth/logout.php");
  exit();
}

if (isset($_GET['id_penjual'])) {
    $id_per_penjual = (int) $_GET['id_penjual'];
}

include "../../database/koneksi.php";
include "../../database/model.php";

require_once '../../middleware/role_auth.php';

require_role('penjual');

$result = hapusMenu($koneksi, $id_per_menu, $id_per_penjual);

?>