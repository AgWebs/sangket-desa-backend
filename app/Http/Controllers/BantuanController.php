<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bantuan;

class BantuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bantuan = Bantuan::all();
        return response()->json($bantuan);
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
            'kode_bantuan' => 'required|string|unique:bantuan,kode_bantuan',
            'nama_bantuan' => 'required|string',
            'keterangan' => 'nullable|string',
            'sumber_dana' => 'required|in:nasional,daerah,dana_desa',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'kode_bantuan.unique' => 'Kode bantuan ":input" sudah dipakai oleh program lain. Gunakan kode yang berbeda.',
            'kode_bantuan.required' => 'Kode bantuan wajib diisi.',
        ]);

        $bantuan = Bantuan::create($validatedData);
        return response()->json($bantuan, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bantuan $bantuan)
    {
        return response()->json($bantuan);
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
    public function update(Request $request, Bantuan $bantuan)
    {
        $validatedData = $request->validate([
            'kode_bantuan' => [
            'sometimes',
            'string',
            \Illuminate\Validation\Rule::unique('bantuan', 'kode_bantuan')->ignore($bantuan->kode_bantuan, 'kode_bantuan')
        ],
            'nama_bantuan' => 'string',
            'keterangan' => 'nullable|string',
            'sumber_dana' => 'sometimes|in:nasional,daerah,dana_desa',
            'status' => 'sometimes|in:aktif,nonaktif',
        ], [
            'kode_bantuan.unique' => 'Kode bantuan ":input" sudah dipakai oleh program lain. Gunakan kode yang berbeda.',
        ]);

        $bantuan->update($validatedData);

        return response()->json($bantuan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bantuan $bantuan)
    {
        $bantuan->delete();

        return response()->json(['message' => 'Bantuan sudah dihapus']);
    }
}
