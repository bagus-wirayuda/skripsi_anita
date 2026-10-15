<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Input Nilai</title>
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
  <body data-page="guru-nilai">
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
          <a class="sidebar__link active" href="{{ route('guru.nilai') }}" data-nav="guru-nilai">
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
          <a class="sidebar__link" href="{{ route('guru.penilaian-harian') }}" data-nav="guru-penilaian-harian">
            <i class="fa-solid fa-star-half-stroke"></i>
            <span>Penilaian Harian</span>
          </a>
        </nav>
      </aside>

      <main class="layout__main">
        <header class="page-header">
          <h1>Input Nilai Siswa</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <button class="btn" type="button">
              <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
              <span>Simpan Nilai</span>
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

        <section aria-labelledby="filter-nilai">
          <h2 id="filter-nilai" class="section-title">Filter Data</h2>
          <form method="GET" action="{{ route('guru.nilai') }}">
            <div class="grid grid-3">
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
                <span class="card__title"><i class="fa-solid fa-calendar-days"></i> Semester</span>
                <select name="semester" class="input-inline" onchange="this.form.submit()">
                  <option value="1" {{ $semesterFilter == '1' ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                  <option value="2" {{ $semesterFilter == '2' ? 'selected' : '' }}>Semester 2 (Genap)</option>
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

        @if($kelasFilter && $siswa->count() > 0 && $mapelId)
        <section aria-labelledby="nilai-table">
          <h2 id="nilai-table" class="section-title">{{ $kelasFilter ?? 'Kelas' }} - Semester {{ $semesterFilter == '1' ? 'Ganjil' : 'Genap' }}</h2>
          @php
            $currentMapel = $mapelGuru->where('id', $mapelId)->first();
            $selectedKelas = $kelasList->where('nama_kelas', $kelasFilter)->first();
          @endphp
          @if($currentMapel)
          <p style="margin-bottom: 1rem; color: #666; font-size: 0.9rem;">
            <i class="fa-solid fa-info-circle"></i> 
            Mata Pelajaran: {{ $currentMapel->nama_mapel ?? '-' }}
          </p>
          @endif
          
          <form method="POST" action="{{ route('guru.nilai.store') }}">
            @csrf
            <input type="hidden" name="mapel_id" value="{{ $mapelId }}">
            <input type="hidden" name="kelas_id" value="{{ $selectedKelas->id ?? '' }}">
            <input type="hidden" name="semester" value="{{ $semesterFilter }}">
            
            <div class="table-wrapper">
              <table>
                <thead>
                  <tr>
                    <th>Nama Siswa</th>
                    <th>NIS</th>
                    <th>Nilai Tugas</th>
                    <th>Nilai UTS</th>
                    <th>Nilai UAS</th>
                    <th>Nilai Akhir</th>
                    <th>Predikat</th>
                  </tr>
                </thead>
                <tbody>
                  @if($siswa->count() > 0)
                    @foreach($siswa as $index => $s)
                    @php
                      $nilaiSiswaData = isset($nilaiSiswa[$s->id]) ? $nilaiSiswa[$s->id] : null;
                    @endphp
                    <tr>
                      <td><strong>{{ $s->nama_siswa ?? '-' }}</strong></td>
                      <td>{{ $s->nis ?? '-' }}</td>
                      <td>
                        <input class="input-inline" type="number" min="0" max="100" step="0.1" 
                          name="nilai_tugas[{{ $index }}]" 
                          value="{{ $nilaiSiswaData && $nilaiSiswaData->nilai_tugas ? number_format($nilaiSiswaData->nilai_tugas, 1) : '' }}" 
                          placeholder="0-100" />
                        <input type="hidden" name="siswa_id[]" value="{{ $s->id }}">
                      </td>
                      <td>
                        <input class="input-inline" type="number" min="0" max="100" step="0.1" 
                          name="nilai_uts[{{ $index }}]" 
                          value="{{ $nilaiSiswaData && $nilaiSiswaData->nilai_uts ? number_format($nilaiSiswaData->nilai_uts, 1) : '' }}" 
                          placeholder="0-100" />
                      </td>
                      <td>
                        <input class="input-inline" type="number" min="0" max="100" step="0.1" 
                          name="nilai_uas[{{ $index }}]" 
                          value="{{ $nilaiSiswaData && $nilaiSiswaData->nilai_uas ? number_format($nilaiSiswaData->nilai_uas, 1) : '' }}" 
                          placeholder="0-100" />
                      </td>
                      <td>
                        <span class="badge" style="background: {{ $nilaiSiswaData && $nilaiSiswaData->nilai_akhir ? ($nilaiSiswaData->nilai_akhir >= 80 ? '#4caf50' : ($nilaiSiswaData->nilai_akhir >= 70 ? '#ff9800' : '#c62828')) : '#999' }}; color: white;">
                          {{ $nilaiSiswaData && $nilaiSiswaData->nilai_akhir ? number_format($nilaiSiswaData->nilai_akhir, 1) : '-' }}
                        </span>
                      </td>
                      <td>
                        <span class="badge" style="background: {{ $nilaiSiswaData && $nilaiSiswaData->predikat ? ($nilaiSiswaData->predikat == 'A' ? '#4caf50' : ($nilaiSiswaData->predikat == 'B' ? '#2196f3' : ($nilaiSiswaData->predikat == 'C' ? '#ff9800' : '#c62828'))) : '#999' }}; color: white;">
                          {{ $nilaiSiswaData && $nilaiSiswaData->predikat ? $nilaiSiswaData->predikat : '-' }}
                        </span>
                      </td>
                    </tr>
                    @endforeach
                  @else
                  <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem;">
                      <p>Tidak ada siswa ditemukan</p>
                    </td>
                  </tr>
                  @endif
                </tbody>
              </table>
            </div>
            @if($siswa->count() > 0)
            <div style="margin-top: 24px;">
              <button class="btn" type="submit">
                <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                <span>Simpan Nilai</span>
              </button>
            </div>
            @endif
          </form>
        </section>
        @else
        <section aria-labelledby="nilai-table">
          <div class="card" style="text-align: center; padding: 3rem;">
            <p><i class="fa-solid fa-info-circle"></i> Silakan pilih kelas terlebih dahulu untuk melihat dan input nilai</p>
          </div>
        </section>
        @endif
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>


