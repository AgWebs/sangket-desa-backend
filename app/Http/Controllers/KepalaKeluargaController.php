<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kepala_Keluarga;
use App\Models\Bantuan_Penduduk;
use App\Models\Anggota_Keluarga;
use Illuminate\Validation\Rule;

class KepalaKeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kepalaKeluarga = Kepala_Keluarga::select('no_kk', 'nik', 'nama_kepala_keluarga', 'banjar_id', 'rt', 'rw', 'status_penduduk', 'tanggal_mulai_tinggal', 'created_at')
        ->with(['bantuan' => function ($query) {
            $query->select('penduduk_no_kk', 'bantuan_kode'); 
        }])
        ->get();

        $total = Kepala_Keluarga::count();

        return response()->json($kepalaKeluarga)
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
            'no_kk' => 'required|string|unique:kepala_keluarga,no_kk',
            'nik' => 'required|string|unique:kepala_keluarga,nik',
            'nama_kepala_keluarga' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string|in:Laki-laki,Perempuan',
            'agama' => 'required|string|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',
            'pendidikan_terakhir' => 'required|string|in:Tidak/Belum Sekolah,Belum Tamat SD/Sederajat,Tamat SD/Sederajat,SLTP/Sederajat,SLTA/Sederajat,Diploma I/II,Diploma III,Diploma IV/Strata I,Strata II,Strata III',
            'pekerjaan' => 'required|string',
            'status_perkawinan' => 'required|string|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'alamat_lengkap' => 'required|string',
            'rt' => 'required|numeric',
            'rw' => 'required|numeric',
            'banjar_id' => 'required|exists:banjar,id',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status_penduduk' => 'required|string|in:Permanen,Non-permanen',
            'alamat_asal' => 'nullable|string',
            'tanggal_mulai_tinggal' => 'nullable|date',

            'bantuan' => 'nullable|array',
            'bantuan.*' => 'required|string|exists:bantuan,kode_bantuan',
        ]);

        DB::beginTransaction();

        try {
            $dataKepalaKeluarga = collect($validatedData)->except(['bantuan'])->toArray();
            $kepalaKeluarga = Kepala_Keluarga::create($dataKepalaKeluarga);

            if (!empty($validatedData['bantuan'])) {
                foreach ($validatedData['bantuan'] as $bantuanKode) {
                    Bantuan_Penduduk::create([
                        'penduduk_no_kk' => $kepalaKeluarga->no_kk, 
                        'bantuan_kode'   => $bantuanKode,
                    ]);
                }
            }

            DB::commit();

            $kepalaKeluarga->load('bantuan'); 

            return response()->json($kepalaKeluarga, 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Gagal menyimpan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    // public function show(Kepala_Keluarga $kepalaKeluarga)
    // {
    //     $kepalaKeluarga = Kepala_Keluarga::select('no_kk', 'nik', 'nama_kepala_keluarga', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'pendidikan_terakhir', 'pekerjaan', 'status_perkawinan', 'alamat_lengkap', 'rt', 'rw', 'banjar_id', 'latitude', 'longitude', 'status_penduduk', 'alamat_asal', 'tanggal_mulai_tinggal')
    //     ->with(['bantuan' => function ($query) {
    //         $query->select('penduduk_no_kk', 'bantuan_kode'); 
    //     }, 
    //     'anggotaKeluarga' => function ($query) {
    //         $query->select('no_kk', 'nama_anggota_keluarga', 'hubungan_keluarga', 'nik', 'jenis_kelamin', 'tanggal_lahir', 'pekerjaan');
    //     }])
    //     ->get();
    //     return response()->json($kepalaKeluarga);
    // }
    public function show(Kepala_Keluarga $kepalaKeluarga)
    {
        // Cukup gunakan instance $kepalaKeluarga yang sudah di-bind oleh Laravel
        // Tidak perlu query ulang dengan ->get()
        $kepalaKeluarga->load(['bantuan', 'anggotaKeluarga']); 
        
        return response()->json($kepalaKeluarga);
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
    public function update(Request $request, Kepala_Keluarga $kepalaKeluarga)
    {
        $validatedData = $request->validate([
            'no_kk' => [
                'string',
                Rule::unique('kepala_keluarga', 'no_kk')->ignore($kepalaKeluarga->no_kk, 'no_kk')
            ],
            'nik' => [
                'string',
                Rule::unique('kepala_keluarga', 'nik')->ignore($kepalaKeluarga->nik, 'nik')
            ],
            'nama_kepala_keluarga' => 'string',
            'tempat_lahir' => 'string',
            'tanggal_lahir' => 'date',
            'jenis_kelamin' => 'string|in:Laki-laki,Perempuan',
            'agama' => 'string|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',
            'pendidikan_terakhir' => 'string|in:Tidak/Belum Sekolah,Belum Tamat SD/Sederajat,Tamat SD/Sederajat,SLTP/Sederajat,SLTA/Sederajat,Diploma I/II,Diploma III,Diploma IV/Strata I,Strata II,Strata III',
            'pekerjaan' => 'string',
            'status_perkawinan' => 'string|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'alamat_lengkap' => 'string',
            'rt' => 'numeric',
            'rw' => 'numeric',
            'banjar_id' => 'exists:banjar,id',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status_penduduk' => 'string|in:Permanen,Non-permanen',
            'alamat_asal' => 'nullable|string',
            'tanggal_mulai_tinggal' => 'nullable|date',

            'bantuan' => 'nullable|array',
            'bantuan.*' => 'string|exists:bantuan,kode_bantuan',
        ]);

        DB::beginTransaction();

        try {
            $noKkLama = $kepalaKeluarga->no_kk;

            Bantuan_Penduduk::where('penduduk_no_kk', $noKkLama)->delete();

            $dataKepalaKeluarga = collect($validatedData)->except(['bantuan'])->toArray();
            $kepalaKeluarga->update($dataKepalaKeluarga);

            $noKkBaru = $kepalaKeluarga->no_kk;

            if (isset($validatedData['bantuan'])) {
                foreach ($validatedData['bantuan'] as $bantuanKode) {
                    Bantuan_Penduduk::create([
                        'penduduk_no_kk' => $noKkBaru, // Menggunakan no_kk terbaru
                        'bantuan_kode'   => $bantuanKode,
                    ]);
                }
            }

            DB::commit();

            $kepalaKeluarga->load('bantuan');

            return response()->json($kepalaKeluarga, 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Gagal memperbarui data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kepala_Keluarga $kepalaKeluarga)
    {
        $kepalaKeluarga->delete();

        return response()->json(['message' => 'Kepala Keluarga sudah dihapus']);
    }
}
