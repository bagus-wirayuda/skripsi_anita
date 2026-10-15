<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Data Siswa</title>
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
  <body data-page="admin-data-siswa">
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
          <a class="sidebar__link active" href="{{ route('admin.data-siswa') }}" data-nav="admin-data-siswa">
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
          <h1>Data Siswa</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('admin.data-siswa.create') }}" class="btn">
              <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
              <span>Tambah Siswa</span>
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

        <section aria-labelledby="filter-siswa">
          <h2 id="filter-siswa" class="section-title">Filter Data</h2>
          <form method="GET" action="{{ route('admin.data-siswa') }}">
            <div class="grid grid-3">
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-layer-group"></i> Kelas</span>
                <select name="kelas" class="input-inline" onchange="this.form.submit()">
                  <option value="Semua Kelas" {{ request('kelas') == 'Semua Kelas' || !request('kelas') ? 'selected' : '' }}>Semua Kelas</option>
                  @foreach($kelasList as $kelas)
                  <option value="{{ $kelas->nama_kelas }}" {{ request('kelas') == $kelas->nama_kelas ? 'selected' : '' }}>
                    {{ $kelas->nama_kelas }}
                  </option>
                  @endforeach
                </select>
              </label>
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-venus-mars"></i> Jenis Kelamin</span>
                <select name="jenis_kelamin" class="input-inline" onchange="this.form.submit()">
                  <option value="Semua" {{ request('jenis_kelamin') == 'Semua' || !request('jenis_kelamin') ? 'selected' : '' }}>Semua</option>
                  <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                  <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
              </label>
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-bolt"></i> Status</span>
                <select name="status" class="input-inline" onchange="this.form.submit()">
                  <option value="Aktif" {{ request('status') == 'Aktif' || !request('status') ? 'selected' : '' }}>Aktif</option>
                  <option value="Lulus" {{ request('status') == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                  <option value="Pindah" {{ request('status') == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                </select>
              </label>
            </div>
          </form>
        </section>

        <section aria-labelledby="tabel-siswa">
          <h2 id="tabel-siswa" class="section-title">Daftar Siswa Terdaftar</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>NIS</th>
                  <th>Nama Lengkap</th>
                  <th>Kelas</th>
                  <th>Jenis Kelamin</th>
                  <th>Orang Tua</th>
                  <th>Kontak Orang Tua</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($siswa as $s)
                <tr>
                  <td>{{ $s->nis ?? '-' }}</td>
                  <td>{{ $s->nama_siswa ?? '-' }}</td>
                  <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                  <td>{{ $s->jenis_kelamin_text }}</td>
                  <td>
                    @if($s->ortu && $s->ortu->user)
                      <a href="{{ route('admin.data-siswa.ortu', $s->ortu->id) }}" style="color: #007bff; text-decoration: none; font-weight: 500;">
                        <i class="fa-solid fa-user" style="margin-right: 0.25rem;"></i>
                        {{ $s->ortu->user->name }}
                      </a>
                    @else
                      <span style="color: #999;">-</span>
                    @endif
                  </td>
                  <td>{{ $s->ortu->no_hp ?? '-' }}</td>
                  <td>
                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                      <a href="{{ route('admin.data-siswa.show', $s->id) }}" class="btn btn--sm" style="background: #17a2b8; color: white; padding: 0.4rem 0.6rem; border-radius: 4px; text-decoration: none;" title="Detail">
                        <i class="fa-solid fa-eye"></i>
                      </a>
                      <a href="{{ route('admin.data-siswa.edit', $s->id) }}" class="btn btn--sm" style="background: #ffc107; color: white; padding: 0.4rem 0.6rem; border-radius: 4px; text-decoration: none;" title="Edit">
                        <i class="fa-solid fa-edit"></i>
                      </a>
                      <a href="{{ route('admin.data-siswa.delete', $s->id) }}" class="btn btn--sm" style="background: #dc3545; color: white; padding: 0.4rem 0.6rem; border-radius: 4px; text-decoration: none;" title="Hapus">
                        <i class="fa-solid fa-trash"></i>
                      </a>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" style="text-align: center; padding: 2rem;">
                    <p>Tidak ada data siswa ditemukan</p>
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

