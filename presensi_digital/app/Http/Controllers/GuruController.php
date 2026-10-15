<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Presensi;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\PenilaianHarian;
use Carbon\Carbon;

class GuruController extends Controller
{
    /**
     * Get current logged in guru
     */
    protected function getCurrentGuru()
    {
        $user = Auth::user();
        if (!$user || !$user->guru) {
            $this->logoutAndRedirect();
        }
        return $user->guru;
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
     * Display guru dashboard
     */
    public function dashboard()
    {
        $guru = $this->getCurrentGuru();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Guru tidak ditemukan');
        }

        // Get mapel (classes) taught by this guru
        $mapelGuru = Mapel::where('guru_id', $guru->id)
            ->with('kelas')
            ->get();

        // Get classes (unique) for today's schedule
        $hariIni = Carbon::now()->locale('id')->dayName;
        $hariIniMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];
        $hariIniId = $hariIniMap[$hariIni] ?? 'Senin';
        
        $kelasHariIni = collect([]);
        foreach ($mapelGuru as $m) {
            // Only show classes scheduled for today
            if ($m->hari === $hariIniId) {
                $kelasHariIni->push([
                    'nama_kelas' => $m->kelas->nama_kelas ?? '-',
                    'nama_mapel' => $m->nama_mapel,
                    'hari' => $m->hari,
                    'jam_mulai' => $m->jam_mulai ? \Carbon\Carbon::parse($m->jam_mulai)->format('H:i') : '-',
                    'jam_selesai' => $m->jam_selesai ? \Carbon\Carbon::parse($m->jam_selesai)->format('H:i') : '-',
                ]);
            }
        }

        // Get recent attendance records for classes taught by this guru
        $presensiTerbaru = Presensi::whereHas('mapel', function($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })
            ->with(['siswa.kelas', 'mapel'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('guru.dashboard', compact(
            'guru',
            'mapelGuru',
            'kelasHariIni',
            'presensiTerbaru'
        ));
    }

    /**
     * Display attendance (presensi) page for guru's classes
     */
    public function presensi(Request $request)
    {
        $guru = $this->getCurrentGuru();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Guru tidak ditemukan');
        }

        // Get filter parameters
        $kelasFilter = $request->get('kelas');
        $tanggalFilter = $request->get('tanggal', Carbon::today()->format('Y-m-d'));
        
        // Get mapel taught by this guru
        $mapelGuru = Mapel::where('guru_id', $guru->id)
            ->with('kelas')
            ->get();

        // Get unique classes
        $kelasList = $mapelGuru->pluck('kelas')->unique('id')->filter()->values();

        // Get siswa from selected class (or first class if not specified)
        $kelasId = null;
        if ($kelasFilter) {
            $kelas = Kelas::where('nama_kelas', $kelasFilter)->first();
            if ($kelas) {
                $kelasId = $kelas->id;
            }
        } else {
            // Default to first class
            if ($kelasList->isNotEmpty()) {
                $kelasId = $kelasList->first()->id;
                $kelasFilter = $kelasList->first()->nama_kelas;
            }
        }

        $siswa = [];
        if ($kelasId) {
            $siswa = Siswa::where('kelas_id', $kelasId)
                ->orderBy('nis')
                ->get();
        }

        // Get attendance for selected date for these students
        $presensiHariIni = collect([]);
        if ($siswa->isNotEmpty()) {
            $siswaIds = $siswa->pluck('id')->toArray();
            $mapelIds = $mapelGuru->where('kelas_id', $kelasId)->pluck('id')->toArray();
            
            $presensiHariIni = Presensi::whereIn('siswa_id', $siswaIds)
                ->whereIn('mapel_id', $mapelIds)
                ->whereDate('tanggal', $tanggalFilter)
                ->with('mapel')
                ->get()
                ->keyBy('siswa_id');
        }

        return view('guru.presensi', compact(
            'guru',
            'kelasList',
            'kelasFilter',
            'tanggalFilter',
            'mapelGuru',
            'siswa',
            'presensiHariIni'
        ));
    }

    /**
     * Store presensi data
     */
    public function storePresensi(Request $request)
    {
        $guru = $this->getCurrentGuru();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Guru tidak ditemukan');
        }

        $validated = $request->validate([
            'siswa_id' => 'required|array',
            'siswa_id.*' => 'required|exists:siswa,id',
            'status' => 'required|array',
            'status.*' => 'required|in:hadir,izin,sakit,alpha,terlambat',
            'tanggal' => 'required|date',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        // Verify that kelas has mapel taught by this guru
        $mapelGuru = Mapel::where('guru_id', $guru->id)
            ->where('kelas_id', $validated['kelas_id'])
            ->first();

        if (!$mapelGuru) {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses untuk kelas ini.');
        }

        DB::beginTransaction();
        try {
            $savedCount = 0;
            $updatedCount = 0;

            foreach ($validated['siswa_id'] as $index => $siswaId) {
                $status = $validated['status'][$index] ?? 'alpha';

                // Check if presensi already exists for this siswa, mapel, and tanggal
                $existingPresensi = Presensi::where('siswa_id', $siswaId)
                    ->where('mapel_id', $mapelGuru->id)
                    ->whereDate('tanggal', $validated['tanggal'])
                    ->first();

                if ($existingPresensi) {
                    // Update existing
                    $existingPresensi->update([
                        'status' => $status,
                        'guru_id' => $guru->id,
                        'waktu_masuk' => $status === 'hadir' ? Carbon::now()->format('H:i:s') : null,
                    ]);
                    $updatedCount++;
                } else {
                    // Create new
                    Presensi::create([
                        'siswa_id' => $siswaId,
                        'mapel_id' => $mapelGuru->id,
                        'guru_id' => $guru->id,
                        'tanggal' => $validated['tanggal'],
                        'status' => $status,
                        'waktu_masuk' => $status === 'hadir' ? Carbon::now()->format('H:i:s') : null,
                    ]);
                    $savedCount++;
                }
            }

            DB::commit();

            $message = '';
            if ($savedCount > 0 && $updatedCount > 0) {
                $message = "Presensi berhasil disimpan. {$savedCount} presensi baru ditambahkan, {$updatedCount} presensi diperbarui.";
            } elseif ($savedCount > 0) {
                $message = "Presensi berhasil disimpan. {$savedCount} presensi baru ditambahkan.";
            } elseif ($updatedCount > 0) {
                $message = "Presensi berhasil diperbarui. {$updatedCount} presensi diperbarui.";
            } else {
                $message = "Tidak ada presensi yang disimpan.";
            }

            return redirect()->back()
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menyimpan presensi: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display nilai (grades) input page
     */
    public function nilai(Request $request)
    {
        $guru = $this->getCurrentGuru();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Guru tidak ditemukan');
        }

        // Get filter parameters
        $kelasFilter = $request->get('kelas');
        $semesterFilter = $request->get('semester', '1');
        
        // Get mapel taught by this guru
        $mapelGuru = Mapel::where('guru_id', $guru->id)
            ->with('kelas')
            ->get();

        // Get unique classes
        $kelasList = $mapelGuru->pluck('kelas')->unique('id')->filter()->values();

        // Get siswa from selected class (or first class if not specified)
        $kelasId = null;
        $mapelId = null;
        
        if ($kelasFilter) {
            $kelas = Kelas::where('nama_kelas', $kelasFilter)->first();
            if ($kelas) {
                $kelasId = $kelas->id;
            }
        } else {
            // Default to first class
            if ($kelasList->isNotEmpty()) {
                $kelasId = $kelasList->first()->id;
                $kelasFilter = $kelasList->first()->nama_kelas;
            }
        }

        // Get mapel for selected class (first mapel for that class)
        if ($kelasId) {
            $selectedMapel = $mapelGuru->where('kelas_id', $kelasId)->first();
            if ($selectedMapel) {
                $mapelId = $selectedMapel->id;
            }
        }

        $siswa = collect([]);
        $nilaiSiswa = collect([]);
        if ($kelasId && $mapelId) {
            $siswa = Siswa::where('kelas_id', $kelasId)
                ->orderBy('nis')
                ->get();

            // Get existing nilai for these students
            if ($siswa->isNotEmpty()) {
                $nilaiSiswa = Nilai::where('mapel_id', $mapelId)
                    ->where('semester', $semesterFilter)
                    ->whereIn('siswa_id', $siswa->pluck('id')->toArray())
                    ->get()
                    ->keyBy('siswa_id');
            }
        }

        return view('guru.nilai', compact(
            'guru',
            'kelasList',
            'kelasFilter',
            'semesterFilter',
            'mapelGuru',
            'mapelId',
            'siswa',
            'nilaiSiswa'
        ));
    }

    /**
     * Store nilai data
     */
    public function storeNilai(Request $request)
    {
        $guru = $this->getCurrentGuru();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Guru tidak ditemukan');
        }

        $validated = $request->validate([
            'siswa_id' => 'required|array',
            'siswa_id.*' => 'required|exists:siswa,id',
            'mapel_id' => 'required|exists:mapel,id',
            'kelas_id' => 'required|exists:kelas,id',
            'semester' => 'required|string|max:10',
            'nilai_tugas' => 'nullable|array',
            'nilai_tugas.*' => 'nullable|numeric|min:0|max:100',
            'nilai_uts' => 'nullable|array',
            'nilai_uts.*' => 'nullable|numeric|min:0|max:100',
            'nilai_uas' => 'nullable|array',
            'nilai_uas.*' => 'nullable|numeric|min:0|max:100',
        ]);

        // Verify that mapel belongs to this guru
        $mapel = Mapel::where('id', $validated['mapel_id'])
            ->where('guru_id', $guru->id)
            ->first();

        if (!$mapel) {
            return redirect()->back()
                ->with('error', 'Mata pelajaran tidak ditemukan atau tidak diizinkan.');
        }

        DB::beginTransaction();
        try {
            $savedCount = 0;
            $updatedCount = 0;

            foreach ($validated['siswa_id'] as $index => $siswaId) {
                $nilaiTugas = $validated['nilai_tugas'][$index] ?? null;
                $nilaiUts = $validated['nilai_uts'][$index] ?? null;
                $nilaiUas = $validated['nilai_uas'][$index] ?? null;

                // Skip if all nilai are empty
                if (empty($nilaiTugas) && empty($nilaiUts) && empty($nilaiUas)) {
                    continue;
                }

                // Calculate nilai akhir (average of tugas, UTS, UAS)
                $nilaiArray = array_filter([$nilaiTugas, $nilaiUts, $nilaiUas], function($n) {
                    return $n !== null && $n !== '';
                });
                $nilaiAkhir = !empty($nilaiArray) ? round(array_sum($nilaiArray) / count($nilaiArray), 2) : null;

                // Determine predikat
                $predikat = null;
                if ($nilaiAkhir !== null) {
                    if ($nilaiAkhir >= 90) {
                        $predikat = 'A';
                    } elseif ($nilaiAkhir >= 80) {
                        $predikat = 'B';
                    } elseif ($nilaiAkhir >= 70) {
                        $predikat = 'C';
                    } elseif ($nilaiAkhir >= 60) {
                        $predikat = 'D';
                    } else {
                        $predikat = 'E';
                    }
                }

                // Check if nilai already exists for this siswa, mapel, and semester
                $existingNilai = Nilai::where('siswa_id', $siswaId)
                    ->where('mapel_id', $validated['mapel_id'])
                    ->where('semester', $validated['semester'])
                    ->first();

                if ($existingNilai) {
                    // Update existing
                    $existingNilai->update([
                        'kelas_id' => $validated['kelas_id'],
                        'nilai_tugas' => $nilaiTugas,
                        'nilai_uts' => $nilaiUts,
                        'nilai_uas' => $nilaiUas,
                        'nilai_akhir' => $nilaiAkhir,
                        'predikat' => $predikat,
                    ]);
                    $updatedCount++;
                } else {
                    // Create new
                    Nilai::create([
                        'siswa_id' => $siswaId,
                        'mapel_id' => $validated['mapel_id'],
                        'kelas_id' => $validated['kelas_id'],
                        'semester' => $validated['semester'],
                        'nilai_tugas' => $nilaiTugas,
                        'nilai_uts' => $nilaiUts,
                        'nilai_uas' => $nilaiUas,
                        'nilai_akhir' => $nilaiAkhir,
                        'predikat' => $predikat,
                    ]);
                    $savedCount++;
                }
            }

            DB::commit();

            $message = '';
            if ($savedCount > 0 && $updatedCount > 0) {
                $message = "Nilai berhasil disimpan. {$savedCount} nilai baru ditambahkan, {$updatedCount} nilai diperbarui.";
            } elseif ($savedCount > 0) {
                $message = "Nilai berhasil disimpan. {$savedCount} nilai baru ditambahkan.";
            } elseif ($updatedCount > 0) {
                $message = "Nilai berhasil diperbarui. {$updatedCount} nilai diperbarui.";
            } else {
                $message = "Tidak ada nilai yang disimpan. Pastikan minimal satu nilai telah diisi.";
            }

            return redirect()->back()
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menyimpan nilai: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display laporan (report) page
     */
    public function laporan(Request $request)
    {
        $guru = $this->getCurrentGuru();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Guru tidak ditemukan');
        }

        // Get filter parameters
        $kelasFilter = $request->get('kelas');
        $periodeFilter = $request->get('periode', 'bulan');
        $tanggalFilter = $request->get('tanggal', Carbon::today()->format('Y-m-d'));

        // Get mapel taught by this guru
        $mapelGuru = Mapel::where('guru_id', $guru->id)
            ->with('kelas')
            ->get();

        // Get unique classes
        $kelasList = $mapelGuru->pluck('kelas')->unique('id')->filter()->values();

        // Calculate date range based on periode
        $tanggalAwal = Carbon::today();
        $tanggalAkhir = Carbon::today();
        
        switch ($periodeFilter) {
            case 'minggu':
                $tanggalAwal = Carbon::now()->startOfWeek();
                $tanggalAkhir = Carbon::now()->endOfWeek();
                break;
            case 'bulan':
                $tanggalAwal = Carbon::now()->startOfMonth();
                $tanggalAkhir = Carbon::now()->endOfMonth();
                break;
            case 'semester':
                $tanggalAwal = Carbon::now()->startOfYear();
                $tanggalAkhir = Carbon::now()->endOfYear();
                break;
        }

        // Get kelas ID
        $kelasId = null;
        if ($kelasFilter) {
            $kelas = Kelas::where('nama_kelas', $kelasFilter)->first();
            if ($kelas) {
                $kelasId = $kelas->id;
            }
        } else {
            if ($kelasList->isNotEmpty()) {
                $kelasId = $kelasList->first()->id;
                $kelasFilter = $kelasList->first()->nama_kelas;
            }
        }

        // Get statistics
        $totalSiswa = 0;
        $rataRataKehadiran = 0;
        $rataRataNilai = 0;
        $siswaHadirHariIni = 0;
        $detailPresensi = collect([]);

        if ($kelasId) {
            $siswaQuery = Siswa::where('kelas_id', $kelasId);
            $totalSiswa = $siswaQuery->count();
            $siswaIds = $siswaQuery->pluck('id')->toArray();

            if (!empty($siswaIds)) {
                // Get presensi statistics
                $presensiQuery = Presensi::whereIn('siswa_id', $siswaIds)
                    ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);

                $totalPresensi = $presensiQuery->count();
                $totalHadir = $presensiQuery->where('status', 'hadir')->count();
                $rataRataKehadiran = $totalPresensi > 0 
                    ? round(($totalHadir / $totalPresensi) * 100, 1) 
                    : 0;

                // Get attendance for today
                $siswaHadirHariIni = Presensi::whereIn('siswa_id', $siswaIds)
                    ->whereDate('tanggal', Carbon::today())
                    ->where('status', 'hadir')
                    ->count();

                // Get average nilai
                $rataRataNilai = Nilai::whereIn('siswa_id', $siswaIds)
                    ->avg('nilai_akhir');
                $rataRataNilai = $rataRataNilai ? round($rataRataNilai, 1) : 0;

                // Get detail presensi per siswa
                $detailPresensi = Presensi::whereIn('siswa_id', $siswaIds)
                    ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
                    ->selectRaw('siswa_id, 
                        SUM(CASE WHEN status = "hadir" THEN 1 ELSE 0 END) as hadir,
                        SUM(CASE WHEN status = "izin" THEN 1 ELSE 0 END) as izin,
                        SUM(CASE WHEN status = "sakit" THEN 1 ELSE 0 END) as sakit,
                        SUM(CASE WHEN status = "alpha" THEN 1 ELSE 0 END) as alpa,
                        COUNT(*) as total')
                    ->groupBy('siswa_id')
                    ->with('siswa')
                    ->get();

                // Calculate percentage for each student
                foreach ($detailPresensi as $dp) {
                    $dp->persentase = $dp->total > 0 
                        ? round(($dp->hadir / $dp->total) * 100, 1) 
                        : 0;
                }
            }
        }

        return view('guru.laporan', compact(
            'guru',
            'kelasList',
            'kelasFilter',
            'periodeFilter',
            'tanggalFilter',
            'totalSiswa',
            'rataRataKehadiran',
            'rataRataNilai',
            'siswaHadirHariIni',
            'detailPresensi'
        ));
    }

    /**
     * Display penilaian harian (daily assessment) page
     */
    public function penilaianHarian(Request $request)
    {
        $guru = $this->getCurrentGuru();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Guru tidak ditemukan');
        }

        // Get filter parameters
        $kelasFilter = $request->get('kelas');
        $tanggalFilter = $request->get('tanggal', Carbon::today()->format('Y-m-d'));
        $mapelFilter = $request->get('mapel');
        $siswaFilter = $request->get('siswa');

        // Get mapel taught by this guru
        $mapelGuru = Mapel::where('guru_id', $guru->id)
            ->with('kelas')
            ->get();

        // Get unique classes
        $kelasList = $mapelGuru->pluck('kelas')->unique('id')->filter()->values();

        // Get siswa from selected class
        $kelasId = null;
        $mapelId = null;
        $selectedMapel = null;
        $selectedSiswa = null;
        $siswaList = collect([]);
        
        if ($kelasFilter) {
            $kelas = Kelas::where('nama_kelas', $kelasFilter)->first();
            if ($kelas) {
                $kelasId = $kelas->id;
                // Get all siswa in this class for dropdown
                $siswaList = Siswa::where('kelas_id', $kelasId)
                    ->orderBy('nis')
                    ->get();
            }
        } else {
            if ($kelasList->isNotEmpty()) {
                $kelasId = $kelasList->first()->id;
                $kelasFilter = $kelasList->first()->nama_kelas;
                $siswaList = Siswa::where('kelas_id', $kelasId)
                    ->orderBy('nis')
                    ->get();
            }
        }

        // Get mapel for selected class
        if ($kelasId) {
            // Get mapel list for selected kelas
            $mapelForKelas = $mapelGuru->where('kelas_id', $kelasId);
            
            if ($mapelFilter) {
                $selectedMapel = $mapelForKelas->where('id', $mapelFilter)->first();
            } else {
                $selectedMapel = $mapelForKelas->first();
            }
            
            if ($selectedMapel) {
                $mapelId = $selectedMapel->id;
                if (!$mapelFilter) {
                    $mapelFilter = $selectedMapel->id;
                }
            }
        }

        // Get selected siswa
        if ($siswaFilter && $siswaList->isNotEmpty()) {
            $selectedSiswa = $siswaList->where('id', $siswaFilter)->first();
        }

        // Get penilaian harian for selected siswa, mapel, and date
        $penilaianHariIni = null;
        if ($selectedSiswa && $mapelId) {
            $penilaianHariIni = PenilaianHarian::where('siswa_id', $selectedSiswa->id)
                ->where('mapel_id', $mapelId)
                ->whereDate('tanggal', $tanggalFilter)
                ->orderBy('jenis_penilaian')
                ->first(); // Get first one (or can be multiple based on jenis_penilaian)
        }

        return view('guru.penilaian-harian', compact(
            'guru',
            'kelasList',
            'kelasFilter',
            'tanggalFilter',
            'mapelGuru',
            'mapelFilter',
            'selectedMapel',
            'siswaList',
            'siswaFilter',
            'selectedSiswa',
            'penilaianHariIni'
        ));
    }

    /**
     * Store penilaian harian data
     */
    public function storePenilaianHarian(Request $request)
    {
        $guru = $this->getCurrentGuru();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Guru tidak ditemukan');
        }

        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'mapel_id' => 'required|exists:mapel,id',
            'tanggal' => 'required|date',
            'jenis_penilaian' => 'required|string|max:50',
            'nilai' => 'required|numeric|min:0|max:100',
            'deskripsi' => 'nullable|string',
            'catatan_guru' => 'nullable|string',
        ]);

        // Verify that mapel belongs to this guru
        $mapel = Mapel::where('id', $validated['mapel_id'])
            ->where('guru_id', $guru->id)
            ->first();

        if (!$mapel) {
            return redirect()->back()
                ->with('error', 'Mata pelajaran tidak ditemukan atau tidak diizinkan.');
        }

        // Verify that siswa belongs to the mapel's class
        $siswa = Siswa::findOrFail($validated['siswa_id']);
        if ($siswa->kelas_id != $mapel->kelas_id) {
            return redirect()->back()
                ->with('error', 'Siswa tidak berada di kelas yang sesuai dengan mata pelajaran.');
        }

        DB::beginTransaction();
        try {
            // Check if penilaian already exists for this siswa, mapel, tanggal, and jenis_penilaian
            $existingPenilaian = PenilaianHarian::where('siswa_id', $validated['siswa_id'])
                ->where('mapel_id', $validated['mapel_id'])
                ->whereDate('tanggal', $validated['tanggal'])
                ->where('jenis_penilaian', $validated['jenis_penilaian'])
                ->first();

            if ($existingPenilaian) {
                // Update existing
                $existingPenilaian->update([
                    'nilai' => $validated['nilai'],
                    'deskripsi' => $validated['deskripsi'] ?? null,
                    'catatan_guru' => $validated['catatan_guru'] ?? null,
                ]);
                $message = "Penilaian harian berhasil diperbarui.";
            } else {
                // Create new
                PenilaianHarian::create([
                    'siswa_id' => $validated['siswa_id'],
                    'mapel_id' => $validated['mapel_id'],
                    'tanggal' => $validated['tanggal'],
                    'jenis_penilaian' => $validated['jenis_penilaian'],
                    'nilai' => $validated['nilai'],
                    'deskripsi' => $validated['deskripsi'] ?? null,
                    'catatan_guru' => $validated['catatan_guru'] ?? null,
                ]);
                $message = "Penilaian harian berhasil disimpan.";
            }

            DB::commit();

            return redirect()->back()
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menyimpan penilaian harian: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display notes page
     * Note: Notes are stored in penilaian_harian as catatan_guru
     */
    public function notes(Request $request)
    {
        $guru = $this->getCurrentGuru();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Guru tidak ditemukan');
        }

        // Get filter parameters
        $kelasFilter = $request->get('kelas');
        $siswaFilter = $request->get('siswa');

        // Get mapel taught by this guru
        $mapelGuru = Mapel::where('guru_id', $guru->id)
            ->with('kelas')
            ->get();

        // Get unique classes
        $kelasList = $mapelGuru->pluck('kelas')->unique('id')->filter()->values();

        // Get siswa from selected class
        $kelasId = null;
        $siswaList = collect([]);
        
        if ($kelasFilter) {
            $kelas = Kelas::where('nama_kelas', $kelasFilter)->first();
            if ($kelas) {
                $kelasId = $kelas->id;
                $siswaList = Siswa::where('kelas_id', $kelasId)
                    ->orderBy('nis')
                    ->get();
            }
        } else {
            if ($kelasList->isNotEmpty()) {
                $kelasId = $kelasList->first()->id;
                $kelasFilter = $kelasList->first()->nama_kelas;
                $siswaList = Siswa::where('kelas_id', $kelasId)
                    ->orderBy('nis')
                    ->get();
            }
        }

        // Get recent notes (catatan_guru from penilaian_harian)
        $notesTerbaru = collect([]);
        if ($kelasId) {
            $mapelIds = $mapelGuru->where('kelas_id', $kelasId)->pluck('id')->toArray();
            $siswaIds = $siswaList->pluck('id')->toArray();

            if (!empty($mapelIds) && !empty($siswaIds)) {
                $notesTerbaru = PenilaianHarian::whereIn('mapel_id', $mapelIds)
                    ->whereIn('siswa_id', $siswaIds)
                    ->whereNotNull('catatan_guru')
                    ->where('catatan_guru', '!=', '')
                    ->with(['siswa.kelas', 'mapel'])
                    ->orderBy('tanggal', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get();
            }
        }

        return view('guru.notes', compact(
            'guru',
            'kelasList',
            'kelasFilter',
            'siswaList',
            'siswaFilter',
            'notesTerbaru'
        ));
    }

    /**
     * Display perwalian (homeroom class management) page
     */
    public function perwalian(Request $request)
    {
        $guru = $this->getCurrentGuru();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Guru tidak ditemukan');
        }

        // Get kelas binaan (perwalian) for this guru
        $kelasBinaan = Kelas::where('wali_kelas_id', $guru->id)->first();

        if (!$kelasBinaan) {
            // If guru doesn't have a kelas binaan, show message
            return view('guru.perwalian', [
                'guru' => $guru,
                'kelasBinaan' => null,
                'siswa' => collect([]),
                'jadwalMingguan' => collect([]),
            ]);
        }

        // Get filter parameters
        $jenisKelaminFilter = $request->get('jenis_kelamin', 'Semua');

        // Get siswa from kelas binaan
        $query = Siswa::where('kelas_id', $kelasBinaan->id)
            ->with(['kelas', 'ortu.user']);

        // Filter by jenis kelamin
        if ($jenisKelaminFilter !== 'Semua') {
            $jenisKelamin = $jenisKelaminFilter === 'Laki-laki' ? 'L' : 'P';
            $query->where('jenis_kelamin', $jenisKelamin);
        }

        $siswa = $query->orderBy('nis')->get();

        // Get jadwal mata pelajaran untuk kelas ini selama seminggu
        $hariMinggu = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $jadwalMingguan = collect([]);

        foreach ($hariMinggu as $hari) {
            $mapelHariIni = Mapel::where('kelas_id', $kelasBinaan->id)
                ->where('hari', $hari)
                ->with(['guru.user'])
                ->orderBy('jam_mulai')
                ->get();

            $jadwalMingguan->push([
                'hari' => $hari,
                'mapel' => $mapelHariIni
            ]);
        }

        // Get total mapel count for info card
        $totalMapel = Mapel::where('kelas_id', $kelasBinaan->id)->distinct('kode_mapel')->count('kode_mapel');

        return view('guru.perwalian', compact(
            'guru',
            'kelasBinaan',
            'siswa',
            'jadwalMingguan',
            'jenisKelaminFilter'
        ));
    }

    /**
     * Display kelas saya (my classes/schedule) page
     */
    public function kelasSaya()
    {
        $guru = $this->getCurrentGuru();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Guru tidak ditemukan');
        }

        // Get all mapel taught by this guru
        $mapelList = Mapel::where('guru_id', $guru->id)
            ->with(['kelas'])
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        // Get current day and time
        $now = Carbon::now();
        $hariIni = $now->locale('id')->dayName;
        $hariIniMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];
        $hariIniId = $hariIniMap[$hariIni] ?? 'Senin';
        $jamSekarang = $now->format('H:i');

        // Get jadwal terdekat (today and upcoming)
        $jadwalTerdekat = collect([]);
        
        // Get today's schedule that hasn't passed yet
        $jadwalHariIni = $mapelList->filter(function($mapel) use ($hariIniId, $jamSekarang) {
            if ($mapel->hari === $hariIniId && $mapel->jam_mulai) {
                $jamMulai = Carbon::parse($mapel->jam_mulai)->format('H:i');
                return $jamMulai >= $jamSekarang;
            }
            return false;
        })->sortBy('jam_mulai');

        // Get upcoming schedules for next days
        $hariMinggu = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $hariIndex = array_search($hariIniId, $hariMinggu);
        $hariIndex = $hariIndex !== false ? $hariIndex : 0;
        
        $hariBerikutnya = [];
        for ($i = 1; $i <= 6; $i++) {
            $index = ($hariIndex + $i) % 6;
            $hariBerikutnya[] = $hariMinggu[$index];
        }

        $jadwalBerikutnya = collect([]);
        foreach ($hariBerikutnya as $hari) {
            $mapelHari = $mapelList->where('hari', $hari)->sortBy('jam_mulai');
            if ($mapelHari->isNotEmpty()) {
                $jadwalBerikutnya = $jadwalBerikutnya->merge($mapelHari);
            }
            if ($jadwalBerikutnya->count() >= 5) {
                break;
            }
        }

        // Combine and take up to 5 nearest schedules
        $jadwalTerdekat = $jadwalHariIni->merge($jadwalBerikutnya)->take(5);

        // Get jadwal mingguan (all schedules organized by day)
        $jadwalMingguan = collect([]);
        foreach ($hariMinggu as $hari) {
            $mapelHari = $mapelList->where('hari', $hari)->sortBy('jam_mulai');
            $jadwalMingguan->push([
                'hari' => $hari,
                'mapel' => $mapelHari,
                'isToday' => $hari === $hariIniId
            ]);
        }

        // Get statistics
        $totalMapel = $mapelList->count();
        $totalKelas = $mapelList->pluck('kelas_id')->unique()->count();
        $mapelHariIni = $mapelList->where('hari', $hariIniId)->count();

        return view('guru.kelas-saya', compact(
            'guru',
            'mapelList',
            'jadwalTerdekat',
            'jadwalMingguan',
            'hariIniId',
            'totalMapel',
            'totalKelas',
            'mapelHariIni'
        ));
    }
}

