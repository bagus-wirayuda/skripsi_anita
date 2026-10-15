<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Tambah Guru</title>
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
  <body data-page="admin-data-guru">
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
          <a class="sidebar__link active" href="{{ route('admin.data-guru') }}" data-nav="admin-data-guru">
            <i class="fa-solid fa-person-chalkboard"></i>
            <span>Guru</span>
          </a>
          <a class="sidebar__link" href="{{ route('admin.data-siswa') }}" data-nav="admin-data-siswa">
            <i class="fa-solid fa-children"></i>
            <span>Siswa</span>
          </a>
          <a class="sidebar__link" href="{{ route('admin.kelas.index') }}" data-nav="admin-kelas">
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
          <h1>Tambah Guru</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('admin.data-guru') }}" class="btn">
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

        @if(session('error'))
        <div class="alert alert-error" style="margin: 1rem 0; padding: 1rem; background: #f8d7da; color: #721c24; border-radius: 4px;">
          {{ session('error') }}
        </div>
        @endif

        <section aria-labelledby="form-guru">
          <h2 id="form-guru" class="section-title">Form Tambah Guru</h2>
          <form method="POST" action="{{ route('admin.data-guru.store') }}" class="card" style="max-width: 800px;">
            @csrf
            
            <div style="margin-bottom: 1.5rem;">
              <h3 style="margin-bottom: 1rem; color: #333; font-size: 1.1rem;">Data Akun</h3>
              <div class="grid grid-2" style="gap: 1rem;">
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Nama Lengkap *</span>
                  <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap guru" required style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" />
                </label>
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Email *</span>
                  <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" required style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" />
                </label>
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Password *</span>
                  <input type="password" name="password" required style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" />
                </label>
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Konfirmasi Password *</span>
                  <input type="password" name="password_confirmation" required style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" />
                </label>
              </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
              <h3 style="margin-bottom: 1rem; color: #333; font-size: 1.1rem;">Data Profil Guru</h3>
              <div class="grid grid-2" style="gap: 1rem;">
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">NIP</span>
                  <input type="text" name="nip" value="{{ old('nip') }}" placeholder="Nomor Induk Pegawai" maxlength="20" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" />
                </label>
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Pangkat</span>
                  <input type="text" name="pangkat" value="{{ old('pangkat') }}" placeholder="Pangkat golongan" maxlength="50" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" />
                </label>
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">No. HP</span>
                  <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="081234567890" maxlength="20" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" />
                </label>
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Tanggal Lahir</span>
                  <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" />
                </label>
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Jenis Kelamin</span>
                  <select name="jenis_kelamin" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; background-color: white;">
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                  </select>
                </label>
              </div>
              <label style="display: flex; flex-direction: column; gap: 0.5rem; margin-top: 1rem;">
                <span style="font-weight: 500; color: #555;">Alamat</span>
                <textarea name="alamat" rows="3" placeholder="Alamat lengkap" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; resize: vertical;">{{ old('alamat') }}</textarea>
              </label>
            </div>

            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #eee; display: flex; gap: 0.75rem;">
              <button type="submit" class="btn" style="flex: 0 0 auto;">
                <i class="fa-solid fa-save"></i>
                <span>Simpan Guru</span>
              </button>
              <a href="{{ route('admin.data-guru') }}" class="btn btn--secondary" style="flex: 0 0 auto;">
                <span>Batal</span>
              </a>
            </div>
          </form>
        </section>
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>

