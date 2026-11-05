<?php

namespace Tests\Feature;

use App\Models\Kategori;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BukuSaveTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_store_a_book_from_the_web_form(): void
    {
        $kategori = Kategori::create(['nama' => 'Teknologi']);

        $payload = [
            'kategori_id' => $kategori->id,
            'judul' => 'Laravel untuk Pemula',
            'penulis' => 'Rizki',
            'tahun_terbit' => 2026,
        ];

        $this->post(route('buku.store'), $payload)
            ->assertRedirect(route('buku.index'));

        $this->assertDatabaseHas('bukus', $payload);
    }
}
