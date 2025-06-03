<?php
require_once '../../middleware/role_auth.php';

// Pastikan user sudah login dan role-nya penjual
require_role('penjual');
?>


<!DOCTYPE html>
<html data-theme="light" class="bg-background">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/campuseats/dist/output.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
    <title>Kelola Kantin</title>
  </head>
  <body class="min-h-screen flex flex-col">
    <?php include '../../partials/navbar-penjual.php'; ?>

    <main class="w-[90%] mx-auto mt-6">
      <h2 class="text-2xl font-bold mb-4">Kelola Informasi Kantin</h2>

      <!-- Informasi Kantin -->
      <?php
      // Contoh data kantin
      $kantin = [
        "id" => 1,
        "nama" => "Kantin Teknik",
        "fakultas" => "Fakultas Teknik",
        "deskripsi" => "Kantin yang menyediakan makanan dan minuman murah dan enak.",
        "gambar" => "/campuseats/assets/img/kantin-teknik.jpg"
      ];
      ?>

      <div class="bg-white border border-black rounded-lg p-6">
        <div class="flex flex-col md:flex-row items-start md:items-center mb-6">
          <img src="<?= $kantin['gambar']; ?>" alt="Foto Kantin" class="w-32 h-32 rounded-lg object-cover mr-6 mb-4 md:mb-0" />
          <div>
            <h3 class="text-2xl font-semibold"><?= $kantin['nama']; ?></h3>
            <p class="text-gray-600"><?= $kantin['fakultas']; ?></p>
            <p class="mt-2"><?= $kantin['deskripsi']; ?></p>
          </div>
        </div>
        <a href="edit-kantin.php?id=<?= $kantin['id']; ?>" class="btn bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600">
          Edit Informasi Kantin
        </a>
      </div>
    </main>
  </body>
</html>