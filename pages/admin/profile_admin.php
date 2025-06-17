<?php
if (!isset($_GET['id_admin'])) {
    header("Location: dashboard.php");
    exit;
}

$id_admin = (int) $_GET['id_admin'];

require_once '../../middleware/role_auth.php';
require_role('Admin');

include "../../database/koneksi.php";
include "../../database/model.php";

if (isset($_POST['submit'])) {
    $id_admin = (int) $_POST['id_admin'];
    $nama = trim($_POST['nama']);
    $jabatan = trim($_POST['jabatan']);

    if ($nama !== '' && $jabatan !== '') {
    $hasil = updateInfoAdmin($koneksi, $id_admin, $nama, $jabatan);
    // Redirect ke dashboard dengan success
    header("Location: dashboard.php?id_admin=$id_admin&success=true");
    exit;
    } else {
        // Redirect ke halaman ini dengan parameter error
        header("Location: profile_admin.php?id_admin=$id_admin&error=error");
        exit;
    }
}

// Ambil data admin dari DB
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

  <!-- Notyf CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
  <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

  <title>Profile Admin</title>
</head>
<body class="min-h-screen flex flex-col">
  <?php $activePage = 'dashboard';
  include '../../partials/navbar-admin.php'; ?>

  <main class="w-full max-w-3xl mx-auto mt-8 px-4">
    <h2 class="text-2xl font-bold mb-6">Edit Admin Profile</h2>

    <form method="POST" class="bg-white p-6 rounded-xl shadow-md border border-black" novalidate>
      <input type="hidden" name="id_admin" value="<?= htmlspecialchars($id_admin) ?>" />

      <!-- Admin Name -->
      <div class="mb-4">
        <label for="nama" class="block font-semibold mb-2 text-gray-700">Nama Admin</label>
        <input
          type="text"
          id="nama"
          name="nama"
          value="<?= htmlspecialchars($row_admin['nama']) ?>"
          class="input input-bordered w-full border-gray-300 rounded-md focus:ring-yellow-400 focus:border-yellow-400"
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

  <!-- Notyf Toast Script -->
  <script>
    const notyf = new Notyf({
      duration: 2000,
      position: { x: 'right', y: 'top' },
      types: [
        {
          type: 'success',
          background: '#FFB43B',
          icon: { className: 'notyf__icon--success', tagName: 'i' }
        },
        {
          type: 'error',
          background: '#d63031',
          icon: { className: 'notyf__icon--error', tagName: 'i' }
        }
      ]
    });

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === 'true') {
      notyf.success("Profile updated successfully!");
    }
    if (urlParams.get('error') === 'error') {
      notyf.error("Name and Position must be filled in!");
    }
  </script>
</body>
</html>
