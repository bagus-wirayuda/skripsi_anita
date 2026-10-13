<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['kepalasekolah']);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Dashboard Kepala Sekolah</title>
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
  <body data-page="kepala-dashboard">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Ikhtisar Sekolah</h1>
          <button class="btn" type="button" data-alert="Berbagi ringkasan ke stakeholder dapat menggunakan ekspor laporan (fitur lanjutan).">
            <i class="fa-solid fa-share-nodes" aria-hidden="true"></i>
            <span>Bagikan Insight</span>
          </button>
        </header>

        <section aria-labelledby="statistik-global">
          <h2 id="statistik-global" class="section-title">Statistik Global</h2>
          <div class="stats-grid">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-graduate"></i> Total Siswa</p>
              <p class="card__value">1.250</p>
              <small>Seluruh jenjang kelas 1 - 6</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-person-chalkboard"></i> Total Guru</p>
              <p class="card__value">78</p>
              <small>Pengajar aktif dan tenaga pendamping</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-calendar-check"></i> Presensi Rata-rata</p>
              <p class="card__value">94%</p>
              <small>Akumulasi semester berjalan</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-trophy"></i> Rata-rata Nilai</p>
              <p class="card__value">86</p>
              <small>Gabungan seluruh mata pelajaran</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="highlight-laporan">
          <h2 id="highlight-laporan" class="section-title">Sorotan Laporan Terbaru</h2>
          <div class="grid grid-2">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-school-flag"></i> Program Literasi</p>
              <p>Partisipasi siswa mencapai 92%, perlu tindak lanjut pada kelas 2B dan 3A.</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-person-circle-check"></i> Kehadiran Guru</p>
              <p>Kehadiran guru stabil di 98%. Lakukan monitoring rutin setiap awal pekan.</p>
            </article>
          </div>
        </section>
      </main>
    </div>

    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
  </body>
</html>


