<?php

namespace Tests\Feature;

use App\Models\Buku;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BukuFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeded_books_are_available_on_the_book_pages(): void
    {
        $this->seed();

        $this->assertDatabaseCount('kategoris', 4);
        $this->assertDatabaseCount('anggotas', 3);
        $this->assertDatabaseCount('bukus', 5);
        $this->assertDatabaseCount('peminjamans', 3);

        $buku = Buku::query()->with('kategori')->firstOrFail();
        $this->assertNotEmpty($buku->judul);
        $this->assertNotEmpty($buku->penulis);
        $this->assertGreaterThanOrEqual(1950, $buku->tahun_terbit);
        $this->assertNotNull($buku->kategori);

        $this->assertSame('/buku', route('buku.index', [], false));

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('href="'.route('buku.index').'"', false);

        $this->get(route('buku.index'))
            ->assertOk()
            ->assertSee($buku->judul)
            ->assertSee($buku->penulis);

        $this->get(route('buku.show', $buku))
            ->assertOk()
            ->assertSee($buku->judul)
            ->assertSee($buku->kategori->nama);
    }
}
