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

function validate_password($password) {
    if (strlen($password) < 8) {
        return "Password must be at least 8 characters.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        return "Password must contain at least one uppercase letter.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        return "Password must contain at least one lowercase letter.";
    }
    if (!preg_match('/[0-9]/', $password)) {
        return "Password must contain at least one number.";
    }
    if (!preg_match('/[\W_]/', $password)) {
        return "Password must contain at least one special character (e.g., !@#$%^&*).";
    }
    return true;
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $nama_penjual = $_POST['nama_penjual'];
    $nama_kantin = $_POST['nama_kantin'];
    $id_fakultas = $_POST['id_fakultas'];
    $link = $_POST['link'];
    if ($_POST['password'] != $_POST['konfirmasi_password']) {
        $error = 'Password and password confirmation do not match.';
    } else {
        $password_input = $_POST['password'];
        $valid_pass = validate_password($password_input);

        if ($valid_pass !== true) {
            $error = $valid_pass;
        } else {
            $password = password_hash($password_input, PASSWORD_DEFAULT);

            $hasil = registrasiPenjual($koneksi, $username, $nama_penjual, 
            $nama_kantin, $id_fakultas, $password, $link);

            header("Location: kelola_kantin.php?id_admin=" . $id_admin);
            exit();
        }
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
    <?php   $activePage = 'kelola_kantin'; 
    include '../../partials/navbar-admin.php'; ?>

    <main class="w-[90%] mx-auto mt-6 max-w-xl">
      <h2 class="text-2xl font-bold mb-4 text-center">Add New Canteen</h2>

      <form method="POST" enctype="multipart/form-data"
  class="space-y-6 bg-white p-6 rounded-lg shadow border border-black mb-8" id="menuForm">

        <input type="hidden" name="id_admin" value="<?= htmlspecialchars($id_admin) ?>">

        <div class="flex flex-col md:flex-row gap-6">
            <!-- Left Column -->
            <div class="flex-1 space-y-4">
            <div>
                <label class="block font-semibold mb-1">Seller Username</label>
                <input type="text" name="username" class="input input-bordered w-full" value="<?= htmlspecialchars($username ?? '') ?>" />
            </div>

            <div>
                <label class="block font-semibold mb-1">Seller Name</label>
                <input type="text" name="nama_penjual" class="input input-bordered w-full" required value="<?= htmlspecialchars($nama_penjual ?? '') ?>"/>
            </div>

            <div>
                <label class="block font-semibold mb-1">Canteen Name</label>
                <input type="text" name="nama_kantin" class="input input-bordered w-full" required value="<?= htmlspecialchars($nama_kantin ?? '') ?>"/>
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
                    <input type="text" name="link" class="input input-bordered w-full" required value="<?= htmlspecialchars($link ?? '') ?>" />
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

<!-- Notyf JS -->
<script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
<script>
const notyf = new Notyf({
    duration: 3000,
    position: { x: 'right', y: 'top' },
    dismissible: true
});

<?php if (isset($error) && !empty($error)): ?>
    notyf.error(<?= json_encode(htmlspecialchars($error, ENT_QUOTES, 'UTF-8')) ?>);
<?php endif; ?>
</script>


<script>
AOS.init();
</script>
