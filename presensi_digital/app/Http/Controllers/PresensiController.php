<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PresensiController extends Controller
{
    /**
     * Handle QR code scan submission
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function scan(Request $request): JsonResponse
    {
        // Validate the request
        $request->validate([
            'qr_data' => 'required|string|max:500',
        ]);

        // Get the QR code data and clean it
        $qrData = trim($request->input('qr_data'));
        
        // Log for debugging
        Log::info('Presensi scan request', [
            'qr_data' => $qrData,
            'qr_data_length' => strlen($qrData),
            'timestamp' => now()->toDateTimeString()
        ]);

        // Find siswa by QR code - try exact match first, then case-insensitive
        $siswa = DB::table('siswa')
            ->leftJoin('kelas', 'siswa.kelas_id', '=', 'kelas.id')
            ->where('siswa.qr_code', $qrData)
            ->select(
                'siswa.id as siswa_id',
                'siswa.nis',
                'siswa.nisn',
                'siswa.kelas_id',
                'siswa.qr_code',
                'siswa.nama_siswa',
                'kelas.nama_kelas'
            )
            ->first();

        // If exact match not found, try case-insensitive match
        if (!$siswa) {
            $siswa = DB::table('siswa')
                ->leftJoin('kelas', 'siswa.kelas_id', '=', 'kelas.id')
                ->whereRaw('LOWER(siswa.qr_code) = LOWER(?)', [$qrData])
                ->select(
                    'siswa.id as siswa_id',
                    'siswa.nis',
                    'siswa.nisn',
                    'siswa.kelas_id',
                    'siswa.qr_code',
                    'siswa.nama_siswa',
                    'kelas.nama_kelas'
                )
                ->first();
            
            if ($siswa) {
                Log::info('QR code matched case-insensitively', [
                    'input' => $qrData,
                    'database' => $siswa->qr_code
                ]);
            } else {
                Log::warning('QR code not found', [
                    'input' => $qrData,
                    'available_codes' => DB::table('siswa')->whereNotNull('qr_code')->pluck('qr_code')->take(5)->toArray()
                ]);
            }
        }

        // Check if siswa exists
        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak ditemukan atau tidak valid',
            ], 404);
        }

        // Check for duplicate presensi today (same student, same date)
        $today = Carbon::now()->format('Y-m-d');
        $existingPresensi = DB::table('presensi')
            ->where('siswa_id', $siswa->siswa_id)
            ->where('tanggal', $today)
            ->orderBy('created_at', 'desc')
            ->first();

        // If presensi already exists, return existing data with waktu absen
        if ($existingPresensi) {
            $waktuAbsen = $existingPresensi->waktu_masuk 
                ? Carbon::parse($existingPresensi->waktu_masuk)->format('H:i:s')
                : Carbon::parse($existingPresensi->created_at)->format('H:i:s');
            
            $tanggalAbsen = Carbon::parse($existingPresensi->created_at)->format('d F Y');
            $tanggalAbsenWithTime = Carbon::parse($existingPresensi->created_at)->format('d F Y H:i');
            
            return response()->json([
                'success' => true,
                'message' => 'Presensi untuk hari ini sudah tercatat sebelumnya',
                'already_present' => true,
                'data' => [
                    'nama_siswa' => $siswa->nama_siswa,
                    'nis' => $siswa->nis,
                    'nisn' => $siswa->nisn,
                    'kelas' => $siswa->nama_kelas ?? '-',
                    'waktu_presensi' => $waktuAbsen,
                    'tanggal' => $today,
                    'tanggal_full' => $tanggalAbsen,
                    'waktu_absen_lengkap' => $tanggalAbsenWithTime,
                ],
            ], 200);
        }

        // Save new presensi
        $waktuMasuk = Carbon::now()->format('H:i:s');
        $waktuMasukFull = Carbon::now();
        $presensiId = DB::table('presensi')->insertGetId([
            'siswa_id' => $siswa->siswa_id,
            'guru_id' => null,
            'mapel_id' => null,
            'ortu_id' => null,
            'tanggal' => $today,
            'waktu_masuk' => $waktuMasuk,
            'waktu_keluar' => null,
            'status' => 'hadir',
            'qr_data' => $qrData,
            'keterangan' => null,
            'lokasi' => 'SDN 1 Unduolo',
            'created_at' => $waktuMasukFull,
            'updated_at' => $waktuMasukFull,
        ]);

        // Return success response with siswa data
        return response()->json([
            'success' => true,
            'message' => 'Presensi berhasil direkam',
            'already_present' => false,
            'data' => [
                'nama_siswa' => $siswa->nama_siswa,
                'nis' => $siswa->nis,
                'nisn' => $siswa->nisn,
                'kelas' => $siswa->nama_kelas ?? '-',
                'waktu_presensi' => $waktuMasuk,
                'tanggal' => $today,
                'tanggal_full' => $waktuMasukFull->format('d F Y'),
                'waktu_absen_lengkap' => $waktuMasukFull->format('d F Y H:i'),
            ],
        ], 200);
    }
}

