<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <title>Kelola Pengguna</title>
</head>
<body class="min-h-screen flex flex-col">
  <?php include '../../partials/navbar-admin.php'; ?>

  <main class="w-[90%] mx-auto mt-6 mb-10">
    <h2 class="text-2xl font-bold mb-6">Manage User</h2>

    <?php
    $pengguna = [
      ["id" => 1, "nama" => "Rizky", "email" => "keshian"],
      ["id" => 2, "nama" => "Sari", "email" => "ghanighina"],
      ["id" => 3, "nama" => "Budi", "email" => "randyrider"],
      ["id" => 4, "nama" => "Andi", "email" => "pengguna123"],
    ];
    ?>

    <div class="overflow-x-auto bg-white rounded shadow">
      <table class="table w-full">
        <thead class="bg-kuning text-white">
          <tr>
            <th>No</th>
            <th>Name</th>
            <th>Username</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($pengguna as $user) {
            echo '<tr>';
            echo '<td>' . $no++ . '</td>';
            echo '<td>' . htmlspecialchars($user["nama"]) . '</td>';
            echo '<td>' . htmlspecialchars($user["email"]) . '</td>';
            echo '<td>
                    <form method="POST" action="hapus_pengguna.php" onsubmit="return confirm(\'Yakin ingin menghapus pengguna ini?\')">
                      <input type="hidden" name="id" value="' . $user["id"] . '">
                      <button type="submit" class="btn btn-sm btn-error text-white">Hapus</button>
                    </form>
                  </td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>
