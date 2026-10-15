<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Dashboard Kepala Sekolah</title>
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
  <body data-page="kepala-dashboard">
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
          <h1>Ikhtisar Sekolah</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <button class="btn" type="button">
              <i class="fa-solid fa-share-nodes" aria-hidden="true"></i>
              <span>Bagikan Insight</span>
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

        <section aria-labelledby="statistik-global">
          <h2 id="statistik-global" class="section-title">Statistik Global</h2>
          <div class="stats-grid">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-graduate"></i> Total Siswa</p>
              <p class="card__value">{{ number_format($totalSiswa) }}</p>
              <small>Seluruh jenjang kelas 1 - 6</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-person-chalkboard"></i> Total Guru</p>
              <p class="card__value">{{ number_format($totalGuru) }}</p>
              <small>Pengajar aktif dan tenaga pendamping</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-calendar-check"></i> Presensi Rata-rata</p>
              <p class="card__value">{{ number_format($rataRataPresensi, 1) }}%</p>
              <small>Akumulasi semester berjalan</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-trophy"></i> Rata-rata Nilai</p>
              <p class="card__value">{{ number_format($rataRataNilai, 1) }}</p>
              <small>Gabungan seluruh mata pelajaran</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="highlight-laporan">
          <h2 id="highlight-laporan" class="section-title">Sorotan Laporan Terbaru</h2>
          <div class="grid grid-2">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-school-flag"></i> Program Literasi</p>
              <p>Partisipasi siswa mencapai 92%, perlu tindak lanjut pada kelas 2B dan 3A.</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-person-circle-check"></i> Kehadiran Guru</p>
              <p>Kehadiran guru stabil di 98%. Lakukan monitoring rutin setiap awal pekan.</p>
            </article>
          </div>
        </section>
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>


