<?php
if (isset($_GET['id_admin'])) {
    $id_admin = (int) $_GET['id_admin'];
}
require_once '../../middleware/role_auth.php';

require_role('Admin');

include "../../database/koneksi.php";
include "../../database/model.php";
?>

<!-- admin/dashboard.php -->
<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />

  <!-- jquery wajib untuk notify.js -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>

  <title>Dashboard Admin</title>
</head>
<body class="min-h-screen flex flex-col">
  <?php include '../../partials/navbar-admin.php'; ?>

  <main class="w-[90%] mx-auto mt-6">
    <h2 class="text-2xl font-bold mb-6">Dashboard Admin</h2>
    <?php
    $ambil_data_admin = mysqli_query($koneksi, 
    "SELECT * FROM admin WHERE id_admin='$id_admin'");
    $row_admin = mysqli_fetch_assoc($ambil_data_admin);


    $ambil_data_user = mysqli_query($koneksi, 
        "SELECT Role, COUNT(*) AS jumlah
        FROM user
        GROUP BY Role;");

    $role_counts = [
        'admin' => 0,
        'penjual' => 0,
        'pembeli' => 0
    ];

    while ($row = mysqli_fetch_assoc($ambil_data_user)) {
        $role = strtolower($row['Role']); // antisipasi huruf kapital
        $role_counts[$role] = $row['jumlah'];
    }
    ?>
    <!-- profile admin -->
    <div class="max-w-md mx-auto mb-10">
      <div class="w-full mb-10 px-4">
        <div class="bg-white border border-black rounded-xl p-6 shadow-lg text-center w-full">
          <p class="text-lg mb-2">
            Admin Name: <span class="font-medium"><?= htmlspecialchars($row_admin['nama']) ?></span>
          </p>
          <p class="text-lg mb-6">
            Role: <span class="font-medium"><?= htmlspecialchars($row_admin['jabatan']) ?></span>
          </p>
          <a href="profile_admin.php?id_admin=<?= urlencode($id_admin) ?>">
            <button
              class="btn bg-kuning hover:bg-yellow-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition duration-300 ease-in-out w-full"
              type="button"
            >
              Edit Profile
            </button>
          </a>
        </div>
      </div>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-2 md:grid-cols-2 gap-2 mb-2">
      <div class="bg-white border border-black rounded-lg p-4 text-center shadow">
        <h3 class="text-lg font-semibold">Total Active Users</h3>
        <p class="text-2xl font-bold text-kuning"><?= $role_counts['pembeli'] ?></p>
      </div>
      <div class="bg-white border border-black rounded-lg p-4 text-center shadow">
        <h3 class="text-lg font-semibold">Total Active Sellers</h3>
        <p class="text-2xl font-bold text-kuning"><?= $role_counts['penjual'] ?></p>
      </div>
    </div>

    <!-- Navigasi Kelola -->
    <div class="grid grid-cols-2 md:grid-cols-2 gap-2">
      <!-- kelola pengguna -->
      <a href='kelola_pengguna.php?id_admin=<?= $id_admin ?>' class="bg-white border border-black rounded-lg p-4 text-center hover:bg-gray-100 transition">
        <h4 class="text-lg font-semibold mb-2">Manage CampusEats's User</h4>
        <p class="text-gray-600 text-sm">Look and delete Campuseats's User data.</p>
      </a>
      <!-- kelola kantin -->
      <a href="kelola_kantin.php?id_admin=<?= $id_admin ?>" class="bg-white border border-black rounded-lg p-4 text-center hover:bg-gray-100 transition">
        <h4 class="text-lg font-semibold mb-2">Manage Campuseats's Canteen</h4>
        <p class="text-gray-600 text-sm">Add, edit, and delete Campuseats's Canteen data.</p>
      </a>
    </div>
  </main>

  <script>
  const notyf = new Notyf({
    duration: 3000,
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
