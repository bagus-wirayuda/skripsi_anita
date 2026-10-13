<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['guru']);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Dashboard Guru</title>
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
  <body data-page="guru-dashboard">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Guru'); ?></h1>
          <button class="btn" type="button" data-alert="Belum ada pengumuman baru dari sekolah.">
            <i class="fa-solid fa-bell" aria-hidden="true"></i>
            <span>Pengumuman</span>
          </button>
        </header>

        <section aria-labelledby="ringkasan-guru">
          <h2 id="ringkasan-guru" class="section-title">Ringkasan Kegiatan Hari Ini</h2>
          <div class="grid grid-3">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-users-rectangle"></i> Kelas Pagi</p>
              <p class="card__value">5A - Matematika</p>
              <small>07.30 - 09.00</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-users-rectangle"></i> Kelas Siang</p>
              <p class="card__value">4B - IPA</p>
              <small>11.00 - 12.30</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-calendar-check"></i> Agenda Khusus</p>
              <p class="card__value">Rapat Kurikulum</p>
              <small>15.00 - Ruang Guru</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="catatan-kehadiran">
          <h2 id="catatan-kehadiran" class="section-title">Catatan Kehadiran Terbaru</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Nama Siswa</th>
                  <th>Kelas</th>
                  <th>Tanggal</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Dina Maharani</td>
                  <td>5A</td>
                  <td>12 Nov 2025</td>
                  <td><span class="badge status--hadir">Hadir</span></td>
                </tr>
                <tr>
                  <td>Ahmad Fauzi</td>
                  <td>5A</td>
                  <td>12 Nov 2025</td>
                  <td><span class="badge status--izin">Izin</span></td>
                </tr>
                <tr>
                  <td>Nadia Prameswari</td>
                  <td>4B</td>
                  <td>12 Nov 2025</td>
                  <td><span class="badge status--hadir">Hadir</span></td>
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


