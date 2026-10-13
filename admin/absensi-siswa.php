<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['admin']);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Absensi Siswa</title>
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
  <body data-page="admin-absensi">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Absensi Siswa</h1>
          <button class="btn" type="button" data-alert="Ekspor rekap absensi (CSV/PDF) dapat ditambahkan ke sistem ini.">
            <i class="fa-solid fa-download" aria-hidden="true"></i>
            <span>Unduh Rekap</span>
          </button>
        </header>

        <section aria-labelledby="filter-absensi">
          <h2 id="filter-absensi" class="section-title">Filter Kehadiran</h2>
          <div class="grid grid-3">
            <label class="card">
              <span class="card__title"><i class="fa-solid fa-school"></i> Kelas</span>
              <select class="input-inline">
                <option>Semua Kelas</option>
                <option>1A</option>
                <option>2B</option>
                <option>4C</option>
                <option>5A</option>
              </select>
            </label>
            <label class="card">
              <span class="card__title"><i class="fa-solid fa-calendar-day"></i> Tanggal</span>
              <input class="input-inline" type="date" />
            </label>
            <label class="card">
              <span class="card__title"><i class="fa-solid fa-filter"></i> Status</span>
              <select class="input-inline">
                <option>Semua Status</option>
                <option>Hadir</option>
                <option>Izin</option>
                <option>Alpa</option>
              </select>
            </label>
          </div>
        </section>

        <section aria-labelledby="tabel-absensi">
          <h2 id="tabel-absensi" class="section-title">Daftar Kehadiran Harian</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Nama Siswa</th>
                  <th>Kelas</th>
                  <th>Status</th>
                  <th>Jam Masuk</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>13 Nov 2025</td>
                  <td>Andi Prakoso</td>
                  <td>5A</td>
                  <td><span class="badge status--hadir">Hadir</span></td>
                  <td>07:21</td>
                  <td>-</td>
                </tr>
                <tr>
                  <td>13 Nov 2025</td>
                  <td>Ratna Dewi</td>
                  <td>5A</td>
                  <td><span class="badge status--hadir">Hadir</span></td>
                  <td>07:25</td>
                  <td>-</td>
                </tr>
                <tr>
                  <td>13 Nov 2025</td>
                  <td>Bagas Maulana</td>
                  <td>5A</td>
                  <td><span class="badge status--izin">Izin</span></td>
                  <td>-</td>
                  <td>Sakit ringan</td>
                </tr>
                <tr>
                  <td>13 Nov 2025</td>
                  <td>Citra Nabila</td>
                  <td>4B</td>
                  <td><span class="badge status--alpha">Alpa</span></td>
                  <td>-</td>
                  <td>Belum ada konfirmasi</td>
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

