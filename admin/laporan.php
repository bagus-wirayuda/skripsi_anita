<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['admin']);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Laporan Presensi</title>
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
  <body data-page="admin-laporan">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Laporan Presensi Siswa</h1>
          <button class="btn" type="button" data-alert="Fitur berbagi laporan (PDF/email) dapat ditambahkan kemudian. Untuk sementara gunakan cetak halaman (Ctrl+P).">
            <i class="fa-solid fa-share-from-square" aria-hidden="true"></i>
            <span>Bagikan</span>
          </button>
        </header>

        <section aria-labelledby="ringkasan-laporan">
          <h2 id="ringkasan-laporan" class="section-title">Ringkasan Laporan</h2>
          <div class="grid grid-3">
            <article class="card">
              <p class="card__title">
                <i class="fa-solid fa-graduation-cap"></i> Laporan Akademik
              </p>
              <p class="card__value">85%</p>
              <small>Nilai rata-rata semester, termasuk tren kenaikan 3%.</small>
            </article>
            <article class="card">
              <p class="card__title">
                <i class="fa-solid fa-user-check"></i> Laporan Absensi Siswa
              </p>
              <p class="card__value">94%</p>
              <small>Kehadiran keseluruhan 4 minggu terakhir.</small>
            </article>
            <article class="card">
              <p class="card__title">
                <i class="fa-solid fa-lightbulb"></i> Evaluasi Pembelajaran
              </p>
              <p class="card__value">76%</p>
              <small>Feedback positif terhadap metode pengajaran terbaru.</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="filter-presensi">
          <h2 id="filter-presensi" class="section-title">Filter Laporan</h2>
          <div class="grid grid-3">
            <label class="card">
              <span class="card__title"><i class="fa-solid fa-users"></i> Pilih Kelas</span>
              <select class="input-inline">
                <option>Semua Kelas</option>
                <option>1A</option>
                <option>2B</option>
                <option>3C</option>
                <option>4A</option>
              </select>
            </label>
            <label class="card">
              <span class="card__title"><i class="fa-solid fa-calendar-week"></i> Rentang Tanggal</span>
              <input class="input-inline" type="date" />
            </label>
            <label class="card">
              <span class="card__title"><i class="fa-solid fa-calendar-week"></i> Sampai</span>
              <input class="input-inline" type="date" />
            </label>
          </div>
        </section>

        <section aria-labelledby="tabel-presensi">
          <h2 id="tabel-presensi" class="section-title">Rekap Presensi</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Nama Siswa</th>
                  <th>Tanggal</th>
                  <th>Kelas</th>
                  <th>Status</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Ayu Pratiwi</td>
                  <td>13 Nov 2025</td>
                  <td>5A</td>
                  <td><span class="badge status--hadir">Hadir</span></td>
                  <td>-</td>
                </tr>
                <tr>
                  <td>Bagas Maulana</td>
                  <td>13 Nov 2025</td>
                  <td>5A</td>
                  <td><span class="badge status--izin">Izin</span></td>
                  <td>Sakit ringan</td>
                </tr>
                <tr>
                  <td>Citra Nabila</td>
                  <td>13 Nov 2025</td>
                  <td>5A</td>
                  <td><span class="badge status--hadir">Hadir</span></td>
                  <td>-</td>
                </tr>
                <tr>
                  <td>Dimas Wicaksono</td>
                  <td>13 Nov 2025</td>
                  <td>5A</td>
                  <td><span class="badge status--alpha">Alpa</span></td>
                  <td>Tidak ada kabar</td>
                </tr>
                <tr>
                  <td>Eka Sari</td>
                  <td>13 Nov 2025</td>
                  <td>5A</td>
                  <td><span class="badge status--hadir">Hadir</span></td>
                  <td>-</td>
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


