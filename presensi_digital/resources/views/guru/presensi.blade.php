<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Presensi Guru</title>
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
  <body data-page="guru-presensi">
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
          <a class="sidebar__link active" href="{{ route('guru.presensi') }}" data-nav="guru-presensi">
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
          <a class="sidebar__link" href="{{ route('guru.penilaian-harian') }}" data-nav="guru-penilaian-harian">
            <i class="fa-solid fa-star-half-stroke"></i>
            <span>Penilaian Harian</span>
          </a>
        </nav>
      </aside>

      <main class="layout__main">
        <header class="page-header">
          <h1>Presensi {{ $kelasFilter ?? 'Kelas' }}</h1>
          <div style="display: flex; align-items: center; gap: 16px;">
            <button class="btn" type="button">
              <i class="fa-solid fa-rotate" aria-hidden="true"></i>
              <span>Sinkronkan</span>
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
          <h2 id="filter-kelas" class="section-title">Filter Presensi</h2>
          <form method="GET" action="{{ route('guru.presensi') }}">
            <div class="grid grid-3">
              <label class="card">
                <span class="card__title"><i class="fa-solid fa-school"></i> Kelas</span>
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
                <input name="tanggal" class="input-inline" type="date" value="{{ $tanggalFilter ?? \Carbon\Carbon::today()->format('Y-m-d') }}" onchange="this.form.submit()" />
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

        @if($kelasFilter && $mapelGuru->where('kelas_id', $siswa->first()->kelas_id ?? null)->isNotEmpty())
        <section aria-labelledby="detail-kelas">
          <h2 id="detail-kelas" class="section-title">Daftar Siswa - {{ $kelasFilter }}</h2>
          @php
            $selectedKelas = $kelasList->where('nama_kelas', $kelasFilter)->first();
            $mapelForKelas = $mapelGuru->where('kelas_id', $selectedKelas->id ?? null)->first();
          @endphp
          @if($mapelForKelas)
          <p style="margin-bottom: 1rem; color: #666; font-size: 0.9rem;">
            <i class="fa-solid fa-info-circle"></i> 
            Mata Pelajaran: {{ $mapelForKelas->nama_mapel ?? '-' }} | 
            Tanggal: {{ \Carbon\Carbon::parse($tanggalFilter)->format('d F Y') }}
          </p>
          @endif
          
          <form method="POST" action="{{ route('guru.presensi.store') }}">
            @csrf
            <input type="hidden" name="tanggal" value="{{ $tanggalFilter }}">
            <input type="hidden" name="kelas_id" value="{{ $selectedKelas->id ?? '' }}">
            
            <div class="table-wrapper">
              <table>
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Alpa</th>
                    <th>Terlambat</th>
                  </tr>
                </thead>
                <tbody>
                  @if($siswa->count() > 0)
                    @foreach($siswa as $s)
                    @php
                      $presensiSiswa = isset($presensiHariIni[$s->id]) ? $presensiHariIni[$s->id] : null;
                      $statusToday = $presensiSiswa ? $presensiSiswa->status : null;
                    @endphp
                    <tr>
                      <td><strong>{{ $s->nama_siswa ?? '-' }}</strong></td>
                      <td>{{ $s->nis ?? '-' }}</td>
                      <td>
                        <input type="radio" name="status[{{ $loop->index }}]" value="hadir" id="presensi_{{ $s->id }}_hadir" {{ $statusToday == 'hadir' ? 'checked' : '' }} required />
                        <label for="presensi_{{ $s->id }}_hadir"></label>
                        <input type="hidden" name="siswa_id[]" value="{{ $s->id }}">
                      </td>
                      <td>
                        <input type="radio" name="status[{{ $loop->index }}]" value="izin" id="presensi_{{ $s->id }}_izin" {{ $statusToday == 'izin' ? 'checked' : '' }} />
                        <label for="presensi_{{ $s->id }}_izin"></label>
                      </td>
                      <td>
                        <input type="radio" name="status[{{ $loop->index }}]" value="sakit" id="presensi_{{ $s->id }}_sakit" {{ $statusToday == 'sakit' ? 'checked' : '' }} />
                        <label for="presensi_{{ $s->id }}_sakit"></label>
                      </td>
                      <td>
                        <input type="radio" name="status[{{ $loop->index }}]" value="alpha" id="presensi_{{ $s->id }}_alpha" {{ $statusToday == 'alpha' ? 'checked' : '' }} />
                        <label for="presensi_{{ $s->id }}_alpha"></label>
                      </td>
                      <td>
                        <input type="radio" name="status[{{ $loop->index }}]" value="terlambat" id="presensi_{{ $s->id }}_terlambat" {{ $statusToday == 'terlambat' ? 'checked' : '' }} />
                        <label for="presensi_{{ $s->id }}_terlambat"></label>
                      </td>
                    </tr>
                    @endforeach
                  @else
                  <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem;">
                      <p>Pilih kelas terlebih dahulu atau tidak ada siswa di kelas ini</p>
                    </td>
                  </tr>
                  @endif
                </tbody>
              </table>
            </div>
            @if($siswa->count() > 0 && $mapelForKelas)
            <div style="margin-top: 24px;">
              <button class="btn" type="submit">
                <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                <span>Simpan Presensi</span>
              </button>
            </div>
            @endif
          </form>
        </section>
        @else
        <section aria-labelledby="detail-kelas">
          <div class="card" style="text-align: center; padding: 3rem;">
            <p><i class="fa-solid fa-info-circle"></i> Silakan pilih kelas terlebih dahulu untuk melihat daftar siswa</p>
          </div>
        </section>
        @endif
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
  </body>
</html>


