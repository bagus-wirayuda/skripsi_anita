"""HTTP regression tests. Requires tests/bootstrap.php and a server using the test DB."""
import os, re, json, urllib.request, urllib.parse, urllib.error, http.cookiejar, zipfile, io, subprocess
from datetime import datetime, timezone, timedelta
from pathlib import Path

BASE=os.environ.get('TEST_URL','http://127.0.0.1:8097')
DB=os.environ.get('DB_NAME','')
assert re.fullmatch(r'anita_test_[a-z0-9_]+',DB), 'Use a disposable test database.'
MYSQL=os.environ.get('MYSQL_BIN',r'C:/laragon/bin/mysql/mysql-8.0.30-winx64/bin/mysql.exe')
today=datetime.now(timezone(timedelta(hours=8))).strftime('%Y-%m-%d')
y=int(today[:4])-(int(today[5:7])<7);year=f'{y}/{y+1}';semester='ganjil' if int(today[5:7])>=7 else 'genap'
checks=0
def check(ok, label):
 global checks
 assert ok, label
 checks+=1
 print('PASS',label,flush=True)
def sql(statement):
 return subprocess.check_output([MYSQL,'-u','root','-N','-B',DB,'-e',statement],text=True,encoding='utf-8').strip()
class Client:
 def __init__(self,user=None):
  self.opener=urllib.request.build_opener(urllib.request.HTTPCookieProcessor(http.cookiejar.CookieJar()))
  if user:
   code,body=self.get('/login.php');token=self.token(body)
   code,body=self.post('/login.php',{'csrf':token,'username':user,'password':'TestPass123!'})
   check('Dashboard' in body and 'Password salah' not in body,'login '+user)
 def request(self,path,data=None,binary=False):
  try:
   r=self.opener.open(BASE+path,urllib.parse.urlencode(data).encode() if data is not None else None,timeout=30)
   code=r.status;body=r.read()
  except urllib.error.HTTPError as ex: code=ex.code;body=ex.read()
  if binary:return code,body
  body=body.decode('utf-8')
  check(not re.search(r'(Fatal error|Warning:|Deprecated:|Parse error)',body),'no PHP errors '+path)
  return code,body
 def get(self,path):return self.request(path)
 def post(self,path,data):return self.request(path,data)
 def token(self,body):return re.search(r'name="csrf" value="([a-f0-9]+)"',body)[1]
 def submit(self,path,data):
  code,body=self.get(path)
  return self.post(path,{'csrf':self.token(body),**data})

admin=Client('admin');guru=Client('guru');parent=Client('ortu');head=Client('kepala');anon=Client()
for role,client in [('admin',admin),('guru',guru),('orangtua',parent),('kepalasekolah',head)]:
 for file in Path(role).glob('*.php'):
  code,body=client.get('/'+file.as_posix());check(code==200,'page '+str(file))
code,body=anon.get('/admin/dashboard.php');check('loginForm' in body,'anonymous redirected')
code,body=parent.get('/admin/data-user.php');check(code==403,'role isolation')
code,body=admin.post('/admin/data-kelas.php',{'nama_kelas':'BAD'});check(code==419,'CSRF rejected')
code,body=admin.submit('/admin/data-kelas.php',{'nama_kelas':'3U','tingkat':'3','wali_kelas_id':'','tahun_ajaran':year})
check(sql("SELECT COUNT(*) FROM kelas WHERE nama_kelas='3U'")=='1','create class')
cid=sql("SELECT id FROM kelas WHERE nama_kelas='3U'")
admin.submit('/admin/data-kelas.php',{'id':cid,'nama_kelas':'3V','tingkat':'3','wali_kelas_id':'','tahun_ajaran':year})
check(sql(f'SELECT nama_kelas FROM kelas WHERE id={cid}')=='3V','update class')
admin.submit('/admin/data-kelas.php',{'id':cid,'action':'delete'})
check(sql(f'SELECT COUNT(*) FROM kelas WHERE id={cid}')=='0','delete unused class')
before=sql('SELECT COUNT(*) FROM jadwal')
code,body=admin.submit('/admin/jadwal.php',{'kelas_id':1,'hari':'Senin','jam_mulai':'08:00','jam_selesai':'10:00','mata_pelajaran':'Matematika','guru_id':1,'semester':semester,'tahun_ajaran':year})
check('bentrok' in body and sql('SELECT COUNT(*) FROM jadwal')==before,'overlapping schedule rejected')
att=f'/guru/presensi.php?kelas_id=1&tanggal={today}'
guru.submit(att,{'presensi[1]':'alpa','presensi[3]':'','keterangan[1]':'Uji alpa'})
check(sql('SELECT status FROM absensi_siswa WHERE siswa_id=1')=='alpa','attendance persisted')
check(sql("SELECT COUNT(*) FROM notification_queue WHERE status='pending'")=='1','absence queued, not sent')
guru.submit(att,{'presensi[1]':'alpa'})
check(sql('SELECT COUNT(*) FROM notification_queue')=='1','notification deduplicated')
guru.submit(att,{'presensi[1]':'hadir'})
check(sql('SELECT status FROM notification_queue')=='cancelled','corrected attendance cancels notification')
code,body=guru.submit(att,{'presensi[2]':'hadir'})
check(sql('SELECT COUNT(*) FROM absensi_siswa WHERE siswa_id=2')=='0','teacher cannot edit other class')
code,body=guru.get('/guru/presensi.php?kelas_id=2');check('Anak Rahasia' not in body,'teacher cannot view other class')
grade='/guru/nilai.php?'+urllib.parse.urlencode({'kelas_id':1,'mapel':'Matematika','semester':semester,'tahun_ajaran':year})
guru.submit(grade,{'scores[1][harian]':'80','scores[1][ulangan]':'90'})
check(sql('SELECT nilai_rata FROM nilai WHERE siswa_id=1')=='85.00','grade average persisted')
guru.submit(grade,{'scores[1][harian]':'100','scores[1][ulangan]':'90'})
check(sql('SELECT COUNT(*) FROM nilai WHERE siswa_id=1')=='1' and sql('SELECT nilai_rata FROM nilai WHERE siswa_id=1')=='95.00','grade edit does not duplicate')
guru.submit(grade,{'scores[1][harian]':'101','scores[1][ulangan]':'90'})
check(sql('SELECT nilai_rata FROM nilai WHERE siswa_id=1')=='95.00','invalid grade rejected')
daily='/guru/penilaian-harian.php?'+urllib.parse.urlencode({'kelas_id':1,'mapel':'Matematika','tanggal':today})
guru.submit(daily,{'scores[1]':'4','keterangan[1]':'Aktif'})
guru.submit(daily,{'scores[1]':'5','keterangan[1]':'Sangat aktif'})
check(sql('SELECT COUNT(*) FROM penilaian_harian')=='1' and sql('SELECT rating FROM penilaian_harian')=='5','daily assessment updates')
note='/guru/notes.php?kelas_id=1'
guru.submit(note,{'siswa_id':1,'kategori':'prestasi','tanggal':today,'judul':'Prestasi Uji','isi':'<script>alert(1)</script> Rajin belajar.'})
code,body=parent.get('/orangtua/notes.php?siswa_id=1')
check('Prestasi Uji' in body and '&lt;script&gt;' in body and '<script>alert(1)' not in body,'parent sees persisted escaped note')
code,body=parent.get('/orangtua/notes.php?siswa_id=2');check('Prestasi Uji' not in body and 'Anak Rahasia' not in body,'parent ownership enforced')
code,body=parent.get('/orangtua/perkembangan.php?siswa_id=1&'+urllib.parse.urlencode({'tahun_ajaran':year,'semester':semester}));check('95.00' in body,'parent sees real grades')
code,body=parent.get('/orangtua/penilaian-harian.php?siswa_id=1');check('Sangat aktif' in body,'parent sees real daily assessment')
code,body=parent.get('/kartu-qr.php?siswa_id=2');check(code==403,'QR ownership enforced')
code,body=parent.get('/kartu-qr.php?siswa_id=1');check('data-token="ANITA:' in body,'QR card generated')
code,body=admin.get('/presensi.php');token=re.search(r'data-csrf="([a-f0-9]+)"',body)[1]
qr=sql('SELECT token FROM qr_tokens WHERE siswa_id=1')
for direction in ['masuk','masuk','pulang','pulang']:
 code,body=admin.post('/api/presensi.php',{'csrf':token,'code':'ANITA:'+qr,'direction':direction});check(json.loads(body)['ok'],'QR '+direction)
check(sql('SELECT COUNT(*) FROM absensi_siswa WHERE siswa_id=1')=='1','QR scan deduplicated')
check(sql('SELECT jam_keluar IS NOT NULL FROM absensi_siswa WHERE siswa_id=1')=='1','checkout persisted')
code,body=admin.post('/api/presensi.php',{'csrf':token,'code':'invalid','direction':'masuk'});check(code==422,'invalid QR rejected')
admin.submit('/admin/absensi-guru.php?tanggal='+today,{'presensi[1]':'hadir'})
check(sql('SELECT COUNT(*) FROM absensi_guru')=='1','teacher attendance persisted')
for kind in ['siswa','guru','gabungan','nilai','kelas','evaluasi','harian','catatan']:
 code,body=head.get('/kepalasekolah/laporan.php?jenis='+kind);check(code==200,'report '+kind)
code,data=admin.request('/admin/laporan.php?jenis=siswa&export=xlsx',binary=True)
with zipfile.ZipFile(io.BytesIO(data)) as z:
 content=z.read('xl/worksheets/sheet1.xml').decode();check('Anak Uji' in content and 'inlineStr' in content,'valid Excel contains filtered records')
reg=Client();reg.submit('/register.php',{'username':'newparent','password':'TestPass123!','nama':'Orang Tua Baru','alamat':'Alamat Baru','nomor_hp':'081234567892'})
pid=sql("SELECT id FROM orangtua WHERE nama='Orang Tua Baru'")
check(bool(pid),'parent registration persisted')
code,body=reg.submit('/login.php',{'username':'newparent','password':'TestPass123!'});check('Username atau password salah' in body,'pending account cannot login')
admin.submit('/admin/pendaftaran.php',{'kind':'parent','id':pid,'decision':'approve'})
newparent=Client('newparent')
newparent.submit('/orangtua/data-anak.php',{'nama_lengkap':'Anak Baru','nisn':'0000000022','jenis_kelamin':'Perempuan','tempat_lahir':'Kolaka','tanggal_lahir':'2018-01-02','kelas_id':1})
requestid=sql("SELECT id FROM pendaftaran_anak WHERE nama_lengkap='Anak Baru'")
admin.submit('/admin/pendaftaran.php',{'kind':'child','id':requestid,'decision':'approve','nis':'T004','kelas_id':1,'catatan':'Disetujui'})
check(sql("SELECT COUNT(*) FROM siswa WHERE nis='T004'")=='1','child approval creates student')
code,body=newparent.get('/orangtua/data-anak.php');check('Anak Baru' in body and 'Cetak Kartu QR' in body,'approved child connected to parent')
admin.submit('/admin/pendaftaran.php',{'kind':'child','id':requestid,'decision':'approve','nis':'T005','kelas_id':1})
check(sql("SELECT COUNT(*) FROM siswa WHERE nama_lengkap='Anak Baru'")=='1','approval cannot duplicate student')
# Additional reference-data CRUD and session revocation checks.
admin.submit('/admin/mata-pelajaran.php',{'nama':'Sains Uji','kode':'UJI'})
mid=sql("SELECT id FROM mata_pelajaran WHERE kode='UJI'")
check(bool(mid),'create subject')
admin.submit('/admin/mata-pelajaran.php',{'id':mid,'nama':'Sains Baru','kode':'UJI'})
check(sql(f'SELECT nama FROM mata_pelajaran WHERE id={mid}')=='Sains Baru','edit subject')
admin.submit('/admin/mata-pelajaran.php',{'id':mid,'action':'delete'})
check(sql(f'SELECT COUNT(*) FROM mata_pelajaran WHERE id={mid}')=='0','delete unused subject')
admin.submit('/admin/data-user.php',{'username':'manualparent','password':'TestPass123!','nama_lengkap':'Manual Parent','email':'manual@example.test','role':'orangtua','status':'aktif'})
uid=sql("SELECT id FROM users WHERE username='manualparent'")
check(bool(uid),'create user')
admin.submit('/admin/data-orangtua.php',{'nama':'Manual Parent','alamat':'Alamat uji','nomor_hp':'081234567899','user_id':uid,'status':'approved'})
manualparent=Client('manualparent')
check(sql(f'SELECT COUNT(*) FROM orangtua WHERE user_id={uid}')=='1','manual parent linked')
admin.submit('/admin/data-guru.php',{'nip':'TMP001','nama':'Guru Sementara','email':'tmp@example.test','mata_pelajaran':'Matematika','user_id':'','status':'aktif'})
tid=sql("SELECT id FROM guru WHERE nip='TMP001'")
check(bool(tid),'create teacher')
admin.submit('/admin/data-guru.php',{'id':tid,'nip':'TMP001','nama':'Guru Sementara Baru','email':'tmp@example.test','mata_pelajaran':'Matematika','user_id':'','status':'cuti'})
check(sql(f'SELECT status FROM guru WHERE id={tid}')=='cuti','edit teacher')
admin.submit('/admin/data-guru.php',{'id':tid,'action':'delete'})
check(sql(f'SELECT COUNT(*) FROM guru WHERE id={tid}')=='0','delete unused teacher')
admin.submit('/admin/data-siswa.php',{'nis':'TMP001','nisn':'0000000099','nama_lengkap':'Siswa Sementara','jenis_kelamin':'Laki-laki','tempat_lahir':'Kolaka','tanggal_lahir':'2018-01-01','kelas_id':1,'orangtua_id':1,'tahun_masuk':'2026','status':'aktif'})
sid=sql("SELECT id FROM siswa WHERE nis='TMP001'")
check(bool(sid),'create student')
admin.submit('/admin/data-siswa.php',{'id':sid,'action':'delete'})
check(sql(f'SELECT COUNT(*) FROM siswa WHERE id={sid}')=='0','delete student without history')
admin.submit('/admin/data-siswa.php',{'id':1,'action':'delete'})
check(sql('SELECT COUNT(*) FROM siswa WHERE id=1')=='1','student history cannot be deleted')
code,body=head.get('/kepalasekolah/laporan.php?dari=invalid&sampai='+today)
check('Rentang tanggal tidak valid' in body,'invalid report dates rejected')
code,data=admin.request('/admin/laporan.php?jenis=siswa&kelas_id=2&export=xlsx',binary=True)
with zipfile.ZipFile(io.BytesIO(data)) as z:
 check('Anak Uji' not in z.read('xl/worksheets/sheet1.xml').decode(),'Excel respects class filter')
oldgrade=grade.replace(urllib.parse.quote_plus(year),'2024%2F2025')
code,body=guru.submit(oldgrade,{'scores[1][harian]':'50','scores[1][ulangan]':'50'})
check('belum ditugaskan' in body,'grading requires correct academic-year assignment')
otherteacher=Client('guru2')
admin.submit('/admin/data-user.php',{'id':3,'username':'guru2','password':'','nama_lengkap':'Uji guru2','email':'guru2@example.test','role':'guru','status':'nonaktif'})
code,body=otherteacher.get('/guru/dashboard.php');check('loginForm' in body,'disabled account session revoked')
print(f'PASSED {checks} checks',flush=True)
