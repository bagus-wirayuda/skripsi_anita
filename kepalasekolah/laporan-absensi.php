<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['kepalasekolah']);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Laporan Absensi</title>
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
  <body data-page="kepala-laporan-absensi">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Laporan Absensi Umum</h1>
          <button class="btn" type="button" data-alert="Ekspor ringkasan absensi dapat ditambahkan; gunakan cetak halaman jika diperlukan.">
            <i class="fa-solid fa-file-export" aria-hidden="true"></i>
            <span>Ekspor Data</span>
          </button>
        </header>

        <section aria-labelledby="ringkasan-absensi">
          <h2 id="ringkasan-absensi" class="section-title">Ringkasan Absensi</h2>
          <div class="stats-grid">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-users"></i> Total Kehadiran</p>
              <p class="card__value">94%</p>
              <small>Gabungan guru dan siswa</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-calendar-days"></i> Hari Aktif</p>
              <p class="card__value">22</p>
              <small>Bulan ini</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-chart-bar"></i> Tren Kehadiran</p>
              <p class="card__value">+2.1%</p>
              <small>Dibanding bulan lalu</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-check-double"></i> Target Tercapai</p>
              <p class="card__value">95%</p>
              <small>Dari target 90%</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="perbandingan-absensi">
          <h2 id="perbandingan-absensi" class="section-title">Perbandingan Absensi</h2>
          <div class="grid grid-2">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-chalkboard-user"></i> Absensi Guru</p>
              <p class="card__value">98%</p>
              <p>76 dari 78 guru hadir | 2 izin | 0 tidak hadir</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-graduate"></i> Absensi Siswa</p>
              <p class="card__value">94%</p>
              <p>1,175 dari 1,250 siswa hadir | 50 izin | 25 tidak hadir</p>
            </article>
          </div>
        </section>

        <section aria-labelledby="rekap-harian">
          <h2 id="rekap-harian" class="section-title">Rekap Harian (Minggu Terakhir)</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Guru Hadir</th>
                  <th>Siswa Hadir</th>
                  <th>Total Kehadiran</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Senin, 20 Jan 2025</td>
                  <td>78/78 (100%)</td>
                  <td>1,200/1,250 (96%)</td>
                  <td>97.2%</td>
                  <td><span class="badge status--hadir">Sempurna</span></td>
                </tr>
                <tr>
                  <td>Selasa, 21 Jan 2025</td>
                  <td>77/78 (98.7%)</td>
                  <td>1,180/1,250 (94.4%)</td>
                  <td>95.1%</td>
                  <td><span class="badge status--hadir">Baik</span></td>
                </tr>
                <tr>
                  <td>Rabu, 22 Jan 2025</td>
                  <td>78/78 (100%)</td>
                  <td>1,175/1,250 (94%)</td>
                  <td>95.3%</td>
                  <td><span class="badge status--hadir">Baik</span></td>
                </tr>
                <tr>
                  <td>Kamis, 23 Jan 2025</td>
                  <td>76/78 (97.4%)</td>
                  <td>1,170/1,250 (93.6%)</td>
                  <td>94.2%</td>
                  <td><span class="badge status--hadir">Baik</span></td>
                </tr>
                <tr>
                  <td>Jumat, 24 Jan 2025</td>
                  <td>78/78 (100%)</td>
                  <td>1,185/1,250 (94.8%)</td>
                  <td>95.6%</td>
                  <td><span class="badge status--hadir">Baik</span></td>
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

