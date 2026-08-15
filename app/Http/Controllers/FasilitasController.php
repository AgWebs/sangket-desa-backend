<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fasilitas;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FasilitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fasilitas = Fasilitas::all();
        return response()->json($fasilitas);
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
            'nama_fasilitas' => 'required|string',
            'jenis_fasilitas' => 'required|string|in:pendidikan,kesehatan,olahraga,ibadah,umum',
            'lokasi_banjar_id' => 'required|exists:banjar,id',
            'kondisi' => 'required|string|in:baik,rusak_ringan,rusak_berat',
            'keterangan' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            // 'foto' dikirim sebagai base64 data URL (mis. "data:image/jpeg;base64,...."),
            // BUKAN file upload multipart biasa — supaya tetap kompatibel dengan
            // Refine simple-rest data provider yang mengirim JSON.
            'foto' => 'nullable|string',
        ]);

        $fotoBase64 = $validatedData['foto'] ?? null;
        unset($validatedData['foto']);

        if ($fotoBase64) {
            $validatedData['foto_url'] = $this->simpanFotoBase64($fotoBase64);
        }

        $fasilitas = Fasilitas::create($validatedData);
        return response()->json($fasilitas, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        return response()->json($fasilitas);
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
            'nama_fasilitas' => 'string',
            'jenis_fasilitas' => 'string|in:pendidikan,kesehatan,olahraga,ibadah,umum',
            'lokasi_banjar_id' => 'exists:banjar,id',
            'kondisi' => 'string|in:baik,rusak_ringan,rusak_berat',
            'keterangan' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            // String biasa berarti URL lama dikirim balik (tidak berubah).
            // Data URL base64 berarti ada foto baru yang perlu disimpan.
            'foto' => 'nullable|string',
            // Dikirim eksplisit true kalau user menghapus foto tanpa mengganti.
            'hapus_foto' => 'nullable|boolean',
        ]);

        $fasilitas = Fasilitas::findOrFail($id);

        $fotoBaru = $validatedData['foto'] ?? null;
        $hapusFoto = $validatedData['hapus_foto'] ?? false;
        unset($validatedData['foto'], $validatedData['hapus_foto']);

        if ($fotoBaru && str_starts_with($fotoBaru, 'data:image')) {
            // Ada foto baru (base64) → hapus foto lama, simpan yang baru
            $this->hapusFotoLama($fasilitas->foto_url);
            $validatedData['foto_url'] = $this->simpanFotoBase64($fotoBaru);
        } elseif ($hapusFoto) {
            $this->hapusFotoLama($fasilitas->foto_url);
            $validatedData['foto_url'] = null;
        }
        // Kalau $fotoBaru adalah URL biasa (bukan data:image base64) atau tidak
        // dikirim sama sekali, foto_url yang lama dibiarkan apa adanya.

        $fasilitas->update($validatedData);

        return response()->json($fasilitas);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $this->hapusFotoLama($fasilitas->foto_url);
        $fasilitas->delete();

        return response()->json(['message' => 'Fasilitas sudah dihapus']);
    }

    /**
     * Decode base64 data URL dan simpan sebagai file di disk `public`
     * (storage/app/public/fasilitas), lalu kembalikan URL publiknya.
     */
    private function simpanFotoBase64(string $dataUrl): string
    {
        // Format: "data:image/jpeg;base64,/9j/4AAQSkZJRg...."
        if (!preg_match('/^data:image\/(\w+);base64,/', $dataUrl, $matches)) {
            abort(422, 'Format foto tidak valid.');
        }

        $extension = $matches[1] === 'jpeg' ? 'jpg' : $matches[1];
        $binaryData = base64_decode(substr($dataUrl, strpos($dataUrl, ',') + 1));

        // Batasi ukuran maksimal 5MB supaya tidak membebani server
        if (strlen($binaryData) > 5 * 1024 * 1024) {
            abort(422, 'Ukuran foto maksimal 5MB.');
        }

        $filename = 'fasilitas/' . Str::uuid() . '.' . $extension;
        Storage::disk('public')->put($filename, $binaryData);

        // Storage::url() saja menghasilkan path RELATIF (mis. "/storage/fasilitas/xxx.jpg").
        // Karena frontend (Next.js, port 3000) dan backend (Laravel, port 8000) beda origin,
        // path relatif itu akan di-resolve browser ke origin Next.js dan jadi 404.
        // Makanya di sini dibuat URL absolut ke origin Laravel (APP_URL).
        return url(Storage::url($filename));
    }

    /**
     * Hapus file foto lama dari disk `public` (kalau ada dan memang berasal
     * dari folder fasilitas/, bukan URL eksternal).
     */
    private function hapusFotoLama(?string $fotoUrl): void
    {
        if (!$fotoUrl) {
            return;
        }

        $path = str_replace('/storage/', '', parse_url($fotoUrl, PHP_URL_PATH) ?? '');
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
