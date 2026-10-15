<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Edit Mata Pelajaran</title>
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
  <body data-page="admin-mapel">
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
          <a class="sidebar__link active" href="{{ route('admin.mapel.index') }}" data-nav="admin-mapel">
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
          <h1>Edit Mata Pelajaran: {{ $mapel->nama_mapel }}</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('admin.mapel.index') }}" class="btn">
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

        <section aria-labelledby="form-mapel">
          <h2 id="form-mapel" class="section-title">Form Edit Mata Pelajaran</h2>
          <form method="POST" action="{{ route('admin.mapel.update', $mapel->id) }}" class="card" style="max-width: 800px;">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1.5rem;">
              <h3 style="margin-bottom: 1rem; color: #333; font-size: 1.1rem;">Informasi Mata Pelajaran</h3>
              <div class="grid grid-2" style="gap: 1rem;">
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Nama Mata Pelajaran *</span>
                  <input type="text" name="nama_mapel" value="{{ old('nama_mapel', $mapel->nama_mapel) }}" placeholder="Contoh: Matematika" required style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" />
                </label>
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Kode Mapel *</span>
                  <input type="text" name="kode_mapel" value="{{ old('kode_mapel', $mapel->kode_mapel) }}" placeholder="Contoh: MAT-01" maxlength="20" required style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" />
                </label>
              </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
              <h3 style="margin-bottom: 1rem; color: #333; font-size: 1.1rem;">Kelas & Guru</h3>
              <div class="grid grid-2" style="gap: 1rem;">
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Kelas *</span>
                  <select name="kelas_id" required style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; background-color: white;">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $kelas)
                    <option value="{{ $kelas->id }}" {{ old('kelas_id', $mapel->kelas_id) == $kelas->id ? 'selected' : '' }}>
                      {{ $kelas->nama_kelas }}
                    </option>
                    @endforeach
                  </select>
                </label>
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Guru Pengajar *</span>
                  <select name="guru_id" required style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; background-color: white;">
                    <option value="">-- Pilih Guru --</option>
                    @foreach($guruList as $guru)
                    <option value="{{ $guru->id }}" {{ old('guru_id', $mapel->guru_id) == $guru->id ? 'selected' : '' }}>
                      {{ $guru->user->name ?? '-' }}
                      @if($guru->nip) ({{ $guru->nip }}) @endif
                    </option>
                    @endforeach
                  </select>
                </label>
              </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
              <h3 style="margin-bottom: 1rem; color: #333; font-size: 1.1rem;">Jadwal Pelajaran</h3>
              <div class="grid grid-3" style="gap: 1rem;">
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Hari *</span>
                  <select name="hari" required style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; background-color: white;">
                    <option value="">-- Pilih Hari --</option>
                    <option value="Senin" {{ old('hari', $mapel->hari) == 'Senin' ? 'selected' : '' }}>Senin</option>
                    <option value="Selasa" {{ old('hari', $mapel->hari) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                    <option value="Rabu" {{ old('hari', $mapel->hari) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                    <option value="Kamis" {{ old('hari', $mapel->hari) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                    <option value="Jumat" {{ old('hari', $mapel->hari) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                    <option value="Sabtu" {{ old('hari', $mapel->hari) == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                  </select>
                </label>
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Jam Mulai *</span>
                  <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $mapel->jam_mulai ?? '09:00') }}" required style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" />
                </label>
                <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                  <span style="font-weight: 500; color: #555;">Jam Selesai *</span>
                  <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $mapel->jam_selesai ?? '10:00') }}" required style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;" />
                </label>
              </div>
            </div>

            <div style="margin-bottom: 1.5rem;">
              <h3 style="margin-bottom: 1rem; color: #333; font-size: 1.1rem;">Deskripsi</h3>
              <label style="display: flex; flex-direction: column; gap: 0.5rem;">
                <span style="font-weight: 500; color: #555;">Deskripsi (Opsional)</span>
                <textarea name="deskripsi" rows="4" placeholder="Deskripsi mata pelajaran" style="padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; resize: vertical;">{{ old('deskripsi', $mapel->deskripsi) }}</textarea>
              </label>
            </div>

            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #eee; display: flex; gap: 0.75rem;">
              <button type="submit" class="btn" style="flex: 0 0 auto;">
                <i class="fa-solid fa-save"></i>
                <span>Update Mata Pelajaran</span>
              </button>
              <a href="{{ route('admin.mapel.index') }}" class="btn btn--secondary" style="flex: 0 0 auto;">
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

