<?php

include "koneksi.php";

function tambah_pembeli($koneksi, $id_user){
    $ambil_data = mysqli_query($koneksi, "SELECT nama FROM user WHERE id_user='$id_user'");
    $user = mysqli_fetch_assoc($ambil_data);
    $nama = $user['nama'];

    mysqli_query($koneksi, "INSERT INTO pembeli SET id_user='$id_user', nama='$nama'");
}



function registrasi($koneksi, $nama, $username, $password, $role, $email, $nomor_wa) {
    $ambil_data_usn = mysqli_query($koneksi, "SELECT username FROM user WHERE username = '$username'");
    $ambil_data_email = mysqli_query($koneksi, "SELECT email FROM user WHERE email = '$email'");
    $ambil_data_nomor_wa = mysqli_query($koneksi, "SELECT nomor_wa FROM user WHERE nomor_wa = '$nomor_wa'");

    if (mysqli_num_rows($ambil_data_usn) > 0) {
        return "Username already used! choose another username";
    }elseif (mysqli_num_rows($ambil_data_email) > 0) {
        return "Email already used! choose another email";
    }elseif (mysqli_num_rows($ambil_data_nomor_wa)) {
        return "Whatsapp number already used! choose another number";
    }
    $query = mysqli_query($koneksi, "
        INSERT INTO user (nama, username, password, role, email, nomor_wa)
        VALUES ('$nama', '$username', '$password', '$role', '$email', '$nomor_wa')
    ");
    if (!$query) {
        return "Registration failed: " . mysqli_error($koneksi);
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

function is_done($koneksi, $order_id, $menu,  $id_user, $nomor_wa){
    $order_id = mysqli_real_escape_string($koneksi, $order_id);
    $query = "INSERT INTO is_done SET 
    id_user = '$id_user',
    nomor_wa = '$nomor_wa',
    menu = '$menu',
    order_id = '$order_id',
    is_sent = 0";

    $result = mysqli_query($koneksi, $query);
    return $result;
}

function send_notif($nomor, $pesan) {
    $token = "HsCtMv5poHL7eTAnNtVj"; // 

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.fonnte.com/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => array(
            'target' => $nomor,
            'message' => $pesan
        ),
        CURLOPT_HTTPHEADER => array(
            "Authorization: $token"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    return $err ? false : true;
}

function kirimNotifikasiDone($koneksi) {
    $query = "SELECT * FROM is_done WHERE is_sent = 0";
    $result = mysqli_query($koneksi, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $nomor_wa = $row['nomor_wa'];
        $order_id = $row['order_id'];
        $menu     = $row['menu'];
        $id_user  = $row['id_user'];
        $id       = $row['id_isdone'];

        $result_kedua = mysqli_query($koneksi, "SELECT nama FROM user WHERE id_user='$id_user'");
        $data_user = mysqli_fetch_assoc($result_kedua);
        $nama = $data_user['nama'] ?? 'Pengguna Setia Campuseats';

        $result_ketiga = mysqli_query($koneksi, "SELECT nama_kantin FROM riwayat_pembelian WHERE order_id='$order_id'");
        $data_kantin = mysqli_fetch_assoc($result_ketiga);
        $nama_kantin = $data_kantin['nama_kantin'] ?? 'Kantin Campuseats';

        $pesan = "Makanan mu Telah Siap!!!\n";
        $pesan .= "Order ID: *$order_id*\n";
        $pesan .= "============================================\n\n";
        $pesan .= "Halo $nama,\n";
        $pesan .= "Pesanan Anda untuk menu *$menu* di Kantin *$nama_kantin* dengan Order ID *$order_id* telah selesai dan siap untuk diambil.\n\n";
        $pesan .= "Terima kasih telah menjadi sahabt setia Campuseats!";

        $berhasil = send_notif($nomor_wa, $pesan);

        if ($berhasil) {
            mysqli_query($koneksi, "UPDATE is_done SET is_sent = 1 WHERE id_isdone = '$id'");
        }
    }
}

function updateStatusPesanan($koneksi, $order_id, $status, $menu){
    $order_id = mysqli_real_escape_string($koneksi, $order_id);
    $status = mysqli_real_escape_string($koneksi, $status);
    $menu = mysqli_real_escape_string($koneksi, $menu);

    $query = "UPDATE riwayat_pembelian SET status='$status', tanggal = CURRENT_TIMESTAMP WHERE order_id='$order_id' AND menu='$menu'";
    $result = mysqli_query($koneksi, $query);

    if ($result && $status === 'Done') {
        // kita ambil id_pembeli
        $ambil_id_pembeli = mysqli_query($koneksi, "SELECT id_pembeli FROM riwayat_pembelian WHERE order_id = '$order_id'");
        $data_pembeli = mysqli_fetch_assoc($ambil_id_pembeli);
        $id_pembeli = $data_pembeli['id_pembeli'] ?? null;

        // kita ambil id_user
        if ($id_pembeli) {
            $ambil_id_user = mysqli_query($koneksi, "SELECT id_user FROM pembeli WHERE id_pembeli = '$id_pembeli'");
            $data_user = mysqli_fetch_assoc($ambil_id_user);
            $id_user = $data_user['id_user'] ?? null;

            // kita ambil nomor WA
            if ($id_user) {
                $ambil_nomor_wa = mysqli_query($koneksi, "SELECT nomor_wa FROM user WHERE id_user = '$id_user'");
                $data_wa = mysqli_fetch_assoc($ambil_nomor_wa);
                $nomor_wa = $data_wa['nomor_wa'] ?? null;

                if ($nomor_wa) {
                    is_done($koneksi, $order_id, $menu, $id_user, $nomor_wa);
                    kirimNotifikasiDone($koneksi, $order_id, $menu, $id_user);
                }
            }
        }
    }

    return $result;
}


function hapusMenu($koneksi, $id_menu, $id_penjual){
    mysqli_query($koneksi,

    "DELETE FROM menu WHERE id_menu='$id_menu'"
    );
    header("Location: /campuseats/pages/penjual/kelola_menu.php?id_penjual=".$id_penjual);
    $result = mysqli_query($koneksi, "DELETE FROM menu WHERE id_menu='$id_menu'");
    return $result;
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

    if (empty($gambar)) {
        $gambar = 'assets/default-menu.jpg';
    }

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
    $result = mysqli_query($koneksi, "DELETE FROM pembeli WHERE id_user='$id_pembeli'");
    header("Location: /campuseats/pages/admin/kelola_pengguna.php?id_admin=".$id_admin);
    return $result;
    exit();
}

function hapusPenjual($koneksi, $id_penjual, $id_admin){
    mysqli_query($koneksi,

    "DELETE FROM user WHERE id_user='$id_penjual'"
    );
    header("Location: /campuseats/pages/admin/kelola_kantin.php?id_admin=".$id_admin);
    $result = mysqli_query($koneksi, "DELETE FROM menu WHERE id_penjual='$id_penjual'");
    return $result;
    exit();
}

function updatePasswordPengguna($koneksi, $id_user, $username, $new_password) {
    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $username = mysqli_real_escape_string($koneksi, $username);

    $query = "UPDATE user SET username='$username', password='$password_hash' WHERE id_user='$id_user'";
    $result = mysqli_query($koneksi, $query);

    return $result;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';
function verif_otp($koneksi, $nama_user, $email_user) {
    $mail = new PHPMailer(true);

    function generateOTP() {
        $digits = '';
        for ($i = 0; $i < 6; $i++) {
            $digits .= mt_rand(0, 9);
        }

        $letters = '';
        for ($i = 0; $i < 2; $i++) {
            $letters .= chr(mt_rand(65, 90)); // ASCII A-Z
        }

        return $digits . $letters;
    }

    $otp = generateOTP();

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'campuseats.company@gmail.com';
        $mail->Password   = 'aederepvtrzykzdp'; // gunakan App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('campuseats.company@gmail.com', 'Campuseats');
        $mail->addAddress($email_user, $nama_user);

        $mail->isHTML(true);
        $mail->Subject = '[Do not share this code to anyone!] OTP Code Registration Campuseats';
        $mail->Body = '
            <div style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">
                <p>Hi ' . htmlspecialchars($nama_user) . ',</p>
                <p>Thank you for registering at <strong>Campuseats</strong>! To complete your registration, please use the following OTP code:</p>
                <div style="text-align: center; margin: 20px 0;">
                    <span style="display: inline-block; background-color: #f5f5f5; padding: 15px 25px; font-size: 24px; font-weight: bold; letter-spacing: 4px; border-radius: 8px; border: 1px solid #ccc;">
                        ' . $otp . '
                    </span>
                </div>
                <p>This code is valid for the next <strong>5 minutes</strong>. Please do not share this code with anyone, including Campuseats staff.</p>
                <p>If you didn’t request this code, you can safely ignore this email.</p>
                <p>Regards,<br><strong>Campuseats Team</strong></p>
                <hr style="margin-top: 30px;">
                <p style="font-size: 12px; color: #777;">This is an automated message, please do not reply.</p>
            </div>
        ';

        $mail->send();
        date_default_timezone_set('Asia/Makassar');
        $expires_at = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        // coba ambil id user dari email user
        $ambil_id_user = mysqli_query($koneksi, "SELECT id_user FROM user WHERE email='$email_user'");
        $data_id_user = mysqli_fetch_assoc($ambil_id_user);



        // mengirim data otp dan waktu ke tabel otp_verfications
        $send_data = mysqli_query($koneksi, "INSERT INTO otp_verifications SET
        id_user = '$data_id_user[id_user]',
        otp_code = '$otp',
        expires_at = '$expires_at',
        is_used = 0
         ");

        return true;

    } catch (Exception $e) {
        error_log("Email gagal dikirim: {$mail->ErrorInfo}");
        return false;
    }
}

function verification_account($koneksi, $otp, $id_user_masuk) {
    date_default_timezone_set('Asia/Makassar');
    $id_user = $id_user_masuk;

    $otp = mysqli_real_escape_string($koneksi, $otp);

    $query = "SELECT * FROM otp_verifications 
              WHERE otp_code = '$otp' 
              AND is_used = 0 
              AND expires_at >= NOW() 
              AND id_user = '$id_user'
              LIMIT 1";

    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        mysqli_query($koneksi, "UPDATE otp_verifications SET is_used =1 WHERE expires_at > NOW() ");

        mysqli_query($koneksi, "UPDATE user SET is_verified = 1 WHERE id_user = '$id_user'");

        mysqli_query($koneksi, "UPDATE otp_verifications SET is_used = 1 WHERE id = '{$data['id']}'");

    
        tambah_pembeli($koneksi, $id_user_masuk);

        return true;
    } else {
        return false;
    }
}

function resend_otp($koneksi, $id_user, $nama_user, $email_user) {
    date_default_timezone_set('Asia/Makassar');

    mysqli_query($koneksi, "UPDATE otp_verifications 
        SET is_used = 1 
        WHERE id_user = '$id_user' 
        AND is_used = 0 
        AND expires_at >= NOW()");

    return verif_otp($koneksi, $nama_user, $email_user);
}

function cekEmail($koneksi, $email){
    $cek_email_user = mysqli_query($koneksi, "SELECT email FROM user WHERE email='$email'");
    $data = mysqli_fetch_assoc($cek_email_user);

    if ($data) {
        return true;
    }else {
        return "We couldn't find an account with that email address.";
    }
}

function send_otp_for_reset($koneksi, $email){
    $mail = new PHPMailer(true);

    function generateOTPRePass() {
        $digits = '';
        for ($i = 0; $i < 6; $i++) {
            $digits .= mt_rand(0, 9);
        }

        $letters = '';
        for ($i = 0; $i < 2; $i++) {
            $letters .= chr(mt_rand(65, 90)); // ASCII A-Z
        }

        return $digits . $letters;
    }

    $otp = generateOTPRePass();

    // coba ambil nama user dengan email
    $query_ambil_nama = mysqli_query($koneksi, "SELECT nama FROM user WHERE email = '$email'");
    $result_nama = mysqli_fetch_assoc($query_ambil_nama);
    $nama_user = $result_nama['nama'];

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'campuseats.company@gmail.com';
        $mail->Password   = 'aederepvtrzykzdp'; // gunakan App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('campuseats.company@gmail.com', 'Campuseats');
        $mail->addAddress($email, $nama_user);

        $mail->isHTML(true);
        $mail->Subject = '[Reset Your Password!] OTP Code Reset Password Campuseats';
        $mail->Body = '
            <div style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">
                <p>Hi ' . htmlspecialchars($nama_user) . ',</p>
                <p>We received a request to reset your password for your <strong>Campuseats</strong> account. Use the OTP code below to proceed:</p>
                <div style="text-align: center; margin: 20px 0;">
                    <span style="display: inline-block; background-color: #f5f5f5; padding: 15px 25px; font-size: 24px; font-weight: bold; letter-spacing: 4px; border-radius: 8px; border: 1px solid #ccc;">
                        ' . $otp . '
                    </span>
                </div>
                <p>This code is valid for the next <strong>5 minutes</strong>. For your security, please do not share this code with anyone.</p>
                <p>If you didn’t request a password reset, please ignore this email — your account will remain safe.</p>
                <p>Best regards,<br><strong>The Campuseats Team</strong></p>
                <hr style="margin-top: 30px;">
                <p style="font-size: 12px; color: #777;">This is an automated message. Please do not reply to this email.</p>
            </div>
        ';


        $mail->send();
        date_default_timezone_set('Asia/Makassar');
        $expires_at = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        // coba ambil id user dari email user
        $ambil_id_user = mysqli_query($koneksi, "SELECT id_user FROM user WHERE email='$email'");
        $data_id_user = mysqli_fetch_assoc($ambil_id_user);

        // mengirim data otp dan waktu ke tabel otp_verfications
        $send_data = mysqli_query($koneksi, "INSERT INTO otp_verifications SET
        id_user = '$data_id_user[id_user]',
        otp_code = '$otp',
        expires_at = '$expires_at',
        is_used = 0
         ");

        return true;

    } catch (Exception $e) {
        error_log("Email gagal dikirim: {$mail->ErrorInfo}");
        return false;
    }
}

function resend_otp_reset_password($koneksi, $id_user, $nama_user, $email_user) {
    date_default_timezone_set('Asia/Makassar');

    mysqli_query($koneksi, "UPDATE otp_verifications 
        SET is_used = 1 
        WHERE id_user = '$id_user' 
        AND is_used = 0 
        AND expires_at >= NOW()");

    return send_otp_for_reset($koneksi, $email_user);
}

function verification_account_reset_password($koneksi, $otp, $id_user_masuk) {
    date_default_timezone_set('Asia/Makassar');
    $id_user = $id_user_masuk;

    $otp = mysqli_real_escape_string($koneksi, $otp);

    $query = "SELECT * FROM otp_verifications 
              WHERE otp_code = '$otp' 
              AND is_used = 0 
              AND expires_at >= NOW() 
              AND id_user = '$id_user'
              LIMIT 1";

    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        mysqli_query($koneksi, "UPDATE otp_verifications SET is_used =1 WHERE expires_at > NOW() ");

        mysqli_query($koneksi, "UPDATE user SET is_verified = 1 WHERE id_user = '$id_user'");

        mysqli_query($koneksi, "UPDATE otp_verifications SET is_used = 1 WHERE id = '{$data['id']}'");

        return true;
    } else {
        return false;
    }
}

function changePassword($koneksi, $password, $id_user){
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE user SET password='$password_hash' WHERE id_user='$id_user'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        return true;
    }else{
        return "Change Password failed: " . mysqli_error($koneksi);
    }
}

?>