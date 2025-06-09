<?php
$id_pembeli = isset($_SESSION['id_pembeli']) ? $_SESSION['id_pembeli'] : null;
$activePage = isset($activePage) ? $activePage : '';
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="sticky top-0 z-50 bg-base-100 shadow-sm navbar">
  <div class="navbar-start">
    <div class="dropdown">
      <label tabindex="0" class="btn btn-ghost lg:hidden" role="button" aria-label="Menu Toggle">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> 
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /> 
        </svg>
      </label>
      <ul
        tabindex="0"
        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-50 mt-3 w-52 p-2 shadow-lg"
        role="menu"
        aria-label="Mobile Navigation Menu"
      >
        <li><a href="../../index.php" class="<?= ($activePage == 'index') ? 'underline decoration-kuning decoration-1 underline-offset-4 ' :  '' ?>">Home</a></li>
        <li><a href="/campuseats/pages/pembeli/canteen.php<?= $id_pembeli ? '?id_pembeli=' . $id_pembeli : '' ?>" class="<?= ($activePage == 'canteen') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Canteen</a></li>
        <li><a href="/campuseats/pages/pembeli/history.php<?= $id_pembeli ? '?id_pembeli=' . $id_pembeli : '' ?>" class="<?= ($activePage == 'history') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">History</a></li>
        <li><a href="/campuseats/pages/pembeli/cart.php<?= $id_pembeli ? '?id_pembeli=' . $id_pembeli : '' ?>" class="<?= ($activePage == 'cart') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Cart</a></li>
        <li><a href="/campuseats/pages/pembeli/about_us.php">About Us</a></li>
      </ul>
    </div>
    <a class="btn btn-ghost normal-case text-xl">CampusEats</a>
  </div>

  <div class="navbar-center hidden lg:flex">
    <ul class="menu menu-horizontal px-1">
      <li><a href="/campuseats/pages/pembeli/canteen.php<?= $id_pembeli ? '?id_pembeli=' . $id_pembeli : '' ?>" class="<?= ($activePage == 'canteen') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Canteen</a></li>
      <li><a href="/campuseats/pages/pembeli/history.php<?= $id_pembeli ? '?id_pembeli=' . $id_pembeli : '' ?>" class="<?= ($activePage == 'history') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">History</a></li>
      <li><a href="/campuseats/pages/pembeli/cart.php<?= $id_pembeli ? '?id_pembeli=' . $id_pembeli : '' ?>" class="<?= ($activePage == 'cart') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Cart</a></li>
      <li><a href="/campuseats/pages/pembeli/about_us.php">About Us</a></li>
    </ul>
  </div>

  <div class="navbar-end flex items-center gap-4 z-50">
    <button id="logoutBtn" class="bg-kuning text-white p-2 px-4 rounded hover:bg-yellow-600 transition">
      Logout
    </button>
  </div>
</div>

<script>
  document.getElementById('logoutBtn').addEventListener('click', function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Logout Confirmation',
      text: "Are you sure you want to logout?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#FFB43B',
      confirmButtonText: 'Yes, logout',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "/campuseats/pages/auth/logout.php";
      }
    });
  });
</script>
