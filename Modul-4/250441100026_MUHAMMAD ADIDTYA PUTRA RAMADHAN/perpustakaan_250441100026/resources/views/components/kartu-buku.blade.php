<div class="book-card">
    <h3>{{ $judul }}</h3>
    <p><strong>Penulis:</strong> {{ $penulis }}</p>
    <p><strong>Tahun:</strong> {{ $tahun }}</p>
    
    <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #eee;">
        {{ $slot }}
    </div>

    <a href="{{ $detailUrl }}" class="btn">Lihat Detail</a>
</div>