<?php
$id_pembeli = isset($_SESSION['id_pembeli']) ? $_SESSION['id_pembeli'] : null;
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        <li><a href="/campuseats/pages/pembeli/cart.php" class="<?= ($activePage == 'cart') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Cart</a></li>
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
  <div class="navbar-end flex items-center gap-4 z-10">
    <a  id="logoutBtn" href="/campuseats/pages/auth/logout.php" class="bg-kuning text-white p-2 px-4 rounded hover:bg-yellow-600 transition">
      Logout
    </a>
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
