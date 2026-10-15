<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::with('waliKelas.user')->orderBy('urutan_kelas')->orderBy('rombel')->get();
        return view('admin.kelas.index', compact('kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guruList = Guru::with('user')->orderBy('nip')->get();
        return view('admin.kelas.create', compact('guruList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tingkat' => 'required|string|max:10',
            'rombel' => 'required|string|max:10',
            'wali_kelas' => 'nullable|string|max:100',
            'wali_kelas_id' => 'nullable|exists:guru,id',
            'deskripsi' => 'nullable|string',
            'catatan' => 'nullable|string',
            'kapasitas' => 'nullable|integer|min:1',
        ]);

        // Generate nama_kelas from tingkat + rombel (e.g., "1A", "2B")
        $namaKelas = $validated['tingkat'] . $validated['rombel'];
        
        // Check if nama_kelas already exists
        if (Kelas::where('nama_kelas', $namaKelas)->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['rombel' => 'Kelas dengan tingkat dan rombel ini sudah ada.']);
        }

        // Set urutan_kelas same as tingkat
        $validated['urutan_kelas'] = (int) $validated['tingkat'];
        $validated['nama_kelas'] = $namaKelas;

        Kelas::create($validated);

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kelas = Kelas::with(['waliKelas.user', 'siswa', 'mapel.guru.user'])->findOrFail($id);
        return view('admin.kelas.show', compact('kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kelas = Kelas::findOrFail($id);
        $guruList = Guru::with('user')->orderBy('nip')->get();
        return view('admin.kelas.edit', compact('kelas', 'guruList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kelas = Kelas::findOrFail($id);

        $validated = $request->validate([
            'tingkat' => 'required|string|max:10',
            'rombel' => 'required|string|max:10',
            'wali_kelas' => 'nullable|string|max:100',
            'wali_kelas_id' => 'nullable|exists:guru,id',
            'deskripsi' => 'nullable|string',
            'catatan' => 'nullable|string',
            'kapasitas' => 'nullable|integer|min:1',
        ]);

        // Generate nama_kelas from tingkat + rombel (e.g., "1A", "2B")
        $namaKelas = $validated['tingkat'] . $validated['rombel'];
        
        // Check if nama_kelas already exists (excluding current record)
        if (Kelas::where('nama_kelas', $namaKelas)->where('id', '!=', $id)->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['rombel' => 'Kelas dengan tingkat dan rombel ini sudah ada.']);
        }

        // Set urutan_kelas same as tingkat
        $validated['urutan_kelas'] = (int) $validated['tingkat'];
        $validated['nama_kelas'] = $namaKelas;

        $kelas->update($validated);

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelas = Kelas::findOrFail($id);

        // Check if kelas has siswa or mapel
        if ($kelas->siswa()->count() > 0) {
            return redirect()->route('admin.kelas.index')
                ->with('error', 'Tidak dapat menghapus kelas karena masih memiliki siswa.');
        }

        if ($kelas->mapel()->count() > 0) {
            return redirect()->route('admin.kelas.index')
                ->with('error', 'Tidak dapat menghapus kelas karena masih memiliki mata pelajaran.');
        }

        $kelas->delete();

        return redirect()->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }
}
