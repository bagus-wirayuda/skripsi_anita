<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Edit Kelas</title>
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
  <body data-page="admin-kelas">
    <div class="layout">
      <aside class="sidebar">
        <div class="sidebar__brand">
          <img src="{{ asset('assets/img/logo.png') }}" alt="Logo SDN 1 UNDUOLO" width="40" height="40" />
          <span>SDN 1 UNDUOLO</span>
        </div>
        <nav class="sidebar__nav">
          <a class="sidebar__link" href="{{ route('admin.dashboard') }}" data-nav="admin-dashboard">
            <i class="fa-solid fa-chart-line"></i>
            <span>Dashboard</span>
          </a>
          <a class="sidebar__link" href="{{ route('admin.pendaftaran') }}" data-nav="admin-pendaftaran">
            <i class="fa-solid fa-user-plus"></i>
            <span>Pendaftaran</span>
          </a>
          <a class="sidebar__link" href="{{ route('admin.absensi-siswa') }}" data-nav="admin-absensi">
            <i class="fa-solid fa-clipboard-user"></i>
            <span>Presensi</span>
          </a>
          <a class="sidebar__link" href="{{ route('admin.data-guru') }}" data-nav="admin-data-guru">
            <i class="fa-solid fa-person-chalkboard"></i>
            <span>Guru</span>
          </a>
          <a class="sidebar__link" href="{{ route('admin.data-siswa') }}" data-nav="admin-data-siswa">
            <i class="fa-solid fa-children"></i>
            <span>Siswa</span>
          </a>
          <a class="sidebar__link active" href="{{ route('admin.kelas.index') }}" data-nav="admin-kelas">
            <i class="fa-solid fa-door-open"></i>
            <span>Kelas</span>
          </a>
          <a class="sidebar__link" href="{{ route('admin.mapel.index') }}" data-nav="admin-mapel">
            <i class="fa-solid fa-book"></i>
            <span>Mapel</span>
          </a>
          <a class="sidebar__link" href="{{ route('admin.data-nilai') }}" data-nav="admin-data-nilai">
            <i class="fa-solid fa-chart-column"></i>
            <span>Nilai</span>
          </a>
          <a class="sidebar__link" href="{{ route('admin.data-user') }}" data-nav="admin-data-user">
            <i class="fa-solid fa-users-gear"></i>
            <span>User</span>
          </a>
          <a class="sidebar__link" href="{{ route('admin.laporan') }}" data-nav="admin-laporan">
            <i class="fa-solid fa-file-lines"></i>
            <span>Laporan</span>
          </a>
        </nav>
      </aside>

      <main class="layout__main">
        <header class="page-header">
          <h1>Edit Kelas: {{ $kelas->nama_kelas }}</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('admin.kelas.index') }}" class="btn">
              <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
              <span>Kembali</span>
            </a>
            <div class="user-menu">
              <button class="user-menu__trigger" type="button" aria-label="User Menu">
                <i class="fa-solid fa-user"></i>
              </button>
              <div class="user-menu__dropdown">
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                  @csrf
                  <button type="submit" class="user-menu__item user-menu__item--logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </header>

        @if($errors->any())
        <div class="alert alert-error" style="margin: 1rem 0; padding: 1rem; background: #f8d7da; color: #721c24; border-radius: 4px;">
          <ul style="margin: 0; padding-left: 1.5rem;">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <section aria-labelledby="form-kelas">
          <h2 id="form-kelas" class="section-title">Form Edit Kelas: {{ $kelas->nama_kelas }}</h2>
          <form method="POST" action="{{ route('admin.kelas.update', $kelas->id) }}" class="card" style="max-width: 800px; margin: 0 auto;">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1.5rem;">
              <h3 style="margin-bottom: 1rem; color: #333; font-size: 1.1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e9ecef;">
                <i class="fa-solid fa-door-open" style="margin-right: 0.5rem; color: #007bff;"></i>
                Informasi Kelas
              </h3>
              <div class="grid grid-2" style="gap: 1rem;">
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Tingkat Kelas *</span>
                  <select name="tingkat" required style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; background-color: white; transition: border-color 0.3s;" onchange="updatePreview()">
                    <option value="">-- Pilih Tingkat --</option>
                    @for($i = 1; $i <= 6; $i++)
                    <option value="{{ $i }}" {{ old('tingkat', $kelas->tingkat) == $i ? 'selected' : '' }}>Kelas {{ $i }}</option>
                    @endfor
                  </select>
                </label>
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Rombel *</span>
                  <input type="text" name="rombel" value="{{ old('rombel', $kelas->rombel) }}" placeholder="A, B, C, dst" maxlength="10" required style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; text-transform: uppercase;" oninput="this.value = this.value.toUpperCase(); updatePreview()" />
                  <small style="color: #666; font-size: 0.875rem;">Nama kelas akan otomatis menjadi: <strong id="preview-nama" style="color: #007bff;">{{ $kelas->tingkat . ($kelas->rombel ?? '') }}</strong></small>
                </label>
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Kapasitas</span>
                  <input type="number" name="kapasitas" value="{{ old('kapasitas', $kelas->kapasitas ?? 30) }}" min="1" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" />
                </label>
              </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
              <h3 style="margin-bottom: 1rem; color: #333; font-size: 1.1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e9ecef;">
                <i class="fa-solid fa-person-chalkboard" style="margin-right: 0.5rem; color: #007bff;"></i>
                Wali Kelas
              </h3>
              <div class="grid grid-2" style="gap: 1rem;">
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Pilih Wali Kelas (Guru)</span>
                  <select name="wali_kelas_id" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; background-color: white;">
                    <option value="">-- Pilih Wali Kelas --</option>
                    @foreach($guruList as $guru)
                    <option value="{{ $guru->id }}" {{ old('wali_kelas_id', $kelas->wali_kelas_id) == $guru->id ? 'selected' : '' }}>
                      {{ $guru->user->name ?? '-' }} 
                      @if($guru->nip) ({{ $guru->nip }}) @endif
                    </option>
                    @endforeach
                  </select>
                </label>
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Panggilan Guru (Opsional)</span>
                  <input type="text" name="wali_kelas" value="{{ old('wali_kelas', $kelas->wali_kelas) }}" placeholder="Contoh: Pak Budi, Bu Siti" maxlength="100" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" />
                </label>
              </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
              <h3 style="margin-bottom: 1rem; color: #333; font-size: 1.1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e9ecef;">
                <i class="fa-solid fa-file-lines" style="margin-right: 0.5rem; color: #007bff;"></i>
                Informasi Tambahan
              </h3>
              <label style="display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1rem;">
                <span style="font-weight: 500; color: #555;">Deskripsi (Opsional)</span>
                <textarea name="deskripsi" rows="3" placeholder="Deskripsi kelas" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; resize: vertical;">{{ old('deskripsi', $kelas->deskripsi) }}</textarea>
              </label>
              <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                <span style="font-weight: 500; color: #555;">Catatan (Opsional)</span>
                <textarea name="catatan" rows="3" placeholder="Catatan tentang kelas ini" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; resize: vertical;">{{ old('catatan', $kelas->catatan) }}</textarea>
              </label>
            </div>

            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #eee; display: flex; gap: 0.75rem;">
              <button type="submit" class="btn" style="flex: 0 0 auto;">
                <i class="fa-solid fa-save"></i>
                <span>Update Kelas</span>
              </button>
              <a href="{{ route('admin.kelas.index') }}" class="btn btn--secondary" style="flex: 0 0 auto;">
                <span>Batal</span>
              </a>
            </div>
          </form>
        </section>

        <script>
          function updatePreview() {
            const tingkat = document.querySelector('select[name="tingkat"]').value;
            const rombel = document.querySelector('input[name="rombel"]').value.toUpperCase();
            const preview = document.getElementById('preview-nama');
            
            if (tingkat && rombel) {
              preview.textContent = tingkat + rombel;
            } else {
              preview.textContent = '-';
            }
          }
          
          // Initialize preview on page load
          document.addEventListener('DOMContentLoaded', updatePreview);
        </script>
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>

