<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['admin']);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Jadwal Pelajaran</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css" />
  </head>
  <body data-page="admin-jadwal">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Jadwal Pelajaran Mingguan</h1>
          <button class="btn" type="button" data-alert="Form tambah jadwal akan dihubungkan ke database pada pengembangan berikutnya.">
            <i class="fa-solid fa-plus" aria-hidden="true"></i>
            <span>Tambah Jadwal</span>
          </button>
        </header>

        <section aria-labelledby="jadwal-kelas">
          <h2 id="jadwal-kelas" class="section-title">Daftar Jadwal Kelas</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Hari</th>
                  <th>Waktu</th>
                  <th>Kelas</th>
                  <th>Mata Pelajaran</th>
                  <th>Guru</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Senin</td>
                  <td>07.30 - 09.00</td>
                  <td>5A</td>
                  <td>Matematika</td>
                  <td>Ibu Ratna</td>
                </tr>
                <tr>
                  <td>Senin</td>
                  <td>09.15 - 10.45</td>
                  <td>5A</td>
                  <td>Bahasa Indonesia</td>
                  <td>Bapak Dimas</td>
                </tr>
                <tr>
                  <td>Selasa</td>
                  <td>07.30 - 09.00</td>
                  <td>4B</td>
                  <td>IPA</td>
                  <td>Ibu Sari</td>
                </tr>
                <tr>
                  <td>Rabu</td>
                  <td>08.00 - 09.30</td>
                  <td>6C</td>
                  <td>IPS</td>
                  <td>Bapak Yoga</td>
                </tr>
                <tr>
                  <td>Kamis</td>
                  <td>09.45 - 11.15</td>
                  <td>3A</td>
                  <td>Bahasa Inggris</td>
                  <td>Ibu Putri</td>
                </tr>
                <tr>
                  <td>Jumat</td>
                  <td>07.30 - 09.00</td>
                  <td>2B</td>
                  <td>Seni Budaya</td>
                  <td>Ibu Lestari</td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>
      </main>
    </div>

    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
  </body>
</html>


