<!-- Memanggil layout utama -->
@extends('layouts.app')

<!-- Mengisi bagian @yield('title') di layout utama -->
@section('title', 'Beranda')

<!-- Mengisi bagian @yield('content') di layout utama -->
@section('content')
    <h1>Selamat Datang di Perpus Kampus</h1>
    <p>Aplikasi perpustakaan sederhana untuk tugas kuliah.</p>
    <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-top: 20px;">
        <a href="{{ route('buku.index') }}" class="btn">Lihat Koleksi Buku Kami</a>
        <a href="{{ route('buku.create') }}" class="btn" style="background: #16a34a;">Tambah Buku Baru</a>
    </div>
@endsection




