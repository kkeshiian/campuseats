<!-- admin/dashboard.php -->
<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <title>Dashboard Admin</title>
</head>
<body class="min-h-screen flex flex-col">
  <?php include '../../partials/navbar-admin.php'; ?>

  <main class="w-[90%] mx-auto mt-6">
    <h2 class="text-2xl font-bold mb-6">Dashboard Admin</h2>

    <!-- Statistik -->
    <div class="grid grid-cols-2 md:grid-cols-2 gap-2 mb-2">
      <div class="bg-white border border-black rounded-lg p-4 text-center shadow">
        <h3 class="text-lg font-semibold">Total Pengguna</h3>
        <p class="text-2xl font-bold text-blue-600">120</p>
      </div>
      <div class="bg-white border border-black rounded-lg p-4 text-center shadow">
        <h3 class="text-lg font-semibold">Total Penjual</h3>
        <p class="text-2xl font-bold text-green-600">25</p>
      </div>
    </div>

    <!-- Navigasi Kelola -->
    <div class="grid grid-cols-2 md:grid-cols-2 gap-2">
      <a href="kelola_pengguna.php" class="bg-white border border-black rounded-lg p-4 text-center hover:bg-gray-100 transition">
        <h4 class="text-lg font-semibold mb-2">Kelola Pengguna</h4>
        <p class="text-gray-600 text-sm">Lihat dan atur data pembeli & penjual.</p>
      </a>
      <a href="kelola_kantin.php" class="bg-white border border-black rounded-lg p-4 text-center hover:bg-gray-100 transition">
        <h4 class="text-lg font-semibold mb-2">Kelola Kantin</h4>
        <p class="text-gray-600 text-sm">Tambah, edit, atau hapus data kantin.</p>
      </a>
    </div>
  </main>
</body>
</html>
