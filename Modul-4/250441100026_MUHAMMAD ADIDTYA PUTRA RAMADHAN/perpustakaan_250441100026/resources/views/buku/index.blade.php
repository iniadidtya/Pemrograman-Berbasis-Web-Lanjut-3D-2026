@extends('layouts.app')

@section('title', 'Manajemen Buku (CRUD API)')

@section('content')
<div style="max-width: 1200px; margin: 24px auto; padding: 0 16px;">
    <!-- Header Section -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="margin: 0; font-size: 1.75rem; color: #0f172a; font-weight: 700;">Katalog & Manajemen Buku</h2>
            <p style="margin: 4px 0 0; color: #64748b; font-size: 0.95rem;">Operasi CRUD Real-time menggunakan Fetch API, async/await, dan Laravel API Resource.</p>
        </div>
        <div style="display: flex; gap: 8px;">
            <button type="button" onclick="loadBuku()" class="btn" style="margin: 0; padding: 0.6rem 1.2rem; font-size: 0.875rem; background: linear-gradient(135deg, #0284c7, #0369a1); display: inline-flex; align-items: center; gap: 6px;">
                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Segarkan Data
            </button>
        </div>
    </div>

    <!-- Kotak Pesan Notifikasi (Sukses / Error) -->
    <div id="pesan-notifikasi" style="display: none; margin-bottom: 24px; padding: 14px 18px; border-radius: 12px; font-weight: 500; font-size: 0.95rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); transition: all 0.3s ease;"></div>

    <!-- Grid: Form Input & Tabel Data -->
    <div style="display: grid; grid-template-columns: 360px 1fr; gap: 24px; align-items: start;">
        
        <!-- Kolom Form (Create / Update) -->
        <div style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 16px; padding: 24px; box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.05);">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 18px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
                <span style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 10px; background: #eff6ff; color: #2563eb;">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </span>
                <h3 id="form-title" style="margin: 0; font-size: 1.15rem; font-weight: 700; color: #0f172a;">Tambah Buku Baru</h3>
            </div>

            <form id="form-buku">
                <!-- Hidden input ID buku untuk membedakan mode Create vs Update -->
                <input type="hidden" id="buku_id" name="buku_id" value="">

                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <label for="kategori_id" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 6px;">Kategori Buku <span style="color: #ef4444;">*</span></label>
                        <select id="kategori_id" name="kategori_id" required style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 0.92rem; color: #1e293b; background-color: #fff; outline: none; transition: border-color 0.2s;">
                            <option value="">-- Pilih Kategori --</option>
                            @php
                                $kategoris = \App\Models\Kategori::orderBy('nama')->get();
                            @endphp
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }} (ID: {{ $kategori->id }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="judul" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 6px;">Judul Buku <span style="color: #ef4444;">*</span></label>
                        <input type="text" id="judul" name="judul" required placeholder="Contoh: Belajar Laravel 13" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 0.92rem; color: #1e293b; outline: none; transition: border-color 0.2s;">
                    </div>

                    <div>
                        <label for="penulis" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 6px;">Nama Penulis <span style="color: #ef4444;">*</span></label>
                        <input type="text" id="penulis" name="penulis" required placeholder="Contoh: Muhammad Adidtya" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 0.92rem; color: #1e293b; outline: none; transition: border-color 0.2s;">
                    </div>

                    <div>
                        <label for="tahun_terbit" style="display: block; font-size: 0.875rem; font-weight: 600; color: #334155; margin-bottom: 6px;">Tahun Terbit <span style="color: #ef4444;">*</span></label>
                        <input type="number" id="tahun_terbit" name="tahun_terbit" min="1900" max="{{ date('Y') }}" required placeholder="Contoh: {{ date('Y') }}" style="width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 0.92rem; color: #1e293b; outline: none; transition: border-color 0.2s;">
                    </div>
                </div>

                <div style="margin-top: 22px; display: flex; flex-direction: column; gap: 8px;">
                    <button type="submit" id="btn-submit" class="btn" style="margin: 0; width: 100%; padding: 0.75rem 1.25rem; font-size: 0.95rem; background: linear-gradient(135deg, #2563eb, #1d4ed8);">
                        Simpan Buku
                    </button>
                    <button type="button" id="btn-batal" onclick="batalEdit()" style="display: none; width: 100%; padding: 0.65rem 1.25rem; font-size: 0.9rem; font-weight: 600; background: #e2e8f0; color: #475569; border: none; border-radius: 10px; cursor: pointer; transition: background 0.2s;">
                        Batal
                    </button>
                </div>
            </form>
        </div>

        <!-- Kolom Tabel Data Buku -->
        <div style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(226, 232, 240, 0.8); border-radius: 16px; padding: 24px; box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.05); overflow: hidden;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="margin: 0; font-size: 1.15rem; font-weight: 700; color: #0f172a;">Daftar Koleksi Buku</h3>
                <span id="badge-total" style="font-size: 0.85rem; padding: 4px 10px; background: #f1f5f9; color: #475569; border-radius: 9999px; font-weight: 600;">Memuat...</span>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.92rem;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; color: #475569; font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.05em;">
                            <th style="padding: 12px 14px; text-align: center; width: 50px;">No</th>
                            <th style="padding: 12px 14px;">Kategori</th>
                            <th style="padding: 12px 14px;">Judul Buku</th>
                            <th style="padding: 12px 14px;">Penulis</th>
                            <th style="padding: 12px 14px; text-align: center;">Tahun</th>
                            <th style="padding: 12px 14px; text-align: center;">Dipinjam</th>
                            <th style="padding: 12px 14px; text-align: center; width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tabel-buku">
                        <!-- Data buku akan dimuat secara dinamis oleh JavaScript -->
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 28px; color: #64748b;">
                                Memuat data dari API...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<style>
    /* Styling interaktif input & tabel */
    #form-buku input:focus, #form-buku select:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2) !important;
    }
    .badge-kategori {
        display: inline-block;
        padding: 3px 10px;
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
        border-radius: 9999px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        padding: 6px 12px;
        font-size: 0.82rem;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-ubah {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }
    .btn-ubah:hover {
        background: #fde68a;
        transform: translateY(-1px);
    }
    .btn-hapus {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }
    .btn-hapus:hover {
        background: #fecaca;
        transform: translateY(-1px);
    }
    @media (max-width: 900px) {
        div[style*="grid-template-columns: 360px 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<script>
    // Konfigurasi Header Wajib Fetch API
    const API_HEADERS = {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    };

    // Helper untuk menampilkan notifikasi sukses/error
    function tampilkanPesan(pesan, tipe = 'sukses') {
        const notif = document.getElementById('pesan-notifikasi');
        notif.style.display = 'block';

        if (tipe === 'sukses') {
            notif.style.backgroundColor = '#dcfce7';
            notif.style.color = '#166534';
            notif.style.border = '1px solid #86efac';
        } else {
            notif.style.backgroundColor = '#fee2e2';
            notif.style.color = '#991b1b';
            notif.style.border = '1px solid #fca5a5';
        }

        notif.innerHTML = pesan;

        // Auto-scroll ke pesan notifikasi jika pengguna berada di bawah
        notif.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    // Helper untuk membersihkan form dan mengembalikan ke mode Create
    function bersihkanForm() {
        document.getElementById('form-buku').reset();
        document.getElementById('buku_id').value = '';
        document.getElementById('form-title').innerText = 'Tambah Buku Baru';
        document.getElementById('btn-submit').innerText = 'Simpan Buku';
        document.getElementById('btn-batal').style.display = 'none';
    }

    // Tombol Batal Edit
    function batalEdit() {
        bersihkanForm();
        tampilkanPesan('Pengeditan buku dibatalkan.', 'sukses');
    }

    // Helper keamanan dari serangan XSS
    function escapeHtml(text) {
        if (text === null || text === undefined) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // 1. FUNGSI LOAD DATA BUKU (GET /api/buku)
    async function loadBuku() {
        const tbody = document.getElementById('tabel-buku');
        const badgeTotal = document.getElementById('badge-total');

        try {
            const response = await fetch('/api/buku', {
                method: 'GET',
                headers: API_HEADERS
            });

            if (!response.ok) {
                throw new Error(`Gagal memuat data buku (Status: ${response.status})`);
            }

            const result = await response.json();
    
            const listBuku = result.data ? result.data : result;

            tbody.innerHTML = '';

            if (!Array.isArray(listBuku) || listBuku.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 32px; color: #64748b;">
                            Belum ada data buku yang tersimpan di basis data.
                        </td>
                    </tr>
                `;
                badgeTotal.innerText = '0 Buku';
                return;
            }

            badgeTotal.innerText = `${listBuku.length} Buku`;

            // Render baris tabel menggunakan pemetaan atribut BukuResource
            listBuku.forEach((item, index) => {
                const tr = document.createElement('tr');
                tr.style.borderBottom = '1px solid #f1f5f9';
                tr.style.transition = 'background-color 0.15s';
                tr.onmouseenter = () => tr.style.backgroundColor = '#f8fafc';
                tr.onmouseleave = () => tr.style.backgroundColor = 'transparent';

                // Pemetaan atribut API Resource:
                // kategori -> nama kategori
                // judul_buku -> kolom db 'judul'
                // penulis_buku -> kolom db 'penulis'
                // tahun_publikasi -> kolom db 'tahun_terbit'
                // jumlah_peminjaman -> hitungan peminjaman
                tr.innerHTML = `
                    <td style="padding: 14px; text-align: center; color: #64748b; font-weight: 500;">${index + 1}</td>
                    <td style="padding: 14px;">
                        <span class="badge-kategori">${escapeHtml(item.kategori || 'Tanpa Kategori')}</span>
                    </td>
                    <td style="padding: 14px; font-weight: 600; color: #0f172a;">
                        ${escapeHtml(item.judul_buku || item.judul || '-')}
                    </td>
                    <td style="padding: 14px; color: #475569;">
                        ${escapeHtml(item.penulis_buku || item.penulis || '-')}
                    </td>
                    <td style="padding: 14px; text-align: center; color: #475569;">
                        ${item.tahun_publikasi || item.tahun_terbit || '-'}
                    </td>
                    <td style="padding: 14px; text-align: center;">
                        <span style="display: inline-block; padding: 2px 8px; border-radius: 9999px; background: #e0f2fe; color: #0369a1; font-size: 0.8rem; font-weight: 600;">
                            ${item.jumlah_peminjaman ?? 0} kali
                        </span>
                    </td>
                    <td style="padding: 14px; text-align: center;">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <button type="button" class="btn-action btn-ubah" onclick="editBuku(${item.id})">
                                Ubah
                            </button>
                            <button type="button" class="btn-action btn-hapus" onclick="hapusBuku(${item.id})">
                                Hapus
                            </button>
                        </div>
                    </td>
                `;

                tbody.appendChild(tr);
            });

        } catch (error) {
            console.error('Error loadBuku:', error);
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" style="text-align: center; padding: 32px; color: #ef4444;">
                        ${escapeHtml(error.message || 'Gagal memuat data buku.')}
                    </td>
                </tr>
            `;
            tampilkanPesan(error.message || 'Tidak dapat terhubung ke endpoint API /api/buku.', 'error');
        }
    }

    // 2. EVENT LISTENER SUBMIT FORM (POST /api/buku atau PUT /api/buku/{id})
    document.getElementById('form-buku').addEventListener('submit', async function (e) {
        e.preventDefault();

        const bukuId = document.getElementById('buku_id').value;
        const kategoriId = document.getElementById('kategori_id').value;
        const judul = document.getElementById('judul').value;
        const penulis = document.getElementById('penulis').value;
        const tahunTerbit = document.getElementById('tahun_terbit').value;

        // Siapkan payload JSON untuk request ke Controller
        const payload = {
            kategori_id: parseInt(kategoriId, 10),
            judul: judul.trim(),
            penulis: penulis.trim(),
            tahun_terbit: parseInt(tahunTerbit, 10)
        };

        const isEdit = Boolean(bukuId);
        const url = isEdit ? `/api/buku/${bukuId}` : '/api/buku';
        const method = isEdit ? 'PUT' : 'POST';

        const btnSubmit = document.getElementById('btn-submit');
        const teksAsli = btnSubmit.innerText;
        btnSubmit.disabled = true;
        btnSubmit.innerText = 'Menyimpan...';

        try {
            const response = await fetch(url, {
                method: method,
                headers: API_HEADERS,
                body: JSON.stringify(payload)
            });

            // Tangani Error Validasi Laravel (Status 422 Unprocessable Entity)
            if (response.status === 422) {
                const errorData = await response.json();
                let daftarPesan = '<strong>Terjadi kesalahan validasi data:</strong><ul style="margin: 6px 0 0 18px; padding: 0;">';
                if (errorData.errors) {
                    for (const field in errorData.errors) {
                        errorData.errors[field].forEach(msg => {
                            daftarPesan += `<li>${escapeHtml(msg)}</li>`;
                        });
                    }
                } else if (errorData.message) {
                    daftarPesan += `<li>${escapeHtml(errorData.message)}</li>`;
                }
                daftarPesan += '</ul>';
                tampilkanPesan(daftarPesan, 'error');
                return;
            }

            // Tangani status gagal lainnya
            if (!response.ok) {
                const errData = await response.json().catch(() => ({}));
                throw new Error(errData.message || `Operasi gagal dengan status respons ${response.status}`);
            }

            // Operasi Berhasil
            bersihkanForm();
            tampilkanPesan(
                isEdit ? 'Data buku berhasil diperbarui!' : 'Buku baru berhasil ditambahkan ke katalog!',
                'sukses'
            );

            // Perbarui tabel secara otomatis tanpa reload halaman
            await loadBuku();

        } catch (error) {
            console.error('Error submit form:', error);
            tampilkanPesan(error.message || 'Terjadi kegagalan saat mengirim data ke API.', 'error');
        } finally {
            btnSubmit.disabled = false;
            btnSubmit.innerText = teksAsli;
        }
    });

    // 3. FUNGSI EDIT BUKU (GET /api/buku/{id})
    async function editBuku(id) {
        try {
            const response = await fetch(`/api/buku/${id}`, {
                method: 'GET',
                headers: API_HEADERS
            });

            if (!response.ok) {
                throw new Error(`Buku tidak ditemukan atau gagal dimuat (Status: ${response.status})`);
            }

            const result = await response.json();
            const buku = result.data ? result.data : result;

            // Isikan data ke input formulir
            document.getElementById('buku_id').value = buku.id;
            document.getElementById('kategori_id').value = buku.kategori_id;
            // Ambil dari atribut BukuResource atau fallback
            document.getElementById('judul').value = buku.judul_buku || buku.judul || '';
            document.getElementById('penulis').value = buku.penulis_buku || buku.penulis || '';
            document.getElementById('tahun_terbit').value = buku.tahun_publikasi || buku.tahun_terbit || '';

            // Perbarui antarmuka form ke mode Edit
            document.getElementById('form-title').innerText = `Ubah Data Buku (ID: ${buku.id})`;
            document.getElementById('btn-submit').innerText = 'Perbarui Buku';
            document.getElementById('btn-batal').style.display = 'inline-block';

            // Fokus ke input judul
            document.getElementById('judul').focus();
            tampilkanPesan(`Data buku "<em>${escapeHtml(buku.judul_buku || buku.judul)}</em>" siap diubah pada formulir.`, 'sukses');

        } catch (error) {
            console.error('Error editBuku:', error);
            tampilkanPesan(error.message || 'Gagal memuat data buku yang dipilih.', 'error');
        }
    }

    // 4. FUNGSI HAPUS BUKU (DELETE /api/buku/{id})
    async function hapusBuku(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus data buku ini?')) {
            return;
        }

        try {
            const response = await fetch(`/api/buku/${id}`, {
                method: 'DELETE',
                headers: API_HEADERS
            });

            if (!response.ok) {
                const errData = await response.json().catch(() => ({}));
                throw new Error(errData.message || `Gagal menghapus buku (Status: ${response.status})`);
            }

            // Jika buku yang sedang diedit di form adalah buku yang dihapus, reset form
            if (document.getElementById('buku_id').value == id) {
                bersihkanForm();
            }

            tampilkanPesan('Buku berhasil dihapus dari basis data!', 'sukses');

            // Perbarui tabel secara otomatis tanpa reload halaman
            await loadBuku();

        } catch (error) {
            console.error('Error hapusBuku:', error);
            tampilkanPesan(error.message || 'Terjadi kesalahan saat menghapus data buku.', 'error');
        }
    }

    // Inisialisasi: Panggil loadBuku() saat halaman selesai dimuat
    document.addEventListener('DOMContentLoaded', () => {
        loadBuku();
    });
</script>
@endsection