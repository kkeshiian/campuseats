<?php
if (isset($_GET['id_pembeli']) && ($_GET['id_admin'])) {
    $id_per_pembeli = (int) $_GET['id_pembeli'];
    $id_admin = (int) $_GET['id_admin'];
}

include "../../database/koneksi.php";
include "../../database/model.php";

require_once '../../middleware/role_auth.php';

require_role('Admin');

$hasil = hapusPembeli($koneksi, $id_per_pembeli, $id_admin)




?>