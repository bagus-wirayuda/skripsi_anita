<?php
require_once __DIR__ . '/auth.php';

function e($value): string { return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8'); }
function dbRun(string $sql, array $params = []): mysqli_stmt {
    $stmt = getDB()->prepare($sql);
    if ($params) $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    $stmt->execute();
    return $stmt;
}
function dbAll(string $sql, array $params = []): array { return dbRun($sql, $params)->get_result()->fetch_all(MYSQLI_ASSOC); }
function dbOne(string $sql, array $params = []): ?array { return dbRun($sql, $params)->get_result()->fetch_assoc(); }
function csrfField(): string { return '<input type="hidden" name="csrf" value="'.e($_SESSION['csrf']).'">'; }
function flash(string $message, string $type = 'success'): void { $_SESSION['flash'] = [$message, $type]; }
function redirectHere(): void { header('Location: '.strtok($_SERVER['REQUEST_URI'], '?')); exit; }
function schoolYear(): string { $y = (int)date('Y') - ((int)date('n') < 7 ? 1 : 0); return $y.'/'.($y+1); }
function validDate($value): bool { $d = DateTime::createFromFormat('!Y-m-d', (string)$value); return $d && $d->format('Y-m-d') === $value; }
function need(bool $condition, string $message): void { if (!$condition) throw new InvalidArgumentException($message); }
function textInput(string $key, int $max = 200, bool $required = true): string {
    $v = trim((string)($_POST[$key] ?? ''));
    need((!$required || $v !== '') && mb_strlen($v) <= $max, "Isian $key wajib diisi dan maksimal $max karakter.");
    return $v;
}
function relatedId(): int { return (int)($_SESSION['related_id'] ?? 0); }
function classScope(string $alias = 's'): string {
    $id = relatedId();
    if ($_SESSION['role'] === 'guru') return "($alias.kelas_id IN (SELECT id FROM kelas WHERE wali_kelas_id=$id) OR $alias.kelas_id IN (SELECT kelas_id FROM jadwal WHERE guru_id=$id))";
    if ($_SESSION['role'] === 'orangtua') return "$alias.orangtua_id=$id";
    return '1=1';
}
function classes(): array {
    if ($_SESSION['role'] === 'guru') return dbAll('SELECT DISTINCT k.* FROM kelas k LEFT JOIN jadwal j ON j.kelas_id=k.id WHERE k.wali_kelas_id=? OR j.guru_id=? ORDER BY k.tingkat,k.nama_kelas',[relatedId(),relatedId()]);
    return dbAll('SELECT * FROM kelas ORDER BY tingkat,nama_kelas');
}
function student(int $id): array {
    $s = dbOne('SELECT s.*,k.nama_kelas,k.tahun_ajaran FROM siswa s JOIN kelas k ON k.id=s.kelas_id WHERE s.id=? AND '.classScope(), [$id]);
    need((bool)$s, 'Siswa tidak ditemukan atau tidak berada dalam akses Anda.');
    return $s;
}
function subjects(int $class): array {
    if ($_SESSION['role'] === 'guru') return dbAll('SELECT DISTINCT mata_pelajaran AS nama FROM jadwal WHERE kelas_id=? AND guru_id=? ORDER BY mata_pelajaran',[$class,relatedId()]);
    return dbAll('SELECT nama FROM mata_pelajaran ORDER BY nama');
}
function canGrade(int $class, string $subject, string $year, string $semester): bool { return (bool)dbOne('SELECT id FROM jadwal WHERE kelas_id=? AND guru_id=? AND mata_pelajaran=? AND tahun_ajaran=? AND semester=?',[$class,relatedId(),$subject,$year,$semester]); }
function actionError(Throwable $ex): string {
    if ($ex instanceof InvalidArgumentException) return $ex->getMessage();
    error_log((string)$ex);
    if ($ex instanceof mysqli_sql_exception && $ex->getCode() === 1062) return 'Data sudah terdaftar. Gunakan NIS, NIP, username, atau email yang berbeda.';
    if ($ex instanceof mysqli_sql_exception && $ex->getCode() === 1451) return 'Data masih digunakan. Nonaktifkan data atau lepaskan hubungan terkait terlebih dahulu.';
    return 'Data belum tersimpan. Periksa isian dan konfigurasi database.';
}
function queueAbsence(int $studentId, string $date, string $status): void {
    if ($status !== 'alpa') { dbRun("UPDATE notification_queue SET status='cancelled' WHERE siswa_id=? AND tanggal=? AND status='pending'",[$studentId,$date]); return; }
    $s = dbOne('SELECT s.nama_lengkap,o.nomor_hp FROM siswa s LEFT JOIN orangtua o ON o.id=s.orangtua_id WHERE s.id=?',[$studentId]);
    $message = 'Informasi sekolah: '.$s['nama_lengkap'].' tercatat alpa pada '.$date.'. Silakan hubungi wali kelas untuk konfirmasi.';
    dbRun("INSERT INTO notification_queue (siswa_id,tanggal,nomor_hp,pesan) VALUES (?,?,?,?) ON DUPLICATE KEY UPDATE nomor_hp=VALUES(nomor_hp),pesan=VALUES(pesan),status=IF(status='cancelled','pending',status)",[$studentId,$date,$s['nomor_hp'] ?? '',$message]);
}
function saveAttendance(int $id, string $date, string $status, string $note): void {
    $s = student($id);
    need($s['status']==='aktif','Hanya siswa aktif yang dapat dipresensi.');
    need(validDate($date) && $date <= date('Y-m-d'), 'Tanggal presensi tidak valid atau berada di masa depan.');
    need(in_array($status,['hadir','izin','sakit','alpa'],true), 'Status presensi tidak valid.');
    need(mb_strlen($note)<=1000,'Keterangan maksimal 1000 karakter.');
    $time = $status==='hadir' && $date===date('Y-m-d') ? date('H:i:s') : null;
    dbRun("INSERT INTO absensi_siswa (siswa_id,tanggal,status,jam_masuk,keterangan,guru_id) VALUES (?,?,?,?,?,?) ON DUPLICATE KEY UPDATE jam_masuk=IF(VALUES(status)='hadir',COALESCE(jam_masuk,VALUES(jam_masuk)),NULL),jam_keluar=IF(VALUES(status)='hadir',jam_keluar,NULL),status=VALUES(status),keterangan=VALUES(keterangan),guru_id=VALUES(guru_id)",[$id,$date,$status,$time,$note,$_SESSION['role']==='guru'?relatedId():null]);
    queueAbsence($id,$date,$status);
}
