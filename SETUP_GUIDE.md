# Panduan Setup Sistem Manajemen Sekolah SDN 1 UNDUOLO

## Yang Sudah Diselesaikan

### ✅ 1. Database Structure
- ✅ File `database.sql` dengan semua tabel yang diperlukan
- ✅ Tabel users, orangtua, guru, siswa, kelas, jadwal, absensi, nilai, notes, dll
- ✅ Data default (admin user, mata pelajaran, kelas)

### ✅ 2. Konfigurasi & Helper Files
- ✅ `config/database.php` - Koneksi database dan helper functions
- ✅ `config/auth.php` - Sistem autentikasi dan session management
- ✅ `includes/sidebar.php` - Komponen sidebar navigation

### ✅ 3. Sistem Autentikasi
- ✅ Login page dengan database integration
- ✅ Register page untuk orang tua
- ✅ Session management
- ✅ Role-based access control (Admin, Guru, Kepala Sekolah, Orang Tua)
- ✅ Logout functionality

### ✅ 4. Public Pages
- ✅ Login page (`login.php`)
- ✅ Register page (`register.php`)
- ✅ Register success page (`register-success.php`)
- ✅ Homepage profil sekolah (`index.php`)
- ✅ Presensi public page (`presensi.php`)

### ✅ 5. Modul Admin
- ✅ Dashboard admin dengan statistik real-time
- ✅ Data siswa dengan filter dan query database
- ⚠️ Data guru (HTML ready, perlu PHP integration)
- ⚠️ Data user (HTML ready, perlu PHP integration)
- ⚠️ Data nilai (HTML ready, perlu PHP integration)
- ⚠️ Absensi siswa (HTML ready, perlu PHP integration)
- ⚠️ Jadwal pelajaran (HTML ready, perlu PHP integration)
- ⚠️ Laporan (HTML ready, perlu PHP integration)

### ✅ 6. Modul Guru
- ✅ Dashboard guru (HTML ready, perlu PHP integration)
- ✅ Presensi siswa dengan save functionality
- ⚠️ Nilai (HTML ready, perlu PHP integration)
- ⚠️ Penilaian harian (HTML ready, perlu PHP integration)
- ⚠️ Notes (HTML ready, perlu PHP integration)
- ⚠️ Laporan (HTML ready, perlu PHP integration)

### ✅ 7. Modul Kepala Sekolah
- ✅ Dashboard kepala sekolah (HTML ready, perlu PHP integration)
- ⚠️ Semua laporan (HTML ready, perlu PHP integration)

### ✅ 8. Modul Orang Tua
- ✅ Dashboard orang tua dengan data real-time
- ⚠️ Data anak (HTML ready, perlu PHP integration)
- ⚠️ Perkembangan anak (HTML ready, perlu PHP integration)
- ⚠️ Notes dari guru (HTML ready, perlu PHP integration)

## Yang Masih Perlu Dilakukan

### 🔄 File yang Perlu Diupdate (Urutan Prioritas)

#### Prioritas Tinggi:
1. **admin/data-guru.php** - Tambahkan query database untuk list guru
2. **admin/data-user.php** - Tambahkan query database untuk list user
3. **admin/absensi-siswa.php** - Tambahkan query database untuk absensi
4. **admin/jadwal.php** - Tambahkan query database untuk jadwal
5. **admin/data-nilai.php** - Tambahkan query database untuk nilai
6. **admin/laporan.php** - Tambahkan query database untuk laporan
7. **guru/dashboard.php** - Integrasikan dengan database
8. **guru/nilai.php** - Tambahkan save functionality
9. **guru/notes.php** - Tambahkan save functionality
10. **guru/penilaian-harian.php** - Tambahkan save functionality
11. **orangtua/data-anak.php** - Integrasikan dengan database
12. **orangtua/perkembangan.php** - Integrasikan dengan database
13. **orangtua/notes.php** - Integrasikan dengan database

#### Prioritas Menengah:
14. **kepalasekolah/dashboard.php** - Integrasikan dengan database
15. **kepalasekolah/laporan.php** - Integrasikan dengan database
16. **kepalasekolah/laporan-akademik.php** - Integrasikan dengan database
17. **kepalasekolah/laporan-absensi-guru.php** - Integrasikan dengan database
18. **kepalasekolah/laporan-absensi-siswa.php** - Integrasikan dengan database
19. **kepalasekolah/laporan-absensi.php** - Integrasikan dengan database
20. **kepalasekolah/evaluasi-pembelajaran.php** - Integrasikan dengan database

### 🔧 Fitur CRUD yang Perlu Ditambahkan

1. **Tambah/Edit/Hapus Siswa** - Form modal atau halaman terpisah
2. **Tambah/Edit/Hapus Guru** - Form modal atau halaman terpisah
3. **Tambah/Edit/Hapus User** - Form modal atau halaman terpisah
4. **Tambah/Edit/Hapus Jadwal** - Form modal atau halaman terpisah
5. **Approve Orangtua Registration** - Di halaman admin data-user

## Cara Melanjutkan Development

### Pattern untuk Update File

Untuk setiap file PHP yang perlu diupdate, ikuti pattern berikut:

```php
<?php
require_once __DIR__ . '/../config/auth.php';
requireRole(['role_name']); // atau requireLogin() untuk role apapun

require_once __DIR__ . '/../config/database.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form data
    // Save to database
    // Redirect or show message
}

// Get data from database
$data = fetchAll("SELECT * FROM table_name WHERE condition");

?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <!-- Head content -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css" />
  </head>
  <body>
    <div class="layout">
      <?php include __DIR__ . '/../includes/sidebar.php'; ?>
      
      <main class="layout__main">
        <!-- Content with PHP echo -->
        <?php foreach ($data as $row): ?>
          <!-- Display data -->
        <?php endforeach; ?>
      </main>
    </div>
    
    <script src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
  </body>
</html>
```

### Helper Functions yang Tersedia

```php
// Koneksi database
$conn = getDB();

// Query helper
$result = query($sql); // Execute query, return mysqli_result
$row = fetchOne($sql); // Get single row as array
$rows = fetchAll($sql); // Get all rows as array of arrays

// Escape string
$safe = escape($string);

// Get last insert ID
$id = lastInsertId();
```

### Query Examples

```php
// Get students with class info
$siswa = fetchAll("SELECT s.*, k.nama_kelas 
                   FROM siswa s 
                   LEFT JOIN kelas k ON s.kelas_id = k.id 
                   WHERE s.status = 'aktif'");

// Get attendance for today
$today = date('Y-m-d');
$presensi = fetchAll("SELECT * FROM absensi_siswa WHERE tanggal = '$today'");

// Insert new record
$nama = escape($_POST['nama']);
query("INSERT INTO siswa (nama_lengkap, nis) VALUES ('$nama', '12345')");

// Update record
$id = escape($_POST['id']);
query("UPDATE siswa SET status = 'aktif' WHERE id = $id");

// Delete record
$id = escape($_GET['id']);
query("DELETE FROM siswa WHERE id = $id");
```

## Tips Development

1. **Gunakan escape() untuk semua user input** - Mencegah SQL injection
2. **Gunakan htmlspecialchars() untuk output** - Mencegah XSS
3. **Validasi semua form input** - Pastikan data valid sebelum save
4. **Gunakan prepared statements untuk complex queries** - Lebih aman
5. **Test setiap fitur setelah implementasi** - Pastikan bekerja dengan baik

## Testing Checklist

Untuk setiap file yang diupdate, test:

- [ ] Halaman bisa diakses dan tidak error
- [ ] Data dari database muncul dengan benar
- [ ] Form submission bekerja (jika ada)
- [ ] Redirect setelah save bekerja
- [ ] Error handling bekerja (jika ada)
- [ ] Filter/search bekerja (jika ada)
- [ ] Link navigation bekerja

## Next Steps

1. Update semua file admin dengan database integration
2. Update semua file guru dengan database integration  
3. Update semua file orangtua dengan database integration
4. Update semua file kepalasekolah dengan database integration
5. Tambahkan CRUD functionality untuk semua modul
6. Test semua fitur secara menyeluruh
7. Fix bugs yang ditemukan
8. Optimize queries jika diperlukan

## Catatan Penting

- Semua file HTML sudah diubah menjadi PHP
- Semua link `.html` perlu diubah menjadi `.php` (beberapa masih perlu update)
- BASE_URL auto-detect sudah diimplementasi
- Session management sudah bekerja
- Database structure sudah lengkap

## Kontak & Support

Jika ada pertanyaan atau butuh bantuan, silakan hubungi developer atau buat issue di repository.

---

**Last Updated:** 2025
**Status:** In Progress - 40% Complete


