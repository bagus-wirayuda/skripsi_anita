<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SDN 1 UNDUOLO - Admin Dashboard</title>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
      .grid.grid-4 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
      }
      @media (min-width: 768px) {
        .grid.grid-4 {
          grid-template-columns: repeat(4, 1fr);
        }
      }
      @media (min-width: 1024px) {
        .grid.grid-4 {
          grid-template-columns: repeat(5, 1fr);
        }
      }
      .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: all 0.2s ease;
      }
      .chart-container {
        position: relative;
        height: 300px;
        margin: 1rem 0;
      }
      .chart-container-large {
        position: relative;
        height: 400px;
        margin: 1rem 0;
      }
      .stats-overview {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
      }
      .stat-card {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      }
      .stat-card__value {
        font-size: 2rem;
        font-weight: bold;
        color: #c62828;
        margin: 0.5rem 0;
      }
      .stat-card__label {
        font-size: 0.875rem;
        color: #666;
        margin: 0;
      }
    </style>
  </head>
  <body data-page="admin-dashboard">
    <div class="layout">
      <!-- Sidebar Navigation -->
      <aside class="sidebar">
        <div class="sidebar__brand">
          <img src="{{ asset('assets/img/logo.png') }}" alt="Logo SDN 1 UNDUOLO" width="40" height="40" />
          <span>SDN 1 UNDUOLO</span>
        </div>
        <nav class="sidebar__nav">
          <a class="sidebar__link active" href="{{ route('admin.dashboard') }}" data-nav="admin-dashboard">
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
          <a class="sidebar__link" href="{{ route('admin.data-siswa') }}" data-nav="admin-data-siswa">
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

      <!-- Main Dashboard Content -->
      <main class="layout__main">
        <header class="page-header">
          <h1>Dashboard Admin</h1>
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

        <!-- Quick Access Shortcuts -->
        <section aria-labelledby="quick-access">
          <h2 id="quick-access" class="section-title">Pintasan Cepat</h2>
          <div class="grid grid-4" style="margin-bottom: 2rem;">
            <a href="{{ route('admin.pendaftaran') }}" class="card" style="text-decoration: none; color: inherit; display: block;">
              <p class="card__title"><i class="fa-solid fa-user-plus"></i> Pendaftaran</p>
              <p style="margin: 0.5rem 0; font-size: 0.875rem; color: #666;">
                @if($pendingPendaftaran > 0)
                  <span style="color: #e74c3c; font-weight: bold;">{{ $pendingPendaftaran }} pending</span>
                @else
                  Kelola pendaftaran baru
                @endif
              </p>
            </a>
            <a href="{{ route('admin.absensi-siswa') }}" class="card" style="text-decoration: none; color: inherit; display: block;">
              <p class="card__title"><i class="fa-solid fa-clipboard-user"></i> Presensi</p>
              <p style="margin: 0.5rem 0; font-size: 0.875rem; color: #666;">
                {{ $presensiHariIni }} presensi hari ini
              </p>
            </a>
            <a href="{{ route('admin.data-guru') }}" class="card" style="text-decoration: none; color: inherit; display: block;">
              <p class="card__title"><i class="fa-solid fa-person-chalkboard"></i> Guru</p>
              <p style="margin: 0.5rem 0; font-size: 0.875rem; color: #666;">
                {{ $totalGuru }} guru terdaftar
              </p>
            </a>
            <a href="{{ route('admin.data-siswa') }}" class="card" style="text-decoration: none; color: inherit; display: block;">
              <p class="card__title"><i class="fa-solid fa-children"></i> Siswa</p>
              <p style="margin: 0.5rem 0; font-size: 0.875rem; color: #666;">
                {{ $totalSiswa }} siswa aktif
              </p>
            </a>
            <a href="{{ route('admin.kelas.index') }}" class="card" style="text-decoration: none; color: inherit; display: block;">
              <p class="card__title"><i class="fa-solid fa-door-open"></i> Kelas</p>
              <p style="margin: 0.5rem 0; font-size: 0.875rem; color: #666;">
                {{ $totalKelas }} kelas tersedia
              </p>
            </a>
            <a href="{{ route('admin.mapel.index') }}" class="card" style="text-decoration: none; color: inherit; display: block;">
              <p class="card__title"><i class="fa-solid fa-book"></i> Mapel</p>
              <p style="margin: 0.5rem 0; font-size: 0.875rem; color: #666;">
                {{ $totalMapel }} mata pelajaran
              </p>
            </a>
            <a href="{{ route('admin.data-nilai') }}" class="card" style="text-decoration: none; color: inherit; display: block;">
              <p class="card__title"><i class="fa-solid fa-chart-column"></i> Nilai</p>
              <p style="margin: 0.5rem 0; font-size: 0.875rem; color: #666;">
                Rata-rata: {{ $rataRataNilai }}
              </p>
            </a>
            <a href="{{ route('admin.data-user') }}" class="card" style="text-decoration: none; color: inherit; display: block;">
              <p class="card__title"><i class="fa-solid fa-users-gear"></i> User</p>
              <p style="margin: 0.5rem 0; font-size: 0.875rem; color: #666;">
                {{ $totalUser }} total pengguna
              </p>
            </a>
            <a href="{{ route('admin.laporan') }}" class="card" style="text-decoration: none; color: inherit; display: block;">
              <p class="card__title"><i class="fa-solid fa-file-lines"></i> Laporan</p>
              <p style="margin: 0.5rem 0; font-size: 0.875rem; color: #666;">
                Lihat laporan presensi
              </p>
            </a>
          </div>
        </section>

        <!-- Overview Statistics -->
        <section aria-labelledby="overview-stats">
          <h2 id="overview-stats" class="section-title">Ringkasan Data</h2>
          <div class="stats-overview">
            <div class="stat-card">
              <p class="stat-card__label"><i class="fa-solid fa-user-graduate"></i> Total Siswa</p>
              <p class="stat-card__value">{{ number_format($totalSiswa) }}</p>
            </div>
            <div class="stat-card">
              <p class="stat-card__label"><i class="fa-solid fa-person-chalkboard"></i> Total Guru</p>
              <p class="stat-card__value">{{ number_format($totalGuru) }}</p>
            </div>
            <div class="stat-card">
              <p class="stat-card__label"><i class="fa-solid fa-door-open"></i> Total Kelas</p>
              <p class="stat-card__value">{{ number_format($totalKelas) }}</p>
            </div>
            <div class="stat-card">
              <p class="stat-card__label"><i class="fa-solid fa-check-circle"></i> Kehadiran Rata-rata</p>
              <p class="stat-card__value">{{ number_format($avgKehadiran, 1) }}%</p>
            </div>
            <div class="stat-card">
              <p class="stat-card__label"><i class="fa-solid fa-user-clock"></i> Pendaftaran Pending</p>
              <p class="stat-card__value">{{ number_format($pendingPendaftaran) }}</p>
            </div>
          </div>
        </section>

        <!-- Charts Section -->
        <section aria-labelledby="charts-section">
          <div class="grid grid-2">
            <!-- Distribusi Siswa -->
            <article class="card">
              <h3 class="card__title"><i class="fa-solid fa-chart-pie"></i> Distribusi Siswa</h3>
              <div class="chart-container">
                <canvas id="chartSiswa"></canvas>
              </div>
            </article>

            <!-- Distribusi User -->
            <article class="card">
              <h3 class="card__title"><i class="fa-solid fa-users"></i> Distribusi User</h3>
              <div class="chart-container">
                <canvas id="chartUser"></canvas>
              </div>
            </article>

            <!-- Statistik Presensi -->
            <article class="card">
              <h3 class="card__title"><i class="fa-solid fa-clipboard-check"></i> Statistik Presensi Bulan Ini</h3>
              <div class="chart-container">
                <canvas id="chartPresensi"></canvas>
              </div>
            </article>

            <!-- Persentase Kehadiran -->
            <article class="card">
              <h3 class="card__title"><i class="fa-solid fa-percent"></i> Persentase Kehadiran</h3>
              <div class="chart-container">
                <canvas id="chartKehadiran"></canvas>
              </div>
            </article>
          </div>

          <!-- Tren Presensi -->
          <article class="card" style="margin-top: 2rem;">
            <h3 class="card__title"><i class="fa-solid fa-chart-line"></i> Tren Presensi</h3>
            <div class="chart-container-large">
              <canvas id="chartTrenPresensi"></canvas>
            </div>
          </article>
        </section>

        <section aria-labelledby="admin-reminders">
          <h2 id="admin-reminders" class="section-title">Agenda Penting Minggu Ini</h2>
          <div class="grid grid-2">
            @foreach($agenda as $item)
            <article class="card">
              <p class="card__title"><i class="{{ $item['icon'] }}"></i> {{ $item['title'] }}</p>
              <p>{{ $item['description'] }}</p>
            </article>
            @endforeach
          </div>
        </section>
      </main>
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
      // Chart Colors
      const colors = {
        primary: '#c62828',
        secondary: '#ef9a9a',
        success: '#4caf50',
        warning: '#ff9800',
        danger: '#f44336',
        info: '#2196f3',
        light: '#f5f5f5'
      };

      // Distribusi Siswa (Pie Chart)
      const ctxSiswa = document.getElementById('chartSiswa');
      if (ctxSiswa) {
        new Chart(ctxSiswa, {
          type: 'pie',
          data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
              data: [{{ $siswaLaki }}, {{ $siswaPerempuan }}],
              backgroundColor: [colors.info, colors.secondary],
              borderWidth: 2,
              borderColor: '#fff'
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'bottom'
              },
              tooltip: {
                callbacks: {
                  label: function(context) {
                    const total = {{ $totalSiswa }};
                    const value = context.parsed;
                    const percentage = ((value / total) * 100).toFixed(1);
                    return context.label + ': ' + value + ' (' + percentage + '%)';
                  }
                }
              }
            }
          }
        });
      }

      // Distribusi User (Doughnut Chart)
      const ctxUser = document.getElementById('chartUser');
      if (ctxUser) {
        new Chart(ctxUser, {
          type: 'doughnut',
          data: {
            labels: ['Admin', 'Guru', 'Orang Tua'],
            datasets: [{
              data: [{{ $countAdmin }}, {{ $countGuru }}, {{ $countOrtu }}],
              backgroundColor: [colors.primary, colors.success, colors.warning],
              borderWidth: 2,
              borderColor: '#fff'
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'bottom'
              },
              tooltip: {
                callbacks: {
                  label: function(context) {
                    const total = {{ $totalUser }};
                    const value = context.parsed;
                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                    return context.label + ': ' + value + ' (' + percentage + '%)';
                  }
                }
              }
            }
          }
        });
      }

      // Statistik Presensi (Bar Chart)
      const ctxPresensi = document.getElementById('chartPresensi');
      if (ctxPresensi) {
        new Chart(ctxPresensi, {
          type: 'bar',
          data: {
            labels: ['Hadir', 'Izin', 'Sakit', 'Alpha', 'Terlambat'],
            datasets: [{
              label: 'Jumlah Presensi',
              data: [
                {{ $hadirBulanIni }},
                {{ $presensiIzin }},
                {{ $presensiSakit }},
                {{ $presensiAlpha }},
                {{ $presensiTerlambat }}
              ],
              backgroundColor: [
                colors.success,
                colors.info,
                colors.warning,
                colors.danger,
                colors.secondary
              ],
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  stepSize: 1
                }
              }
            }
          }
        });
      }

      // Persentase Kehadiran (Doughnut Chart)
      const ctxKehadiran = document.getElementById('chartKehadiran');
      if (ctxKehadiran) {
        const totalPresensiBulan = {{ $presensiBulanIni }};
        const hadirBulan = {{ $hadirBulanIni }};
        const tidakHadir = totalPresensiBulan - hadirBulan;
        
        new Chart(ctxKehadiran, {
          type: 'doughnut',
          data: {
            labels: ['Hadir', 'Tidak Hadir'],
            datasets: [{
              data: [hadirBulan, tidakHadir],
              backgroundColor: [colors.success, colors.danger],
              borderWidth: 2,
              borderColor: '#fff'
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'bottom'
              },
              tooltip: {
                callbacks: {
                  label: function(context) {
                    const total = totalPresensiBulan;
                    const value = context.parsed;
                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                    return context.label + ': ' + value + ' (' + percentage + '%)';
                  }
                }
              }
            }
          }
        });
      }

      // Tren Presensi (Line Chart)
      const ctxTren = document.getElementById('chartTrenPresensi');
      if (ctxTren) {
        new Chart(ctxTren, {
          type: 'line',
          data: {
            labels: ['Hari Ini', 'Minggu Ini', 'Bulan Ini'],
            datasets: [
              {
                label: 'Total Presensi',
                data: [{{ $presensiHariIni }}, {{ $presensiMingguIni }}, {{ $presensiBulanIni }}],
                borderColor: colors.primary,
                backgroundColor: colors.secondary + '40',
                tension: 0.4,
                fill: true
              },
              {
                label: 'Hadir',
                data: [{{ $hadirHariIni }}, {{ $hadirMingguIni }}, {{ $hadirBulanIni }}],
                borderColor: colors.success,
                backgroundColor: colors.success + '40',
                tension: 0.4,
                fill: true
              },
              {
                label: 'Persentase (%)',
                data: [{{ $persentaseHariIni }}, {{ $persentaseMingguIni }}, {{ $persentaseBulanIni }}],
                borderColor: colors.info,
                backgroundColor: colors.info + '40',
                tension: 0.4,
                fill: true,
                yAxisID: 'y1'
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
              mode: 'index',
              intersect: false,
            },
            plugins: {
              legend: {
                position: 'top'
              }
            },
            scales: {
              y: {
                type: 'linear',
                display: true,
                position: 'left',
                beginAtZero: true
              },
              y1: {
                type: 'linear',
                display: true,
                position: 'right',
                beginAtZero: true,
                max: 100,
                grid: {
                  drawOnChartArea: false
                }
              }
            }
          }
        });
      }
    </script>
  </body>
</html>


