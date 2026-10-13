<?php
/**
 * Sidebar Navigation Component
 * SDN 1 UNDUOLO - Sistem Manajemen Sekolah
 */

require_once __DIR__ . '/../config/auth.php';
requireLogin();

$currentPage = basename($_SERVER['PHP_SELF'], '.php');
$role = $_SESSION['role'] ?? '';

// Get user info
$user = getCurrentUser();
?>

<aside class="sidebar">
  <div class="sidebar__brand">
    <img src="<?php echo BASE_URL; ?>/assets/img/logo.png" alt="Logo SDN 1 UNDUOLO" width="40" height="40" />
    <span>SDN 1 UNDUOLO</span>
  </div>
  <nav class="sidebar__nav">
    <?php if ($role === 'admin'): ?>
      <a class="sidebar__link <?php echo $currentPage === 'dashboard' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/admin/dashboard.php" data-nav="admin-dashboard">
        <i class="fa-solid fa-chart-line"></i>
        <span>Dashboard</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'jadwal' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/admin/jadwal.php" data-nav="admin-jadwal">
        <i class="fa-solid fa-calendar-days"></i>
        <span>Jadwal Pelajaran</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'laporan' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/admin/laporan.php" data-nav="admin-laporan">
        <i class="fa-solid fa-file-lines"></i>
        <span>Laporan Presensi</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'data-siswa' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/admin/data-siswa.php" data-nav="admin-data-siswa">
        <i class="fa-solid fa-children"></i>
        <span>Data Siswa</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'data-guru' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/admin/data-guru.php" data-nav="admin-data-guru">
        <i class="fa-solid fa-person-chalkboard"></i>
        <span>Data Guru</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'data-nilai' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/admin/data-nilai.php" data-nav="admin-data-nilai">
        <i class="fa-solid fa-chart-column"></i>
        <span>Data Nilai</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'absensi-siswa' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/admin/absensi-siswa.php" data-nav="admin-absensi">
        <i class="fa-solid fa-clipboard-user"></i>
        <span>Absensi Siswa</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'data-user' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/admin/data-user.php" data-nav="admin-data-user">
        <i class="fa-solid fa-users-gear"></i>
        <span>Data User</span>
      </a>
    <?php elseif ($role === 'guru'): ?>
      <a class="sidebar__link <?php echo $currentPage === 'dashboard' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/guru/dashboard.php" data-nav="guru-dashboard">
        <i class="fa-solid fa-house"></i>
        <span>Dashboard</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'presensi' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/guru/presensi.php" data-nav="guru-presensi">
        <i class="fa-solid fa-clipboard-check"></i>
        <span>Presensi</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'nilai' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/guru/nilai.php" data-nav="guru-nilai">
        <i class="fa-solid fa-star"></i>
        <span>Nilai</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'notes' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/guru/notes.php" data-nav="guru-notes">
        <i class="fa-solid fa-note-sticky"></i>
        <span>Notes</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'laporan' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/guru/laporan.php" data-nav="guru-laporan">
        <i class="fa-solid fa-chart-bar"></i>
        <span>Laporan</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'penilaian-harian' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/guru/penilaian-harian.php" data-nav="guru-penilaian-harian">
        <i class="fa-solid fa-star-half-stroke"></i>
        <span>Penilaian Harian</span>
      </a>
    <?php elseif ($role === 'kepalasekolah'): ?>
      <a class="sidebar__link <?php echo $currentPage === 'dashboard' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/kepalasekolah/dashboard.php" data-nav="kepala-dashboard">
        <i class="fa-solid fa-gauge"></i>
        <span>Dashboard</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'laporan' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/kepalasekolah/laporan.php" data-nav="kepala-laporan">
        <i class="fa-solid fa-folder-open"></i>
        <span>Laporan</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'laporan-akademik' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/kepalasekolah/laporan-akademik.php" data-nav="kepala-laporan-akademik">
        <i class="fa-solid fa-graduation-cap"></i>
        <span>Laporan Akademik</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'laporan-absensi-guru' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/kepalasekolah/laporan-absensi-guru.php" data-nav="kepala-laporan-absensi-guru">
        <i class="fa-solid fa-chalkboard-user"></i>
        <span>Laporan Absensi Guru</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'laporan-absensi-siswa' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/kepalasekolah/laporan-absensi-siswa.php" data-nav="kepala-laporan-absensi-siswa">
        <i class="fa-solid fa-user-graduate"></i>
        <span>Laporan Absensi Siswa</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'laporan-absensi' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/kepalasekolah/laporan-absensi.php" data-nav="kepala-laporan-absensi">
        <i class="fa-solid fa-clipboard-check"></i>
        <span>Laporan Absensi</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'evaluasi-pembelajaran' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/kepalasekolah/evaluasi-pembelajaran.php" data-nav="kepala-evaluasi-pembelajaran">
        <i class="fa-solid fa-chart-line"></i>
        <span>Evaluasi Pembelajaran</span>
      </a>
    <?php elseif ($role === 'orangtua'): ?>
      <a class="sidebar__link <?php echo $currentPage === 'dashboard' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/orangtua/dashboard.php" data-nav="orangtua-dashboard">
        <i class="fa-solid fa-house-chimney"></i>
        <span>Dashboard</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'data-anak' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/orangtua/data-anak.php" data-nav="orangtua-data-anak">
        <i class="fa-solid fa-child"></i>
        <span>Data Anak</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'perkembangan' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/orangtua/perkembangan.php" data-nav="orangtua-perkembangan">
        <i class="fa-solid fa-chart-simple"></i>
        <span>Perkembangan Anak</span>
      </a>
      <a class="sidebar__link <?php echo $currentPage === 'notes' ? 'is-active' : ''; ?>" href="<?php echo BASE_URL; ?>/orangtua/notes.php" data-nav="orangtua-notes">
        <i class="fa-solid fa-note-sticky"></i>
        <span>Notes</span>
      </a>
    <?php endif; ?>
    
    <div style="margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
      <a class="sidebar__link" href="<?php echo BASE_URL; ?>/logout.php" style="color: #fff;">
        <i class="fa-solid fa-sign-out-alt"></i>
        <span>Logout</span>
      </a>
    </div>
  </nav>
</aside>


