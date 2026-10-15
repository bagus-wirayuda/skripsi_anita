<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Konfirmasi Hapus Siswa</title>
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
          <h1>Konfirmasi Hapus Siswa</h1>
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

        <div style="max-width: 800px; margin: 2rem auto;">
          <div class="card" style="border-left: 4px solid #dc3545; background: #fff5f5;">
            <div style="text-align: center; margin-bottom: 2rem;">
              <div style="font-size: 4rem; color: #dc3545; margin-bottom: 1rem;">
                <i class="fa-solid fa-exclamation-triangle"></i>
              </div>
              <h2 style="color: #dc3545; margin-bottom: 0.5rem;">Peringatan!</h2>
              <p style="color: #666; font-size: 1.1rem;">
                Anda akan menghapus data siswa berikut beserta seluruh data terkait.
              </p>
            </div>

            <section aria-labelledby="info-siswa" style="margin-bottom: 2rem;">
              <h3 id="info-siswa" style="margin-bottom: 1rem; color: #333; font-size: 1.1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e9ecef;">
                <i class="fa-solid fa-user-graduate" style="margin-right: 0.5rem; color: #007bff;"></i>
                Informasi Siswa yang Akan Dihapus
              </h3>
              <div class="grid grid-2" style="gap: 1rem;">
                <div>
                  <strong style="color: #555;">Nama Lengkap:</strong>
                  <p style="margin: 0.25rem 0; color: #333; word-wrap: break-word;">{{ $siswa->nama_siswa }}</p>
                </div>
                <div>
                  <strong style="color: #555;">NIS:</strong>
                  <p style="margin: 0.25rem 0; color: #333;">{{ $siswa->nis ?? '-' }}</p>
                </div>
                <div>
                  <strong style="color: #555;">NISN:</strong>
                  <p style="margin: 0.25rem 0; color: #333;">{{ $siswa->nisn ?? '-' }}</p>
                </div>
                <div>
                  <strong style="color: #555;">Kelas:</strong>
                  <p style="margin: 0.25rem 0; color: #333;">{{ $siswa->kelas->nama_kelas ?? '-' }}</p>
                </div>
              </div>
            </section>

            <section aria-labelledby="data-terhapus" style="margin-bottom: 2rem;">
              <h3 id="data-terhapus" style="margin-bottom: 1rem; color: #333; font-size: 1.1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e9ecef;">
                <i class="fa-solid fa-trash" style="margin-right: 0.5rem; color: #dc3545;"></i>
                Data yang Akan Dihapus
              </h3>
              <div style="background: #fff; padding: 1rem; border-radius: 4px; border: 1px solid #ddd;">
                <ul style="margin: 0; padding-left: 1.5rem; color: #555;">
                  <li style="margin-bottom: 0.5rem;">
                    <strong>Data Siswa:</strong> {{ $siswa->nama_siswa }}
                  </li>
                  <li style="margin-bottom: 0.5rem;">
                    <strong>Presensi:</strong> {{ $siswa->presensi->count() }} record
                  </li>
                  <li style="margin-bottom: 0.5rem;">
                    <strong>Nilai:</strong> {{ $siswa->nilai->count() }} record
                  </li>
                  <li style="margin-bottom: 0.5rem;">
                    <strong>Penilaian Harian:</strong> {{ $siswa->penilaianHarian->count() }} record
                  </li>
                </ul>
              </div>
            </section>

            <section aria-labelledby="data-tersimpan" style="margin-bottom: 2rem;">
              <h3 id="data-tersimpan" style="margin-bottom: 1rem; color: #333; font-size: 1.1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e9ecef;">
                <i class="fa-solid fa-shield-check" style="margin-right: 0.5rem; color: #28a745;"></i>
                Data yang TIDAK Akan Dihapus
              </h3>
              <div style="background: #f0f9ff; padding: 1rem; border-radius: 4px; border: 1px solid #b3e5fc;">
                <ul style="margin: 0; padding-left: 1.5rem; color: #555;">
                  <li style="margin-bottom: 0.5rem;">
                    <strong>Data Orang Tua:</strong> 
                    @if($siswa->ortu && $siswa->ortu->user)
                      {{ $siswa->ortu->user->name }} (Data orang tua akan tetap tersimpan)
                    @else
                      Tidak ada data orang tua
                    @endif
                  </li>
                </ul>
              </div>
            </section>

            <div style="background: #fff3cd; border: 1px solid #ffc107; padding: 1rem; border-radius: 4px; margin-bottom: 2rem;">
              <p style="margin: 0; color: #856404; display: flex; align-items: start; gap: 0.5rem;">
                <i class="fa-solid fa-info-circle" style="margin-top: 0.2rem;"></i>
                <span>
                  <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan. Setelah menghapus, semua data terkait siswa akan hilang secara permanen. Pastikan Anda benar-benar yakin sebelum melanjutkan.
                </span>
              </p>
            </div>

            <form action="{{ route('admin.data-siswa.destroy', $siswa->id) }}" method="POST" style="display: flex; gap: 1rem; justify-content: center;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn" style="background: #dc3545; color: white; padding: 0.75rem 2rem; font-size: 1rem;">
                <i class="fa-solid fa-trash"></i>
                <span>Ya, Hapus Siswa</span>
              </button>
              <a href="{{ route('admin.data-siswa') }}" class="btn btn--secondary" style="padding: 0.75rem 2rem; font-size: 1rem;">
                <span>Batal</span>
              </a>
            </form>
          </div>
        </div>
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>

