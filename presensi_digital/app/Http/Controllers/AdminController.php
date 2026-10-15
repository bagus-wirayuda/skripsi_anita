<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Presensi;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\User;
use App\Models\Ortu;
use App\Models\OrtuRegister;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display admin dashboard with statistics
     */
    public function dashboard()
    {
        // Basic counts
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalOrtu = Ortu::count();
        $totalKelas = Kelas::count();
        $totalMapel = Mapel::distinct('kode_mapel')->count('kode_mapel');
        $totalUser = User::count();
        
        // Count by gender
        $siswaLaki = Siswa::where('jenis_kelamin', 'L')->count();
        $siswaPerempuan = Siswa::where('jenis_kelamin', 'P')->count();
        
        // Presensi statistics
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();
        $fourWeeksAgo = Carbon::now()->subWeeks(4);
        
        // Today's presensi
        $presensiHariIni = Presensi::whereDate('tanggal', $today)->count();
        $hadirHariIni = Presensi::whereDate('tanggal', $today)->where('status', 'hadir')->count();
        
        // This week's presensi
        $presensiMingguIni = Presensi::where('tanggal', '>=', $thisWeek)->count();
        $hadirMingguIni = Presensi::where('tanggal', '>=', $thisWeek)->where('status', 'hadir')->count();
        
        // This month's presensi
        $presensiBulanIni = Presensi::where('tanggal', '>=', $thisMonth)->count();
        $hadirBulanIni = Presensi::where('tanggal', '>=', $thisMonth)->where('status', 'hadir')->count();
        
        // Presensi by status (this month)
        $presensiIzin = Presensi::where('tanggal', '>=', $thisMonth)->where('status', 'izin')->count();
        $presensiSakit = Presensi::where('tanggal', '>=', $thisMonth)->where('status', 'sakit')->count();
        $presensiAlpha = Presensi::where('tanggal', '>=', $thisMonth)->where('status', 'alpha')->count();
        $presensiTerlambat = Presensi::where('tanggal', '>=', $thisMonth)->where('status', 'terlambat')->count();
        
        // Average attendance percentage (last 4 weeks)
        $totalPresensi = Presensi::where('tanggal', '>=', $fourWeeksAgo)
            ->where('status', 'hadir')
            ->count();
        $totalExpectedPresensi = Presensi::where('tanggal', '>=', $fourWeeksAgo)->count();
        $avgKehadiran = $totalExpectedPresensi > 0 
            ? round(($totalPresensi / $totalExpectedPresensi) * 100, 1) 
            : 0;
        
        // Persentase kehadiran hari ini
        $persentaseHariIni = $presensiHariIni > 0 
            ? round(($hadirHariIni / $presensiHariIni) * 100, 1) 
            : 0;
        
        // Persentase kehadiran minggu ini
        $persentaseMingguIni = $presensiMingguIni > 0 
            ? round(($hadirMingguIni / $presensiMingguIni) * 100, 1) 
            : 0;
        
        // Persentase kehadiran bulan ini
        $persentaseBulanIni = $presensiBulanIni > 0 
            ? round(($hadirBulanIni / $presensiBulanIni) * 100, 1) 
            : 0;

        // Count active parents (logged in within last 30 days)
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        $activeParents = User::where('role', 'ortu')
            ->where('updated_at', '>=', $thirtyDaysAgo)
            ->count();
        
        // Pending registrations
        $pendingPendaftaran = OrtuRegister::count();
        
        // Nilai statistics
        $totalNilai = Nilai::count();
        $rataRataNilai = Nilai::avg('nilai_akhir');
        $rataRataNilai = $rataRataNilai ? round($rataRataNilai, 1) : 0;
        $nilaiTertinggi = Nilai::max('nilai_akhir');
        $nilaiTerendah = Nilai::min('nilai_akhir');
        
        // User by role
        $countAdmin = User::where('role', 'admin')->count();
        $countGuru = User::where('role', 'guru')->count();
        $countOrtu = User::where('role', 'ortu')->count();
        
        // Kelas with wali kelas
        $kelasDenganWali = Kelas::whereNotNull('wali_kelas_id')->count();
        
        // Guru with kelas binaan
        $guruWaliKelas = Guru::whereHas('kelasBinaan')->count();

        // Get recent agenda/reminders
        $agenda = [
            [
                'icon' => 'fa-solid fa-bullhorn',
                'title' => 'Sosialisasi Kurikulum',
                'description' => 'Koordinasikan materi kurikulum merdeka dengan wali kelas dan kepala sekolah.'
            ],
            [
                'icon' => 'fa-solid fa-laptop-file',
                'title' => 'Audit Presensi',
                'description' => 'Verifikasi data kehadiran pekan lalu sebelum dikirim ke dinas pendidikan.'
            ]
        ];

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalOrtu',
            'totalKelas',
            'totalMapel',
            'totalUser',
            'siswaLaki',
            'siswaPerempuan',
            'presensiHariIni',
            'hadirHariIni',
            'presensiMingguIni',
            'hadirMingguIni',
            'presensiBulanIni',
            'hadirBulanIni',
            'presensiIzin',
            'presensiSakit',
            'presensiAlpha',
            'presensiTerlambat',
            'avgKehadiran',
            'persentaseHariIni',
            'persentaseMingguIni',
            'persentaseBulanIni',
            'activeParents',
            'pendingPendaftaran',
            'totalNilai',
            'rataRataNilai',
            'nilaiTertinggi',
            'nilaiTerendah',
            'countAdmin',
            'countGuru',
            'countOrtu',
            'kelasDenganWali',
            'guruWaliKelas',
            'agenda'
        ));
    }

    /**
     * Display list of students
     */
    public function dataSiswa(Request $request)
    {
        $query = Siswa::with(['kelas', 'ortu.user']);

        // Filter by kelas
        if ($request->has('kelas') && $request->kelas !== 'Semua Kelas') {
            $query->whereHas('kelas', function($q) use ($request) {
                $q->where('nama_kelas', $request->kelas);
            });
        }

        // Filter by jenis kelamin
        if ($request->has('jenis_kelamin') && $request->jenis_kelamin !== 'Semua') {
            $jenisKelamin = $request->jenis_kelamin === 'Laki-laki' ? 'L' : 'P';
            $query->where('jenis_kelamin', $jenisKelamin);
        }

        // Filter by status (can be customized based on business logic)
        // For now, we'll show all active students

        $siswa = $query->orderBy('nis')->get();

        // Get list of kelas for filter dropdown
        $kelasList = Kelas::orderBy('nama_kelas')->get();

        return view('admin.data-siswa', compact('siswa', 'kelasList'));
    }

    /**
     * Display list of teachers
     */
    public function dataGuru()
    {
        $guru = Guru::with(['user', 'mapel.kelas', 'kelasBinaan'])->orderBy('nip')->get();

        // Calculate statistics
        $totalGuru = $guru->count();
        
        // Count unique subjects (mapel)
        $totalMapel = Mapel::distinct('kode_mapel')->count('kode_mapel');
        
        // Count unique classes where guru is wali kelas (kelas binaan)
        $totalKelasBinaan = Kelas::whereNotNull('wali_kelas_id')->distinct('wali_kelas_id')->count('wali_kelas_id');

        return view('admin.data-guru', compact('guru', 'totalGuru', 'totalMapel', 'totalKelasBinaan'));
    }

    /**
     * Show the form for creating a new guru
     */
    public function createGuru()
    {
        return view('admin.create-guru');
    }

    /**
     * Store a newly created guru
     */
    public function storeGuru(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nip' => 'nullable|string|max:20|unique:guru,nip',
            'pangkat' => 'nullable|string|max:50',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
        ]);

        DB::beginTransaction();
        try {
            // Create user account
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'guru',
                'email_verified_at' => now(),
            ]);

            // Create guru record
            Guru::create([
                'user_id' => $user->id,
                'nip' => $validated['nip'] ?? null,
                'pangkat' => $validated['pangkat'] ?? null,
                'no_hp' => $validated['no_hp'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            ]);

            DB::commit();

            return redirect()->route('admin.data-guru')
                ->with('success', 'Guru berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan guru: ' . $e->getMessage());
        }
    }

    /**
     * Display attendance records
     */
    public function absensiSiswa(Request $request)
    {
        $query = Presensi::with(['siswa.kelas', 'guru.user']);

        // Filter by kelas
        if ($request->has('kelas') && $request->kelas !== 'Semua Kelas' && $request->kelas !== '') {
            $query->whereHas('siswa.kelas', function($q) use ($request) {
                $q->where('nama_kelas', $request->kelas);
            });
        }

        // Filter by tanggal
        if ($request->has('tanggal') && $request->tanggal !== '') {
            $query->whereDate('tanggal', $request->tanggal);
        } else {
            // Default to today if no date specified
            $query->whereDate('tanggal', Carbon::today());
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'Semua Status' && $request->status !== '') {
            $statusMap = [
                'Hadir' => 'hadir',
                'Izin' => 'izin',
                'Alpa' => 'alpha',
                'Sakit' => 'sakit',
                'Terlambat' => 'terlambat',
            ];
            if (isset($statusMap[$request->status])) {
                $query->where('status', $statusMap[$request->status]);
            }
        }

        $presensi = $query->orderBy('tanggal', 'desc')
            ->orderBy('waktu_masuk', 'desc')
            ->get();

        // Get list of kelas for filter dropdown
        $kelasList = Kelas::orderBy('nama_kelas')->get();

        return view('admin.absensi-siswa', compact('presensi', 'kelasList'));
    }

    /**
     * Display attendance report
     */
    public function laporan(Request $request)
    {
        // Get filter parameters
        $kelasFilter = $request->get('kelas', 'Semua Kelas');
        $tanggalAwal = $request->get('tanggal_awal', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $tanggalAkhir = $request->get('tanggal_akhir', Carbon::now()->format('Y-m-d'));

        // Build query for presensi
        $query = Presensi::with(['siswa.kelas']);

        if ($kelasFilter !== 'Semua Kelas' && $kelasFilter !== '') {
            $query->whereHas('siswa.kelas', function($q) use ($kelasFilter) {
                $q->where('nama_kelas', $kelasFilter);
            });
        }

        $query->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);

        $presensi = $query->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate summary statistics
        $totalPresensi = Presensi::whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])->count();
        $totalHadir = Presensi::whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->where('status', 'hadir')
            ->count();
        $persentaseKehadiran = $totalPresensi > 0 
            ? round(($totalHadir / $totalPresensi) * 100, 1) 
            : 0;

        // Calculate academic report percentage (placeholder - can be customized)
        $laporanAkademik = 85; // This can be calculated from nilai table if needed
        
        // Calculate evaluation percentage (placeholder - can be customized)
        $evaluasiPembelajaran = 76; // This can be calculated from feedback/rating if available

        // Get list of kelas for filter dropdown
        $kelasList = Kelas::orderBy('nama_kelas')->get();

        return view('admin.laporan', compact(
            'presensi',
            'kelasList',
            'kelasFilter',
            'tanggalAwal',
            'tanggalAkhir',
            'persentaseKehadiran',
            'laporanAkademik',
            'evaluasiPembelajaran'
        ));
    }

    /**
     * Display schedule (jadwal pelajaran)
     * Note: Since there's no jadwal table, we'll use mapel table
     */
    public function jadwal(Request $request)
    {
        $query = Mapel::with(['guru.user', 'kelas']);

        // Filter by kelas if provided
        if ($request->has('kelas') && $request->kelas !== 'Semua Kelas' && $request->kelas !== '') {
            $query->whereHas('kelas', function($q) use ($request) {
                $q->where('nama_kelas', $request->kelas);
            });
        }

        $mapel = $query->orderBy('nama_mapel')->get();

        // Get list of kelas for filter dropdown
        $kelasList = Kelas::orderBy('nama_kelas')->get();

        // Note: Jadwal table doesn't exist yet, so we're showing mapel assignments
        // If you need actual schedule with hari and waktu, you'll need to create a jadwal table
        // For now, we'll display mapel with their assigned guru and kelas

        return view('admin.jadwal', compact('mapel', 'kelasList'));
    }

    /**
     * Display academic grades (nilai)
     */
    public function dataNilai(Request $request)
    {
        $query = Nilai::with(['siswa.kelas', 'mapel']);

        // Filter by kelas if provided
        if ($request->has('kelas') && $request->kelas !== 'Semua Kelas' && $request->kelas !== '') {
            $query->whereHas('siswa.kelas', function($q) use ($request) {
                $q->where('nama_kelas', $request->kelas);
            });
        }

        // Filter by semester if provided
        if ($request->has('semester') && $request->semester !== 'Semua Semester' && $request->semester !== '') {
            $query->where('semester', $request->semester);
        }

        $nilai = $query->orderBy('nilai_akhir', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        // Calculate statistics
        $rataRataSekolah = Nilai::avg('nilai_akhir');
        $rataRataSekolah = $rataRataSekolah ? round($rataRataSekolah, 1) : 0;

        // Calculate increase percentage (placeholder - can be compared with previous period)
        $peningkatanBulan = 2.5; // This can be calculated by comparing current month with previous month

        // Get highest score
        $nilaiTertinggi = Nilai::max('nilai_akhir');
        $siswaTerbaik = Nilai::where('nilai_akhir', $nilaiTertinggi)
            ->with('siswa.kelas')
            ->first();

        // Get list of kelas for filter dropdown
        $kelasList = Kelas::orderBy('nama_kelas')->get();

        return view('admin.data-nilai', compact(
            'nilai',
            'kelasList',
            'rataRataSekolah',
            'peningkatanBulan',
            'nilaiTertinggi',
            'siswaTerbaik'
        ));
    }

    /**
     * Display user management
     */
    public function dataUser(Request $request)
    {
        $query = User::query();

        // Filter by role if provided
        if ($request->has('role') && $request->role !== 'Semua Role' && $request->role !== '') {
            $query->where('role', $request->role);
        }

        // Filter by status if provided (based on updated_at for active users)
        if ($request->has('status') && $request->status !== 'Semua Status' && $request->status !== '') {
            if ($request->status === 'Aktif') {
                // Users active in last 30 days
                $query->where('updated_at', '>=', Carbon::now()->subDays(30));
            }
        }

        $users = $query->orderBy('name')->paginate(50);

        // Count users by role
        $countAdmin = User::where('role', 'admin')->count();
        $countGuru = User::where('role', 'guru')->count();
        $countOrtu = User::where('role', 'ortu')->count();

        return view('admin.data-user', compact(
            'users',
            'countAdmin',
            'countGuru',
            'countOrtu'
        ));
    }

    /**
     * Step 1: Show himbauan page for adding student
     */
    public function createSiswaStep1()
    {
        return view('admin.create-siswa-step1');
    }

    /**
     * Step 2: Show form for parent data
     */
    public function createSiswaStep2()
    {
        return view('admin.create-siswa-step2');
    }

    /**
     * Store parent data and redirect to step 3
     */
    public function storeSiswaOrtu(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nik' => 'nullable|string|max:16|unique:ortu,nik',
            'hubungan' => 'required|in:Ayah,Ibu,Wali,Lainnya',
            'pekerjaan' => 'nullable|string|max:100',
            'pendidikan' => 'nullable|string|max:50',
            'alamat' => 'required|string',
            'nomor_hp' => 'required|string|max:20',
        ]);

        DB::beginTransaction();
        try {
            // 1. Create user account for parent
            $userOrtu = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'ortu',
                'email_verified_at' => now(),
            ]);

            // 2. Create ortu record
            $ortu = Ortu::create([
                'user_id' => $userOrtu->id,
                'nik' => $validated['nik'] ?? null,
                'hubungan' => $validated['hubungan'],
                'pekerjaan' => $validated['pekerjaan'] ?? null,
                'pendidikan' => $validated['pendidikan'] ?? null,
                'no_hp' => $validated['nomor_hp'],
                'alamat' => $validated['alamat'],
            ]);

            DB::commit();

            return redirect()->route('admin.data-siswa.create.siswa', $ortu->id)
                ->with('success', 'Data orang tua berhasil disimpan. Silakan lengkapi data siswa.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data orang tua: ' . $e->getMessage());
        }
    }

    /**
     * Step 3: Show form for student data
     */
    public function createSiswaStep3($ortuId)
    {
        $ortu = Ortu::with('user')->findOrFail($ortuId);
        $kelasList = Kelas::orderBy('urutan_kelas')->orderBy('rombel')->get();
        return view('admin.create-siswa-step3', compact('ortu', 'kelasList'));
    }

    /**
     * Store student data
     */
    public function storeSiswa(Request $request, $ortuId)
    {
        $validated = $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nis' => 'nullable|string|max:20|unique:siswa,nis',
            'nisn' => 'nullable|string|max:10|unique:siswa,nisn',
            'kelas_id' => 'nullable|exists:kelas,id',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:100',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $ortu = Ortu::findOrFail($ortuId);

            // If alamat is empty, use parent's address
            if (empty($validated['alamat'])) {
                $validated['alamat'] = $ortu->alamat;
            }

            // Create siswa record
            $siswa = Siswa::create([
                'kelas_id' => $validated['kelas_id'] ?? null,
                'ortu_id' => $ortu->id,
                'nama_siswa' => $validated['nama_siswa'],
                'nis' => $validated['nis'] ?? null,
                'nisn' => $validated['nisn'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                'tempat_lahir' => $validated['tempat_lahir'] ?? null,
                'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
                'qr_code' => null, // Will be generated after creation
            ]);

            // Generate QR code using siswa id
            $qrCode = 'SDN1-UNDUOLO-' . str_pad($siswa->id, 6, '0', STR_PAD_LEFT);
            $siswa->update(['qr_code' => $qrCode]);

            DB::commit();

            return redirect()->route('admin.data-siswa')
                ->with('success', 'Siswa berhasil ditambahkan. Akun orang tua dan data siswa telah dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data siswa: ' . $e->getMessage());
        }
    }

    /**
     * Show ortu detail page
     */
    public function showOrtu($id)
    {
        $ortu = Ortu::with(['user', 'siswa.kelas'])->findOrFail($id);
        return view('admin.show-ortu', compact('ortu'));
    }

    /**
     * Show siswa detail page
     */
    public function showSiswa($id)
    {
        $siswa = Siswa::with(['kelas', 'ortu.user', 'presensi', 'nilai.mapel', 'penilaianHarian.mapel'])->findOrFail($id);
        return view('admin.show-siswa', compact('siswa'));
    }

    /**
     * Show form for editing siswa
     */
    public function editSiswa($id)
    {
        $siswa = Siswa::with(['kelas', 'ortu.user'])->findOrFail($id);
        $kelasList = Kelas::orderBy('urutan_kelas')->orderBy('rombel')->get();
        return view('admin.edit-siswa', compact('siswa', 'kelasList'));
    }

    /**
     * Update siswa data
     */
    public function updateSiswa(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $validated = $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nis' => 'nullable|string|max:20|unique:siswa,nis,' . $id,
            'nisn' => 'nullable|string|max:10|unique:siswa,nisn,' . $id,
            'kelas_id' => 'nullable|exists:kelas,id',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:100',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat' => 'nullable|string',
        ]);

        // If alamat is empty, use parent's address
        if (empty($validated['alamat']) && $siswa->ortu) {
            $validated['alamat'] = $siswa->ortu->alamat;
        }

        $siswa->update($validated);

        return redirect()->route('admin.data-siswa.show', $siswa->id)
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Show confirmation page for deleting siswa
     */
    public function confirmDeleteSiswa($id)
    {
        $siswa = Siswa::with(['kelas', 'ortu.user', 'presensi', 'nilai', 'penilaianHarian'])->findOrFail($id);
        return view('admin.delete-siswa', compact('siswa'));
    }

    /**
     * Delete siswa and all related data (but not ortu)
     */
    public function destroySiswa($id)
    {
        $siswa = Siswa::findOrFail($id);

        DB::beginTransaction();
        try {
            // Delete related data (cascade will handle most, but we'll be explicit)
            // Presensi, Nilai, PenilaianHarian will be deleted automatically due to cascade
            // But we'll count them first for logging
            
            $presensiCount = $siswa->presensi()->count();
            $nilaiCount = $siswa->nilai()->count();
            $penilaianCount = $siswa->penilaianHarian()->count();

            // Delete the siswa (cascade will handle related data)
            $siswa->delete();

            DB::commit();

            return redirect()->route('admin.data-siswa')
                ->with('success', "Siswa berhasil dihapus. Data terkait yang dihapus: {$presensiCount} presensi, {$nilaiCount} nilai, {$penilaianCount} penilaian harian. Data orang tua tetap tersimpan.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.data-siswa')
                ->with('error', 'Gagal menghapus siswa: ' . $e->getMessage());
        }
    }

    /**
     * Display pending parent registrations (pendaftaran)
     */
    public function pendaftaran()
    {
        $pendaftaran = OrtuRegister::orderBy('created_at', 'desc')->get();
        return view('admin.pendaftaran', compact('pendaftaran'));
    }

    /**
     * Show approve form with anak data input
     */
    public function showApproveForm($id)
    {
        $ortuRegister = OrtuRegister::findOrFail($id);
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        return view('admin.approve-pendaftaran', compact('ortuRegister', 'kelasList'));
    }

    /**
     * Approve parent registration with anak data
     */
    public function approvePendaftaran(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_anak' => 'required|string|max:255',
            'nis' => 'nullable|string|max:20|unique:siswa,nis',
            'nisn' => 'nullable|string|max:10|unique:siswa,nisn',
            'kelas_id' => 'nullable|exists:kelas,id',
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:100',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat_anak' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $ortuRegister = OrtuRegister::findOrFail($id);

            // 1. Create user account for parent
            $userOrtu = User::create([
                'name' => $ortuRegister->name,
                'email' => $ortuRegister->email,
                'password' => 'password123', // Plain text for development
                'role' => 'ortu',
                'email_verified_at' => now(),
            ]);

            // 2. Create ortu record
            $ortu = Ortu::create([
                'user_id' => $userOrtu->id,
                'nik' => $ortuRegister->nik,
                'hubungan' => $ortuRegister->hubungan,
                'pekerjaan' => $ortuRegister->pekerjaan,
                'pendidikan' => $ortuRegister->pendidikan,
                'no_hp' => $ortuRegister->no_hp,
                'alamat' => $ortuRegister->alamat,
            ]);

            // 3. Create siswa record (tanpa user_id, karena siswa tidak login)
            $siswa = Siswa::create([
                'kelas_id' => $validated['kelas_id'] ?? null,
                'ortu_id' => $ortu->id,
                'nama_siswa' => $validated['nama_anak'],
                'nis' => $validated['nis'] ?? null,
                'nisn' => $validated['nisn'] ?? null,
                'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
                'tempat_lahir' => $validated['tempat_lahir'] ?? null,
                'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
                'alamat' => $validated['alamat_anak'] ?? $ortuRegister->alamat,
                'qr_code' => null, // Will be generated after creation
            ]);

            // 4. Generate QR code using siswa id
            $qrCode = 'SDN1-UNDUOLO-' . str_pad($siswa->id, 6, '0', STR_PAD_LEFT);
            $siswa->update(['qr_code' => $qrCode]);

            // 5. Delete from orturegister
            $ortuRegister->delete();

            DB::commit();

            return redirect()->route('admin.pendaftaran')
                ->with('success', 'Pendaftaran berhasil disetujui. Akun orangtua dan data siswa telah dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.pendaftaran')
                ->with('error', 'Gagal menyetujui pendaftaran: ' . $e->getMessage());
        }
    }

    /**
     * Reject parent registration
     */
    public function rejectPendaftaran($id)
    {
        try {
            $ortuRegister = OrtuRegister::findOrFail($id);
            $ortuRegister->delete();

            return redirect()->route('admin.pendaftaran')
                ->with('success', 'Pendaftaran ditolak dan dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.pendaftaran')
                ->with('error', 'Gagal menolak pendaftaran: ' . $e->getMessage());
        }
    }

    /**
     * Delete parent registration
     */
    public function deletePendaftaran($id)
    {
        try {
            $ortuRegister = OrtuRegister::findOrFail($id);
            $ortuRegister->delete();

            return redirect()->route('admin.pendaftaran')
                ->with('success', 'Pendaftaran berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.pendaftaran')
                ->with('error', 'Gagal menghapus pendaftaran: ' . $e->getMessage());
        }
    }
}

