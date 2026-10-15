<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Dashboard Guru</title>
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
  <body data-page="guru-dashboard">
    <div class="layout">
      <aside class="sidebar">
        <div class="sidebar__brand">
          <img src="{{ asset('assets/img/logo.png') }}" alt="Logo SDN 1 UNDUOLO" width="40" height="40" />
          <span>SDN 1 UNDUOLO</span>
        </div>
        <nav class="sidebar__nav">
          <a class="sidebar__link active" href="{{ route('guru.dashboard') }}" data-nav="guru-dashboard">
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
          <h1>Selamat Datang, {{ $guru->user->name ?? 'Guru' }}</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <button class="btn" type="button">
              <i class="fa-solid fa-bell" aria-hidden="true"></i>
              <span>Pengumuman</span>
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

        <section aria-labelledby="ringkasan-guru">
          <h2 id="ringkasan-guru" class="section-title">Ringkasan Kegiatan Hari Ini</h2>
          <div class="grid grid-3">
            @php
              $kelasArray = $kelasHariIni->toArray();
              $kelasCount = count($kelasArray);
            @endphp
            @if($kelasCount > 0)
              @foreach(array_slice($kelasArray, 0, 3) as $index => $kelas)
              <article class="card">
                <p class="card__title">
                  <i class="fa-solid fa-users-rectangle"></i> 
                  {{ $index === 0 ? 'Kelas Pagi' : ($index === 1 ? 'Kelas Siang' : 'Kelas Lainnya') }}
                </p>
                <p class="card__value">{{ $kelas['nama_kelas'] ?? '-' }} - {{ $kelas['nama_mapel'] ?? '-' }}</p>
                <small>{{ $kelas['jam_mulai'] ?? '-' }} - {{ $kelas['jam_selesai'] ?? '-' }}</small>
              </article>
              @endforeach
              @if($kelasCount < 3)
              <article class="card">
                <p class="card__title"><i class="fa-solid fa-calendar-check"></i> Agenda Khusus</p>
                <p class="card__value">Rapat Kurikulum</p>
                <small>15.00 - Ruang Guru</small>
              </article>
              @endif
            @else
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-info-circle"></i> Belum Ada Kelas</p>
              <p class="card__value">-</p>
              <small>Belum ada kelas yang ditugaskan</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-calendar-check"></i> Agenda Khusus</p>
              <p class="card__value">Rapat Kurikulum</p>
              <small>15.00 - Ruang Guru</small>
            </article>
            @endif
          </div>
        </section>

        <section aria-labelledby="catatan-kehadiran">
          <h2 id="catatan-kehadiran" class="section-title">Catatan Kehadiran Terbaru</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Nama Siswa</th>
                  <th>Kelas</th>
                  <th>Tanggal</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($presensiTerbaru as $p)
                <tr>
                  <td>{{ $p->siswa->nama_siswa ?? '-' }}</td>
                  <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                  <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                  <td><span class="badge {{ $p->status_badge_class }}">{{ ucfirst($p->status) }}</span></td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" style="text-align: center; padding: 2rem;">
                    <p>Tidak ada data presensi terbaru</p>
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


