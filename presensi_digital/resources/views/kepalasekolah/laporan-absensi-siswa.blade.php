<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Laporan Absensi Siswa</title>
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
  <body data-page="kepala-laporan-absensi-siswa">
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
          <a class="sidebar__link is-active" href="{{ route('kepalasekolah.laporan-absensi-siswa') }}" data-nav="kepala-laporan-absensi-siswa">
            <i class="fa-solid fa-user-graduate"></i>
            <span>Laporan Absensi Siswa</span>
          </a>
          <a class="sidebar__link" href="{{ route('kepalasekolah.laporan-absensi') }}" data-nav="kepala-laporan-absensi">
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
          <h1>Laporan Absensi Siswa</h1>
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

        <section aria-labelledby="statistik-absensi-siswa">
          <h2 id="statistik-absensi-siswa" class="section-title">Statistik Absensi Siswa</h2>
          <div class="stats-grid">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-calendar-check"></i> Rata-rata Kehadiran</p>
              <p class="card__value">{{ number_format($rataRataPresensi, 1) }}%</p>
              <small>Bulan ini</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-check"></i> Siswa Hadir</p>
              <p class="card__value">{{ number_format($totalHadir) }}</p>
              <small>Dari {{ number_format($totalSiswa) }} siswa</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-clock"></i> Izin</p>
              <p class="card__value">{{ number_format($totalIzin) }}</p>
              <small>Bulan ini</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-xmark"></i> Tidak Hadir</p>
              <p class="card__value">{{ number_format($totalAlpha) }}</p>
              <small>Bulan ini</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="rekap-absensi-kelas">
          <h2 id="rekap-absensi-kelas" class="section-title">Rekap Absensi per Kelas</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Kelas</th>
                  <th>Wali Kelas</th>
                  <th>Hadir</th>
                  <th>Izin</th>
                  <th>Tidak Hadir</th>
                  <th>Persentase</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($rekapKelas as $rek)
                <tr>
                  <td>{{ $rek['nama_kelas'] }}</td>
                  <td>{{ $rek['wali_kelas'] }}</td>
                  <td>{{ number_format($rek['hadir']) }}</td>
                  <td>{{ number_format($rek['izin']) }}</td>
                  <td>{{ number_format($rek['alpha']) }}</td>
                  <td>{{ number_format($rek['persentase'], 1) }}%</td>
                  <td>
                    @php
                      $statusText = 'Sangat Baik';
                      if ($rek['persentase'] < 75) {
                        $statusText = 'Monitoring';
                      } elseif ($rek['persentase'] < 85) {
                        $statusText = 'Perlu Perhatian';
                      } elseif ($rek['persentase'] < 95) {
                        $statusText = 'Baik';
                      }
                    @endphp
                    <span class="badge {{ $rek['status_badge'] }}">{{ $statusText }}</span>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7" style="text-align: center; padding: 2rem;">
                    <p>Tidak ada data absensi ditemukan</p>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </section>

        <section aria-labelledby="catatan-absensi-siswa">
          <h2 id="catatan-absensi-siswa" class="section-title">Catatan</h2>
          <div class="grid grid-2">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-exclamation-triangle"></i> Perhatian</p>
              <p>Kelas 4C dan 2B menunjukkan tingkat absensi yang perlu dipantau. Lakukan koordinasi dengan wali kelas dan orang tua.</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-lightbulb"></i> Rekomendasi</p>
              <p>Lakukan pendekatan personal untuk siswa dengan absensi tinggi dan libatkan orang tua dalam program peningkatan kehadiran.</p>
            </article>
          </div>
        </section>
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>

