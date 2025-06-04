<?php
require_once '../../middleware/role_auth.php';

require_role('pembeli');
?>


<!DOCTYPE html>
<html data-theme="light" class="bg-background">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/campuseats/dist/output.css" rel="stylesheet" />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap"
      rel="stylesheet"
    />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  </head>
  <body class="min-h-screen flex flex-col">
    <?php 
    $activePage = 'canteen';
    include '../../partials/navbar-pembeli.php'; ?>
    
    <!-- main content --> 
    <h2 class="mx-auto text-2xl font-bold m-4">
      Where do You want to eat today?
    </h2> 

    <!-- card -->
    <div
      id="card-container"
      class="grid grid-cols-2 md:grid-cols-5 gap-4 w-[90%] mx-auto"
    ></div>
  </body>

  <script>
        fetch("/campuseats/json/kantindata.json")
      .then(response => {
        if (!response.ok) throw new Error("Network response was not ok");
        return response.json();
      })
      .then(data => {
        const container = document.getElementById("card-container");
        data.forEach(kantin => {
          const card = `
            <div class="flex flex-col justify-between h-full bg-white rounded-lg shadow-lg border border-black p-4">
              <div>
                <img src="${kantin.gambar}" alt="Kantin Image" class="rounded-t-lg w-full h-36 object-cover" />
                <div class="pt-4 pb-4">
                  <h2 class="text-xl font-semibold">${kantin.nama}</h2>
                  <p class="text-gray-600">${kantin.fakultas}</p>
                </div>
              </div>
              <div>
                <a href="menu.php?id=${kantin.id}" class="btn bg-kuning text-black rounded-lg px-4 py-2 hover:bg-yellow-600 w-full text-center">Lihat Menu</a>
              </div>
            </div>
          `;
          container.innerHTML += card;
        });
      })
      .catch(error => {
        console.error("Error fetching JSON:", error);
      });
  </script>
</html>
