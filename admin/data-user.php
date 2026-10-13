<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['admin']);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Data User</title>
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
  <body data-page="admin-data-user">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Manajemen Pengguna</h1>
          <button class="btn" type="button" data-alert="Penambahan akun pengguna baru dapat dilakukan melalui modul admin yang terhubung ke tabel users.">
            <i class="fa-solid fa-user-gear" aria-hidden="true"></i>
            <span>Tambah User</span>
          </button>
        </header>

        <section aria-labelledby="ringkasan-user">
          <h2 id="ringkasan-user" class="section-title">Ringkasan Hak Akses</h2>
          <div class="grid grid-3">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-shield"></i> Administrator</p>
              <p class="card__value">4</p>
              <small>Mengelola seluruh modul sistem.</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-chalkboard-teacher"></i> Guru</p>
              <p class="card__value">35</p>
              <small>Akses penilaian dan presensi kelas masing-masing.</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-people-roof"></i> Orang Tua</p>
              <p class="card__value">380</p>
              <small>Mengamati perkembangan dan presensi anak.</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="tabel-user">
          <h2 id="tabel-user" class="section-title">Daftar Pengguna Aktif</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Peran</th>
                  <th>Status</th>
                  <th>Terakhir Login</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Admin Sekolah</td>
                  <td>admin@sdn1unduolo.sch.id</td>
                  <td><span class="badge status--hadir">Administrator</span></td>
                  <td><span class="badge status--hadir">Aktif</span></td>
                  <td>13 Nov 2025 08:45</td>
                  <td><button class="btn" type="button" data-alert="Reset password dikirim (simulasi).">Reset</button></td>
                </tr>
                <tr>
                  <td>Ibu Ratna Sari</td>
                  <td>ratna@sdn1unduolo.sch.id</td>
                  <td><span class="badge status--hadir">Guru</span></td>
                  <td><span class="badge status--hadir">Aktif</span></td>
                  <td>12 Nov 2025 15:10</td>
                  <td><button class="btn" type="button" data-alert="Hak akses diperbarui (simulasi).">Kelola</button></td>
                </tr>
                <tr>
                  <td>Bapak Pratama</td>
                  <td>pratama@sdn1unduolo.sch.id</td>
                  <td><span class="badge status--izin">Orang Tua</span></td>
                  <td><span class="badge status--hadir">Aktif</span></td>
                  <td>11 Nov 2025 21:04</td>
                  <td><button class="btn" type="button" data-alert="Akun dinonaktifkan (simulasi).">Nonaktifkan</button></td>
                </tr>
                <tr>
                  <td>Monitoring Dinas</td>
                  <td>dinas@sdn1unduolo.sch.id</td>
                  <td><span class="badge status--alpha">Pengawas</span></td>
                  <td><span class="badge status--hadir">Aktif</span></td>
                  <td>09 Nov 2025 10:18</td>
                  <td><button class="btn" type="button" data-alert="Link audit dikirim (simulasi).">Kirim Link</button></td>
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

