<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Pesan Guru</title>
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
  <body data-page="orangtua-notes">
    <div class="layout">
      <aside class="sidebar">
        <div class="sidebar__brand">
          <img src="{{ asset('assets/img/logo.png') }}" alt="Logo SDN 1 UNDUOLO" width="40" height="40" />
          <span>SDN 1 UNDUOLO</span>
        </div>
        <nav class="sidebar__nav">
          <a class="sidebar__link" href="{{ route('orangtua.dashboard') }}" data-nav="orangtua-dashboard">
            <i class="fa-solid fa-house-chimney"></i>
            <span>Dashboard</span>
          </a>
          <a class="sidebar__link" href="{{ route('orangtua.data-anak') }}" data-nav="orangtua-data-anak">
            <i class="fa-solid fa-child"></i>
            <span>Data Anak</span>
          </a>
          <a class="sidebar__link" href="{{ route('orangtua.penilaian-harian') }}" data-nav="orangtua-penilaian-harian">
            <i class="fa-solid fa-star-half-stroke"></i>
            <span>Penilaian Harian</span>
          </a>
          <a class="sidebar__link" href="{{ route('orangtua.perkembangan') }}" data-nav="orangtua-perkembangan">
            <i class="fa-solid fa-chart-simple"></i>
            <span>Perkembangan Anak</span>
          </a>
          <a class="sidebar__link" href="{{ route('orangtua.notes') }}" data-nav="orangtua-notes">
            <i class="fa-solid fa-envelope-open-text"></i>
            <span>Pesan Guru</span>
          </a>
        </nav>
      </aside>

      <main class="layout__main">
        <header class="page-header">
          <h1>Pesan dari Guru</h1>
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

        @if($anakList->isEmpty())
          <section aria-labelledby="empty-state">
            <div class="card" style="text-align: center; padding: 3rem;">
              <p style="font-size: 1.2rem; color: #666;">Belum ada data anak terdaftar</p>
            </div>
          </section>
        @else
          @if($anak)
          <section aria-labelledby="info-notes">
            <div class="card" style="background: rgba(33, 150, 243, 0.08); border-left: 4px solid #2196f3; margin-bottom: 24px;">
              <p style="margin: 0; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-info-circle" style="color: #2196f3;"></i>
                <span>Catatan di bawah ini adalah pesan yang diberikan oleh guru untuk {{ $anak->nama_siswa }} ({{ $anak->kelas->nama_kelas ?? 'Kelas' }}).</span>
              </p>
            </div>
          </section>

          <section aria-labelledby="daftar-notes">
            <h2 id="daftar-notes" class="section-title">Semua Pesan</h2>
            @if($notesList->isNotEmpty())
              <div class="grid grid-2">
                @foreach($notesList as $note)
                <article class="card">
                  <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <p class="card__title" style="margin: 0;">
                      <i class="fa-solid fa-note-sticky"></i> {{ $note->mapel->nama_mapel ?? 'Umum' }}
                    </p>
                    <span class="badge" style="background: rgba(33, 150, 243, 0.15); color: #1976d2;">
                      {{ \Carbon\Carbon::parse($note->tanggal)->format('d M Y') }}
                    </span>
                  </div>
                  <p style="margin: 12px 0; color: rgba(0, 0, 0, 0.8);">
                    {{ $note->catatan_guru }}
                  </p>
                  <div style="display: flex; align-items: center; gap: 16px; margin-top: 16px; padding-top: 12px; border-top: 1px solid rgba(0, 0, 0, 0.1);">
                    <small style="color: rgba(0, 0, 0, 0.6);">
                      <i class="fa-solid fa-user-chalkboard"></i> {{ $note->mapel->guru->user->name ?? '-' }}
                    </small>
                    <small style="color: rgba(0, 0, 0, 0.6);">
                      <i class="fa-solid fa-calendar"></i> {{ \Carbon\Carbon::parse($note->tanggal)->format('d M Y') }}
                    </small>
                  </div>
                </article>
                @endforeach
              </div>
            @else
              <div class="card" style="text-align: center; padding: 3rem;">
                <p style="font-size: 1.2rem; color: #666;">Belum ada pesan dari guru</p>
              </div>
            @endif
          </section>
          @else
          <section aria-labelledby="empty-state">
            <div class="card" style="text-align: center; padding: 3rem;">
              <p style="font-size: 1.2rem; color: #666;">Data anak tidak ditemukan</p>
            </div>
          </section>
          @endif
        @endif
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>
