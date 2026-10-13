<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Presensi Digital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="assets/css/style.css" />
  </head>
  <body data-page="presensi">
    <main class="attendance-layout">
      <section class="attendance-wrapper">

        <div class="attendance-panel">
          <div class="attendance-camera card" data-action="scan-box">
            <i class="fa-solid fa-camera-rotate fa-3x" aria-hidden="true"></i>
            <p>Area Kamera Pendeteksi QR/Barcode</p>
            <small>Ketuk untuk simulasi hasil scan</small>
          </div>

          <div class="attendance-manual card">
            <p class="card__title">
              <i class="fa-solid fa-keyboard"></i> Input Manual
            </p>
            <p class="attendance-manual__desc">Gunakan jika barcode tidak terbaca.</p>
            <label class="attendance-manual__label" for="manualCode">Kode Presensi</label>
            <input
              id="manualCode"
              class="input-inline"
              type="text"
              placeholder="Contoh: SDN1-UNDUOLO-2025"
              aria-label="Kode presensi manual"
            />
            <button class="btn" type="button" data-alert="Kode presensi manual berhasil dikirim (simulasi).">
    
              <span>Aben</span>
            </button>
          </div>
        </div>
      </section>
    </main>

    <script src="assets/js/script.js"></script>
  </body>
</html>

