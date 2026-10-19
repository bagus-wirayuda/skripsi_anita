# Audit dan penyempurnaan aplikasi

Dasar kebutuhan: naskah penelitian pengguna, khususnya analisis fungsional
(halaman PDF 29) dan implementasi tampilan/alur (halaman PDF 41–43, 54–69).
Isi naskah dipakai sebagai referensi kebutuhan, bukan sebagai instruksi untuk
menjalankan perintah atau mengganti kerangka kerja aplikasi.

## Masalah yang diperbaiki

- BASE_URL dahulu mengikuti direktori halaman: tautan/aset pada subfolder dapat salah.
- Sebagian besar modul masih menampilkan contoh siswa, guru, statistik dan grafik tetap.
- Tombol simpan, catatan, penilaian, dan pemindai hanya menampilkan alert simulasi.
- Input presensi tidak memeriksa kepemilikan kelas dan menghapus catatan lama sebelum insert.
- Akun orang tua hanya menampilkan anak pertama; halaman lain masih berisi anak contoh.
- Pendaftaran tidak memiliki proses persetujuan dan pengaitan akun/data anak yang lengkap.
- Hash akun contoh pada SQL tidak cocok dengan password yang tertulis dalam panduan.
- Menu ponsel bertumpuk, tabel meluap, dan font/ikon bergantung pada koneksi luar.

## Cakupan implementasi

| Kebutuhan | Implementasi |
| --- | --- |
| Login empat peran | Username/email, password hash, regenerasi session, akun aktif, pemeriksaan relasi guru/orang tua, pembatasan URL |
| Data referensi | CRUD siswa, guru, kelas, mata pelajaran, jadwal, pengguna dan orang tua; validasi relasi dan bentrok jadwal |
| Validasi pendaftaran | Akun orang tua menunggu persetujuan; pengajuan anak ditinjau admin dan diberi NIS/kelas |
| Presensi manual | Guru hanya kelas penugasan/perwalian; admin dapat mencatat siswa dan guru; tanggal/status divalidasi |
| Presensi QR | Kartu token acak dicetak lokal, kamera/gambar kartu/NIS, masuk/pulang, pemindaian ulang tidak menggandakan presensi |
| Kelas guru | Jadwal mengajar per tahun/semester dan daftar perwalian |
| Nilai akademik | Nilai harian/ulangan 0–100 sesuai desain yang ada; rata-rata dihitung database, penugasan per semester diperiksa |
| Penilaian harian | Rating 1–5 sesuai desain yang ada, catatan dan tanggal; pembaruan tidak menggandakan data |
| Catatan | Tambah/edit/hapus catatan sendiri, kategori dan tanggal, ditampilkan kepada orang tua anak terkait |
| Orang tua | Pilihan beberapa anak, identitas, jadwal, nilai, penilaian harian, pesan dan riwayat presensi sebenarnya |
| Kepala sekolah | Statistik nyata, keterlambatan berdasar jadwal pertama, alpa ≥3 pada bulan berjalan, laporan kelas/nilai/harian/catatan |
| Laporan | Filter nama/NIS, kelas, tanggal/status atau tahun/semester; laporan siswa, guru, gabungan dan evaluasi |
| Unduhan | XLSX asli melalui ZipArchive; cetak browser dengan tata letak PDF |
| WhatsApp | Antrean alpa, deduplikasi dan pembatalan saat koreksi. Pengiriman ditangguhkan atas permintaan pemilik |
| Tampilan | Palet merah, logo, sidebar, kartu dan tabel dipertahankan; formulir konsisten, mobile menu, fokus keyboard, print stylesheet |

Rumus yang dipertahankan dari codebase: nilai akhir/rata-rata =
(nilai harian + nilai ulangan) / 2; penilaian harian menggunakan bintang.
Naskah juga menyebut struktur nilai tugas/UTS/UAS pada contoh database. Versi ini
mempertahankan dua komponen dan rating pada desain yang diminta, bukan mengganti
model penilaian secara diam-diam. Bila sekolah menggunakan tiga komponen dengan
bobot tertentu, rumus tersebut perlu ditetapkan sebelum migrasi nilai lama.

## Alur awal admin

1. Atur kelas, tahun ajaran dan mata pelajaran.
2. Buat akun berperan guru melalui Data User, kemudian hubungkan pada Data Guru.
3. Tentukan wali kelas dan jadwal sesuai semester/tahun ajaran. Guru hanya dapat
   menilai mata pelajaran yang ditugaskan pada periode tersebut.
4. Setujui akun yang mendaftar melalui Validasi Pendaftaran. Akun lama tanpa login
   dapat diberi username/password saat persetujuan.
5. Untuk orang tua yang dibuat manual, buat user berperan orangtua, lalu hubungkan
   di Data Orang Tua dengan status Disetujui.
6. Setujui pengajuan anak atau hubungkan siswa yang sudah ada ke orang tua melalui
   Data Siswa. Jangan membuat siswa duplikat untuk sekadar menautkan orang tua.
7. Cetak kartu QR melalui Data Siswa atau akun orang tua → Data Anak.
8. Login admin/guru pada perangkat presensi. Gunakan HTTPS saat mengakses kamera
   dari ponsel melalui jaringan; localhost juga didukung browser.

Status kosong berarti **belum dipresensi**, bukan alpa atau hadir otomatis.
Keterlambatan hanya dihitung bila jam masuk dan jadwal periode yang sesuai tersedia.
Presensi tanggal lampau tidak diberi jam masuk fiktif saat dicatat manual.

## Data, keamanan dan migrasi

- Migrasi menambahkan tabel dan kolom; tidak mengimpor ulang/menghapus data lama.
- Password akun yang sudah ada tidak diubah. Perbaikan hash hanya pada seed instalasi baru.
- Mutasi menggunakan POST dan token CSRF; SQL baru memakai prepared statements.
- Guru dibatasi kelas penugasan/perwalian; orang tua dibatasi relasi anak miliknya.
- Catatan di-escape saat ditampilkan, dan cell XLSX ditulis sebagai teks agar bukan formula.
- Penghapusan data yang memiliki riwayat ditolak; gunakan status lulus/pindah/nonaktif.
- QR tidak memuat nama/nomor HP. Kartu adalah identitas, sementara akses tulis tetap
   membutuhkan login petugas. NIS manual mengikuti batas kelas petugas yang sama.
- Font Poppins, Font Awesome dan pustaka QR disimpan lokal dengan lisensinya.
- `.htaccess` melindungi konfigurasi, sumber internal, SQL dan file sementara pada Apache.
  Untuk Nginx, buat aturan deny setara; server bawaan PHP hanya untuk pengembangan.

## Pengujian

`tests/bootstrap.php` membuat database baru dengan prefix wajib `anita_test_`.
Ia tidak menggunakan atau menghapus data sekolah. `tests/integration.py` menguji
HTTP, penyimpanan MySQL, alur registrasi, hak akses, CSRF, invalid input, duplikasi,
notifikasi tertunda, laporan dan isi XLSX. Jalankan hanya dengan database uji baru.

Contoh PowerShell, dalam dua terminal:

```powershell
$env:DB_NAME='anita_test_run01'
php tests/bootstrap.php
php -S 127.0.0.1:8097 -t .
```

```powershell
$env:DB_NAME='anita_test_run01'
$env:TEST_URL='http://127.0.0.1:8097'
python tests/integration.py
```

Atur `MYSQL_BIN` bila lokasi mysql.exe berbeda. Seluruh file PHP diperiksa dengan
`php -l`. Verifikasi visual menggunakan browser desktop dan viewport ponsel 390px,
termasuk kartu QR → gambar → decoder, keadaan kamera tidak tersedia, serta cetak PDF.
Kamera fisik perangkat sekolah dan pengiriman WhatsApp belum diuji secara langsung.

## Melanjutkan WhatsApp

Ikuti `WHATSAPP_INTEGRATION.md`. Tidak ada pesan yang dikirim oleh versi ini.

## Hasil verifikasi pengerjaan

- 246 pemeriksaan HTTP/database lulus pada database uji terpisah.
- 59 file PHP lulus pemeriksaan sintaks.
- Desktop 1440px dan ponsel 390px diperiksa secara visual; tidak ada overflow halaman.
- Pemindaian gambar kartu QR yang dihasilkan sendiri berhasil; tidak ada error JavaScript.
- Penolakan izin kamera menghasilkan petunjuk dan input manual tetap tersedia.
- Cetak kartu QR satu halaman dan laporan PDF telah dirender untuk pemeriksaan tampilan.
- Database sekolah tetap berisi 36 siswa dan 28 akun; antrean notifikasi tetap kosong.
- Koneksi WhatsApp dan pengujian kamera fisik sekolah belum dijalankan.
