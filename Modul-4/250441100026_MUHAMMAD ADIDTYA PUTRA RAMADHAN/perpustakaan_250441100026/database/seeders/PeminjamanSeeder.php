<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Peminjaman;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        // Karena ada relasi, ID anggota ambil 1-3, ID buku ambil 1-5
        Peminjaman::factory()->count(3)->sequence(
            ['anggota_id' => 1, 'buku_id' => 1],
            ['anggota_id' => 2, 'buku_id' => 3],
            ['anggota_id' => 3, 'buku_id' => 5],
        )->create();
    }
}
