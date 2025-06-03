<div class="navbar bg-base-100 shadow-sm">
  <div class="navbar-start">
    <div class="dropdown">
      <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /> </svg>
      </div>
      <ul
        tabindex="0"
        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
        <li><a href="../../index.php" class="<?= ($activePage == 'index') ? 'underline decoration-kuning decoration-1 underline-offset-4 ' :  '' ?>">Home</a></li>
        <li><a href="/campuseats/pages/pembeli/canteen.php" class="<?= ($activePage == 'canteen') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Canteen</a></li>
        <li><a href="/campuseats/pages/pembeli/history.php" class="<?= ($activePage == 'history') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">History</a></li>
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
      <li><a href="../../index.php" class="<?= ($activePage == 'index') ? 'underline decoration-kuning decoration-1 underline-offset-4 ' :  '' ?>">Home</a></li>
      <li><a href="/campuseats/pages/pembeli/canteen.php" class="<?= ($activePage == 'canteen') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Canteen</a></li>
      <li><a href="/campuseats/pages/pembeli/history.php" class="<?= ($activePage == 'history') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">History</a></li>
      <li><a href="">About Us</a></li>
    </ul>
  </div>
  <div class="navbar-end">
  <a href="/campuseats/pages/pembeli/cart.php" class="btn btn-ghost">
    <!-- Heroicons - Shopping Cart -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round"
            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6m1.5-6h10m0 0l1.5 6M9 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/>
    </svg>
  </a>
</div>
</div>
