<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['kepalasekolah']);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Laporan Absensi Guru</title>
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
  <body data-page="kepala-laporan-absensi-guru">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Laporan Absensi Guru</h1>
          <button class="btn" type="button" data-alert="Ekspor rekap absensi guru dapat ditambahkan; gunakan cetak halaman jika diperlukan.">
            <i class="fa-solid fa-file-export" aria-hidden="true"></i>
            <span>Ekspor Data</span>
          </button>
        </header>

        <section aria-labelledby="statistik-absensi-guru">
          <h2 id="statistik-absensi-guru" class="section-title">Statistik Absensi Guru</h2>
          <div class="stats-grid">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-calendar-check"></i> Rata-rata Kehadiran</p>
              <p class="card__value">98%</p>
              <small>Bulan ini</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-check"></i> Guru Hadir</p>
              <p class="card__value">76</p>
              <small>Dari 78 guru</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-clock"></i> Izin</p>
              <p class="card__value">2</p>
              <small>Bulan ini</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-xmark"></i> Tidak Hadir</p>
              <p class="card__value">0</p>
              <small>Bulan ini</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="rekap-absensi-guru">
          <h2 id="rekap-absensi-guru" class="section-title">Rekap Absensi Guru</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Nama Guru</th>
                  <th>Mata Pelajaran</th>
                  <th>Kehadiran</th>
                  <th>Izin</th>
                  <th>Persentase</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Ibu Yuni</td>
                  <td>Kelas 1A</td>
                  <td>22</td>
                  <td>0</td>
                  <td>100%</td>
                  <td><span class="badge status--hadir">Sempurna</span></td>
                </tr>
                <tr>
                  <td>Bapak Rico</td>
                  <td>Matematika</td>
                  <td>21</td>
                  <td>1</td>
                  <td>95.5%</td>
                  <td><span class="badge status--hadir">Baik</span></td>
                </tr>
                <tr>
                  <td>Ibu Sinta</td>
                  <td>Kelas 4C</td>
                  <td>22</td>
                  <td>0</td>
                  <td>100%</td>
                  <td><span class="badge status--hadir">Sempurna</span></td>
                </tr>
                <tr>
                  <td>Ibu Ratna</td>
                  <td>Kelas 5A</td>
                  <td>22</td>
                  <td>0</td>
                  <td>100%</td>
                  <td><span class="badge status--hadir">Sempurna</span></td>
                </tr>
                <tr>
                  <td>Bapak Yoga</td>
                  <td>Kelas 6B</td>
                  <td>21</td>
                  <td>1</td>
                  <td>95.5%</td>
                  <td><span class="badge status--hadir">Baik</span></td>
                </tr>
                <tr>
                  <td>Ibu Sari</td>
                  <td>Bahasa Indonesia</td>
                  <td>22</td>
                  <td>0</td>
                  <td>100%</td>
                  <td><span class="badge status--hadir">Sempurna</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

        <section aria-labelledby="catatan-absensi-guru">
          <h2 id="catatan-absensi-guru" class="section-title">Catatan</h2>
          <div class="grid grid-2">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-check-circle"></i> Pencapaian</p>
              <p>Kehadiran guru stabil di 98%. Semua guru telah memenuhi standar minimal kehadiran 95%.</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-lightbulb"></i> Rekomendasi</p>
              <p>Lakukan monitoring rutin setiap awal pekan dan apresiasi untuk guru dengan kehadiran sempurna.</p>
            </article>
          </div>
        </section>
      </main>
    </div>

    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
  </body>
</html>

