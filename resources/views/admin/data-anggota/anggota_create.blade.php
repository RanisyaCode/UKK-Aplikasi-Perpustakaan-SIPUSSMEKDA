@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .admin-catalog {
        --bg-body: #020617;
        --card-bg: rgba(255, 255, 255, 0.03);
        --text-main: #ffffff;
        --text-muted: rgba(255, 255, 255, 0.6);
        --input-bg: rgba(15, 23, 42, 0.6);
        --garis: rgba(255, 255, 255, 0.1);
        --emerald: #10b981;
        --ocean: #0ea5e9;
        --gradasi: linear-gradient(135deg, #10b981 0%, #0ea5e9 100%);
        --shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        --radial-bg: radial-gradient(circle at 50% 50%, #0f172a 0%, #020617 100%);
    }

    html[data-theme="light"] .admin-catalog {
        --bg-body: #f8fafc;
        --card-bg: #ffffff;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --input-bg: #f1f5f9;
        --garis: rgba(15, 23, 42, 0.08);
        --shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        --radial-bg: radial-gradient(circle at 50% 50%, #f1f5f9 0%, #f8fafc 100%);
    }

    .admin-catalog {
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding: 3rem 1rem;
        background-color: var(--bg-body);
        min-height: 100vh;
        color: var(--text-main);
        position: relative;
        overflow-x: hidden;
        transition: all 0.3s ease;
    }

    .latar-animasi {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        z-index: 0; background: var(--radial-bg);
        pointer-events: none;
    }

    .container { position: relative; z-index: 10; }

    .form-card {
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        border-radius: 28px;
        border: 1px solid var(--garis);
        padding: 2.5rem;
        max-width: 700px;
        margin: 0 auto;
        box-shadow: var(--shadow);
    }

    .judul-form {
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: -0.5px;
        color: var(--text-main) !important;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 0.5rem;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        opacity: 0.9;
    }

    .form-control, .form-select {
        background: var(--input-bg) !important;
        border: 1px solid var(--garis) !important;
        border-radius: 14px;
        padding: 0.75rem 1.1rem;
        color: var(--text-main) !important;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .form-select option {
        background-color: var(--bg-body); 
        color: var(--text-main);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--emerald);
        background: var(--input-bg) !important;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        outline: none;
    }

    .text-gradient {
        background: var(--gradasi);
        -webkit-background-clip: text;
        background-clip: text; 
        -webkit-text-fill-color: transparent;
    }

    .btn-save {
        background: var(--gradasi);
        color: #ffffff !important;
        border: none;
        padding: 0.9rem 2.5rem;
        border-radius: 16px;
        font-weight: 700;
        font-size: 0.9rem;
        transition: transform 0.2s, opacity 0.2s;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        opacity: 0.9;
        color: #ffffff;
    }

    .btn-cancel {
        color: var(--text-main);
        background: var(--card-bg);
        border: 1px solid var(--garis);
        padding: 0.9rem 2rem;
        border-radius: 16px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.3s;
    }

    .btn-cancel:hover {
        background: var(--garis);
        color: var(--text-main);
    }

    .partikel {
        position: absolute; background: var(--emerald);
        border-radius: 50%; opacity: 0;
        animation: terbang linear infinite;
    }

    @keyframes terbang {
        0% { transform: translateY(100vh) scale(0.5); opacity: 0; }
        50% { opacity: 0.2; }
        100% { transform: translateY(-10vh) scale(1.2); opacity: 0; }
    }
</style>

<div class="admin-catalog">
    <div class="latar-animasi" id="particles-container"></div>
    
    <div class="container">
        <div class="mb-5 text-center">
            <h1 class="judul-form">Tambah <span class="text-gradient">Anggota Baru</span></h1>
            <p style="color: var(--text-muted); font-size: 0.85rem;">Pastikan data yang dimasukkan sudah benar.</p>
        </div>

        <div class="form-card">
        <form action="{{ route('anggota.store') }}" method="POST" novalidate>
            @csrf
            <input type="hidden" name="role" value="Siswa">

            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama" value="{{ old('nama') }}">
                    @error('nama') 
                        <small class="text-danger d-block mt-1" style="font-size: 0.75rem; font-weight: 600;">* {{ $message }}</small> 
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">NIS</label>
                    <input type="text" name="nis" class="form-control" placeholder="9 digit angka" value="{{ old('nis') }}">
                    @error('nis') 
                        <small class="text-danger d-block mt-1" style="font-size: 0.75rem; font-weight: 600;">* {{ $message }}</small> 
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="" selected disabled>Pilih Gender</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') 
                        <small class="text-danger d-block mt-1" style="font-size: 0.75rem; font-weight: 600;">* {{ $message }}</small> 
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Alamat Email</label>
                    <input type="email" name="email" class="form-control" placeholder="email@sekolah.com" value="{{ old('email') }}">
                    @error('email') 
                        <small class="text-danger d-block mt-1" style="font-size: 0.75rem; font-weight: 600;">* {{ $message }}</small> 
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">No. Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" placeholder="08xxxxxxxxxx" value="{{ old('no_telepon') }}">
                    @error('no_telepon') 
                        <small class="text-danger d-block mt-1" style="font-size: 0.75rem; font-weight: 600;">* {{ $message }}</small> 
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Kelas</label>
                    <input type="text" name="kelas" class="form-control" placeholder="Contoh: XII RPL 1" value="{{ old('kelas') }}">
                    @error('kelas') 
                        <small class="text-danger d-block mt-1" style="font-size: 0.75rem; font-weight: 600;">* {{ $message }}</small> 
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Password Keamanan</label>
                    <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter">
                    @error('password') 
                        <small class="text-danger d-block mt-1" style="font-size: 0.75rem; font-weight: 600;">* {{ $message }}</small> 
                    @enderror
                </div>

                <div class="col-12 mt-5 d-flex gap-3 justify-content-center">
                    <a href="{{ route('anggota') }}" class="btn btn-cancel">Batal</a>
                    <button type="submit" class="btn btn-save">
                        <i class="bi bi-shield-check me-2"></i> Simpan Data
                    </button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
        
        // --- Logika Animasi Partikel Tetap Sama ---
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