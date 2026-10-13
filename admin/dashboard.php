<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['admin']);

require_once __DIR__ . '/../config/database.php';

// Get statistics
$totalSiswa = fetchOne("SELECT COUNT(*) as total FROM siswa WHERE status = 'aktif'")['total'] ?? 0;
$totalGuru = fetchOne("SELECT COUNT(*) as total FROM guru WHERE status = 'aktif'")['total'] ?? 0;

// Calculate average attendance for last 4 weeks
$lastMonth = date('Y-m-d', strtotime('-30 days'));
$totalDays = fetchOne("SELECT COUNT(DISTINCT tanggal) as total FROM absensi_siswa WHERE tanggal >= '$lastMonth'")['total'] ?? 1;
$hadirCount = fetchOne("SELECT COUNT(*) as total FROM absensi_siswa WHERE status = 'hadir' AND tanggal >= '$lastMonth'")['total'] ?? 0;
$totalAbsensi = fetchOne("SELECT COUNT(*) as total FROM absensi_siswa WHERE tanggal >= '$lastMonth'")['total'] ?? 1;
$avgAttendance = $totalAbsensi > 0 ? round(($hadirCount / $totalAbsensi) * 100) : 0;

// Active parents (logged in last 30 days)
$last30Days = date('Y-m-d H:i:s', strtotime('-30 days'));
$activeParents = fetchOne("SELECT COUNT(DISTINCT u.id) as total FROM users u 
                           INNER JOIN orangtua o ON u.id = o.user_id 
                           WHERE u.role = 'orangtua' AND u.last_login >= '$last30Days'")['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Admin Dashboard</title>
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
  <body data-page="admin-dashboard">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <!-- Main Dashboard Content -->
      <main class="layout__main">
        <header class="page-header">
          <h1>Dashboard Admin - <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?></h1>
          <button class="btn" type="button" data-alert="Ringkasan dashboard dapat dicetak dengan Ctrl+P atau diekspor setelah fitur laporan diaktifkan.">
            <i class="fa-solid fa-download" aria-hidden="true"></i>
            <span>Unduh Ringkasan</span>
          </button>
        </header>

        <section aria-labelledby="admin-stats">
          <h2 id="admin-stats" class="section-title">Statistik Sekolah</h2>
          <div class="stats-grid">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-graduate"></i> Jumlah Siswa</p>
              <p class="card__value"><?php echo number_format($totalSiswa); ?></p>
              <small>Terdaftar pada tahun ajaran 2024/2025</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-person-chalkboard"></i> Jumlah Guru</p>
              <p class="card__value"><?php echo number_format($totalGuru); ?></p>
              <small>Termasuk guru honorer dan wali kelas</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-check-circle"></i> Kehadiran Rata-rata</p>
              <p class="card__value"><?php echo $avgAttendance; ?>%</p>
              <small>Akumulasi 4 minggu terakhir</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-people-group"></i> Orang Tua Aktif</p>
              <p class="card__value"><?php echo number_format($activeParents); ?></p>
              <small>Telah login dalam 30 hari terakhir</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="admin-reminders">
          <h2 id="admin-reminders" class="section-title">Agenda Penting Minggu Ini</h2>
          <div class="grid grid-2">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-bullhorn"></i> Sosialisasi Kurikulum</p>
              <p>Koordinasikan materi kurikulum merdeka dengan wali kelas dan kepala sekolah.</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-laptop-file"></i> Audit Presensi</p>
              <p>Verifikasi data kehadiran pekan lalu sebelum dikirim ke dinas pendidikan.</p>
            </article>
          </div>
        </section>
      </main>
    </div>

    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
  </body>
</html>
