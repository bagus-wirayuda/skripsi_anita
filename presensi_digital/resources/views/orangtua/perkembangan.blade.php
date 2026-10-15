<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Perkembangan Anak</title>
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
  <body data-page="orangtua-perkembangan">
    <div class="layout">
      <aside class="sidebar">
        <div class="sidebar__brand">
          <img src="{{ asset('assets/img/logo.png') }}" alt="Logo SDN 1 UNDUOLO" width="40" height="40" />
          <span>SDN 1 UNDUOLO</span>
        </div>
        <nav class="sidebar__nav">
          <a class="sidebar__link" href="{{ route('orangtua.dashboard') }}" data-nav="orangtua-dashboard">
            <i class="fa-solid fa-house-chimney"></i>
            <span>Dashboard</span>
          </a>
          <a class="sidebar__link" href="{{ route('orangtua.data-anak') }}" data-nav="orangtua-data-anak">
            <i class="fa-solid fa-child"></i>
            <span>Data Anak</span>
          </a>
          <a class="sidebar__link" href="{{ route('orangtua.penilaian-harian') }}" data-nav="orangtua-penilaian-harian">
            <i class="fa-solid fa-star-half-stroke"></i>
            <span>Penilaian Harian</span>
          </a>
          <a class="sidebar__link" href="{{ route('orangtua.perkembangan') }}" data-nav="orangtua-perkembangan">
            <i class="fa-solid fa-chart-simple"></i>
            <span>Perkembangan Anak</span>
          </a>
          <a class="sidebar__link" href="{{ route('orangtua.notes') }}" data-nav="orangtua-notes">
            <i class="fa-solid fa-envelope-open-text"></i>
            <span>Pesan Guru</span>
          </a>
        </nav>
      </aside>

      <main class="layout__main">
        <header class="page-header">
          <h1>Perkembangan Anak - {{ $anak->nama_siswa ?? 'Anak' }}</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            @if($anak)
            <a href="{{ route('orangtua.cetak-laporan', $anak->id) }}" class="btn" target="_blank">
              <i class="fa-solid fa-print" aria-hidden="true"></i>
              <span>Cetak Laporan</span>
            </a>
            @endif
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

        @if($anakList->isEmpty())
          <section aria-labelledby="empty-state">
            <div class="card" style="text-align: center; padding: 3rem;">
              <p style="font-size: 1.2rem; color: #666;">Belum ada data anak terdaftar</p>
            </div>
          </section>
        @else
          @if($anak)
          <section aria-labelledby="nilai-mapel">
            <h2 id="nilai-mapel" class="section-title">Nilai per Mata Pelajaran</h2>
            @if($nilaiPerMapel->isNotEmpty())
              <div class="grid grid-3">
                @foreach($nilaiPerMapel as $nilai)
                <article class="card progress-card">
                  <p class="card__title"><i class="fa-solid fa-book"></i> {{ $nilai->mapel->nama_mapel ?? '-' }}</p>
                  <p class="card__value">{{ number_format($nilai->nilai_akhir ?? 0, 1) }}</p>
                  <div class="progress-bar">
                    <span style="width: {{ min(100, ($nilai->nilai_akhir ?? 0)) }}%"></span>
                  </div>
                  <small>Predikat: {{ $nilai->predikat ?? '-' }}</small>
                </article>
                @endforeach
              </div>
            @else
              <div class="card" style="text-align: center; padding: 2rem;">
                <p style="color: #666;">Belum ada data nilai</p>
              </div>
            @endif
          </section>

          <section aria-labelledby="absensi-hari-ini">
            <h2 id="absensi-hari-ini" class="section-title">Absensi Hari Ini</h2>
            <div class="card">
              <div class="grid grid-3">
                <article class="card">
                  <p class="card__title"><i class="fa-solid fa-calendar-day"></i> Status Hari Ini</p>
                  <p class="card__value" style="font-size: 1.2rem;">
                    @if($presensiHariIni)
                      <span class="badge {{ $presensiHariIni->status_badge_class }}" style="padding: 8px 16px; font-size: 0.9rem;">{{ ucfirst($presensiHariIni->status) }}</span>
                    @else
                      <span class="badge status--alpha" style="padding: 8px 16px; font-size: 0.9rem;">Tidak Ada Data</span>
                    @endif
                  </p>
                  <small>{{ \Carbon\Carbon::now()->format('d F Y') }}</small>
                </article>
                <article class="card">
                  <p class="card__title"><i class="fa-solid fa-clock"></i> Waktu Masuk</p>
                  <p class="card__value" style="font-size: 1.4rem;">{{ $presensiHariIni->waktu_masuk_formatted ?? '-' }}</p>
                  <small>{{ $presensiHariIni ? 'Tercatat' : 'Tidak ada data' }}</small>
                </article>
                <article class="card">
                  <p class="card__title"><i class="fa-solid fa-info-circle"></i> Keterangan</p>
                  <p class="card__value" style="font-size: 1rem;">{{ $presensiHariIni->keterangan ?? '-' }}</p>
                </article>
              </div>
            </div>
          </section>

          <section aria-labelledby="statistik-absensi">
            <h2 id="statistik-absensi" class="section-title">Statistik Absensi Bulan Ini</h2>
            <div class="stats-grid">
              <article class="card">
                <p class="card__title"><i class="fa-solid fa-calendar-check"></i> Jumlah Kehadiran</p>
                <p class="card__value">{{ $totalHadir ?? 0 }}</p>
                <small>Dari {{ $totalPresensi ?? 0 }} hari belajar</small>
              </article>
              <article class="card">
                <p class="card__title"><i class="fa-solid fa-bed"></i> Sakit</p>
                <p class="card__value">{{ $totalSakit ?? 0 }}</p>
                <small>Hari tidak hadir karena sakit</small>
              </article>
              <article class="card">
                <p class="card__title"><i class="fa-solid fa-envelope-open-text"></i> Izin</p>
                <p class="card__value">{{ $totalIzin ?? 0 }}</p>
                <small>Hari dengan izin</small>
              </article>
              <article class="card">
                <p class="card__title"><i class="fa-solid fa-times-circle"></i> Alpa</p>
                <p class="card__value">{{ $totalAlpha ?? 0 }}</p>
                <small>Hari tidak hadir tanpa izin</small>
              </article>
            </div>
          </section>

          <section aria-labelledby="detail-absensi">
            <h2 id="detail-absensi" class="section-title">Detail Absensi Bulan Ini</h2>
            <div class="table-wrapper">
              <table>
                <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Waktu Masuk</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($presensiBulanIni ?? [] as $presensi)
                  <tr>
                    <td>{{ \Carbon\Carbon::parse($presensi->tanggal)->format('d M Y') }}</td>
                    <td><span class="badge {{ $presensi->status_badge_class }}">{{ ucfirst($presensi->status) }}</span></td>
                    <td>{{ $presensi->waktu_masuk_formatted ?? '-' }}</td>
                    <td>{{ $presensi->keterangan ?? '-' }}</td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="4" style="text-align: center; padding: 2rem;">
                      <p>Tidak ada data presensi bulan ini</p>
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </section>
          @else
          <section aria-labelledby="empty-state">
            <div class="card" style="text-align: center; padding: 3rem;">
              <p style="font-size: 1.2rem; color: #666;">Data anak tidak ditemukan</p>
            </div>
          </section>
          @endif
        @endif
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>
