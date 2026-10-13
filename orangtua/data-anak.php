<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['orangtua']);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Data Anak</title>
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
  <body data-page="orangtua-data-anak">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Data Anak - Salsabila Pratama</h1>
          <button class="btn" type="button" data-print>
            <i class="fa-solid fa-print" aria-hidden="true"></i>
            <span>Cetak Data</span>
          </button>
        </header>

        <section aria-labelledby="info-umum">
          <h2 id="info-umum" class="section-title">Informasi Umum</h2>
          <div class="grid grid-2">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-graduate"></i> Identitas Siswa</p>
              <dl style="margin: 16px 0; display: grid; gap: 12px;">
                <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                  <dt style="font-weight: 600; color: var(--accent-color);">Nama Lengkap</dt>
                  <dd>Salsabila Pratama</dd>
                </div>
                <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                  <dt style="font-weight: 600; color: var(--accent-color);">NIS</dt>
                  <dd>192301</dd>
                </div>
                <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                  <dt style="font-weight: 600; color: var(--accent-color);">NISN</dt>
                  <dd>0012345678</dd>
                </div>
                <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                  <dt style="font-weight: 600; color: var(--accent-color);">Kelas</dt>
                  <dd>5A</dd>
                </div>
                <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                  <dt style="font-weight: 600; color: var(--accent-color);">Tahun Ajaran</dt>
                  <dd>2024/2025</dd>
                </div>
                <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                  <dt style="font-weight: 600; color: var(--accent-color);">Tanggal Lahir</dt>
                  <dd>15 Maret 2015</dd>
                </div>
                <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                  <dt style="font-weight: 600; color: var(--accent-color);">Tempat Lahir</dt>
                  <dd>Jakarta</dd>
                </div>
              </dl>
            </article>

            <article class="card">
              <p class="card__title"><i class="fa-solid fa-users"></i> Informasi Orang Tua</p>
              <dl style="margin: 16px 0; display: grid; gap: 12px;">
                <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                  <dt style="font-weight: 600; color: var(--accent-color);">Nama Ayah</dt>
                  <dd>Bapak Andi Pratama</dd>
                </div>
                <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                  <dt style="font-weight: 600; color: var(--accent-color);">Nama Ibu</dt>
                  <dd>Ibu Siti Pratama</dd>
                </div>
                <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                  <dt style="font-weight: 600; color: var(--accent-color);">No. HP Ayah</dt>
                  <dd>0812-3456-7890</dd>
                </div>
                <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                  <dt style="font-weight: 600; color: var(--accent-color);">No. HP Ibu</dt>
                  <dd>0813-4567-8901</dd>
                </div>
                <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                  <dt style="font-weight: 600; color: var(--accent-color);">Alamat</dt>
                  <dd>Jl. Merdeka No. 123, Jakarta Selatan</dd>
                </div>
              </dl>
            </article>
          </div>
        </section>

        <section aria-labelledby="akademik-info">
          <h2 id="akademik-info" class="section-title">Informasi Akademik</h2>
          <div class="grid grid-3">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-person-chalkboard"></i> Wali Kelas</p>
              <p class="card__value" style="font-size: 1.2rem;">Ibu Ratna</p>
              <small>Guru Matematika & Wali Kelas 5A</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-calendar-alt"></i> Tahun Masuk</p>
              <p class="card__value" style="font-size: 1.2rem;">2020</p>
              <small>Masuk pada tahun ajaran 2020/2021</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-trophy"></i> Rata-rata Nilai</p>
              <p class="card__value" style="font-size: 1.2rem;">88</p>
              <small>Semester Ganjil 2024/2025</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="jadwal-kelas">
          <h2 id="jadwal-kelas" class="section-title">Jadwal Pelajaran</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Hari</th>
                  <th>Jam</th>
                  <th>Mata Pelajaran</th>
                  <th>Guru</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Senin</td>
                  <td>07:30 - 09:00</td>
                  <td>Matematika</td>
                  <td>Ibu Ratna</td>
                </tr>
                <tr>
                  <td>Senin</td>
                  <td>09:30 - 11:00</td>
                  <td>Bahasa Indonesia</td>
                  <td>Ibu Sari</td>
                </tr>
                <tr>
                  <td>Selasa</td>
                  <td>07:30 - 09:00</td>
                  <td>IPA</td>
                  <td>Ibu Sari</td>
                </tr>
                <tr>
                  <td>Selasa</td>
                  <td>09:30 - 11:00</td>
                  <td>IPS</td>
                  <td>Ibu Ratna</td>
                </tr>
                <tr>
                  <td>Rabu</td>
                  <td>07:30 - 09:00</td>
                  <td>Bahasa Inggris</td>
                  <td>Ibu Sari</td>
                </tr>
                <tr>
                  <td>Kamis</td>
                  <td>07:30 - 09:00</td>
                  <td>Seni Budaya</td>
                  <td>Ibu Ratna</td>
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

