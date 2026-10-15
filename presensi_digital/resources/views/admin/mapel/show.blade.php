<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Detail Mata Pelajaran</title>
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
  <body data-page="admin-mapel">
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
          <a class="sidebar__link" href="{{ route('admin.kelas.index') }}" data-nav="admin-kelas">
            <i class="fa-solid fa-door-open"></i>
            <span>Kelas</span>
          </a>
          <a class="sidebar__link active" href="{{ route('admin.mapel.index') }}" data-nav="admin-mapel">
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
          <h1>Detail Mata Pelajaran: {{ $mapel->nama_mapel }}</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('admin.mapel.edit', $mapel->id) }}" class="btn">
              <i class="fa-solid fa-pencil" aria-hidden="true"></i>
              <span>Edit</span>
            </a>
            <a href="{{ route('admin.mapel.index') }}" class="btn btn--secondary">
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

        <section aria-labelledby="detail-mapel">
          <h2 id="detail-mapel" class="section-title">Informasi Mata Pelajaran</h2>
          <div class="grid grid-2">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-book"></i> Nama Mata Pelajaran</p>
              <p class="card__value">{{ $mapel->nama_mapel }}</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-hashtag"></i> Kode Mapel</p>
              <p class="card__value">{{ $mapel->kode_mapel }}</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-door-open"></i> Kelas</p>
              <p class="card__value">{{ $mapel->kelas->nama_kelas ?? '-' }}</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-person-chalkboard"></i> Guru Pengajar</p>
              <p class="card__value">{{ $mapel->guru->user->name ?? '-' }}</p>
            </article>
          </div>
          <div class="grid grid-3" style="margin-top: 1rem;">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-calendar-day"></i> Hari</p>
              <p class="card__value">{{ $mapel->hari ?? '-' }}</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-clock"></i> Jam Mulai</p>
              <p class="card__value">{{ $mapel->jam_mulai ? date('H:i', strtotime($mapel->jam_mulai)) : '-' }}</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-clock"></i> Jam Selesai</p>
              <p class="card__value">{{ $mapel->jam_selesai ? date('H:i', strtotime($mapel->jam_selesai)) : '-' }}</p>
            </article>
          </div>
          @if($mapel->deskripsi)
          <article class="card" style="margin-top: 1rem;">
            <p class="card__title"><i class="fa-solid fa-file-lines"></i> Deskripsi</p>
            <p>{{ $mapel->deskripsi }}</p>
          </article>
          @endif
        </section>
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>

