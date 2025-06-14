<?php
include "../../database/koneksi.php";
include "../../database/model.php";

$error = '';
$success = '';

function validate_password($password) {
    if (strlen($password) < 8) {
        return "Password must be at least 8 characters.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        return "Password must contain at least one uppercase letter.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        return "Password must contain at least one lowercase letter.";
    }
    if (!preg_match('/[0-9]/', $password)) {
        return "Password must contain at least one number.";
    }
    if (!preg_match('/[\W_]/', $password)) {
        return "Password must contain at least one special character (e.g., !@#$%^&*).";
    }
    return true;
}

if (isset($_POST['submit'])) {
    $nama_lengkap = trim($_POST['nama'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $konfirmasi_password = $_POST['konfirmasi_password'] ?? '';
    $email = $_POST['email'] ?? '';
    $nomor_wa = $_POST['nomor_wa'] ?? '';

    if ($nama_lengkap === '' || $username === '' || $password === '' || $konfirmasi_password === '' || $email === '' || $nomor_wa === '') {
        $error = 'Please fill in all fields.';
    } else if ($password !== $konfirmasi_password) {
        $error = 'Password and confirmation do not match.';
    } else {
        $valid_pass = validate_password($password);
        if ($valid_pass !== true) {
            $error = $valid_pass;
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $role = $_POST['role'] ?? 'pembeli';

            $hasil = registrasi($koneksi, $nama_lengkap, $username, $password_hash, $role, $email, 
            $nomor_wa);

            if ($hasil===true) {
                // Ambil id_user setelah berhasil registrasi
                $cek_id_user = mysqli_query($koneksi, "SELECT id_user FROM user WHERE email = '$email'");
                $data_id_user = mysqli_fetch_assoc($cek_id_user);
                $id_user = $data_id_user['id_user'] ?? null;

                if ($id_user) {
                    session_start(); 
                    $_SESSION['id_user'] = $id_user;

                    // Kirim OTP
                    $kirim_otp = verif_otp($koneksi, $nama_lengkap, $email);

                    if ($kirim_otp) {
                        header("Location: verif-otp.php?success=true&id_user=" . $id_user);
                        exit();
                    } else {
                        $error = "Failed to send OTP. Please try again.";
                    }
                } else {
                    $error = "User ID not found after registration.";
                }
            } else {
              // menyesuaikan sesuai dengan errornya apa dari mysqlinya 
              $error = $hasil;
            }
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
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  
  <!-- Notyf CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
</head>

<body class="min-h-screen flex flex-col relative">
  <?php 
    $activePage = 'register';
    include '../../partials/navbar-belum-login.php'; 
  ?>

  <div class="flex justify-center items-center flex-1">
    <div class="bg-white shadow-md rounded-xl p-8 w-full max-w-md">
      <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>

      <form method="POST" class="space-y-4" novalidate>
        <div>
          <label class="label" for="nama">Full Name</label>
          <input id="nama" type="text" name="nama" class="input input-bordered w-full rounded-lg" value="<?= htmlspecialchars($nama_lengkap ?? '') ?>" />
        </div>
        <div>
          <label class="label" for="nama">Email</label>
          <input id="email" type="email" name="email" class="input input-bordered w-full rounded-lg" value="<?= htmlspecialchars($email ?? '') ?>" />
        </div>
        <div>
          <label class="label" for="username">Username</label>
          <input id="username" type="text" name="username" class="input input-bordered w-full rounded-lg" value="<?= htmlspecialchars($username ?? '') ?>" />
        </div>
        <div>
          <label class="label" for="nama">Whatsapp Number</label>
          <input id="number" type="text" name="nomor_wa" class="input input-bordered w-full rounded-lg" value="<?= htmlspecialchars($nomor_wa ?? '') ?>" />
        </div>
        <div>
          <label class="label" for="password">Password</label>
          <input id="password" type="password" name="password" class="input input-bordered w-full rounded-lg" />
          <p class="text-gray-500 mt-1 text-xs leading-snug">
            Password must be at least 8 characters, include uppercase, lowercase, a number,
            and a special symbol (e.g., !@#$%^&*).
          </p>
        </div>
        <div>
          <label class="label" for="konfirmasi_password">Confirm Password</label>
          <input id="konfirmasi_password" type="password" name="konfirmasi_password" class="input input-bordered w-full rounded-lg" />
        </div>

        <button type="submit" name="submit" class="btn bg-kuning text-black w-full hover:bg-yellow-600 rounded-lg">
          Register
        </button>
      </form>

      <p class="mt-4 text-center text-sm text-gray-600">
        Already have an account? 
        <a href="login.php" class="text-yellow-600 hover:underline">Login</a>
      </p>
    </div>
  </div>

  <!-- Notyf JS -->
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <script>
    const notyf = new Notyf({
      duration: 3000,
      position: { x: 'right', y: 'top' },
      dismissible: true
    });

    <?php if (isset($error) && !empty($error)): ?>
      notyf.error(<?= json_encode(htmlspecialchars($error, ENT_QUOTES, 'UTF-8')) ?>);
    <?php endif; ?>
  </script>


  <script>
    AOS.init();
  </script>
</body>
</html>
