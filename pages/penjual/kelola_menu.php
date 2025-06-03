<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <title>Kelola Menu</title>

  <!-- SweetAlert2 CDN -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="min-h-screen flex flex-col">
  <?php include '../../partials/navbar-penjual.php'; ?>

  <main class="w-[90%] mx-auto mt-6">
    <div class="flex justify-between items-center">
      <h2 class="text-2xl font-bold mb-4">Manage Menu</h2>
      <div class="mb-4">
        <a href="menu.php?action=add" class="btn bg-kuning text-white font-semibold rounded-lg px-4 py-2 hover:bg-yellow-600">
          + Add Menu
        </a>
      </div>
    </div>

    <div class="overflow-x-auto bg-white border">
      <table class="table w-full">
        <thead class="bg-kuning text-white">
          <tr>
            <th class="text-center">No</th>
            <th>Menu Name</th>
            <th>Price</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($menu as $m) {
            echo '
            <tr>
              <td class="text-center">'.$no++.'</td>
              <td>'.htmlspecialchars($m["nama_menu"]).'</td>
              <td>Rp '.number_format($m["harga"], 0, ',', '.').'</td>
              <td>
                <a href="menu.php?action=edit&id='.$m["id_menu"].'" class="btn btn-sm bg-blue-500 text-white mr-2">Edit</a>
                <button class="btn btn-sm bg-red-500 text-white btn-hapus" data-id="'.$m["id_menu"].'">Hapus</button>
              </td>
            </tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>

  <script>
    const btnHapusList = document.querySelectorAll('.btn-hapus');

    btnHapusList.forEach(btn => {
      btn.addEventListener('click', function() {
        const id = this.getAttribute('data-id');

        Swal.fire({
          title: 'Yakin ingin hapus menu ini?',
          text: "Data yang sudah dihapus tidak bisa dikembalikan!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            // Redirect ke proses delete
            window.location.href = 'menu.php?action=delete&id=' + id;
          }
        });
      });
    });
  </script>
</body>
</html>
