@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>

    .admin-catalog {
        --bg-body: #020617;
        --card-bg: rgba(255, 255, 255, 0.03);
        --text-main: #ffffff;
        --text-muted: rgba(255, 255, 255, 0.5);
        --input-bg: rgba(255, 255, 255, 0.05);
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

    .admin-catalog {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--bg-body);
        min-height: 100vh;
        padding: 40px 6%;
        color: var(--text-main);
        position: relative;
        overflow-x: hidden;
        transition: all 0.3s ease;
    }

    .latar-animasi {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        z-index: 0; 
        background: radial-gradient(circle at 50% 50%, var(--card-bg) 0%, var(--bg-body) 100%);
        pointer-events: none;
    }

    .container-content { position: relative; z-index: 10; max-width: 1000px; margin: auto; }

    .text-gradient {
        background: var(--gradasi);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
    }

    .card-kaca {
        background: var(--card-bg);
        border: 1px solid var(--garis);
        border-radius: 24px;
        overflow: hidden;
        backdrop-filter: blur(20px);
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }

    .form-label { 
        color: var(--text-main) !important; 
        font-weight: 700; 
        font-size: 0.8rem;
        margin-bottom: 10px;
    }
    
    .form-control, .form-select {
        background: var(--input-bg) !important;
        border: 1px solid var(--garis) !important;
        color: var(--text-main) !important;
        border-radius: 12px !important;
        padding: 12px 15px;
    }

    .is-invalid {
        border-color: #ef4444 !important;
    }
    .error-msg {
        color: #ef4444;
        font-size: 11px;
        font-weight: 600;
        margin-top: 5px;
        display: block;
    }

    .form-select option {
        background-color: white; 
        color: black;
    }
    html[data-theme="dark"] .form-select option {
        background-color: #0f172a; 
        color: white;
    }

    #previewBox {
        width: 100%;
        height: 320px;
        background: var(--input-bg);
        border: 2px dashed var(--garis);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
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
    .btn-mewah:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3); }

    .btn-batal {
        background: var(--input-bg);
        color: var(--text-main);
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
        from { transform: translateY(100vh); }
        to { transform: translateY(-10vh); }
    }
</style>

<div class="admin-catalog">
    <div class="latar-animasi" id="particles-container"></div>
    
    <div class="container-content">
        <div class="mb-4">
            <h2 class="fw-800" style="color: var(--text-main)">
                <i class="bi bi-pencil-square me-2 text-gradient"></i>Edit <span class="text-gradient">Data Buku</span>
            </h2>
            <p style="color: var(--text-muted)">Perbarui informasi koleksi buku "{{ $buku->judul }}".</p>
        </div>

        <div class="card-kaca">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label text-uppercase">Cover Saat Ini</label>
                            <div id="previewBox">
                                <img id="imgPreview" src="{{ $buku->cover ? asset('storage/covers/' . $buku->cover) : 'https://ui-avatars.com/api/?name='.urlencode($buku->judul).'&background=10b981&color=fff' }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <input type="file" name="cover" id="coverInput" class="form-control mt-3 @error('cover') is-invalid @enderror" accept="image/*">
                            @error('cover') <span class="error-msg">{{ $message }}</span> @enderror
                            <small style="color: var(--text-muted); font-size: 11px;" class="mt-2 d-block">* Kosongkan jika tidak ingin mengubah cover</small>
                        </div>

                        <div class="col-md-8">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label text-uppercase">Judul Buku</label>
                                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $buku->judul) }}">
                                    @error('judul') <span class="error-msg">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase">Penulis</label>
                                    <input type="text" name="penulis" class="form-control @error('penulis') is-invalid @enderror" value="{{ old('penulis', $buku->penulis) }}">
                                    @error('penulis') <span class="error-msg">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase">Kategori</label>
                                    <select name="kategori" class="form-select @error('kategori') is-invalid @enderror">
                                        @foreach($kategoris as $kat)
                                            <option value="{{ $kat }}" {{ old('kategori', $buku->kategori) == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori') <span class="error-msg">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase">ISBN</label>
                                    <input type="text" name="isbn" class="form-control @error('isbn') is-invalid @enderror" value="{{ old('isbn', $buku->isbn) }}">
                                    @error('isbn') <span class="error-msg">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-uppercase">Stok</label>
                                    <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $buku->stok) }}">
                                    @error('stok') <span class="error-msg">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-uppercase">Sinopsis</label>
                                    <textarea name="sinopsis" class="form-control @error('sinopsis') is-invalid @enderror" rows="4">{{ old('sinopsis', $buku->sinopsis) }}</textarea>
                                    @error('sinopsis') <span class="error-msg">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="mt-5 d-flex gap-3">
                                <button type="submit" class="btn-mewah">Simpan Perubahan</button>
                                <a href="{{ route('databuku') }}" class="btn-batal">Batal</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('coverInput').onchange = function(e) {
        const [file] = this.files;
        if (file) document.getElementById('imgPreview').src = URL.createObjectURL(file);
    };

    const pc = document.getElementById('particles-container');
    for (let i = 0; i < 15; i++) {
        const p = document.createElement('div');
        p.className = 'partikel';
        p.style.left = Math.random() * 100 + 'vw';
        const s = Math.random() * 3 + 2 + 'px';
        p.style.width = s; p.style.height = s;
        p.style.animationDuration = Math.random() * 10 + 10 + 's';
        pc.appendChild(p);
    }
</script>
@endsection