<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrtuRegister;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Show register form
     */
    public function show()
    {
        return view('register');
    }

    /**
     * Handle register form submission
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:orturegister,email|unique:users,email',
            'alamat' => 'required|string',
            'nomor_hp' => 'required|string|max:20',
            'nik' => 'nullable|string|max:16|unique:orturegister,nik',
            'hubungan' => 'nullable|in:Ayah,Ibu,Wali,Lainnya',
            'pekerjaan' => 'nullable|string|max:100',
            'pendidikan' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $ortuRegister = OrtuRegister::create([
                'name' => $request->nama,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'no_hp' => $request->nomor_hp,
                'nik' => $request->nik,
                'hubungan' => $request->hubungan ?? 'Ayah',
                'pekerjaan' => $request->pekerjaan,
                'pendidikan' => $request->pendidikan,
            ]);

            // Store ID in session for PDF download
            $request->session()->put('register_id', $ortuRegister->id);

            return redirect()->route('register-success')
                ->with('success', 'Pendaftaran berhasil dikirim. Silakan tunggu persetujuan dari admin.');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])
                ->withInput();
        }
    }

    /**
     * Show register success page
     */
    public function registerSuccess(Request $request)
    {
        $registerId = $request->session()->get('register_id');
        $ortuRegister = null;
        
        if ($registerId) {
            $ortuRegister = OrtuRegister::find($registerId);
        }

        return view('register-success', compact('ortuRegister'));
    }

    /**
     * Download formulir PDF
     */
    public function downloadFormulir(Request $request)
    {
        $registerId = $request->session()->get('register_id');
        
        if (!$registerId) {
            return redirect()->route('register')->withErrors(['error' => 'Data pendaftaran tidak ditemukan.']);
        }

        $ortuRegister = OrtuRegister::find($registerId);
        
        if (!$ortuRegister) {
            return redirect()->route('register')->withErrors(['error' => 'Data pendaftaran tidak ditemukan.']);
        }

        // Check if PDF package is available
        if (!class_exists('Barryvdh\DomPDF\Facade\Pdf')) {
            return back()->withErrors(['error' => 'Fitur PDF belum tersedia. Silakan hubungi administrator untuk mengaktifkan fitur ini.']);
        }

        // Generate PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('formulir-pendaftaran-pdf', compact('ortuRegister'));
        return $pdf->download('formulir-pendaftaran-' . $ortuRegister->name . '.pdf');
    }
}
