<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['guru']);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Input Nilai</title>
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
  <body data-page="guru-nilai">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Input Nilai Siswa</h1>
          <button class="btn" type="button" data-alert="Nilai akan disimpan ke sistem setelah modul ini terhubung ke database. Periksa kembali sebelum submit massal.">
            <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
            <span>Simpan Nilai</span>
          </button>
        </header>

        <section aria-labelledby="nilai-table">
          <h2 id="nilai-table" class="section-title">Kelas 5A - Semester Ganjil</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Nama Siswa</th>
                  <th>Mata Pelajaran</th>
                  <th>Nilai Harian</th>
                  <th>Nilai Ulangan</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Andi Prakoso</td>
                  <td>Matematika</td>
                  <td><input class="input-inline" type="number" min="0" max="100" data-grade-input /></td>
                  <td><input class="input-inline" type="number" min="0" max="100" data-grade-input /></td>
                </tr>
                <tr>
                  <td>Bella Lestari</td>
                  <td>Matematika</td>
                  <td><input class="input-inline" type="number" min="0" max="100" data-grade-input /></td>
                  <td><input class="input-inline" type="number" min="0" max="100" data-grade-input /></td>
                </tr>
                <tr>
                  <td>Chandra Wijaya</td>
                  <td>Matematika</td>
                  <td><input class="input-inline" type="number" min="0" max="100" data-grade-input /></td>
                  <td><input class="input-inline" type="number" min="0" max="100" data-grade-input /></td>
                </tr>
                <tr>
                  <td>Dewi Anggraini</td>
                  <td>Matematika</td>
                  <td><input class="input-inline" type="number" min="0" max="100" data-grade-input /></td>
                  <td><input class="input-inline" type="number" min="0" max="100" data-grade-input /></td>
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


