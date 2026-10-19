<?php
require __DIR__.'/ui.php';requireRole(['guru','admin']);
$class=(int)($_GET['kelas_id']??0);$date=(string)($_GET['tanggal']??date('Y-m-d'));$error='';
$classList=classes();
if($_SERVER['REQUEST_METHOD']==='POST')try {
 need(in_array($class,array_column($classList,'id')),'Pilih kelas yang dapat Anda akses.');
 $data=$_POST['presensi']??[];need(is_array($data)&&count($data)>0,'Pilih minimal satu status presensi.');
 getDB()->begin_transaction();
  $saved=0; foreach($data as $id=>$status){if($status==='')continue;$s=student((int)$id);need((int)$s['kelas_id']===$class,'Siswa tidak sesuai kelas.');saveAttendance((int)$id,$date,(string)$status,(string)($_POST['keterangan'][$id]??''));$saved++;} need($saved>0,'Pilih minimal satu status presensi.');
 getDB()->commit();flash('Presensi '.$saved.' siswa berhasil disimpan.');header('Location: ?'.http_build_query(['kelas_id'=>$class,'tanggal'=>$date]));exit;
}catch(Throwable $ex){getDB()->rollback();$error=actionError($ex);}
pageStart('Presensi Siswa','Catat kehadiran harian. Status kosong berarti belum dipresensi.');
if($error)echo '<div class="message error">'.e($error).'</div>';
echo '<div class="form-actions"><a class="btn btn--ghost" href="'.BASE_URL.'/presensi.php">Buka Pemindai QR</a></div>';
filterForm(['kelas_id'=>['Kelas',options($classList,'nama_kelas')],'tanggal'=>['Tanggal','date',$date]]);
$students=dbAll("SELECT s.*,a.status attendance_status,a.keterangan FROM siswa s LEFT JOIN absensi_siswa a ON a.siswa_id=s.id AND a.tanggal=? WHERE s.kelas_id=? AND s.status='aktif' AND ".classScope().' ORDER BY s.nama_lengkap',[$date,$class]);
if(!$students)echo '<p class="card empty-state">Pilih kelas yang memiliki siswa aktif.</p>';else {?>
<form method="post"><?=csrfField()?><div class="table-wrapper"><table><thead><tr><th>Nama Siswa</th><th>NIS</th><th>Status</th><th>Keterangan</th></tr></thead><tbody><?php foreach($students as $s):?><tr><td><?=e($s['nama_lengkap'])?></td><td><?=e($s['nis'])?></td><td><?php selectField('presensi['.$s['id'].']','Kehadiran '.$s['nama_lengkap'],['hadir'=>'Hadir','izin'=>'Izin','sakit'=>'Sakit','alpa'=>'Alpa'],$_POST['presensi'][$s['id']]??$s['attendance_status'],false);?></td><td><input name="keterangan[<?=$s['id']?>]" aria-label="Keterangan <?=e($s['nama_lengkap'])?>" maxlength="1000" value="<?=e($_POST['keterangan'][$s['id']]??$s['keterangan'])?>"></td></tr><?php endforeach;?></tbody></table></div><div class="form-actions"><button class="btn">Simpan Presensi</button></div></form>
<?php }pageEnd();
