<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Edit Siswa</title>
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
  <body data-page="admin-data-siswa">
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
          <a class="sidebar__link active" href="{{ route('admin.data-siswa') }}" data-nav="admin-data-siswa">
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
          <h1 style="word-wrap: break-word; word-break: break-word; overflow-wrap: break-word; max-width: 100%;">Edit Siswa: {{ $siswa->nama_siswa }}</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('admin.data-siswa.show', $siswa->id) }}" class="btn">
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

        <section aria-labelledby="form-siswa">
          <h2 id="form-siswa" class="section-title">Form Edit Siswa</h2>
          <form method="POST" action="{{ route('admin.data-siswa.update', $siswa->id) }}" class="card" style="max-width: 800px; margin: 0 auto;">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1.5rem;">
              <h3 style="margin-bottom: 1rem; color: #333; font-size: 1.1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e9ecef;">
                <i class="fa-solid fa-user-graduate" style="margin-right: 0.5rem; color: #007bff;"></i>
                Informasi Siswa
              </h3>
              <label style="display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1rem;">
                <span style="font-weight: 500; color: #555;">Nama Lengkap Siswa *</span>
                <input type="text" name="nama_siswa" value="{{ old('nama_siswa', $siswa->nama_siswa) }}" placeholder="Contoh: Andi Pratama" required style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" />
              </label>
              <div class="grid grid-2" style="gap: 1rem;">
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">NIS</span>
                  <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" placeholder="Nomor Induk Siswa" maxlength="20" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" />
                </label>
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">NISN</span>
                  <input type="text" name="nisn" value="{{ old('nisn', $siswa->nisn) }}" placeholder="Nomor Induk Siswa Nasional" maxlength="10" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" />
                </label>
              </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
              <h3 style="margin-bottom: 1rem; color: #333; font-size: 1.1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e9ecef;">
                <i class="fa-solid fa-school" style="margin-right: 0.5rem; color: #007bff;"></i>
                Kelas & Data Pribadi
              </h3>
              <div class="grid grid-2" style="gap: 1rem;">
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Kelas</span>
                  <select name="kelas_id" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; background-color: white;">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $kelas)
                    <option value="{{ $kelas->id }}" {{ old('kelas_id', $siswa->kelas_id) == $kelas->id ? 'selected' : '' }}>
                      {{ $kelas->nama_kelas }}
                    </option>
                    @endforeach
                  </select>
                </label>
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Jenis Kelamin</span>
                  <select name="jenis_kelamin" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; background-color: white;">
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                  </select>
                </label>
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Tanggal Lahir</span>
                  <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('Y-m-d') : '') }}" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" />
                </label>
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Tempat Lahir</span>
                  <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" placeholder="Contoh: Jakarta" maxlength="100" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" />
                </label>
              </div>
              <label style="display: flex; flex-direction: column; gap: 0.5rem; margin-top: 1rem;">
                <span style="font-weight: 500; color: #555;">Alamat</span>
                <textarea name="alamat" rows="3" placeholder="Alamat lengkap (opsional, jika kosong akan menggunakan alamat orang tua)" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; resize: vertical;">{{ old('alamat', $siswa->alamat) }}</textarea>
              </label>
            </div>

            @if($siswa->ortu)
            <div style="background: rgba(33, 150, 243, 0.08); border-left: 4px solid #2196f3; padding: 1rem; margin-bottom: 1.5rem; border-radius: 4px;">
              <p style="margin: 0; color: #1976d2; font-size: 0.875rem;">
                <i class="fa-solid fa-info-circle"></i> 
                <strong>Catatan:</strong> Email dan nomor HP siswa menggunakan data dari orang tua ({{ $siswa->ortu->user->email ?? '-' }} / {{ $siswa->ortu->no_hp ?? '-' }}).
              </p>
            </div>
            @endif

            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #eee; display: flex; gap: 0.75rem;">
              <button type="submit" class="btn" style="flex: 0 0 auto;">
                <i class="fa-solid fa-save"></i>
                <span>Simpan Perubahan</span>
              </button>
              <a href="{{ route('admin.data-siswa.show', $siswa->id) }}" class="btn btn--secondary" style="flex: 0 0 auto;">
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

