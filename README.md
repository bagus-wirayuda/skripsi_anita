# Sistem Manajemen Sekolah SDN 1 UNDUOLO

Sistem informasi manajemen sekolah yang komprehensif untuk mengelola data siswa, guru, presensi, nilai, dan komunikasi antara sekolah dengan orang tua.

## Fitur Utama

### 1. Modul Admin
- Dashboard dengan statistik sekolah
- Manajemen data siswa (CRUD)
- Manajemen data guru
- Manajemen user dan hak akses
- Data nilai akademik
- Absensi siswa
- Jadwal pelajaran
- Laporan presensi

### 2. Modul Guru
- Dashboard dengan ringkasan kegiatan
- Input presensi siswa
- Input nilai siswa
- Penilaian harian (rating bintang)
- Catatan/Notes untuk siswa
- Laporan statistik kelas

### 3. Modul Kepala Sekolah
- Dashboard dengan ikhtisar sekolah
- Laporan akademik
- Laporan absensi guru
- Laporan absensi siswa
- Evaluasi pembelajaran

### 4. Modul Orang Tua
- Dashboard dengan ringkasan anak
- Data anak lengkap
- Perkembangan anak (nilai dan presensi)
- Catatan dari guru

### 5. Public Pages
- Halaman profil sekolah
- Formulir pendaftaran siswa baru
- Presensi digital (QR Code)

## Persyaratan Sistem

- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi (atau MariaDB 10.2+)
- Web Server (Apache/Nginx)
- Extension PHP: mysqli, pdo_mysql

## Instalasi

### 1. Clone atau Download Project

```bash
git clone [repository-url]
cd anita
```

### 2. Setup Database

1. Buat database MySQL:
```sql
mysql -u root -p
CREATE DATABASE sdn1unduolo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Import database schema:
```bash
mysql -u root -p sdn1unduolo < database.sql
```

Atau jalankan file `database.sql` melalui phpMyAdmin.

### 3. Konfigurasi Database

Edit file `config/database.php` sesuai dengan konfigurasi database Anda:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'sdn1unduolo');
```

### 4. Setup Web Server

#### Menggunakan Laragon/XAMPP:
1. Copy folder project ke `C:\laragon\www\anita` (atau `htdocs` untuk XAMPP)
2. Akses melalui browser: `http://localhost/anita`

#### Menggunakan Nginx/Apache:
1. Setup virtual host mengarah ke folder project
2. Pastikan `mod_rewrite` aktif (untuk Apache)

### 5. Default Login Credentials

Setelah instalasi database, Anda bisa login dengan:

**Admin:**
- Username: `admin`
- Password: `admin123`

**Kepala Sekolah:**
- Username: `kepalasekolah`
- Password: `kepala123`

**Note:** Password di-hash dengan bcrypt. Untuk membuat akun baru atau mengubah password, gunakan fungsi `password_hash()` di PHP atau jalankan query SQL langsung.

## Struktur Database

Database terdiri dari tabel-tabel berikut:

- `users` - Data semua pengguna sistem
- `orangtua` - Data orang tua/wali siswa
- `guru` - Data guru
- `kelas` - Data kelas
- `siswa` - Data siswa
- `jadwal` - Jadwal pelajaran
- `absensi_siswa` - Absensi siswa
- `absensi_guru` - Absensi guru
- `nilai` - Nilai akademik siswa
- `penilaian_harian` - Penilaian harian (rating)
- `notes` - Catatan guru untuk siswa
- `mata_pelajaran` - Daftar mata pelajaran

## Cara Menggunakan

### Untuk Admin:

1. Login dengan akun admin
2. Masuk ke menu "Data Siswa" untuk menambah/mengelola siswa
3. Masuk ke menu "Data Guru" untuk menambah/mengelola guru
4. Masuk ke menu "Data User" untuk membuat akun user baru
5. Setelah data guru dan siswa ada, bisa setting jadwal di menu "Jadwal Pelajaran"

### Untuk Guru:

1. Login dengan akun guru
2. Pilih kelas yang diajar di menu "Presensi"
3. Input presensi siswa setiap hari
4. Input nilai siswa di menu "Nilai"
5. Berikan catatan untuk siswa di menu "Notes"

### Untuk Orang Tua:

1. Daftar melalui halaman "Pendaftaran" di public website
2. Admin akan approve pendaftaran dan membuat akun
3. Login dan lihat perkembangan anak di dashboard
4. Lihat presensi, nilai, dan catatan dari guru

## File Structure

```
anita/
├── admin/              # Modul admin
├── guru/               # Modul guru
├── kepalasekolah/      # Modul kepala sekolah
├── orangtua/           # Modul orang tua
├── assets/             # CSS, JS, Images
├── config/             # Konfigurasi database & auth
├── includes/           # Include files (sidebar, etc)
├── database.sql        # Database schema
├── login.php           # Halaman login
├── register.php        # Pendaftaran orang tua
├── index.php           # Homepage profil sekolah
└── README.md           # Dokumentasi
```

## Fitur Keamanan

- Password di-hash dengan bcrypt
- Session management untuk autentikasi
- Role-based access control (RBAC)
- SQL injection protection dengan prepared statements
- XSS protection dengan htmlspecialchars

## Development Notes

### Menambah Fitur Baru:

1. Buat file PHP baru di folder modul terkait
2. Include `config/auth.php` dan `config/database.php`
3. Gunakan helper functions dari `config/database.php`:
   - `fetchOne($sql)` - Ambil satu row
   - `fetchAll($sql)` - Ambil semua rows
   - `query($sql)` - Execute query
   - `escape($string)` - Escape string

### Custom Query:

```php
require_once __DIR__ . '/../config/database.php';

// Fetch single row
$user = fetchOne("SELECT * FROM users WHERE id = 1");

// Fetch multiple rows
$students = fetchAll("SELECT * FROM siswa WHERE status = 'aktif'");

// Execute query
query("UPDATE siswa SET status = 'aktif' WHERE id = 1");

// Escape input
$name = escape($_POST['name']);
```

## Troubleshooting

### Database Connection Error:
- Pastikan MySQL service berjalan
- Cek kredensial di `config/database.php`
- Pastikan database sudah dibuat dan di-import

### Session Issues:
- Pastikan `session_start()` dipanggil di `config/auth.php`
- Cek file permission pada folder session
- Pastikan cookies enabled di browser

### 404 Error pada Link:
- Pastikan semua file `.html` sudah diubah menjadi `.php`
- Cek BASE_URL di `config/database.php`
- Pastikan web server configured dengan benar

## Todo / Development Roadmap

- [x] Database structure
- [x] Authentication system
- [x] Admin dashboard
- [x] Admin data siswa
- [x] Guru presensi
- [x] Orangtua dashboard
- [ ] CRUD lengkap untuk semua modul
- [ ] Export laporan ke PDF/Excel
- [ ] Notifikasi sistem
- [ ] Upload foto profil
- [ ] QR Code generator untuk presensi
- [ ] Mobile responsive improvements

## Kontribusi

Untuk kontribusi, silakan buat issue atau pull request.

## License

Copyright © 2025 SDN 1 UNDUOLO. All rights reserved.

## Support

Untuk bantuan atau pertanyaan:
- Email: admin@sdn1unduolo.sch.id
- Phone: 0851-1234-5678

---

**Selamat menggunakan Sistem Manajemen Sekolah SDN 1 UNDUOLO!** 🎓


