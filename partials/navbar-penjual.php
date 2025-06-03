<div class="navbar bg-base-100 shadow-sm">
  <div class="navbar-start">
    <div class="dropdown">
      <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /> </svg>
      </div>
      <ul
        tabindex="0"
        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
        <li><a href="../../index.php" class="<?= ($activePage == 'index') ? 'underline decoration-kuning decoration-1 underline-offset-4 ' :  '' ?>">Dashboard</a></li>
        <li><a href="/campuseats/pages/penjual/kelola_menu.php" class="<?= ($activePage == 'canteen') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>"></a>Kelola Menu</li>
        <li><a href="/campuseats/pages/penjual/kelola_kantin.php" class="<?= ($activePage == 'history') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Kelola Kantin</a></li>
        <li><a href="/campuseats/pages/penjual/cart.php" class="<?= ($activePage == 'cart') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Cart</a></li>
        <li><a href="">About Us</a></li>
      </ul>
    </div>
    <div class="flex-1">
    <button onclick="history.back()" class="btn btn-ghost btn-circle">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
        viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M15 19l-7-7 7-7" />
      </svg>
    </button>
    <a class="btn btn-ghost normal-case text-xl">CampusEats</a>
  </div>
  </div>
  <div class="navbar-center hidden lg:flex">
    <ul class="menu menu-horizontal px-1">
      <li><a href="../../index.php" class="<?= ($activePage == 'index') ? 'underline decoration-kuning decoration-1 underline-offset-4 ' :  '' ?>">Dashboard</a></li>
      <li><a href="/campuseats/pages/penjual/kelola_menu.php" class="<?= ($activePage == 'canteen') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Kelola Menu</a></li>
      <li><a href="/campuseats/pages/penjual/kelola_kantin.php" class="<?= ($activePage == 'history') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Kelola Kantin</a></li>
      <li><a href="/campuseats/pages/penjual/cart.php" class="<?= ($activePage == 'cart') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Cart</a></li>
      <li><a href="">About Us</a></li>
    </ul>
  </div>
  <div class="navbar-end flex items-center gap-4 z-10">
    <a href="/campuseats/pages/auth/login.php" class="bg-yellow-500 text-white p-2 px-4 rounded hover:bg-yellow-600 transition">
      Login
    </a>
    <a href="/campuseats/pages/auth/register.php" class=" text-yellow-500 border border-1 border-kuning p-2 px-4 rounded hover:bg-gray-300 transition">
      Register
    </a>
  </div>
</div>
