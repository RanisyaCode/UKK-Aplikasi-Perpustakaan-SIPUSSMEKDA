@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    .admin-catalog {
        --bg-body: #020617;
        --bg-radial: radial-gradient(circle at 50% 50%, #0f172a 0%, #020617 100%);
        --emerald: #10b981;
        --ocean: #0ea5e9;
        --gradasi: linear-gradient(135deg, #10b981 0%, #0ea5e9 100%);
        --kaca: rgba(255, 255, 255, 0.03);
        --garis: rgba(255, 255, 255, 0.1);
        --teks-utama: #ffffff;
        --teks-muted: #94a3b8;
        --input-bg: rgba(255, 255, 255, 0.05);
        --shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    html[data-theme="light"] .admin-catalog {
        --bg-body: #f8fafc;
        --bg-radial: radial-gradient(circle at 50% 50%, #f1f5f9 0%, #e2e8f0 100%);
        --kaca: #ffffff;
        --garis: rgba(15, 23, 42, 0.08);
        --teks-utama: #0f172a;
        --teks-muted: #64748b;
        --input-bg: #f1f5f9;
        --shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .admin-catalog {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--bg-body);
        min-height: 100vh;
        padding: 40px 6%;
        color: var(--teks-utama);
        position: relative;
        overflow-x: hidden;
        transition: all 0.3s ease;
    }

    .latar-animasi {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        z-index: 0; background: var(--bg-radial);
        pointer-events: none;
    }

    .container-content { position: relative; z-index: 10; max-width: 1000px; margin: auto; }

    .card-kaca {
        background: var(--kaca);
        backdrop-filter: blur(20px);
        border: 1px solid var(--garis);
        border-radius: 24px;
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .text-gradient {
        background: var(--gradasi);
        -webkit-background-clip: text;
        background-clip: text; 
        -webkit-text-fill-color: transparent;
        font-weight: 800;
    }

    .form-label { 
        color: var(--teks-utama) !important; 
        font-weight: 700; 
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
    }
    
    .form-control, .form-select {
        background: var(--input-bg) !important;
        border: 1px solid var(--garis) !important;
        color: var(--teks-utama) !important;
        border-radius: 12px !important;
        padding: 12px 15px;
        transition: 0.3s;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--emerald) !important;
        box-shadow: 0 0 15px rgba(16, 185, 129, 0.1) !important;
    }

    #previewBox {
        width: 100%; height: 320px;
        background: var(--input-bg);
        border: 2px dashed var(--garis);
        border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden; position: relative;
    }

    .btn-mewah {
        background: var(--gradasi);
        color: white !important;
        padding: 12px 28px;
        border-radius: 14px;
        font-weight: 700;
        border: none;
        transition: 0.4s;
    }
    .btn-mewah:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2); }

    .btn-batal {
        background: var(--input-bg);
        color: var(--teks-utama) !important;
        padding: 12px 28px;
        border-radius: 14px;
        border: 1px solid var(--garis);
        text-decoration: none;
        font-weight: 600;
    }

    .partikel {
        position: absolute; background: var(--emerald);
        border-radius: 50%; opacity: 0.1;
        animation: terbang linear infinite;
    }
    @keyframes terbang {
        from { transform: translateY(100vh); opacity: 0.2; }
        to { transform: translateY(-10vh); opacity: 0; }
    }

    .form-select {
        background-color: var(--kaca) !important;
        color: var(--teks-utama) !important;
        border-color: var(--garis) !important;
    }

    .form-select option {
        background-color: var(--bg-body); 
        color: var(--teks-utama);
    }

    .form-select:focus {
        border-color: var(--emerald) !important;
        box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.25) !important;
    }
</style>

<div class="admin-catalog">
    <div class="latar-animasi" id="particles-container"></div>
    
    <div class="container-content">
        <div class="mb-4 text-center text-md-start">
            <h2 class="fw-800" style="color: var(--teks-utama)">Tambah <span class="text-gradient">Buku Baru</span></h2>
            <p style="color: var(--teks-muted)">Lengkapi formulir untuk menambah koleksi perpustakaan.</p>
        </div>

        <div class="card-kaca">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label">Cover Buku</label>
                            <div id="previewBox">
                                <img id="imgPreview" src="#" alt="Preview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                                <div id="placeholderText" class="text-center">
                                    <i class="bi bi-cloud-arrow-up text-gradient" style="font-size: 3rem;"></i>
                                    <p class="small mt-2" style="color: var(--teks-muted)">Pilih File Cover</p>
                                </div>
                            </div>
                            <input type="file" name="cover" id="coverInput" class="form-control mt-3" accept="image/*">
                            @error('cover') <small class="text-danger d-block mt-2" style="font-weight: 600;">* {{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-8">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Judul Lengkap</label>
                                    <input type="text" name="judul" class="form-control" placeholder="Masukkan judul buku..." value="{{ old('judul') }}">
                                    @error('judul') <small class="text-danger d-block mt-1" style="font-weight: 600;">* {{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Penulis</label>
                                    <input type="text" name="penulis" class="form-control" placeholder="Nama penulis..." value="{{ old('penulis') }}">
                                    @error('penulis') <small class="text-danger d-block mt-1" style="font-weight: 600;">* {{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kategori</label>
                                    <select name="kategori" class="form-select">
                                        <option value="" disabled selected>-- Pilih Kategori --</option>
                                        @foreach($kategoris as $kat)
                                            <option value="{{ $kat }}" {{ old('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori') <small class="text-danger d-block mt-1" style="font-weight: 600;">* {{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">ISBN</label>
                                    <input type="text" name="isbn" class="form-control" placeholder="978-xxxx" value="{{ old('isbn') }}">
                                    @error('isbn') <small class="text-danger d-block mt-1" style="font-weight: 600;">* {{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Penerbit</label>
                                    <input type="text" name="penerbit" class="form-control" placeholder="Gramedia, dll" value="{{ old('penerbit') }}">
                                    @error('penerbit') <small class="text-danger d-block mt-1" style="font-weight: 600;">* {{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jumlah Halaman</label>
                                    <input type="number" name="jumlah_halaman" class="form-control" placeholder="Contoh: 250" value="{{ old('jumlah_halaman') }}">
                                    @error('jumlah_halaman') <small class="text-danger d-block mt-1" style="font-weight: 600;">* {{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Tahun Terbit</label>
                                    <input type="number" name="tahun_terbit" class="form-control" placeholder="YYYY" value="{{ old('tahun_terbit') }}">
                                    @error('tahun_terbit') <small class="text-danger d-block mt-1" style="font-size: 0.7rem; font-weight: 600;">* {{ $message }}</small> @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Stok</label>
                                    <input type="number" name="stok" class="form-control" value="{{ old('stok', 1) }}">
                                    @error('stok') <small class="text-danger d-block mt-1" style="font-weight: 600;">* {{ $message }}</small> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Sinopsis</label>
                                    <textarea name="sinopsis" class="form-control" rows="4" style="resize: none;" placeholder="Tulis ringkasan buku...">{{ old('sinopsis') }}</textarea>
                                </div>
                            </div>

                            <div class="mt-5 d-flex gap-3 justify-content-center justify-content-md-start">
                                <button type="submit" class="btn-mewah">
                                    <i class="bi bi-save2-fill me-2"></i> Simpan Koleksi
                                </button>
                                <a href="{{ route('databuku') }}" class="btn-batal">Batal</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil data session dari Laravel
        // Kita gunakan operator || untuk jaga-jaga jika nilainya kosong
        const msgSuccess = "{{ session('success') }}";
        const msgError = "{{ session('error') }}";
        const hasErrors = "{{ $errors->any() ? 'true' : '' }}";

        // 1. Alert untuk Pesan Sukses
        if (msgSuccess) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: msgSuccess,
                background: 'rgba(15, 23, 42, 0.9)', 
                color: '#fff',
                confirmButtonColor: '#10b981',
                backdrop: `rgba(2, 6, 23, 0.4)`
            });
        }

        // 2. Alert untuk Error Manual (misal dari AuthController)
        if (msgError) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: msgError,
                background: 'rgba(15, 23, 42, 0.9)',
                color: '#fff',
                confirmButtonColor: '#ef4444'
            });
        }

        // 3. Alert untuk Error Validasi (Tulisan merah di bawah input tetap muncul)
        if (hasErrors) {
            Swal.fire({
                icon: 'error',
                title: 'Ups!',
                text: 'Ada beberapa kesalahan pada pengisian form.',
                background: 'rgba(15, 23, 42, 0.9)',
                color: '#fff',
                confirmButtonColor: '#ef4444',
                timer: 3000
            });
        }

        // --- Sisanya (Preview & Partikel) ---
        const coverInput = document.getElementById('coverInput');
        if(coverInput) {
            coverInput.onchange = () => {
                const [file] = coverInput.files;
                if (file) {
                    const img = document.getElementById('imgPreview');
                    img.src = URL.createObjectURL(file);
                    img.style.display = 'block';
                    document.getElementById('placeholderText').style.display = 'none';
                }
            };
        }

        const container = document.getElementById('particles-container');
        if (container) {
            for (let i = 0; i < 15; i++) {
                const p = document.createElement('div');
                p.className = 'partikel';
                p.style.left = Math.random() * 100 + 'vw';
                const size = Math.random() * 3 + 2 + 'px';
                p.style.width = size; p.style.height = size;
                p.style.animationDuration = Math.random() * 10 + 5 + 's';
                p.style.animationDelay = Math.random() * 5 + 's';
                container.appendChild(p);
            }
        }
    });
</script>
@endsection