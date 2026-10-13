<?php
require_once 'config/auth.php';

$success = false;
$error = '';

// Proses pendaftaran
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nama']) && isset($_POST['alamat']) && isset($_POST['nomor_hp'])) {
    $nama = escape($_POST['nama']);
    $alamat = escape($_POST['alamat']);
    $nomor_hp = escape($_POST['nomor_hp']);
    
    if (empty($nama) || empty($alamat) || empty($nomor_hp)) {
        $error = 'Semua field harus diisi!';
    } else {
        // Insert ke tabel orangtua
        $sql = "INSERT INTO orangtua (nama, alamat, nomor_hp, status) 
                VALUES ('$nama', '$alamat', '$nomor_hp', 'pending')";
        
        if (query($sql)) {
            $success = true;
            header('Location: register-success.php');
            exit;
        } else {
            $error = 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Pendaftaran Orang Tua</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="assets/css/style.css" />
    <style>
      .error-message {
        background: #fee;
        border: 1px solid #fcc;
        color: #c33;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: center;
      }
    </style>
  </head>
  <body data-page="register">
    <main class="register-layout">
      <article class="register-card card">
        <header class="register-header">
          <h1>Pendaftaran Orang Tua / Wali</h1>
          <p>
            Silakan isi data berikut untuk mendaftarkan calon siswa SDN 1 UNDUOLO.
            Setelah mengirim formulir, Anda akan menerima instruksi lanjutan.
          </p>
        </header>

        <?php if ($error): ?>
          <div class="error-message">
            <i class="fa-solid fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
          </div>
        <?php endif; ?>

        <form id="registerForm" class="register-form" method="POST" action="">
          <label class="form-group">
            <span><i class="fa-solid fa-user"></i> Nama Lengkap Orang Tua / Wali</span>
            <input type="text" name="nama" placeholder="Contoh: Bapak Andi Saputra" required value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>" />
          </label>
          <label class="form-group">
            <span><i class="fa-solid fa-location-dot"></i> Alamat Lengkap</span>
            <textarea
              name="alamat"
              placeholder="Tuliskan alamat domisili lengkap beserta RT/RW."
              rows="3"
              required
            ><?php echo isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : ''; ?></textarea>
          </label>
          <label class="form-group">
            <span><i class="fa-solid fa-phone"></i> Nomor HP Aktif</span>
            <input type="tel" name="nomor_hp" placeholder="Contoh: 0812-XXXX-XXXX" required value="<?php echo isset($_POST['nomor_hp']) ? htmlspecialchars($_POST['nomor_hp']) : ''; ?>" />
          </label>

          <button class="btn" type="submit" data-success-url="register-success.php">
            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
            <span>Kirim Pendaftaran</span>
          </button>
        </form>

        <footer class="register-footer">
          <p>
            Butuh bantuan? Hubungi admin sekolah melalui WhatsApp
            <strong>0851-1234-5678</strong> (Jam layanan 08.00–15.00 WITA).
          </p>
        </footer>
      </article>
    </main>

    <script src="assets/js/script.js"></script>
  </body>
</html>

