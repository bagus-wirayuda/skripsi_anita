<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kartu Siswa - {{ $siswa->nama_siswa }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .card {
            border: 2px solid #c62828;
            border-radius: 10px;
            padding: 20px;
            max-width: 400px;
            margin: 0 auto;
            background: #fff;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #c62828;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #c62828;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        .photo {
            text-align: center;
            margin: 20px 0;
        }
        .photo-placeholder {
            width: 120px;
            height: 150px;
            border: 2px solid #ddd;
            display: inline-block;
            background: #f5f5f5;
            line-height: 150px;
            color: #999;
        }
        .info {
            margin: 15px 0;
        }
        .info-row {
            display: flex;
            margin: 8px 0;
        }
        .info-label {
            font-weight: bold;
            width: 120px;
            color: #333;
        }
        .info-value {
            flex: 1;
            color: #666;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #999;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
        .qr-placeholder {
            width: 100px;
            height: 100px;
            border: 2px solid #ddd;
            display: inline-block;
            background: #f5f5f5;
            line-height: 100px;
            color: #999;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h1>KARTU SISWA</h1>
            <p>SDN 1 UNDUOLO</p>
            <p>Tahun Ajaran 2024/2025</p>
        </div>
        
        <div class="photo">
            <div class="photo-placeholder">Foto</div>
        </div>
        
        <div class="info">
            <div class="info-row">
                <span class="info-label">Nama:</span>
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
            <div class="info-row">
                <span class="info-label">Tempat, Tgl Lahir:</span>
                <span class="info-value">{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d/m/Y') : '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Jenis Kelamin:</span>
                <span class="info-value">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : ($siswa->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Alamat:</span>
                <span class="info-value">{{ Str::limit($siswa->alamat ?? '-', 50) }}</span>
            </div>
        </div>
        
        <div class="qr-code">
            <div class="qr-placeholder">QR Code<br>{{ $siswa->qr_code ?? '-' }}</div>
        </div>
        
        <div class="footer">
            <p>Kartu ini berlaku selama menjadi siswa di SDN 1 UNDUOLO</p>
            <p>Dicetak: {{ \Carbon\Carbon::now()->format('d F Y H:i') }}</p>
        </div>
    </div>
</body>
</html>

