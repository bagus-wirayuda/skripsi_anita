<?php
require __DIR__.'/ui.php';requireRole($reportRoles??['admin','guru','kepalasekolah']);
$start=(string)($_GET['dari']??date('Y-m-01'));$end=(string)($_GET['sampai']??date('Y-m-d'));$class=(int)($_GET['kelas_id']??0);$search=trim((string)($_GET['q']??''));$status=(string)($_GET['status']??'');$year=(string)($_GET['tahun_ajaran']??schoolYear());$semester=(string)($_GET['semester']??'');
$types=['siswa'=>'Laporan Absensi Siswa','guru'=>'Laporan Absensi Guru','gabungan'=>'Laporan Seluruh Absensi','nilai'=>'Laporan Akademik','kelas'=>'Laporan Performa Kelas','evaluasi'=>'Evaluasi Pembelajaran','harian'=>'Laporan Penilaian Harian','catatan'=>'Laporan Catatan'];
$type=$_GET['jenis']??$reportType; if(!isset($types[$type]))$type=$reportType;
if($_SESSION['role']==='guru' && in_array($type,['guru','gabungan']))$type='siswa';
$headers=[];$rows=[];$error='';
try {
 need(validDate($start)&&validDate($end)&&$start<=$end,'Rentang tanggal tidak valid.');
 need($status===''||in_array($status,['hadir','izin','sakit','alpa'],true),'Status tidak valid.');
 $scope=classScope();$p=[];
 if($class){$scope.=' AND s.kelas_id=?';$p[]=$class;}
 if($search!==''){$scope.=' AND (s.nama_lengkap LIKE ? OR s.nis LIKE ?)';$p[]='%'.$search.'%';$p[]='%'.$search.'%';}
 $schoolYearSql=' AND n.tahun_ajaran=?';$np=[$year];if($semester!==''){$schoolYearSql.=' AND n.semester=?';$np[]=$semester;}
 if(in_array($type,['siswa','gabungan'])) {
  $headers=['Tanggal','NIS','Nama','Kelas','Status','Masuk','Pulang','Keterangan'];
  $sql="SELECT a.tanggal,s.nis,s.nama_lengkap,k.nama_kelas,a.status,a.jam_masuk,a.jam_keluar,a.keterangan FROM absensi_siswa a JOIN siswa s ON s.id=a.siswa_id JOIN kelas k ON k.id=s.kelas_id WHERE $scope AND a.tanggal BETWEEN ? AND ?";
  $args=[...$p,$start,$end];if($status!==''){$sql.=' AND a.status=?';$args[]=$status;}
  $rows=array_map('array_values',dbAll($sql.' ORDER BY a.tanggal DESC,k.nama_kelas,s.nama_lengkap',$args));
 }
 if(in_array($type,['guru','gabungan'])) {
  $sql='SELECT a.tanggal,g.nip,g.nama,a.status,a.jam_masuk,a.keterangan FROM absensi_guru a JOIN guru g ON g.id=a.guru_id WHERE a.tanggal BETWEEN ? AND ?';$args=[$start,$end];
  if($status!==''){$sql.=' AND a.status=?';$args[]=$status;}if($search!==''){$sql.=' AND (g.nama LIKE ? OR g.nip LIKE ?)';$args[]='%'.$search.'%';$args[]='%'.$search.'%';}
  if($class){$sql.=' AND (g.id IN (SELECT guru_id FROM jadwal WHERE kelas_id=?) OR g.id IN (SELECT wali_kelas_id FROM kelas WHERE id=?))';$args[]=$class;$args[]=$class;}
  $teachers=dbAll($sql.' ORDER BY a.tanggal DESC,g.nama',$args);
  if($type==='guru'){$headers=['Tanggal','NIP','Guru','Status','Masuk','Keterangan'];$rows=array_map('array_values',$teachers);}else {foreach($teachers as $g)$rows[]=[$g['tanggal'],$g['nip'],$g['nama'],'Guru',$g['status'],$g['jam_masuk'],null,$g['keterangan']];usort($rows,fn($a,$b)=>strcmp($b[0],$a[0]));}
 }
 if($type==='nilai') {
  $headers=['NIS','Siswa','Kelas','Mata Pelajaran','Semester','Tahun Ajaran','Harian','Ulangan','Rata-rata','Guru'];
  $rows=array_map('array_values',dbAll("SELECT s.nis,s.nama_lengkap,k.nama_kelas,n.mata_pelajaran,n.semester,n.tahun_ajaran,n.nilai_harian,n.nilai_ulangan,n.nilai_rata,g.nama FROM nilai n JOIN siswa s ON s.id=n.siswa_id JOIN kelas k ON k.id=s.kelas_id JOIN guru g ON g.id=n.guru_id WHERE $scope $schoolYearSql ORDER BY k.nama_kelas,s.nama_lengkap,n.mata_pelajaran",[...$p,...$np]));
 }
 if(in_array($type,['kelas','evaluasi'])) {
  $headers=['Kelas','Siswa','Hadir','Izin','Sakit','Alpa','Kehadiran (%)','Rata-rata Nilai','Rating Harian (1–5)'];
  $roster=dbAll("SELECT s.id,s.kelas_id,k.nama_kelas FROM siswa s JOIN kelas k ON k.id=s.kelas_id WHERE $scope AND s.status='aktif'",$p);
  $groups=[];foreach($roster as $s){$k=$s['kelas_id'];if(!isset($groups[$k]))$groups[$k]=['name'=>$s['nama_kelas'],'ids'=>[]];$groups[$k]['ids'][]=(int)$s['id'];}
  foreach($groups as $g){$ids=implode(',',$g['ids']);$a=dbOne("SELECT COUNT(*) total,SUM(status='hadir') hadir,SUM(status='izin') izin,SUM(status='sakit') sakit,SUM(status='alpa') alpa FROM absensi_siswa WHERE siswa_id IN ($ids) AND tanggal BETWEEN ? AND ?",[$start,$end]);$n=dbOne("SELECT AVG(n.nilai_rata) avg FROM nilai n WHERE n.siswa_id IN ($ids) $schoolYearSql",$np);$d=dbOne("SELECT AVG(rating) avg FROM penilaian_harian WHERE siswa_id IN ($ids) AND tanggal BETWEEN ? AND ?",[$start,$end]);$rows[]=[$g['name'],count($g['ids']),$a['hadir']??0,$a['izin']??0,$a['sakit']??0,$a['alpa']??0,$a['total']?round(100*$a['hadir']/$a['total'],1):'-',$n['avg']!==null?round($n['avg'],2):'-',$d['avg']!==null?round($d['avg'],2):'-'];}
 }
 if($type==='harian'){$headers=['Tanggal','Siswa','Kelas','Mata Pelajaran','Rating','Catatan','Guru'];$rows=array_map('array_values',dbAll("SELECT n.tanggal,s.nama_lengkap,k.nama_kelas,n.mata_pelajaran,n.rating,n.keterangan,g.nama FROM penilaian_harian n JOIN siswa s ON s.id=n.siswa_id JOIN kelas k ON k.id=s.kelas_id JOIN guru g ON g.id=n.guru_id WHERE $scope AND n.tanggal BETWEEN ? AND ? ORDER BY n.tanggal DESC,s.nama_lengkap",[...$p,$start,$end]));}
 if($type==='catatan'){$headers=['Tanggal','Siswa','Kelas','Kategori','Judul','Isi','Guru'];$rows=array_map('array_values',dbAll("SELECT n.tanggal,s.nama_lengkap,k.nama_kelas,n.kategori,n.judul,n.isi,g.nama FROM notes n JOIN siswa s ON s.id=n.siswa_id JOIN kelas k ON k.id=s.kelas_id JOIN guru g ON g.id=n.guru_id WHERE $scope AND n.tanggal BETWEEN ? AND ? ORDER BY n.tanggal DESC,s.nama_lengkap",[...$p,$start,$end]));}
 if(($_GET['export']??'')==='xlsx'){require __DIR__.'/export.php';exportXlsx('laporan-'.$type.'-'.date('Ymd'),$headers,$rows);}
}catch(Throwable $ex){$error=actionError($ex);}
pageStart($types[$type],'Laporan berdasarkan data tersimpan dan filter yang dipilih.');
if($error)echo '<div class="message error">'.e($error).'</div>';
$allowedTypes=$types;if($_SESSION['role']==='guru'){unset($allowedTypes['guru'],$allowedTypes['gabungan']);}
filterForm(['jenis'=>['Jenis Laporan',$allowedTypes,$type],'kelas_id'=>['Kelas',options(classes(),'nama_kelas')],'q'=>['Cari Nama / Nomor Induk','search'],...($type!=='nilai'?['dari'=>['Dari','date',$start],'sampai'=>['Sampai','date',$end]]:[]),...(in_array($type,['siswa','guru','gabungan'])?['status'=>['Status',['hadir'=>'Hadir','izin'=>'Izin','sakit'=>'Sakit','alpa'=>'Alpa']]]:[]),...(in_array($type,['nilai','kelas','evaluasi'])?['tahun_ajaran'=>['Tahun Ajaran','text',$year],'semester'=>['Semester',['ganjil'=>'Ganjil','genap'=>'Genap'],$semester]]:[])]);
echo '<p class="report-period">'.e($types[$type]).' · '.($type==='nilai'?e($year.' '.$semester):e($start.' s.d. '.$end)).' · '.count($rows).' baris</p>';
if(!$error){?><div class="form-actions"><a class="btn" href="?<?=e(http_build_query([...$_GET,'jenis'=>$type,'export'=>'xlsx']))?>">Unduh Excel</a><button class="btn btn--ghost" data-print>Cetak / Simpan PDF</button><?php if($_SESSION['role']==='admin' && $type==='siswa'):?><a class="btn btn--ghost" href="input-presensi.php">Input Presensi</a><?php endif;?></div><?php tableView($headers,$rows);}
if(in_array($type,['kelas','evaluasi']))echo '<p class="muted">Persentase kehadiran menggunakan jumlah entri presensi pada periode, bukan jumlah hari kalender. Nilai mengikuti tahun ajaran dan semester.</p>';
pageEnd();
