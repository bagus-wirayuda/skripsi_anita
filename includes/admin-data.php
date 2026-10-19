<?php
require_once __DIR__.'/ui.php';
requireRole(['admin']);
$definitions = [
 'siswa'=>['Data Siswa','nama_lengkap',['nis'=>'NIS','nisn'=>'NISN','nama_lengkap'=>'Nama Lengkap','jenis_kelamin'=>'Jenis Kelamin','tempat_lahir'=>'Tempat Lahir','tanggal_lahir'=>'Tanggal Lahir','kelas_id'=>'Kelas','orangtua_id'=>'Orang Tua','tahun_masuk'=>'Tahun Masuk','status'=>'Status']],
 'guru'=>['Data Guru','nama',['nip'=>'NIP','nama'=>'Nama Guru','email'=>'Email','mata_pelajaran'=>'Mata Pelajaran','user_id'=>'Akun Guru','status'=>'Status']],
 'users'=>['Data User','nama_lengkap',['username'=>'Username','nama_lengkap'=>'Nama Lengkap','email'=>'Email','role'=>'Peran','status'=>'Status','password'=>'Password']],
 'kelas'=>['Data Kelas','nama_kelas',['nama_kelas'=>'Nama Kelas','tingkat'=>'Tingkat','wali_kelas_id'=>'Wali Kelas','tahun_ajaran'=>'Tahun Ajaran']],
 'mata_pelajaran'=>['Mata Pelajaran','nama',['nama'=>'Nama Mata Pelajaran','kode'=>'Kode']],
 'jadwal'=>['Jadwal Pelajaran','hari',['kelas_id'=>'Kelas','hari'=>'Hari','jam_mulai'=>'Jam Mulai','jam_selesai'=>'Jam Selesai','mata_pelajaran'=>'Mata Pelajaran','guru_id'=>'Guru','semester'=>'Semester','tahun_ajaran'=>'Tahun Ajaran']],
 'orangtua'=>['Data Orang Tua','nama',['nama'=>'Nama Orang Tua','alamat'=>'Alamat','nomor_hp'=>'Nomor HP','user_id'=>'Akun Orang Tua','status'=>'Status']],
];
[$title,$sort,$fields]=$definitions[$entity];
$choices=[
 'kelas_id'=>options(classes(),'nama_kelas'),
 'orangtua_id'=>options(dbAll("SELECT id,nama FROM orangtua WHERE status='approved'")),
 'guru_id'=>options(dbAll("SELECT id,nama FROM guru WHERE status='aktif'")),
 'wali_kelas_id'=>options(dbAll("SELECT id,nama FROM guru WHERE status='aktif'")),
 'jenis_kelamin'=>array_combine(['Laki-laki','Perempuan'],['Laki-laki','Perempuan']),
 'role'=>['admin'=>'Admin','guru'=>'Guru','kepalasekolah'=>'Kepala Sekolah','orangtua'=>'Orang Tua'],
 'semester'=>['ganjil'=>'Ganjil','genap'=>'Genap'],
 'hari'=>array_combine(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu']),
 'user_id'=>options(dbAll("SELECT id,CONCAT(nama_lengkap,' (',username,')') nama FROM users WHERE role=?",[$entity==='orangtua'?'orangtua':'guru'])),
 'mata_pelajaran'=>options(dbAll('SELECT nama FROM mata_pelajaran ORDER BY nama'),'nama','nama'),
 'status'=> $entity==='siswa'?['aktif'=>'Aktif','lulus'=>'Lulus','pindah'=>'Pindah','cuti'=>'Cuti']:($entity==='guru'?['aktif'=>'Aktif','cuti'=>'Cuti','nonaktif'=>'Nonaktif']:($entity==='orangtua'?['pending'=>'Menunggu','approved'=>'Disetujui','rejected'=>'Ditolak']:['aktif'=>'Aktif','nonaktif'=>'Nonaktif']))
];
$optional=['nisn','tempat_lahir','tanggal_lahir','orangtua_id','tahun_masuk','email','user_id','wali_kelas_id','kode'];
$types=['tanggal_lahir'=>'date','email'=>'email','password'=>'password','jam_mulai'=>'time','jam_selesai'=>'time','tingkat'=>'number','tahun_masuk'=>'number'];
$error=''; $edit=null;
if ($_SERVER['REQUEST_METHOD']==='POST') {
 try {
  getDB()->begin_transaction();
  $id=(int)($_POST['id']??0);
  $old=$id?dbOne("SELECT * FROM $entity WHERE id=? FOR UPDATE",[$id]):null;
  need(!$id || (bool)$old,'Data tidak ditemukan.');
  if(($_POST['action']??'')==='delete') {
   need(!($entity==='users' && $id===(int)$_SESSION['user_id']),'Akun yang sedang digunakan tidak dapat dihapus.');
   if($entity==='users') need(!dbOne('SELECT id FROM guru WHERE user_id=?',[$id]) && !dbOne('SELECT id FROM orangtua WHERE user_id=?',[$id]),'Akun masih terhubung ke guru/orang tua. Nonaktifkan akun untuk menjaga riwayat.');
   if($entity==='siswa') need(!dbOne('SELECT id FROM absensi_siswa WHERE siswa_id=? LIMIT 1',[$id]) && !dbOne('SELECT id FROM nilai WHERE siswa_id=? LIMIT 1',[$id]) && !dbOne('SELECT id FROM notes WHERE siswa_id=? LIMIT 1',[$id]) && !dbOne('SELECT id FROM penilaian_harian WHERE siswa_id=? LIMIT 1',[$id]),'Siswa memiliki riwayat. Ubah status menjadi pindah/lulus untuk mempertahankannya.');
   if($entity==='kelas') need(!dbOne('SELECT id FROM jadwal WHERE kelas_id=? LIMIT 1',[$id]),'Kelas masih memiliki jadwal.');
   if($entity==='orangtua') need(!dbOne('SELECT id FROM siswa WHERE orangtua_id=? LIMIT 1',[$id]) && !dbOne('SELECT id FROM pendaftaran_anak WHERE orangtua_id=? LIMIT 1',[$id]),'Orang tua masih terhubung ke data anak.');
   if($entity==='mata_pelajaran') need(!dbOne('SELECT id FROM jadwal WHERE mata_pelajaran=? LIMIT 1',[$old['nama']]) && !dbOne('SELECT id FROM nilai WHERE mata_pelajaran=? LIMIT 1',[$old['nama']]) && !dbOne('SELECT id FROM penilaian_harian WHERE mata_pelajaran=? LIMIT 1',[$old['nama']]),'Mata pelajaran masih digunakan.');
   dbRun("DELETE FROM $entity WHERE id=?",[$id]);
  } else {
   $data=[];
   foreach($fields as $key=>$label) {
    if($key==='password' && $id && empty($_POST[$key])) continue;
    $max=in_array($key,['nis','nisn','nip','kode','tahun_ajaran'])?20:($key==='nama_kelas'?10:($key==='username'?50:100));
    $v=textInput($key,$max,!in_array($key,$optional));
    if(isset($choices[$key]) && $v!=='') need(isset($choices[$key][$v]),"Pilihan $label tidak valid.");
    if($key==='email' && $v!=='') need((bool)filter_var($v,FILTER_VALIDATE_EMAIL),'Format email tidak valid.');
    if($key==='nomor_hp') need((bool)preg_match('/^(?:0|62|\+62)[0-9]{8,14}$/',$v),'Nomor HP tidak valid. Gunakan angka tanpa spasi.');
    if($key==='nisn' && $v!=='') need((bool)preg_match('/^\d{10}$/',$v),'NISN harus terdiri dari 10 digit.');
    if($key==='tanggal_lahir' && $v!=='') need(validDate($v) && $v<date('Y-m-d'),'Tanggal lahir tidak valid.');
    if($key==='tahun_ajaran') need((bool)preg_match('/^(\d{4})\/(\d{4})$/',$v,$matches) && (int)$matches[2]===(int)$matches[1]+1,'Tahun ajaran harus berurutan, misalnya 2026/2027.');
    if($key==='tingkat') need(ctype_digit($v) && (int)$v>=1 && (int)$v<=6,'Tingkat harus 1 sampai 6.');
    if($key==='tahun_masuk' && $v!=='') need(ctype_digit($v) && (int)$v>=1901 && (int)$v<=(int)date('Y'),'Tahun masuk tidak valid.');
    if($key==='password') { need(strlen($v)>=8,'Password minimal 8 karakter.'); $v=hashPassword($v); }
    $data[$key]=$v===''?null:$v;
   }
   if($entity==='guru' && $data['user_id']) need(!dbOne('SELECT id FROM guru WHERE user_id=? AND id<>?',[$data['user_id'],$id]),'Akun sudah digunakan guru lain.');
   if($entity==='siswa' && $data['nisn']) need(!dbOne('SELECT id FROM siswa WHERE nisn=? AND id<>?',[$data['nisn'],$id]),'NISN sudah terdaftar pada siswa lain.');
   if($entity==='orangtua' && $data['user_id']) {
    need(!dbOne('SELECT id FROM orangtua WHERE user_id=? AND id<>?',[$data['user_id'],$id]),'Akun sudah digunakan orang tua lain.');
    dbRun('UPDATE users SET status=? WHERE id=?',[$data['status']==='approved'?'aktif':'nonaktif',$data['user_id']]);
   }
   if($entity==='users' && $old) {
    need($id!==(int)$_SESSION['user_id'] || ($data['role']==='admin' && $data['status']==='aktif'),'Akun sendiri harus tetap admin aktif.');
    if($data['role']!==$old['role']) need(!dbOne('SELECT id FROM guru WHERE user_id=?',[$id]) && !dbOne('SELECT id FROM orangtua WHERE user_id=?',[$id]),'Peran akun yang terhubung tidak dapat diubah.');
   }
   if($entity==='mata_pelajaran' && $old && $old['nama']!==$data['nama']) {
    foreach(['jadwal','nilai','penilaian_harian','guru'] as $t) dbRun("UPDATE $t SET mata_pelajaran=? WHERE mata_pelajaran=?",[$data['nama'],$old['nama']]);
   }
   if($entity==='jadwal') {
    dbRun('SELECT id FROM kelas WHERE id=? FOR UPDATE',[$data['kelas_id']]);
    dbRun('SELECT id FROM guru WHERE id=? FOR UPDATE',[$data['guru_id']]);
    need((bool)preg_match('/^\d{2}:\d{2}(:\d{2})?$/',$data['jam_mulai']) && (bool)preg_match('/^\d{2}:\d{2}(:\d{2})?$/',$data['jam_selesai']) && $data['jam_mulai']<$data['jam_selesai'],'Jam selesai harus setelah jam mulai.');
    need(!dbOne('SELECT id FROM jadwal WHERE id<>? AND hari=? AND semester=? AND tahun_ajaran=? AND (kelas_id=? OR guru_id=?) AND jam_mulai<? AND jam_selesai>?',[$id,$data['hari'],$data['semester'],$data['tahun_ajaran'],$data['kelas_id'],$data['guru_id'],$data['jam_selesai'],$data['jam_mulai']]),'Jadwal bentrok dengan kelas atau guru pada waktu yang sama.');
   }
   $columns=array_keys($data);
   if($id) dbRun("UPDATE $entity SET ".implode(',',array_map(fn($c)=>"$c=?",$columns)).' WHERE id=?',[...array_values($data),$id]);
   else dbRun("INSERT INTO $entity (".implode(',',$columns).') VALUES ('.implode(',',array_fill(0,count($columns),'?')).')',array_values($data));
  }
  getDB()->commit(); flash('Data berhasil '.(($_POST['action']??'')==='delete'?'dihapus.':'disimpan.')); redirectHere();
 } catch(Throwable $ex) { getDB()->rollback(); $error=actionError($ex); $edit=$_POST; }
}
if(isset($_GET['edit'])) $edit=dbOne("SELECT * FROM $entity WHERE id=?",[(int)$_GET['edit']]);
$search=trim((string)($_GET['q']??''));
$where="$sort LIKE ?"; $params=['%'.$search.'%'];
if($entity==='siswa' && !empty($_GET['kelas_id'])) { $where.=' AND kelas_id=?'; $params[]=(int)$_GET['kelas_id']; }
if($entity==='siswa') foreach(['status','jenis_kelamin'] as $key) if(!empty($_GET[$key])){$where.=" AND $key=?";$params[]=(string)$_GET[$key];}
$rows=dbAll("SELECT * FROM $entity WHERE $where ORDER BY $sort",$params);
pageStart($title,'Kelola data sekolah yang terhubung dengan presensi dan laporan.');
if($error) echo '<div class="message error" role="alert">'.e($error).'</div>';
stats(['Jumlah data'=>count($rows),'Tahun ajaran'=>schoolYear()]);
filterForm(['q'=>['Cari '.($entity==='siswa'?'nama siswa':'data'),'search'],...($entity==='siswa'?['kelas_id'=>['Kelas',$choices['kelas_id']],'status'=>['Status',$choices['status']],'jenis_kelamin'=>['Jenis Kelamin',$choices['jenis_kelamin']]]:[])]);
?>
<details class="card editor" <?=($edit||$error)?'open':''?>><summary><?=$edit?'Edit Data':'Tambah '.e($title)?></summary><form method="post" class="form-grid"><?=csrfField()?><input type="hidden" name="id" value="<?=e($edit['id']??'')?>"><?php foreach($fields as $key=>$label) {
 $value=$key==='password'?'':($edit[$key]??($key==='tahun_ajaran'?schoolYear():''));
 $required=!in_array($key,$optional) && !($key==='password' && $edit);
 if(isset($choices[$key])) selectField($key,$label,$choices[$key],$value,$required); else field($key,$key==='password' && $edit?'Password baru (kosongkan jika tetap)':$label,$value,$types[$key]??'text',$required);
}?><div class="form-actions"><button class="btn">Simpan Data</button><a class="btn btn--ghost" href="<?=e(strtok($_SERVER['REQUEST_URI'],'?'))?>">Batal</a></div></form></details>
<section><h2 class="section-title">Daftar <?=e($title)?></h2><div class="table-wrapper" tabindex="0"><table><thead><tr><?php $visible=array_diff_key($fields,array_flip(['password','tempat_lahir','tanggal_lahir','tahun_masuk']));foreach($visible as $label):?><th><?=e($label)?></th><?php endforeach;?><th>Aksi</th></tr></thead><tbody>
<?php if(!$rows):?><tr><td class="empty-state" colspan="<?=count($visible)+1?>">Belum ada data. Gunakan tombol tambah di atas.</td></tr><?php endif;foreach($rows as $row):?><tr><?php foreach($visible as $key=>$label):?><td><?=e($choices[$key][$row[$key]]??$row[$key]??'-')?></td><?php endforeach;?><td><div class="row-actions"><a class="btn btn--ghost btn--small" href="?edit=<?=$row['id']?>">Edit</a><?php if($entity==='siswa'):?><a class="btn btn--ghost btn--small" href="<?=BASE_URL?>/kartu-qr.php?siswa_id=<?=$row['id']?>">Kartu QR</a><?php endif;?><form method="post" data-confirm="Hapus data ini? Data yang masih digunakan akan dipertahankan."><?=csrfField()?><input type="hidden" name="id" value="<?=$row['id']?>"><button class="btn btn--ghost btn--small" name="action" value="delete">Hapus</button></form></div></td></tr><?php endforeach;?></tbody></table></div></section>
<?php pageEnd();
