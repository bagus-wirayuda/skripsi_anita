<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['guru']);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Laporan Guru</title>
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
  <body data-page="guru-laporan">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Laporan Statistik Kelas</h1>
          <button class="btn" type="button" data-alert="Unduh PDF/Excel dapat ditambahkan; untuk sekarang gunakan cetak halaman (Ctrl+P).">
            <i class="fa-solid fa-download" aria-hidden="true"></i>
            <span>Unduh Laporan</span>
          </button>
        </header>

        <section aria-labelledby="filter-laporan">
          <h2 id="filter-laporan" class="section-title">Filter Laporan</h2>
          <div class="grid grid-3">
            <label class="card">
              <span class="card__title"><i class="fa-solid fa-layer-group"></i> Kelas</span>
              <select class="input-inline" id="filterKelasLaporan">
                <option value="5A">Kelas 5A</option>
                <option value="4B">Kelas 4B</option>
                <option value="3C">Kelas 3C</option>
              </select>
            </label>
            <label class="card">
              <span class="card__title"><i class="fa-solid fa-calendar-week"></i> Periode</span>
              <select class="input-inline" id="filterPeriode">
                <option value="minggu">Minggu Ini</option>
                <option value="bulan">Bulan Ini</option>
                <option value="semester">Semester Ini</option>
              </select>
            </label>
            <label class="card">
              <span class="card__title"><i class="fa-solid fa-calendar"></i> Tanggal</span>
              <input class="input-inline" type="date" id="tanggalLaporan" />
            </label>
          </div>
        </section>

        <section aria-labelledby="statistik-kelas">
          <h2 id="statistik-kelas" class="section-title">Statistik Kelas 5A</h2>
          <div class="stats-grid">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-graduate"></i> Total Siswa</p>
              <p class="card__value">28</p>
              <small>Jumlah siswa aktif di kelas</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-calendar-check"></i> Rata-rata Kehadiran</p>
              <p class="card__value">94%</p>
              <small>Dari total hari belajar bulan ini</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-star"></i> Rata-rata Nilai</p>
              <p class="card__value">85</p>
              <small>Rata-rata nilai seluruh siswa</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-check-circle"></i> Siswa Hadir Hari Ini</p>
              <p class="card__value">26</p>
              <small>2 siswa izin, 0 alpa</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="detail-presensi">
          <h2 id="detail-presensi" class="section-title">Detail Presensi Bulan Ini</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Nama Siswa</th>
                  <th>Hadir</th>
                  <th>Izin</th>
                  <th>Sakit</th>
                  <th>Alpa</th>
                  <th>Persentase</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Andi Prakoso</td>
                  <td>18</td>
                  <td>1</td>
                  <td>0</td>
                  <td>1</td>
                  <td><span class="badge" style="background: rgba(76, 175, 80, 0.15); color: #2e7d32;">90%</span></td>
                </tr>
                <tr>
                  <td>Bella Lestari</td>
                  <td>19</td>
                  <td>1</td>
                  <td>0</td>
                  <td>0</td>
                  <td><span class="badge" style="background: rgba(76, 175, 80, 0.15); color: #2e7d32;">95%</span></td>
                </tr>
                <tr>
                  <td>Chandra Wijaya</td>
                  <td>17</td>
                  <td>0</td>
                  <td>1</td>
                  <td>2</td>
                  <td><span class="badge status--izin">85%</span></td>
                </tr>
                <tr>
                  <td>Dewi Anggraini</td>
                  <td>20</td>
                  <td>0</td>
                  <td>0</td>
                  <td>0</td>
                  <td><span class="badge" style="background: rgba(76, 175, 80, 0.15); color: #2e7d32;">100%</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

        <section aria-labelledby="grafik-statistik">
          <h2 id="grafik-statistik" class="section-title">Grafik Statistik</h2>
          <div class="grid grid-2">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-chart-column"></i> Tren Kehadiran</p>
              <canvas id="chartKehadiran" width="400" height="200"></canvas>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-chart-line"></i> Tren Nilai</p>
              <canvas id="chartNilai" width="400" height="200"></canvas>
            </article>
          </div>
        </section>
      </main>
    </div>

    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
  </body>
</html>

