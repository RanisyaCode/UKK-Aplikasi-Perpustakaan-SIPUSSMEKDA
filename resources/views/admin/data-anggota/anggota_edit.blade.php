@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    /* ==========================================================================
       DYNAMIC THEME ENGINE
       ========================================================================== */
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
    }

    html[data-theme="light"] .admin-catalog {
        --bg-body: #f8fafc;
        --card-bg: #ffffff;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --input-bg: #f1f5f9;
        --garis: rgba(15, 23, 42, 0.08);
    }

    .error-text {
        color: #ef4444;
        font-size: 0.7rem;
        font-weight: 600;
        margin-top: 5px;
        display: block;
    }

    .is-invalid {
        border-color: #ef4444 !important;
    }

    .admin-catalog {
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding: 3rem 1rem;
        background-color: var(--bg-body);
        min-height: 100vh;
        color: var(--text-main);
        position: relative;
        overflow-x: hidden;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .latar-animasi {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        z-index: 0; 
        background: radial-gradient(circle at 50% 50%, var(--card-bg) 0%, var(--bg-body) 100%);
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
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2);
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

    .btn-update {
        background: var(--gradasi);
        color: #ffffff !important;
        border: none;
        padding: 0.9rem 2.5rem;
        border-radius: 16px;
        font-weight: 700;
        font-size: 0.9rem;
        transition: transform 0.2s, opacity 0.2s;
    }

    .btn-update:hover {
        transform: translateY(-2px);
        opacity: 0.9;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
    }

    .btn-back {
        color: var(--text-main);
        background: var(--card-bg);
        border: 1px solid var(--garis);
        padding: 0.9rem 2rem;
        border-radius: 16px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-back:hover {
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

    .input-group-icon {
        position: relative;
    }

    .input-group-icon i {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--emerald);
        opacity: 0.7;
        font-size: 1rem;
    }
</style>

<div class="admin-catalog">
    <div class="latar-animasi" id="particles-container"></div>
    
    <div class="container">
        <div class="mb-5 text-center">
            <h1 class="judul-form">Ubah <span class="text-gradient">Data Anggota</span></h1>
            <p style="color: var(--text-muted); font-size: 0.85rem;">Memperbarui profil: <b>{{ $siswa->nama }}</b></p>
        </div>

        <div class="form-card">
            <form action="{{ route('anggota.update', $siswa->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    {{-- Nama --}}
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <div class="input-group-icon">
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $siswa->nama) }}" placeholder="Masukkan nama...">
                            <i class="bi bi-person"></i>
                        </div>
                        @error('nama') <span class="error-text"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                    </div>

                    {{-- NIS --}}
                    <div class="col-md-6">
                        <label class="form-label">NIS</label>
                        <div class="input-group-icon">
                            <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis', $siswa->nis) }}" placeholder="Maks 9 digit...">
                            <i class="bi bi-hash"></i>
                        </div>
                        @error('nis') <span class="error-text"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="col-md-6">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                            <option value="Laki-laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <span class="error-text"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label class="form-label">Alamat Email</label>
                        <div class="input-group-icon">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $siswa->email) }}" placeholder="nama@email.com">
                            <i class="bi bi-envelope"></i>
                        </div>
                        @error('email') <span class="error-text"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                    </div>

                    {{-- No Telepon --}}
                    <div class="col-md-6">
                        <label class="form-label">Nomor Telepon</label>
                        <div class="input-group-icon">
                            <input type="text" name="no_telepon" class="form-control @error('no_telepon') is-invalid @enderror" value="{{ old('no_telepon', $siswa->no_telepon) }}" placeholder="08xxxxxxxxxx">
                            <i class="bi bi-telephone"></i>
                        </div>
                        @error('no_telepon') <span class="error-text"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                    </div>

                    {{-- Kelas --}}
                    <div class="col-md-6">
                        <label class="form-label">Kelas</label>
                        <div class="input-group-icon">
                            <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror" value="{{ old('kelas', $siswa->kelas) }}" placeholder="Contoh: XII RPL 1">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                        @error('kelas') <span class="error-text"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                    </div>

                    {{-- Role --}}
                    <div class="col-md-6">
                        <label class="form-label">Hak Akses (Role)</label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror">
                            <option value="Siswa" {{ old('role', strtolower($siswa->role)) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="admin" {{ old('role', strtolower($siswa->role)) == 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                        @error('role') <span class="error-text"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                    </div>

                    {{-- Password --}}
                    <div class="col-md-6">
                        <label class="form-label">Password <span style="font-size: 0.6rem; opacity: 0.6;">(Kosongkan jika tak diubah)</span></label>
                        <div class="input-group-icon">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••">
                            <i class="bi bi-lock"></i>
                        </div>
                        @error('password') <span class="error-text"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                    </div>

                    <div class="col-12 mt-5 d-flex gap-3 justify-content-center">
                        <a href="{{ route('anggota') }}" class="btn-back">Batalkan</a>
                        <button type="submit" class="btn btn-update">
                            <i class="bi bi-arrow-repeat me-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const container = document.getElementById('particles-container');
    if(container) {
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
</script>
@endsection