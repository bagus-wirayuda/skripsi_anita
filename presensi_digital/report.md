# LAPORAN SISTEM PRESENSI DIGITAL SDN 1 UNDUOLO

## 1. PENDAHULUAN

Sistem Presensi Digital SDN 1 UNDUOLO adalah sebuah aplikasi web berbasis Laravel yang dirancang untuk mengelola aktivitas akademik sekolah dasar secara terintegrasi. Sistem ini memfasilitasi manajemen presensi siswa, penilaian akademik, pengelolaan data siswa dan guru, serta komunikasi antara sekolah, guru, dan orang tua siswa.

### 1.1 Tujuan Sistem
- Mengotomatisasi proses presensi siswa berbasis QR Code
- Memudahkan guru dalam mengelola penilaian harian dan nilai akademik
- Memberikan akses transparan bagi orang tua untuk memantau perkembangan anak
- Meningkatkan efisiensi administrasi sekolah
- Menyediakan laporan komprehensif untuk evaluasi pembelajaran

---

## 2. TEKNOLOGI YANG DIGUNAKAN

### 2.1 Backend Framework
- **Laravel 10.10**: Framework PHP modern untuk pengembangan aplikasi web
- **PHP 8.1+**: Bahasa pemrograman server-side
- **MySQL/MariaDB**: Database management system untuk penyimpanan data

### 2.2 Frontend Technologies
- **Blade Template Engine**: Template engine Laravel untuk rendering views
- **HTML5 & CSS3**: Markup dan styling
- **JavaScript (Vanilla)**: Interaktivitas client-side
- **Chart.js**: Library untuk visualisasi data dalam bentuk chart dan grafik
- **Font Awesome**: Icon library untuk UI

### 2.3 Third-Party Packages
- **barryvdh/laravel-dompdf (v3.1)**: Library untuk generate PDF (kartu siswa, laporan)
- **guzzlehttp/guzzle (v7.2)**: HTTP client untuk komunikasi dengan API eksternal
- **laravel/sanctum (v3.3)**: Authentication system
- **Carbon**: Library untuk manipulasi tanggal dan waktu

### 2.4 Development Tools
- **Vite**: Build tool untuk frontend assets
- **Composer**: Dependency manager untuk PHP
- **NPM**: Package manager untuk JavaScript dependencies

### 2.5 Arsitektur Sistem
- **MVC (Model-View-Controller)**: Pola arsitektur yang digunakan
- **RESTful Routing**: Struktur routing yang mengikuti prinsip REST
- **Middleware-based Authentication**: Sistem autentikasi berbasis middleware
- **Role-Based Access Control (RBAC)**: Kontrol akses berdasarkan peran pengguna

---

## 3. STRUKTUR DATABASE

Sistem menggunakan struktur database relasional dengan tabel-tabel utama sebagai berikut:

### 3.1 Tabel User Management
- **users**: Menyimpan data autentikasi semua pengguna (admin, kepsek, guru, ortu)
- **admin**: Data tambahan untuk admin
- **kepsek**: Data tambahan untuk kepala sekolah
- **guru**: Data tambahan untuk guru
- **ortu**: Data tambahan untuk orang tua/wali

### 3.2 Tabel Akademik
- **kelas**: Data kelas (1A-6B)
- **siswa**: Data siswa
- **mapel**: Mata pelajaran dan jadwal mengajar
- **presensi**: Catatan kehadiran siswa
- **nilai**: Nilai akademik (tugas, UTS, UAS)
- **penilaian_harian**: Penilaian harian (kuis, tugas, praktik, dll)

### 3.3 Tabel Pendaftaran
- **ortu_register**: Data pendaftaran orang tua baru yang menunggu persetujuan

### 3.4 Relasi Database
- Setiap user memiliki relasi ke tabel spesifik sesuai role (admin, kepsek, guru, ortu)
- Siswa terhubung dengan kelas dan orang tua
- Presensi terhubung dengan siswa, guru, mapel, dan orang tua
- Nilai dan penilaian harian terhubung dengan siswa dan mapel
- Mapel terhubung dengan guru dan kelas

---

## 4. ROLE DAN FUNGSI

Sistem memiliki 4 role utama dengan hak akses dan fungsi yang berbeda:

### 4.1 ADMIN
**Fungsi Utama:**
- Mengelola seluruh data sistem (siswa, guru, kelas, mata pelajaran)
- Menyetujui atau menolak pendaftaran orang tua baru
- Melihat dan mengelola presensi semua siswa
- Melihat dan mengelola nilai semua siswa
- Mengelola data user (admin, guru, kepala sekolah)
- Melihat laporan komprehensif sekolah
- Mengatur jadwal pelajaran

**Fitur Khusus:**
- Dashboard dengan statistik lengkap (total siswa, guru, kelas, presensi, dll)
- Visualisasi data dengan chart (Pie Chart, Doughnut Chart, Bar Chart, Line Chart)
- Quick access shortcuts ke semua modul
- Manajemen pendaftaran dengan approval/rejection
- CRUD lengkap untuk siswa, guru, kelas, dan mata pelajaran

**Keterkaitan dengan Role Lain:**
- **Dengan Guru**: Admin dapat melihat semua data yang diinput guru (presensi, nilai, penilaian harian)
- **Dengan Orang Tua**: Admin menyetujui pendaftaran orang tua baru dan dapat melihat data anak mereka
- **Dengan Kepala Sekolah**: Admin menyediakan data untuk laporan yang dibutuhkan kepala sekolah

### 4.2 GURU
**Fungsi Utama:**
- Menginput presensi siswa untuk mata pelajaran yang diajarkan
- Menginput nilai akademik (tugas, UTS, UAS) untuk mata pelajaran yang diajarkan
- Menginput penilaian harian (kuis, tugas, praktik, ulangan harian, proyek, portofolio)
- Melihat jadwal mengajar pribadi
- Mengelola kelas binaan (jika sebagai wali kelas)
- Melihat laporan kelas yang diajar

**Fitur Khusus:**
- **Dashboard**: Menampilkan kelas yang akan diajar hari ini
- **Kelas Saya**: Menampilkan jadwal mengajar, kelas terdekat, dan jadwal mingguan
- **Perwalian**: Untuk wali kelas, menampilkan data siswa di kelas binaan dan jadwal pelajaran kelas tersebut
- **Presensi**: Input presensi per mata pelajaran dengan filter kelas dan tanggal
- **Nilai**: Input nilai per mata pelajaran dengan filter kelas dan semester
- **Penilaian Harian**: Input penilaian harian per siswa (satu per satu) dengan filter kelas, tanggal, mata pelajaran, dan siswa

**Keterkaitan dengan Role Lain:**
- **Dengan Admin**: Data yang diinput guru dapat dilihat dan dikelola oleh admin
- **Dengan Orang Tua**: Presensi, nilai, dan penilaian harian yang diinput guru dapat dilihat oleh orang tua siswa
- **Dengan Siswa**: Guru mengelola data akademik siswa yang diajar

### 4.3 ORANG TUA (ORTU)
**Fungsi Utama:**
- Melihat data anak (siswa)
- Melihat presensi anak
- Melihat nilai akademik anak
- Melihat penilaian harian anak
- Melihat catatan dari guru
- Mencetak kartu siswa
- Mencetak laporan perkembangan anak

**Fitur Khusus:**
- **Dashboard**: Ringkasan informasi anak (presensi, nilai, catatan terbaru)
- **Data Anak**: Detail informasi anak
- **Perkembangan**: Grafik perkembangan akademik anak
- **Penilaian Harian**: Daftar penilaian harian dengan filter (anak, tanggal, mata pelajaran, jenis penilaian)
- **Notes**: Catatan dari guru untuk anak
- **Cetak Kartu**: Generate PDF kartu siswa
- **Cetak Laporan**: Generate PDF laporan perkembangan

**Keterkaitan dengan Role Lain:**
- **Dengan Admin**: Orang tua harus mendaftar dan disetujui admin sebelum dapat mengakses sistem
- **Dengan Guru**: Orang tua melihat data yang diinput guru (presensi, nilai, penilaian harian, catatan)
- **Dengan Siswa**: Orang tua mewakili siswa dalam sistem (siswa tidak memiliki akun sendiri)

### 4.4 KEPALA SEKOLAH (KEPSEK)
**Fungsi Utama:**
- Melihat laporan evaluasi pembelajaran
- Melihat laporan absensi guru
- Melihat laporan absensi siswa
- Melihat laporan akademik sekolah
- Dashboard dengan overview sekolah

**Fitur Khusus:**
- Dashboard dengan statistik sekolah
- Laporan evaluasi pembelajaran
- Laporan absensi (guru dan siswa)
- Laporan akademik komprehensif

**Keterkaitan dengan Role Lain:**
- **Dengan Admin**: Kepala sekolah melihat data yang dikelola admin
- **Dengan Guru**: Kepala sekolah melihat performa dan aktivitas guru
- **Dengan Orang Tua**: Kepala sekolah dapat melihat data siswa untuk evaluasi

---

## 5. ALUR SISTEM

### 5.1 Alur Pendaftaran Orang Tua
1. Orang tua mengakses halaman registrasi
2. Mengisi formulir pendaftaran (nama, email, NIK, hubungan dengan siswa, dll)
3. Sistem menyimpan data ke tabel `ortu_register` dengan status "pending"
4. Admin menerima notifikasi pendaftaran baru
5. Admin meninjau data pendaftaran
6. Admin menyetujui atau menolak pendaftaran
7. Jika disetujui:
   - Sistem membuat user account untuk orang tua
   - Sistem membuat record di tabel `ortu`
   - Orang tua dapat login dengan email dan password
8. Jika ditolak:
   - Data pendaftaran dihapus atau ditandai sebagai ditolak
   - Orang tua tidak dapat login

### 5.2 Alur Presensi Siswa
1. Guru mengakses halaman presensi
2. Guru memilih kelas dan mata pelajaran yang diajar
3. Guru memilih tanggal presensi
4. Sistem menampilkan daftar siswa di kelas tersebut
5. Guru menginput status presensi untuk setiap siswa (Hadir, Izin, Sakit, Alpha, Terlambat)
6. Guru menyimpan presensi
7. Sistem menyimpan data ke tabel `presensi`
8. Orang tua dapat melihat presensi anak di dashboard mereka
9. Admin dapat melihat semua presensi di halaman absensi siswa

### 5.3 Alur Input Nilai
1. Guru mengakses halaman nilai
2. Guru memilih kelas, mata pelajaran, dan semester
3. Sistem menampilkan daftar siswa di kelas tersebut
4. Guru menginput nilai (Tugas, UTS, UAS) untuk setiap siswa
5. Sistem menghitung nilai akhir (rata-rata) dan predikat (A, B, C, D, E)
6. Guru menyimpan nilai
7. Sistem menyimpan/update data ke tabel `nilai`
8. Orang tua dapat melihat nilai anak di halaman perkembangan
9. Admin dapat melihat semua nilai di halaman data nilai

### 5.4 Alur Penilaian Harian
1. Guru mengakses halaman penilaian harian
2. Guru memilih kelas, tanggal, dan mata pelajaran
3. Guru memilih siswa yang akan dinilai
4. Sistem menampilkan form penilaian untuk siswa yang dipilih
5. Guru mengisi:
   - Jenis penilaian (Kuis, Tugas, Praktik, Ulangan Harian, Proyek, Portofolio)
   - Nilai (0-100)
   - Deskripsi (opsional)
   - Catatan guru (opsional)
6. Guru menyimpan penilaian
7. Sistem menyimpan/update data ke tabel `penilaian_harian`
8. Orang tua dapat melihat penilaian harian anak dengan filter
9. Admin dapat melihat semua penilaian harian

### 5.5 Alur Manajemen Data Siswa (Admin)
1. Admin mengakses halaman data siswa
2. Admin dapat:
   - Melihat daftar semua siswa dengan filter (kelas, jenis kelamin)
   - Menambah siswa baru (3 langkah: pilih/buat ortu → buat siswa)
   - Melihat detail siswa
   - Edit data siswa
   - Hapus siswa
3. Jika menambah siswa baru:
   - Langkah 1: Pilih orang tua yang sudah ada atau buat baru
   - Langkah 2: Jika buat baru, isi data orang tua
   - Langkah 3: Isi data siswa dan pilih kelas
4. Sistem menyimpan data ke tabel `siswa` dan `ortu` (jika baru)

### 5.6 Alur Manajemen Kelas dan Mata Pelajaran (Admin)
1. Admin mengakses halaman kelas atau mata pelajaran
2. Admin dapat CRUD (Create, Read, Update, Delete) kelas dan mata pelajaran
3. Untuk mata pelajaran, admin dapat:
   - Menetapkan guru pengajar
   - Menetapkan kelas
   - Mengatur jadwal (hari, jam mulai, jam selesai)
4. Sistem menyimpan data ke tabel `kelas` dan `mapel`

---

## 6. FITUR UTAMA SISTEM

### 6.1 Dashboard
- **Admin Dashboard**: Statistik lengkap sekolah, chart visualisasi, quick access shortcuts
- **Guru Dashboard**: Kelas yang akan diajar hari ini, ringkasan aktivitas
- **Orang Tua Dashboard**: Ringkasan informasi anak (presensi, nilai, catatan)
- **Kepala Sekolah Dashboard**: Overview sekolah, statistik umum

### 6.2 Manajemen Presensi
- Input presensi oleh guru per mata pelajaran
- Status presensi: Hadir, Izin, Sakit, Alpha, Terlambat
- Filter berdasarkan kelas, tanggal, mata pelajaran
- View presensi untuk orang tua dan admin

### 6.3 Manajemen Nilai
- Input nilai oleh guru (Tugas, UTS, UAS)
- Perhitungan otomatis nilai akhir dan predikat
- Filter berdasarkan kelas, mata pelajaran, semester
- View nilai untuk orang tua dan admin

### 6.4 Penilaian Harian
- Input penilaian harian per siswa (satu per satu)
- Jenis penilaian: Kuis, Tugas, Praktik, Ulangan Harian, Proyek, Portofolio
- Deskripsi dan catatan guru
- Filter untuk orang tua: anak, tanggal, mata pelajaran, jenis penilaian

### 6.5 Manajemen Data
- CRUD siswa, guru, kelas, mata pelajaran
- Manajemen user (admin, guru, kepala sekolah)
- Pendaftaran dan approval orang tua

### 6.6 Laporan
- Laporan presensi (harian, mingguan, bulanan)
- Laporan nilai dan akademik
- Laporan evaluasi pembelajaran (kepala sekolah)
- Generate PDF untuk kartu siswa dan laporan perkembangan

### 6.7 Jadwal
- Jadwal pelajaran per kelas
- Jadwal mengajar guru
- Jadwal terdekat untuk guru

---

## 7. KEAMANAN SISTEM

### 7.1 Autentikasi
- Login berbasis email dan password
- Password di-hash menggunakan bcrypt
- Session-based authentication
- Remember token untuk "Remember Me" functionality

### 7.2 Authorization
- Middleware-based role checking
- Setiap route dilindungi dengan middleware sesuai role
- User hanya dapat mengakses fitur sesuai role mereka

### 7.3 Data Validation
- Server-side validation untuk semua input
- CSRF protection untuk form
- SQL injection prevention melalui Eloquent ORM
- XSS protection melalui Blade template escaping

### 7.4 Access Control
- Guru hanya dapat menginput data untuk mata pelajaran yang diajarkan
- Orang tua hanya dapat melihat data anak mereka sendiri
- Admin memiliki akses penuh ke semua data

---

## 8. ELEMEN LAIN YANG DIBUTUHKAN UNTUK LAPORAN

### 8.1 Data Dummy/Seeder
Sistem dilengkapi dengan seeder untuk data dummy yang mencakup:
- 1 Admin, 1 Kepala Sekolah, 8 Guru, 30 Orang Tua
- 12 Kelas (1A-6B)
- 60 Siswa (5 siswa per kelas)
- Mata pelajaran untuk semua kelas dengan jadwal lengkap
- Data presensi untuk 3 bulan terakhir
- Data nilai untuk semester 1 dan 2
- Data penilaian harian untuk 3 bulan terakhir

### 8.2 Visualisasi Data
- Chart.js untuk visualisasi data:
  - Pie Chart: Distribusi siswa
  - Doughnut Chart: Distribusi user, persentase kehadiran
  - Bar Chart: Statistik presensi
  - Line Chart: Tren presensi

### 8.3 Export/Print
- Generate PDF untuk:
  - Kartu siswa
  - Laporan perkembangan siswa
  - Formulir pendaftaran

### 8.4 Filter dan Pencarian
- Filter berdasarkan:
  - Kelas
  - Tanggal
  - Mata pelajaran
  - Semester
  - Jenis kelamin
  - Status presensi
  - Jenis penilaian

### 8.5 Responsive Design
- Layout responsive untuk berbagai ukuran layar
- Mobile-friendly interface
- Sidebar navigation yang dapat di-collapse

---

## 9. KETERKAITAN ANTAR ROLE

### 9.1 Admin ↔ Guru
- **Admin ke Guru**: Admin dapat melihat semua data yang diinput guru, mengelola data guru, menetapkan guru ke mata pelajaran
- **Guru ke Admin**: Guru menginput data (presensi, nilai, penilaian harian) yang dapat dilihat admin

### 9.2 Admin ↔ Orang Tua
- **Admin ke Orang Tua**: Admin menyetujui pendaftaran orang tua, dapat melihat data anak mereka
- **Orang Tua ke Admin**: Orang tua mendaftar dan menunggu persetujuan admin

### 9.3 Guru ↔ Orang Tua
- **Guru ke Orang Tua**: Guru menginput presensi, nilai, penilaian harian, dan catatan yang dapat dilihat orang tua
- **Orang Tua ke Guru**: Orang tua melihat data yang diinput guru untuk memantau perkembangan anak

### 9.4 Admin ↔ Kepala Sekolah
- **Admin ke Kepala Sekolah**: Admin mengelola data yang digunakan kepala sekolah untuk laporan
- **Kepala Sekolah ke Admin**: Kepala sekolah melihat laporan berdasarkan data yang dikelola admin

### 9.5 Guru ↔ Kepala Sekolah
- **Guru ke Kepala Sekolah**: Guru menginput data yang digunakan kepala sekolah untuk evaluasi pembelajaran
- **Kepala Sekolah ke Guru**: Kepala sekolah melihat performa guru melalui laporan

---

## 10. ALUR KERJA INTEGRASI

### 10.1 Siklus Akademik
1. **Awal Semester**: Admin mengatur kelas, mata pelajaran, dan jadwal
2. **Selama Semester**: 
   - Guru menginput presensi harian
   - Guru menginput penilaian harian
   - Orang tua memantau perkembangan anak
3. **Pertengahan Semester**: Guru menginput nilai UTS
4. **Akhir Semester**: Guru menginput nilai UAS dan nilai akhir
5. **Evaluasi**: Kepala sekolah melihat laporan evaluasi pembelajaran

### 10.2 Siklus Pendaftaran
1. Orang tua baru mendaftar
2. Admin meninjau dan menyetujui
3. Admin menambahkan siswa baru (jika belum ada)
4. Orang tua dapat mengakses sistem dan melihat data anak

### 10.3 Siklus Presensi Harian
1. Siswa hadir di kelas
2. Guru menginput presensi di sistem
3. Data presensi tersimpan
4. Orang tua melihat presensi di dashboard
5. Admin dapat melihat statistik presensi

---

## 11. KESIMPULAN

Sistem Presensi Digital SDN 1 UNDUOLO adalah solusi terintegrasi untuk manajemen akademik sekolah dasar yang mencakup:

1. **Manajemen Presensi**: Otomatisasi presensi dengan input oleh guru dan akses transparan untuk orang tua
2. **Manajemen Nilai**: Input nilai akademik dengan perhitungan otomatis dan akses untuk orang tua
3. **Penilaian Harian**: Sistem penilaian harian yang detail dengan berbagai jenis penilaian
4. **Manajemen Data**: CRUD lengkap untuk siswa, guru, kelas, dan mata pelajaran
5. **Laporan**: Laporan komprehensif untuk evaluasi pembelajaran
6. **Komunikasi**: Platform untuk komunikasi antara sekolah, guru, dan orang tua

Sistem ini dirancang dengan arsitektur yang scalable, secure, dan user-friendly, menggunakan teknologi modern dan best practices dalam pengembangan web application.

---

**Dokumen ini dibuat untuk keperluan dokumentasi dan laporan sistem.**

