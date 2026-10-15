<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Perkembangan - {{ $siswa->nama_siswa }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #c62828;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #c62828;
            margin: 0;
            font-size: 20px;
        }
        .header p {
            margin: 5px 0;
            font-size: 11px;
        }
        .info-section {
            margin: 15px 0;
        }
        .info-row {
            display: flex;
            margin: 8px 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            width: 150px;
            color: #333;
        }
        .info-value {
            flex: 1;
            color: #666;
        }
        .section-title {
            background: #c62828;
            color: white;
            padding: 8px;
            margin: 20px 0 10px 0;
            font-size: 14px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background: #f5f5f5;
            font-weight: bold;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin: 15px 0;
        }
        .stat-box {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #c62828;
        }
        .stat-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PERKEMBANGAN SISWA</h1>
        <p>SDN 1 UNDUOLO</p>
        <p>Bulan: {{ \Carbon\Carbon::now()->format('F Y') }}</p>
    </div>
    
    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Nama Siswa:</span>
            <span class="info-value">{{ $siswa->nama_siswa }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">NIS:</span>
            <span class="info-value">{{ $siswa->nis ?? '-' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">NISN:</span>
            <span class="info-value">{{ $siswa->nisn ?? '-' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Kelas:</span>
            <span class="info-value">{{ $siswa->kelas->nama_kelas ?? '-' }}</span>
        </div>
    </div>

    <div class="section-title">NILAI MATA PELAJARAN</div>
    @if($nilaiPerMapel->isNotEmpty())
    <table>
        <thead>
            <tr>
                <th>Mata Pelajaran</th>
                <th>Nilai Akhir</th>
                <th>Predikat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nilaiPerMapel as $nilai)
            <tr>
                <td>{{ $nilai->mapel->nama_mapel ?? '-' }}</td>
                <td>{{ number_format($nilai->nilai_akhir ?? 0, 2) }}</td>
                <td>{{ $nilai->predikat ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p style="text-align: center; color: #666; padding: 20px;">Belum ada data nilai</p>
    @endif

    <div class="section-title">STATISTIK ABSENSI BULAN INI</div>
    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-value">{{ $totalHadir ?? 0 }}</div>
            <div class="stat-label">Hadir</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">{{ $totalSakit ?? 0 }}</div>
            <div class="stat-label">Sakit</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">{{ $totalIzin ?? 0 }}</div>
            <div class="stat-label">Izin</div>
        </div>
        <div class="stat-box">
            <div class="stat-value">{{ $totalAlpha ?? 0 }}</div>
            <div class="stat-label">Alpha</div>
        </div>
    </div>

    <div class="section-title">DETAIL ABSENSI BULAN INI</div>
    @if($presensiBulanIni->isNotEmpty())
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Waktu Masuk</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($presensiBulanIni as $presensi)
            <tr>
                <td>{{ \Carbon\Carbon::parse($presensi->tanggal)->format('d/m/Y') }}</td>
                <td>{{ ucfirst($presensi->status) }}</td>
                <td>{{ $presensi->waktu_masuk ? \Carbon\Carbon::parse($presensi->waktu_masuk)->format('H:i') : '-' }}</td>
                <td>{{ $presensi->keterangan ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p style="text-align: center; color: #666; padding: 20px;">Tidak ada data presensi bulan ini</p>
    @endif

    <div class="footer">
        <p>Laporan ini dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i:s') }}</p>
        <p>SDN 1 UNDUOLO - Sistem Presensi Digital</p>
    </div>
</body>
</html>

