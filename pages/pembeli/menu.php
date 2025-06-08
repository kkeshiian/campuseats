<?php
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
}else{
  header("Location: /campuseats/pages/auth/logout.php");
  exit();
}

include "../../database/koneksi.php";
include "../../database/model.php";


$query_penjual = mysqli_query($koneksi, "SELECT id_penjual, id_fakultas, nama_kantin, gambar, link FROM penjual WHERE id_penjual = '$id'"); 
$row_penjual = mysqli_fetch_assoc($query_penjual);

$query_menu = mysqli_query($koneksi, "SELECT * FROM menu WHERE id_penjual = '$id'"); 
$kantin = $row_penjual['nama_kantin'];


// $stmt = $conn->prepare("SELECT 
//     menu.id_menu AS id, 
//     menu.id_penjual AS kantin_id, 
//     menu.nama_menu AS nama, 
//     menu.harga, 
//     menu.gambar, 
//     penjual.nama_kantin AS kantin,
//     penjual.link AS link,
//     penjual.gambar AS gambar_kantin
//     FROM penjual LEFT JOIN menu ON menu.id_penjual = penjual.id_penjual WHERE penjual.id_penjual = ?");

    
// $stmt->bind_param("i", $id);
// $stmt->execute();
// $result = $stmt->get_result();

// // Ambil info nama kantin & link dulu
// $kantin = '';
// $lokasiMaps = '';
// $gambar_kantin = '';

// if ($result->num_rows > 0) {
//     $row = $result->fetch_assoc();
//     $kantin = $row['kantin'];
//     $lokasiMaps = $row['link'];
//     $gambar_kantin = $row['gambar_kantin'];
//     $result->data_seek(0); // reset pointer agar bisa di-loop lagi
// }

require_once '../../middleware/role_auth.php';
require_role('pembeli');
?>
<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/campuseats/dist/output.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <title>Menu Kantin</title>
</head>
<body class="min-h-screen flex flex-col mb-4">

<?php
$activePage = 'canteen';
include '../../partials/navbar-pembeli.php';
?>


<div class="flex w-full max-w-md mx-6 md:mx-auto m-6 p-4 border border-black rounded-xl shadow-sm bg-white"
data-aos="fade-down" data-aos-duration="1000">
   <div class="mx-auto flex items-center gap-6">
     <!-- Bagian kiri: gambar -->
    <?php
    if ($row_penjual['gambar']== null || $row_penjual['gambar']== '') {
        $row_penjual['gambar']= "assets/img/default-canteen.jpg";
    }
    ?>
    <div class="w-64">
      <img src="/campuseats/<?= $row_penjual['gambar'] ?>" alt="Gambar Kantin <?= htmlspecialchars($row_penjual['nama_kantin']) ?>" class="rounded-lg object-cover w-full h-32 md:h-40" />
    </div>

    <!-- Bagian kanan: nama kantin dan tombol -->
    <div class="w-2/3 flex flex-col justify-center">
        <div class="text-black text-2xl font-bold mb-2"><?= $row_penjual['nama_kantin'] ?></div>

        <?php if (!empty($row_penjual['link'])): ?>
        <a href="<?= $row_penjual['link'] ?>" target="_blank"
           class="inline-block bg-kuning text-black px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-200 w-max">
           Direction to Canteen
        </a>
        <?php endif; ?>
    </div>
   </div>
</div>

<!-- Tempat menampilkan menu -->
<div id="card-container" class="grid grid-cols-2 md:grid-cols-5 gap-4 w-[90%] mx-auto mt-4" data-aos="fade-up" data-aos-duration="1000">
    <?php
    
        if (mysqli_num_rows($query_menu) > 0) {
            while ($row_menu = mysqli_fetch_assoc($query_menu)) {
                $nama = htmlspecialchars($row_menu['nama_menu']);
                $harga = (int)$row_menu['harga'];
                $gambar = htmlspecialchars($row_menu['gambar']);
    ?>
    <div class="flex flex-col justify-between bg-white rounded-lg shadow-lg border border-black p-4">
        <div>
            <img src="/campuseats/<?= $gambar ?>" alt="<?= $nama ?>" class="rounded-t-lg w-full h-36 object-cover" />
            <div class="pt-4 pb-4">
                <h2 class="text-xl font-semibold"><?= $nama ?></h2><br>
                <p class="text-gray-600">Rp <?= number_format($harga, 0, ',', '.') ?></p>
            </div>
        </div>
        <div>
            <button
                class="btn bg-kuning text-sm text-black rounded-lg px-4 py-2 hover:bg-yellow-600 w-full text-center add-to-cart"
                data-nama="<?= $nama ?>"
                data-harga="<?= $harga ?>"
                data-gambar="<?= $gambar ?>"
                data-kantin="<?= $kantin?>"
            >Add to Cart</button>
        </div>
    </div>
    <?php
            }
        } else {
            echo '<p class="text-center col-span-full text-gray-500">Tidak ada menu tersedia untuk kantin ini.</p>';
        }
    ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    setupCartButtons();
    updateCartUI();
});

function setupCartButtons() {
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', () => {
            const nama = button.dataset.nama;
            const harga = parseInt(button.dataset.harga);
            const gambar = button.dataset.gambar;
            const kantin = button.dataset.kantin;

            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            if (cart.length > 0) {
                const existingKantin = cart[0].kantin;
                if (kantin !== existingKantin) {
                    alert("Tidak bisa menambahkan menu dari kantin berbeda. Silakan selesaikan pesanan kantin sebelumnya terlebih dahulu.");
                    return;
                }
            }

            const existingIndex = cart.findIndex(item => item.nama === nama);
            if (existingIndex !== -1) {
                cart[existingIndex].quantity += 1;
            } else {
                cart.push({
                    nama: nama,
                    harga: harga,
                    gambar: gambar,
                    kantin: kantin,
                    quantity: 1,
                    notes: ''
                });
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartUI();
        });
    });
}

function updateCartUI() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
    const cartCountElement = document.getElementById('cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = totalItems;
    }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
  });
</script>
</body>
</html>
