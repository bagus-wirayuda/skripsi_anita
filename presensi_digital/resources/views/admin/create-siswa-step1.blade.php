<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Tambah Siswa</title>
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
          <h1>Tambah Siswa</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('admin.data-siswa') }}" class="btn">
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

        <section aria-labelledby="himbauan" style="max-width: 800px; margin: 2rem auto;">
          <div class="card" style="padding: 2rem; text-align: center;">
            <div style="font-size: 4rem; color: #007bff; margin-bottom: 1.5rem;">
              <i class="fa-solid fa-info-circle"></i>
            </div>
            <h2 style="margin-bottom: 1rem; color: #333;">Himbauan Pendaftaran</h2>
            <p style="color: #666; line-height: 1.6; margin-bottom: 2rem; font-size: 1.1rem;">
              Kami menyarankan agar orang tua/wali melakukan pendaftaran secara mandiri melalui halaman registrasi publik. 
              Hal ini memungkinkan orang tua untuk mengisi data mereka sendiri dan memastikan keakuratan informasi.
            </p>

            <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem; text-align: left;">
              <h3 style="margin-bottom: 1rem; color: #333; font-size: 1.1rem;">
                <i class="fa-solid fa-route" style="color: #007bff; margin-right: 0.5rem;"></i>
                Cara Pendaftaran Mandiri:
              </h3>
              <ol style="margin: 0; padding-left: 1.5rem; color: #555; line-height: 2;">
                <li>Orang tua mengakses halaman <strong>Register</strong> atau <strong>Pindahan</strong> di website publik</li>
                <li>Mengisi formulir pendaftaran dengan lengkap</li>
                <li>Admin akan meninjau dan menyetujui pendaftaran</li>
                <li>Setelah disetujui, akun orang tua akan aktif</li>
              </ol>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
              <a href="{{ route('admin.data-siswa') }}" class="btn btn--secondary" style="flex: 0 0 auto;">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
              </a>
              <a href="{{ route('register') }}" target="_blank" class="btn" style="flex: 0 0 auto; background: #28a745;">
                <i class="fa-solid fa-external-link-alt"></i>
                <span>Buka Halaman Register</span>
              </a>
              <a href="{{ route('admin.data-siswa.create.ortu') }}" class="btn" style="flex: 0 0 auto;">
                <i class="fa-solid fa-user-edit"></i>
                <span>Daftarkan Manual</span>
              </a>
            </div>

            <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
              <p style="color: #999; font-size: 0.875rem; margin: 0;">
                <i class="fa-solid fa-info-circle"></i>
                Jika memilih "Daftarkan Manual", Anda akan mengisi data orang tua dan siswa secara langsung.
              </p>
            </div>
          </div>
        </section>
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>

