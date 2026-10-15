<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Mapel::with(['guru.user', 'kelas']);

        // Filter by kelas if provided
        if ($request->has('kelas') && $request->kelas !== 'Semua Kelas' && $request->kelas !== '') {
            $query->where('kelas_id', $request->kelas);
        }

        // Filter by guru if provided
        if ($request->has('guru') && $request->guru !== 'Semua Guru' && $request->guru !== '') {
            $query->where('guru_id', $request->guru);
        }

        $mapel = $query->orderBy('nama_mapel')->get();
        $kelasList = Kelas::orderBy('urutan_kelas')->orderBy('rombel')->get();
        $guruList = Guru::with('user')->orderBy('nip')->get();

        return view('admin.mapel.index', compact('mapel', 'kelasList', 'guruList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelasList = Kelas::orderBy('urutan_kelas')->orderBy('rombel')->get();
        $guruList = Guru::with('user')->orderBy('nip')->get();
        return view('admin.mapel.create', compact('kelasList', 'guruList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id',
            'nama_mapel' => 'required|string|max:100',
            'kode_mapel' => 'required|string|max:20|unique:mapel,kode_mapel',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'deskripsi' => 'nullable|string',
        ]);

        // Check if this combination already exists
        $exists = Mapel::where('guru_id', $validated['guru_id'])
            ->where('kelas_id', $validated['kelas_id'])
            ->where('kode_mapel', $validated['kode_mapel'])
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Guru ini sudah mengajar mata pelajaran ini di kelas tersebut.');
        }

        Mapel::create($validated);

        return redirect()->route('admin.mapel.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mapel = Mapel::with(['guru.user', 'kelas', 'presensi.siswa', 'nilai.siswa'])->findOrFail($id);
        return view('admin.mapel.show', compact('mapel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mapel = Mapel::findOrFail($id);
        $kelasList = Kelas::orderBy('urutan_kelas')->orderBy('rombel')->get();
        $guruList = Guru::with('user')->orderBy('nip')->get();
        return view('admin.mapel.edit', compact('mapel', 'kelasList', 'guruList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mapel = Mapel::findOrFail($id);

        $validated = $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id',
            'nama_mapel' => 'required|string|max:100',
            'kode_mapel' => 'required|string|max:20|unique:mapel,kode_mapel,' . $id,
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'deskripsi' => 'nullable|string',
        ]);

        // Check if this combination already exists (excluding current record)
        $exists = Mapel::where('guru_id', $validated['guru_id'])
            ->where('kelas_id', $validated['kelas_id'])
            ->where('kode_mapel', $validated['kode_mapel'])
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Guru ini sudah mengajar mata pelajaran ini di kelas tersebut.');
        }

        $mapel->update($validated);

        return redirect()->route('admin.mapel.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mapel = Mapel::findOrFail($id);

        // Check if mapel has presensi or nilai
        if ($mapel->presensi()->count() > 0) {
            return redirect()->route('admin.mapel.index')
                ->with('error', 'Tidak dapat menghapus mata pelajaran karena masih memiliki data presensi.');
        }

        if ($mapel->nilai()->count() > 0) {
            return redirect()->route('admin.mapel.index')
                ->with('error', 'Tidak dapat menghapus mata pelajaran karena masih memiliki data nilai.');
        }

        $mapel->delete();

        return redirect()->route('admin.mapel.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
