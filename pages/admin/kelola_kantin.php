<?php
if (isset($_GET['id_admin'])) {
    $id_admin = (int) $_GET['id_admin'];
}
require_once '../../middleware/role_auth.php';
require_role('Admin');

include "../../database/koneksi.php";
include "../../database/model.php";
include "register_penjual.php";

if (isset($_POST['submit'])) {
    $id_admin = $_POST['id_admin'];
    $nama= $_POST['nama'];
    $jabatan=$_POST['jabatan'];

    $hasil = updateInfoAdmin($koneksi, $id_admin, $nama, $jabatan);
    header("Location: profile_admin.php?id_admin=$id_admin");
    exit;
}
?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>Dashboard Admin - Manage Canteen</title>
</head>
<body class="min-h-screen flex flex-col">
  <?php include '../../partials/navbar-admin.php'; ?>

  <main class="w-[90%] max-w-6xl mx-auto mt-6 mb-6">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-3xl font-bold text-gray-800">Manage Canteen</h2>
      <div class="space-x-2">
        <label for="modal_register" class="btn bg-kuning text-white rounded-lg hover:bg-yellow-600 cursor-pointer">
          + Add Canteen
        </label>
      </div>
    </div>

    <?php
    $ambil_data_user = mysqli_query($koneksi, "SELECT * FROM user WHERE Role='penjual'");
    ?>

    <div class="overflow-x-auto bg-white border rounded-lg shadow mb-6">
      <?php if (mysqli_num_rows($ambil_data_user) == 0) : ?>
        <p class="text-center text-lg p-6 text-gray-600">Tidak ada data kantin yang ditemukan.</p>
      <?php else : ?>
        <table class="table w-full text-center">
          <thead class="bg-kuning text-white">
            <tr>
              <th class="p-3">No</th>
              <th class="p-3">Full Name</th>
              <th class="p-3">Username</th>
              <th class="p-3">Nama Kantin</th>
              <th class="p-3">Fakultas</th>
              <th class="p-3">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            while ($row_user = mysqli_fetch_assoc($ambil_data_user)) :
              $id_user_penjual = $row_user['id_user'];
              $ambil_fakultas = mysqli_query($koneksi, 
              "SELECT fakultas.nama_fakultas, fakultas.link, penjual.nama_kantin
               FROM penjual 
               JOIN fakultas ON penjual.id_fakultas = fakultas.id_fakultas 
               WHERE penjual.id_user = '$id_user_penjual'");
              $row_fakultas = mysqli_fetch_assoc($ambil_fakultas);

              $nama_fakultas = $row_fakultas['nama_fakultas'] ?? '-';
              $nama_kantin = $row_fakultas['nama_kantin'] ?? '-';
            ?>
              <tr class="hover:bg-gray-50">
                <td class="p-3"><?= $no ?></td>
                <td class="p-3"><?= htmlspecialchars($row_user['nama']) ?></td>
                <td class="p-3"><?= htmlspecialchars($row_user['username']) ?></td>
                <td class="p-3"><?= htmlspecialchars($nama_kantin) ?></td>
                <td class="p-3"><?= htmlspecialchars($nama_fakultas) ?></td>
                <td class="p-3 space-x-2">
                  <a
                    href="#"
                    class="btn btn-sm bg-red-500 rounded-lg text-white hover:bg-red-600 transition"
                    onclick="confirmDelete(<?= $row_user['id_user'] ?>, <?= $id_admin ?>)"
                  >
                    Delete
                  </a>

                  <a
                    href="#"
                    class="btn btn-sm bg-kuning rounded-lg text-white hover:bg-yellow-600 transition"
                    onclick="confirmAuthorization(<?= $row_user['id_user'] ?>, <?= $id_admin ?>)"
                  >
                    Authorization
                  </a>
                </td>
              </tr>
            <?php
              $no++;
            endwhile;
            ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </main>

  <script>
    function confirmDelete(id_user, id_admin) {
      Swal.fire({
        title: 'Are you sure?',
        text: "This canteen user will be deleted permanently!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e3342f',
        cancelButtonColor: '#FFB43B',
        confirmButtonText: 'Yes, delete it'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = `hapus-kantin.php?id_user=${id_user}&id_admin=${id_admin}`;
        }
      });
    }

    function confirmAuthorization(id_penjual, id_admin) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You are about to authorize this canteen user!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FFB43B',
        cancelButtonColor: '#e3342f',
        confirmButtonText: 'Yes, authorize'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = `edit-data-penjual.php?id_penjual=${id_penjual}&id_admin=${id_admin}`;
        }
      });
    }
  </script>
</body>
</html>
