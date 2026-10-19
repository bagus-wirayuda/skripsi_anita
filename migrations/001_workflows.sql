CREATE TABLE IF NOT EXISTS qr_tokens (
 siswa_id INT PRIMARY KEY, token CHAR(64) NOT NULL UNIQUE,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE IF NOT EXISTS pendaftaran_anak (
 id INT AUTO_INCREMENT PRIMARY KEY, orangtua_id INT NOT NULL,
 nama_lengkap VARCHAR(100) NOT NULL, nisn VARCHAR(20),
 jenis_kelamin ENUM('Laki-laki','Perempuan') NOT NULL,
 tempat_lahir VARCHAR(100), tanggal_lahir DATE NOT NULL,
 kelas_id INT NOT NULL, status ENUM('pending','approved','rejected') DEFAULT 'pending',
 catatan TEXT, siswa_id INT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (orangtua_id) REFERENCES orangtua(id) ON DELETE CASCADE,
 FOREIGN KEY (kelas_id) REFERENCES kelas(id) ON DELETE RESTRICT,
 FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE IF NOT EXISTS notification_queue (
 id INT AUTO_INCREMENT PRIMARY KEY, siswa_id INT NOT NULL, tanggal DATE NOT NULL,
 nomor_hp VARCHAR(20) NOT NULL, pesan TEXT NOT NULL,
 status ENUM('pending','sent','failed','cancelled') DEFAULT 'pending',
 attempts INT NOT NULL DEFAULT 0, last_error TEXT NULL, provider_message_id VARCHAR(200) NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, sent_at DATETIME NULL,
 UNIQUE KEY unique_absence_notice (siswa_id,tanggal),
 FOREIGN KEY (siswa_id) REFERENCES siswa(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
