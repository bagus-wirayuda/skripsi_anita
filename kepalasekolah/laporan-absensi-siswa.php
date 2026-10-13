<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['kepalasekolah']);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Laporan Absensi Siswa</title>
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
  <body data-page="kepala-laporan-absensi-siswa">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Laporan Absensi Siswa</h1>
          <button class="btn" type="button" data-alert="Ekspor rekap absensi siswa dapat ditambahkan; gunakan cetak halaman jika diperlukan.">
            <i class="fa-solid fa-file-export" aria-hidden="true"></i>
            <span>Ekspor Data</span>
          </button>
        </header>

        <section aria-labelledby="statistik-absensi-siswa">
          <h2 id="statistik-absensi-siswa" class="section-title">Statistik Absensi Siswa</h2>
          <div class="stats-grid">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-calendar-check"></i> Rata-rata Kehadiran</p>
              <p class="card__value">94%</p>
              <small>Bulan ini</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-check"></i> Siswa Hadir</p>
              <p class="card__value">1,175</p>
              <small>Dari 1,250 siswa</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-clock"></i> Izin</p>
              <p class="card__value">50</p>
              <small>Bulan ini</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-xmark"></i> Tidak Hadir</p>
              <p class="card__value">25</p>
              <small>Bulan ini</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="rekap-absensi-kelas">
          <h2 id="rekap-absensi-kelas" class="section-title">Rekap Absensi per Kelas</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Kelas</th>
                  <th>Wali Kelas</th>
                  <th>Hadir</th>
                  <th>Izin</th>
                  <th>Tidak Hadir</th>
                  <th>Persentase</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1A</td>
                  <td>Ibu Yuni</td>
                  <td>39</td>
                  <td>1</td>
                  <td>0</td>
                  <td>97.5%</td>
                  <td><span class="badge status--hadir">Sangat Baik</span></td>
                </tr>
                <tr>
                  <td>2B</td>
                  <td>Ibu Sari</td>
                  <td>36</td>
                  <td>3</td>
                  <td>1</td>
                  <td>90%</td>
                  <td><span class="badge status--izin">Perlu Perhatian</span></td>
                </tr>
                <tr>
                  <td>3B</td>
                  <td>Bapak Rico</td>
                  <td>39</td>
                  <td>2</td>
                  <td>1</td>
                  <td>92.9%</td>
                  <td><span class="badge status--hadir">Baik</span></td>
                </tr>
                <tr>
                  <td>4C</td>
                  <td>Ibu Sinta</td>
                  <td>35</td>
                  <td>3</td>
                  <td>2</td>
                  <td>87.5%</td>
                  <td><span class="badge status--alpha">Monitoring</span></td>
                </tr>
                <tr>
                  <td>5A</td>
                  <td>Ibu Ratna</td>
                  <td>39</td>
                  <td>1</td>
                  <td>0</td>
                  <td>97.5%</td>
                  <td><span class="badge status--hadir">Sangat Baik</span></td>
                </tr>
                <tr>
                  <td>6B</td>
                  <td>Bapak Yoga</td>
                  <td>40</td>
                  <td>2</td>
                  <td>0</td>
                  <td>95.2%</td>
                  <td><span class="badge status--hadir">Sangat Baik</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

        <section aria-labelledby="catatan-absensi-siswa">
          <h2 id="catatan-absensi-siswa" class="section-title">Catatan</h2>
          <div class="grid grid-2">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-exclamation-triangle"></i> Perhatian</p>
              <p>Kelas 4C dan 2B menunjukkan tingkat absensi yang perlu dipantau. Lakukan koordinasi dengan wali kelas dan orang tua.</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-lightbulb"></i> Rekomendasi</p>
              <p>Lakukan pendekatan personal untuk siswa dengan absensi tinggi dan libatkan orang tua dalam program peningkatan kehadiran.</p>
            </article>
          </div>
        </section>
      </main>
    </div>

    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
  </body>
</html>

