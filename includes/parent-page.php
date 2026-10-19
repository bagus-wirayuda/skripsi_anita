<?php
require __DIR__.'/ui.php';requireRole(['orangtua']);$error='';
if($_SERVER['REQUEST_METHOD']==='POST' && $mode==='data-anak')try {
 $nama=textInput('nama_lengkap',100);$nisn=textInput('nisn',20,false);$sex=textInput('jenis_kelamin',20);$birth=textInput('tanggal_lahir',10);$class=(int)($_POST['kelas_id']??0);
 need($nisn==='' || (bool)preg_match('/^\d{10}$/',$nisn),'NISN harus terdiri dari 10 digit.');
 need(in_array($sex,['Laki-laki','Perempuan'],true),'Jenis kelamin tidak valid.');need(validDate($birth)&&$birth<date('Y-m-d'),'Tanggal lahir tidak valid.');need((bool)dbOne('SELECT id FROM kelas WHERE id=?',[$class]),'Kelas tidak valid.');
 need(!dbOne("SELECT id FROM pendaftaran_anak WHERE orangtua_id=? AND nama_lengkap=? AND status='pending'",[relatedId(),$nama]),'Pengajuan anak ini masih menunggu validasi.');
 dbRun('INSERT INTO pendaftaran_anak (orangtua_id,nama_lengkap,nisn,jenis_kelamin,tempat_lahir,tanggal_lahir,kelas_id) VALUES (?,?,?,?,?,?,?)',[relatedId(),$nama,$nisn?:null,$sex,textInput('tempat_lahir',100,false),$birth,$class]);flash('Data anak diajukan. Admin akan memvalidasi sebelum kartu QR tersedia.');redirectHere();
}catch(Throwable $ex){$error=actionError($ex);}
$children=dbAll('SELECT s.*,k.nama_kelas,k.tahun_ajaran,g.nama wali FROM siswa s JOIN kelas k ON k.id=s.kelas_id LEFT JOIN guru g ON g.id=k.wali_kelas_id WHERE s.orangtua_id=? ORDER BY s.nama_lengkap',[relatedId()]);
$id=(int)($_GET['siswa_id']??($children[0]['id']??0));$child=null;foreach($children as $c)if((int)$c['id']===$id)$child=$c;
$titles=['dashboard'=>'Dashboard Orang Tua','data-anak'=>'Data Anak','perkembangan'=>'Perkembangan Anak','notes'=>'Pesan Guru','penilaian-harian'=>'Penilaian Harian'];
pageStart($titles[$mode],'Pantau kehadiran dan pembelajaran anak Anda.');if($error)echo '<div class="message error">'.e($error).'</div>';
if($mode==='data-anak'):?>
<details class="card editor" <?=$error?'open':''?>><summary>Ajukan Data Anak</summary><form method="post" class="form-grid"><?=csrfField()?><?php field('nama_lengkap','Nama Anak',$_POST['nama_lengkap']??'');field('nisn','NISN',$_POST['nisn']??'','text',false);selectField('jenis_kelamin','Jenis Kelamin',['Laki-laki'=>'Laki-laki','Perempuan'=>'Perempuan'],$_POST['jenis_kelamin']??'');field('tempat_lahir','Tempat Lahir',$_POST['tempat_lahir']??'','text',false);field('tanggal_lahir','Tanggal Lahir',$_POST['tanggal_lahir']??'','date');selectField('kelas_id','Kelas Tujuan',options(classes(),'nama_kelas'),$_POST['kelas_id']??'');?><div class="form-actions"><button class="btn">Ajukan untuk Validasi</button></div></form></details>
<?php tableView(['Pengajuan Anak','Status','Catatan Admin'],array_map(fn($p)=>[$p['nama_lengkap'],$p['status'],$p['catatan']],dbAll('SELECT * FROM pendaftaran_anak WHERE orangtua_id=? ORDER BY id DESC',[relatedId()])));endif;
if(!$children){echo '<p class="card empty-state">Belum ada anak yang terhubung. Ajukan data melalui menu Data Anak atau hubungi admin untuk menghubungkan siswa yang sudah terdaftar.</p>';pageEnd();return;}
$year=(string)($_GET['tahun_ajaran']??$child['tahun_ajaran']??schoolYear());$semester=(string)($_GET['semester']??((int)date('n')>=7?'ganjil':'genap'));
filterForm(['siswa_id'=>['Pilih Anak',options($children,'nama_lengkap'),$id],...($mode==='perkembangan'?['tahun_ajaran'=>['Tahun Ajaran','text',$year],'semester'=>['Semester',['ganjil'=>'Ganjil','genap'=>'Genap'],$semester]]:[])]);
if(!$child){echo '<p class="card empty-state">Anak tidak ditemukan dalam akun Anda.</p>';pageEnd();return;}
echo '<h2 class="section-title">'.e($child['nama_lengkap']).' · '.e($child['nama_kelas']).'</h2>';
$attendance=dbOne("SELECT COUNT(*) total,SUM(status='hadir') hadir,SUM(status='alpa') alpa FROM absensi_siswa WHERE siswa_id=? AND tanggal BETWEEN ? AND ?",[$id,date('Y-m-01'),date('Y-m-t')]);
$grades=dbAll('SELECT mata_pelajaran,nilai_harian,nilai_ulangan,nilai_rata FROM nilai WHERE siswa_id=? AND tahun_ajaran=? AND semester=? ORDER BY mata_pelajaran',[$id,$year,$semester]);
if(in_array($mode,['dashboard','perkembangan'])) {
 $avg=count($grades)?round(array_sum(array_column($grades,'nilai_rata'))/count($grades),2):'-';
 stats(['Kehadiran bulan ini'=>$attendance['total']?round(100*$attendance['hadir']/$attendance['total'],1).'%':'Belum tercatat','Rata-rata nilai'=>$avg,'Kelas'=>$child['nama_kelas']]);
 echo '<p class="muted">Kehadiran dihitung dari '.$attendance['total'].' hari yang sudah dicatat untuk anak ini. Nilai: '.e($semester).' '.e($year).'.</p>';
 $rows=dbAll('SELECT tanggal,status,jam_masuk,jam_keluar,keterangan FROM absensi_siswa WHERE siswa_id=? ORDER BY tanggal DESC LIMIT '.($mode==='dashboard'?'7':'100'),[$id]);
 echo '<h2 class="section-title">Riwayat Presensi</h2>';tableView(['Tanggal','Status','Masuk','Pulang','Keterangan'],array_map('array_values',$rows));
 if($mode==='perkembangan') {
  echo '<h2 class="section-title">Nilai per Mata Pelajaran</h2>';tableView(['Mata Pelajaran','Harian','Ulangan','Rata-rata'],array_map('array_values',$grades));
  echo '<h2 class="section-title">Rekap Bulanan</h2>';tableView(['Bulan','Tercatat','Hadir','Izin','Sakit','Alpa'],array_map('array_values',dbAll("SELECT DATE_FORMAT(tanggal,'%Y-%m') bulan,COUNT(*),SUM(status='hadir'),SUM(status='izin'),SUM(status='sakit'),SUM(status='alpa') FROM absensi_siswa WHERE siswa_id=? GROUP BY bulan ORDER BY bulan DESC",[$id])));
  echo '<div class="card"><h3>Perbandingan Nilai</h3>';foreach($grades as $g)echo '<label class="progress-row">'.e($g['mata_pelajaran']).'<progress max="100" value="'.e($g['nilai_rata']).'"></progress><strong>'.e($g['nilai_rata']).'</strong></label>';if(!$grades)echo '<p class="muted">Belum ada nilai pada periode ini.</p>';echo '</div>';
 }
}
if($mode==='data-anak') {
 $parent=dbOne('SELECT * FROM orangtua WHERE id=?',[relatedId()]);
 echo '<div class="grid grid-2"><article class="card"><h3>Identitas Siswa</h3><dl class="identity-list">';foreach(['nis'=>'NIS','nisn'=>'NISN','nama_lengkap'=>'Nama','jenis_kelamin'=>'Jenis Kelamin','tempat_lahir'=>'Tempat Lahir','tanggal_lahir'=>'Tanggal Lahir','status'=>'Status'] as $k=>$v)echo '<dt>'.e($v).'</dt><dd>'.e($child[$k]?:'-').'</dd>';echo '</dl><a class="btn" href="'.BASE_URL.'/kartu-qr.php?siswa_id='.$id.'">Cetak Kartu QR</a></article><article class="card"><h3>Informasi Orang Tua & Akademik</h3><dl class="identity-list">';foreach(['Orang Tua'=>$parent['nama'],'No. HP'=>$parent['nomor_hp'],'Alamat'=>$parent['alamat'],'Wali Kelas'=>$child['wali'],'Tahun Ajaran'=>$child['tahun_ajaran']] as $k=>$v)echo '<dt>'.e($k).'</dt><dd>'.e($v?:'-').'</dd>';echo '</dl></article></div>';
 echo '<h2 class="section-title">Jadwal Pelajaran</h2>';tableView(['Hari','Mulai','Selesai','Mata Pelajaran','Guru','Semester','Tahun Ajaran'],array_map('array_values',dbAll("SELECT j.hari,j.jam_mulai,j.jam_selesai,j.mata_pelajaran,g.nama,j.semester,j.tahun_ajaran FROM jadwal j JOIN guru g ON g.id=j.guru_id WHERE j.kelas_id=? AND j.tahun_ajaran=? ORDER BY FIELD(j.hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'),j.jam_mulai",[$child['kelas_id'],$child['tahun_ajaran']])));
}
if($mode==='notes') {
 $notes=dbAll('SELECT n.*,g.nama guru FROM notes n JOIN guru g ON g.id=n.guru_id WHERE n.siswa_id=? ORDER BY n.tanggal DESC,n.id DESC',[$id]);
 if(!$notes)echo '<p class="card empty-state">Belum ada catatan guru untuk anak ini.</p>';
 foreach($notes as $n)echo '<article class="card editor"><p class="muted">'.e($n['tanggal']).' · '.e($n['guru']).' · '.e(ucfirst($n['kategori'])).'</p><h3>'.e($n['judul']).'</h3><p class="pre-wrap">'.e($n['isi']).'</p></article>';
}
if($mode==='penilaian-harian') tableView(['Tanggal','Mata Pelajaran','Rating (1–5)','Catatan','Guru'],array_map('array_values',dbAll('SELECT p.tanggal,p.mata_pelajaran,p.rating,p.keterangan,g.nama FROM penilaian_harian p JOIN guru g ON g.id=p.guru_id WHERE p.siswa_id=? ORDER BY p.tanggal DESC,p.id DESC',[$id])));
pageEnd();
