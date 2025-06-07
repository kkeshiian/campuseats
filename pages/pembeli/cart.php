<?php
require_once '../../middleware/role_auth.php';

require_role('pembeli');

if (isset($_GET['id_pembeli'])) {
  $id_per_pembeli = $_GET['id_pembeli'];
}

?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <title>Cart</title>

  <!-- Midtrans Snap.js -->
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-eQfKe1LFpAFOWEcr"></script>
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
</head>
<body class="min-h-screen flex flex-col">

<?php 
$activePage = 'cart';
include '../../partials/navbar-pembeli.php'; 
?>

<div class="w-full max-w-4xl mx-auto m-4" data-aos="fade-up" data-aos-duration="1000">
  <h1 class="text-2xl font-bold mb-4 text-center">Your Cart</h1>

  <div id="cartContainer" class="space-y-4 p-4 shadow-md border border-1 border-black rounded-lg mx-4"></div>

  <div class="text-right mt-4 mx-4">
    <p class="text-xl font-semibold">Total: Rp <span id="totalHarga">0</span></p>
    <button id="checkoutButton" class="mt-2 bg-kuning text-white px-4 py-2 rounded hover:bg-yellow-600">
      Checkout
    </button>
  </div>  
</div>

<script>
function loadCart() {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  const container = document.getElementById('cartContainer');
  const totalHargaElem = document.getElementById('totalHarga');
  container.innerHTML = '';

  if (cart.length === 0) {
    container.innerHTML = '<p class="text-center text-gray-500">Empty.</p>';
    totalHargaElem.textContent = '0';
    return;
  }

  let total = 0;

  cart.forEach((item, index) => {
    const subtotal = Math.round(item.harga * item.quantity);
    const kantin = item.kantin;
    total += subtotal;

    const card = document.createElement('div');
    card.className = "flex flex-col md:flex-row items-center justify-between border-b";

    card.innerHTML = `
      <div class="flex flex-col md:flex-row justify-between w-full">
        <div class="flex-1 w-full">
          <h2 class="text-xl font-bold text-gray-800 mb-1">${item.nama}</h2>
          <h2 class="text-xl font-bold text-gray-800 mb-1">${kantin}</h2>
          <p class="text-sm text-gray-700 mb-2">Rp ${item.harga.toLocaleString('id-ID')}</p>
          <input type="text" placeholder="Catatan untuk penjual..." value="${item.notes || ''}" 
            class="border border-gray-300 rounded-lg px-3 py-2 w-full text-sm focus:outline-none focus:ring-1 focus:ring-black note-input mb-3" data-index="${index}" />
          
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm text-gray-700">Subtotal: <span class="font-semibold text-black">Rp ${subtotal.toLocaleString('id-ID')}</span></p>
              <button class="delete-item text-sm text-red-600 hover:text-red-800 hover:underline transition" data-index="${index}">Hapus</button>
            </div>
            <div class="flex items-center gap-2">
              <button class="decrease h-6 w-6 border border-1 border-black text-black flex items-center justify-center rounded-full hover:bg-kuning transition" data-index="${index}">−</button>
              <span class="text-base font-semibold w-6 text-center">${item.quantity}</span>
              <button class="increase h-6 w-6 border border-1 border-black text-black flex items-center justify-center rounded-full hover:bg-kuning transition" data-index="${index}">+</button>
            </div>
          </div>
        </div>
      </div>
    `;
    container.appendChild(card);
  });

  totalHargaElem.textContent = total.toLocaleString('id-ID');
}

document.addEventListener('click', function(e) {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  const index = parseInt(e.target.dataset.index);

  if (e.target.classList.contains('increase')) {
    cart[index].quantity += 1;
  } else if (e.target.classList.contains('decrease')) {
    if (cart[index].quantity > 1) cart[index].quantity -= 1;
  } else if (e.target.classList.contains('delete-item')) {
    cart.splice(index, 1);
  } else {
    return;
  }

  localStorage.setItem('cart', JSON.stringify(cart));
  loadCart();
});

document.addEventListener('input', function(e) {
  if (e.target.classList.contains('note-input')) {
    const index = parseInt(e.target.dataset.index);
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart[index].notes = e.target.value;
    localStorage.setItem('cart', JSON.stringify(cart));
  }
});

loadCart();

const checkoutButton = document.getElementById('checkoutButton');

checkoutButton.addEventListener('click', function () {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];

  if (cart.length === 0) {
    alert("Keranjang kosong.");
    return;
  }

  let total = 0;
  cart.forEach(item => {
    total += Math.round(item.harga * item.quantity);
  });

  total = Math.round(total);

  const order_id = "ORD" + Date.now() + Math.floor(Math.random() * 1000);
  const idPembeli = <?= json_encode($id_per_pembeli) ?>;

  checkoutButton.disabled = true; // disable button supaya gak klik berkali-kali

  fetch('../../api/get-midtrans-token.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      order_id: order_id,
      gross_amount: total,
      items: cart,
      id_pembeli: idPembeli
    })
  })
  .then(res => res.json())
  .then(data => {
    if (data.token) {
      snap.pay(data.token, {
        onSuccess: function(result) {
          console.log('Payment success:', result);
            fetch('save_order.php', {
              method: 'POST',
              headers: {'Content-Type': 'application/json'},
              body: JSON.stringify({
                order_id: order_id,
                id_pembeli: idPembeli,
                cart: cart
              })
            })
            .then(res => res.json())
          localStorage.removeItem('cart');
          window.location.href = "order-success.php?order_id=" + order_id;
        },
        onPending: function(result) {
          console.log('Payment pending:', result);
          alert("Menunggu pembayaran.");
          checkoutButton.disabled = false;
        },
        onError: function(result) {
          console.log('Payment error:', result);
          alert("Pembayaran gagal.");
          checkoutButton.disabled = false;
        }
      });
    } else {
      alert("Gagal mendapatkan token Midtrans.");
      checkoutButton.disabled = false;
    }
  })
  .catch(err => {
    console.error(err);
    alert("Terjadi kesalahan.");
    checkoutButton.disabled = false;
  });
});
</script>
<script>
  AOS.init({
  });
</script>
</body>
</html>