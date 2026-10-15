<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Evaluasi Pembelajaran</title>
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
  <body data-page="kepala-evaluasi-pembelajaran">
    <div class="layout">
      <aside class="sidebar">
        <div class="sidebar__brand">
          <img src="{{ asset('assets/img/logo.png') }}" alt="Logo SDN 1 UNDUOLO" width="40" height="40" />
          <span>SDN 1 UNDUOLO</span>
        </div>
        <nav class="sidebar__nav">
          <a class="sidebar__link" href="{{ route('kepalasekolah.dashboard') }}" data-nav="kepala-dashboard">
            <i class="fa-solid fa-gauge"></i>
            <span>Dashboard</span>
          </a>
          <a class="sidebar__link" href="{{ route('kepalasekolah.laporan') }}" data-nav="kepala-laporan">
            <i class="fa-solid fa-folder-open"></i>
            <span>Laporan</span>
          </a>
          <a class="sidebar__link" href="{{ route('kepalasekolah.laporan-akademik') }}" data-nav="kepala-laporan-akademik">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>Laporan Akademik</span>
          </a>
          <a class="sidebar__link" href="{{ route('kepalasekolah.laporan-absensi-guru') }}" data-nav="kepala-laporan-absensi-guru">
            <i class="fa-solid fa-chalkboard-user"></i>
            <span>Laporan Absensi Guru</span>
          </a>
          <a class="sidebar__link" href="{{ route('kepalasekolah.laporan-absensi-siswa') }}" data-nav="kepala-laporan-absensi-siswa">
            <i class="fa-solid fa-user-graduate"></i>
            <span>Laporan Absensi Siswa</span>
          </a>
          <a class="sidebar__link" href="{{ route('kepalasekolah.laporan-absensi') }}" data-nav="kepala-laporan-absensi">
            <i class="fa-solid fa-clipboard-check"></i>
            <span>Laporan Absensi</span>
          </a>
          <a class="sidebar__link is-active" href="{{ route('kepalasekolah.evaluasi-pembelajaran') }}" data-nav="kepala-evaluasi-pembelajaran">
            <i class="fa-solid fa-chart-line"></i>
            <span>Evaluasi Pembelajaran</span>
          </a>
        </nav>
      </aside>

      <main class="layout__main">
        <header class="page-header">
          <h1>Evaluasi Pembelajaran</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <button class="btn" type="button">
              <i class="fa-solid fa-file-export" aria-hidden="true"></i>
              <span>Ekspor Laporan</span>
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

        <section aria-labelledby="ringkasan-evaluasi">
          <h2 id="ringkasan-evaluasi" class="section-title">Ringkasan Evaluasi</h2>
          <div class="stats-grid">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-star"></i> Skor Evaluasi</p>
              <p class="card__value">{{ number_format($skorEvaluasi, 1) }}</p>
              <small>Dari skala 5.0</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-chalkboard"></i> Metode Pembelajaran</p>
              <p class="card__value">{{ number_format($rataRataMetode, 1) }}</p>
              <small>Rata-rata penilaian</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-book-open"></i> Materi Pembelajaran</p>
              <p class="card__value">{{ number_format($rataRataMateri, 1) }}</p>
              <small>Rata-rata penilaian</small>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-comments"></i> Interaksi Pembelajaran</p>
              <p class="card__value">{{ number_format($rataRataInteraksi, 1) }}</p>
              <small>Rata-rata penilaian</small>
            </article>
          </div>
        </section>

        <section aria-labelledby="evaluasi-kelas">
          <h2 id="evaluasi-kelas" class="section-title">Evaluasi per Kelas</h2>
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>Kelas</th>
                  <th>Wali Kelas</th>
                  <th>Metode</th>
                  <th>Materi</th>
                  <th>Interaksi</th>
                  <th>Skor Total</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($evaluasiKelas as $eval)
                <tr>
                  <td>{{ $eval['nama_kelas'] }}</td>
                  <td>{{ $eval['wali_kelas'] }}</td>
                  <td>{{ number_format($eval['metode'], 1) }}</td>
                  <td>{{ number_format($eval['materi'], 1) }}</td>
                  <td>{{ number_format($eval['interaksi'], 1) }}</td>
                  <td>{{ number_format($eval['skor_total'], 1) }}</td>
                  <td>
                    @php
                      $statusText = 'Sangat Baik';
                      if ($eval['skor_total'] < 3.5) {
                        $statusText = 'Perlu Peningkatan';
                      } elseif ($eval['skor_total'] < 4.0) {
                        $statusText = 'Baik';
                      } elseif ($eval['skor_total'] < 4.5) {
                        $statusText = 'Baik';
                      } else {
                        $statusText = 'Sangat Baik';
                      }
                    @endphp
                    <span class="badge {{ $eval['status_badge'] }}">{{ $statusText }}</span>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7" style="text-align: center; padding: 2rem;">
                    <p>Tidak ada data evaluasi ditemukan</p>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </section>

        <section aria-labelledby="aspek-evaluasi">
          <h2 id="aspek-evaluasi" class="section-title">Aspek Evaluasi</h2>
          <div class="grid grid-2">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-lightbulb"></i> Kreativitas Metode</p>
              <p>Guru menggunakan berbagai metode pembelajaran yang menarik dan sesuai dengan karakteristik siswa.</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-book"></i> Kualitas Materi</p>
              <p>Materi pembelajaran disampaikan dengan jelas dan mudah dipahami oleh siswa.</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-comments"></i> Interaksi Pembelajaran</p>
              <p>Interaksi antara guru dan siswa berjalan dengan baik, menciptakan suasana belajar yang kondusif.</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-target"></i> Pencapaian Tujuan</p>
              <p>Sebagian besar tujuan pembelajaran tercapai dengan baik, namun masih ada ruang untuk peningkatan.</p>
            </article>
          </div>
        </section>

        <section aria-labelledby="rekomendasi">
          <h2 id="rekomendasi" class="section-title">Rekomendasi</h2>
          <div class="grid grid-2">
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-arrow-up"></i> Peningkatan</p>
              <p>Kelas 4C perlu mendapat perhatian khusus untuk meningkatkan kualitas pembelajaran. Lakukan pendampingan intensif.</p>
            </article>
            <article class="card">
              <p class="card__title"><i class="fa-solid fa-trophy"></i> Apresiasi</p>
              <p>Kelas 1A, 5A, dan 6B menunjukkan performa pembelajaran yang sangat baik. Pertahankan dan jadikan sebagai contoh.</p>
            </article>
          </div>
        </section>
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>

