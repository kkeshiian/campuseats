<?php
session_start();
include "../../database/koneksi.php";
include "../../database/model.php";

$error = '';
$success = '';

$id_user = $_SESSION['id_user'] ?? $_GET['id_user'] ?? null;

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
    $password = $_POST['password'] ?? '';
    $konfirmasi_password = $_POST['konfirmasi_password'] ?? '';

    if ($password != $konfirmasi_password) {
        $error = 'Password and confirmation do not match.';
    }else{
        $result=changePassword($koneksi, $konfirmasi_password, $id_user);

        if ($result===true) {
            header("Location: login.php?reset=true");
            exit();
        }else{
            $error = "Failed to change your password!";
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
    Enter your new password here!
    </p>

      <form method="POST" class="space-y-4">
        <div>
          <label class="label">New Password</label>
          <input type="password" required name="password" class="input input-bordered w-full rounded-lg" />
        </div>
        <div>
          <label class="label">Confirmation Your New Password</label>
          <input type="password" required name="konfirmasi_password" class="input input-bordered w-full rounded-lg" />
        </div>

        <button type="submit" name="submit" class="btn bg-kuning text-black w-full hover:bg-yellow-600 rounded-lg">
          Set your new password
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
      notyf.success('Reset your password.');
      const url = new URL(window.location);
      url.searchParams.delete('success');
      window.history.replaceState({}, document.title, url.pathname);

    }
    <?php if (!empty($error)): ?>
    notyf.error(<?= json_encode($error) ?>);
    <?php elseif (!empty($success)): ?>
    notyf.success(<?= json_encode($success) ?>);
    <?php endif; ?>

  </script>

</body>
</html>
