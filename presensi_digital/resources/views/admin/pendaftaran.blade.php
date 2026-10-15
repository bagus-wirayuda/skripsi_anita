<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Pendaftaran</title>
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
  <body data-page="admin-pendaftaran">
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
          <a class="sidebar__link is-active" href="{{ route('admin.pendaftaran') }}" data-nav="admin-pendaftaran">
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
          <h1>Pendaftaran Orang Tua</h1>
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
        </header>

        @if (session('success'))
          <div class="alert alert--success" style="margin-bottom: 20px;">
            {{ session('success') }}
          </div>
        @endif

        @if (session('error'))
          <div class="alert alert--error" style="margin-bottom: 20px;">
            {{ session('error') }}
          </div>
        @endif

        <section aria-labelledby="pending-registrations">
          <h2 id="pending-registrations" class="section-title">Daftar Pendaftaran Tertunda</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Nama Lengkap</th>
                  <th>Email</th>
                  <th>NIK</th>
                  <th>Hubungan</th>
                  <th>No. HP</th>
                  <th>Alamat</th>
                  <th>Tanggal Daftar</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($pendaftaran as $reg)
                <tr>
                  <td>{{ $reg->name }}</td>
                  <td>{{ $reg->email }}</td>
                  <td>{{ $reg->nik ?? '-' }}</td>
                  <td>{{ $reg->hubungan }}</td>
                  <td>{{ $reg->no_hp }}</td>
                  <td>{{ $reg->alamat ?? '-' }}</td>
                  <td>{{ \Carbon\Carbon::parse($reg->created_at)->format('d M Y H:i') }}</td>
                  <td>
                    <div style="display: flex; gap: 8px;">
                      <a href="{{ route('admin.pendaftaran.approve-form', $reg->id) }}" class="btn btn--success btn--small">
                        <i class="fa-solid fa-check"></i> Setujui
                      </a>
                      <form action="{{ route('admin.pendaftaran.reject', $reg->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menolak pendaftaran ini?');">
                        @csrf
                        <button type="submit" class="btn btn--danger btn--small">
                          <i class="fa-solid fa-times"></i> Tolak
                        </button>
                      </form>
                      <form action="{{ route('admin.pendaftaran.delete', $reg->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pendaftaran ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn--warning btn--small">
                          <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="8" style="text-align: center; padding: 2rem;">
                    <p>Tidak ada pendaftaran orang tua yang tertunda.</p>
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

