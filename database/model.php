<?php

include "koneksi.php";

function tambah_pembeli($koneksi, $id_user){
    $ambil_data = mysqli_query($koneksi, "SELECT nama FROM user WHERE id_user='$id_user'");
    $user = mysqli_fetch_assoc($ambil_data);
    $nama = $user['nama'];

    mysqli_query($koneksi, "INSERT INTO pembeli SET id_user='$id_user', nama='$nama'");
}



function registrasi($koneksi, $nama, $username, $password, $role) {
        mysqli_query($koneksi, "
            INSERT INTO user SET
            nama = '$nama',
            username = '$username',
            password = '$password',
            Role = '$role'       
        ");
        $cek_role = $role;

        if ($cek_role=='pembeli') {
            $id_user_baru = mysqli_insert_id($koneksi);

            tambah_pembeli($koneksi, $id_user_baru);
        }
        
        return true;
}

function registrasiPenjual($koneksi, $username, $nama_penjual, $nama_kantin, $id_fakultas, $password, $link) {
        $username = mysqli_real_escape_string($koneksi, $username);
        mysqli_query($koneksi, "
            INSERT INTO user SET
            nama = '$nama_penjual',
            username = '$username',
            password = '$password',
            Role = 'penjual'       
        ");
        $id_user_baru = mysqli_insert_id($koneksi);

        tambah_penjual($koneksi, $id_user_baru, $nama_penjual, $id_fakultas, $nama_kantin,
     $link    
    );

}

function tambah_penjual($koneksi, $id_user, $nama, $id_fakultas, $nama_kantin, $link){
    $ambil_data = mysqli_query($koneksi, "SELECT nama FROM user WHERE id_user='$id_user'");
    $user = mysqli_fetch_assoc($ambil_data);
    $nama = $user['nama'];
    $gambar = "/assets/img/default-canteen.jpg";

    mysqli_query($koneksi, "INSERT INTO penjual SET 
            id_user='$id_user', 
            nama_kantin='$nama_kantin',
            nama = '$nama', 
            gambar = '$gambar', 
            link = '$link', 
            id_fakultas = '$id_fakultas'
        ");
}

function login($koneksi, $username, $password) {
    $username = mysqli_real_escape_string($koneksi, $username);
    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            return $user;
        }
    }
    return false;
}

function saveOrderSimple($koneksi, $order_id, $id_pembeli, $cart, $created_at = null) {
    if (!$created_at) {
        $created_at = date('Y-m-d H:i:s');
    }
    
    foreach ($cart as $item) {
        $nama_kantin = $item['kantin'] ?? '';
        $menu = $item['nama'] ?? '';
        $quantity = $item['quantity'] ?? 0;
        $harga = $item['harga'] ?? 0;
        $total = $item['total'] ?? ($harga * $quantity);
        $status = $item['status'] ?? 'Waiting to Confirm';
        $note = mysqli_real_escape_string($koneksi, $item['notes'] ?? '');
        $tanggal = $created_at;
        
        $query = "INSERT INTO riwayat_pembelian 
                  (order_id, id_pembeli, nama_kantin, menu, quantity, harga, total, status, notes) 
                  VALUES 
                  ('$order_id', '$id_pembeli','$nama_kantin', '$menu', $quantity, $harga, $total, '$status', '$note')";
        
        $result = mysqli_query($koneksi, $query);
        
        if (!$result) {
            return ['success' => false, 'message' => 'Failed to insert: ' . mysqli_error($koneksi)];
        }
    }
    
    return ['success' => true, 'message' => 'Order saved successfully'];
}

function history_pembeli($koneksi, $id_pembeli){
    $ambil_data = mysqli_query($koneksi, "SELECT * FROM riwayat_pembelian WHERE id_pembeli='$id_pembeli' ORDER BY order_id, nama_kantin, tanggal");
    $orders_count = [];
    $kantin_count = [];
    $rows = [];

    while ($data_history = mysqli_fetch_assoc($ambil_data)) {
        $rows[] = $data_history;

        $orders_count[$data_history['order_id']] = ($orders_count[$data_history['order_id']] ?? 0) + 1;

        $key = $data_history['order_id'] . '|' . $data_history['nama_kantin'];
        $kantin_count[$key] = ($kantin_count[$key] ?? 0) + 1;
    }

    $no = 1;
    $printed_order_ids = [];
    $printed_kantin = [];

    foreach ($rows as $data_history) {
        echo "<tr>";

        if (!in_array($data_history['order_id'], $printed_order_ids)) {
            $rowspan_order = $orders_count[$data_history['order_id']];
            echo "<td rowspan='$rowspan_order'>$no</td>";
            echo "<td rowspan='$rowspan_order'>{$data_history['order_id']}</td>";
            $printed_order_ids[] = $data_history['order_id'];
            $no++;
        }

        $key = $data_history['order_id'] . '|' . $data_history['nama_kantin'];
        if (!in_array($key, $printed_kantin)) {
            $rowspan_kantin = $kantin_count[$key];
            echo "<td rowspan='$rowspan_kantin'>{$data_history['nama_kantin']}</td>";
            $printed_kantin[] = $key;
        }

        echo "<td>{$data_history['menu']}</td>";
        echo "<td>{$data_history['quantity']}</td>";
        echo "<td>Rp" . number_format($data_history['harga']) . "</td>";
        echo "<td>Rp" . number_format($data_history['total']) . "</td>";
        echo "<td>{$data_history['status']}</td>";
        echo "<td>{$data_history['tanggal']}</td>";

        echo "</tr>";
    }
}

function updateStatusPesanan($koneksi, $order_id, $status, $menu){
    $order_id = mysqli_real_escape_string($koneksi, $order_id);
    $status = mysqli_real_escape_string($koneksi, $status);
    $menu = mysqli_real_escape_string($koneksi, $menu);

    $query = "UPDATE riwayat_pembelian SET status='$status', tanggal = CURRENT_TIMESTAMP  WHERE order_id='$order_id' AND menu='$menu'";
    $result = mysqli_query($koneksi, $query);

    return $result;
}

function hapusMenu($koneksi, $id_menu, $id_penjual){
    mysqli_query($koneksi,

    "DELETE FROM menu WHERE id_menu='$id_menu'"
    );
    header("Location: /campuseats/pages/penjual/kelola_menu.php?id_penjual=".$id_penjual);
    exit();
}

function updateInfoMenu($koneksi, $id_menu, $nama_menu, $harga, $gambar = null){
    $id_menu = mysqli_real_escape_string($koneksi, $id_menu);
    $nama_menu = mysqli_real_escape_string($koneksi, $nama_menu);
    $harga = (int)$harga;

    if ($gambar !== null) {
        $gambar = mysqli_real_escape_string($koneksi, $gambar);
        $query = "UPDATE menu SET nama_menu = '$nama_menu', harga = '$harga', gambar = 'assets/$gambar' WHERE id_menu = '$id_menu'";
    } else {
        $query = "UPDATE menu SET nama_menu = '$nama_menu', harga = '$harga' WHERE id_menu = '$id_menu'";
    }

    return mysqli_query($koneksi, $query);
}
function tambahMenu($koneksi, $id_penjual, $nama_menu, $harga, $gambar) {
    $nama_menu = mysqli_real_escape_string($koneksi, $nama_menu);
    $gambar = mysqli_real_escape_string($koneksi, $gambar);

    $id_penjual = (int) $id_penjual;
    $harga = (int) $harga;

    $query = "INSERT INTO menu (id_penjual, nama_menu, harga, gambar) 
              VALUES ($id_penjual, '$nama_menu', $harga, '$gambar')";

    return mysqli_query($koneksi, $query);
}
function updateInfoKantin($koneksi, $id_penjual, $nama_kantin, $link, $id_fakultas, $foto_baru = null) {
    $path_gambar = "assets/" . $foto_baru;
    if ($foto_baru) {
        $sql = "UPDATE penjual SET 
                    nama_kantin = ?, 
                    link = ?, 
                    id_fakultas = ?, 
                    gambar = ? 
                WHERE id_penjual = ?";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $nama_kantin, $link, $id_fakultas, $path_gambar, $id_penjual);
    } else {
        $sql = "UPDATE penjual SET 
                    nama_kantin = ?, 
                    link = ?, 
                    id_fakultas = ? 
                WHERE id_penjual = ?";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "sssi", $nama_kantin, $link, $id_fakultas, $id_penjual);
    }

    if (mysqli_stmt_execute($stmt)) {
        return true;
    } else {
        return false;
    }
}

function updateInfoAdmin($koneksi, $id_admin, $nama, $jabatan){
    $id_admin = mysqli_real_escape_string($koneksi, $id_admin);
    $nama = mysqli_real_escape_string($koneksi, $nama);
    $jabatan = mysqli_real_escape_string($koneksi, $jabatan);
    
    $query = "UPDATE admin SET nama = '$nama', jabatan = '$jabatan' WHERE id_admin = '$id_admin'";

    return mysqli_query($koneksi, $query);
}

function hapusPembeli($koneksi, $id_pembeli, $id_admin){
    mysqli_query($koneksi,

    "DELETE FROM user WHERE id_user='$id_pembeli'"
    );
    header("Location: /campuseats/pages/admin/kelola_pengguna.php?id_admin=".$id_admin);
    exit();
}

function hapusPenjual($koneksi, $id_penjual, $id_admin){
    mysqli_query($koneksi,

    "DELETE FROM user WHERE id_user='$id_penjual'"
    );
    header("Location: /campuseats/pages/admin/kelola_kantin.php?id_admin=".$id_admin);
    exit();
}

function updatePasswordPengguna($koneksi, $id_user, $username, $new_password) {
    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $username = mysqli_real_escape_string($koneksi, $username);

    $query = "UPDATE user SET username='$username', password='$password_hash' WHERE id_user='$id_user'";
    $result = mysqli_query($koneksi, $query);

    return $result;
}





?>