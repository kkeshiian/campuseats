<?php
session_start();
include "../../database/koneksi.php";
include "../../database/model.php";

$error = '';
$success = '';

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === '' || $password === '') {
        $error = 'empty_fields';
    } else {
        $user = login($koneksi, $username, $password);

        if ($user) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['Role'] = $user['Role'];
            $_SESSION['nama'] = $user['nama'];

            if ($_SESSION['Role']=='penjual') {
                $id_user = $_SESSION['id_user'];
                $id_penjual_query = mysqli_query($koneksi, "SELECT id_penjual FROM penjual WHERE id_user ='$id_user'");

                if ($row = mysqli_fetch_assoc($id_penjual_query)) {
                    $id_penjual = $row['id_penjual'];
                    $_SESSION['id_penjual'] = $id_penjual;
                    header("Location: /campuseats/pages/penjual/dashboard.php?id_penjual=" . $id_penjual);
                    exit();
                }

            } elseif ($_SESSION['Role']=='pembeli') {
                $id_user = $_SESSION['id_user'];
                $id_pembeli_query = mysqli_query($koneksi, "SELECT id_pembeli FROM pembeli WHERE id_user ='$id_user'");

                if ($row = mysqli_fetch_assoc($id_pembeli_query)) {
                    $id_pembeli = $row['id_pembeli'];
                    $_SESSION['id_pembeli'] = $id_pembeli;
                    header("Location: /campuseats/pages/pembeli/canteen.php?id_pembeli=" . $id_pembeli);
                    exit();
                }
            } elseif ($_SESSION['Role']=='Admin') {
                $id_user = $_SESSION['id_user'];
                $id_admin_query = mysqli_query($koneksi, "SELECT id_admin FROM admin WHERE id_user ='$id_user'");

                if ($row = mysqli_fetch_assoc($id_admin_query)) {
                    $id_admin = $row['id_admin'];
                    $_SESSION['id_admin'] = $id_admin;
                    header("Location: /campuseats/pages/admin/dashboard.php?id_admin=" . $id_admin);
                    exit();
                }
            }
        } else {
            $error = 'wrong_credentials';
        }
    }

    if (isset($_GET['success']) && $_GET['success'] == 1) {
        $success = 'Anda berhasil registrasi, silakan login.';
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
      <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

      <form method="POST" class="space-y-4" id="loginForm">
        <div>
          <label class="label">Username</label>
          <input type="text" name="username" class="input input-bordered w-full rounded-lg" />
        </div>
        <div>
          <label class="label">Password</label>
          <input type="password" name="password" class="input input-bordered w-full rounded-lg" />
        </div>

        <button type="submit" name="submit" class="btn bg-kuning text-black w-full hover:bg-yellow-600 rounded-lg">
          Login
        </button>
      </form>

      <p class="mt-4 text-center text-sm text-gray-600">
        Belum punya akun? 
        <a href="register.php" class="text-yellow-600 hover:underline">Register</a>
      </p>
    </div>
  </div>

  <!-- Notyf JS -->
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <script>
    const notyf = new Notyf({
      duration: 3000,
      position: { x: 'right', y: 'top' },
      dismissible: false // no close button
    });

    <?php if ($error === 'wrong_credentials'): ?>
      notyf.error('Incorrect username or password!');
    <?php elseif ($error === 'empty_fields'): ?>
      notyf.error('Please fill in all fields!');
    <?php elseif ($success): ?>
      notyf.success('<?php echo addslashes($success); ?>');
    <?php endif; ?>
  </script>

</body>
</html>
