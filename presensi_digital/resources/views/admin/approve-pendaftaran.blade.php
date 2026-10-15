<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Setujui Pendaftaran</title>
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
  <body data-page="admin-approve-pendaftaran">
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
          <h1>Setujui Pendaftaran - {{ $ortuRegister->name }}</h1>
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
        </header>

        <section aria-labelledby="data-ortu">
          <h2 id="data-ortu" class="section-title">Data Orang Tua / Wali</h2>
          <div class="card">
            <dl style="display: grid; gap: 12px; margin: 0;">
              <div style="display: grid; grid-template-columns: 200px 1fr; gap: 12px;">
                <dt style="font-weight: 600; color: var(--accent-color);">Nama Lengkap:</dt>
                <dd>{{ $ortuRegister->name }}</dd>
              </div>
              <div style="display: grid; grid-template-columns: 200px 1fr; gap: 12px;">
                <dt style="font-weight: 600; color: var(--accent-color);">Email:</dt>
                <dd>{{ $ortuRegister->email }}</dd>
              </div>
              <div style="display: grid; grid-template-columns: 200px 1fr; gap: 12px;">
                <dt style="font-weight: 600; color: var(--accent-color);">NIK:</dt>
                <dd>{{ $ortuRegister->nik ?? '-' }}</dd>
              </div>
              <div style="display: grid; grid-template-columns: 200px 1fr; gap: 12px;">
                <dt style="font-weight: 600; color: var(--accent-color);">Hubungan:</dt>
                <dd>{{ $ortuRegister->hubungan }}</dd>
              </div>
              <div style="display: grid; grid-template-columns: 200px 1fr; gap: 12px;">
                <dt style="font-weight: 600; color: var(--accent-color);">No. HP:</dt>
                <dd>{{ $ortuRegister->no_hp }}</dd>
              </div>
              <div style="display: grid; grid-template-columns: 200px 1fr; gap: 12px;">
                <dt style="font-weight: 600; color: var(--accent-color);">Alamat:</dt>
                <dd>{{ $ortuRegister->alamat }}</dd>
              </div>
            </dl>
          </div>
        </section>

        <section aria-labelledby="data-anak">
          <h2 id="data-anak" class="section-title">Data Anak (Siswa)</h2>
          <form action="{{ route('admin.pendaftaran.approve', $ortuRegister->id) }}" method="POST" class="card">
            @csrf
            
            @if ($errors->any())
              <div class="alert alert--error" style="margin-bottom: 20px;">
                <strong>Perhatian!</strong>
                <ul style="margin: 8px 0 0 20px;">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <div style="display: grid; gap: 20px;">
              <label class="form-group">
                <span><i class="fa-solid fa-user"></i> Nama Lengkap Anak *</span>
                <input type="text" name="nama_anak" value="{{ old('nama_anak') }}" placeholder="Contoh: Andi Pratama" required />
              </label>

              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <label class="form-group">
                  <span><i class="fa-solid fa-id-card"></i> NIS</span>
                  <input type="text" name="nis" value="{{ old('nis') }}" placeholder="Nomor Induk Siswa" maxlength="20" />
                </label>

                <label class="form-group">
                  <span><i class="fa-solid fa-id-card"></i> NISN</span>
                  <input type="text" name="nisn" value="{{ old('nisn') }}" placeholder="Nomor Induk Siswa Nasional" maxlength="10" />
                </label>
              </div>

              <label class="form-group">
                <span><i class="fa-solid fa-school"></i> Kelas</span>
                <select name="kelas_id" style="padding: 12px; border-radius: 8px; border: 1px solid #ddd; width: 100%;">
                  <option value="">Pilih Kelas</option>
                  @foreach($kelasList as $kelas)
                  <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>
                    {{ $kelas->nama_kelas }}
                  </option>
                  @endforeach
                </select>
              </label>

              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <label class="form-group">
                  <span><i class="fa-solid fa-calendar"></i> Tanggal Lahir</span>
                  <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" />
                </label>

                <label class="form-group">
                  <span><i class="fa-solid fa-map-marker-alt"></i> Tempat Lahir</span>
                  <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Contoh: Jakarta" maxlength="100" />
                </label>
              </div>

              <label class="form-group">
                <span><i class="fa-solid fa-venus-mars"></i> Jenis Kelamin</span>
                <select name="jenis_kelamin" style="padding: 12px; border-radius: 8px; border: 1px solid #ddd; width: 100%;">
                  <option value="">Pilih Jenis Kelamin</option>
                  <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                  <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
              </label>

              <label class="form-group">
                <span><i class="fa-solid fa-location-dot"></i> Alamat</span>
                <textarea name="alamat_anak" placeholder="Alamat lengkap (opsional, jika kosong akan menggunakan alamat orang tua)" rows="3">{{ old('alamat_anak') }}</textarea>
              </label>

              <div class="alert" style="background: rgba(33, 150, 243, 0.08); border-left: 4px solid #2196f3; padding: 12px; margin-top: 16px;">
                <p style="margin: 0; color: #1976d2; font-size: 0.875rem;">
                  <i class="fa-solid fa-info-circle"></i> 
                  <strong>Catatan:</strong> Email dan nomor HP siswa akan menggunakan data dari orang tua ({{ $ortuRegister->email }} / {{ $ortuRegister->no_hp }}).
                </p>
              </div>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 24px;">
              <button type="submit" class="btn btn--success" style="flex: 1;">
                <i class="fa-solid fa-check"></i>
                <span>Setujui dan Simpan</span>
              </button>
              <a href="{{ route('admin.pendaftaran') }}" class="btn btn--ghost" style="flex: 1; text-align: center;">
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

