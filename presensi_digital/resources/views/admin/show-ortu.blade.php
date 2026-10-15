<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Detail Orang Tua</title>
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
      /* Ensure text doesn't overflow boxes */
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
      
      .card__title {
        word-wrap: break-word;
        overflow-wrap: break-word;
        max-width: 100%;
      }
      
      table td, table th {
        word-wrap: break-word;
        overflow-wrap: break-word;
        max-width: 200px;
        padding: 0.75rem;
      }
      
      /* For long names, allow wrapping */
      h1 {
        word-wrap: break-word;
        word-break: break-word;
        overflow-wrap: break-word;
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
          <h1 style="word-wrap: break-word; word-break: break-word; overflow-wrap: break-word; max-width: 100%;">Detail Orang Tua: {{ $ortu->user->name ?? '-' }}</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <a href="{{ route('admin.data-siswa') }}" class="btn">
              <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
              <span>Kembali ke Data Siswa</span>
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

        <section aria-labelledby="detail-ortu">
          <h2 id="detail-ortu" class="section-title">Informasi Orang Tua / Wali</h2>
          <div class="grid grid-2">
            <article class="card" style="overflow: hidden;">
              <p class="card__title"><i class="fa-solid fa-user"></i> Nama Lengkap</p>
              <p class="card__value" style="word-wrap: break-word; word-break: break-word; overflow-wrap: break-word; max-width: 100%; font-size: 0.95rem; line-height: 1.5;">{{ $ortu->user->name ?? '-' }}</p>
            </article>
            <article class="card" style="overflow: hidden;">
              <p class="card__title"><i class="fa-solid fa-envelope"></i> Email</p>
              <p class="card__value" style="word-wrap: break-word; word-break: break-all; overflow-wrap: break-word; max-width: 100%; font-size: 0.9rem; line-height: 1.5;">{{ $ortu->user->email ?? '-' }}</p>
            </article>
            <article class="card" style="overflow: hidden;">
              <p class="card__title"><i class="fa-solid fa-id-card"></i> NIK</p>
              <p class="card__value" style="word-wrap: break-word; overflow-wrap: break-word; max-width: 100%; font-size: 0.95rem;">{{ $ortu->nik ?? '-' }}</p>
            </article>
            <article class="card" style="overflow: hidden;">
              <p class="card__title"><i class="fa-solid fa-users"></i> Hubungan</p>
              <p class="card__value" style="word-wrap: break-word; overflow-wrap: break-word; max-width: 100%; font-size: 0.95rem;">{{ $ortu->hubungan ?? '-' }}</p>
            </article>
            <article class="card" style="overflow: hidden;">
              <p class="card__title"><i class="fa-solid fa-briefcase"></i> Pekerjaan</p>
              <p class="card__value" style="word-wrap: break-word; word-break: break-word; overflow-wrap: break-word; max-width: 100%; font-size: 0.95rem; line-height: 1.5;">{{ $ortu->pekerjaan ?? '-' }}</p>
            </article>
            <article class="card" style="overflow: hidden;">
              <p class="card__title"><i class="fa-solid fa-graduation-cap"></i> Pendidikan Terakhir</p>
              <p class="card__value" style="word-wrap: break-word; overflow-wrap: break-word; max-width: 100%; font-size: 0.95rem;">{{ $ortu->pendidikan ?? '-' }}</p>
            </article>
            <article class="card" style="overflow: hidden;">
              <p class="card__title"><i class="fa-solid fa-phone"></i> Nomor HP</p>
              <p class="card__value" style="word-wrap: break-word; overflow-wrap: break-word; max-width: 100%; font-size: 0.95rem;">{{ $ortu->no_hp ?? '-' }}</p>
            </article>
            <article class="card" style="overflow: hidden;">
              <p class="card__title"><i class="fa-solid fa-calendar"></i> Akun Dibuat</p>
              <p class="card__value" style="word-wrap: break-word; overflow-wrap: break-word; max-width: 100%; font-size: 0.95rem;">{{ $ortu->user->created_at ? \Carbon\Carbon::parse($ortu->user->created_at)->format('d F Y') : '-' }}</p>
            </article>
          </div>
          @if($ortu->alamat)
          <article class="card" style="margin-top: 1rem; overflow: hidden;">
            <p class="card__title"><i class="fa-solid fa-location-dot"></i> Alamat</p>
            <p style="margin: 0; color: #555; word-wrap: break-word; word-break: break-word; overflow-wrap: break-word; max-width: 100%; line-height: 1.6; white-space: pre-wrap;">{{ $ortu->alamat }}</p>
          </article>
          @endif
        </section>

        <section aria-labelledby="anak-ortu">
          <h2 id="anak-ortu" class="section-title">Anak yang Terdaftar ({{ $ortu->siswa->count() }})</h2>
          @if($ortu->siswa->count() > 0)
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>NIS</th>
                  <th>Nama Siswa</th>
                  <th>Kelas</th>
                  <th>Jenis Kelamin</th>
                  <th>Tanggal Lahir</th>
                </tr>
              </thead>
              <tbody>
                @foreach($ortu->siswa as $anak)
                <tr>
                  <td style="word-wrap: break-word; overflow-wrap: break-word; max-width: 120px;">{{ $anak->nis ?? '-' }}</td>
                  <td style="word-wrap: break-word; word-break: break-word; overflow-wrap: break-word; max-width: 200px;">
                    <a href="{{ route('admin.data-siswa') }}?siswa={{ $anak->id }}" style="color: #007bff; text-decoration: none; font-weight: 500; display: inline-block; max-width: 100%;">
                      {{ $anak->nama_siswa }}
                    </a>
                  </td>
                  <td style="word-wrap: break-word; overflow-wrap: break-word; max-width: 100px;">{{ $anak->kelas->nama_kelas ?? '-' }}</td>
                  <td style="word-wrap: break-word; overflow-wrap: break-word; max-width: 120px;">{{ $anak->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                  <td style="word-wrap: break-word; overflow-wrap: break-word; max-width: 150px;">{{ $anak->tanggal_lahir ? \Carbon\Carbon::parse($anak->tanggal_lahir)->format('d F Y') : '-' }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @else
          <div class="card" style="text-align: center; padding: 2rem;">
            <p style="color: #666;">Belum ada anak yang terdaftar untuk orang tua ini.</p>
          </div>
          @endif
        </section>
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>

