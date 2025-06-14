<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // autoload PHPMailer

$mail = new PHPMailer(true);

try {
    // Konfigurasi SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // contoh Gmail
    $mail->SMTPAuth   = true;
    $mail->Username   = 'campuseats.company@gmail.com'; // ganti dengan emailmu
    $mail->Password   = 'aederepvtrzykzdp';      // gunakan app password, bukan password biasa
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Info pengirim & penerima
    $mail->setFrom('campuseats.company@gmail.com', 'Campuseats');
    $mail->addAddress('ghanimdzkr3@gmail.com', 'User');

    // Konten email
    $mail->isHTML(true);
    $mail->Subject = 'Tes Kirim Email';
    $mail->Body    = 'Ini adalah email percobaan dari <b>PHPMailer</b>.';

    $mail->send();
    echo 'Email berhasil dikirim.';
} catch (Exception $e) {
    echo "Email gagal dikirim. Error: {$mail->ErrorInfo}";
}
