<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['orangtua']);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Perkembangan Anak</title>
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
  <body data-page="orangtua-perkembangan">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Perkembangan Anak - Salsabila Pratama</h1>
          <button class="btn" type="button" data-print>
            <i class="fa-solid fa-print" aria-hidden="true"></i>
            <span>Cetak Laporan</span>
          </button>
        </header>

        <section aria-labelledby="nilai-mapel">
          <h2 id="nilai-mapel" class="section-title">Nilai per Mata Pelajaran</h2>
          <div class="grid grid-3">
            <article class="card progress-card">
              <p class="card__title"><i class="fa-solid fa-square-root-variable"></i> Matematika</p>
              <p class="card__value">90</p>
              <div class="progress-bar">
                <span style="width: 90%"></span>
              </div>
            </article>
            <article class="card progress-card">
              <p class="card__title"><i class="fa-solid fa-book"></i> Bahasa Indonesia</p>
              <p class="card__value">85</p>
              <div class="progress-bar">
                <span style="width: 85%"></span>
              </div>
            </article>
            <article class="card progress-card">
              <p class="card__title"><i class="fa-solid fa-flask"></i> IPA</p>
              <p class="card__value">92</p>
              <div class="progress-bar">
                <span style="width: 92%"></span>
              </div>
            </article>
            <article class="card progress-card">
              <p class="card__title"><i class="fa-solid fa-earth-asia"></i> IPS</p>
              <p class="card__value">87</p>
              <div class="progress-bar">
                <span style="width: 87%"></span>
              </div>
            </article>
            <article class="card progress-card">
              <p class="card__title"><i class="fa-solid fa-language"></i> Bahasa Inggris</p>
              <p class="card__value">88</p>
              <div class="progress-bar">
                <span style="width: 88%"></span>
              </div>
            </article>
            <article class="card progress-card">
              <p class="card__title"><i class="fa-solid fa-music"></i> Seni Budaya</p>
              <p class="card__value">94</p>
              <div class="progress-bar">
                <span style="width: 94%"></span>
              </div>
            </article>
          </div>
        </section>

        <section aria-labelledby="absensi-hari-ini">
          <h2 id="absensi-hari-ini" class="section-title">Absensi Hari Ini</h2>
          <div class="card">
            <div class="grid grid-3">
              <article class="card">
                <p class="card__title"><i class="fa-solid fa-calendar-day"></i> Status Hari Ini</p>
                <p class="card__value" style="font-size: 1.2rem;">
                  <span class="badge status--hadir" style="padding: 8px 16px; font-size: 0.9rem;">Hadir</span>
                </p>
                <small>12 November 2025</small>
              </article>
              <article class="card">
                <p class="card__title"><i class="fa-solid fa-clock"></i> Waktu Masuk</p>
                <p class="card__value" style="font-size: 1.4rem;">07:25 WIB</p>
                <small>Tepat waktu</small>
              </article>
              <article class="card">
                <p class="card__title"><i class="fa-solid fa-info-circle"></i> Keterangan</p>
                <p class="card__value" style="font-size: 1rem;">-</p>
                <small>Tidak ada catatan khusus</small>
              </article>
            </div>
          </div>
        </section>

        <section aria-labelledby="statistik-absensi">
          <h2 id="statistik-absensi" class="section-title">Statistik Absensi Bulan Ini</h2>
          <div class="stats-grid">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-calendar-check"></i> Jumlah Kehadiran</p>
              <p class="card__value">19</p>
              <small>Dari 20 hari belajar</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-bed"></i> Sakit</p>
              <p class="card__value">1</p>
              <small>Hari tidak hadir karena sakit</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-envelope-open-text"></i> Izin</p>
              <p class="card__value">0</p>
              <small>Hari dengan izin</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-times-circle"></i> Alpa</p>
              <p class="card__value">0</p>
              <small>Hari tidak hadir tanpa izin</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="detail-absensi">
          <h2 id="detail-absensi" class="section-title">Detail Absensi Bulan Ini</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Status</th>
                  <th>Waktu Masuk</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>01 Nov 2025</td>
                  <td><span class="badge status--hadir">Hadir</span></td>
                  <td>07:20 WIB</td>
                  <td>-</td>
                </tr>
                <tr>
                  <td>02 Nov 2025</td>
                  <td><span class="badge status--hadir">Hadir</span></td>
                  <td>07:25 WIB</td>
                  <td>-</td>
                </tr>
                <tr>
                  <td>03 Nov 2025</td>
                  <td><span class="badge status--sakit">Sakit</span></td>
                  <td>-</td>
                  <td>Demam</td>
                </tr>
                <tr>
                  <td>04 Nov 2025</td>
                  <td><span class="badge status--hadir">Hadir</span></td>
                  <td>07:30 WIB</td>
                  <td>-</td>
                </tr>
                <tr>
                  <td>05 Nov 2025</td>
                  <td><span class="badge status--hadir">Hadir</span></td>
                  <td>07:15 WIB</td>
                  <td>-</td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

        <section aria-labelledby="grafik-perkembangan">
          <h2 id="grafik-perkembangan" class="section-title">Grafik Perkembangan Semester</h2>
          <canvas id="perkembanganChart" width="600" height="320" aria-label="Grafik nilai per bulan" role="img"></canvas>
        </section>
      </main>
    </div>

    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
  </body>
</html>


