<?php
$id_penjual = isset($_SESSION['id_penjual']) ? $_SESSION['id_penjual'] : null;
?>

<div class="navbar bg-base-100 shadow-sm">
  <div class="navbar-start">
    <div class="dropdown">
      <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /> </svg>
      </div>
      <ul
        tabindex="0"
        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
        <li><a href="../../pages/penjual/dashboard.php<?= $id_penjual ? '?id_penjual=' . $id_penjual : '' ?>" class="<?= ($activePage == 'dashboard_seller') ? 'underline decoration-kuning decoration-1 underline-offset-4 ' :  '' ?>">Dashboard</a></li>
        <li><a href="/campuseats/pages/penjual/kelola_menu.php<?= $id_penjual ? '?id_penjual=' . $id_penjual : '' ?>" class="<?= ($activePage == 'manage_menu_seller') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>"></a>Manage Menu</li>
        <li><a href="/campuseats/pages/penjual/kelola_kantin.php<?= $id_penjual ? '?id_penjual=' . $id_penjual : '' ?>" class="<?= ($activePage == 'manage_canteen_seller') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Manage Canteen</a></li>
        <li><a href="/campuseats/pages/penjual/laporan_penjualan.php<?= $id_penjual ? '?id_penjual=' . $id_penjual : '' ?>" class="<?= ($activePage == 'laporan_penjualan') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Sales Report</a></li>
      </ul>
    </div>
  <a class="btn btn-ghost normal-case text-xl">CampusEats</a>
  </div>
  <div class="navbar-center hidden lg:flex">
    <ul class="menu menu-horizontal px-1">
      <li><a href="../../pages/penjual/dashboard.php<?= $id_penjual ? '?id_penjual=' . $id_penjual : '' ?>" class="<?= ($activePage == 'dashboard_seller') ? 'underline decoration-kuning decoration-1 underline-offset-4 ' :  '' ?>">Dashboard</a></li>
      <li><a href="/campuseats/pages/penjual/kelola_menu.php<?= $id_penjual ? '?id_penjual=' . $id_penjual : '' ?>" class="<?= ($activePage == 'manage_menu_seller') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Manage Menu</a></li>
      <li><a href="/campuseats/pages/penjual/kelola_kantin.php<?= $id_penjual ? '?id_penjual=' . $id_penjual : '' ?>" class="<?= ($activePage == 'manage_canteen_seller') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Manage Canteen</a></li>
      <li><a href="/campuseats/pages/penjual/laporan_penjualan.php<?= $id_penjual ? '?id_penjual=' . $id_penjual : '' ?>" class="<?= ($activePage == 'laporan_penjualan.php') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Sales Report</a></li>
    </ul>
  </div>
  <div class="navbar-end flex items-center gap-4 z-10">
    <a href="/campuseats/pages/auth/logout.php" class="bg-yellow-500 text-white p-2 px-4 rounded hover:bg-yellow-600 transition">
      Logout
    </a>
  </div>
</div>
