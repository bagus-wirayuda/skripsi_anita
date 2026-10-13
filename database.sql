-- Database untuk Sistem Manajemen Sekolah SDN 1 UNDUOLO
-- Created: 2025

CREATE DATABASE IF NOT EXISTS sdn1unduolo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sdn1unduolo;

-- Tabel Users untuk semua jenis pengguna
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE,
    role ENUM('admin', 'guru', 'kepalasekolah', 'orangtua') NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    status ENUM('aktif', 'nonaktif') DEFAULT 'aktif',
    last_login DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Orangtua (Parent Registration)
CREATE TABLE IF NOT EXISTS orangtua (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    nomor_hp VARCHAR(20) NOT NULL,
    user_id INT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Guru
CREATE TABLE IF NOT EXISTS guru (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nip VARCHAR(20) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    mata_pelajaran VARCHAR(100),
    user_id INT NULL,
    status ENUM('aktif', 'cuti', 'nonaktif') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_nip (nip)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Kelas
CREATE TABLE IF NOT EXISTS kelas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kelas VARCHAR(10) UNIQUE NOT NULL,
    tingkat INT NOT NULL,
    wali_kelas_id INT NULL,
    tahun_ajaran VARCHAR(20) DEFAULT '2024/2025',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (wali_kelas_id) REFERENCES guru(id) ON DELETE SET NULL,
    INDEX idx_nama_kelas (nama_kelas)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Siswa
CREATE TABLE IF NOT EXISTS siswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nis VARCHAR(20) UNIQUE NOT NULL,
    nisn VARCHAR(20),
    nama_lengkap VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('Laki-laki', 'Perempuan') NOT NULL,
    tempat_lahir VARCHAR(100),
    tanggal_lahir DATE,
    kelas_id INT NOT NULL,
    orangtua_id INT NULL,
    tahun_masuk YEAR,
    status ENUM('aktif', 'lulus', 'pindah', 'cuti') DEFAULT 'aktif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE RESTRICT,
    FOREIGN KEY (orangtua_id) REFERENCES orangtua(id) ON DELETE SET NULL,
    INDEX idx_nis (nis),
    INDEX idx_kelas_id (kelas_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Jadwal Pelajaran
CREATE TABLE IF NOT EXISTS jadwal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kelas_id INT NOT NULL,
    hari ENUM('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu') NOT NULL,
    jam_mulai TIME NOT NULL,
    jam_selesai TIME NOT NULL,
    mata_pelajaran VARCHAR(100) NOT NULL,
    guru_id INT NOT NULL,
    semester ENUM('ganjil', 'genap') DEFAULT 'ganjil',
    tahun_ajaran VARCHAR(20) DEFAULT '2024/2025',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE CASCADE,
    FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE RESTRICT,
    INDEX idx_kelas_hari (kelas_id, hari)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Absensi Siswa
CREATE TABLE IF NOT EXISTS absensi_siswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    siswa_id INT NOT NULL,
    tanggal DATE NOT NULL,
    status ENUM('hadir', 'izin', 'sakit', 'alpa') NOT NULL,
    jam_masuk TIME NULL,
    keterangan TEXT,
    guru_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE,
    FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE SET NULL,
    UNIQUE KEY unique_absensi (siswa_id, tanggal),
    INDEX idx_siswa_tanggal (siswa_id, tanggal),
    INDEX idx_tanggal (tanggal)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Absensi Guru
CREATE TABLE IF NOT EXISTS absensi_guru (
    id INT AUTO_INCREMENT PRIMARY KEY,
    guru_id INT NOT NULL,
    tanggal DATE NOT NULL,
    status ENUM('hadir', 'izin', 'sakit', 'alpa') NOT NULL,
    jam_masuk TIME NULL,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE CASCADE,
    UNIQUE KEY unique_absensi_guru (guru_id, tanggal),
    INDEX idx_guru_tanggal (guru_id, tanggal)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Mata Pelajaran
CREATE TABLE IF NOT EXISTS mata_pelajaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) UNIQUE NOT NULL,
    kode VARCHAR(20) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Nilai Siswa
CREATE TABLE IF NOT EXISTS nilai (
    id INT AUTO_INCREMENT PRIMARY KEY,
    siswa_id INT NOT NULL,
    mata_pelajaran VARCHAR(100) NOT NULL,
    semester ENUM('ganjil', 'genap') NOT NULL,
    tahun_ajaran VARCHAR(20) DEFAULT '2024/2025',
    nilai_harian DECIMAL(5,2) DEFAULT 0,
    nilai_ulangan DECIMAL(5,2) DEFAULT 0,
    nilai_rata DECIMAL(5,2) GENERATED ALWAYS AS ((nilai_harian + nilai_ulangan) / 2) STORED,
    guru_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE,
    FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE RESTRICT,
    INDEX idx_siswa_semester (siswa_id, semester),
    INDEX idx_mata_pelajaran (mata_pelajaran)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Penilaian Harian (Star Rating)
CREATE TABLE IF NOT EXISTS penilaian_harian (
    id INT AUTO_INCREMENT PRIMARY KEY,
    siswa_id INT NOT NULL,
    guru_id INT NOT NULL,
    tanggal DATE NOT NULL,
    mata_pelajaran VARCHAR(100) NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE,
    FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE RESTRICT,
    INDEX idx_siswa_tanggal (siswa_id, tanggal),
    INDEX idx_guru_tanggal (guru_id, tanggal)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Notes/Catatan Guru untuk Siswa
CREATE TABLE IF NOT EXISTS notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    siswa_id INT NOT NULL,
    guru_id INT NOT NULL,
    judul VARCHAR(200) NOT NULL,
    isi TEXT NOT NULL,
    kategori ENUM('prestasi', 'perilaku', 'akademik', 'sosial', 'lainnya') NOT NULL,
    tanggal DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE,
    FOREIGN KEY (guru_id) REFERENCES guru(id) ON DELETE RESTRICT,
    INDEX idx_siswa_tanggal (siswa_id, tanggal),
    INDEX idx_guru (guru_id),
    INDEX idx_kategori (kategori)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Data Default

-- Insert default admin user (password: admin123)
INSERT INTO users (username, password, email, role, nama_lengkap, status) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@sdn1unduolo.sch.id', 'admin', 'Admin Sekolah', 'aktif');

-- Insert default kepala sekolah user (password: kepala123)
INSERT INTO users (username, password, email, role, nama_lengkap, status) VALUES
('kepalasekolah', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'kepala@sdn1unduolo.sch.id', 'kepalasekolah', 'Kepala Sekolah', 'aktif');

-- Insert Mata Pelajaran
INSERT INTO mata_pelajaran (nama, kode) VALUES
('Matematika', 'MAT'),
('Bahasa Indonesia', 'BIN'),
('IPA', 'IPA'),
('IPS', 'IPS'),
('Bahasa Inggris', 'BIG'),
('Seni Budaya', 'SB'),
('Pendidikan Jasmani', 'PJOK'),
('Pendidikan Agama', 'PAI'),
('PPKn', 'PPKN');

-- Insert Kelas
INSERT INTO kelas (nama_kelas, tingkat, tahun_ajaran) VALUES
('1A', 1, '2024/2025'),
('1B', 1, '2024/2025'),
('2A', 2, '2024/2025'),
('2B', 2, '2024/2025'),
('3A', 3, '2024/2025'),
('3B', 3, '2024/2025'),
('3C', 3, '2024/2025'),
('4A', 4, '2024/2025'),
('4B', 4, '2024/2025'),
('5A', 5, '2024/2025'),
('5B', 5, '2024/2025'),
('6A', 6, '2024/2025'),
('6B', 6, '2024/2025'),
('6C', 6, '2024/2025');


