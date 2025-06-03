<?php 
$activePage = 'index';
?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="dist/output.css" rel="stylesheet" />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap"
      rel="stylesheet"
    />
  </head>
  <body class="min-h-screen flex flex-col">
    <?php
    
    
    
    include 'partials/navbar-pembeli-belum-login.php'; 
    
    ?>

    <!-- main content -->
    <div class="flex-1 flex items-center justify-center -mt-16">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 px-6 max-w-4xl mx-auto">
        <div>
          <img
            src="../campuseats/assets/img/food.png"
            alt=""
            class="w-full h-auto p-8 lg:mr-8"
          />
        </div>
        <div class="flex flex-col justify-center">
          <p class="text-4xl font-bold mb-2">
            Smart Eating for Smart Students!
          </p>
          <p>Order fast, pay cashless, and skip the lines.</p>
          <a
            class="btn bg-kuning rounded-lg mt-4"
            href="pages/pembeli/canteen.php"
            >Explore Foods!</a
          >
        </div>
      </div>
    </div>
  </body>
</html>
