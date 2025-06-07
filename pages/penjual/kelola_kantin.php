<?php
if (isset($_GET['id_penjual'])) {
    $id_per_penjual = (int) $_GET['id_penjual'];
}

include "../../database/koneksi.php";
include "../../database/model.php";

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
    <title>Manage Canteen</title>
  </head>
  <body class="min-h-screen flex flex-col">
    <?php include '../../partials/navbar-penjual.php'; ?>

    <main class="w-[90%] mx-auto mt-6 max-w-2xl">
      <h2 class="text-2xl font-bold mb-4">Manage Canteen</h2>

      <form action="proses_kelola_kantin.php" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded-lg shadow border">
        <input type="hidden" name="id_penjual" value="<?= $id_per_penjual ?>" />  
        <!-- Canteen Name -->
         <?php
         $ambil_data = mysqli_query($koneksi, "
         SELECT penjual.nama_kantin, penjual.link, penjual.gambar, fakultas.nama_fakultas, fakultas.id_fakultas FROM penjual JOIN fakultas
         ON penjual.id_fakultas = fakultas.id_fakultas WHERE penjual.id_penjual='$id_per_penjual'");
         $data = mysqli_fetch_assoc($ambil_data);

         $queryFakultas = mysqli_query($koneksi, "SELECT id_fakultas, nama_fakultas FROM fakultas ORDER BY nama_fakultas ASC");

        
        $id_fakultas_terpilih = $data['id_fakultas'];
         ?>
        <div>
          <label class="block font-semibold mb-1">Canteen Name</label>
          <input type="text" name="nama_kantin" value="<?= htmlspecialchars($data['nama_kantin']) ?>" class="input input-bordered w-full" required />
        </div>

        <!-- Location -->
        <div>
          <label class="block font-semibold mb-1">Location (Fakultas)</label>
            <select name="id_fakultas" class="select select-bordered w-full" required>
              <option value="">-- Pilih Fakultas --</option>
              <?php
              while ($fakultas = mysqli_fetch_assoc($queryFakultas)) {
                  $selected = ($fakultas['id_fakultas'] == $id_fakultas_terpilih) ? 'selected' : '';
                  echo "<option value='{$fakultas['id_fakultas']}' $selected>{$fakultas['nama_fakultas']}</option>";
              }
              ?>
            </select>
        </div>

        <!-- Link Maps -->
        <div>
          <div>
            <label class="block font-semibold mb-1">Link Maps</label>
            <input type="text" name="link" value="<?= htmlspecialchars($data['link']) ?>" class="input input-bordered w-full" required />
          </div>
        </div>

        <!-- Upload Canteen Photo -->
        <div>
          <label class="block font-semibold mb-1">Canteen Photo</label>
          <input type="file" name="foto_kantin" accept="image/*" class="file-input file-input-bordered w-full" />
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
          <button type="submit" name="submit" class="btn bg-kuning text-white hover:bg-yellow-600">Save Changes</button>
        </div>
      </form>
    </main>
  </body>
</html>
