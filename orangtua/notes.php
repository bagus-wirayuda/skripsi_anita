<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['orangtua']);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Notes Anak</title>
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
  <body data-page="orangtua-notes">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Catatan dari Guru</h1>
          <button class="btn" type="button" data-alert="Filter lanjutan dapat ditambahkan; saat ini daftar ditampilkan lengkap di halaman ini.">
            <i class="fa-solid fa-filter" aria-hidden="true"></i>
            <span>Filter</span>
          </button>
        </header>

        <section aria-labelledby="info-notes">
          <div class="card" style="background: rgba(33, 150, 243, 0.08); border-left: 4px solid #2196f3; margin-bottom: 24px;">
            <p style="margin: 0; display: flex; align-items: center; gap: 8px;">
              <i class="fa-solid fa-info-circle" style="color: #2196f3;"></i>
              <span>Catatan di bawah ini adalah catatan yang diberikan oleh guru untuk Salsabila Pratama (Kelas 5A).</span>
            </p>
          </div>
        </section>

        <section aria-labelledby="daftar-notes">
          <h2 id="daftar-notes" class="section-title">Semua Catatan</h2>
          <div class="grid grid-2">
            <article class="card">
              <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                <p class="card__title" style="margin: 0;">
                  <i class="fa-solid fa-note-sticky"></i> Peningkatan dalam Matematika
                </p>
                <span class="badge" style="background: rgba(76, 175, 80, 0.15); color: #2e7d32;">
                  Prestasi
                </span>
              </div>
              <p style="margin: 12px 0; color: rgba(0, 0, 0, 0.8);">
                Salsabila menunjukkan peningkatan yang signifikan dalam memahami konsep pecahan. 
                Terus semangat belajar dan pertahankan konsistensi!
              </p>
              <div style="display: flex; align-items: center; gap: 16px; margin-top: 16px; padding-top: 12px; border-top: 1px solid rgba(0, 0, 0, 0.1);">
                <small style="color: rgba(0, 0, 0, 0.6);">
                  <i class="fa-solid fa-user-chalkboard"></i> Ibu Ratna - Guru Matematika
                </small>
                <small style="color: rgba(0, 0, 0, 0.6);">
                  <i class="fa-solid fa-calendar"></i> 12 Nov 2025
                </small>
              </div>
            </article>

            <article class="card">
              <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                <p class="card__title" style="margin: 0;">
                  <i class="fa-solid fa-note-sticky"></i> Partisipasi Aktif di Kelas
                </p>
                <span class="badge" style="background: rgba(33, 150, 243, 0.15); color: #1976d2;">
                  Akademik
                </span>
              </div>
              <p style="margin: 12px 0; color: rgba(0, 0, 0, 0.8);">
                Salsabila sangat aktif bertanya dan menjawab pertanyaan saat pembelajaran IPA. 
                Pertahankan semangat belajar dan keberanian untuk berpartisipasi!
              </p>
              <div style="display: flex; align-items: center; gap: 16px; margin-top: 16px; padding-top: 12px; border-top: 1px solid rgba(0, 0, 0, 0.1);">
                <small style="color: rgba(0, 0, 0, 0.6);">
                  <i class="fa-solid fa-user-chalkboard"></i> Ibu Sari - Guru IPA
                </small>
                <small style="color: rgba(0, 0, 0, 0.6);">
                  <i class="fa-solid fa-calendar"></i> 11 Nov 2025
                </small>
              </div>
            </article>

            <article class="card">
              <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                <p class="card__title" style="margin: 0;">
                  <i class="fa-solid fa-note-sticky"></i> Perilaku yang Baik
                </p>
                <span class="badge" style="background: rgba(255, 193, 7, 0.15); color: #f57f17;">
                  Perilaku
                </span>
              </div>
              <p style="margin: 12px 0; color: rgba(0, 0, 0, 0.8);">
                Salsabila selalu menunjukkan sikap hormat kepada guru dan teman-temannya. 
                Terima kasih atas dukungan keluarga dalam membentuk karakter yang baik.
              </p>
              <div style="display: flex; align-items: center; gap: 16px; margin-top: 16px; padding-top: 12px; border-top: 1px solid rgba(0, 0, 0, 0.1);">
                <small style="color: rgba(0, 0, 0, 0.6);">
                  <i class="fa-solid fa-user-chalkboard"></i> Ibu Ratna - Wali Kelas
                </small>
                <small style="color: rgba(0, 0, 0, 0.6);">
                  <i class="fa-solid fa-calendar"></i> 08 Nov 2025
                </small>
              </div>
            </article>

            <article class="card">
              <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                <p class="card__title" style="margin: 0;">
                  <i class="fa-solid fa-note-sticky"></i> Peningkatan Berhitung
                </p>
                <span class="badge" style="background: rgba(76, 175, 80, 0.15); color: #2e7d32;">
                  Prestasi
                </span>
              </div>
              <p style="margin: 12px 0; color: rgba(0, 0, 0, 0.8);">
                Anak menunjukkan kemajuan yang baik dalam kemampuan berhitung cepat. 
                Latihan di rumah sangat membantu perkembangan belajarnya.
              </p>
              <div style="display: flex; align-items: center; gap: 16px; margin-top: 16px; padding-top: 12px; border-top: 1px solid rgba(0, 0, 0, 0.1);">
                <small style="color: rgba(0, 0, 0, 0.6);">
                  <i class="fa-solid fa-user-chalkboard"></i> Ibu Ratna - Guru Matematika
                </small>
                <small style="color: rgba(0, 0, 0, 0.6);">
                  <i class="fa-solid fa-calendar"></i> 05 Nov 2025
                </small>
              </div>
            </article>
          </div>
        </section>

        <section aria-labelledby="riwayat-notes">
          <h2 id="riwayat-notes" class="section-title">Riwayat Catatan Lainnya</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Kategori</th>
                  <th>Judul</th>
                  <th>Guru</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>03 Nov 2025</td>
                  <td><span class="badge" style="background: rgba(33, 150, 243, 0.15); color: #1976d2;">Akademik</span></td>
                  <td>Peningkatan Membaca</td>
                  <td>Ibu Sari</td>
                </tr>
                <tr>
                  <td>01 Nov 2025</td>
                  <td><span class="badge" style="background: rgba(156, 39, 176, 0.15); color: #7b1fa2;">Sosial</span></td>
                  <td>Kerjasama dalam Kelompok</td>
                  <td>Ibu Ratna</td>
                </tr>
                <tr>
                  <td>28 Okt 2025</td>
                  <td><span class="badge" style="background: rgba(76, 175, 80, 0.15); color: #2e7d32;">Prestasi</span></td>
                  <td>Berhasil Menyelesaikan Proyek</td>
                  <td>Ibu Sari</td>
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

