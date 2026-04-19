@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .main-container {
        --grad-masterpiece: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
        --bg-body: #020617;
        --kaca: rgba(15, 23, 42, 0.7);
        --garis: rgba(255, 255, 255, 0.08);
        --text-header: #ffffff;
        --text-p: #94a3b8;
        --input-bg: rgba(255, 255, 255, 0.03);
        --card-buku-bg: rgba(255, 255, 255, 0.05);
    }

    html[data-theme="light"] .main-container {
        --bg-body: #f8fafc;
        --kaca: rgba(255, 255, 255, 0.8);
        --garis: rgba(15, 23, 42, 0.08);
        --text-header: #0f172a;
        --text-p: #64748b;
        --input-bg: #f1f5f9;
        --card-buku-bg: #ffffff;
    }

    .main-container {
        max-width: 750px;
        margin: 1.5rem auto;
        padding: 0 1rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .glass-card {
        background: var(--kaca);
        backdrop-filter: blur(20px);
        border-radius: 28px;
        border: 1px solid var(--garis);
        padding: 2.5rem;
    }

    .section-title {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #10b981;
        letter-spacing: 1px;
        margin: 1.5rem 0 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title::after {
        content: "";
        height: 1px;
        background: var(--garis);
        flex: 1;
    }

    .search-input-wrapper {
        position: relative;
        margin-bottom: 0.5rem;
    }

    .custom-input {
        width: 100%;
        padding: 0.8rem 1rem 0.8rem 3rem;
        background: var(--input-bg);
        border: 1px solid var(--garis);
        border-radius: 14px;
        color: var(--text-header);
        font-size: 0.9rem;
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #10b981;
    }

    .buku-container {
        background: var(--input-bg);
        border-radius: 20px;
        padding: 1.5rem;
        border: 1px solid var(--garis);
    }

    .buku-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 1.25rem;
        max-height: 350px;
        overflow-y: auto;
        padding-right: 5px;
    }

    .buku-card {
        background: var(--card-buku-bg);
        border-radius: 16px;
        padding: 10px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent;
        text-align: center;
        position: relative;
    }

    .buku-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .buku-card.selected {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.05);
    }

    .buku-card.selected::before {
        content: "\F26E"; 
        font-family: "bootstrap-icons";
        position: absolute;
        top: 8px;
        right: 8px;
        color: #10b981;
        font-size: 1.2rem;
        background: white;
        border-radius: 50%;
        height: 20px;
        width: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
    }

    .cover-wrapper {
        width: 100%;
        aspect-ratio: 3/4;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 8px;
        background: #334155;
    }

    .cover-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .buku-judul {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-header);
        display: -webkit-box;
        -webkit-line-clamp: 1; 
        line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .buku-stok {
        font-size: 0.7rem;
        color: var(--text-p);
    }

    /* DATE & BUTTON */
    .date-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .date-box {
        background: var(--input-bg);
        border: 1px solid var(--garis);
        border-radius: 14px;
        padding: 0.7rem 1rem;
    }

    .date-box label {
        display: block;
        font-size: 0.65rem;
        font-weight: 800;
        color: var(--text-p);
        margin-bottom: 2px;
    }

    .date-box input {
        background: transparent;
        border: none;
        color: var(--text-header);
        width: 100%;
        font-weight: 600;
        outline: none;
        font-size: 0.9rem;
    }

    .btn-submit {
        background: var(--grad-masterpiece);
        color: white;
        width: 100%;
        border: none;
        padding: 1rem;
        border-radius: 16px;
        font-weight: 700;
        margin-top: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: 0.3s;
        cursor: pointer;
    }

    .btn-submit:hover {
        transform: scale(1.02);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
    }

    /* Custom Scrollbar */
    .buku-grid::-webkit-scrollbar { width: 5px; }
    .buku-grid::-webkit-scrollbar-thumb { background: var(--garis); border-radius: 10px; }

    /* Dropdown Siswa Custom */
    #dropdown_siswa {
        position: absolute;
        width: 100%;
        background: var(--bg-body);
        border: 1px solid var(--garis);
        border-radius: 12px;
        z-index: 100;
        display: none;
        max-height: 150px;
        overflow-y: auto;
    }
    .siswa-item {
        padding: 10px 15px;
        cursor: pointer;
        border-bottom: 1px solid var(--garis);
        font-size: 0.85rem;
        color: var(--text-header);
    }
    .siswa-item:hover { background: var(--grad-masterpiece); color: white; }

    /* Style Tombol Kembali Custom */
    .btn-back {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0.7rem 2rem;
        border-radius: 16px;
        font-weight: 700;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s ease;
        background: var(--input-bg);
        color: var(--text-header);
        border: 1px solid var(--garis);
    }

    .btn-back:hover {
        background: var(--garis);
        color: #10b981; /* Warna Emerald saat hover */
        transform: translateX(-5px);
    }

    .gap-3 {
        gap: 1rem !important;
    }
</style>

<div class="main-container">
    <div class="glass-card">
        <div class="header-section text-center mb-4">
            <h2 style="font-weight: 800; color: var(--text-header);">Tambah Pinjaman</h2>
            <p style="color: var(--text-p); font-size: 0.85rem;">Silahkan lengkapi data peminjaman buku di bawah ini.</p>
        </div>

        <form action="{{ route('admin.transaksi.store') }}" method="POST">
            @csrf

            <div class="section-title">1. Data Peminjam</div>
            <div class="search-input-wrapper">
                <i class="bi bi-person-search search-icon"></i>
                <input type="text" id="siswa_search" class="custom-input" placeholder="Cari nama, NIS, atau kelas..." autocomplete="off" required>
                <div id="dropdown_siswa">
                    @foreach($users as $user)
                        <div class="siswa-item" data-id="{{ $user->id }}" data-value="{{ $user->nama }} | {{ $user->kelas }}">
                            {{ $user->nama }} <small>({{ $user->kelas }})</small>
                        </div>
                    @endforeach
                </div>
            </div>
            <input type="hidden" name="user_id" id="user_id_hidden">

            <div class="section-title">2. Pilih Koleksi</div>
            <div class="search-input-wrapper mb-3">
                <i class="bi bi-search search-icon"></i>
                <input type="text" id="buku_filter" class="custom-input" placeholder="Cari berdasarkan judul...">
            </div>

            <div class="buku-container">
                <div class="buku-grid" id="bukuGrid">
                    @foreach($bukus as $buku)
                    <div class="buku-card" data-id="{{ $buku->id }}" data-judul="{{ strtolower($buku->judul) }}">
                        <div class="cover-wrapper">
                            @if($buku->cover)
                                <img src="{{ asset('storage/covers/' . $buku->cover) }}" alt="{{ $buku->judul }}">
                            @else
                                <div style="display:flex;align-items:center;justify-content:center;height:100%;color:gray">No Cover</div>
                            @endif
                        </div>
                        <div class="buku-judul">{{ $buku->judul }}</div>
                        <div class="buku-stok">Stok: {{ $buku->stok }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            <input type="hidden" name="buku_id" id="buku_id_hidden" required>

            <div class="section-title">3. Waktu Pinjam</div>
            <div class="date-row">
                <div class="date-box">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tanggal_pinjam" id="tgl_pinjam" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="date-box" style="opacity: 0.7;">
                    <label>Batas Pengembalian</label>
                    <input type="date" name="tanggal_kembali" id="tgl_kembali" readonly>
                </div>
            </div>
            
            <div class="col-12 mt-5 d-flex gap-3 justify-content-center">
                <a href="{{ route('admin.transaksi.peminjaman') }}" class="btn-back">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn-submit" style="margin-top: 0; width: auto; padding: 0.7rem 2rem;">
                    <i class="bi bi-plus-lg"></i> Proses Peminjaman
                </button>
            </div>
            <p class="text-warning" style="font-size: 0.75rem; font-weight: 600;">
                <i class="bi bi-info-circle"></i> Maksimal peminjaman aktif adalah 3 buku per anggota.
            </p>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. Fungsi Helper untuk Deteksi Tema ---
        const getSwalConfig = () => {
            const isLight = document.documentElement.getAttribute('data-theme') === 'light';
            return {
                background: isLight ? '#ffffff' : 'rgba(15, 23, 42, 0.95)',
                color: isLight ? '#0f172a' : '#ffffff',
                confirmButtonColor: '#10b981', 
                backdrop: isLight ? 'rgba(0,0,0,0.2)' : 'rgba(2, 6, 23, 0.7)',
            };
        };

        const msgSuccess = "{{ session('success') }}";
        const msgError = "{{ session('error') }}";
        const hasErrors = "{{ $errors->any() ? 'true' : '' }}";

        // --- 2. Alert untuk Pesan Sukses ---
        if (msgSuccess) {
            const config = getSwalConfig();
            Swal.fire({
                ...config,
                icon: 'success',
                title: 'Berhasil!',
                text: msgSuccess,
            });
        }

        // --- 3. Alert untuk Error Manual (Termasuk Cek Kuota 3 Buku) ---
        if (msgError) {
            const config = getSwalConfig();
            Swal.fire({
                ...config,
                icon: 'error',
                title: 'Gagal!',
                text: msgError,
                confirmButtonColor: '#ef4444' // Merah untuk error
            });
        }

        // --- 4. Alert untuk Error Validasi Form ---
        if (hasErrors) {
            const config = getSwalConfig();
            Swal.fire({
                ...config,
                icon: 'error',
                title: 'Ups!',
                text: 'Ada beberapa kesalahan pada pengisian form.',
                confirmButtonColor: '#ef4444',
                timer: 3000
            });
        }

        // --- LOGIKA FORM LAINNYA (Pilih Buku, Search, dll) ---
        const bukuCards = document.querySelectorAll('.buku-card');
        const bukuHidden = document.getElementById('buku_id_hidden');
        const bukuFilter = document.getElementById('buku_filter');
        const tglPinjam = document.getElementById('tgl_pinjam');
        const tglKembali = document.getElementById('tgl_kembali');

        bukuCards.forEach(card => {
            card.addEventListener('click', function() {
                bukuCards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                bukuHidden.value = this.dataset.id;
            });
        });

        // Filter Buku
        bukuFilter.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            bukuCards.forEach(card => {
                const judul = card.dataset.judul;
                card.style.display = judul.includes(query) ? 'block' : 'none';
            });
        });

        // Dropdown Siswa
        const sSearch = document.getElementById('siswa_search');
        const sDrop = document.getElementById('dropdown_siswa');
        const sHidden = document.getElementById('user_id_hidden');
        const sItems = document.querySelectorAll('.siswa-item');

        sSearch.addEventListener('focus', () => sDrop.style.display = 'block');
        sSearch.addEventListener('input', function() {
            const q = this.value.toLowerCase();
            sItems.forEach(item => {
                item.style.display = item.innerText.toLowerCase().includes(q) ? 'block' : 'none';
            });
        });

        sItems.forEach(item => {
            item.addEventListener('click', function() {
                sSearch.value = this.dataset.value;
                sHidden.value = this.dataset.id;
                sDrop.style.display = 'none';
            });
        });

        function setTglKembali() {
            if(tglPinjam.value) {
                let d = new window.Date(tglPinjam.value);
                d.setDate(d.getDate() + 7);
                tglKembali.value = d.toISOString().split('T')[0];
            }
        }
        tglPinjam.addEventListener('change', setTglKembali);
        setTglKembali();

        document.addEventListener('click', (e) => {
            if(!sSearch.contains(e.target)) sDrop.style.display = 'none';
        });
    });
</script>
@endsection