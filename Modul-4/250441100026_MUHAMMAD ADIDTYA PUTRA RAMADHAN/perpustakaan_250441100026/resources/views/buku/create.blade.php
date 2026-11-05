@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
    <div style="max-width: 720px; margin: 40px auto; padding: 24px; background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.08);">
        <h2 style="margin-bottom: 20px;">Tambah Buku Baru</h2>

        @if ($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px;">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('buku.store') }}">
            @csrf

            <div style="display: grid; gap: 16px;">
                <div>
                    <label for="kategori_id" style="display: block; margin-bottom: 8px; font-weight: 600;">Kategori</label>
                    <select name="kategori_id" id="kategori_id" required style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px;">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="judul" style="display: block; margin-bottom: 8px; font-weight: 600;">Judul Buku</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px;">
                </div>

                <div>
                    <label for="penulis" style="display: block; margin-bottom: 8px; font-weight: 600;">Penulis</label>
                    <input type="text" name="penulis" id="penulis" value="{{ old('penulis') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px;">
                </div>

                <div>
                    <label for="tahun_terbit" style="display: block; margin-bottom: 8px; font-weight: 600;">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" id="tahun_terbit" value="{{ old('tahun_terbit') }}" min="1900" max="{{ date('Y') }}" required style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px;">
                </div>
            </div>

            <div style="margin-top: 24px; display: flex; gap: 12px; align-items: center;">
                <button type="submit" style="background: #2563eb; color: white; border: none; border-radius: 8px; padding: 10px 18px; font-weight: 600; cursor: pointer;">
                    Simpan Buku
                </button>
                <a href="{{ route('buku.index') }}" style="color: #374151; text-decoration: none;">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
