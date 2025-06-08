<?php
if (isset($_GET['id_penjual'])) {
    $id_per_penjual = (int) $_GET['id_penjual'];
}else{
  header("Location: /campuseats/pages/auth/logout.php");
  exit();
}
require_once '../../middleware/role_auth.php';

require_role('penjual');
?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/campuseats/dist/output.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
    <!-- Notyf -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <title>CampusEats!</title>
  </head>
  <body class="min-h-screen flex flex-col">
    <?php include '../../partials/navbar-penjual.php'; ?>

    <main class="w-[90%] mx-auto mt-6 max-w-xl">
      <h2 class="text-2xl font-bold mb-4 text-center">Add New Menu</h2>

      <form action="proses_tambah_menu.php" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded-lg shadow border" id="menuForm">
        <input type="hidden" name="id_penjual" value="<?= $id_per_penjual ?>" />
        <!-- Nama Menu -->
        <div>
          <label class="block font-semibold mb-1">Menu Name</label>
          <input type="text" name="nama" class="input input-bordered w-full" />
        </div>

        <!-- Harga -->
        <div>
          <label class="block font-semibold mb-1">Price (Rp)</label>
          <input type="number" name="harga" class="input input-bordered w-full" min="0" />
        </div>

        <!-- Upload Gambar -->
        <div>
          <label class="block font-semibold mb-1">Menu Picture</label>
          <input type="file" name="gambar" accept="image/*" class="file-input file-input-bordered w-full" />
        </div>

        <!-- Tombol Simpan -->
        <div class="flex justify-end">
          <button type="submit" name="submit" class="btn bg-kuning text-white hover:bg-yellow-600">Add Menu</button>
        </div>
      </form>
    </main>

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

    // Show success message if redirected with success=1
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === 'true') {
      notyf.success("Changes saved successfully!");
    }

    // Custom form validation on submit
    document.getElementById("menuForm").addEventListener("submit", function (e) {
      const nama = this.querySelector("input[name='nama']").value.trim();
      const harga = this.querySelector("input[name='harga']").value.trim();
      const gambar = this.querySelector("input[name='gambar']").files;

      if (!nama || !harga || harga < 0 || gambar.length === 0) {
        e.preventDefault();
        notyf.error("Please fill in all required fields!");
      }
    });
    </script>
  </body>
</html>
