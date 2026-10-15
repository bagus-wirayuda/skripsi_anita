<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Pendaftaran Orang Tua</title>
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
  <body data-page="register">
    <main class="register-layout">
      <article class="register-card card">
        <header class="register-header">
          <h1>Pendaftaran Orang Tua / Wali</h1>
          <p>
            Silakan isi data berikut untuk mendaftarkan calon siswa SDN 1 UNDUOLO.
            Setelah mengirim formulir, Anda akan menerima instruksi lanjutan.
          </p>
        </header>

        <form id="registerForm" class="register-form" action="{{ route('register.post') }}" method="POST">
          @csrf
          @if ($errors->any())
            <div class="alert alert-error" style="background: #fee; border: 1px solid #fcc; padding: 12px; border-radius: 8px; margin-bottom: 20px; color: #c33;">
              <strong>Perhatian!</strong>
              <ul style="margin: 8px 0 0 20px;">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          
          @if (session('success'))
            <div class="alert alert-success" style="background: #efe; border: 1px solid #cfc; padding: 12px; border-radius: 8px; margin-bottom: 20px; color: #3c3;">
              {{ session('success') }}
            </div>
          @endif

          <label class="form-group">
            <span><i class="fa-solid fa-user"></i> Nama Lengkap Orang Tua / Wali</span>
            <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Bapak Andi Saputra" required />
          </label>
          <label class="form-group">
            <span><i class="fa-solid fa-envelope"></i> Email</span>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Contoh: andi@email.com" required />
            <small style="color: #666; font-size: 0.875rem;">Email ini akan digunakan untuk login setelah disetujui admin</small>
          </label>
          <label class="form-group">
            <span><i class="fa-solid fa-id-card"></i> NIK (Nomor Induk Kependudukan)</span>
            <input type="text" name="nik" value="{{ old('nik') }}" placeholder="16 digit NIK (opsional)" maxlength="16" />
          </label>
          <label class="form-group">
            <span><i class="fa-solid fa-users"></i> Hubungan dengan Calon Siswa</span>
            <select name="hubungan" style="padding: 12px; border-radius: 8px; border: 1px solid #ddd; width: 100%;">
              <option value="Ayah" {{ old('hubungan') == 'Ayah' ? 'selected' : '' }}>Ayah</option>
              <option value="Ibu" {{ old('hubungan') == 'Ibu' ? 'selected' : '' }}>Ibu</option>
              <option value="Wali" {{ old('hubungan') == 'Wali' ? 'selected' : '' }}>Wali</option>
              <option value="Lainnya" {{ old('hubungan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
          </label>
          <label class="form-group">
            <span><i class="fa-solid fa-briefcase"></i> Pekerjaan</span>
            <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" placeholder="Contoh: PNS, Wiraswasta (opsional)" />
          </label>
          <label class="form-group">
            <span><i class="fa-solid fa-graduation-cap"></i> Pendidikan Terakhir</span>
            <input type="text" name="pendidikan" value="{{ old('pendidikan') }}" placeholder="Contoh: SMA, S1 (opsional)" />
          </label>
          <label class="form-group">
            <span><i class="fa-solid fa-location-dot"></i> Alamat Lengkap</span>
            <textarea
              name="alamat"
              placeholder="Tuliskan alamat domisili lengkap beserta RT/RW."
              rows="3"
              required
            >{{ old('alamat') }}</textarea>
          </label>
          <label class="form-group">
            <span><i class="fa-solid fa-phone"></i> Nomor HP Aktif</span>
            <input type="tel" name="nomor_hp" value="{{ old('nomor_hp') }}" placeholder="Contoh: 0812-XXXX-XXXX" required />
          </label>

          <button class="btn" type="submit">
            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
            <span>Kirim Pendaftaran</span>
          </button>
        </form>

        <footer class="register-footer">
          <p>
            Butuh bantuan? Hubungi admin sekolah melalui WhatsApp
            <strong>0851-1234-5678</strong> (Jam layanan 08.00–15.00 WITA).
          </p>
        </footer>
      </article>
    </main>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>

