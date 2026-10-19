<?php
require __DIR__.'/ui.php'; requireRole(['guru']);
$class=(int)($_GET['kelas_id']??0); $classList=classes();
$subject=(string)($_GET['mapel']??''); $date=(string)($_GET['tanggal']??date('Y-m-d'));
$semester=(string)($_GET['semester']??((int)date('n')>=7?'ganjil':'genap'));$year=(string)($_GET['tahun_ajaran']??schoolYear());
$error='';
if($_SERVER['REQUEST_METHOD']==='POST') try {
 getDB()->begin_transaction();
 need(in_array($class,array_column($classList,'id')),'Pilih kelas yang Anda ajar.');
 if($mode==='notes') {
  $id=(int)($_POST['id']??0);$old=$id?dbOne('SELECT * FROM notes WHERE id=? AND guru_id=? FOR UPDATE',[$id,relatedId()]):null;
  need(!$id||(bool)$old,'Catatan tidak ditemukan atau bukan milik Anda.');
  if($old) { $s=student((int)$old['siswa_id']);need((int)$s['kelas_id']===$class,'Kelas catatan tidak sesuai.'); }
  if(($_POST['action']??'')==='delete') {need((bool)$old,'Catatan tidak ditemukan.'); dbRun('DELETE FROM notes WHERE id=?',[$id]);}
  else {
   $sid=(int)($_POST['siswa_id']??0);$s=student($sid);need((int)$s['kelas_id']===$class,'Siswa tidak berada di kelas ini.');
   $category=textInput('kategori',20);need(in_array($category,['prestasi','perilaku','akademik','sosial','lainnya'],true),'Kategori tidak valid.');
   $date=textInput('tanggal',10);need(validDate($date)&&$date<=date('Y-m-d'),'Tanggal catatan tidak valid.');
   $values=[$sid,textInput('judul',200),textInput('isi',5000),$category,$date];
   if($id) dbRun('UPDATE notes SET siswa_id=?,judul=?,isi=?,kategori=?,tanggal=? WHERE id=? AND guru_id=?',[...$values,$id,relatedId()]);
   else dbRun('INSERT INTO notes (siswa_id,judul,isi,kategori,tanggal,guru_id) VALUES (?,?,?,?,?,?)',[...$values,relatedId()]);
  }
 } else {
  $assessmentYear=$mode==='nilai'?$year:((int)substr($date,0,4)-((int)substr($date,5,2)<7?1:0));
  if($mode!=='nilai')$assessmentYear=$assessmentYear.'/'.($assessmentYear+1);
  $assessmentSemester=$mode==='nilai'?$semester:((int)substr($date,5,2)>=7?'ganjil':'genap');
  need(canGrade($class,$subject,$assessmentYear,$assessmentSemester),'Mata pelajaran belum ditugaskan kepada Anda pada kelas, semester, dan tahun ajaran ini.');
  need(validDate($date)&&$date<=date('Y-m-d'),'Tanggal tidak valid.');
  need(in_array($semester,['ganjil','genap'],true),'Semester tidak valid.');
  need((bool)preg_match('/^(\d{4})\/(\d{4})$/',$year,$m) && (int)$m[2]===(int)$m[1]+1,'Tahun ajaran tidak valid.');
  $values=$_POST['scores']??[];need(is_array($values)&&count($values)>0,'Belum ada nilai yang diisi.');$saved=0;
  // Lock the class so two submissions cannot create duplicate assessments.
  dbRun('SELECT id FROM kelas WHERE id=? FOR UPDATE',[$class]);
  foreach($values as $sid=>$v) {
   $s=student((int)$sid);need((int)$s['kelas_id']===$class && $s['status']==='aktif','Siswa tidak sesuai kelas aktif.');
   if($mode==='nilai') {
    if(($v['harian']??'')==='' && ($v['ulangan']??'')==='') continue;
    need(is_numeric($v['harian']??null)&&is_numeric($v['ulangan']??null),'Isi kedua komponen nilai atau kosongkan keduanya.');
    $a=(float)$v['harian'];$b=(float)$v['ulangan'];need($a>=0&&$a<=100&&$b>=0&&$b<=100,'Nilai harus antara 0 dan 100.');
    $old=dbOne('SELECT id,guru_id FROM nilai WHERE siswa_id=? AND mata_pelajaran=? AND semester=? AND tahun_ajaran=?',[$sid,$subject,$semester,$year]);
    need(!$old||(int)$old['guru_id']===relatedId(),'Nilai telah diinput guru lain. Hubungi admin untuk penyesuaian penugasan.');
    if($old) dbRun('UPDATE nilai SET nilai_harian=?,nilai_ulangan=? WHERE id=?',[$a,$b,$old['id']]);
    else dbRun('INSERT INTO nilai (siswa_id,mata_pelajaran,semester,tahun_ajaran,nilai_harian,nilai_ulangan,guru_id) VALUES (?,?,?,?,?,?,?)',[$sid,$subject,$semester,$year,$a,$b,relatedId()]);
   } else {
    if($v==='') continue;
    need(ctype_digit((string)$v)&&(int)$v>=1&&(int)$v<=5,'Penilaian harus 1 sampai 5 bintang.');
    $note=(string)($_POST['keterangan'][$sid]??'');need(mb_strlen($note)<=1000,'Keterangan maksimal 1000 karakter.');
    $old=dbOne('SELECT id FROM penilaian_harian WHERE siswa_id=? AND guru_id=? AND tanggal=? AND mata_pelajaran=?',[$sid,relatedId(),$date,$subject]);
    if($old) dbRun('UPDATE penilaian_harian SET rating=?,keterangan=? WHERE id=?',[$v,$note,$old['id']]);
    else dbRun('INSERT INTO penilaian_harian (siswa_id,guru_id,tanggal,mata_pelajaran,rating,keterangan) VALUES (?,?,?,?,?,?)',[$sid,relatedId(),$date,$subject,$v,$note]);
   }$saved++;
  }need($saved>0,'Isi minimal satu penilaian.');
 }
 getDB()->commit();flash('Data berhasil disimpan dan dapat dilihat orang tua.');header('Location: '.strtok($_SERVER['REQUEST_URI'],'?').'?'.http_build_query($_GET));exit;
} catch(Throwable $ex){getDB()->rollback();$error=actionError($ex);}
$students=dbAll("SELECT s.* FROM siswa s WHERE s.kelas_id=? AND s.status='aktif' AND ".classScope().' ORDER BY s.nama_lengkap',[$class]);
$titles=['nilai'=>'Input Nilai Siswa','notes'=>'Catatan Guru','harian'=>'Penilaian Harian'];pageStart($titles[$mode],'Pilih kelas dan periode, kemudian simpan perubahan.');if($error)echo '<div class="message error">'.e($error).'</div>';
filterForm(['kelas_id'=>['Kelas',options($classList,'nama_kelas')],...($mode!=='notes'?['mapel'=>['Mata Pelajaran',options(subjects($class),'nama','nama')]]:[]),...($mode==='nilai'?['semester'=>['Semester',['ganjil'=>'Ganjil','genap'=>'Genap'],$semester],'tahun_ajaran'=>['Tahun Ajaran','text',$year]]:($mode==='harian'?['tanggal'=>['Tanggal','date',$date]]:[]))]);
if(!$class || !$students) {echo '<p class="card empty-state">Pilih kelas yang memiliki siswa aktif. Mata pelajaran mengikuti jadwal mengajar Anda.</p>';pageEnd();return;}
if($mode==='notes') {
 $edit=isset($_GET['edit'])?dbOne('SELECT n.* FROM notes n JOIN siswa s ON s.id=n.siswa_id WHERE n.id=? AND n.guru_id=? AND s.kelas_id=? AND '.classScope(),[(int)$_GET['edit'],relatedId(),$class]):null;
 $edit=$error?array_merge($edit??[],$_POST):$edit;
?><section class="card editor"><h2 class="section-title"><?=$edit?'Edit Catatan':'Tulis Catatan'?></h2><form method="post" class="form-grid"><?=csrfField()?><input type="hidden" name="id" value="<?=e($edit['id']??'')?>"><?php selectField('siswa_id','Siswa',options($students,'nama_lengkap'),$edit['siswa_id']??'');selectField('kategori','Kategori',array_combine(['prestasi','perilaku','akademik','sosial','lainnya'],['Prestasi','Perilaku','Akademik','Sosial','Lainnya']),$edit['kategori']??'');field('tanggal','Tanggal',$edit['tanggal']??date('Y-m-d'),'date');field('judul','Judul',$edit['judul']??'');?><label class="form-group full-width"><span>Isi Catatan</span><textarea name="isi" rows="5" maxlength="5000" required><?=e($edit['isi']??'')?></textarea></label><div class="form-actions"><button class="btn">Simpan Catatan</button></div></form></section>
<?php $notes=dbAll('SELECT n.*,s.nama_lengkap FROM notes n JOIN siswa s ON s.id=n.siswa_id WHERE n.guru_id=? AND s.kelas_id=? ORDER BY n.tanggal DESC,n.id DESC',[relatedId(),$class]);foreach($notes as $n):?>
<article class="card editor"><p class="muted"><?=e($n['tanggal'])?> · <?=e($n['nama_lengkap'])?> · <?=e($n['kategori'])?></p><h3><?=e($n['judul'])?></h3><p class="pre-wrap"><?=e($n['isi'])?></p><div class="row-actions"><a class="btn btn--ghost" href="?kelas_id=<?=$class?>&edit=<?=$n['id']?>">Edit</a><form method="post" data-confirm="Hapus catatan ini?"><?=csrfField()?><input type="hidden" name="id" value="<?=$n['id']?>"><button class="btn btn--ghost" name="action" value="delete">Hapus</button></form></div></article>
<?php endforeach;
} else {
 if(!$subject){echo '<p class="card empty-state">Pilih mata pelajaran kemudian tekan Terapkan.</p>';pageEnd();return;}
 $existing=$mode==='nilai'?dbAll('SELECT * FROM nilai WHERE mata_pelajaran=? AND semester=? AND tahun_ajaran=? AND siswa_id IN (SELECT id FROM siswa WHERE kelas_id=?)',[$subject,$semester,$year,$class]):dbAll('SELECT * FROM penilaian_harian WHERE guru_id=? AND mata_pelajaran=? AND tanggal=?',[relatedId(),$subject,$date]);$scores=array_column($existing,null,'siswa_id');
?><form method="post"><?=csrfField()?><div class="table-wrapper"><table><thead><tr><th>Nama Siswa</th><th>NIS</th><th><?=$mode==='nilai'?'Nilai Harian':'Rating'?></th><th><?=$mode==='nilai'?'Nilai Ulangan':'Keterangan'?></th></tr></thead><tbody><?php foreach($students as $s):$v=$scores[$s['id']]??[];?><tr><td><?=e($s['nama_lengkap'])?></td><td><?=e($s['nis'])?></td><?php if($mode==='nilai'):?><td><input aria-label="Nilai harian <?=e($s['nama_lengkap'])?>" class="input-inline" name="scores[<?=$s['id']?>][harian]" type="number" min="0" max="100" step="0.01" value="<?=e($_POST['scores'][$s['id']]['harian']??$v['nilai_harian']??'')?>"></td><td><input aria-label="Nilai ulangan <?=e($s['nama_lengkap'])?>" class="input-inline" name="scores[<?=$s['id']?>][ulangan]" type="number" min="0" max="100" step="0.01" value="<?=e($_POST['scores'][$s['id']]['ulangan']??$v['nilai_ulangan']??'')?>"></td><?php else:?><td><?php starField((int)$s['id'],$s['nama_lengkap'],$_POST['scores'][$s['id']]??$v['rating']??'');?></td><td><input aria-label="Keterangan <?=e($s['nama_lengkap'])?>" name="keterangan[<?=$s['id']?>]" maxlength="1000" value="<?=e($_POST['keterangan'][$s['id']]??$v['keterangan']??'')?>"></td><?php endif;?></tr><?php endforeach;?></tbody></table></div><div class="form-actions"><button class="btn">Simpan <?=$mode==='nilai'?'Nilai':'Penilaian'?></button></div></form>
<?php } pageEnd();
