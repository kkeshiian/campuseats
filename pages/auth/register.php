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
    $password = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    if ($password !== $konfirmasi_password) {
        $error = 'Password and confirmation do not match.';
    } else {
        $valid_pass = validate_password($password);
        if ($valid_pass !== true) {
            $error = $valid_pass;
        } else {
            $nama_lengkap = trim($_POST['nama']);
            $username = trim($_POST['username']);
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $role = $_POST['role'] ?? 'pembeli';

            $hasil = registrasi($koneksi, $nama_lengkap, $username, $password_hash, $role);

            if ($hasil) {
                // Redirect with success flag
                header("Location: login.php?success=1");
                exit();
            } else {
                $error = "Registration failed, username might already be taken.";
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
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
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
          <input id="nama" type="text" name="nama" class="input input-bordered w-full" required value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '' ?>" />
        </div>
        <div>
          <label class="label" for="username">Username</label>
          <input id="username" type="text" name="username" class="input input-bordered w-full" required value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" />
        </div>
        <div>
          <label class="label" for="password">Password</label>
          <input id="password" type="password" name="password" class="input input-bordered w-full" required />
          <p class="text-gray-500 mt-1 text-xs leading-snug">
            Password must be at least 8 characters, include uppercase, lowercase, a number,<br />
            and a special symbol (e.g., !@#$%^&*).
          </p>
        </div>
        <div>
          <label class="label" for="konfirmasi_password">Confirm Password</label>
          <input id="konfirmasi_password" type="password" name="konfirmasi_password" class="input input-bordered w-full" required />
        </div>

        <button type="submit" name="submit" class="btn bg-kuning text-black w-full hover:bg-yellow-600">
          Register
        </button>
      </form>

      <p class="mt-4 text-center text-sm text-gray-600">
        Already have an account? 
        <a href="login.php" class="text-yellow-600 hover:underline">Login</a>
      </p>
    </div>
  </div>

  <!-- Toast container, fixed top right -->
  <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2" data-aos="fade-left" data-aos-duration="500"></div>

  <script>
    // Function to create and show toast
    function showToast(message, type = 'error') {
      const container = document.getElementById('toast-container');

      const toast = document.createElement('div');
      toast.className = `alert shadow-lg ${type === 'error' ? 'alert-error' : 'alert-success'}`;
      toast.innerHTML = `
        <div>
          <span class="text-white">${message}</span>
        </div>
        <button class="btn btn-sm btn-ghost" aria-label="Close">&times;</button>
      `;

      container.appendChild(toast);

      // Close button functionality
      toast.querySelector('button').addEventListener('click', () => {
        toast.remove();
      });

      // Auto-remove after 5 seconds
      setTimeout(() => {
        toast.remove();
      }, 3000);
    }

    <?php if (!empty($error)): ?>
      showToast(<?= json_encode($error) ?>, 'error');
    <?php endif; ?>
  </script>

  <script>
  AOS.init({
  });
</script>
</body>
</html>
