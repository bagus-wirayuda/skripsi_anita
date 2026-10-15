<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Management Mapel</title>
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
          <h1>Management Mata Pelajaran</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('admin.mapel.create') }}" class="btn">
              <i class="fa-solid fa-plus" aria-hidden="true"></i>
              <span>Tambah Mapel</span>
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

        <section aria-labelledby="filter-mapel">
          <h2 id="filter-mapel" class="section-title">Filter Data</h2>
          <form method="GET" action="{{ route('admin.mapel.index') }}">
            <div class="grid grid-2">
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-layer-group"></i> Kelas</span>
                <select name="kelas" class="input-inline" onchange="this.form.submit()">
                  <option value="Semua Kelas" {{ request('kelas') == 'Semua Kelas' || !request('kelas') ? 'selected' : '' }}>Semua Kelas</option>
                  @foreach($kelasList as $kelas)
                  <option value="{{ $kelas->id }}" {{ request('kelas') == $kelas->id ? 'selected' : '' }}>
                    {{ $kelas->nama_kelas }}
                  </option>
                  @endforeach
                </select>
              </label>
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-person-chalkboard"></i> Guru</span>
                <select name="guru" class="input-inline" onchange="this.form.submit()">
                  <option value="Semua Guru" {{ request('guru') == 'Semua Guru' || !request('guru') ? 'selected' : '' }}>Semua Guru</option>
                  @foreach($guruList as $guru)
                  <option value="{{ $guru->id }}" {{ request('guru') == $guru->id ? 'selected' : '' }}>
                    {{ $guru->user->name ?? '-' }}
                  </option>
                  @endforeach
                </select>
              </label>
            </div>
          </form>
        </section>

        <section aria-labelledby="tabel-mapel">
          <h2 id="tabel-mapel" class="section-title">Daftar Mata Pelajaran</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Kode Mapel</th>
                  <th>Nama Mata Pelajaran</th>
                  <th>Kelas</th>
                  <th>Guru Pengajar</th>
                  <th>Jadwal</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($mapel as $m)
                <tr>
                  <td><strong>{{ $m->kode_mapel }}</strong></td>
                  <td>{{ $m->nama_mapel }}</td>
                  <td>{{ $m->kelas->nama_kelas ?? '-' }}</td>
                  <td>{{ $m->guru->user->name ?? '-' }}</td>
                  <td>
                    @if($m->hari && $m->jam_mulai && $m->jam_selesai)
                      {{ $m->hari }}, {{ date('H:i', strtotime($m->jam_mulai)) }} - {{ date('H:i', strtotime($m->jam_selesai)) }}
                    @else
                      <span style="color: #999;">Belum diatur</span>
                    @endif
                  </td>
                  <td>
                    <div style="display: flex; gap: 8px;">
                      <a href="{{ route('admin.mapel.show', $m->id) }}" class="btn btn--sm" title="Detail">
                        <i class="fa-solid fa-eye"></i>
                      </a>
                      <a href="{{ route('admin.mapel.edit', $m->id) }}" class="btn btn--sm" title="Edit">
                        <i class="fa-solid fa-pencil"></i>
                      </a>
                      <form action="{{ route('admin.mapel.destroy', $m->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?');">
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
                  <td colspan="6" style="text-align: center; padding: 2rem;">
                    <p>Tidak ada data mata pelajaran ditemukan. <a href="{{ route('admin.mapel.create') }}">Tambah mata pelajaran baru</a></p>
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

