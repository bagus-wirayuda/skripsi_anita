<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['kepalasekolah']);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Evaluasi Pembelajaran</title>
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
  <body data-page="kepala-evaluasi-pembelajaran">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Evaluasi Pembelajaran</h1>
          <button class="btn" type="button" data-alert="Ekspor laporan evaluasi dapat ditambahkan; gunakan cetak halaman jika diperlukan.">
            <i class="fa-solid fa-file-export" aria-hidden="true"></i>
            <span>Ekspor Laporan</span>
          </button>
        </header>

        <section aria-labelledby="ringkasan-evaluasi">
          <h2 id="ringkasan-evaluasi" class="section-title">Ringkasan Evaluasi</h2>
          <div class="stats-grid">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-star"></i> Skor Evaluasi</p>
              <p class="card__value">4.2</p>
              <small>Dari skala 5.0</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-chalkboard"></i> Metode Pembelajaran</p>
              <p class="card__value">4.3</p>
              <small>Rata-rata penilaian</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-book-open"></i> Materi Pembelajaran</p>
              <p class="card__value">4.1</p>
              <small>Rata-rata penilaian</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-arrow-trend-up"></i> Peningkatan</p>
              <p class="card__value">+0.3</p>
              <small>Dibanding semester lalu</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="evaluasi-kelas">
          <h2 id="evaluasi-kelas" class="section-title">Evaluasi per Kelas</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Kelas</th>
                  <th>Wali Kelas</th>
                  <th>Metode</th>
                  <th>Materi</th>
                  <th>Interaksi</th>
                  <th>Skor Total</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1A</td>
                  <td>Ibu Yuni</td>
                  <td>4.5</td>
                  <td>4.3</td>
                  <td>4.4</td>
                  <td>4.4</td>
                  <td><span class="badge status--hadir">Sangat Baik</span></td>
                </tr>
                <tr>
                  <td>2B</td>
                  <td>Ibu Sari</td>
                  <td>4.0</td>
                  <td>3.9</td>
                  <td>4.1</td>
                  <td>4.0</td>
                  <td><span class="badge status--hadir">Baik</span></td>
                </tr>
                <tr>
                  <td>3B</td>
                  <td>Bapak Rico</td>
                  <td>4.2</td>
                  <td>4.1</td>
                  <td>4.0</td>
                  <td>4.1</td>
                  <td><span class="badge status--hadir">Baik</span></td>
                </tr>
                <tr>
                  <td>4C</td>
                  <td>Ibu Sinta</td>
                  <td>3.8</td>
                  <td>3.9</td>
                  <td>3.7</td>
                  <td>3.8</td>
                  <td><span class="badge status--izin">Perlu Peningkatan</span></td>
                </tr>
                <tr>
                  <td>5A</td>
                  <td>Ibu Ratna</td>
                  <td>4.6</td>
                  <td>4.5</td>
                  <td>4.6</td>
                  <td>4.6</td>
                  <td><span class="badge status--hadir">Sangat Baik</span></td>
                </tr>
                <tr>
                  <td>6B</td>
                  <td>Bapak Yoga</td>
                  <td>4.4</td>
                  <td>4.3</td>
                  <td>4.5</td>
                  <td>4.4</td>
                  <td><span class="badge status--hadir">Sangat Baik</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

        <section aria-labelledby="aspek-evaluasi">
          <h2 id="aspek-evaluasi" class="section-title">Aspek Evaluasi</h2>
          <div class="grid grid-2">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-lightbulb"></i> Kreativitas Metode</p>
              <p>Guru menggunakan berbagai metode pembelajaran yang menarik dan sesuai dengan karakteristik siswa.</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-book"></i> Kualitas Materi</p>
              <p>Materi pembelajaran disampaikan dengan jelas dan mudah dipahami oleh siswa.</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-comments"></i> Interaksi Pembelajaran</p>
              <p>Interaksi antara guru dan siswa berjalan dengan baik, menciptakan suasana belajar yang kondusif.</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-target"></i> Pencapaian Tujuan</p>
              <p>Sebagian besar tujuan pembelajaran tercapai dengan baik, namun masih ada ruang untuk peningkatan.</p>
            </article>
          </div>
        </section>

        <section aria-labelledby="rekomendasi">
          <h2 id="rekomendasi" class="section-title">Rekomendasi</h2>
          <div class="grid grid-2">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-arrow-up"></i> Peningkatan</p>
              <p>Kelas 4C perlu mendapat perhatian khusus untuk meningkatkan kualitas pembelajaran. Lakukan pendampingan intensif.</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-trophy"></i> Apresiasi</p>
              <p>Kelas 1A, 5A, dan 6B menunjukkan performa pembelajaran yang sangat baik. Pertahankan dan jadikan sebagai contoh.</p>
            </article>
          </div>
        </section>
      </main>
    </div>

    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
  </body>
</html>

