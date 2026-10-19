<?php
require __DIR__.'/ui.php';requireRole([$dashboardRole]);$scope=classScope();$today=date('Y-m-d');$month=date('Y-m-01');
$total=dbOne("SELECT COUNT(*) n FROM siswa s WHERE status='aktif' AND $scope")['n'];
$present=dbOne("SELECT COUNT(*) n FROM absensi_siswa a JOIN siswa s ON s.id=a.siswa_id WHERE $scope AND a.tanggal=? AND a.status='hadir'",[$today])['n'];
$recorded=dbOne("SELECT COUNT(*) n FROM absensi_siswa a JOIN siswa s ON s.id=a.siswa_id WHERE $scope AND s.status='aktif' AND a.tanggal=?",[$today])['n'];
$absence=dbOne("SELECT COUNT(*) n FROM absensi_siswa a JOIN siswa s ON s.id=a.siswa_id WHERE $scope AND a.tanggal=? AND a.status='alpa'",[$today])['n'];
pageStart('Dashboard '.($dashboardRole==='kepalasekolah'?'Kepala Sekolah':ucfirst($dashboardRole)),'Selamat datang, '.$_SESSION['nama_lengkap'].'. Berikut ringkasan sekolah hari ini.');
stats(['Siswa Aktif'=>$total,'Hadir Hari Ini'=>$present,'Alpa Hari Ini'=>$absence,'Belum Dipresensi'=>max(0,$total-$recorded)]);
?><div class="form-actions"><a class="btn" href="<?=BASE_URL?>/<?=$dashboardRole?>/laporan.php">Lihat Laporan</a><?php if($dashboardRole!=='kepalasekolah'):?><a class="btn btn--ghost" href="<?=BASE_URL?>/presensi.php">Presensi QR</a><?php endif;?></div><?php
if($dashboardRole==='admin') {
 $pending=dbOne("SELECT COUNT(*) n FROM orangtua WHERE status='pending'")['n']+dbOne("SELECT COUNT(*) n FROM pendaftaran_anak WHERE status='pending'")['n'];
 echo '<article class="card editor"><h2 class="section-title">Pendaftaran Menunggu Validasi</h2><p>'.e($pending).' pengajuan perlu ditinjau.</p><a class="btn btn--ghost" href="pendaftaran.php">Tinjau Pendaftaran</a></article>';
}
if($dashboardRole==='guru'){
 echo '<h2 class="section-title">Jadwal Hari Ini</h2>';$days=['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];tableView(['Kelas','Mata Pelajaran','Mulai','Selesai'],array_map('array_values',dbAll('SELECT k.nama_kelas,j.mata_pelajaran,j.jam_mulai,j.jam_selesai FROM jadwal j JOIN kelas k ON k.id=j.kelas_id WHERE j.guru_id=? AND j.hari=? AND j.tahun_ajaran=? AND j.semester=? ORDER BY j.jam_mulai',[relatedId(),$days[(int)date('w')],schoolYear(),(int)date('n')>=7?'ganjil':'genap'])));
}
if($dashboardRole==='kepalasekolah'){
 $late=dbOne("SELECT COUNT(*) n FROM absensi_siswa a JOIN siswa s ON s.id=a.siswa_id WHERE a.tanggal=? AND a.status='hadir' AND a.jam_masuk>(SELECT MIN(j.jam_mulai) FROM jadwal j WHERE j.kelas_id=s.kelas_id AND j.hari=ELT(DAYOFWEEK(a.tanggal),'Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') AND j.tahun_ajaran=? AND j.semester=?)",[$today,schoolYear(),(int)date('n')>=7?'ganjil':'genap'])['n'];
 stats(['Terlambat Hari Ini'=>$late,'Guru Aktif'=>dbOne("SELECT COUNT(*) n FROM guru WHERE status='aktif'")['n'],'Jumlah Kelas'=>count(classes())]);
 echo '<p class="muted">Keterlambatan dihitung dari jam masuk terhadap jadwal pertama kelas pada hari dan semester yang sama.</p><h2 class="section-title">Siswa dengan Alpa Berulang Bulan Ini</h2>';
 tableView(['Siswa','Kelas','Jumlah Alpa'],array_map('array_values',dbAll("SELECT s.nama_lengkap,k.nama_kelas,COUNT(*) total FROM absensi_siswa a JOIN siswa s ON s.id=a.siswa_id JOIN kelas k ON k.id=s.kelas_id WHERE a.status='alpa' AND a.tanggal BETWEEN ? AND ? GROUP BY s.id,s.nama_lengkap,k.nama_kelas HAVING COUNT(*)>=3 ORDER BY total DESC",[$month,$today])));
}
echo '<h2 class="section-title">Presensi Terbaru</h2>';tableView(['Tanggal','Siswa','Kelas','Status','Jam Masuk'],array_map('array_values',dbAll("SELECT a.tanggal,s.nama_lengkap,k.nama_kelas,a.status,a.jam_masuk FROM absensi_siswa a JOIN siswa s ON s.id=a.siswa_id JOIN kelas k ON k.id=s.kelas_id WHERE $scope ORDER BY a.tanggal DESC,a.updated_at DESC LIMIT 10")));pageEnd();
