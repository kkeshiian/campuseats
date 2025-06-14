<?php
session_start();
include "../../database/koneksi.php";
include "../../database/model.php";

$error = '';
$success = '';

$id_user = $_SESSION['id_user'] ?? null;

if (isset($_POST['submit'])) {
    $kode_otp_masuk = $_POST['otp'];
    $result = verification_account($koneksi, $kode_otp_masuk, $id_user);

    if ($result) {
    $success = "Account successfully verified!";
    header("Location: login.php?success=true");
    exit();
    } else {
        $error = "wrong_credentials";
    }
}


if (isset($_GET['resend']) && $id_user) {
    $query_user = mysqli_query($koneksi, "SELECT nama, email FROM user WHERE id_user='$id_user'");
    $user_data = mysqli_fetch_assoc($query_user);

    if ($user_data) {
        $nama_user = $user_data['nama'];
        $email_user = $user_data['email'];

        $otp_result = resend_otp($koneksi, $id_user, $nama_user, $email_user);

        if ($otp_result) {
            header("Location: verif-otp.php?resent=success");
            exit();
        } else {
            header("Location: verif-otp.php?resent=failed");
            exit();
        }

    }
}



?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />

  <!-- Notyf CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
</head>
<body class="min-h-screen flex flex-col">
  <?php 
    $activePage = 'login';
    include '../../partials/navbar-belum-login.php'; 
  ?>
    
  <div class="flex justify-center items-center flex-1">
    <div class="bg-white shadow-md rounded-xl p-8 w-full max-w-xl m-4">
      <h2 class="text-2xl font-bold mb-2 text-center">Verification OTP Code</h2>
      <h5 class="text-lg mb-6 text-center">We have sent an OTP code to your email. Please check your inbox and enter the code below.</h5>
    <form method="POST" class="space-y-6" id="otpForm">
        <h3 class="text-2xl font-bold text-center">OTP Code</h3>

    <div class="w-full flex justify-center">
    <input
        type="text"
        name="otp"
        maxlength="8"
        pattern="[0-9A-Z]{8}"
        inputmode="text"
        class="w-40 h-14 text-center text-2xl p-2 tracking-widest border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 uppercase"
        placeholder="--------"
        required
    />
    </div>
        <button
            type="submit"
            name="submit"
            class="btn bg-kuning w-full flex justify-center text-black w-40 hover:bg-yellow-600 rounded-lg"
        >
            Verify
        </button>
    </form>
    <p class="mt-4 text-center text-sm text-gray-600">
        Did not receive the code?
        <a href="verif-otp.php?resend=true" class="text-yellow-600 hover:underline">Resend OTP</a>
    </p>
    </div>
  </div>

  <!-- Notyf JS -->
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <script>
    const notyf = new Notyf({
    duration: 2000,
    position: {
      x: 'right',
      y: 'top',
    },
    types: [
      {
        type: 'success',
        background: '#FFB43B',
        icon: {
          className: 'notyf__icon--success',
          tagName: 'i',
        }
      },
      {
        type: 'error',
        background: '#d63031',
        icon: {
          className: 'notyf__icon--error',
          tagName: 'i',
        }
      }
    ]
  });

        const urlParams = new URLSearchParams(window.location.search);
        const successParam = urlParams.get('success');
        const resentParam = urlParams.get('resent');

        if (successParam === 'true') {
            notyf.success('Registration successful! Please verify your account.');
        }

        if (resentParam === 'success') {
            notyf.success('OTP has been resent!');
        }

        if (resentParam === 'failed') {
            notyf.error('Failed to resend OTP. Please try again.');
        }

        urlParams.delete('success');
        urlParams.delete('resent');
        const newUrl = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
        window.history.replaceState({}, document.title, newUrl);

        <?php if ($error === 'wrong_credentials'): ?>
            notyf.error('Incorrect OTP Code!');
        <?php elseif ($error === 'empty_fields'): ?>
            notyf.error('Please fill in all fields!');
        <?php endif; ?>

  </script>

</body>
</html>

