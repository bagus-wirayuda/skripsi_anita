<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Absensi Siswa</title>
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
  <body data-page="admin-absensi">
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
          <a class="sidebar__link active" href="{{ route('admin.absensi-siswa') }}" data-nav="admin-absensi">
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
          <h1>Absensi Siswa</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <button class="btn" type="button">
              <i class="fa-solid fa-download" aria-hidden="true"></i>
              <span>Unduh Rekap</span>
            </button>
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

        <section aria-labelledby="filter-absensi">
          <h2 id="filter-absensi" class="section-title">Filter Kehadiran</h2>
          <form method="GET" action="{{ route('admin.absensi-siswa') }}">
            <div class="grid grid-3">
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-school"></i> Kelas</span>
                <select name="kelas" class="input-inline" onchange="this.form.submit()">
                  <option value="Semua Kelas" {{ request('kelas') == 'Semua Kelas' || !request('kelas') ? 'selected' : '' }}>Semua Kelas</option>
                  @foreach($kelasList as $kelas)
                  <option value="{{ $kelas->nama_kelas }}" {{ request('kelas') == $kelas->nama_kelas ? 'selected' : '' }}>
                    {{ $kelas->nama_kelas }}
                  </option>
                  @endforeach
                </select>
              </label>
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-calendar-day"></i> Tanggal</span>
                <input name="tanggal" class="input-inline" type="date" value="{{ request('tanggal', \Carbon\Carbon::today()->format('Y-m-d')) }}" onchange="this.form.submit()" />
              </label>
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-filter"></i> Status</span>
                <select name="status" class="input-inline" onchange="this.form.submit()">
                  <option value="Semua Status" {{ request('status') == 'Semua Status' || !request('status') ? 'selected' : '' }}>Semua Status</option>
                  <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                  <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                  <option value="Sakit" {{ request('status') == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                  <option value="Alpa" {{ request('status') == 'Alpa' ? 'selected' : '' }}>Alpa</option>
                  <option value="Terlambat" {{ request('status') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                </select>
              </label>
            </div>
          </form>
        </section>

        <section aria-labelledby="tabel-absensi">
          <h2 id="tabel-absensi" class="section-title">Daftar Kehadiran Harian</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Nama Siswa</th>
                  <th>Kelas</th>
                  <th>Status</th>
                  <th>Jam Masuk</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                @forelse($presensi as $p)
                <tr>
                  <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                  <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                  <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                  <td><span class="badge {{ $p->status_badge_class }}">{{ ucfirst($p->status) }}</span></td>
                  <td>{{ $p->waktu_masuk_formatted }}</td>
                  <td>{{ $p->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" style="text-align: center; padding: 2rem;">
                    <p>Tidak ada data presensi ditemukan</p>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </section>
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>

