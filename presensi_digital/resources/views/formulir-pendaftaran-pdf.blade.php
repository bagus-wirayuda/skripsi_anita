<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formulir Pendaftaran - {{ $ortuRegister->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 30px;
            font-size: 12px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #c62828;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #c62828;
            margin: 0;
            font-size: 22px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        .section {
            margin: 25px 0;
        }
        .section-title {
            background: #c62828;
            color: white;
            padding: 10px 15px;
            margin: 20px 0 15px 0;
            font-size: 14px;
            font-weight: bold;
            border-radius: 4px;
        }
        .form-row {
            display: table;
            width: 100%;
            margin: 12px 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .form-label {
            display: table-cell;
            width: 200px;
            font-weight: bold;
            color: #333;
            vertical-align: top;
            padding-right: 15px;
        }
        .form-value {
            display: table-cell;
            color: #666;
            vertical-align: top;
        }
        .berkas-section {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
            border-left: 4px solid #ff9800;
        }
        .berkas-list {
            list-style: none;
            padding: 0;
            margin: 15px 0 0 0;
        }
        .berkas-list li {
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }
        .berkas-list li:last-child {
            border-bottom: none;
        }
        .berkas-list li:before {
            content: "☐ ";
            margin-right: 8px;
            font-size: 14px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            font-size: 11px;
            color: #999;
        }
        .note {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            font-size: 11px;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>FORMULIR PENDAFTARAN ORANG TUA / WALI</h1>
        <p>SDN 1 UNDUOLO</p>
        <p>Tahun Ajaran 2024/2025</p>
    </div>
    
    <div class="note">
        <strong>Catatan:</strong> Formulir ini telah diisi secara online. Silakan bawa formulir ini beserta 
        dokumen pendukung yang tercantum di bawah untuk proses verifikasi di sekolah.
    </div>

    <div class="section">
        <div class="section-title">DATA ORANG TUA / WALI</div>
        
        <div class="form-row">
            <div class="form-label">Nama Lengkap:</div>
            <div class="form-value">{{ $ortuRegister->name }}</div>
        </div>
        
        <div class="form-row">
            <div class="form-label">Email:</div>
            <div class="form-value">{{ $ortuRegister->email }}</div>
        </div>
        
        <div class="form-row">
            <div class="form-label">NIK (Nomor Induk Kependudukan):</div>
            <div class="form-value">{{ $ortuRegister->nik ?? '-' }}</div>
        </div>
        
        <div class="form-row">
            <div class="form-label">Hubungan dengan Calon Siswa:</div>
            <div class="form-value">{{ $ortuRegister->hubungan }}</div>
        </div>
        
        <div class="form-row">
            <div class="form-label">Pekerjaan:</div>
            <div class="form-value">{{ $ortuRegister->pekerjaan ?? '-' }}</div>
        </div>
        
        <div class="form-row">
            <div class="form-label">Pendidikan Terakhir:</div>
            <div class="form-value">{{ $ortuRegister->pendidikan ?? '-' }}</div>
        </div>
        
        <div class="form-row">
            <div class="form-label">Nomor HP:</div>
            <div class="form-value">{{ $ortuRegister->no_hp }}</div>
        </div>
        
        <div class="form-row">
            <div class="form-label">Alamat Lengkap:</div>
            <div class="form-value">{{ $ortuRegister->alamat }}</div>
        </div>
        
        <div class="form-row">
            <div class="form-label">Tanggal Pendaftaran:</div>
            <div class="form-value">{{ \Carbon\Carbon::parse($ortuRegister->created_at)->format('d F Y H:i') }}</div>
        </div>
    </div>

    <div class="berkas-section">
        <h3 style="margin: 0 0 15px 0; color: #ff9800; font-size: 14px;">
            ✓ BERKAS YANG PERLU DIBAWA
        </h3>
        <p style="margin: 0 0 10px 0; font-size: 12px; color: #333;">
            Silakan lengkapi dan bawa dokumen berikut saat melakukan verifikasi di sekolah:
        </p>
        <ul class="berkas-list">
            <li>Fotokopi Akta Kelahiran calon siswa</li>
            <li>Fotokopi Kartu Keluarga terbaru</li>
            <li>Fotokopi KTP orang tua / wali</li>
            <li>Pas foto calon siswa ukuran 3x4 (2 lembar)</li>
            <li>Formulir kesehatan dari puskesmas (jika ada)</li>
        </ul>
    </div>

    <div class="note" style="margin-top: 30px;">
        <strong>Informasi Penting:</strong><br>
        • Waktu penyerahan berkas: Senin–Jumat pukul 08.00–13.00 WITA di Ruang Tata Usaha<br>
        • Kontak: 0851-1234-5678 (WhatsApp, Jam layanan 08.00–15.00 WITA)<br>
        • Setelah berkas diverifikasi, admin akan membuatkan akun untuk akses sistem
    </div>

    <div class="footer">
        <p><strong>SDN 1 UNDUOLO - Sistem Presensi Digital</strong></p>
        <p>Formulir ini dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i:s') }}</p>
        <p style="margin-top: 10px; font-size: 10px;">
            Formulir ini adalah hasil pengisian online. Pastikan semua data di atas benar sebelum dicetak.
        </p>
    </div>
</body>
</html>

