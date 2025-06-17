<?php
if (isset($_GET['id_admin']) && isset($_GET['id_pembeli'])) {
    $id_admin = (int) $_GET['id_admin'];
    $id_user = (int) $_GET['id_pembeli'];
}

require_once '../../middleware/role_auth.php';
require_role('Admin');
include "../../database/koneksi.php";
include "../../database/model.php";

$error_message = '';

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $password_admin = trim($_POST['password']);
    $username_user = trim($_POST['username']);
    $new_password = trim($_POST['new_password']);

    // Cek input kosong
    if (empty($nama) || empty($password_admin) || empty($username_user) || empty($new_password)) {
        $error_message = "All fields must be filled.";
    } else {
        // Validasi password baru pengguna
        $valid = validate_password($new_password);
        if ($valid !== true) {
            $error_message = $valid;
        } else {
            // Cek autentikasi admin
            $query_admin = "SELECT * FROM admin WHERE id_admin = '$id_admin'";
            $result_admin = mysqli_query($koneksi, $query_admin);
            $admin_row = mysqli_fetch_assoc($result_admin);

            if ($admin_row) {
                $query_user = "SELECT * FROM user WHERE id_user = '{$admin_row['id_user']}'";
                $result_user = mysqli_query($koneksi, $query_user);
                $admin_user = mysqli_fetch_assoc($result_user);

                if ($admin_user && password_verify($password_admin, $admin_user['password'])) {
                    // Hash password baru sebelum update
                    $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_result = updatePasswordPengguna($koneksi, $id_user, $username_user, $hashedPassword);

                    if ($update_result) {
                        header("Location: kelola_pengguna.php?id_admin=" . $id_admin . "&success=true");
                        exit;
                    } else {
                        $error_message = "Gagal memperbarui password pengguna.";
                    }
                } else {
                    $error_message = "Autentikasi admin gagal. Nama atau password salah.";
                }
            } else {
                $error_message = "Data admin tidak ditemukan.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <title>Authorization Admin</title>

  <!-- Notyf CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
</head>
<body class="min-h-screen flex flex-col">
  <?php include '../../partials/navbar-admin.php'; ?>

  <main class="mx-auto mt-6 px-4 w-full max-w-screen-xl">
    <h2 class="text-2xl font-bold mb-6 ml-6">Change User Password by Admin</h2> 

    <?php
      $ambil_data_admin = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin='$id_admin'");
      $row_admin = mysqli_fetch_assoc($ambil_data_admin);
      $row_admin_user = $row_admin['id_user'];

      $ambil_data_user = mysqli_query($koneksi, "SELECT username FROM user WHERE id_user = '$row_admin_user'");
      $username = mysqli_fetch_assoc($ambil_data_user);
    ?>

    <form method="POST" class="bg-white p-6 rounded-lg shadow border w-full mx-auto px-6" style="max-width: 1200px;">
      <div class="flex flex-wrap gap-6">
        <!-- Authentication Admin -->
        <div class="flex-1 min-w-[300px] space-y-6">
          <h3 class="text-xl font-semibold border-b pb-2 mb-4">Authentication Admin</h3>
          <input type="hidden" name="id_admin" value="<?= $id_admin ?>" />
          <div>
            <label class="block font-semibold mb-1" for="nama">Admin Name</label>
            <input id="nama" type="text" name="nama" value="<?= htmlspecialchars($username['username']) ?>" class="input input-bordered w-full"  />
          </div>
          <div>
            <label class="block font-semibold mb-1" for="password">Admin Password</label>
            <input id="password" type="password" name="password" class="input input-bordered w-full"  />
          </div>
        </div>

        <!-- Authentication User -->
        <div class="flex-1 min-w-[300px] space-y-6">
          <h3 class="text-xl font-semibold border-b pb-2 mb-4">Authentication User</h3>
          <input type="hidden" name="id_user" value="<?= $id_user ?>" />
          <div>
            <label class="block font-semibold mb-1" for="username">Username User</label>
            <input id="username" type="text" name="username" class="input input-bordered w-full"  />
          </div>
          <div>
            <label class="block font-semibold mb-1" for="new_password">Change Password User</label>
            <input id="new_password" type="password" name="new_password" class="input input-bordered w-full"  />
            <p class="text-gray-500 mt-1 text-xs leading-snug">
              Password must be at least 8 characters, include uppercase, lowercase, a number,
              and a special symbol (e.g., !@#$%^&*).
            </p>
          </div>
          <div class="flex justify-between mt-6">
            <a href="kelola_pengguna.php?id_admin=<?= $id_admin ?>" class="btn btn-outline border-kuning border-1 rounded-lg">← Manage User</a>
            <button type="submit" name="submit" class="btn bg-kuning text-white hover:bg-kuning rounded-lg">Save Changes</button>
          </div>
        </div>
      </div>
    </form>
  </main>

  <script>
    const notyf = new Notyf({
      duration: 3000,
      position: { x: 'right', y: 'top' },
      types: [
        {
          type: 'success',
          background: '#28a745',
          icon: { className: 'notyf__icon--success', tagName: 'i' }
        },
        {
          type: 'error',
          background: '#dc3545',
          icon: { className: 'notyf__icon--error', tagName: 'i' }
        }
      ]
    });

    <?php if (!empty($error_message)) : ?>
      notyf.error("<?= addslashes($error_message) ?>");
    <?php endif; ?>
  </script>
</body>
</html>
