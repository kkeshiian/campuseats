<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <title>Edit Canteen - CampusEats!</title>
</head>
<body class="min-h-screen flex flex-col">
  <?php include '../../partials/navbar-admin.php'; ?>

  <main class="w-[90%] mx-auto mt-6 max-w-xl">
    <h2 class="text-2xl font-bold mb-4 text-center">Edit Canteen</h2>

    <form action="proses_edit_kantin.php" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded-lg shadow border">
      <input type="hidden" name="id" value="<?= htmlspecialchars($canteen['id']) ?>" />

      <!-- Canteen Name -->
      <div>
        <label class="block font-semibold mb-1">Canteen Name</label>
        <input type="text" name="name" class="input input-bordered w-full" required value="<?= htmlspecialchars($canteen['name']) ?>" />
      </div>

      <!-- Location -->
      <div>
        <label class="block font-semibold mb-1">Location</label>
        <input type="text" name="location" class="input input-bordered w-full" required value="<?= htmlspecialchars($canteen['location']) ?>" />
      </div>

      <!-- Change Picture -->
      <div>
        <label class="block font-semibold mb-1">Change Picture</label>
        <input type="file" name="image" accept="image/*" class="file-input file-input-bordered w-full" />
      </div>

      <!-- Save Button -->
      <div class="flex justify-end">
        <button type="submit" class="btn bg-kuning text-white hover:bg-yellow-600">Save Changes</button>
      </div>
    </form>
  </main>
</body>
</html>
