<div class="navbar bg-base-100 shadow-sm">
  <div class="navbar-start">
    <div class="dropdown lg:hidden">
      <div tabindex="0" role="button" class="btn btn-ghost">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> 
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /> 
        </svg>
      </div>
      <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-10 mt-3 w-52 p-2 shadow">
        <li><a href="/campuseats/pages/admin/dashboard.php" class="<?= ($activePage == 'dashboard') ? 'underline decoration-kuning decoration-1 underline-offset-4' : '' ?>">Dashboard</a></li>
        <li><a href="/campuseats/pages/admin/kelola_pengguna.php" class="<?= ($activePage == 'kelola_pengguna') ? 'underline decoration-kuning decoration-1 underline-offset-4' : '' ?>">Manage User</a></li>
        <li><a href="/campuseats/pages/admin/kelola_kantin.php" class="<?= ($activePage == 'kelola_kantin') ? 'underline decoration-kuning decoration-1 underline-offset-4' : '' ?>">Manage Canteen</a></li>
        <li><a href="/campuseats/pages/admin/kelola_report.php" class="<?= ($activePage == 'report') ? 'underline decoration-kuning decoration-1 underline-offset-4' : '' ?>">Manage Report</a></li>
      </ul>
    </div>
    <a class="btn btn-ghost normal-case text-xl">CampusEats</a>
  </div>
</div>
