<?php
require_once __DIR__.'/config/app.php';
$error='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
 try {
  $nama=textInput('nama',100); $alamat=textInput('alamat',1000); $hp=textInput('nomor_hp',20);
  need((bool)preg_match('/^(?:0|62|\+62)[0-9]{8,14}$/',$hp),'Nomor HP harus berupa nomor Indonesia yang valid tanpa spasi.');
  $username=textInput('username',50); $password=textInput('password',100);
  need((bool)preg_match('/^[a-zA-Z0-9_.-]{3,50}$/',$username),'Username minimal 3 karakter, hanya huruf, angka, titik, garis bawah atau tanda hubung.');
  need(strlen($password)>=8,'Password minimal 8 karakter.');
  getDB()->begin_transaction();
  dbRun("INSERT INTO users (username,password,role,nama_lengkap,status) VALUES (?,?,'orangtua',?,'nonaktif')",[$username,hashPassword($password),$nama]);
  $uid=lastInsertId();
  dbRun("INSERT INTO orangtua (nama,alamat,nomor_hp,user_id,status) VALUES (?,?,?,?,'pending')",[$nama,$alamat,$hp,$uid]);
  getDB()->commit(); header('Location: register-success.php'); exit;
 } catch(Throwable $ex) { getDB()->rollback(); $error=actionError($ex); }
}
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Pendaftaran Orang Tua</title>
    <link
      rel="stylesheet"
      href="assets/vendor/fontawesome/css/all.min.css"
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

        <form id="registerForm" class="register-form" method="POST" action=""><?=csrfField()?>
<div class="form-group"><label for="username">Username akun</label><input id="username" name="username" required minlength="3" maxlength="50" autocomplete="username" value="<?=e($_POST['username']??'')?>"></div>
<div class="form-group"><label for="password">Password (minimal 8 karakter)</label><input id="password" name="password" type="password" required minlength="8" autocomplete="new-password"></div>
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
            <input type="tel" name="nomor_hp" placeholder="Contoh: 081234567890" required value="<?php echo isset($_POST['nomor_hp']) ? htmlspecialchars($_POST['nomor_hp']) : ''; ?>" />
          </label>

          <button class="btn" type="submit" data-success-url="register-success.php">
            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
            <span>Kirim Pendaftaran</span>
          </button>
        </form>

        <footer class="register-footer">
          <p>Butuh bantuan? Hubungi tata usaha sekolah untuk verifikasi akun dan informasi pendaftaran.</p>
        </footer>
      </article>
    </main>

    <script src="assets/js/script.js"></script>
  </body>
</html>

