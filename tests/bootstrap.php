<?php
// Run only against an explicitly selected disposable test database.
if(PHP_SAPI!=='cli')exit;
$name=getenv('DB_NAME');if(!$name||!preg_match('/^anita_test_[a-z0-9_]+$/',$name))exit("Set DB_NAME=anita_test_<name> first.\n");
$db=new mysqli(getenv('DB_HOST')?:'localhost',getenv('DB_USER')?:'root',getenv('DB_PASS')?:'');
$db->query("CREATE DATABASE `$name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");$db->select_db($name);
$sql=file_get_contents(__DIR__.'/../database.sql');$sql=preg_replace('/CREATE DATABASE IF NOT EXISTS[^;]+;|USE sdn1unduolo;/','',$sql);$sql=substr($sql,0,strpos($sql,'-- Insert Data Default'));
$db->multi_query($sql);do{if($r=$db->store_result())$r->free();}while($db->more_results()&&$db->next_result());
require __DIR__.'/../config/app.php';require __DIR__.'/../scripts/migrate.php';
foreach([['admin','admin'],['guru','guru'],['guru2','guru'],['kepala','kepalasekolah'],['ortu','orangtua'],['ortu2','orangtua']] as [$user,$role])dbRun('INSERT INTO users (username,password,role,nama_lengkap,status,email) VALUES (?,?,?,?,?,?)',[$user,hashPassword('TestPass123!'),$role,'Uji '.$user,'aktif',$user.'@example.test']);
dbRun("INSERT INTO guru (nip,nama,user_id,mata_pelajaran) VALUES ('T001','Guru Uji',2,'Matematika'),('T002','Guru Lain',3,'Matematika')");
dbRun("INSERT INTO kelas (nama_kelas,tingkat,wali_kelas_id,tahun_ajaran) VALUES ('1A',1,1,?),('2A',2,2,?)",[schoolYear(),schoolYear()]);
dbRun("INSERT INTO mata_pelajaran (nama,kode) VALUES ('Matematika','MAT')");
dbRun("INSERT INTO orangtua (nama,alamat,nomor_hp,user_id,status) VALUES ('Ortu Uji','Alamat uji','081234567890',5,'approved'),('Ortu Lain','Alamat lain','081234567891',6,'approved')");
dbRun("INSERT INTO siswa (nis,nisn,nama_lengkap,jenis_kelamin,kelas_id,orangtua_id,status) VALUES ('T001','0000000001','Anak Uji','Perempuan',1,1,'aktif'),('T002','0000000002','Anak Rahasia','Laki-laki',2,2,'aktif'),('T003','0000000003','Anak Kedua','Laki-laki',1,1,'aktif')");
$semester=(int)date('n')>=7?'ganjil':'genap';
dbRun("INSERT INTO jadwal (kelas_id,hari,jam_mulai,jam_selesai,mata_pelajaran,guru_id,semester,tahun_ajaran) VALUES (1,'Senin','07:00','09:00','Matematika',1,?,?),(2,'Senin','07:00','09:00','Matematika',2,?,?)",[$semester,schoolYear(),$semester,schoolYear()]);
echo "Test fixtures ready: $name\n";
