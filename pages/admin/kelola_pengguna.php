<?php
if (isset($_GET['id_admin'])) {
    $id_admin = (int) $_GET['id_admin'];
}
require_once '../../middleware/role_auth.php';
require_role('Admin');

include "../../database/koneksi.php";
include "../../database/model.php";

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
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Notyf CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <title>Dashboard Admin - Manage User</title>
</head>
<body class="min-h-screen flex flex-col">
  <?php
  $activePage = 'kelola_pengguna';
  include '../../partials/navbar-admin.php'; ?>

  <main class="w-[90%] max-w-5xl mx-auto mt-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
      <h2 class="text-2xl sm:text-3xl font-bold text-black">Manage User</h2>
    </div>

  <?php
  $ambil_data_user = mysqli_query($koneksi, "SELECT * FROM user WHERE Role='pembeli'");
  ?>

  <div class="overflow-x-auto bg-white border rounded-lg shadow">
    <?php if (mysqli_num_rows($ambil_data_user) == 0) : ?>
      <p class="text-center text-lg p-6 text-gray-600">No user data found.</p>
    <?php else : ?>
      <table class="table w-full text-sm sm:text-base text-center">
        <thead class="bg-kuning text-white">
          <tr>
            <th class="p-2 sm:p-3">No</th>
            <th class="p-2 sm:p-3">Full Name</th>
            <th class="p-2 sm:p-3">Username</th>
            <th class="p-2 sm:p-3">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          while ($row_user = mysqli_fetch_assoc($ambil_data_user)) :
          ?>
            <tr class="hover:bg-gray-50">
              <td class="p-2 sm:p-3"><?= $no ?></td>
              <td class="p-2 sm:p-3"><?= htmlspecialchars($row_user['nama']) ?></td>
              <td class="p-2 sm:p-3"><?= htmlspecialchars($row_user['username']) ?></td>
              <td class="p-2 sm:p-3 flex flex-col sm:flex-row justify-center items-center gap-2">
                <a
                  class="btn btn-sm bg-kuning text-white hover:bg-yellow-600 transition rounded-lg"
                  onclick="confirmAuthorization(<?= $row_user['id_user'] ?>, <?= $id_admin ?>)">
                  Authorization
                </a>
                <a
                  class="btn btn-sm bg-red-500 text-white hover:bg-red-600 transition rounded-lg"
                  onclick="confirmDelete(<?= $row_user['id_user'] ?>, <?= $id_admin ?>)">
                  Delete
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
  function confirmAuthorization(id_pembeli, id_admin) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You are about to authorize this user!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#FFB43B', // kuning
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, authorize'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = `edit-data-pembeli.php?id_pembeli=${id_pembeli}&id_admin=${id_admin}`;
      }
    });
  }

  function confirmDelete(id_pembeli, id_admin) {
    Swal.fire({
      title: 'Are you sure?',
      text: "This action cannot be undone. The user will be deleted permanently.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#e3342f', // merah
      cancelButtonColor: '#FFB43B',
      confirmButtonText: 'Yes, delete'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = `hapus-pembeli.php?id_pembeli=${id_pembeli}&id_admin=${id_admin}`;
      }
    });
  }
</script>

<script>
    const notyf = new Notyf({
      duration: 3000,
      position: { x: 'right', y: 'top' },
      types: [
        {
          type: 'success',
          background: '#28a745',
          icon: { className: 'notyf__icon--success', tagName: 'i' }
        }
      ]
    });

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === 'true') {
      notyf.success('User data updated successfully!');
      history.replaceState(null, '', window.location.pathname);
    }
  </script>
</body>
</html>