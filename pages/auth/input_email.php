<?php

include "../../database/koneksi.php";
include "../../database/model.php";

$error = '';
$success = '';

if (isset($_POST['submit'])) {
  $email_masuk = $_POST['email'];

  // cek email masuk atau ngga
  if ($email_masuk == '') {
    $error = 'empty_fields';
  }else{
    $cek_email = cekEmail($koneksi, $email_masuk);

    // cek email di database
    if ($cek_email===true) {
      // kalau email tercatat, terbang ke halaman verif code otp

      // ambil id_user dulu
      $cek_id_user = mysqli_query($koneksi, "SELECT id_user FROM user WHERE email = '$email_masuk'");
      $data_id_user = mysqli_fetch_assoc($cek_id_user);
      $id_user = $data_id_user['id_user'] ?? null;

      if ($id_user) {
        session_start(); 
        $_SESSION['id_user'] = $id_user;

        // Kirim OTP ke email yang dimasukin
        $kirim_otp = send_otp_for_reset($koneksi, $email_masuk);

        if ($kirim_otp) {
            header("Location: verif-otp-reset.php?success=true&id_user=" . $id_user);
            exit();
        } else {
            $error = "Failed to send OTP. Please try again.";
        }
      } else {
        $error = "User ID not found after registration.";
      }
    }else{
      $error = $cek_email;
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
    <div class="bg-white shadow-md rounded-xl p-8 w-full max-w-md m-4">
    <h2 class="text-2xl font-bold mb-2 text-center">Reset Your Password</h2>
    <p class="text-base mb-6 text-center text-gray-600">
    Enter your email address and we’ll send you a verification code.
    </p>

      <form method="POST" class="space-y-4">
        <div>
          <label class="label">Email</label>
          <input type="email" required name="email" class="input input-bordered w-full rounded-lg" />
        </div>

        <button type="submit" name="submit" class="btn bg-kuning text-black w-full hover:bg-yellow-600 rounded-lg">
          Send OTP Code
        </button>
      </form>
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

    if (successParam == 'true') {
      notyf.success('Registration successful! Please log in.');
      const url = new URL(window.location);
      url.searchParams.delete('success');
      window.history.replaceState({}, document.title, url.pathname);

    }

    <?php if ($error === 'wrong_credentials'): ?>
      notyf.error('Email not found or has never been used.');
    <?php elseif ($error === 'empty_fields'): ?>
      notyf.error('Please fill in all fields!');
    <?php elseif ($error === 'We couldn\'t find an account with that email address.'): ?>
      notyf.error('We couldn\'t find an account with that email address.');
    <?php elseif ($success): ?>
      notyf.success('<?php echo addslashes($success); ?>');
    <?php endif; ?>
  </script>

</body>
</html>
