<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Kelas Saya</title>
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
    <style>
      .jadwal-card {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
        border-left: 4px solid #c62828;
        transition: transform 0.2s, box-shadow 0.2s;
      }
      .jadwal-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      }
      .jadwal-card.terdekat {
        border-left-color: #4caf50;
        background: linear-gradient(135deg, #f5f9ff 0%, #ffffff 100%);
      }
      .jadwal-card__header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
      }
      .jadwal-card__hari {
        font-weight: 600;
        font-size: 1.1rem;
        color: #c62828;
      }
      .jadwal-card__waktu {
        font-size: 0.9rem;
        color: #666;
        background: #f5f5f5;
        padding: 0.25rem 0.75rem;
        border-radius: 4px;
      }
      .jadwal-card__mapel {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
      }
      .jadwal-card__kelas {
        font-size: 0.95rem;
        color: #666;
      }
      .jadwal-table {
        width: 100%;
        border-collapse: collapse;
        margin: 1rem 0;
      }
      .jadwal-table th,
      .jadwal-table td {
        padding: 0.75rem;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
      }
      .jadwal-table th {
        background-color: #f5f5f5;
        font-weight: 600;
      }
      .jadwal-table tr:hover {
        background-color: #f9f9f9;
      }
      .jadwal-item {
        padding: 0.75rem;
        margin: 0.5rem 0;
        background: #f5f9ff;
        border-left: 3px solid #c62828;
        border-radius: 4px;
      }
      .jadwal-item.today {
        background: #e8f5e9;
        border-left-color: #4caf50;
      }
      .jadwal-item__mapel {
        font-weight: 600;
        color: #c62828;
        margin-bottom: 0.25rem;
      }
      .jadwal-item__kelas {
        font-size: 0.875rem;
        color: #666;
      }
      .jadwal-item__waktu {
        font-size: 0.875rem;
        color: #999;
        margin-top: 0.25rem;
      }
      .badge-hari-ini {
        background: #4caf50;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-left: 0.5rem;
      }
    </style>
  </head>
  <body data-page="guru-kelas-saya">
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
          <a class="sidebar__link active" href="{{ route('guru.kelas-saya') }}" data-nav="guru-kelas-saya">
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
          <a class="sidebar__link" href="{{ route('guru.laporan') }}" data-nav="guru-laporan">
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
          <h1>Kelas Saya - Jadwal Mengajar</h1>
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

        <!-- Overview Statistics -->
        <section aria-labelledby="overview-stats">
          <h2 id="overview-stats" class="section-title">Ringkasan Jadwal</h2>
          <div class="stats-grid">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-book"></i> Total Mata Pelajaran</p>
              <p class="card__value">{{ number_format($totalMapel) }}</p>
              <small>Mata pelajaran yang Anda ajar</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-door-open"></i> Total Kelas</p>
              <p class="card__value">{{ number_format($totalKelas) }}</p>
              <small>Kelas yang Anda ajar</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-calendar-day"></i> Jadwal Hari Ini</p>
              <p class="card__value">{{ number_format($mapelHariIni) }}</p>
              <small>Mata pelajaran hari ini ({{ $hariIniId }})</small>
            </article>
          </div>
        </section>

        <!-- Jadwal Terdekat -->
        @if($jadwalTerdekat->count() > 0)
        <section aria-labelledby="jadwal-terdekat">
          <h2 id="jadwal-terdekat" class="section-title">Jadwal Terdekat</h2>
          <div class="grid grid-2">
            @foreach($jadwalTerdekat as $mapel)
            <article class="jadwal-card {{ $mapel->hari === $hariIniId ? 'terdekat' : '' }}">
              <div class="jadwal-card__header">
                <span class="jadwal-card__hari">
                  {{ $mapel->hari }}
                  @if($mapel->hari === $hariIniId)
                    <span class="badge-hari-ini">Hari Ini</span>
                  @endif
                </span>
                <span class="jadwal-card__waktu">
                  <i class="fa-solid fa-clock"></i>
                  {{ $mapel->jam_mulai ? \Carbon\Carbon::parse($mapel->jam_mulai)->format('H:i') : '-' }} - 
                  {{ $mapel->jam_selesai ? \Carbon\Carbon::parse($mapel->jam_selesai)->format('H:i') : '-' }}
                </span>
              </div>
              <div class="jadwal-card__mapel">
                <i class="fa-solid fa-book"></i> {{ $mapel->nama_mapel }}
              </div>
              <div class="jadwal-card__kelas">
                <i class="fa-solid fa-door-open"></i> {{ $mapel->kelas->nama_kelas ?? '-' }}
              </div>
            </article>
            @endforeach
          </div>
        </section>
        @else
        <section aria-labelledby="jadwal-terdekat">
          <div class="card" style="text-align: center; padding: 2rem;">
            <p><i class="fa-solid fa-info-circle"></i> Tidak ada jadwal terdekat</p>
          </div>
        </section>
        @endif

        <!-- Jadwal Mingguan -->
        <section aria-labelledby="jadwal-mingguan">
          <h2 id="jadwal-mingguan" class="section-title">Jadwal Mengajar Mingguan</h2>
          <div class="card">
            <table class="jadwal-table">
              <thead>
                <tr>
                  <th style="width: 15%;">Hari</th>
                  <th>Mata Pelajaran & Jadwal</th>
                </tr>
              </thead>
              <tbody>
                @foreach($jadwalMingguan as $jadwal)
                <tr>
                  <td style="font-weight: 600; vertical-align: top; padding-top: 1rem;">
                    {{ $jadwal['hari'] }}
                    @if($jadwal['isToday'])
                      <span class="badge-hari-ini">Hari Ini</span>
                    @endif
                  </td>
                  <td>
                    @if($jadwal['mapel']->count() > 0)
                      @foreach($jadwal['mapel'] as $mapel)
                      <div class="jadwal-item {{ $jadwal['isToday'] ? 'today' : '' }}">
                        <div class="jadwal-item__mapel">
                          <i class="fa-solid fa-book"></i> {{ $mapel->nama_mapel }}
                        </div>
                        <div class="jadwal-item__kelas">
                          <i class="fa-solid fa-door-open"></i> {{ $mapel->kelas->nama_kelas ?? '-' }}
                        </div>
                        <div class="jadwal-item__waktu">
                          <i class="fa-solid fa-clock"></i> 
                          {{ $mapel->jam_mulai ? \Carbon\Carbon::parse($mapel->jam_mulai)->format('H:i') : '-' }} - 
                          {{ $mapel->jam_selesai ? \Carbon\Carbon::parse($mapel->jam_selesai)->format('H:i') : '-' }}
                        </div>
                      </div>
                      @endforeach
                    @else
                      <p style="color: #999; font-style: italic;">Tidak ada jadwal</p>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </section>

        <!-- Daftar Mata Pelajaran -->
        <section aria-labelledby="daftar-mapel">
          <h2 id="daftar-mapel" class="section-title">Daftar Mata Pelajaran yang Saya Ajar</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Kode Mapel</th>
                  <th>Nama Mata Pelajaran</th>
                  <th>Kelas</th>
                  <th>Hari</th>
                  <th>Jam</th>
                </tr>
              </thead>
              <tbody>
                @forelse($mapelList as $mapel)
                <tr>
                  <td><strong>{{ $mapel->kode_mapel }}</strong></td>
                  <td>{{ $mapel->nama_mapel }}</td>
                  <td>{{ $mapel->kelas->nama_kelas ?? '-' }}</td>
                  <td>
                    @if($mapel->hari)
                      <span class="badge" style="background: {{ $mapel->hari === $hariIniId ? '#4caf50' : '#c62828' }}; color: white;">
                        {{ $mapel->hari }}
                      </span>
                    @else
                      <span style="color: #999;">-</span>
                    @endif
                  </td>
                  <td>
                    @if($mapel->jam_mulai && $mapel->jam_selesai)
                      {{ \Carbon\Carbon::parse($mapel->jam_mulai)->format('H:i') }} - 
                      {{ \Carbon\Carbon::parse($mapel->jam_selesai)->format('H:i') }}
                    @else
                      <span style="color: #999;">-</span>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" style="text-align: center; padding: 2rem;">
                    <p>Anda belum memiliki jadwal mengajar. Silakan hubungi administrator untuk menetapkan mata pelajaran.</p>
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


