<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Perwalian</title>
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
        padding: 0.5rem;
        margin: 0.25rem 0;
        background: #f5f9ff;
        border-left: 3px solid #c62828;
        border-radius: 4px;
      }
      .jadwal-item__mapel {
        font-weight: 600;
        color: #c62828;
      }
      .jadwal-item__guru {
        font-size: 0.875rem;
        color: #666;
      }
      .jadwal-item__waktu {
        font-size: 0.875rem;
        color: #999;
      }
    </style>
  </head>
  <body data-page="guru-perwalian">
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
          <a class="sidebar__link active" href="{{ route('guru.perwalian') }}" data-nav="guru-perwalian">
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
          <h1>Perwalian Kelas</h1>
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

        @if(!$kelasBinaan)
        <section aria-labelledby="no-kelas">
          <div class="card" style="text-align: center; padding: 3rem;">
            <p style="font-size: 1.2rem; margin-bottom: 1rem;">
              <i class="fa-solid fa-info-circle" style="color: #c62828;"></i>
            </p>
            <p style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem;">Belum Memiliki Kelas Perwalian</p>
            <p style="color: #666;">Anda belum ditugaskan sebagai wali kelas. Silakan hubungi administrator untuk menetapkan kelas perwalian.</p>
          </div>
        </section>
        @else
        <!-- Informasi Kelas -->
        <section aria-labelledby="info-kelas">
          <h2 id="info-kelas" class="section-title">Informasi Kelas Perwalian</h2>
          <div class="grid grid-3">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-door-open"></i> Nama Kelas</p>
              <p class="card__value">{{ $kelasBinaan->nama_kelas }}</p>
              <small>Tingkat: {{ $kelasBinaan->tingkat }}</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-graduate"></i> Jumlah Siswa</p>
              <p class="card__value">{{ $siswa->count() }}</p>
              <small>Total siswa di kelas ini</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-book"></i> Mata Pelajaran</p>
              <p class="card__value">{{ $jadwalMingguan->sum(function($item) { return $item['mapel']->count(); }) }}</p>
              <small>Total jadwal per minggu</small>
            </article>
          </div>
        </section>

        <!-- Jadwal Mata Pelajaran -->
        <section aria-labelledby="jadwal-mingguan">
          <h2 id="jadwal-mingguan" class="section-title">Jadwal Mata Pelajaran - {{ $kelasBinaan->nama_kelas }}</h2>
          <div class="card">
            <table class="jadwal-table">
              <thead>
                <tr>
                  <th style="width: 15%;">Hari</th>
                  <th>Mata Pelajaran</th>
                </tr>
              </thead>
              <tbody>
                @foreach($jadwalMingguan as $jadwal)
                <tr>
                  <td style="font-weight: 600; vertical-align: top; padding-top: 1rem;">{{ $jadwal['hari'] }}</td>
                  <td>
                    @if($jadwal['mapel']->count() > 0)
                      @foreach($jadwal['mapel'] as $mapel)
                      <div class="jadwal-item">
                        <div class="jadwal-item__mapel">
                          <i class="fa-solid fa-book"></i> {{ $mapel->nama_mapel }}
                        </div>
                        <div class="jadwal-item__guru">
                          <i class="fa-solid fa-chalkboard-teacher"></i> 
                          {{ $mapel->guru->user->name ?? '-' }}
                        </div>
                        <div class="jadwal-item__waktu">
                          <i class="fa-solid fa-clock"></i> 
                          {{ $mapel->jam_mulai ? \Carbon\Carbon::parse($mapel->jam_mulai)->format('H:i') : '-' }} - 
                          {{ $mapel->jam_selesai ? \Carbon\Carbon::parse($mapel->jam_selesai)->format('H:i') : '-' }}
                        </div>
                      </div>
                      @endforeach
                    @else
                      <p style="color: #999; font-style: italic;">Tidak ada mata pelajaran</p>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </section>

        <!-- Filter Data Siswa -->
        <section aria-labelledby="filter-siswa">
          <h2 id="filter-siswa" class="section-title">Filter Data Siswa</h2>
          <form method="GET" action="{{ route('guru.perwalian') }}">
            <div class="grid grid-3">
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-venus-mars"></i> Jenis Kelamin</span>
                <select name="jenis_kelamin" class="input-inline" onchange="this.form.submit()">
                  <option value="Semua" {{ $jenisKelaminFilter == 'Semua' || !$jenisKelaminFilter ? 'selected' : '' }}>Semua</option>
                  <option value="Laki-laki" {{ $jenisKelaminFilter == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                  <option value="Perempuan" {{ $jenisKelaminFilter == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
              </label>
            </div>
          </form>
        </section>

        <!-- Data Siswa -->
        <section aria-labelledby="tabel-siswa">
          <h2 id="tabel-siswa" class="section-title">Daftar Siswa - {{ $kelasBinaan->nama_kelas }}</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>NIS</th>
                  <th>Nama Lengkap</th>
                  <th>Jenis Kelamin</th>
                  <th>Orang Tua</th>
                  <th>Kontak Orang Tua</th>
                  <th>Alamat</th>
                </tr>
              </thead>
              <tbody>
                @forelse($siswa as $s)
                <tr>
                  <td>{{ $s->nis ?? '-' }}</td>
                  <td>{{ $s->nama_siswa ?? '-' }}</td>
                  <td>{{ $s->jenis_kelamin_text }}</td>
                  <td>
                    @if($s->ortu && $s->ortu->user)
                      <span style="font-weight: 500;">
                        <i class="fa-solid fa-user" style="margin-right: 0.25rem;"></i>
                        {{ $s->ortu->user->name }}
                      </span>
                    @else
                      <span style="color: #999;">-</span>
                    @endif
                  </td>
                  <td>
                    @if($s->ortu)
                      <span>{{ $s->ortu->no_hp ?? '-' }}</span>
                    @else
                      <span style="color: #999;">-</span>
                    @endif
                  </td>
                  <td>
                    <span style="word-wrap: break-word; max-width: 200px; display: inline-block;">
                      {{ $s->alamat ?? ($s->ortu->alamat ?? '-') }}
                    </span>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" style="text-align: center; padding: 2rem;">
                    <p>Tidak ada siswa ditemukan di kelas ini</p>
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

