<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Http\Resources\BukuResource;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // 1. GET /api/buku (Menampilkan Semua + Filter + Search)
    public function index(Request $request)
    {
        // Query dengan relasi kategori dan count peminjamans (Eager Loading)
        $query = Buku::with('kategori')->withCount('peminjamans');

        // Filter: Cari Judul/Penulis
        if ($request->has('cari')) {
            $query->where('judul', 'like', '%' . $request->cari . '%')
                  ->orWhere('penulis', 'like', '%' . $request->cari . '%');
        }

        // Filter: Kategori
        if ($request->has('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter: Tahun
        if ($request->has('tahun')) {
            $query->where('tahun_terbit', $request->tahun);
        }

        $buku = $query->orderBy('created_at', 'desc')->get();

        return BukuResource::collection($buku); //diganti dengan ini, yang awalya menggunakan return responese()->json
    }

    // 2. POST /api/buku (Menyimpan Data Baru)
    public function store(StoreBukuRequest $request)
    {
        // $request->validated() adalah fitur Mass Assignment Protection. Hanya data yang lolos validasi yang diambil.
        $buku = Buku::create($request->validated());
        
        return response()->json($buku, 201); // 201 = Created
    }

    // 3. GET /api/buku/{id} (Melihat Detail 1 Buku)
    public function show($id)
    {
        $buku = Buku::with('kategori')->withCount('peminjamans')->find($id);

        if (!$buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        return new BukuResource($buku);
    }

    // 4. PUT /api/buku/{id} (Mengubah Data)
    public function update(UpdateBukuRequest $request, $id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        $buku->update($request->validated());

        return response()->json($buku, 200);
    }

    // 5. DELETE /api/buku/{id} (Menghapus Data)
    public function destroy($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus'], 200);
    }
}