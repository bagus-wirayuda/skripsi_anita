<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Dashboard Orang Tua</title>
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
  <body data-page="orangtua-dashboard">
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
          <h1>Halo, {{ $ortu->user->name ?? 'Orang Tua' }}</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
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
          <section aria-labelledby="ringkasan-anak">
            <h2 id="ringkasan-anak" class="section-title">Ringkasan Anak Anda</h2>
            <div class="grid grid-3">
              <article class="card">
                <p class="card__title"><i class="fa-solid fa-calendar-check"></i> Kehadiran Bulan Ini</p>
                <p class="card__value">{{ $persentaseKehadiran }}%</p>
                <small>{{ $totalHadir ?? 0 }} dari {{ $totalPresensi ?? 0 }} hari hadir</small>
              </article>
              <article class="card">
                <p class="card__title"><i class="fa-solid fa-award"></i> Rata-rata Nilai</p>
                <p class="card__value">{{ $rataRataNilai ?? 0 }}</p>
                <small>Nilai rata-rata semua mata pelajaran</small>
              </article>
              <article class="card">
                <p class="card__title"><i class="fa-solid fa-child"></i> Jumlah Anak</p>
                <p class="card__value">{{ $anakList->count() }}</p>
                <small>Anak yang terdaftar</small>
              </article>
            </div>
          </section>

          <section aria-labelledby="riwayat-presensi">
            <h2 id="riwayat-presensi" class="section-title">Riwayat Presensi Minggu Ini</h2>
            <div class="table-wrapper">
              <table>
                <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($presensiMingguIni ?? [] as $presensi)
                  <tr>
                    <td>{{ \Carbon\Carbon::parse($presensi->tanggal)->format('d M Y') }}</td>
                    <td><span class="badge {{ $presensi->status_badge_class }}">{{ ucfirst($presensi->status) }}</span></td>
                    <td>{{ $presensi->keterangan ?? '-' }}</td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="3" style="text-align: center; padding: 2rem;">
                      <p>Tidak ada data presensi minggu ini</p>
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </section>
        @endif
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>
