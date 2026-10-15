<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Penilaian Harian</title>
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
      .penilaian-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
        border-left: 4px solid #c62828;
        transition: transform 0.2s, box-shadow 0.2s;
      }
      .penilaian-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      }
      .penilaian-card__header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e0e0e0;
      }
      .penilaian-card__info {
        flex: 1;
      }
      .penilaian-card__mapel {
        font-size: 1.2rem;
        font-weight: 600;
        color: #c62828;
        margin-bottom: 0.5rem;
      }
      .penilaian-card__meta {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        font-size: 0.9rem;
        color: #666;
      }
      .penilaian-card__nilai {
        text-align: center;
        min-width: 80px;
      }
      .penilaian-card__nilai-value {
        font-size: 2rem;
        font-weight: 700;
        color: #c62828;
        line-height: 1;
      }
      .penilaian-card__nilai-label {
        font-size: 0.75rem;
        color: #999;
        margin-top: 0.25rem;
      }
      .penilaian-card__badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 0.5rem;
      }
      .badge-kuis { background: #e3f2fd; color: #1976d2; }
      .badge-tugas { background: #f3e5f5; color: #7b1fa2; }
      .badge-praktik { background: #e8f5e9; color: #388e3c; }
      .badge-ulangan { background: #fff3e0; color: #f57c00; }
      .badge-proyek { background: #fce4ec; color: #c2185b; }
      .badge-portofolio { background: #e0f2f1; color: #00796b; }
      .penilaian-card__body {
        margin-top: 1rem;
      }
      .penilaian-card__deskripsi,
      .penilaian-card__catatan {
        margin-top: 0.75rem;
        padding: 0.75rem;
        background: #f5f5f5;
        border-radius: 6px;
        font-size: 0.9rem;
        line-height: 1.6;
      }
      .penilaian-card__catatan {
        background: #fff3cd;
        border-left: 3px solid #ffc107;
      }
      .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
      }
      .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      }
      .stat-card.primary {
        background: linear-gradient(135deg, #c62828 0%, #d32f2f 100%);
      }
      .stat-card.success {
        background: linear-gradient(135deg, #388e3c 0%, #4caf50 100%);
      }
      .stat-card.info {
        background: linear-gradient(135deg, #1976d2 0%, #2196f3 100%);
      }
      .stat-card__value {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0.5rem 0;
      }
      .stat-card__label {
        font-size: 0.9rem;
        opacity: 0.9;
      }
      .empty-state {
        text-align: center;
        padding: 3rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      }
      .empty-state__icon {
        font-size: 4rem;
        color: #ccc;
        margin-bottom: 1rem;
      }
    </style>
  </head>
  <body data-page="orangtua-penilaian-harian">
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
          <a class="sidebar__link active" href="{{ route('orangtua.penilaian-harian') }}" data-nav="orangtua-penilaian-harian">
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
          <h1>Penilaian Harian</h1>
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
            <div class="empty-state">
              <div class="empty-state__icon">
                <i class="fa-solid fa-child"></i>
              </div>
              <p style="font-size: 1.2rem; color: #666;">Belum ada data anak terdaftar</p>
            </div>
          </section>
        @else
          <!-- Filter Section -->
          <section aria-labelledby="filter-penilaian">
            <h2 id="filter-penilaian" class="section-title">Filter Penilaian</h2>
            <form method="GET" action="{{ route('orangtua.penilaian-harian') }}">
              <div class="grid grid-4">
                <label class="card">
                  <span class="card__title"><i class="fa-solid fa-child"></i> Pilih Anak</span>
                  <select name="anak_id" class="input-inline" onchange="this.form.submit()">
                    @foreach($anakList as $a)
                    <option value="{{ $a->id }}" {{ $anak && $anak->id == $a->id ? 'selected' : '' }}>
                      {{ $a->nama_siswa }} - {{ $a->kelas->nama_kelas ?? '-' }}
                    </option>
                    @endforeach
                  </select>
                </label>
                <label class="card">
                  <span class="card__title"><i class="fa-solid fa-calendar"></i> Tanggal</span>
                  <input name="tanggal" class="input-inline" type="date" value="{{ $tanggalFilter }}" onchange="this.form.submit()" />
                </label>
                <label class="card">
                  <span class="card__title"><i class="fa-solid fa-book"></i> Mata Pelajaran</span>
                  <select name="mapel" class="input-inline" onchange="this.form.submit()">
                    <option value="">Semua Mapel</option>
                    @foreach($mapelList as $mapel)
                    <option value="{{ $mapel->id }}" {{ $mapelFilter == $mapel->id ? 'selected' : '' }}>
                      {{ $mapel->nama_mapel }}
                    </option>
                    @endforeach
                  </select>
                </label>
                <label class="card">
                  <span class="card__title"><i class="fa-solid fa-filter"></i> Jenis Penilaian</span>
                  <select name="jenis_penilaian" class="input-inline" onchange="this.form.submit()">
                    <option value="Semua">Semua Jenis</option>
                    <option value="Kuis" {{ $jenisFilter == 'Kuis' ? 'selected' : '' }}>Kuis</option>
                    <option value="Tugas" {{ $jenisFilter == 'Tugas' ? 'selected' : '' }}>Tugas</option>
                    <option value="Praktik" {{ $jenisFilter == 'Praktik' ? 'selected' : '' }}>Praktik</option>
                    <option value="Ulangan Harian" {{ $jenisFilter == 'Ulangan Harian' ? 'selected' : '' }}>Ulangan Harian</option>
                    <option value="Proyek" {{ $jenisFilter == 'Proyek' ? 'selected' : '' }}>Proyek</option>
                    <option value="Portofolio" {{ $jenisFilter == 'Portofolio' ? 'selected' : '' }}>Portofolio</option>
                  </select>
                </label>
              </div>
            </form>
          </section>

          @if($anak)
          <!-- Statistics Section -->
          <section aria-labelledby="statistics">
            <h2 id="statistics" class="section-title">Ringkasan Penilaian</h2>
            <div class="stats-grid">
              <div class="stat-card primary">
                <div class="stat-card__label">
                  <i class="fa-solid fa-star"></i> Total Penilaian
                </div>
                <div class="stat-card__value">{{ number_format($totalPenilaian) }}</div>
                <div class="stat-card__label">Penilaian yang diterima</div>
              </div>
              <div class="stat-card success">
                <div class="stat-card__label">
                  <i class="fa-solid fa-chart-line"></i> Rata-rata Nilai
                </div>
                <div class="stat-card__value">{{ number_format($rataRataNilai, 1) }}</div>
                <div class="stat-card__label">Dari semua penilaian</div>
              </div>
              <div class="stat-card info">
                <div class="stat-card__label">
                  <i class="fa-solid fa-calendar-week"></i> Penilaian 7 Hari Terakhir
                </div>
                <div class="stat-card__value">{{ $penilaianTerbaru->count() }}</div>
                <div class="stat-card__label">Penilaian terbaru</div>
              </div>
            </div>
          </section>

          <!-- Penilaian List -->
          <section aria-labelledby="daftar-penilaian">
            <h2 id="daftar-penilaian" class="section-title">
              Daftar Penilaian Harian - {{ $anak->nama_siswa }}
            </h2>
            
            @if($penilaianHarian->count() > 0)
              @foreach($penilaianHarian as $penilaian)
              <article class="penilaian-card">
                <div class="penilaian-card__header">
                  <div class="penilaian-card__info">
                    <div class="penilaian-card__mapel">
                      <i class="fa-solid fa-book"></i> {{ $penilaian->mapel->nama_mapel ?? '-' }}
                    </div>
                    <div class="penilaian-card__meta">
                      <span>
                        <i class="fa-solid fa-calendar"></i> 
                        {{ \Carbon\Carbon::parse($penilaian->tanggal)->format('d F Y') }}
                      </span>
                      <span>
                        <i class="fa-solid fa-person-chalkboard"></i> 
                        {{ $penilaian->mapel->guru->user->name ?? '-' }}
                      </span>
                      <span>
                        <i class="fa-solid fa-door-open"></i> 
                        {{ $penilaian->mapel->kelas->nama_kelas ?? '-' }}
                      </span>
                    </div>
                    @php
                      $badgeClass = 'badge-tugas';
                      $jenisLower = strtolower($penilaian->jenis_penilaian);
                      if (str_contains($jenisLower, 'kuis')) {
                        $badgeClass = 'badge-kuis';
                      } elseif (str_contains($jenisLower, 'tugas')) {
                        $badgeClass = 'badge-tugas';
                      } elseif (str_contains($jenisLower, 'praktik')) {
                        $badgeClass = 'badge-praktik';
                      } elseif (str_contains($jenisLower, 'ulangan')) {
                        $badgeClass = 'badge-ulangan';
                      } elseif (str_contains($jenisLower, 'proyek')) {
                        $badgeClass = 'badge-proyek';
                      } elseif (str_contains($jenisLower, 'portofolio')) {
                        $badgeClass = 'badge-portofolio';
                      }
                    @endphp
                    <span class="penilaian-card__badge {{ $badgeClass }}">
                      {{ $penilaian->jenis_penilaian }}
                    </span>
                  </div>
                  <div class="penilaian-card__nilai">
                    <div class="penilaian-card__nilai-value">{{ number_format($penilaian->nilai, 1) }}</div>
                    <div class="penilaian-card__nilai-label">Nilai</div>
                  </div>
                </div>
                <div class="penilaian-card__body">
                  @if($penilaian->deskripsi)
                  <div class="penilaian-card__deskripsi">
                    <strong><i class="fa-solid fa-info-circle"></i> Deskripsi:</strong><br>
                    {{ $penilaian->deskripsi }}
                  </div>
                  @endif
                  @if($penilaian->catatan_guru)
                  <div class="penilaian-card__catatan">
                    <strong><i class="fa-solid fa-comment-dots"></i> Catatan Guru:</strong><br>
                    {{ $penilaian->catatan_guru }}
                  </div>
                  @endif
                </div>
              </article>
              @endforeach
            @else
              <div class="empty-state">
                <div class="empty-state__icon">
                  <i class="fa-solid fa-clipboard-list"></i>
                </div>
                <p style="font-size: 1.2rem; color: #666; margin-bottom: 0.5rem;">Belum ada penilaian harian</p>
                <p style="color: #999;">Penilaian harian akan muncul di sini setelah guru memberikan penilaian.</p>
              </div>
            @endif
          </section>
          @endif
        @endif
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>

