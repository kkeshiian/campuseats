<?php
if (isset($_GET['id_penjual'])) {
    $id_per_penjual = (int) $_GET['id_penjual'];
} else {
    header("Location: /campuseats/pages/auth/logout.php");
    exit();
}

include "../../database/koneksi.php";
include "../../database/model.php";
require_once '../../middleware/role_auth.php';

require_role('penjual');

$ambil_data_kantin = mysqli_query($koneksi, "SELECT * FROM penjual WHERE id_penjual = '$id_per_penjual'");
$row_penjual =  mysqli_fetch_assoc($ambil_data_kantin);
?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <title>Manage Canteen</title>

  <!-- AOS -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

  <!-- Notyf -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
</head>
<body class="min-h-screen flex flex-col">
  <?php include '../../partials/navbar-penjual.php'; ?>
  <?php $gambar_kantin_default = "/campuseats/assets/img/default-canteen.jpg"; ?>

  <main class="w-[90%] mx-auto mt-6 max-w-5xl mb-4" data-aos="fade-up" data-aos-duration="1000">
    <h2 class="text-2xl font-bold mb-4">Manage Canteen</h2>

    <form action="proses_kelola_kantin.php" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded-lg shadow border border-black">
      <?php
      $ambil_data = mysqli_query($koneksi, "
          SELECT penjual.nama_kantin, penjual.link, penjual.gambar, fakultas.nama_fakultas, fakultas.id_fakultas 
          FROM penjual 
          JOIN fakultas ON penjual.id_fakultas = fakultas.id_fakultas 
          WHERE penjual.id_penjual='$id_per_penjual'");
      $data = mysqli_fetch_assoc($ambil_data);
      $queryFakultas = mysqli_query($koneksi, "SELECT id_fakultas, nama_fakultas FROM fakultas ORDER BY nama_fakultas ASC");
      $id_fakultas_terpilih = $data['id_fakultas'];
      ?>

      <div class="flex flex-col md:flex-row gap-6">
        <input type="hidden" name="id_penjual" value="<?= $id_per_penjual ?>" />

        <?php
        $src_gambar = "/campuseats/" . ($data['gambar'] ?: "/assets/img/default-canteen.jpg");
        ?>
        <img src="<?= htmlspecialchars($src_gambar) ?>" alt="Canteen Image" class="w-full md:w-64 h-64 object-cover rounded-lg border border-black" />

        <div class="flex flex-col md:flex-row gap-4 flex-1">
          <div class="flex-1">
            <div class="mb-4">
              <label class="block font-semibold mb-1">Canteen Name</label>
              <input type="text" name="nama_kantin" value="<?= htmlspecialchars($data['nama_kantin']) ?>" class="input input-bordered w-full" />
            </div>

            <div>
              <label class="block font-semibold mb-1">Location (Faculty)</label>
              <select name="id_fakultas" class="select select-bordered w-full">
                <option value="">-- Select Faculty --</option>
                <?php
                while ($fakultas = mysqli_fetch_assoc($queryFakultas)) {
                  $selected = ($fakultas['id_fakultas'] == $id_fakultas_terpilih) ? 'selected' : '';
                  echo "<option value='{$fakultas['id_fakultas']}' $selected>{$fakultas['nama_fakultas']}</option>";
                }
                ?>
              </select>
            </div>
          </div>

          <div class="flex-1">
            <div class="mb-4">
              <label class="block font-semibold mb-1">Canteen Location Link</label>
              <input type="text" name="link" value="<?= htmlspecialchars($data['link']) ?>" class="input input-bordered w-full" />
            </div>

            <div class="mb-4">
              <label class="block font-semibold mb-1">Canteen Photo</label>
              <input type="file" name="foto_kantin" accept="image/*" class="file-input file-input-bordered w-full" />
            </div>

            <div class="flex justify-end">
              <button type="submit" name="submit" class="btn bg-kuning text-white hover:bg-yellow-600">Save Changes</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </main>

  <script>
    AOS.init();

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

    // Show success message if redirected from proses_kelola_kantin.php
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === 'true') {
      notyf.success("Changes saved successfully!");
    }

    // Form validation
    document.querySelector("form").addEventListener("submit", function (e) {
      const namaKantin = document.querySelector("input[name='nama_kantin']").value.trim();
      const idFakultas = document.querySelector("select[name='id_fakultas']").value.trim();
      const link = document.querySelector("input[name='link']").value.trim();

      if (!namaKantin || !idFakultas || !link) {
        e.preventDefault(); // stop form submit
        notyf.error("Please fill in all required fields!");
      }
    });
  </script>
</body>
</html>
