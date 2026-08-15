<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Anggota_Keluarga;

class AnggotaKeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggotaKeluarga = Anggota_Keluarga::select('nik', 'no_kk', 'nama_anggota_keluarga', 'hubungan_keluarga', 'created_at')
            ->with(['kepalaKeluarga' => function ($query) {
                $query->select('no_kk', 'nama_kepala_keluarga', 'status_penduduk');
            }])
            ->get();

        $total = Anggota_Keluarga::count();

        return response()->json($anggotaKeluarga)
            ->header('X-Total-Count', $total)
            ->header('Access-Control-Expose-Headers', 'X-Total-Count');
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
            'no_kk' => 'required|string|exists:kepala_keluarga,no_kk',
            'hubungan_keluarga' => 'required|string|in:Istri,Anak,Menantu,Cucu,Orang Tua,Mertua,Famili Lain,Pembantu,Lainnya',
            'nik' => 'required|string|unique:anggota_keluarga,nik',
            'nama_anggota_keluarga' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'agama' => 'required|string|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',
            'pendidikan_terakhir' => 'required|string|in:Tidak/Belum Sekolah,Belum Tamat SD/Sederajat,Tamat SD/Sederajat,SLTP/Sederajat,SLTA/Sederajat,Diploma I/II,Diploma III,Diploma IV/Strata I,Strata II,Strata III',
            'pekerjaan' => 'required|string',
            'status_perkawinan' => 'required|string|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati'
        ]);

        $anggotaKeluarga = Anggota_Keluarga::create($validatedData);
        return response()->json($anggotaKeluarga, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Anggota_Keluarga $anggotaKeluarga)
    {
        return response()->json($anggotaKeluarga);
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
    public function update(Request $request, Anggota_Keluarga $anggotaKeluarga)
    {
        $validatedData = $request->validate([
            'no_kk' => 'string|exists:kepala_keluarga,no_kk',
            'hubungan_keluarga' => 'string|in:Istri,Anak,Menantu,Cucu,Orang Tua,Mertua,Famili Lain,Pembantu,Lainnya',
            'nik' => [
                'string',
                Rule::unique('anggota_keluarga', 'nik')->ignore($anggotaKeluarga->nik, 'nik')
            ],
            'nama_anggota_keluarga' => 'string',
            'tempat_lahir' => 'string',
            'tanggal_lahir' => 'date',
            'jenis_kelamin' => 'string|in:Laki-laki,Perempuan',
            'agama' => 'string|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',
            'pendidikan_terakhir' => 'string|in:Tidak/Belum Sekolah,Belum Tamat SD/Sederajat,Tamat SD/Sederajat,SLTP/Sederajat,SLTA/Sederajat,Diploma I/II,Diploma III,Diploma IV/Strata I,Strata II,Strata III',
            'pekerjaan' => 'string',
            'status_perkawinan' => 'string|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati'
        ]);

        $anggotaKeluarga->update($validatedData);
        return response()->json($anggotaKeluarga);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggota_Keluarga $anggotaKeluarga)
    {
        $anggotaKeluarga->delete();
        return response()->json(['message' => 'Anggota keluarga sudah dihapus']);
    }
}
