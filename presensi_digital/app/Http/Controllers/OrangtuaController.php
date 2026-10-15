<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Ortu;
use App\Models\Siswa;
use App\Models\Presensi;
use App\Models\Nilai;
use App\Models\PenilaianHarian;
use App\Models\Mapel;
use Carbon\Carbon;

class OrangtuaController extends Controller
{
    /**
     * Get current logged in orangtua
     */
    protected function getCurrentOrtu()
    {
        $user = Auth::user();
        if (!$user || !$user->ortu) {
            $this->logoutAndRedirect();
        }
        return $user->ortu;
    }

    /**
     * Logout and redirect to login
     */
    protected function logoutAndRedirect()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        throw new HttpResponseException(redirect()->route('login'));
    }

    /**
     * Get children (siswa) of current orangtua
     */
    protected function getAnak()
    {
        $ortu = $this->getCurrentOrtu();
        return Siswa::where('ortu_id', $ortu->id)
            ->with(['kelas'])
            ->get();
    }

    /**
     * Display orangtua dashboard
     */
    public function dashboard()
    {
        $ortu = $this->getCurrentOrtu();
        $anakList = $this->getAnak();

        // If no children, show empty state
        if ($anakList->isEmpty()) {
            return view('orangtua.dashboard', compact('ortu', 'anakList'));
        }

        // For now, show data for first child (can be enhanced to show all or selected child)
        $anak = $anakList->first();
        $anakIds = $anakList->pluck('id')->toArray();

        // Calculate attendance percentage for this month
        $tanggalAwal = Carbon::now()->startOfMonth();
        $tanggalAkhir = Carbon::now()->endOfMonth();
        
        $presensiQuery = Presensi::whereIn('siswa_id', $anakIds)
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
        $totalPresensi = $presensiQuery->count();
        $totalHadir = $presensiQuery->where('status', 'hadir')->count();
        $persentaseKehadiran = $totalPresensi > 0 
            ? round(($totalHadir / $totalPresensi) * 100, 1) 
            : 0;

        // Calculate average nilai
        $rataRataNilai = Nilai::whereIn('siswa_id', $anakIds)
            ->avg('nilai_akhir');
        $rataRataNilai = $rataRataNilai ? round($rataRataNilai, 1) : 0;

        // Get recent presensi (this week)
        $mingguAwal = Carbon::now()->startOfWeek();
        $presensiMingguIni = Presensi::whereIn('siswa_id', $anakIds)
            ->whereBetween('tanggal', [$mingguAwal, Carbon::now()])
            ->with(['siswa.kelas'])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('orangtua.dashboard', compact(
            'ortu',
            'anak',
            'anakList',
            'persentaseKehadiran',
            'rataRataNilai',
            'totalHadir',
            'totalPresensi',
            'presensiMingguIni'
        ));
    }

    /**
     * Display data anak
     */
    public function dataAnak(Request $request)
    {
        $ortu = $this->getCurrentOrtu();
        $anakList = $this->getAnak();

        // If no children, show empty state
        if ($anakList->isEmpty()) {
            return view('orangtua.data-anak', compact('ortu', 'anakList'));
        }

        // Get selected anak or default to first
        $anakId = $request->get('anak_id');
        $anak = null;
        
        if ($anakId) {
            $anak = $anakList->where('id', $anakId)->first();
        }
        
        if (!$anak) {
            $anak = $anakList->first();
        }

        // Load relations
        $anak->load(['kelas', 'ortu.user']);

        // Get mapel for this anak's kelas
        $mapelList = collect([]);
        if ($anak->kelas_id) {
            $mapelList = Mapel::where('kelas_id', $anak->kelas_id)
                ->with('guru.user')
                ->get();
        }

        return view('orangtua.data-anak', compact(
            'ortu',
            'anak',
            'anakList',
            'mapelList'
        ));
    }

    /**
     * Display perkembangan anak (grades/nilai)
     */
    public function perkembangan(Request $request)
    {
        $ortu = $this->getCurrentOrtu();
        $anakList = $this->getAnak();

        // If no children, show empty state
        if ($anakList->isEmpty()) {
            return view('orangtua.perkembangan', compact('ortu', 'anakList'));
        }

        // Get selected anak or default to first
        $anakId = $request->get('anak_id');
        $anak = null;
        
        if ($anakId) {
            $anak = $anakList->where('id', $anakId)->first();
        }
        
        if (!$anak) {
            $anak = $anakList->first();
        }

        // Get nilai for this anak
        $nilaiList = Nilai::where('siswa_id', $anak->id)
            ->with('mapel')
            ->get();

        // Group by mapel
        $nilaiPerMapel = $nilaiList->groupBy('mapel_id')->map(function ($nilaiGroup) {
            return $nilaiGroup->first();
        });

        // Get penilaian harian for this anak
        $penilaianHarian = PenilaianHarian::where('siswa_id', $anak->id)
            ->with('mapel')
            ->orderBy('tanggal', 'desc')
            ->get();

        // Get presensi for this month
        $tanggalAwal = Carbon::now()->startOfMonth();
        $tanggalAkhir = Carbon::now()->endOfMonth();
        
        $presensiBulanIni = Presensi::where('siswa_id', $anak->id)
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->orderBy('tanggal', 'desc')
            ->get();

        // Calculate presensi statistics
        $totalPresensi = $presensiBulanIni->count();
        $totalHadir = $presensiBulanIni->where('status', 'hadir')->count();
        $totalSakit = $presensiBulanIni->where('status', 'sakit')->count();
        $totalIzin = $presensiBulanIni->where('status', 'izin')->count();
        $totalAlpha = $presensiBulanIni->where('status', 'alpha')->count();

        // Get presensi today
        $presensiHariIni = Presensi::where('siswa_id', $anak->id)
            ->whereDate('tanggal', Carbon::today())
            ->first();

        return view('orangtua.perkembangan', compact(
            'ortu',
            'anak',
            'anakList',
            'nilaiPerMapel',
            'penilaianHarian',
            'presensiBulanIni',
            'totalHadir',
            'totalSakit',
            'totalIzin',
            'totalAlpha',
            'totalPresensi',
            'presensiHariIni'
        ));
    }

    /**
     * Cetak laporan perkembangan (PDF)
     */
    public function cetakLaporanPerkembangan($siswaId)
    {
        $ortu = $this->getCurrentOrtu();
        $anakList = $this->getAnak();
        
        // Get siswa - ensure it belongs to this parent
        $siswa = $anakList->where('id', $siswaId)->first();
        
        if (!$siswa) {
            abort(404, 'Data siswa tidak ditemukan atau tidak memiliki akses');
        }

        // Load relations
        $siswa->load(['kelas', 'ortu.user']);

        // Get nilai
        $nilaiList = Nilai::where('siswa_id', $siswa->id)
            ->with('mapel')
            ->get();
        $nilaiPerMapel = $nilaiList->groupBy('mapel_id')->map(function ($nilaiGroup) {
            return $nilaiGroup->first();
        });

        // Get presensi this month
        $tanggalAwal = Carbon::now()->startOfMonth();
        $tanggalAkhir = Carbon::now()->endOfMonth();
        $presensiBulanIni = Presensi::where('siswa_id', $siswa->id)
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalPresensi = $presensiBulanIni->count();
        $totalHadir = $presensiBulanIni->where('status', 'hadir')->count();
        $totalSakit = $presensiBulanIni->where('status', 'sakit')->count();
        $totalIzin = $presensiBulanIni->where('status', 'izin')->count();
        $totalAlpha = $presensiBulanIni->where('status', 'alpha')->count();

        // Check if PDF package is available
        if (!class_exists('Barryvdh\DomPDF\Facade\Pdf')) {
            return back()->withErrors(['error' => 'Fitur PDF belum tersedia. Silakan hubungi administrator untuk mengaktifkan fitur ini.']);
        }

        // Generate PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('orangtua.laporan-perkembangan-pdf', compact(
            'siswa',
            'nilaiPerMapel',
            'presensiBulanIni',
            'totalHadir',
            'totalSakit',
            'totalIzin',
            'totalAlpha',
            'totalPresensi'
        ));
        return $pdf->download('laporan-perkembangan-' . $siswa->nama_siswa . '.pdf');
    }

    /**
     * Display notes from teachers
     */
    public function notes(Request $request)
    {
        $ortu = $this->getCurrentOrtu();
        $anakList = $this->getAnak();

        // If no children, show empty state
        if ($anakList->isEmpty()) {
            return view('orangtua.notes', compact('ortu', 'anakList'));
        }

        // Get selected anak or default to first
        $anakId = $request->get('anak_id');
        $anak = null;
        
        if ($anakId) {
            $anak = $anakList->where('id', $anakId)->first();
        }
        
        if (!$anak) {
            $anak = $anakList->first();
        }

        $anakIds = $anakList->pluck('id')->toArray();

        // Get notes (catatan_guru from penilaian_harian) for all children
        $notesList = PenilaianHarian::whereIn('siswa_id', $anakIds)
            ->whereNotNull('catatan_guru')
            ->where('catatan_guru', '!=', '')
            ->with(['siswa.kelas', 'mapel.guru.user'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orangtua.notes', compact(
            'ortu',
            'anak',
            'anakList',
            'notesList'
        ));
    }

    /**
     * Display penilaian harian (daily assessment) for children
     */
    public function penilaianHarian(Request $request)
    {
        $ortu = $this->getCurrentOrtu();
        $anakList = $this->getAnak();

        // If no children, show empty state
        if ($anakList->isEmpty()) {
            return view('orangtua.penilaian-harian', compact('ortu', 'anakList'));
        }

        // Get selected anak or default to first
        $anakId = $request->get('anak_id');
        $anak = null;
        
        if ($anakId) {
            $anak = $anakList->where('id', $anakId)->first();
        }
        
        if (!$anak) {
            $anak = $anakList->first();
        }

        // Get filter parameters
        $tanggalFilter = $request->get('tanggal');
        $mapelFilter = $request->get('mapel');
        $jenisFilter = $request->get('jenis_penilaian');

        // Get penilaian harian for selected anak
        $query = PenilaianHarian::where('siswa_id', $anak->id)
            ->with(['mapel.guru.user', 'mapel.kelas']);

        // Apply filters
        if ($tanggalFilter) {
            $query->whereDate('tanggal', $tanggalFilter);
        }

        if ($mapelFilter) {
            $query->where('mapel_id', $mapelFilter);
        }

        if ($jenisFilter && $jenisFilter !== 'Semua') {
            $query->where('jenis_penilaian', $jenisFilter);
        }

        $penilaianHarian = $query->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get mapel list for filter (mapel that this anak's class has)
        $mapelList = collect([]);
        if ($anak->kelas_id) {
            $mapelList = Mapel::where('kelas_id', $anak->kelas_id)
                ->with('guru.user')
                ->orderBy('nama_mapel')
                ->get();
        }

        // Get statistics
        $totalPenilaian = PenilaianHarian::where('siswa_id', $anak->id)->count();
        $rataRataNilai = PenilaianHarian::where('siswa_id', $anak->id)->avg('nilai');
        $rataRataNilai = $rataRataNilai ? round($rataRataNilai, 2) : 0;
        
        // Get penilaian by jenis
        $penilaianByJenis = PenilaianHarian::where('siswa_id', $anak->id)
            ->selectRaw('jenis_penilaian, COUNT(*) as total, AVG(nilai) as rata_rata')
            ->groupBy('jenis_penilaian')
            ->get();

        // Get recent penilaian (last 7 days)
        $tanggalAwal = Carbon::now()->subDays(7);
        $penilaianTerbaru = PenilaianHarian::where('siswa_id', $anak->id)
            ->where('tanggal', '>=', $tanggalAwal)
            ->with(['mapel.guru.user'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orangtua.penilaian-harian', compact(
            'ortu',
            'anak',
            'anakList',
            'penilaianHarian',
            'mapelList',
            'tanggalFilter',
            'mapelFilter',
            'jenisFilter',
            'totalPenilaian',
            'rataRataNilai',
            'penilaianByJenis',
            'penilaianTerbaru'
        ));
    }

    /**
     * Cetak kartu siswa (PDF)
     * Note: Requires barryvdh/laravel-dompdf package
     * Install: composer require barryvdh/laravel-dompdf
     * Then publish config: php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
     */
    public function cetakKartuSiswa($siswaId)
    {
        $ortu = $this->getCurrentOrtu();
        $anakList = $this->getAnak();
        
        // Get siswa - ensure it belongs to this parent
        $siswa = $anakList->where('id', $siswaId)->first();
        
        if (!$siswa) {
            abort(404, 'Data siswa tidak ditemukan atau tidak memiliki akses');
        }

        // Load relations
        $siswa->load(['kelas', 'ortu.user']);

        // Check if PDF package is available
        if (!class_exists('Barryvdh\DomPDF\Facade\Pdf')) {
            return back()->withErrors(['error' => 'Fitur PDF belum tersedia. Silakan hubungi administrator untuk mengaktifkan fitur ini.']);
        }

        // Generate PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('orangtua.kartu-siswa-pdf', compact('siswa'));
        return $pdf->download('kartu-siswa-' . $siswa->nama_siswa . '.pdf');
    }
}

