<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Laporan Presensi</title>
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
  <body data-page="admin-laporan">
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
          <a class="sidebar__link active" href="{{ route('admin.laporan') }}" data-nav="admin-laporan">
            <i class="fa-solid fa-file-lines"></i>
            <span>Laporan</span>
          </a>
        </nav>
      </aside>

      <main class="layout__main">
        <header class="page-header">
          <h1>Laporan Presensi Siswa</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <button class="btn" type="button">
              <i class="fa-solid fa-share-from-square" aria-hidden="true"></i>
              <span>Bagikan</span>
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

        <section aria-labelledby="ringkasan-laporan">
          <h2 id="ringkasan-laporan" class="section-title">Ringkasan Laporan</h2>
          <div class="grid grid-3">
            <article class="card">
              <p class="card__title">
                <i class="fa-solid fa-graduation-cap"></i> Laporan Akademik
              </p>
              <p class="card__value">{{ number_format($laporanAkademik, 1) }}%</p>
              <small>Nilai rata-rata semester, termasuk tren kenaikan 3%.</small>
            </article>
            <article class="card">
              <p class="card__title">
                <i class="fa-solid fa-user-check"></i> Laporan Absensi Siswa
              </p>
              <p class="card__value">{{ number_format($persentaseKehadiran, 1) }}%</p>
              <small>Kehadiran keseluruhan periode yang dipilih.</small>
            </article>
            <article class="card">
              <p class="card__title">
                <i class="fa-solid fa-lightbulb"></i> Evaluasi Pembelajaran
              </p>
              <p class="card__value">{{ number_format($evaluasiPembelajaran, 1) }}%</p>
              <small>Feedback positif terhadap metode pengajaran terbaru.</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="filter-presensi">
          <h2 id="filter-presensi" class="section-title">Filter Laporan</h2>
          <form method="GET" action="{{ route('admin.laporan') }}">
            <div class="grid grid-3">
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-users"></i> Pilih Kelas</span>
                <select name="kelas" class="input-inline" onchange="this.form.submit()">
                  <option value="Semua Kelas" {{ $kelasFilter == 'Semua Kelas' || !$kelasFilter ? 'selected' : '' }}>Semua Kelas</option>
                  @foreach($kelasList as $kelas)
                  <option value="{{ $kelas->nama_kelas }}" {{ $kelasFilter == $kelas->nama_kelas ? 'selected' : '' }}>
                    {{ $kelas->nama_kelas }}
                  </option>
                  @endforeach
                </select>
              </label>
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-calendar-week"></i> Rentang Tanggal</span>
                <input name="tanggal_awal" class="input-inline" type="date" value="{{ $tanggalAwal }}" onchange="this.form.submit()" />
              </label>
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-calendar-week"></i> Sampai</span>
                <input name="tanggal_akhir" class="input-inline" type="date" value="{{ $tanggalAkhir }}" onchange="this.form.submit()" />
              </label>
            </div>
          </form>
        </section>

        <section aria-labelledby="tabel-presensi">
          <h2 id="tabel-presensi" class="section-title">Rekap Presensi</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Nama Siswa</th>
                  <th>Tanggal</th>
                  <th>Kelas</th>
                  <th>Status</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody>
                @forelse($presensi as $p)
                <tr>
                  <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                  <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                  <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                  <td><span class="badge {{ $p->status_badge_class }}">{{ ucfirst($p->status) }}</span></td>
                  <td>{{ $p->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" style="text-align: center; padding: 2rem;">
                    <p>Tidak ada data laporan presensi ditemukan</p>
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


