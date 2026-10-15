<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Data User</title>
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
  <body data-page="admin-data-user">
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
          <a class="sidebar__link" href="{{ route('admin.mapel.index') }}" data-nav="admin-mapel">
            <i class="fa-solid fa-book"></i>
            <span>Mapel</span>
          </a>
          <a class="sidebar__link" href="{{ route('admin.data-nilai') }}" data-nav="admin-data-nilai">
            <i class="fa-solid fa-chart-column"></i>
            <span>Nilai</span>
          </a>
          <a class="sidebar__link active" href="{{ route('admin.data-user') }}" data-nav="admin-data-user">
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
          <h1>Manajemen Pengguna</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <button class="btn" type="button">
              <i class="fa-solid fa-user-gear" aria-hidden="true"></i>
              <span>Tambah User</span>
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

        <section aria-labelledby="ringkasan-user">
          <h2 id="ringkasan-user" class="section-title">Ringkasan Hak Akses</h2>
          <div class="grid grid-3">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-user-shield"></i> Administrator</p>
              <p class="card__value">{{ number_format($countAdmin) }}</p>
              <small>Mengelola seluruh modul sistem.</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-chalkboard-teacher"></i> Guru</p>
              <p class="card__value">{{ number_format($countGuru) }}</p>
              <small>Akses penilaian dan presensi kelas masing-masing.</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-people-roof"></i> Orang Tua</p>
              <p class="card__value">{{ number_format($countOrtu) }}</p>
              <small>Mengamati perkembangan dan presensi anak.</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="tabel-user">
          <h2 id="tabel-user" class="section-title">Daftar Pengguna Aktif</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Peran</th>
                  <th>Status</th>
                  <th>Terakhir Login</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($users as $user)
                <tr>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>
                    @php
                      $roleBadgeClass = 'status--hadir';
                      $roleText = ucfirst($user->role ?? 'User');
                      // Map role to badge class and text
                      $roleMap = [
                        'admin' => ['status--hadir', 'Administrator'],
                        'kepsek' => ['status--hadir', 'Kepala Sekolah'],
                        'guru' => ['status--hadir', 'Guru'],
                        'ortu' => ['status--izin', 'Orang Tua'],
                      ];
                      if (isset($roleMap[$user->role])) {
                        $roleBadgeClass = $roleMap[$user->role][0];
                        $roleText = $roleMap[$user->role][1];
                      }
                    @endphp
                    <span class="badge {{ $roleBadgeClass }}">{{ $roleText }}</span>
                  </td>
                  <td>
                    @php
                      $isActive = $user->updated_at && \Carbon\Carbon::parse($user->updated_at)->isAfter(\Carbon\Carbon::now()->subDays(30));
                    @endphp
                    <span class="badge {{ $isActive ? 'status--hadir' : 'status--alpha' }}">{{ $isActive ? 'Aktif' : 'Tidak Aktif' }}</span>
                  </td>
                  <td>{{ $user->updated_at ? \Carbon\Carbon::parse($user->updated_at)->format('d M Y H:i') : '-' }}</td>
                  <td>
                    <button class="btn" type="button" onclick="alert('Fitur reset password akan dikembangkan lebih lanjut.')">Reset</button>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" style="text-align: center; padding: 2rem;">
                    <p>Tidak ada data user ditemukan</p>
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
