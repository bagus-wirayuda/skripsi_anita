<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Notes Guru</title>
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
  <body data-page="guru-notes">
    <div class="layout">
      <aside class="sidebar">
        <div class="sidebar__brand">
          <img src="{{ asset('assets/img/logo.png') }}" alt="Logo SDN 1 UNDUOLO" width="40" height="40" />
          <span>SDN 1 UNDUOLO</span>
        </div>
        <nav class="sidebar__nav">
          <a class="sidebar__link" href="{{ route('guru.dashboard') }}" data-nav="guru-dashboard">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
          </a>
          <a class="sidebar__link" href="{{ route('guru.kelas-saya') }}" data-nav="guru-kelas-saya">
            <i class="fa-solid fa-calendar-days"></i>
            <span>Kelas Saya</span>
          </a>
          <a class="sidebar__link" href="{{ route('guru.perwalian') }}" data-nav="guru-perwalian">
            <i class="fa-solid fa-users-rectangle"></i>
            <span>Perwalian</span>
          </a>
          <a class="sidebar__link" href="{{ route('guru.presensi') }}" data-nav="guru-presensi">
            <i class="fa-solid fa-clipboard-check"></i>
            <span>Presensi</span>
          </a>
          <a class="sidebar__link" href="{{ route('guru.nilai') }}" data-nav="guru-nilai">
            <i class="fa-solid fa-star"></i>
            <span>Nilai</span>
          </a>
          <a class="sidebar__link active" href="{{ route('guru.notes') }}" data-nav="guru-notes">
            <i class="fa-solid fa-note-sticky"></i>
            <span>Notes</span>
          </a>
          <a class="sidebar__link" href="{{ route('guru.laporan') }}" data-nav="guru-laporan">
            <i class="fa-solid fa-chart-bar"></i>
            <span>Laporan</span>
          </a>
          <a class="sidebar__link" href="{{ route('guru.penilaian-harian') }}" data-nav="guru-penilaian-harian">
            <i class="fa-solid fa-star-half-stroke"></i>
            <span>Penilaian Harian</span>
          </a>
        </nav>
      </aside>

      <main class="layout__main">
        <header class="page-header">
          <h1>Notes / Catatan Siswa</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <button class="btn" type="button">
              <i class="fa-solid fa-book-open" aria-hidden="true"></i>
              <span>Riwayat Notes</span>
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

        <section aria-labelledby="filter-kelas">
          <h2 id="filter-kelas" class="section-title">Pilih Kelas & Siswa</h2>
          <form method="GET" action="{{ route('guru.notes') }}">
            <div class="grid grid-3">
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-layer-group"></i> Kelas</span>
                <select name="kelas" class="input-inline" onchange="this.form.submit()" id="selectKelas">
                  <option value="">Pilih Kelas</option>
                  @foreach($kelasList as $kelas)
                  <option value="{{ $kelas->nama_kelas }}" {{ $kelasFilter == $kelas->nama_kelas ? 'selected' : '' }}>
                    {{ $kelas->nama_kelas }}
                  </option>
                  @endforeach
                </select>
              </label>
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-user-graduate"></i> Siswa</span>
                <select name="siswa" class="input-inline" id="selectSiswa">
                  <option value="">-- Pilih Siswa --</option>
                  @if($kelasFilter && $siswaList->count() > 0)
                    @foreach($siswaList as $s)
                    <option value="{{ $s->id }}" {{ $siswaFilter == $s->id ? 'selected' : '' }}>
                      {{ $s->nama_siswa ?? '-' }}
                    </option>
                    @endforeach
                  @endif
                </select>
              </label>
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-calendar"></i> Tanggal</span>
                <input class="input-inline" type="date" id="tanggalNote" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" required />
              </label>
            </div>
          </form>
        </section>

        <section aria-labelledby="form-note">
          <h2 id="form-note" class="section-title">Buat Catatan</h2>
          <div class="card">
            <form id="notesForm" class="register-form">
              <label class="form-group">
                <span><i class="fa-solid fa-heading"></i> Judul Catatan</span>
                <input type="text" name="judul" placeholder="Contoh: Peningkatan dalam Matematika" required />
              </label>
              <label class="form-group">
                <span><i class="fa-solid fa-file-lines"></i> Isi Catatan</span>
                <textarea
                  name="isi"
                  placeholder="Tuliskan catatan tentang siswa yang akan ditampilkan kepada orang tua..."
                  rows="6"
                  required
                ></textarea>
              </label>
              <label class="form-group">
                <span><i class="fa-solid fa-tags"></i> Kategori</span>
                <select class="input-inline" name="kategori" required>
                  <option value="">-- Pilih Kategori --</option>
                  <option value="prestasi">Prestasi</option>
                  <option value="perilaku">Perilaku</option>
                  <option value="akademik">Akademik</option>
                  <option value="sosial">Sosial</option>
                  <option value="lainnya">Lainnya</option>
                </select>
              </label>
              <button class="btn" type="submit">
                <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                <span>Kirim Catatan</span>
              </button>
            </form>
          </div>
        </section>

        <section aria-labelledby="notes-terbaru">
          <h2 id="notes-terbaru" class="section-title">Notes Terbaru</h2>
          <div class="grid grid-2">
            @forelse($notesTerbaru as $note)
            @php
              $kategori = $note->jenis_penilaian ?? 'Lainnya';
              $badgeClass = 'background: rgba(76, 175, 80, 0.15); color: #2e7d32;';
              if ($kategori === 'Akademik') {
                $badgeClass = 'background: rgba(33, 150, 243, 0.15); color: #1976d2;';
              } elseif ($kategori === 'Perilaku') {
                $badgeClass = 'background: rgba(255, 152, 0, 0.15); color: #f57c00;';
              }
            @endphp
            <article class="card">
              <p class="card__title">
                <i class="fa-solid fa-note-sticky"></i> {{ $note->siswa->nama_siswa ?? '-' }} - {{ $note->siswa->kelas->nama_kelas ?? '-' }}
                <span class="badge" style="margin-left: 12px; {{ $badgeClass }}">
                  {{ $kategori }}
                </span>
              </p>
              <p style="margin: 12px 0; font-weight: 600;">{{ $note->deskripsi ?? 'Catatan' }}</p>
              <p>{{ $note->catatan_guru ?? '-' }}</p>
              <small style="color: rgba(0, 0, 0, 0.6);">{{ \Carbon\Carbon::parse($note->tanggal)->format('d M Y') }}</small>
            </article>
            @empty
            <article class="card" style="text-align: center; padding: 2rem;">
              <p><i class="fa-solid fa-info-circle"></i> Belum ada notes terbaru</p>
            </article>
            @endforelse
          </div>
        </section>
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
      // Set default date to today if not set
      document.addEventListener('DOMContentLoaded', () => {
        const tanggalInput = document.getElementById('tanggalNote');
        if (tanggalInput && !tanggalInput.value) {
          const today = new Date().toISOString().split('T')[0];
          tanggalInput.value = today;
        }
      });
    </script>
  </body>
</html>

