<?php
require __DIR__.'/../config/app.php';requireRole(['admin','guru']);header('Content-Type: application/json; charset=utf-8');
if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);header('Allow: POST');echo json_encode(['ok'=>false,'message'=>'Gunakan POST.']);exit;}
try {
 $code=textInput('code',100);$direction=textInput('direction',10);need(in_array($direction,['masuk','pulang'],true),'Jenis presensi tidak valid.');
 $token=str_starts_with($code,'ANITA:')?substr($code,6):$code;
 $qr=dbOne('SELECT siswa_id FROM qr_tokens WHERE token=?',[$token]);
 if($qr)$s=student((int)$qr['siswa_id']);else {$row=dbOne("SELECT s.id FROM siswa s WHERE s.nis=? AND s.status='aktif' AND ".classScope(),[$code]);need((bool)$row,'Kartu QR atau NIS tidak dikenali dalam kelas Anda.');$s=student((int)$row['id']);}
 need($s['status']==='aktif','Siswa tidak aktif.');
 getDB()->begin_transaction();dbRun('SELECT id FROM siswa WHERE id=? FOR UPDATE',[$s['id']]);
 $date=date('Y-m-d');$existing=dbOne('SELECT * FROM absensi_siswa WHERE siswa_id=? AND tanggal=? FOR UPDATE',[$s['id'],$date]);
 if($direction==='masuk') {
  if($existing){need($existing['status']==='hadir','Status '.$existing['status'].' sudah tercatat. Koreksi melalui formulir presensi.');$message='Sudah tercatat hadir pada '.$existing['jam_masuk'].'.';}
  else {saveAttendance((int)$s['id'],$date,'hadir','Presensi QR / NIS oleh petugas');$message='Presensi masuk berhasil disimpan.';}
 } else {
  need($existing && $existing['status']==='hadir','Presensi masuk belum tercatat.');
  if($existing['jam_keluar'])$message='Sudah tercatat pulang pada '.$existing['jam_keluar'].'.';
  else{dbRun('UPDATE absensi_siswa SET jam_keluar=? WHERE id=?',[date('H:i:s'),$existing['id']]);$message='Presensi pulang berhasil disimpan.';}
 }
 getDB()->commit();echo json_encode(['ok'=>true,'message'=>$s['nama_lengkap'].' · '.$message]);
}catch(Throwable $ex){getDB()->rollback();http_response_code(422);echo json_encode(['ok'=>false,'message'=>actionError($ex)]);}
