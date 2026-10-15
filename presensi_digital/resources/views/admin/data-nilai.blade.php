<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Data Nilai</title>
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
  <body data-page="admin-data-nilai">
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
          <a class="sidebar__link active" href="{{ route('admin.data-nilai') }}" data-nav="admin-data-nilai">
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
          <h1>Data Nilai Akademik</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <button class="btn" type="button">
              <i class="fa-solid fa-upload" aria-hidden="true"></i>
              <span>Impor Nilai</span>
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

        <section aria-labelledby="filter-nilai">
          <h2 id="filter-nilai" class="section-title">Filter Data</h2>
          <form method="GET" action="{{ route('admin.data-nilai') }}">
            <div class="grid grid-3">
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-layer-group"></i> Kelas</span>
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
                <span class="card__title"><i class="fa-solid fa-calendar-days"></i> Semester</span>
                <select name="semester" class="input-inline" onchange="this.form.submit()">
                  <option value="Semua Semester" {{ request('semester') == 'Semua Semester' || !request('semester') ? 'selected' : '' }}>Semua Semester</option>
                  <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>Semester 1</option>
                  <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>Semester 2</option>
                </select>
              </label>
            </div>
          </form>
        </section>

        <section aria-labelledby="rekap-nilai">
          <h2 id="rekap-nilai" class="section-title">Rekapitulasi Nilai</h2>
          <div class="grid grid-3">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-ranking-star"></i> Rata-rata Sekolah</p>
              <p class="card__value">{{ number_format($rataRataSekolah, 1) }}</p>
              <small>Nilai gabungan ujian harian dan ulangan.</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-arrow-trend-up"></i> Peningkatan Bulan Ini</p>
              <p class="card__value">+{{ number_format($peningkatanBulan, 1) }}%</p>
              <small>Dibandingkan periode sebelumnya.</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-face-smile"></i> Nilai Tertinggi</p>
              <p class="card__value">{{ number_format($nilaiTertinggi, 1) }}</p>
              <small>Diraih oleh {{ $siswaTerbaik ? $siswaTerbaik->siswa->nama_siswa . ' (' . ($siswaTerbaik->siswa->kelas->nama_kelas ?? '-') . ')' : '-' }}</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="tabel-nilai">
          <h2 id="tabel-nilai" class="section-title">Daftar Nilai Per Mata Pelajaran</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Nama Siswa</th>
                  <th>Kelas</th>
                  <th>Mata Pelajaran</th>
                  <th>Nilai Tugas</th>
                  <th>Nilai UTS</th>
                  <th>Nilai Akhir</th>
                </tr>
              </thead>
              <tbody>
                @forelse($nilai as $n)
                <tr>
                  <td>{{ $n->siswa->nama_siswa ?? '-' }}</td>
                  <td>{{ $n->siswa->kelas->nama_kelas ?? '-' }}</td>
                  <td>{{ $n->mapel->nama_mapel ?? '-' }}</td>
                  <td>{{ $n->nilai_tugas ? number_format($n->nilai_tugas, 1) : '-' }}</td>
                  <td>{{ $n->nilai_uts ? number_format($n->nilai_uts, 1) : '-' }}</td>
                  <td><span class="badge {{ $n->predikat_badge_class }}">{{ $n->nilai_akhir ? number_format($n->nilai_akhir, 1) : '-' }}</span></td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" style="text-align: center; padding: 2rem;">
                    <p>Tidak ada data nilai ditemukan</p>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
            @if(method_exists($nilai, 'hasPages') && $nilai->hasPages())
            <div style="display: flex; justify-content: center; padding: 1.5rem 0;">
              {{ $nilai->links() }}
            </div>
            @endif
          </div>
        </section>
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>

