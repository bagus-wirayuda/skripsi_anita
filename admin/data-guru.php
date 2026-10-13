<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['admin']);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Data Guru</title>
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
  <body data-page="admin-data-guru">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Data Guru</h1>
          <button class="btn" type="button" data-alert="Form tambah guru baru dapat diintegrasikan dengan tabel guru di database.">
            <i class="fa-solid fa-user-tie" aria-hidden="true"></i>
            <span>Tambah Guru</span>
          </button>
        </header>

        <section aria-labelledby="summary-guru">
          <h2 id="summary-guru" class="section-title">Ringkasan</h2>
          <div class="grid grid-3">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-users"></i> Total Guru</p>
              <p class="card__value">35</p>
              <small>Termasuk 5 guru honorer aktif.</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-book-open"></i> Mapel Tercover</p>
              <p class="card__value">12</p>
              <small>Jumlah mata pelajaran yang sudah memiliki pengajar.</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-users-line"></i> Kelas Binaan</p>
              <p class="card__value">24</p>
              <small>Gabungan kelas yang dibimbing guru.</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="tabel-guru">
          <h2 id="tabel-guru" class="section-title">Daftar Guru</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>NIP</th>
                  <th>Nama</th>
                  <th>Mata Pelajaran</th>
                  <th>Kelas Binaan</th>
                  <th>Email</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>19790102</td>
                  <td>Ibu Ratna Sari</td>
                  <td>Matematika</td>
                  <td>5A, 5B</td>
                  <td>ratna@sdn1unduolo.sch.id</td>
                  <td><span class="badge status--hadir">Aktif</span></td>
                </tr>
                <tr>
                  <td>19820314</td>
                  <td>Bapak Dimas Wijaya</td>
                  <td>Bahasa Indonesia</td>
                  <td>5A, 6A</td>
                  <td>dimas@sdn1unduolo.sch.id</td>
                  <td><span class="badge status--hadir">Aktif</span></td>
                </tr>
                <tr>
                  <td>19901230</td>
                  <td>Ibu Sari Lestari</td>
                  <td>IPA</td>
                  <td>4B</td>
                  <td>sari@sdn1unduolo.sch.id</td>
                  <td><span class="badge status--izin">Cuti</span></td>
                </tr>
                <tr>
                  <td>19870607</td>
                  <td>Bapak Yoga Prabowo</td>
                  <td>IPS</td>
                  <td>6C</td>
                  <td>yoga@sdn1unduolo.sch.id</td>
                  <td><span class="badge status--hadir">Aktif</span></td>
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

