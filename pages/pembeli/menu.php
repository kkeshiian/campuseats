<?php
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
} else {
    echo "ID kantin tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/campuseats/dist/output.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
    <title>Menu Kantin</title>
</head>
<body class="min-h-screen flex flex-col">

<?php
$activePage = 'canteen';
include '../../partials/navbar.php';
?>

<h2 class="mx-auto text-2xl font-bold m-4">Where do You want to eat today?</h2>

<!-- Tempat menampilkan menu -->
<div id="card-container" class="grid grid-cols-2 md:grid-cols-5 gap-4 w-[90%] mx-auto mt-4"></div>
<script>
const kantinId = <?php echo json_encode($id); ?>;

// Fungsi untuk update tampilan keranjang dari localStorage
function updateCartUI() {
    const cartItemsDiv = document.getElementById('cartItems');
    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    if (cart.length === 0) {
        cartItemsDiv.innerHTML = '<p class="text-center text-gray-500">Keranjang masih kosong.</p>';
        return;
    }

    cartItemsDiv.innerHTML = '';
    cart.forEach(item => {
        cartItemsDiv.innerHTML += `
            <div class="flex justify-between border-b pb-1">
                <span>${item.nama} x${item.quantity}</span>
                <span>Rp ${(item.harga * item.quantity).toLocaleString('id-ID')}</span>
            </div>
        `;
    });
}

fetch("/campuseats/json/menudata.json")
    .then(response => {
        if (!response.ok) throw new Error("Gagal ambil data menu");
        return response.json();
    })
    .then(data => {
        const container = document.getElementById("card-container");
        const filteredMenu = data.filter(item => item.kantin_id == kantinId);

        if (filteredMenu.length === 0) {
            container.innerHTML = '<p class="text-center col-span-full text-gray-500">Tidak ada menu tersedia untuk kantin ini.</p>';
        }

        filteredMenu.forEach(menu => {
            const card = document.createElement('div');
            card.className = "flex flex-col justify-between bg-white rounded-lg shadow-lg border border-black p-4";

            card.innerHTML = `
                <div>
                    <img src="${menu.gambar}" alt="${menu.nama}" class="rounded-t-lg w-full h-36 object-cover" />
                    <div class="pt-4 pb-4">
                        <h2 class="text-xl font-semibold">${menu.nama}</h2>
                        <p class="text-gray-600">Rp ${menu.harga.toLocaleString('id-ID')}</p>
                    </div>
                </div>
                <div>
                    <button class="btn bg-kuning text-sm text-black rounded-lg px-4 py-2 hover:bg-yellow-600 w-full text-center">Add to Cart</button>
                </div>
            `;

            const btn = card.querySelector('button');
            btn.addEventListener('click', () => {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];

                const existingIndex = cart.findIndex(item => item.nama === menu.nama);
                if (existingIndex !== -1) {
                    cart[existingIndex].quantity += 1;
                } else {
                    cart.push({
                        nama: menu.nama,
                        harga: menu.harga,
                        gambar: menu.gambar,
                        quantity: 1,
                        notes: ''
                    });
                }

                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartUI();
                alert(`"${menu.nama}" ditambahkan ke keranjang!`);
            });

            container.appendChild(card);
        });
    })
    .catch(error => {
        console.error("Error fetching JSON:", error);
    });

// Tampilkan isi keranjang saat pertama kali
updateCartUI();
</script>
</body>
</html>
