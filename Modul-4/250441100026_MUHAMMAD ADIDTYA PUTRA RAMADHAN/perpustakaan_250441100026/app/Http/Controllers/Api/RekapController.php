<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Buku;

class RekapController extends Controller
{
    public function bukuPerKategori()
    {
        // Menghitung jumlah buku di masing-masing kategori
        $data = Kategori::withCount('bukus')->get();
        return response()->json($data, 200);
    }

    public function peminjamanPerBuku()
    {
        // Menghitung total peminjaman per buku
        $data = Buku::withCount('peminjamans')->get();
        return response()->json($data, 200);
    }
}