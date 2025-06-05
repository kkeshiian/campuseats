<?php
include "../../database/koneksi.php";
include "../../database/model.php";
$error = '';
$success = '';


if (isset($_POST['submit'])) {
    if ($_POST['password'] != $_POST['konfirmasi_password']) {
        $error = 'Password dan konfirmasi password tidak cocok.';
      } else {
        $nama_lengkap = $_POST['nama'];
        $username = $_POST['username'];
        $password = password_hash($_POST['konfirmasi_password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];

        $success = 'Anda berhasil melakukan registrasi, silahkan login terlebih dahulu!';

        $hasil = registrasi($koneksi, $nama_lengkap, $username, $password, $role);
        header("Location: login.php?success=1");
        exit();
    }
}  ?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
</head>

<body class="min-h-screen flex flex-col">
  <?php 
    $activePage = 'register';
    include '../../partials/navbar-belum-login.php'; 
  ?>

  <div class="flex justify-center items-center flex-1">
    <div class="bg-white shadow-md rounded-xl p-8 w-full max-w-md">
      <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>

      <?php if (!empty($error)): ?>
        <div role="alert" class="alert alert-error">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>


      <form method="POST" class="space-y-4">
        <div>
          <label class="label">Nama Lengkap</label>
          <input type="text" name="nama" class="input input-bordered w-full" required />
        </div>
        <div>
          <label class="label">Username</label>
          <input type="text" name="username" class="input input-bordered w-full" required />
        </div>
        <div>
          <label class="label">Password</label>
          <input type="password" name="password" class="input input-bordered w-full" required />
        </div>
        <div>
          <label class="label">Konfirmasi Password</label>
          <input type="password" name="konfirmasi_password" class="input input-bordered w-full" required />
        </div>
        <div>
          <label class="label">Daftar Sebagai</label>
          <select name="role" class="select select-bordered w-full" required>
            <option disabled selected>Pilih peran</option>
            <option value="pembeli">Pembeli</option>
            <option value="penjual">Penjual</option>
          </select>
        </div>

        <button type="submit" name="submit" class="btn bg-kuning text-black w-full hover:bg-yellow-600">
          Register
        </button>
      </form>

      <p class="mt-4 text-center text-sm text-gray-600">
        Sudah punya akun? 
        <a href="login.php" class="text-yellow-600 hover:underline">Login</a>
      </p>
    </div>
  </div>
</body>
</html>


