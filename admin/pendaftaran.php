<?php
require __DIR__.'/../includes/ui.php'; requireRole(['admin']);
$error='';
if($_SERVER['REQUEST_METHOD']==='POST') try {
 getDB()->begin_transaction();
 $id=(int)($_POST['id']??0); $approved=($_POST['decision']??'')==='approve';
 if(($_POST['kind']??'')==='parent') {
  $p=dbOne("SELECT * FROM orangtua WHERE id=? AND status='pending' FOR UPDATE",[$id]); need((bool)$p,'Pendaftaran sudah diproses atau tidak ditemukan.');
  $uid=$p['user_id'];
  if($approved && !$uid) {
   $username=textInput('username',50);$password=textInput('password',100);need(strlen($password)>=8,'Password minimal 8 karakter.');
   dbRun("INSERT INTO users (username,password,role,nama_lengkap,status) VALUES (?,?,'orangtua',?,'aktif')",[$username,hashPassword($password),$p['nama']]); $uid=lastInsertId();
  }
  if($uid) dbRun("UPDATE users SET status=? WHERE id=? AND role='orangtua'",[$approved?'aktif':'nonaktif',$uid]);
  dbRun('UPDATE orangtua SET status=?,user_id=? WHERE id=?',[$approved?'approved':'rejected',$uid,$id]);
 } else {
  $p=dbOne("SELECT * FROM pendaftaran_anak WHERE id=? AND status='pending' FOR UPDATE",[$id]);need((bool)$p,'Pengajuan anak sudah diproses atau tidak ditemukan.');
  $sid=null;
  if($approved) {
   $nis=textInput('nis',20); $kelas=(int)($_POST['kelas_id']??0); need((bool)dbOne('SELECT id FROM kelas WHERE id=?',[$kelas]),'Kelas wajib dipilih.');
   need(!$p['nisn'] || !dbOne('SELECT id FROM siswa WHERE nisn=?',[$p['nisn']]),'NISN sudah terdaftar. Hubungkan siswa yang ada ke orang tua melalui Data Siswa.');
   dbRun("INSERT INTO siswa (nis,nisn,nama_lengkap,jenis_kelamin,tempat_lahir,tanggal_lahir,kelas_id,orangtua_id,tahun_masuk,status) VALUES (?,?,?,?,?,?,?,?,?,'aktif')",[$nis,$p['nisn'],$p['nama_lengkap'],$p['jenis_kelamin'],$p['tempat_lahir'],$p['tanggal_lahir'],$kelas,$p['orangtua_id'],date('Y')]);$sid=lastInsertId();
  }
  dbRun('UPDATE pendaftaran_anak SET status=?,catatan=?,siswa_id=? WHERE id=?',[$approved?'approved':'rejected',textInput('catatan',1000,false),$sid,$id]);
 }
 getDB()->commit();flash($approved?'Pendaftaran disetujui.':'Pendaftaran ditolak.');redirectHere();
}catch(Throwable $ex){getDB()->rollback();$error=actionError($ex);}
pageStart('Validasi Pendaftaran','Tinjau akun orang tua dan pengajuan data anak.'); if($error) echo '<div class="message error">'.e($error).'</div>';
?><h2 class="section-title">Akun Orang Tua</h2><?php $parents=dbAll("SELECT o.*,u.username FROM orangtua o LEFT JOIN users u ON u.id=o.user_id WHERE o.status='pending'");if(!$parents) echo '<p class="card empty-state">Tidak ada akun yang menunggu persetujuan.</p>';foreach($parents as $p):?>
<article class="card editor"><h3><?=e($p['nama'])?></h3><p><?=e($p['alamat'])?> · <?=e($p['nomor_hp'])?></p><form method="post" class="form-grid"><?=csrfField()?><input type="hidden" name="kind" value="parent"><input type="hidden" name="id" value="<?=$p['id']?>"><?php if(!$p['user_id']){field('username','Username untuk orang tua');field('password','Password awal','','password');}else echo '<p>Username: '.e($p['username']).'</p>';?><div class="form-actions"><button class="btn" name="decision" value="approve">Setujui Akun</button><button class="btn btn--ghost" name="decision" value="reject" formnovalidate>Tolak</button></div></form></article><?php endforeach;?>
<h2 class="section-title">Pengajuan Data Anak</h2><?php $pending=dbAll("SELECT p.*,o.nama orangtua FROM pendaftaran_anak p JOIN orangtua o ON o.id=p.orangtua_id WHERE p.status='pending'");if(!$pending) echo '<p class="card empty-state">Tidak ada pengajuan anak yang menunggu.</p>';foreach($pending as $p):?>
<article class="card editor"><h3><?=e($p['nama_lengkap'])?></h3><p>Orang tua: <?=e($p['orangtua'])?> · NISN: <?=e($p['nisn'])?> · Lahir: <?=e($p['tempat_lahir'])?>, <?=e($p['tanggal_lahir'])?></p><form method="post" class="form-grid"><?=csrfField()?><input type="hidden" name="kind" value="child"><input type="hidden" name="id" value="<?=$p['id']?>"><?php field('nis','NIS sekolah');selectField('kelas_id','Kelas',options(classes(),'nama_kelas'),$p['kelas_id']);field('catatan','Catatan validasi','','text',false);?><div class="form-actions"><button class="btn" name="decision" value="approve">Setujui Anak</button><button class="btn btn--ghost" name="decision" value="reject" formnovalidate>Tolak</button></div></form></article><?php endforeach;
tableView(['Nama Anak','Status','Catatan'],array_map(fn($p)=>[$p['nama_lengkap'],$p['status'],$p['catatan']],dbAll("SELECT * FROM pendaftaran_anak WHERE status<>'pending' ORDER BY id DESC LIMIT 100")));pageEnd();
