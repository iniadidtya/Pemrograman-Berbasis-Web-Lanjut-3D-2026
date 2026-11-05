<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BukuResource extends JsonResource
{
    public function toArray(Request $request): array// fungsi toArray() untuk mengatur agar kolom ketegori tidak hannya menampilkan kategori_id, tetapi langsung mengambil relasi namanya fiksi melalui $this->kategori->nama. 
    {
        return [
            'id' => $this->id,
            'kategori_id' => $this->kategori_id,
            // PEMETAAN: Atribut API berbeda dengan kolom Database
            'kategori' => $this->kategori->nama ?? 'Tanpa Kategori',
            'judul_buku' => $this->judul,          // DB: judul
            'penulis_buku' => $this->penulis,      // DB: penulis
            'tahun_publikasi' => $this->tahun_terbit, // DB: tahun_terbit
            'jumlah_peminjaman' => $this->peminjamans_count ?? 0
        ];
    }
}