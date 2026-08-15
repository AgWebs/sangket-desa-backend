<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bantuan_Penduduk;

class BantuanPendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bantuanPenduduk = Bantuan_Penduduk::all();
        return response()->json($bantuanPenduduk);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'penduduk_no_kk' => 'required|string|exists:kepala_keluarga,no_kk',
            'bantuan_kode' => 'required|string|exists:bantuan,kode_bantuan',
            'tanggal_menerima' => 'nullable|date',
        ]);

        $bantuanPenduduk = Bantuan_Penduduk::create($validatedData);
        return response()->json($bantuanPenduduk);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'penduduk_no_kk' => 'string|exists:kepala_keluarga,no_kk',
            'bantuan_kode' => 'string|exists:bantuan,kode_bantuan',
            'tanggal_menerima' => 'nullable|date',
        ]);
        
        $bantuanPenduduk = Bantuan_Penduduk::findOrFail($id);
        $bantuanPenduduk->update($validatedData);
        return response()->json($bantuanPenduduk);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bantuanPenduduk = Bantuan_Penduduk::findOrFail($id);
        $bantuanPenduduk->delete();
        return response()->json(['message' => 'Data Bantuan Penduduk berhasil dihapus']);
    }
}
