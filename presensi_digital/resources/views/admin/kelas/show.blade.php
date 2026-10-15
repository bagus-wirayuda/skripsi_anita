<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Detail Kelas</title>
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
  <body data-page="admin-kelas">
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
          <a class="sidebar__link active" href="{{ route('admin.kelas.index') }}" data-nav="admin-kelas">
            <i class="fa-solid fa-door-open"></i>
            <span>Kelas</span>
          </a>
          <a class="sidebar__link" href="{{ route('admin.mapel.index') }}" data-nav="admin-mapel">
            <i class="fa-solid fa-book"></i>
            <span>Mapel</span>
          </a>
          <a class="sidebar__link" href="{{ route('admin.data-nilai') }}" data-nav="admin-data-nilai">
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
          <h1>Detail Kelas: {{ $kelas->nama_kelas }}</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('admin.kelas.edit', $kelas->id) }}" class="btn">
              <i class="fa-solid fa-pencil" aria-hidden="true"></i>
              <span>Edit</span>
            </a>
            <a href="{{ route('admin.kelas.index') }}" class="btn btn--secondary">
              <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
              <span>Kembali</span>
            </a>
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

        <section aria-labelledby="detail-kelas">
          <h2 id="detail-kelas" class="section-title">Informasi Kelas</h2>
          <div class="grid grid-2">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-door-open"></i> Nama Kelas</p>
              <p class="card__value">{{ $kelas->nama_kelas }}</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-layer-group"></i> Tingkat</p>
              <p class="card__value">{{ $kelas->tingkat }}</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-sort-numeric-up"></i> Urutan Kelas</p>
              <p class="card__value">{{ $kelas->urutan_kelas ?? '-' }}</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-font"></i> Rombel</p>
              <p class="card__value">{{ $kelas->rombel ?? '-' }}</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-person-chalkboard"></i> Wali Kelas</p>
              <p class="card__value">
                @if($kelas->waliKelas)
                  {{ $kelas->waliKelas->user->name ?? '-' }}
                  @if($kelas->wali_kelas)
                    <br><small style="color: #666;">{{ $kelas->wali_kelas }}</small>
                  @endif
                @elseif($kelas->wali_kelas)
                  {{ $kelas->wali_kelas }}
                @else
                  <span style="color: #999;">Belum ada</span>
                @endif
              </p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-users"></i> Kapasitas</p>
              <p class="card__value">{{ $kelas->kapasitas ?? 30 }} siswa</p>
            </article>
          </div>
          @if($kelas->deskripsi || $kelas->catatan)
          <div class="grid grid-2" style="margin-top: 1rem;">
            @if($kelas->deskripsi)
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-file-lines"></i> Deskripsi</p>
              <p>{{ $kelas->deskripsi }}</p>
            </article>
            @endif
            @if($kelas->catatan)
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-sticky-note"></i> Catatan</p>
              <p>{{ $kelas->catatan }}</p>
            </article>
            @endif
          </div>
          @endif
        </section>

        <section aria-labelledby="siswa-kelas">
          <h2 id="siswa-kelas" class="section-title">Siswa di Kelas ini ({{ $kelas->siswa->count() }})</h2>
          @if($kelas->siswa->count() > 0)
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>NIS</th>
                  <th>Nama Siswa</th>
                  <th>Jenis Kelamin</th>
                </tr>
              </thead>
              <tbody>
                @foreach($kelas->siswa as $siswa)
                <tr>
                  <td>{{ $siswa->nis ?? '-' }}</td>
                  <td>{{ $siswa->nama_siswa }}</td>
                  <td>{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @else
          <p style="padding: 1rem; background: #f8f9fa; border-radius: 4px;">Belum ada siswa di kelas ini.</p>
          @endif
        </section>

        <section aria-labelledby="mapel-kelas">
          <h2 id="mapel-kelas" class="section-title">Mata Pelajaran di Kelas ini ({{ $kelas->mapel->count() }})</h2>
          @if($kelas->mapel->count() > 0)
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Kode Mapel</th>
                  <th>Nama Mata Pelajaran</th>
                  <th>Guru Pengajar</th>
                  <th>Jam/Minggu</th>
                </tr>
              </thead>
              <tbody>
                @foreach($kelas->mapel as $mapel)
                <tr>
                  <td><strong>{{ $mapel->kode_mapel }}</strong></td>
                  <td>{{ $mapel->nama_mapel }}</td>
                  <td>{{ $mapel->guru->user->name ?? '-' }}</td>
                  <td>{{ $mapel->jam_per_minggu ?? 2 }} jam</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @else
          <p style="padding: 1rem; background: #f8f9fa; border-radius: 4px;">Belum ada mata pelajaran di kelas ini. <a href="{{ route('admin.mapel.create') }}">Tambah mata pelajaran</a></p>
          @endif
        </section>
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>

