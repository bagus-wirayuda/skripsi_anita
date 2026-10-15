<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Pendaftaran Orang Tua</title>
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
  <body data-page="admin-pendaftaran-ortu">
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
          <h1>Pendaftaran Orang Tua / Wali</h1>
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

        @if (session('success'))
          <div class="alert alert-success" style="background: #efe; border: 1px solid #cfc; padding: 12px; border-radius: 8px; margin-bottom: 20px; color: #3c3;">
            {{ session('success') }}
          </div>
        @endif

        @if (session('error'))
          <div class="alert alert-error" style="background: #fee; border: 1px solid #fcc; padding: 12px; border-radius: 8px; margin-bottom: 20px; color: #c33;">
            {{ session('error') }}
          </div>
        @endif

        <section aria-labelledby="tabel-pendaftaran">
          <h2 id="tabel-pendaftaran" class="section-title">Daftar Pendaftaran Pending</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Nama</th>
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
                @forelse($pendaftaran as $p)
                <tr>
                  <td>{{ $p->name }}</td>
                  <td>{{ $p->email }}</td>
                  <td>{{ $p->nik ?? '-' }}</td>
                  <td>{{ $p->hubungan }}</td>
                  <td>{{ $p->no_hp ?? '-' }}</td>
                  <td>{{ Str::limit($p->alamat, 50) }}</td>
                  <td>{{ $p->created_at->format('d M Y') }}</td>
                  <td>
                    <div style="display: flex; gap: 8px;">
                      <form action="{{ route('admin.pendaftaran-ortu.approve', $p->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn" style="padding: 6px 12px; font-size: 0.875rem; background: #4caf50;" onclick="return confirm('Setujui pendaftaran ini?')">
                          <i class="fa-solid fa-check"></i> Setujui
                        </button>
                      </form>
                      <form action="{{ route('admin.pendaftaran-ortu.reject', $p->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn" style="padding: 6px 12px; font-size: 0.875rem; background: #f44336;" onclick="return confirm('Tolak pendaftaran ini? Data akan dihapus.')">
                          <i class="fa-solid fa-times"></i> Tolak
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="8" style="text-align: center; padding: 2rem;">
                    <p>Tidak ada pendaftaran pending</p>
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


