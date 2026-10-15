<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Data Guru</title>
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
  <body data-page="admin-data-guru">
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
          <a class="sidebar__link active" href="{{ route('admin.data-guru') }}" data-nav="admin-data-guru">
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
          <h1>Data Guru</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('admin.data-guru.create') }}" class="btn">
              <i class="fa-solid fa-user-tie" aria-hidden="true"></i>
              <span>Tambah Guru</span>
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

        @if(session('success'))
        <div class="alert alert-success" style="margin: 1rem 0; padding: 1rem; background: #d4edda; color: #155724; border-radius: 4px;">
          {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-error" style="margin: 1rem 0; padding: 1rem; background: #f8d7da; color: #721c24; border-radius: 4px;">
          {{ session('error') }}
        </div>
        @endif

        <section aria-labelledby="summary-guru">
          <h2 id="summary-guru" class="section-title">Ringkasan</h2>
          <div class="grid grid-3">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-users"></i> Total Guru</p>
              <p class="card__value">{{ number_format($totalGuru) }}</p>
              <small>Termasuk guru honorer aktif.</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-book-open"></i> Mapel Tercover</p>
              <p class="card__value">{{ number_format($totalMapel) }}</p>
              <small>Jumlah mata pelajaran yang sudah memiliki pengajar.</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-users-line"></i> Kelas Binaan</p>
              <p class="card__value">{{ number_format($totalKelasBinaan) }}</p>
              <small>Gabungan kelas yang dibimbing guru.</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="tabel-guru">
          <h2 id="tabel-guru" class="section-title">Daftar Guru</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>NIP</th>
                  <th>Nama</th>
                  <th>Mata Pelajaran</th>
                  <th>Kelas Binaan</th>
                  <th>Email</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($guru as $g)
                <tr>
                  <td>{{ $g->nip ?? '-' }}</td>
                  <td>{{ $g->user->name ?? '-' }}</td>
                  <td>
                    @php
                      $mapelList = $g->mapel->pluck('nama_mapel')->unique()->implode(', ');
                    @endphp
                    @if($mapelList)
                      {{ $mapelList }}
                    @else
                      <a href="{{ route('admin.mapel.index') }}" class="btn btn--sm" style="padding: 0.25rem 0.75rem; font-size: 0.875rem; text-decoration: none;">
                        <i class="fa-solid fa-plus"></i> Klik untuk mengisi
                      </a>
                    @endif
                  </td>
                  <td>
                    @php
                      $kelasBinaanList = $g->kelasBinaan->pluck('nama_kelas')->implode(', ');
                    @endphp
                    @if($kelasBinaanList)
                      {{ $kelasBinaanList }}
                    @else
                      <a href="{{ route('admin.kelas.index') }}" class="btn btn--sm" style="padding: 0.25rem 0.75rem; font-size: 0.875rem; text-decoration: none;">
                        <i class="fa-solid fa-plus"></i> Klik untuk mengisi
                      </a>
                    @endif
                  </td>
                  <td>{{ $g->user->email ?? '-' }}</td>
                  <td><span class="badge status--hadir">Aktif</span></td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" style="text-align: center; padding: 2rem;">
                    <p>Tidak ada data guru ditemukan</p>
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

