<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['guru']);

require_once __DIR__ . '/../config/database.php';

// Get guru data
$guruId = $_SESSION['related_id'] ?? null;
if (!$guruId) {
    header('Location: ' . BASE_URL . '/login.php');
    exit;
}

// Get kelas that this teacher teaches
$guru = fetchOne("SELECT * FROM guru WHERE id = $guruId");
$kelasId = $_GET['kelas_id'] ?? null;

// Get classes for this teacher
$kelasList = fetchAll("SELECT DISTINCT k.* FROM jadwal j 
                       INNER JOIN kelas k ON j.kelas_id = k.id 
                       WHERE j.guru_id = $guruId 
                       ORDER BY k.tingkat, k.nama_kelas");

// Get students for selected class
$siswaList = [];
if ($kelasId) {
    $kelasId = escape($kelasId);
    $siswaList = fetchAll("SELECT * FROM siswa WHERE kelas_id = $kelasId AND status = 'aktif' ORDER BY nama_lengkap");
}

// Handle save presensi
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_presensi'])) {
    $tanggal = date('Y-m-d');
    $presensiData = $_POST['presensi'] ?? [];
    $guruId = escape($guruId);
    $tanggalEscaped = escape($tanggal);
    
    $saved = 0;
    foreach ($presensiData as $siswaId => $status) {
        $siswaId = escape($siswaId);
        $status = escape($status);
        $keterangan = escape($_POST['keterangan'][$siswaId] ?? '');
        $jamMasuk = $status === 'hadir' ? date('H:i:s') : null;
        
        // Delete existing presensi for today
        query("DELETE FROM absensi_siswa WHERE siswa_id = $siswaId AND tanggal = '$tanggalEscaped'");
        
        // Insert new presensi
        $sql = "INSERT INTO absensi_siswa (siswa_id, tanggal, status, jam_masuk, keterangan, guru_id) 
                VALUES ($siswaId, '$tanggalEscaped', '$status', " . 
                ($jamMasuk ? "'$jamMasuk'" : 'NULL') . ", '$keterangan', $guruId)";
        
        if (query($sql)) {
            $saved++;
        }
    }
    
    if ($saved > 0) {
        $message = "Presensi $saved siswa berhasil disimpan!";
        $messageType = 'success';
    }
}

// Get today's presensi for display
$today = date('Y-m-d');
$todayPresensi = [];
if ($kelasId) {
    $kelasIdEscaped = escape($kelasId);
    $presensiRows = fetchAll("SELECT * FROM absensi_siswa WHERE tanggal = '$today' AND siswa_id IN 
                              (SELECT id FROM siswa WHERE kelas_id = $kelasIdEscaped)");
    foreach ($presensiRows as $p) {
        $todayPresensi[$p['siswa_id']] = $p;
    }
}

// Get class name
$kelasNama = '';
if ($kelasId) {
    $kelas = fetchOne("SELECT * FROM kelas WHERE id = " . escape($kelasId));
    $kelasNama = $kelas['nama_kelas'] ?? '';
}
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Presensi Guru</title>
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
    <style>
      .message {
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
      }
      .message.success {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
      }
    </style>
  </head>
  <body data-page="guru-presensi">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Presensi <?php echo $kelasNama ? "Kelas $kelasNama" : 'Siswa'; ?></h1>
          <form method="GET" action="" style="display: inline-block;">
            <select name="kelas_id" onchange="this.form.submit()" style="padding: 8px; border-radius: 4px;">
              <option value="">-- Pilih Kelas --</option>
              <?php foreach ($kelasList as $kelas): ?>
                <option value="<?php echo $kelas['id']; ?>" <?php echo $kelasId == $kelas['id'] ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($kelas['nama_kelas']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </form>
        </header>

        <?php if ($message): ?>
          <div class="message <?php echo $messageType; ?>">
            <i class="fa-solid fa-check-circle"></i> <?php echo htmlspecialchars($message); ?>
          </div>
        <?php endif; ?>

        <?php if (!$kelasId): ?>
          <div class="card" style="text-align: center; padding: 40px;">
            <p><i class="fa-solid fa-info-circle"></i> Silakan pilih kelas terlebih dahulu</p>
          </div>
        <?php elseif (empty($siswaList)): ?>
          <div class="card" style="text-align: center; padding: 40px;">
            <p><i class="fa-solid fa-info-circle"></i> Tidak ada siswa di kelas ini</p>
          </div>
        <?php else: ?>
          <section aria-labelledby="detail-kelas">
            <h2 id="detail-kelas" class="section-title">Daftar Siswa - Tanggal: <?php echo date('d/m/Y'); ?></h2>
            <form method="POST" action="">
              <div class="table-wrapper">
                <table>
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>NIS</th>
                      <th>Hadir</th>
                      <th>Izin</th>
                      <th>Sakit</th>
                      <th>Alpa</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($siswaList as $siswa): 
                      $currentPresensi = $todayPresensi[$siswa['id']] ?? null;
                      $currentStatus = $currentPresensi['status'] ?? 'hadir';
                    ?>
                      <tr>
                        <td><?php echo htmlspecialchars($siswa['nama_lengkap']); ?></td>
                        <td><?php echo htmlspecialchars($siswa['nis']); ?></td>
                        <td>
                          <input type="radio" name="presensi[<?php echo $siswa['id']; ?>]" value="hadir" 
                                 id="presensi_<?php echo $siswa['id']; ?>_hadir" 
                                 class="presensi-radio" <?php echo $currentStatus === 'hadir' ? 'checked' : ''; ?> />
                          <label for="presensi_<?php echo $siswa['id']; ?>_hadir"></label>
                        </td>
                        <td>
                          <input type="radio" name="presensi[<?php echo $siswa['id']; ?>]" value="izin" 
                                 id="presensi_<?php echo $siswa['id']; ?>_izin" 
                                 class="presensi-radio" <?php echo $currentStatus === 'izin' ? 'checked' : ''; ?> />
                          <label for="presensi_<?php echo $siswa['id']; ?>_izin"></label>
                        </td>
                        <td>
                          <input type="radio" name="presensi[<?php echo $siswa['id']; ?>]" value="sakit" 
                                 id="presensi_<?php echo $siswa['id']; ?>_sakit" 
                                 class="presensi-radio" <?php echo $currentStatus === 'sakit' ? 'checked' : ''; ?> />
                          <label for="presensi_<?php echo $siswa['id']; ?>_sakit"></label>
                        </td>
                        <td>
                          <input type="radio" name="presensi[<?php echo $siswa['id']; ?>]" value="alpa" 
                                 id="presensi_<?php echo $siswa['id']; ?>_alpa" 
                                 class="presensi-radio" <?php echo $currentStatus === 'alpa' ? 'checked' : ''; ?> />
                          <label for="presensi_<?php echo $siswa['id']; ?>_alpa"></label>
                        </td>
                        <td>
                          <input type="text" name="keterangan[<?php echo $siswa['id']; ?>]" 
                                 placeholder="Keterangan (opsional)" 
                                 value="<?php echo htmlspecialchars($currentPresensi['keterangan'] ?? ''); ?>" 
                                 style="width: 200px; padding: 6px;" />
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <div style="margin-top: 24px;">
                <button class="btn" type="submit" name="save_presensi">
                  <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                  <span>Simpan Presensi</span>
                </button>
              </div>
            </form>
          </section>
        <?php endif; ?>
      </main>
    </div>

    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
  </body>
</html>
