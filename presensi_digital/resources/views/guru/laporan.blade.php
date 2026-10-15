<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Laporan Guru</title>
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
  <body data-page="guru-laporan">
    <div class="layout">
      <aside class="sidebar">
        <div class="sidebar__brand">
          <img src="{{ asset('assets/img/logo.png') }}" alt="Logo SDN 1 UNDUOLO" width="40" height="40" />
          <span>SDN 1 UNDUOLO</span>
        </div>
        <nav class="sidebar__nav">
          <a class="sidebar__link" href="{{ route('guru.dashboard') }}" data-nav="guru-dashboard">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
          </a>
          <a class="sidebar__link" href="{{ route('guru.kelas-saya') }}" data-nav="guru-kelas-saya">
            <i class="fa-solid fa-calendar-days"></i>
            <span>Kelas Saya</span>
          </a>
          <a class="sidebar__link" href="{{ route('guru.perwalian') }}" data-nav="guru-perwalian">
            <i class="fa-solid fa-users-rectangle"></i>
            <span>Perwalian</span>
          </a>
          <a class="sidebar__link" href="{{ route('guru.presensi') }}" data-nav="guru-presensi">
            <i class="fa-solid fa-clipboard-check"></i>
            <span>Presensi</span>
          </a>
          <a class="sidebar__link" href="{{ route('guru.nilai') }}" data-nav="guru-nilai">
            <i class="fa-solid fa-star"></i>
            <span>Nilai</span>
          </a>
          <a class="sidebar__link" href="{{ route('guru.notes') }}" data-nav="guru-notes">
            <i class="fa-solid fa-note-sticky"></i>
            <span>Notes</span>
          </a>
          <a class="sidebar__link active" href="{{ route('guru.laporan') }}" data-nav="guru-laporan">
            <i class="fa-solid fa-chart-bar"></i>
            <span>Laporan</span>
          </a>
          <a class="sidebar__link" href="{{ route('guru.penilaian-harian') }}" data-nav="guru-penilaian-harian">
            <i class="fa-solid fa-star-half-stroke"></i>
            <span>Penilaian Harian</span>
          </a>
        </nav>
      </aside>

      <main class="layout__main">
        <header class="page-header">
          <h1>Laporan Statistik Kelas</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <button class="btn" type="button">
              <i class="fa-solid fa-download" aria-hidden="true"></i>
              <span>Unduh Laporan</span>
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

        <section aria-labelledby="filter-laporan">
          <h2 id="filter-laporan" class="section-title">Filter Laporan</h2>
          <form method="GET" action="{{ route('guru.laporan') }}">
            <div class="grid grid-3">
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-layer-group"></i> Kelas</span>
                <select name="kelas" class="input-inline" onchange="this.form.submit()">
                  <option value="">Pilih Kelas</option>
                  @foreach($kelasList as $kelas)
                  <option value="{{ $kelas->nama_kelas }}" {{ $kelasFilter == $kelas->nama_kelas ? 'selected' : '' }}>
                    {{ $kelas->nama_kelas }}
                  </option>
                  @endforeach
                </select>
              </label>
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-calendar-week"></i> Periode</span>
                <select name="periode" class="input-inline" onchange="this.form.submit()">
                  <option value="minggu" {{ $periodeFilter == 'minggu' ? 'selected' : '' }}>Minggu Ini</option>
                  <option value="bulan" {{ $periodeFilter == 'bulan' || !$periodeFilter ? 'selected' : '' }}>Bulan Ini</option>
                  <option value="semester" {{ $periodeFilter == 'semester' ? 'selected' : '' }}>Semester Ini</option>
                </select>
              </label>
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-calendar"></i> Tanggal</span>
                <input name="tanggal" class="input-inline" type="date" value="{{ $tanggalFilter }}" onchange="this.form.submit()" />
              </label>
            </div>
          </form>
        </section>

        @if($kelasFilter)
        <section aria-labelledby="statistik-kelas">
          <h2 id="statistik-kelas" class="section-title">Statistik {{ $kelasFilter }}</h2>
          <div class="stats-grid">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-graduate"></i> Total Siswa</p>
              <p class="card__value">{{ number_format($totalSiswa) }}</p>
              <small>Jumlah siswa aktif di kelas</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-calendar-check"></i> Rata-rata Kehadiran</p>
              <p class="card__value">{{ number_format($rataRataKehadiran, 1) }}%</p>
              <small>Dari total hari belajar periode ini</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-star"></i> Rata-rata Nilai</p>
              <p class="card__value">{{ number_format($rataRataNilai, 1) }}</p>
              <small>Rata-rata nilai seluruh siswa</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-check-circle"></i> Siswa Hadir Hari Ini</p>
              <p class="card__value">{{ number_format($siswaHadirHariIni) }}</p>
              <small>Siswa yang hadir hari ini</small>
            </article>
          </div>
        </section>
        @else
        <section aria-labelledby="statistik-kelas">
          <div class="card" style="text-align: center; padding: 3rem;">
            <p><i class="fa-solid fa-info-circle"></i> Silakan pilih kelas terlebih dahulu untuk melihat statistik</p>
          </div>
        </section>
        @endif

        @if($kelasFilter && $detailPresensi->count() > 0)
        <section aria-labelledby="detail-presensi">
          <h2 id="detail-presensi" class="section-title">Detail Presensi {{ ucfirst($periodeFilter) }}</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Nama Siswa</th>
                  <th>Hadir</th>
                  <th>Izin</th>
                  <th>Sakit</th>
                  <th>Alpa</th>
                  <th>Persentase</th>
                </tr>
              </thead>
              <tbody>
                @if($detailPresensi->count() > 0)
                  @foreach($detailPresensi as $dp)
                  <tr>
                    <td>{{ $dp->siswa->nama_siswa ?? '-' }}</td>
                    <td>{{ $dp->hadir ?? 0 }}</td>
                    <td>{{ $dp->izin ?? 0 }}</td>
                    <td>{{ $dp->sakit ?? 0 }}</td>
                    <td>{{ $dp->alpa ?? 0 }}</td>
                    <td>
                      @php
                        $persentase = $dp->persentase ?? 0;
                        $badgeClass = 'status--hadir';
                        if ($persentase < 75) {
                          $badgeClass = 'status--alpha';
                        } elseif ($persentase < 85) {
                          $badgeClass = 'status--izin';
                        }
                      @endphp
                      <span class="badge {{ $badgeClass }}">{{ number_format($persentase, 1) }}%</span>
                    </td>
                  </tr>
                  @endforeach
                @else
                <tr>
                  <td colspan="6" style="text-align: center; padding: 2rem;">
                    <p>Tidak ada data presensi ditemukan</p>
                  </td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        </section>
        @elseif($kelasFilter && $detailPresensi->count() == 0)
        <section aria-labelledby="detail-presensi">
          <div class="card" style="text-align: center; padding: 3rem;">
            <p><i class="fa-solid fa-info-circle"></i> Belum ada data presensi untuk periode ini</p>
          </div>
        </section>
        @endif

        <section aria-labelledby="grafik-statistik">
          <h2 id="grafik-statistik" class="section-title">Grafik Statistik</h2>
          <div class="grid grid-2">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-chart-column"></i> Tren Kehadiran</p>
              <canvas id="chartKehadiran" width="400" height="200"></canvas>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-chart-line"></i> Tren Nilai</p>
              <canvas id="chartNilai" width="400" height="200"></canvas>
            </article>
          </div>
        </section>
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>

