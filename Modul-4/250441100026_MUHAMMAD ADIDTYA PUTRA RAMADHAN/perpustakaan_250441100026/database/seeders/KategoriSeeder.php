<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        // Pakai factory sequence agar datanya sesuai 4 kategori tugas sebelumnya
        Kategori::factory()->count(4)->sequence(
            ['nama' => 'Teknologi'],        // ID 1
            ['nama' => 'Desain Web'],       // ID 2
            ['nama' => 'Filsafat'],         // ID 3
            ['nama' => 'Pengembangan Diri'] // ID 4
        )->create();
    }
}
