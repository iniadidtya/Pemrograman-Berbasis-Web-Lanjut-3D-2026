@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
    @if($buku != null)
        <h2>Detail Buku: {{ $buku['judul'] }}</h2>
        <div style="background: white; padding: 20px; border-radius: 8px; max-width: 500px;">
            <p><strong>ID Buku:</strong> {{ $buku['id'] }}</p>
            <p><strong>Judul:</strong> {{ $buku['judul'] }}</p>
            <p><strong>Penulis:</strong> {{ $buku['penulis'] }}</p>
            <p><strong>Tahun Terbit:</strong> {{ $buku['tahun_terbit'] }}</p>
            <p><strong>Kategori:</strong> {{ $buku['kategori'] }}</p>
        </div>
    @else
        <h2>Error: Buku Tidak Ditemukan!</h2>
        <p>Maaf, buku yang Anda cari tidak ada di sistem kami.</p>
    @endif

    <br>
    <a href="{{ route('buku.index') }}" class="btn" style="background-color: gray;">Kembali ke Daftar Buku</a>
@endsection