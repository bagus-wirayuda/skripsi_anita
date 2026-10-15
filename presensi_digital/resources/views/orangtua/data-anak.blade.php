<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Data Anak</title>
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
  <body data-page="orangtua-data-anak">
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
          <h1>Data Anak - {{ $anak->nama_siswa ?? 'Anak' }}</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            @if($anak)
            <a href="{{ route('orangtua.cetak-kartu', $anak->id) }}" class="btn" target="_blank">
              <i class="fa-solid fa-id-card" aria-hidden="true"></i>
              <span>Cetak Kartu Siswa</span>
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
          <section aria-labelledby="info-umum">
            <h2 id="info-umum" class="section-title">Informasi Umum</h2>
            <div class="grid grid-2">
              <article class="card">
                <p class="card__title"><i class="fa-solid fa-user-graduate"></i> Identitas Siswa</p>
                <dl style="margin: 16px 0; display: grid; gap: 12px;">
                  <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                    <dt style="font-weight: 600; color: var(--accent-color);">Nama Lengkap</dt>
                    <dd>{{ $anak->nama_siswa ?? '-' }}</dd>
                  </div>
                  <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                    <dt style="font-weight: 600; color: var(--accent-color);">NIS</dt>
                    <dd>{{ $anak->nis ?? '-' }}</dd>
                  </div>
                  <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                    <dt style="font-weight: 600; color: var(--accent-color);">NISN</dt>
                    <dd>{{ $anak->nisn ?? '-' }}</dd>
                  </div>
                  <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                    <dt style="font-weight: 600; color: var(--accent-color);">Kelas</dt>
                    <dd>{{ $anak->kelas->nama_kelas ?? '-' }}</dd>
                  </div>
                  <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                    <dt style="font-weight: 600; color: var(--accent-color);">Tanggal Lahir</dt>
                    <dd>{{ $anak->tanggal_lahir ? \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d F Y') : '-' }}</dd>
                  </div>
                  <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                    <dt style="font-weight: 600; color: var(--accent-color);">Tempat Lahir</dt>
                    <dd>{{ $anak->tempat_lahir ?? '-' }}</dd>
                  </div>
                  <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                    <dt style="font-weight: 600; color: var(--accent-color);">Jenis Kelamin</dt>
                    <dd>{{ $anak->jenis_kelamin == 'L' ? 'Laki-laki' : ($anak->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</dd>
                  </div>
                </dl>
              </article>

              <article class="card">
                <p class="card__title"><i class="fa-solid fa-users"></i> Informasi Orang Tua</p>
                <dl style="margin: 16px 0; display: grid; gap: 12px;">
                  <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                    <dt style="font-weight: 600; color: var(--accent-color);">Nama</dt>
                    <dd>{{ $anak->ortu->user->name ?? '-' }}</dd>
                  </div>
                  <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                    <dt style="font-weight: 600; color: var(--accent-color);">Hubungan</dt>
                    <dd>{{ $anak->ortu->hubungan ?? '-' }}</dd>
                  </div>
                  <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                    <dt style="font-weight: 600; color: var(--accent-color);">No. HP</dt>
                    <dd>{{ $anak->ortu->no_hp ?? '-' }}</dd>
                  </div>
                  <div style="display: grid; grid-template-columns: 150px 1fr; gap: 12px;">
                    <dt style="font-weight: 600; color: var(--accent-color);">Alamat</dt>
                    <dd>{{ $anak->ortu->alamat ?? ($anak->alamat ?? '-') }}</dd>
                  </div>
                </dl>
              </article>
            </div>
          </section>

          <section aria-labelledby="akademik-info">
            <h2 id="akademik-info" class="section-title">Informasi Akademik</h2>
            <div class="grid grid-3">
              <article class="card">
                <p class="card__title"><i class="fa-solid fa-person-chalkboard"></i> Wali Kelas</p>
                <p class="card__value" style="font-size: 1.2rem;">{{ $anak->kelas->wali_kelas ?? '-' }}</p>
                <small>{{ $anak->kelas->nama_kelas ?? '-' }}</small>
              </article>
              <article class="card">
                <p class="card__title"><i class="fa-solid fa-book-open"></i> Mata Pelajaran</p>
                <p class="card__value" style="font-size: 1.2rem;">{{ $mapelList->count() }}</p>
                <small>Total mata pelajaran</small>
              </article>
            </div>
          </section>

          @if($mapelList->isNotEmpty())
          <section aria-labelledby="jadwal-kelas">
            <h2 id="jadwal-kelas" class="section-title">Mata Pelajaran</h2>
            <div class="table-wrapper">
              <table>
                <thead>
                  <tr>
                    <th>Mata Pelajaran</th>
                    <th>Guru</th>
                    <th>Jam/Minggu</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($mapelList as $mapel)
                  <tr>
                    <td>{{ $mapel->nama_mapel }}</td>
                    <td>{{ $mapel->guru->user->name ?? '-' }}</td>
                    <td>{{ $mapel->jam_per_minggu }} jam</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </section>
          @endif
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
