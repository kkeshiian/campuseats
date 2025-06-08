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
?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <!-- Notyf -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <title>Kelola Menu</title>
</head>
<body class="min-h-screen flex flex-col">
  <?php include '../../partials/navbar-penjual.php'; ?>

  <main class="w-[90%] mx-auto mt-6" data-aos="fade-up" data-aos-duration="1000">
    <div class="flex justify-between items-center">
      <h2 class="text-2xl font-bold mb-4" data-aos="fade-right" data-aos-duration="1000">Manage Menu</h2>
      <!-- Tombol Tambah Menu -->
      <div class="mb-6">
        <a href="tambah-menu.php?id_penjual=<?= $id_per_penjual ?>" class="btn bg-kuning text-white font-semibold rounded-lg px-4 py-2 hover:bg-yellow-600">
          + Add Menu
        </a>
      </div>
    </div>

    <!-- Tabel Daftar Menu -->
    <div class="overflow-x-auto bg-white rounded-lg shadow border border-black">
      <?php
      $ambil_data_menu = mysqli_query($koneksi, "SELECT id_menu, nama_menu AS menu, harga FROM menu WHERE id_penjual = '$id_per_penjual'");

      if (mysqli_num_rows($ambil_data_menu) == 0) {
        echo "<p class='text-base mx-auto m-4 text-center text-gray-500 '>No menu has been added yet</p>";
      } else {
        echo "
          <table class='table w-full text-center'>
            <thead class='bg-kuning text-white'>
              <tr>
                <th>No</th>
                <th>Menu Name</th>
                <th>Price</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
        ";

        $no = 1;
        while ($menu = mysqli_fetch_assoc($ambil_data_menu)) {
          $harga = number_format($menu['harga'], 0, ',', '.');
          echo "
            <tr>
              <td>$no</td>
              <td>{$menu['menu']}</td>
              <td>Rp $harga</td>
              <td class='space-x-2'>
                <button onclick=\"confirmEdit({$menu['id_menu']}, $id_per_penjual)\" class='btn btn-sm bg-blue-500 text-white hover:bg-blue-600'>Edit</button>
                <button onclick=\"confirmDelete({$menu['id_menu']}, $id_per_penjual)\" class='btn btn-sm bg-red-500 text-white hover:bg-red-600'>Delete</button>
              </td>
            </tr>
          ";
          $no++;
        }

        echo "
            </tbody>
          </table>
        ";
      }
      ?>
    </div>
  </main>

  <script>
    AOS.init();

    function confirmEdit(id_menu, id_penjual) {
      Swal.fire({
        title: 'Edit Menu?',
        text: "You are about to edit this menu item.",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#FFB43B',
        confirmButtonText: 'Yes, edit it!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = `edit-menu.php?id_menu=${id_menu}&id_penjual=${id_penjual}`;
        }
      });
    }

    function confirmDelete(id_menu, id_penjual) {
      Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone. The menu will be permanently deleted.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e3342f',
        cancelButtonColor: '#FFB43B',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = `hapus-menu.php?id_menu=${id_menu}&id_penjual=${id_penjual}`;
        }
      });
    }
  </script>

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

  const urlParams = new URLSearchParams(window.location.search);
  const successParam = urlParams.get('success');
  const errorParam = urlParams.get('error');

  if (successParam === 'true') {
    notyf.success("Changes saved successfully!");
  } else if (successParam === 'hapus') {
    notyf.success("Menu berhasil dihapus!");
  }

  if (errorParam === 'true') {
    notyf.error("Failed to save changes!");
  } else if (errorParam === 'hapus') {
    notyf.error("Gagal menghapus menu!");
  }

</script>
</body>
</html>
