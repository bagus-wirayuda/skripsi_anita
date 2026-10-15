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
      .table-wrapper {
        overflow-x: auto;
      }
      table textarea {
        font-family: inherit;
        font-size: 0.9rem;
      }
      table select {
        font-size: 0.9rem;
      }
      .alert {
        border-radius: 4px;
        padding: 1rem;
        margin: 1rem 0;
      }
      .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
      }
      .alert-error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
      }
    </style>
  </head>
  <body data-page="guru-penilaian-harian">
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
          <a class="sidebar__link" href="{{ route('guru.notes') }}" data-nav="guru-notes">
            <i class="fa-solid fa-note-sticky"></i>
            <span>Notes</span>
          </a>
          <a class="sidebar__link" href="{{ route('guru.laporan') }}" data-nav="guru-laporan">
            <i class="fa-solid fa-chart-bar"></i>
            <span>Laporan</span>
          </a>
          <a class="sidebar__link active" href="{{ route('guru.penilaian-harian') }}" data-nav="guru-penilaian-harian">
            <i class="fa-solid fa-star-half-stroke"></i>
            <span>Penilaian Harian</span>
          </a>
        </nav>
      </aside>

      <main class="layout__main">
        <header class="page-header">
          <h1>Penilaian Harian Siswa</h1>
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

        <section aria-labelledby="filter-penilaian">
          <h2 id="filter-penilaian" class="section-title">Pilih Data Penilaian</h2>
          <form method="GET" action="{{ route('guru.penilaian-harian') }}">
            <div class="grid grid-4">
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-layer-group"></i> Kelas</span>
                <select name="kelas" class="input-inline" onchange="this.form.submit()">
                  <option value="">Pilih Kelas</option>
                  @foreach($kelasList as $kelas)
                  <option value="{{ $kelas->nama_kelas }}" {{ $kelasFilter == $kelas->nama_kelas ? 'selected' : '' }}>
                    {{ $kelas->nama_kelas }}
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
                  <option value="">Pilih Mapel</option>
                  @if($kelasFilter)
                    @php
                      $selectedKelas = $kelasList->where('nama_kelas', $kelasFilter)->first();
                      $mapelForSelectedKelas = $selectedKelas ? $mapelGuru->where('kelas_id', $selectedKelas->id) : collect([]);
                    @endphp
                    @foreach($mapelForSelectedKelas as $mapel)
                    <option value="{{ $mapel->id }}" {{ $mapelFilter == $mapel->id ? 'selected' : '' }}>
                      {{ $mapel->nama_mapel }}
                    </option>
                    @endforeach
                  @endif
                </select>
              </label>
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-user-graduate"></i> Pilih Siswa</span>
                <select name="siswa" class="input-inline" onchange="this.form.submit()">
                  <option value="">Pilih Siswa</option>
                  @if($kelasFilter && $siswaList->isNotEmpty())
                    @foreach($siswaList as $s)
                    <option value="{{ $s->id }}" {{ $siswaFilter == $s->id ? 'selected' : '' }}>
                      {{ $s->nis }} - {{ $s->nama_siswa }}
                    </option>
                    @endforeach
                  @endif
                </select>
              </label>
            </div>
          </form>
        </section>

        @if(session('success'))
        <div class="alert alert-success" style="margin: 1rem 0; padding: 1rem; background: #d4edda; color: #155724; border-radius: 4px;">
          {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-error" style="margin: 1rem 0; padding: 1rem; background: #f8d7da; color: #721c24; border-radius: 4px;">
          {{ session('error') }}
        </div>
        @endif

        @if($kelasFilter && $mapelFilter && $selectedMapel && $selectedSiswa)
        <section aria-labelledby="form-penilaian">
          <h2 id="form-penilaian" class="section-title">Form Penilaian Harian</h2>
          
          <div style="margin-bottom: 1.5rem; padding: 1.5rem; background: #f5f9ff; border-radius: 8px; border-left: 4px solid #c62828;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
              <div>
                <p style="margin: 0; font-weight: 600; color: #c62828; margin-bottom: 0.5rem;">
                  <i class="fa-solid fa-book"></i> Mata Pelajaran
                </p>
                <p style="margin: 0; color: #666;">{{ $selectedMapel->nama_mapel }}</p>
              </div>
              <div>
                <p style="margin: 0; font-weight: 600; color: #c62828; margin-bottom: 0.5rem;">
                  <i class="fa-solid fa-user-graduate"></i> Siswa
                </p>
                <p style="margin: 0; color: #666;">{{ $selectedSiswa->nis }} - {{ $selectedSiswa->nama_siswa }}</p>
              </div>
              <div>
                <p style="margin: 0; font-weight: 600; color: #c62828; margin-bottom: 0.5rem;">
                  <i class="fa-solid fa-calendar"></i> Tanggal
                </p>
                <p style="margin: 0; color: #666;">{{ \Carbon\Carbon::parse($tanggalFilter)->format('d F Y') }}</p>
              </div>
              <div>
                <p style="margin: 0; font-weight: 600; color: #c62828; margin-bottom: 0.5rem;">
                  <i class="fa-solid fa-layer-group"></i> Kelas
                </p>
                <p style="margin: 0; color: #666;">{{ $kelasFilter }}</p>
              </div>
            </div>
          </div>

          @php
            $nilaiHariIni = $penilaianHariIni ? $penilaianHariIni->nilai : null;
            $jenisPenilaianHariIni = $penilaianHariIni ? $penilaianHariIni->jenis_penilaian : null;
            $deskripsiHariIni = $penilaianHariIni ? $penilaianHariIni->deskripsi : null;
            $catatanGuruHariIni = $penilaianHariIni ? $penilaianHariIni->catatan_guru : null;
          @endphp
          
          <form id="formPenilaianHarian" method="POST" action="{{ route('guru.penilaian-harian.store') }}">
            @csrf
            <input type="hidden" name="mapel_id" value="{{ $mapelFilter }}">
            <input type="hidden" name="tanggal" value="{{ $tanggalFilter }}">
            <input type="hidden" name="siswa_id" value="{{ $selectedSiswa->id }}">
            
            <div class="card" style="padding: 2rem;">
              <div style="display: grid; gap: 1.5rem;">
                <label>
                  <span class="card__title" style="margin-bottom: 0.5rem; display: block;">
                    <i class="fa-solid fa-tag"></i> Jenis Penilaian <span style="color: #c62828;">*</span>
                  </span>
                  <select name="jenis_penilaian" class="input-inline" required style="width: 100%; font-size: 1rem; padding: 0.75rem;">
                    <option value="">Pilih Jenis Penilaian</option>
                    <option value="Kuis" {{ $jenisPenilaianHariIni == 'Kuis' ? 'selected' : '' }}>Kuis</option>
                    <option value="Tugas" {{ $jenisPenilaianHariIni == 'Tugas' || !$jenisPenilaianHariIni ? 'selected' : '' }}>Tugas</option>
                    <option value="Praktik" {{ $jenisPenilaianHariIni == 'Praktik' ? 'selected' : '' }}>Praktik</option>
                    <option value="Ulangan Harian" {{ $jenisPenilaianHariIni == 'Ulangan Harian' ? 'selected' : '' }}>Ulangan Harian</option>
                    <option value="Proyek" {{ $jenisPenilaianHariIni == 'Proyek' ? 'selected' : '' }}>Proyek</option>
                    <option value="Portofolio" {{ $jenisPenilaianHariIni == 'Portofolio' ? 'selected' : '' }}>Portofolio</option>
                  </select>
                </label>

                <label>
                  <span class="card__title" style="margin-bottom: 0.5rem; display: block;">
                    <i class="fa-solid fa-star"></i> Nilai (0-100) <span style="color: #c62828;">*</span>
                  </span>
                  <input 
                    type="number" 
                    name="nilai" 
                    min="0" 
                    max="100" 
                    step="0.1" 
                    value="{{ $nilaiHariIni ? number_format($nilaiHariIni, 1) : '' }}" 
                    class="input-inline" 
                    placeholder="Masukkan nilai (0-100)"
                    style="width: 100%; font-size: 1rem; padding: 0.75rem;"
                    required />
                </label>

                <label>
                  <span class="card__title" style="margin-bottom: 0.5rem; display: block;">
                    <i class="fa-solid fa-info-circle"></i> Deskripsi Penilaian
                  </span>
                  <textarea 
                    name="deskripsi" 
                    class="input-inline" 
                    rows="4" 
                    placeholder="Deskripsi penilaian (opsional)..."
                    style="width: 100%; resize: vertical; font-size: 1rem; padding: 0.75rem;">{{ $deskripsiHariIni ?? '' }}</textarea>
                </label>

                <label>
                  <span class="card__title" style="margin-bottom: 0.5rem; display: block;">
                    <i class="fa-solid fa-comment-dots"></i> Catatan Guru
                  </span>
                  <textarea 
                    name="catatan_guru" 
                    class="input-inline" 
                    rows="4" 
                    placeholder="Catatan untuk siswa/orang tua (opsional)..."
                    style="width: 100%; resize: vertical; font-size: 1rem; padding: 0.75rem;">{{ $catatanGuruHariIni ?? '' }}</textarea>
                </label>

                @if($penilaianHariIni)
                <div style="padding: 1rem; background: #e8f5e9; border-radius: 6px; border-left: 3px solid #4caf50;">
                  <p style="margin: 0; color: #2e7d32; font-weight: 600;">
                    <i class="fa-solid fa-info-circle"></i> Status: Sudah ada penilaian untuk jenis ini pada tanggal ini. Form ini akan memperbarui penilaian yang sudah ada.
                  </p>
                </div>
                @endif
              </div>

              <div style="margin-top: 2rem; display: flex; gap: 1rem; align-items: center;">
                <button class="btn" type="submit" style="min-width: 150px;">
                  <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                  <span>{{ $penilaianHariIni ? 'Perbarui' : 'Simpan' }} Penilaian</span>
                </button>
                <button class="btn" type="reset" style="background: #6c757d; color: white; min-width: 150px;">
                  <i class="fa-solid fa-rotate-left" aria-hidden="true"></i>
                  <span>Reset</span>
                </button>
              </div>
            </div>
          </form>
        </section>
        @elseif($kelasFilter && $mapelFilter && $selectedMapel)
        <section aria-labelledby="pilih-siswa">
          <div class="card" style="text-align: center; padding: 3rem;">
            <p style="font-size: 1.2rem; color: #666; margin-bottom: 0.5rem;">
              <i class="fa-solid fa-info-circle"></i> Silakan pilih siswa terlebih dahulu
            </p>
            <p style="color: #999;">Pilih siswa dari dropdown di atas untuk mengisi penilaian harian</p>
          </div>
        </section>
        @else
        <section aria-labelledby="daftar-siswa">
          <div class="card" style="text-align: center; padding: 3rem;">
            <p><i class="fa-solid fa-info-circle"></i> Silakan pilih kelas, tanggal, dan mata pelajaran terlebih dahulu</p>
          </div>
        </section>
        @endif
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>

