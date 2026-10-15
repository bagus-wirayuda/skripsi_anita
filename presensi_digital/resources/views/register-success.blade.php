<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Registrasi Berhasil</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
  </head>
  <body data-page="register-success">
    <main class="register-success">
      <article class="register-success__card card">
        <div class="register-success__icon">
          <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
        </div>
        <h1>Pendaftaran Berhasil Dikirim</h1>
        <p>
          Terima kasih telah mendaftarkan calon siswa SDN 1 UNDUOLO. Silakan download formulir pendaftaran 
          yang telah diisi dan bawa dokumen pendukung di bawah ini ke sekolah untuk proses verifikasi. 
          Admin akan membuatkan akun orang tua setelah berkas diterima.
        </p>

        @if(session('success'))
          <div class="alert alert-success" style="background: #efe; border: 1px solid #cfc; padding: 12px; border-radius: 8px; margin: 20px 0; color: #3c3;">
            {{ session('success') }}
          </div>
        @endif

        <section style="margin: 24px 0;">
          <h2 style="font-size: 1.2rem; margin-bottom: 16px; color: #333;">Daftar Berkas Pendukung</h2>
          <ul class="register-success__list" style="list-style: none; padding: 0; margin: 0;">
            <li style="padding: 8px 0; border-bottom: 1px solid #eee;">
              <i class="fa-solid fa-check-circle" style="color: #4caf50; margin-right: 8px;"></i>
              Fotokopi Akta Kelahiran calon siswa
            </li>
            <li style="padding: 8px 0; border-bottom: 1px solid #eee;">
              <i class="fa-solid fa-check-circle" style="color: #4caf50; margin-right: 8px;"></i>
              Fotokopi Kartu Keluarga terbaru
            </li>
            <li style="padding: 8px 0; border-bottom: 1px solid #eee;">
              <i class="fa-solid fa-check-circle" style="color: #4caf50; margin-right: 8px;"></i>
              Fotokopi KTP orang tua / wali
            </li>
            <li style="padding: 8px 0; border-bottom: 1px solid #eee;">
              <i class="fa-solid fa-check-circle" style="color: #4caf50; margin-right: 8px;"></i>
              Pas foto calon siswa ukuran 3x4 (2 lembar)
            </li>
            <li style="padding: 8px 0;">
              <i class="fa-solid fa-check-circle" style="color: #4caf50; margin-right: 8px;"></i>
              Formulir kesehatan dari puskesmas (jika ada)
            </li>
          </ul>
        </section>

        <div class="register-success__actions" style="display: flex; gap: 12px; margin: 24px 0;">
          @if($ortuRegister)
          <a class="btn" href="{{ route('register.download-formulir') }}" target="_blank" style="flex: 1;">
            <i class="fa-solid fa-download"></i>
            <span>Download Formulir Pendaftaran</span>
          </a>
          @endif
          <a class="btn btn--ghost" href="{{ route('index') }}" style="flex: 1;">
            <i class="fa-solid fa-house"></i>
            <span>Kembali ke Beranda</span>
          </a>
        </div>

        <div style="background: rgba(33, 150, 243, 0.08); border-left: 4px solid #2196f3; padding: 16px; border-radius: 8px; margin-top: 24px;">
          <p style="margin: 0; display: flex; align-items: center; gap: 8px; color: #1976d2;">
            <i class="fa-solid fa-clock"></i>
            <strong>Waktu penyerahan berkas:</strong> Senin–Jumat pukul 08.00–13.00 WITA di Ruang Tata Usaha.
          </p>
          <p style="margin: 8px 0 0 0; display: flex; align-items: center; gap: 8px; color: #1976d2;">
            <i class="fa-solid fa-phone"></i>
            <strong>Kontak:</strong> 0851-1234-5678 (WhatsApp, Jam layanan 08.00–15.00 WITA)
          </p>
        </div>
      </article>
    </main>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>
