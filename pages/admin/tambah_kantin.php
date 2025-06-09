<?php
if (isset($_GET['id_admin'])) {
    $id_admin = (int) $_GET['id_admin'];
}

include "../../database/koneksi.php";
include "../../database/model.php";

$ambil_data = mysqli_query($koneksi, "
SELECT nama_fakultas, id_fakultas FROM fakultas");
$data = mysqli_fetch_assoc($ambil_data);

$queryFakultas = mysqli_query($koneksi, "SELECT id_fakultas, nama_fakultas FROM fakultas ORDER BY nama_fakultas ASC");

$id_fakultas_terpilih = '';

$error = '';
$success = '';

if (isset($_POST['submit'])) {
    if ($_POST['password'] != $_POST['konfirmasi_password']) {
        $error = 'Password and password confirmation do not match.';
    } else {
        $username = $_POST['username'];
        $nama_penjual = $_POST['nama_penjual'];
        $nama_kantin = $_POST['nama_kantin'];
        $id_fakultas = $_POST['id_fakultas'];
        $link = $_POST['link'];
        $password = password_hash($_POST['konfirmasi_password'], PASSWORD_DEFAULT);

        $hasil = registrasiPenjual($koneksi, $username, $nama_penjual, 
        $nama_kantin, $id_fakultas, $password, $link);
        header("Location: kelola_kantin.php?id_admin=" . $id_admin);

        exit();
    }
}
?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/campuseats/dist/output.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
    <!-- Notyf -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <title>CampusEats!</title>
  </head>
  <body class="min-h-screen flex flex-col">
    <?php include '../../partials/navbar-admin.php'; ?>

    <main class="w-[90%] mx-auto mt-6 max-w-xl">
      <h2 class="text-2xl font-bold mb-4 text-center">Add New Canteen</h2>

      <form method="POST" enctype="multipart/form-data"
  class="space-y-6 bg-white p-6 rounded-lg shadow border border-black" id="menuForm">

        <input type="hidden" name="id_admin" value="<?= htmlspecialchars($id_admin) ?>">

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Left Column -->
            <div class="flex-1 space-y-4">
            <div>
                <label class="block font-semibold mb-1">Seller Username</label>
                <input type="text" name="username" class="input input-bordered w-full" />
            </div>

            <div>
                <label class="block font-semibold mb-1">Seller Name</label>
                <input type="text" name="nama_penjual" class="input input-bordered w-full" required />
            </div>

            <div>
                <label class="block font-semibold mb-1">Canteen Name</label>
                <input type="text" name="nama_kantin" class="input input-bordered w-full" required />
            </div>

            <div>
                <label class="block font-semibold mb-1">Canteen Location</label>
                <select name="id_fakultas" class="select select-bordered w-full" required>
                <option value="">-- Select Faculty --</option>
                <?php
                
                while ($fakultas = mysqli_fetch_assoc($queryFakultas)) {
                    $selected = ($fakultas['id_fakultas'] == $id_fakultas_terpilih) ? 'selected' : '';
                    echo "<option value='{$fakultas['id_fakultas']}' $selected>{$fakultas['nama_fakultas']}</option>";
                }
                
                ?>
                </select>
            </div>
            </div>

            <!-- Right Column -->
            <div class="flex-1 flex flex-col justify-between space-y-4">
                <div>
                    <label class="block font-semibold mb-1">Canteen Maps Link</label>
                    <input type="text" name="link" class="input input-bordered w-full" required />
                </div>

                <div>
                    <label class="block font-semibold mb-1">Password</label>
                    <input type="password" name="password" class="input input-bordered w-full" required />
                </div>

                <div>
                    <label class="block font-semibold mb-1">Confirm Password</label>
                    <input type="password" name="konfirmasi_password" class="input input-bordered w-full" required />
                </div>

                <!-- Button at the bottom -->
                <div class="flex justify-end pt-2">
                    <button type="submit" name="submit" class="btn bg-kuning text-white hover:bg-yellow-600 rounded-lg">
                    Add Canteen
                    </button>
                </div>
            </div>
        </div>
        </form>

    </main>
  </body>
</html>
