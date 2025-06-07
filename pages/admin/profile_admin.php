<?php
if (!isset($_GET['id_admin'])) {
    // Redirect jika id_admin tidak ada
    header("Location: dashboard.php");
    exit;
}

$id_admin = (int) $_GET['id_admin'];

require_once '../../middleware/role_auth.php';
require_role('Admin');

include "../../database/koneksi.php";
include "../../database/model.php";

if (isset($_POST['submit'])) {
    // Sanitasi input sebelum update
    $id_admin = (int) $_POST['id_admin'];
    $nama = trim($_POST['nama']);
    $jabatan = trim($_POST['jabatan']);

    // Validasi minimal sederhana (boleh kamu tambah validasi lain)
    if ($nama !== '' && $jabatan !== '') {
        $hasil = updateInfoAdmin($koneksi, $id_admin, $nama, $jabatan);
          header("Location: dashboard.php?id_admin=$id_admin");
        exit;
    } else {
        $error = "Nama dan Jabatan harus diisi.";
    }
}

// Ambil data admin untuk ditampilkan di form
$ambil_data_admin = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin='$id_admin'");
$row_admin = mysqli_fetch_assoc($ambil_data_admin);

?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <title>Profile Admin</title>
</head>
<body class="min-h-screen flex flex-col">
  <?php include '../../partials/navbar-admin.php'; ?>

  <main class="w-full max-w-3xl mx-auto mt-8 px-4">
    <h2 class="text-2xl font-bold mb-6">Edit Admin Profile</h2>

    <?php if (!empty($error)) : ?>
      <div class="mb-4 p-4 bg-red-100 text-red-700 rounded border border-red-400">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_GET['success']) && $_GET['success'] == 1) : ?>
      <div class="mb-4 p-4 bg-green-100 text-green-700 rounded border border-green-400">
        Profil berhasil diperbarui.
      </div>
    <?php endif; ?>

    <form method="POST" class=" bg-white p-6 rounded-xl shadow-md border border-black">
        <input type="hidden" name="id_admin" value="<?= $id_admin ?>" />

        <!-- Admin Name -->
        <div class="mb-4">
          <label for="nama" class="block font-semibold mb-2 text-gray-700">Nama Admin</label>
          <input
            type="text"
            id="nama"
            name="nama"
            value="<?= htmlspecialchars($row_admin['nama']) ?>"
            class="input input-bordered w-full border-gray-300 rounded-md focus:ring-yellow-400 focus:border-yellow-400"
            required
          />
        </div>

        <!-- Jabatan -->
        <div class="mb-4">
          <label for="jabatan" class="block font-semibold mb-2 text-gray-700">Jabatan</label>
          <input
            type="text"
            id="jabatan"
            name="jabatan"
            value="<?= htmlspecialchars($row_admin['jabatan']) ?>"
            class="input input-bordered w-full border-gray-300 rounded-md focus:ring-yellow-400 focus:border-yellow-400"
            required
          />
        </div>

        <!-- Buttons -->
        <div class="flex justify-end">
          <button
            type="submit"
            name="submit"
            class="btn bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-2 rounded-lg transition"
          >
            Save Changes
          </button>
        </div>
    </form>
  </main>
</body>
</html>
