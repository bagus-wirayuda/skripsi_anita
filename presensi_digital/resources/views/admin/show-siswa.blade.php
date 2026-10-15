<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Detail Siswa</title>
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
    <style>
      .card {
        overflow: hidden;
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
      }
      
      .card__value {
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
        max-width: 100%;
        line-height: 1.5;
      }
    </style>
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
          <h1 style="word-wrap: break-word; word-break: break-word; overflow-wrap: break-word; max-width: 100%;">Detail Siswa: {{ $siswa->nama_siswa }}</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('admin.data-siswa') }}" class="btn">
              <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
              <span>Kembali</span>
            </a>
            <a href="{{ route('admin.data-siswa.edit', $siswa->id) }}" class="btn" style="background: #ffc107; color: white;">
              <i class="fa-solid fa-edit" aria-hidden="true"></i>
              <span>Edit</span>
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

        <section aria-labelledby="detail-siswa">
          <h2 id="detail-siswa" class="section-title">Informasi Siswa</h2>
          <div class="grid grid-2">
            <article class="card" style="overflow: hidden;">
              <p class="card__title"><i class="fa-solid fa-user-graduate"></i> Nama Lengkap</p>
              <p class="card__value" style="word-wrap: break-word; word-break: break-word; overflow-wrap: break-word; max-width: 100%; font-size: 0.95rem; line-height: 1.5;">{{ $siswa->nama_siswa ?? '-' }}</p>
            </article>
            <article class="card" style="overflow: hidden;">
              <p class="card__title"><i class="fa-solid fa-id-card"></i> NIS</p>
              <p class="card__value" style="word-wrap: break-word; overflow-wrap: break-word; max-width: 100%; font-size: 0.95rem;">{{ $siswa->nis ?? '-' }}</p>
            </article>
            <article class="card" style="overflow: hidden;">
              <p class="card__title"><i class="fa-solid fa-id-card"></i> NISN</p>
              <p class="card__value" style="word-wrap: break-word; overflow-wrap: break-word; max-width: 100%; font-size: 0.95rem;">{{ $siswa->nisn ?? '-' }}</p>
            </article>
            <article class="card" style="overflow: hidden;">
              <p class="card__title"><i class="fa-solid fa-school"></i> Kelas</p>
              <p class="card__value" style="word-wrap: break-word; overflow-wrap: break-word; max-width: 100%; font-size: 0.95rem;">{{ $siswa->kelas->nama_kelas ?? '-' }}</p>
            </article>
            <article class="card" style="overflow: hidden;">
              <p class="card__title"><i class="fa-solid fa-venus-mars"></i> Jenis Kelamin</p>
              <p class="card__value" style="word-wrap: break-word; overflow-wrap: break-word; max-width: 100%; font-size: 0.95rem;">{{ $siswa->jenis_kelamin_text }}</p>
            </article>
            <article class="card" style="overflow: hidden;">
              <p class="card__title"><i class="fa-solid fa-calendar"></i> Tanggal Lahir</p>
              <p class="card__value" style="word-wrap: break-word; overflow-wrap: break-word; max-width: 100%; font-size: 0.95rem;">{{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') : '-' }}</p>
            </article>
            <article class="card" style="overflow: hidden;">
              <p class="card__title"><i class="fa-solid fa-map-marker-alt"></i> Tempat Lahir</p>
              <p class="card__value" style="word-wrap: break-word; overflow-wrap: break-word; max-width: 100%; font-size: 0.95rem;">{{ $siswa->tempat_lahir ?? '-' }}</p>
            </article>
            <article class="card" style="overflow: hidden;">
              <p class="card__title"><i class="fa-solid fa-qrcode"></i> QR Code</p>
              <p class="card__value" style="word-wrap: break-word; overflow-wrap: break-word; max-width: 100%; font-size: 0.85rem; font-family: monospace;">{{ $siswa->qr_code ?? '-' }}</p>
            </article>
          </div>
          @if($siswa->alamat)
          <article class="card" style="margin-top: 1rem; overflow: hidden;">
            <p class="card__title"><i class="fa-solid fa-location-dot"></i> Alamat</p>
            <p style="margin: 0; color: #555; word-wrap: break-word; word-break: break-word; overflow-wrap: break-word; max-width: 100%; line-height: 1.6; white-space: pre-wrap;">{{ $siswa->alamat }}</p>
          </article>
          @endif
        </section>

        <section aria-labelledby="ortu-siswa">
          <h2 id="ortu-siswa" class="section-title">Informasi Orang Tua</h2>
          @if($siswa->ortu && $siswa->ortu->user)
          <div class="grid grid-2">
            <article class="card" style="overflow: hidden;">
              <p class="card__title"><i class="fa-solid fa-user"></i> Nama Orang Tua</p>
              <p class="card__value" style="word-wrap: break-word; word-break: break-word; overflow-wrap: break-word; max-width: 100%; font-size: 0.95rem; line-height: 1.5;">
                <a href="{{ route('admin.data-siswa.ortu', $siswa->ortu->id) }}" style="color: #007bff; text-decoration: none;">
                  {{ $siswa->ortu->user->name }}
                </a>
              </p>
            </article>
            <article class="card" style="overflow: hidden;">
              <p class="card__title"><i class="fa-solid fa-envelope"></i> Email</p>
              <p class="card__value" style="word-wrap: break-word; word-break: break-all; overflow-wrap: break-word; max-width: 100%; font-size: 0.9rem; line-height: 1.5;">{{ $siswa->ortu->user->email ?? '-' }}</p>
            </article>
            <article class="card" style="overflow: hidden;">
              <p class="card__title"><i class="fa-solid fa-phone"></i> Nomor HP</p>
              <p class="card__value" style="word-wrap: break-word; overflow-wrap: break-word; max-width: 100%; font-size: 0.95rem;">{{ $siswa->ortu->no_hp ?? '-' }}</p>
            </article>
            <article class="card" style="overflow: hidden;">
              <p class="card__title"><i class="fa-solid fa-users"></i> Hubungan</p>
              <p class="card__value" style="word-wrap: break-word; overflow-wrap: break-word; max-width: 100%; font-size: 0.95rem;">{{ $siswa->ortu->hubungan ?? '-' }}</p>
            </article>
          </div>
          @else
          <div class="card" style="text-align: center; padding: 2rem;">
            <p style="color: #666;">Tidak ada data orang tua terdaftar</p>
          </div>
          @endif
        </section>

        <section aria-labelledby="statistik-siswa">
          <h2 id="statistik-siswa" class="section-title">Statistik Data</h2>
          <div class="grid grid-3">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-clipboard-check"></i> Total Presensi</p>
              <p class="card__value" style="font-size: 2rem; font-weight: bold; color: #007bff;">{{ $siswa->presensi->count() }}</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-chart-line"></i> Total Nilai</p>
              <p class="card__value" style="font-size: 2rem; font-weight: bold; color: #28a745;">{{ $siswa->nilai->count() }}</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-file-alt"></i> Penilaian Harian</p>
              <p class="card__value" style="font-size: 2rem; font-weight: bold; color: #ffc107;">{{ $siswa->penilaianHarian->count() }}</p>
            </article>
          </div>
        </section>
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>

