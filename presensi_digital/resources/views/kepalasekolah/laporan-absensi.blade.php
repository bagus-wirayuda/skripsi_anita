<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Laporan Absensi</title>
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
  <body data-page="kepala-laporan-absensi">
    <div class="layout">
      <aside class="sidebar">
        <div class="sidebar__brand">
          <img src="{{ asset('assets/img/logo.png') }}" alt="Logo SDN 1 UNDUOLO" width="40" height="40" />
          <span>SDN 1 UNDUOLO</span>
        </div>
        <nav class="sidebar__nav">
          <a class="sidebar__link" href="{{ route('kepalasekolah.dashboard') }}" data-nav="kepala-dashboard">
            <i class="fa-solid fa-gauge"></i>
            <span>Dashboard</span>
          </a>
          <a class="sidebar__link" href="{{ route('kepalasekolah.laporan') }}" data-nav="kepala-laporan">
            <i class="fa-solid fa-folder-open"></i>
            <span>Laporan</span>
          </a>
          <a class="sidebar__link" href="{{ route('kepalasekolah.laporan-akademik') }}" data-nav="kepala-laporan-akademik">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>Laporan Akademik</span>
          </a>
          <a class="sidebar__link" href="{{ route('kepalasekolah.laporan-absensi-guru') }}" data-nav="kepala-laporan-absensi-guru">
            <i class="fa-solid fa-chalkboard-user"></i>
            <span>Laporan Absensi Guru</span>
          </a>
          <a class="sidebar__link" href="{{ route('kepalasekolah.laporan-absensi-siswa') }}" data-nav="kepala-laporan-absensi-siswa">
            <i class="fa-solid fa-user-graduate"></i>
            <span>Laporan Absensi Siswa</span>
          </a>
          <a class="sidebar__link is-active" href="{{ route('kepalasekolah.laporan-absensi') }}" data-nav="kepala-laporan-absensi">
            <i class="fa-solid fa-clipboard-check"></i>
            <span>Laporan Absensi</span>
          </a>
          <a class="sidebar__link" href="{{ route('kepalasekolah.evaluasi-pembelajaran') }}" data-nav="kepala-evaluasi-pembelajaran">
            <i class="fa-solid fa-chart-line"></i>
            <span>Evaluasi Pembelajaran</span>
          </a>
        </nav>
      </aside>

      <main class="layout__main">
        <header class="page-header">
          <h1>Laporan Absensi Umum</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <button class="btn" type="button">
              <i class="fa-solid fa-file-export" aria-hidden="true"></i>
              <span>Ekspor Data</span>
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

        <section aria-labelledby="ringkasan-absensi">
          <h2 id="ringkasan-absensi" class="section-title">Ringkasan Absensi</h2>
          <div class="stats-grid">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-users"></i> Total Kehadiran</p>
              <p class="card__value">{{ number_format($rataRataPresensi, 1) }}%</p>
              <small>Gabungan guru dan siswa</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-calendar-days"></i> Hari Aktif</p>
              <p class="card__value">{{ \Carbon\Carbon::now()->daysInMonth }}</p>
              <small>Bulan ini</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-chalkboard-user"></i> Guru Hadir</p>
              <p class="card__value">{{ number_format($guruHadirHariIni) }}/{{ number_format($totalGuru) }}</p>
              <small>Hari ini</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-graduate"></i> Siswa Hadir</p>
              <p class="card__value">{{ number_format($siswaHadirHariIni) }}/{{ number_format($totalSiswa) }}</p>
              <small>Hari ini</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="perbandingan-absensi">
          <h2 id="perbandingan-absensi" class="section-title">Perbandingan Absensi</h2>
          <div class="grid grid-2">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-chalkboard-user"></i> Absensi Guru</p>
              <p class="card__value">{{ $totalGuru > 0 ? number_format(($guruHadirHariIni / $totalGuru) * 100, 1) : 0 }}%</p>
              <p>{{ number_format($guruHadirHariIni) }} dari {{ number_format($totalGuru) }} guru hadir hari ini</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-graduate"></i> Absensi Siswa</p>
              <p class="card__value">{{ $totalSiswa > 0 ? number_format(($siswaHadirHariIni / $totalSiswa) * 100, 1) : 0 }}%</p>
              <p>{{ number_format($siswaHadirHariIni) }} dari {{ number_format($totalSiswa) }} siswa hadir hari ini</p>
            </article>
          </div>
        </section>

        <section aria-labelledby="rekap-harian">
          <h2 id="rekap-harian" class="section-title">Rekap Harian (Minggu Terakhir)</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Guru Hadir</th>
                  <th>Siswa Hadir</th>
                  <th>Total Kehadiran</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($rekapHarian as $rek)
                <tr>
                  <td>{{ $rek['tanggal']->translatedFormat('l, d M Y') }}</td>
                  <td>{{ number_format($rek['guru_hadir']) }}/{{ number_format($rek['total_guru']) }} ({{ $rek['total_guru'] > 0 ? number_format(($rek['guru_hadir'] / $rek['total_guru']) * 100, 1) : 0 }}%)</td>
                  <td>{{ number_format($rek['siswa_hadir']) }}/{{ number_format($rek['total_siswa']) }} ({{ $rek['total_siswa'] > 0 ? number_format(($rek['siswa_hadir'] / $rek['total_siswa']) * 100, 1) : 0 }}%)</td>
                  <td>{{ number_format($rek['persentase'], 1) }}%</td>
                  <td><span class="badge {{ $rek['status'] == 'Sempurna' ? 'status--hadir' : ($rek['status'] == 'Baik' ? 'status--hadir' : ($rek['status'] == 'Cukup' ? 'status--izin' : 'status--alpha')) }}">{{ $rek['status'] }}</span></td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" style="text-align: center; padding: 2rem;">
                    <p>Belum ada data presensi</p>
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

