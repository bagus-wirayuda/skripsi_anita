<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Management Kelas</title>
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
          <h1>Management Kelas</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('admin.kelas.create') }}" class="btn">
              <i class="fa-solid fa-plus" aria-hidden="true"></i>
              <span>Tambah Kelas</span>
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

        <section aria-labelledby="tabel-kelas">
          <h2 id="tabel-kelas" class="section-title">Daftar Kelas</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Urutan</th>
                  <th>Nama Kelas</th>
                  <th>Tingkat</th>
                  <th>Rombel</th>
                  <th>Wali Kelas</th>
                  <th>Jumlah Siswa</th>
                  <th>Kapasitas</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($kelas as $k)
                <tr>
                  <td>{{ $k->urutan_kelas ?? '-' }}</td>
                  <td><strong>{{ $k->nama_kelas }}</strong></td>
                  <td>{{ $k->tingkat }}</td>
                  <td>{{ $k->rombel ?? '-' }}</td>
                  <td>
                    @if($k->waliKelas)
                      {{ $k->waliKelas->user->name ?? '-' }}
                      @if($k->wali_kelas)
                        <br><small style="color: #666;">{{ $k->wali_kelas }}</small>
                      @endif
                    @elseif($k->wali_kelas)
                      {{ $k->wali_kelas }}
                    @else
                      <span style="color: #999;">Belum ada</span>
                    @endif
                  </td>
                  <td>{{ $k->siswa->count() }}</td>
                  <td>{{ $k->kapasitas ?? 30 }}</td>
                  <td>
                    <div style="display: flex; gap: 8px;">
                      <a href="{{ route('admin.kelas.show', $k->id) }}" class="btn btn--sm" title="Detail">
                        <i class="fa-solid fa-eye"></i>
                      </a>
                      <a href="{{ route('admin.kelas.edit', $k->id) }}" class="btn btn--sm" title="Edit">
                        <i class="fa-solid fa-pencil"></i>
                      </a>
                      <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn--sm btn--danger" title="Hapus">
                          <i class="fa-solid fa-trash"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="8" style="text-align: center; padding: 2rem;">
                    <p>Tidak ada data kelas ditemukan. <a href="{{ route('admin.kelas.create') }}">Tambah kelas baru</a></p>
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

