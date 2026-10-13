<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['guru']);
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Penilaian Harian</title>
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
  <body data-page="guru-penilaian-harian">
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>

      <main class="layout__main">
        <header class="page-header">
          <h1>Penilaian Harian Siswa</h1>
          <button class="btn" type="button" id="savePenilaian">
            <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
            <span>Simpan Penilaian</span>
          </button>
        </header>

        <section aria-labelledby="filter-penilaian">
          <h2 id="filter-penilaian" class="section-title">Filter Penilaian</h2>
          <div class="grid grid-3">
            <label class="card">
              <span class="card__title"><i class="fa-solid fa-layer-group"></i> Kelas</span>
              <select class="input-inline" id="filterKelasPenilaian">
                <option value="5A">Kelas 5A</option>
                <option value="4B">Kelas 4B</option>
                <option value="3C">Kelas 3C</option>
              </select>
            </label>
            <label class="card">
              <span class="card__title"><i class="fa-solid fa-calendar"></i> Tanggal</span>
              <input class="input-inline" type="date" id="tanggalPenilaian" />
            </label>
            <label class="card">
              <span class="card__title"><i class="fa-solid fa-book"></i> Mata Pelajaran</span>
              <select class="input-inline" id="filterMataPelajaran">
                <option value="matematika">Matematika</option>
                <option value="ipa">IPA</option>
                <option value="bahasa">Bahasa Indonesia</option>
              </select>
            </label>
          </div>
        </section>

        <section aria-labelledby="daftar-siswa">
          <h2 id="daftar-siswa" class="section-title">Daftar Siswa - Kelas 5A</h2>
          <p style="margin-bottom: 20px; color: rgba(0, 0, 0, 0.7);">
            <i class="fa-solid fa-info-circle"></i>
            Berikan bintang 1-5 untuk setiap siswa berdasarkan performa hari ini.
          </p>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Siswa</th>
                  <th>NIS</th>
                  <th>Penilaian (Bintang)</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Andi Prakoso</td>
                  <td>192301</td>
                  <td>
                    <div class="star-rating" data-student-id="192301">
                      <input type="radio" name="rating_192301" value="5" id="star5_192301" />
                      <label for="star5_192301" class="star-label">★</label>
                      <input type="radio" name="rating_192301" value="4" id="star4_192301" />
                      <label for="star4_192301" class="star-label">★</label>
                      <input type="radio" name="rating_192301" value="3" id="star3_192301" />
                      <label for="star3_192301" class="star-label">★</label>
                      <input type="radio" name="rating_192301" value="2" id="star2_192301" />
                      <label for="star2_192301" class="star-label">★</label>
                      <input type="radio" name="rating_192301" value="1" id="star1_192301" />
                      <label for="star1_192301" class="star-label">★</label>
                    </div>
                  </td>
                  <td><span class="badge" style="background: rgba(198, 40, 40, 0.12); color: var(--accent-color);">Belum dinilai</span></td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Bella Lestari</td>
                  <td>192302</td>
                  <td>
                    <div class="star-rating" data-student-id="192302">
                      <input type="radio" name="rating_192302" value="5" id="star5_192302" />
                      <label for="star5_192302" class="star-label">★</label>
                      <input type="radio" name="rating_192302" value="4" id="star4_192302" />
                      <label for="star4_192302" class="star-label">★</label>
                      <input type="radio" name="rating_192302" value="3" id="star3_192302" />
                      <label for="star3_192302" class="star-label">★</label>
                      <input type="radio" name="rating_192302" value="2" id="star2_192302" />
                      <label for="star2_192302" class="star-label">★</label>
                      <input type="radio" name="rating_192302" value="1" id="star1_192302" />
                      <label for="star1_192302" class="star-label">★</label>
                    </div>
                  </td>
                  <td><span class="badge" style="background: rgba(198, 40, 40, 0.12); color: var(--accent-color);">Belum dinilai</span></td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Chandra Wijaya</td>
                  <td>192303</td>
                  <td>
                    <div class="star-rating" data-student-id="192303">
                      <input type="radio" name="rating_192303" value="5" id="star5_192303" />
                      <label for="star5_192303" class="star-label">★</label>
                      <input type="radio" name="rating_192303" value="4" id="star4_192303" />
                      <label for="star4_192303" class="star-label">★</label>
                      <input type="radio" name="rating_192303" value="3" id="star3_192303" />
                      <label for="star3_192303" class="star-label">★</label>
                      <input type="radio" name="rating_192303" value="2" id="star2_192303" />
                      <label for="star2_192303" class="star-label">★</label>
                      <input type="radio" name="rating_192303" value="1" id="star1_192303" />
                      <label for="star1_192303" class="star-label">★</label>
                    </div>
                  </td>
                  <td><span class="badge" style="background: rgba(198, 40, 40, 0.12); color: var(--accent-color);">Belum dinilai</span></td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>Dewi Anggraini</td>
                  <td>192304</td>
                  <td>
                    <div class="star-rating" data-student-id="192304">
                      <input type="radio" name="rating_192304" value="5" id="star5_192304" />
                      <label for="star5_192304" class="star-label">★</label>
                      <input type="radio" name="rating_192304" value="4" id="star4_192304" />
                      <label for="star4_192304" class="star-label">★</label>
                      <input type="radio" name="rating_192304" value="3" id="star3_192304" />
                      <label for="star3_192304" class="star-label">★</label>
                      <input type="radio" name="rating_192304" value="2" id="star2_192304" />
                      <label for="star2_192304" class="star-label">★</label>
                      <input type="radio" name="rating_192304" value="1" id="star1_192304" />
                      <label for="star1_192304" class="star-label">★</label>
                    </div>
                  </td>
                  <td><span class="badge" style="background: rgba(76, 175, 80, 0.15); color: #2e7d32;">Sudah dinilai (4★)</span></td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>Eko Pratama</td>
                  <td>192305</td>
                  <td>
                    <div class="star-rating" data-student-id="192305">
                      <input type="radio" name="rating_192305" value="5" id="star5_192305" />
                      <label for="star5_192305" class="star-label">★</label>
                      <input type="radio" name="rating_192305" value="4" id="star4_192305" />
                      <label for="star4_192305" class="star-label">★</label>
                      <input type="radio" name="rating_192305" value="3" id="star3_192305" />
                      <label for="star3_192305" class="star-label">★</label>
                      <input type="radio" name="rating_192305" value="2" id="star2_192305" />
                      <label for="star2_192305" class="star-label">★</label>
                      <input type="radio" name="rating_192305" value="1" id="star1_192305" />
                      <label for="star1_192305" class="star-label">★</label>
                    </div>
                  </td>
                  <td><span class="badge" style="background: rgba(198, 40, 40, 0.12); color: var(--accent-color);">Belum dinilai</span></td>
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

