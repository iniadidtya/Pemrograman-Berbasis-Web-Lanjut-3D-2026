<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBukuRequest;
use App\Models\Buku;
use App\Models\Kategori;

class BukuController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $buku = Buku::with('kategori')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'judul' => $item->judul,
                    'penulis' => $item->penulis,
                    'tahun_terbit' => $item->tahun_terbit,
                    'kategori' => $item->kategori?->nama ?? 'Tanpa Kategori',
                ];
            })
            ->all();

        return view('buku.index', compact('buku'));
    }

    public function create(): \Illuminate\View\View
    {
        $kategoris = Kategori::orderBy('nama')->get();

        return view('buku.create', compact('kategoris'));
    }

    public function store(StoreBukuRequest $request): \Illuminate\Http\RedirectResponse
    {
        Buku::create($request->validated());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(int $id): \Illuminate\View\View
    {
        $buku = Buku::with('kategori')->find($id);

        if (! $buku) {
            abort(404);
        }

        $buku = [
            'id' => $buku->id,
            'judul' => $buku->judul,
            'penulis' => $buku->penulis,
            'tahun_terbit' => $buku->tahun_terbit,
            'kategori' => $buku->kategori?->nama ?? 'Tanpa Kategori',
        ];

        return view('buku.detail', compact('buku'));
    }
}