<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <title>Manage Canteens</title>
</head>
<body class="min-h-screen flex flex-col">
  <?php include '../../partials/navbar-admin.php'; ?>

  <main class="w-[90%] mx-auto mt-6 mb-10">
    <?php
    // Dummy canteen data
    $canteens = [
      ["id" => 1, "name" => "Kantin Pak Jangkung", "location" => "Fakultas Teknik"],
      ["id" => 2, "name" => "Kantin Mas Budi", "location" => "Fakultas Pertanian"],
    ];
    ?>

    <!-- Add New Canteen -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold mb-4">Manage Canteen</h2>
        <!-- Tombol Tambah Menu -->
        <div class="mb-6">
          <a href="tambah_kantin.php" class="btn bg-kuning text-white font-semibold rounded-lg px-4 py-2 hover:bg-yellow-600">
            + Add Canteen
          </a>
        </div>
    </div>

    <!-- Canteen Table -->
    <div class="overflow-x-auto bg-white rounded shadow">
      <table class="table w-full">
        <thead class="bg-kuning text-white">
          <tr>
            <th>No</th>
            <th>Canteen Name</th>
            <th>Location</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($canteens as $canteen) {
            echo '<tr>';
            echo '<td>' . $no++ . '</td>';
            echo '<td>' . htmlspecialchars($canteen["name"]) . '</td>';
            echo '<td>' . htmlspecialchars($canteen["location"]) . '</td>';
            echo '<td class="flex gap-2">
                    <a href="edit_kantin.php?id=' . $canteen["id"] . '" class="btn btn-sm btn-warning text-white">Edit</a>
                    <form method="POST" action="hapus_kantin.php" onsubmit="return confirm(\'Are you sure you want to delete this canteen?\')">
                      <input type="hidden" name="id" value="' . $canteen["id"] . '">
                      <button type="submit" class="btn btn-sm btn-error text-white">Delete</button>
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
