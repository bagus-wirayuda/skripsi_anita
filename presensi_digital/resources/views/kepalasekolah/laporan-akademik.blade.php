<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Laporan Akademik</title>
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
  <body data-page="kepala-laporan-akademik">
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
          <a class="sidebar__link is-active" href="{{ route('kepalasekolah.laporan-akademik') }}" data-nav="kepala-laporan-akademik">
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
          <h1>Laporan Akademik</h1>
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

        <section aria-labelledby="statistik-akademik">
          <h2 id="statistik-akademik" class="section-title">Statistik Akademik</h2>
          <div class="stats-grid">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-trophy"></i> Rata-rata Nilai</p>
              <p class="card__value">{{ number_format($rataRataNilai, 1) }}</p>
              <small>Semua mata pelajaran</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-star"></i> Nilai Tertinggi</p>
              <p class="card__value">{{ number_format($nilaiTertinggi, 1) }}</p>
              <small>{{ $kelasTertinggi ? ($kelasTertinggi['kelas']->nama_kelas ?? '-') : '-' }}</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-users"></i> Siswa Tuntas</p>
              <p class="card__value">{{ number_format($siswaTuntas) }}</p>
              <small>Dari {{ number_format($totalSiswa) }} siswa ({{ number_format($persentaseTuntas, 1) }}%)</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-chart-line"></i> Persentase Tuntas</p>
              <p class="card__value">{{ number_format($persentaseTuntas, 1) }}%</p>
              <small>Nilai ≥ 75</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="rekap-nilai-kelas">
          <h2 id="rekap-nilai-kelas" class="section-title">Rekap Nilai per Kelas</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Kelas</th>
                  <th>Wali Kelas</th>
                  <th>Rata-rata Nilai</th>
                  <th>Siswa Tuntas</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($rekapKelas as $rek)
                <tr>
                  <td>{{ $rek['nama_kelas'] }}</td>
                  <td>{{ $rek['wali_kelas'] }}</td>
                  <td>{{ number_format($rek['rata_rata_nilai'], 1) }}</td>
                  <td>{{ number_format($rek['tuntas']) }}/{{ number_format($rek['total']) }} ({{ number_format($rek['persentase_tuntas'], 1) }}%)</td>
                  <td>
                    @php
                      $statusText = 'Sangat Baik';
                      if ($rek['rata_rata_nilai'] < 75 || $rek['persentase_tuntas'] < 80) {
                        $statusText = 'Monitoring';
                      } elseif ($rek['rata_rata_nilai'] < 80 || $rek['persentase_tuntas'] < 85) {
                        $statusText = 'Perlu Perhatian';
                      } elseif ($rek['rata_rata_nilai'] >= 85 && $rek['persentase_tuntas'] >= 90) {
                        $statusText = 'Sangat Baik';
                      } else {
                        $statusText = 'Baik';
                      }
                    @endphp
                    <span class="badge {{ $rek['status_badge'] }}">{{ $statusText }}</span>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" style="text-align: center; padding: 2rem;">
                    <p>Tidak ada data nilai ditemukan</p>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </section>

        <section aria-labelledby="mata-pelajaran">
          <h2 id="mata-pelajaran" class="section-title">Performa Mata Pelajaran</h2>
          <div class="grid grid-2">
            @forelse($performaMapel as $mapel)
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-book"></i> {{ $mapel['nama_mapel'] }}</p>
              <p>Rata-rata: {{ number_format($mapel['rata_rata'], 1) }} | Siswa tuntas: {{ number_format($mapel['persentase_tuntas'], 1) }}%</p>
              <small>{{ number_format($mapel['tuntas']) }}/{{ number_format($mapel['total']) }} siswa</small>
            </article>
            @empty
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-info-circle"></i> Belum Ada Data</p>
              <p>Tidak ada data nilai mata pelajaran ditemukan</p>
            </article>
            @endforelse
          </div>
        </section>
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>

