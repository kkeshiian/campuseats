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
        <!-- Canteen Name -->
        <div>
          <label class="block font-semibold mb-1">Canteen Name</label>
          <input type="text" name="nama_kantin" value="Kantin Pak Jangkung" class="input input-bordered w-full" required />
        </div>

        <!-- Location -->
        <div>
          <label class="block font-semibold mb-1">Location</label>
          <input type="text" name="lokasi" value="Fakultas Teknik" class="input input-bordered w-full" required />
        </div>

        <!-- Coordinates -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block font-semibold mb-1">Latitude</label>
            <input type="text" name="latitude" value="-6.200000" class="input input-bordered w-full" required />
          </div>
          <div>
            <label class="block font-semibold mb-1">Longitude</label>
            <input type="text" name="longitude" value="106.816666" class="input input-bordered w-full" required />
          </div>
        </div>

        <!-- Upload Canteen Photo -->
        <div>
          <label class="block font-semibold mb-1">Canteen Photo</label>
          <input type="file" name="foto_kantin" accept="image/*" class="file-input file-input-bordered w-full" />
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
          <button type="submit" class="btn bg-kuning text-white hover:bg-yellow-600">Save Changes</button>
        </div>
      </form>
    </main>
  </body>
</html>
