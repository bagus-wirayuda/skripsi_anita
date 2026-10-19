<?php
require __DIR__.'/../includes/ui.php';requireRole(['guru']);
$year=(string)($_GET['tahun_ajaran']??schoolYear());$semester=(string)($_GET['semester']??((int)date('n')>=7?'ganjil':'genap'));
pageStart('Kelas Saya','Jadwal mengajar sesuai penugasan sekolah.');filterForm(['tahun_ajaran'=>['Tahun Ajaran','text',$year],'semester'=>['Semester',['ganjil'=>'Ganjil','genap'=>'Genap'],$semester]]);
tableView(['Hari','Kelas','Mata Pelajaran','Mulai','Selesai'],array_map('array_values',dbAll("SELECT j.hari,k.nama_kelas,j.mata_pelajaran,j.jam_mulai,j.jam_selesai FROM jadwal j JOIN kelas k ON k.id=j.kelas_id WHERE j.guru_id=? AND j.tahun_ajaran=? AND j.semester=? ORDER BY FIELD(j.hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'),j.jam_mulai",[relatedId(),$year,$semester])));pageEnd();
