<!DOCTYPE html>
<html data-theme="light" class="bg-background min-h-screen">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <title>About Us - Tim Pengembang</title>
</head>
<body class="flex flex-col min-h-screen">

<?php include '../../partials/navbar-pembeli.php'; ?>

<main class="flex-grow container mx-auto px-4">
  <h1 class="text-2xl font-bold mb-8 text-center text-black m-4">Tim Pengembang</h1>
  
  <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
    <!-- UI/UX Designer -->
    <div class="bg-white rounded-lg shadow p-6 text-center">
      <img src="https://i.pravatar.cc/150?img=5" alt="UI/UX Designer" class="mx-auto rounded-lg w-64 h-64 mb-4 object-cover" />
      <h2 class="text-xl font-semibold mb-1">Ayu Santoso</h2>
      <p class="text-yellow-600 font-semibold mb-2">UI/UX Designer</p>
      <p class="text-gray-600 text-sm">
        Bertanggung jawab atas desain antarmuka yang menarik dan pengalaman pengguna yang optimal.
      </p>
    </div>

    <!-- Front-End Developer -->
    <div class="bg-white rounded-lg shadow p-6 text-center">
      <img src="https://i.pravatar.cc/150?img=12" alt="Front-End Developer" class="mx-auto rounded-lg w-64 h-64 mb-4 object-cover" />
      <h2 class="text-xl font-semibold mb-1">Budi Pratama</h2>
      <p class="text-yellow-600 font-semibold mb-2">Front-End Developer</p>
      <p class="text-gray-600 text-sm">
        Mengembangkan tampilan website dan memastikan responsif serta interaktif.
      </p>
    </div>

    <!-- Back-End Developer -->
    <div class="bg-white rounded-lg shadow p-6 text-center">
      <img src="https://i.pravatar.cc/150?img=18" alt="Back-End Developer" class="mx-auto rounded-lg w-64 h-64 mb-4 object-cover" />
      <h2 class="text-xl font-semibold mb-1">Citra Dewi</h2>
      <p class="text-yellow-600 font-semibold mb-2">Back-End Developer</p>
      <p class="text-gray-600 text-sm">
        Mengelola server, database, dan logika aplikasi agar berjalan lancar dan aman.
      </p>
    </div>
  </div>
</main>

<footer class="bg-gray-100 text-center py-4 text-gray-700 text-sm">
  &copy; <?= date('Y') ?> Campuseats. All rights reserved.
</footer>

</body>
</html>
