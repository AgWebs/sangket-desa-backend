<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banjar;

class BanjarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banjar = Banjar::all();
        return response()->json($banjar);
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
            'nama_banjar' => 'required|string|unique:banjar,nama_banjar',
        ]);

        $banjar = Banjar::create($validatedData);
        return response()->json($banjar, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $banjar = Banjar::findOrFail($id);
        return response()->json($banjar);
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
            'nama_banjar' => 'string|unique:banjar,nama_banjar,' . $id,
        ]);
        $banjar = Banjar::findOrFail($id);
        $banjar->update($validatedData);

        return response()->json($banjar);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banjar = Banjar::findOrFail($id);

        try {
            $banjar->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'message' => 'Banjar ini masih digunakan oleh data Kepala Keluarga atau Fasilitas Publik, sehingga tidak bisa dihapus. Pindahkan atau hapus data terkait terlebih dahulu.',
            ], 409);
        }

        return response()->json(['message' => 'Banjar sudah dihapus']);
    }
}
