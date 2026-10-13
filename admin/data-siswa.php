<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['admin']);

require_once __DIR__ . '/../config/database.php';

// Handle filters
$filterKelas = $_GET['kelas'] ?? 'all';
$filterJenisKelamin = $_GET['jenis_kelamin'] ?? 'all';
$filterStatus = $_GET['status'] ?? 'aktif';

// Build query
$where = [];
if ($filterKelas !== 'all') {
    $kelasId = escape($filterKelas);
    $where[] = "s.kelas_id = '$kelasId'";
}
if ($filterJenisKelamin !== 'all') {
    $jk = escape($filterJenisKelamin);
    $where[] = "s.jenis_kelamin = '$jk'";
}
$status = escape($filterStatus);
$where[] = "s.status = '$status'";

$whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

// Get students
$sql = "SELECT s.*, k.nama_kelas, o.nama as nama_orangtua, o.nomor_hp 
        FROM siswa s
        LEFT JOIN kelas k ON s.kelas_id = k.id
        LEFT JOIN orangtua o ON s.orangtua_id = o.id
        $whereClause
        ORDER BY k.nama_kelas, s.nama_lengkap";
$siswaList = fetchAll($sql);

// Get classes for filter
$kelasList = fetchAll("SELECT * FROM kelas ORDER BY tingkat, nama_kelas");
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Data Siswa</title>
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
  <body data-page="admin-data-siswa">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Data Siswa</h1>
          <button class="btn" type="button" data-alert="Form tambah siswa baru dapat dihubungkan ke database; hubungi pengembang untuk modul CRUD lengkap.">
            <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
            <span>Tambah Siswa</span>
          </button>
        </header>

        <section aria-labelledby="filter-siswa">
          <h2 id="filter-siswa" class="section-title">Filter Data</h2>
          <form method="GET" action="" class="grid grid-3">
            <label class="card">
              <span class="card__title"><i class="fa-solid fa-layer-group"></i> Kelas</span>
              <select class="input-inline" name="kelas" onchange="this.form.submit()">
                <option value="all">Semua Kelas</option>
                <?php foreach ($kelasList as $kelas): ?>
                  <option value="<?php echo $kelas['id']; ?>" <?php echo $filterKelas == $kelas['id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($kelas['nama_kelas']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </label>
            <label class="card">
              <span class="card__title"><i class="fa-solid fa-venus-mars"></i> Jenis Kelamin</span>
              <select class="input-inline" name="jenis_kelamin" onchange="this.form.submit()">
                <option value="all">Semua</option>
                <option value="Laki-laki" <?php echo $filterJenisKelamin === 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                <option value="Perempuan" <?php echo $filterJenisKelamin === 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
              </select>
            </label>
            <label class="card">
              <span class="card__title"><i class="fa-solid fa-bolt"></i> Status</span>
              <select class="input-inline" name="status" onchange="this.form.submit()">
                <option value="aktif" <?php echo $filterStatus === 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                <option value="lulus" <?php echo $filterStatus === 'lulus' ? 'selected' : ''; ?>>Lulus</option>
                <option value="pindah" <?php echo $filterStatus === 'pindah' ? 'selected' : ''; ?>>Pindah</option>
                <option value="cuti" <?php echo $filterStatus === 'cuti' ? 'selected' : ''; ?>>Cuti</option>
              </select>
            </label>
          </form>
        </section>

        <section aria-labelledby="tabel-siswa">
          <h2 id="tabel-siswa" class="section-title">Daftar Siswa Terdaftar (<?php echo count($siswaList); ?>)</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>NIS</th>
                  <th>Nama Lengkap</th>
                  <th>Kelas</th>
                  <th>Jenis Kelamin</th>
                  <th>Kontak Orang Tua</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($siswaList)): ?>
                  <tr>
                    <td colspan="6" style="text-align: center; padding: 40px;">
                      <i class="fa-solid fa-info-circle"></i> Tidak ada data siswa
                    </td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($siswaList as $siswa): ?>
                    <tr>
                      <td><?php echo htmlspecialchars($siswa['nis']); ?></td>
                      <td><?php echo htmlspecialchars($siswa['nama_lengkap']); ?></td>
                      <td><?php echo htmlspecialchars($siswa['nama_kelas'] ?? '-'); ?></td>
                      <td><?php echo htmlspecialchars($siswa['jenis_kelamin']); ?></td>
                      <td><?php echo htmlspecialchars($siswa['nomor_hp'] ?? '-'); ?></td>
                      <td>
                        <span class="badge status--<?php 
                          echo $siswa['status'] === 'aktif' ? 'hadir' : 
                               ($siswa['status'] === 'lulus' ? 'hadir' : 'izin'); 
                        ?>">
                          <?php echo ucfirst($siswa['status']); ?>
                        </span>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </section>
      </main>
    </div>

    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
  </body>
</html>
