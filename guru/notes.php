<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['guru']);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Notes Guru</title>
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
  <body data-page="guru-notes">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Notes / Catatan Siswa</h1>
          <button class="btn" type="button" data-alert="Riwayat lengkap catatan ditampilkan di bagian bawah halaman ini.">
            <i class="fa-solid fa-book-open" aria-hidden="true"></i>
            <span>Riwayat Notes</span>
          </button>
        </header>

        <section aria-labelledby="filter-kelas">
          <h2 id="filter-kelas" class="section-title">Pilih Kelas & Siswa</h2>
          <div class="grid grid-3">
            <label class="card">
              <span class="card__title"><i class="fa-solid fa-layer-group"></i> Kelas</span>
              <select class="input-inline" id="selectKelas">
                <option value="5A">5A</option>
                <option value="4B">4B</option>
                <option value="3C">3C</option>
              </select>
            </label>
            <label class="card">
              <span class="card__title"><i class="fa-solid fa-user-graduate"></i> Siswa</span>
              <select class="input-inline" id="selectSiswa">
                <option value="">-- Pilih Siswa --</option>
                <option value="andi">Andi Prakoso</option>
                <option value="bella">Bella Lestari</option>
                <option value="chandra">Chandra Wijaya</option>
                <option value="dewi">Dewi Anggraini</option>
              </select>
            </label>
            <label class="card">
              <span class="card__title"><i class="fa-solid fa-calendar"></i> Tanggal</span>
              <input class="input-inline" type="date" id="tanggalNote" required />
            </label>
          </div>
        </section>

        <section aria-labelledby="form-note">
          <h2 id="form-note" class="section-title">Buat Catatan</h2>
          <div class="card">
            <form id="notesForm" class="register-form">
              <label class="form-group">
                <span><i class="fa-solid fa-heading"></i> Judul Catatan</span>
                <input type="text" name="judul" placeholder="Contoh: Peningkatan dalam Matematika" required />
              </label>
              <label class="form-group">
                <span><i class="fa-solid fa-file-lines"></i> Isi Catatan</span>
                <textarea
                  name="isi"
                  placeholder="Tuliskan catatan tentang siswa yang akan ditampilkan kepada orang tua..."
                  rows="6"
                  required
                ></textarea>
              </label>
              <label class="form-group">
                <span><i class="fa-solid fa-tags"></i> Kategori</span>
                <select class="input-inline" name="kategori" required>
                  <option value="">-- Pilih Kategori --</option>
                  <option value="prestasi">Prestasi</option>
                  <option value="perilaku">Perilaku</option>
                  <option value="akademik">Akademik</option>
                  <option value="sosial">Sosial</option>
                  <option value="lainnya">Lainnya</option>
                </select>
              </label>
              <button class="btn" type="submit">
                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                <span>Kirim Catatan</span>
              </button>
            </form>
          </div>
        </section>

        <section aria-labelledby="notes-terbaru">
          <h2 id="notes-terbaru" class="section-title">Notes Terbaru</h2>
          <div class="grid grid-2">
            <article class="card">
              <p class="card__title">
                <i class="fa-solid fa-note-sticky"></i> Andi Prakoso - 5A
                <span class="badge" style="margin-left: 12px; background: rgba(76, 175, 80, 0.15); color: #2e7d32;">
                  Prestasi
                </span>
              </p>
              <p style="margin: 12px 0; font-weight: 600;">Peningkatan dalam Matematika</p>
              <p>Andi menunjukkan peningkatan yang signifikan dalam memahami konsep pecahan. Terus semangat!</p>
              <small style="color: rgba(0, 0, 0, 0.6);">12 Nov 2025</small>
            </article>
            <article class="card">
              <p class="card__title">
                <i class="fa-solid fa-note-sticky"></i> Bella Lestari - 5A
                <span class="badge" style="margin-left: 12px; background: rgba(33, 150, 243, 0.15); color: #1976d2;">
                  Akademik
                </span>
              </p>
              <p style="margin: 12px 0; font-weight: 600;">Partisipasi Aktif di Kelas</p>
              <p>Bella sangat aktif bertanya dan menjawab pertanyaan. Pertahankan semangat belajar!</p>
              <small style="color: rgba(0, 0, 0, 0.6);">11 Nov 2025</small>
            </article>
          </div>
        </section>
      </main>
    </div>

    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
    <script>
      // Set default date to today
      document.addEventListener('DOMContentLoaded', () => {
        const tanggalInput = document.getElementById('tanggalNote');
        if (tanggalInput) {
          const today = new Date().toISOString().split('T')[0];
          tanggalInput.value = today;
        }
      });
    </script>
  </body>
</html>

