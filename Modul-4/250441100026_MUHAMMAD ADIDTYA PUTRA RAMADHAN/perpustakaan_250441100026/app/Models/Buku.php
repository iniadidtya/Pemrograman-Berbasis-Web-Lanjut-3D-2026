<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus';

    // Mengizinkan form untuk menyimpan data ke kolom ini
    protected $fillable = ['kategori_id', 'judul', 'penulis', 'tahun_terbit'];

    // Relasi: 1 Buku dimiliki 1 Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Relasi: 1 Buku memiliki banyak Peminjaman
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}