<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['orangtua']);

require_once __DIR__ . '/../config/database.php';

// Get parent's students
$orangtuaId = $_SESSION['related_id'] ?? null;
if (!$orangtuaId) {
    header('Location: ' . BASE_URL . '/login.php');
    exit;
}

// Get parent's children
$siswaList = fetchAll("SELECT s.*, k.nama_kelas 
                       FROM siswa s
                       LEFT JOIN kelas k ON s.kelas_id = k.id
                       WHERE s.orangtua_id = $orangtuaId AND s.status = 'aktif'");

// If no children, show message
$siswa = !empty($siswaList) ? $siswaList[0] : null;
$siswaId = $siswa['id'] ?? null;

// Calculate monthly attendance
$monthStart = date('Y-m-01');
$monthEnd = date('Y-m-t');
$hadirCount = 0;
$totalDays = 0;
$lastWeekPresensi = [];

if ($siswaId) {
    $hadirCount = fetchOne("SELECT COUNT(*) as total FROM absensi_siswa 
                            WHERE siswa_id = $siswaId AND status = 'hadir' 
                            AND tanggal >= '$monthStart' AND tanggal <= '$monthEnd'")['total'] ?? 0;
    
    $totalDays = fetchOne("SELECT COUNT(DISTINCT tanggal) as total FROM absensi_siswa 
                           WHERE tanggal >= '$monthStart' AND tanggal <= '$monthEnd'")['total'] ?? 1;
    
    $avgAttendance = $totalDays > 0 ? round(($hadirCount / $totalDays) * 100) : 0;
    
    // Get last week presensi
    $weekStart = date('Y-m-d', strtotime('-7 days'));
    $lastWeekPresensi = fetchAll("SELECT * FROM absensi_siswa 
                                   WHERE siswa_id = $siswaId AND tanggal >= '$weekStart'
                                   ORDER BY tanggal DESC LIMIT 7");
    
    // Get average grade
    $avgGrade = fetchOne("SELECT AVG(nilai_rata) as avg FROM nilai 
                          WHERE siswa_id = $siswaId AND tahun_ajaran = '2024/2025'")['avg'] ?? 0;
    $avgGrade = round($avgGrade, 0);
}
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Dashboard Orang Tua</title>
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
  <body data-page="orangtua-dashboard">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Halo, <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?></h1>
          <a class="btn" href="<?php echo BASE_URL; ?>/orangtua/notes.php">
            <i class="fa-solid fa-envelope-open-text" aria-hidden="true"></i>
            <span>Pesan Guru</span>
          </a>
        </header>

        <?php if (!$siswa): ?>
          <div class="card" style="text-align: center; padding: 40px;">
            <p><i class="fa-solid fa-info-circle"></i> Belum ada data anak terdaftar. Silakan hubungi admin sekolah.</p>
          </div>
        <?php else: ?>
          <section aria-labelledby="ringkasan-anak">
            <h2 id="ringkasan-anak" class="section-title">Ringkasan Anak Anda - <?php echo htmlspecialchars($siswa['nama_lengkap']); ?></h2>
            <div class="grid grid-3">
              <article class="card">
                <p class="card__title"><i class="fa-solid fa-calendar-check"></i> Kehadiran Bulan Ini</p>
                <p class="card__value"><?php echo $avgAttendance; ?>%</p>
                <small><?php echo $hadirCount; ?> dari <?php echo $totalDays; ?> hari hadir</small>
              </article>
              <article class="card">
                <p class="card__title"><i class="fa-solid fa-award"></i> Rata-rata Nilai</p>
                <p class="card__value"><?php echo $avgGrade > 0 ? $avgGrade : '-'; ?></p>
                <small><?php echo $avgGrade > 0 ? 'Tahun ajaran 2024/2025' : 'Belum ada nilai'; ?></small>
              </article>
              <article class="card">
                <p class="card__title"><i class="fa-solid fa-school"></i> Kelas</p>
                <p class="card__value"><?php echo htmlspecialchars($siswa['nama_kelas'] ?? '-'); ?></p>
                <small><?php echo htmlspecialchars($siswa['nama_kelas'] ?? ''); ?></small>
              </article>
            </div>
          </section>

          <section aria-labelledby="riwayat-presensi">
            <h2 id="riwayat-presensi" class="section-title">Riwayat Presensi Minggu Ini</h2>
            <div class="table-wrapper">
              <table>
                <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (empty($lastWeekPresensi)): ?>
                    <tr>
                      <td colspan="3" style="text-align: center; padding: 20px;">
                        <i class="fa-solid fa-info-circle"></i> Belum ada data presensi
                      </td>
                    </tr>
                  <?php else: ?>
                    <?php foreach ($lastWeekPresensi as $presensi): ?>
                      <tr>
                        <td><?php echo date('d M Y', strtotime($presensi['tanggal'])); ?></td>
                        <td>
                          <span class="badge status--<?php 
                            echo $presensi['status'] === 'hadir' ? 'hadir' : 
                                 ($presensi['status'] === 'izin' ? 'izin' : 'alpha'); 
                          ?>">
                            <?php echo ucfirst($presensi['status']); ?>
                          </span>
                        </td>
                        <td><?php echo htmlspecialchars($presensi['keterangan'] ?: '-'); ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </section>
        <?php endif; ?>
      </main>
    </div>

    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
  </body>
</html>
