<!DOCTYPE html>
<html lang="id" data-theme="{{ auth()->user()->theme ?? 'dark' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Peminjaman | SIPUS SMEKDA</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('duralux/assets/images/logo/logo open book perpus.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --bg-body: #020617;
            --emerald: #10b981;
            --ocean: #0ea5e9;
            --gradasi: linear-gradient(135deg, #10b981 0%, #0ea5e9 100%);
            --kaca: rgba(255, 255, 255, 0.03);
            --garis: rgba(255, 255, 255, 0.08);
            --teks-main: #f1f5f9;
            --teks-muted: #94a3b8;
            --card-bg: rgba(15, 23, 42, 0.85);
            --latar-gradient: radial-gradient(circle at 50% 50%, #0f172a 0%, #020617 100%);
            --danger: #ef4444;
        }

        [data-theme="light"] {
            --bg-body: #f8fafc;
            --kaca: rgba(15, 23, 42, 0.04);
            --garis: rgba(15, 23, 42, 0.08);
            --teks-main: #0f172a;
            --teks-muted: #64748b;
            --card-bg: rgba(255, 255, 255, 0.95);
            --latar-gradient: radial-gradient(circle at 50% 50%, #f1f5f9 0%, #f8fafc 100%);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--teks-main);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            overflow-x: hidden; padding: 40px 20px; margin: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .latar-animasi {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            z-index: -2; background: var(--latar-gradient);
        }

        .partikel {
            position: absolute; background: var(--emerald); border-radius: 50%; opacity: 0;
            animation: terbang linear infinite; filter: blur(1px);
        }
        @keyframes terbang {
            0% { transform: translateY(105vh) scale(0.5); opacity: 0; }
            20% { opacity: 0.3; }
            100% { transform: translateY(-10vh) scale(1.2); opacity: 0; }
        }

        .form-wrapper { width: 100%; max-width: 680px; position: relative; z-index: 1; }
        
        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(30px);
            border: 1px solid var(--garis);
            border-radius: 40px;
            overflow: hidden;
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.3);
        }

        .card-header-luxe { padding: 40px 40px 10px; text-align: left; }
        .card-header-luxe h2 { 
            font-weight: 800; font-size: 1.8rem; letter-spacing: -1px;
            background: var(--gradasi);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .card-body-luxe { padding: 20px 40px 40px; }

        .section-tag {
            font-size: 0.65rem; font-weight: 800; color: var(--emerald);
            letter-spacing: 2px; text-transform: uppercase;
            margin: 25px 0 15px; display: flex; align-items: center; gap: 10px;
        }
        .section-tag::after { content: ""; height: 1px; flex-grow: 1; background: var(--garis); }

        .field-group { margin-bottom: 20px; }
        .field-group label { 
            display: block; font-size: 0.75rem; font-weight: 700; 
            color: var(--teks-muted); margin-bottom: 10px; margin-left: 5px;
        }

        .error-msg {
            color: var(--danger); font-size: 0.65rem; font-weight: 600;
            margin-top: 6px; margin-left: 5px; display: block;
        }

        .custom-input {
            width: 100%; background: var(--kaca); border: 1px solid var(--garis);
            border-radius: 18px; padding: 14px 20px; color: var(--teks-main);
            font-size: 0.95rem; transition: all 0.3s ease;
        }
        .custom-input.is-invalid { border-color: var(--danger); background: rgba(239, 68, 68, 0.05); }
        .custom-input:focus { outline: none; border-color: var(--emerald); background: rgba(16, 185, 129, 0.05); box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); }

        .readonly-mode { background: rgba(0,0,0,0.03) !important; color: var(--teks-muted) !important; cursor: not-allowed; border-style: dashed; }

        .search-container { position: relative; margin-bottom: 20px; }
        .search-container i { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: var(--emerald); font-size: 1.1rem; }
        .search-container .custom-input { padding-left: 50px; border-radius: 20px; background: rgba(0,0,0,0.1); }

        .book-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 20px; max-height: 350px; overflow-y: auto;
            padding: 15px; background: rgba(0,0,0,0.15); border-radius: 24px;
            border: 1px solid var(--garis); margin-bottom: 10px;
        }

        /* Responsive Grid Fix */
        @media (max-width: 576px) {
            .book-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; padding: 10px; }
            .card-header-luxe, .card-body-luxe { padding-left: 20px; padding-right: 20px; }
            .card-header-luxe h2 { font-size: 1.5rem; }
        }
        
        .book-item {
            background: var(--kaca); border: 2px solid transparent;
            border-radius: 20px; padding: 12px; cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); text-align: center; position: relative;
        }
        .book-item:hover { background: rgba(255, 255, 255, 0.05); transform: translateY(-5px); }
        .book-item.selected { 
            border-color: var(--emerald); 
            background: rgba(16, 185, 129, 0.1);
            box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.2);
        }
        .book-item.selected::before {
            content: "\F272"; font-family: "bootstrap-icons";
            position: absolute; top: 10px; right: 10px; z-index: 2;
            background: var(--emerald); color: white; width: 24px; height: 24px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; border: 2px solid var(--card-bg);
        }

        .book-cover { width: 100%; aspect-ratio: 3/4; object-fit: cover; border-radius: 14px; margin-bottom: 12px; }
        .book-title { 
            font-size: 0.75rem; font-weight: 700; color: var(--teks-main);
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
            line-clamp: 2; overflow: hidden; line-height: 1.3;
        }

        .btn-gradasi {
            background: var(--gradasi); color: white; border: none; width: 100%;
            padding: 16px; border-radius: 20px; font-weight: 800; font-size: 1rem;
            letter-spacing: 1px; transition: all 0.4s; margin-top: 20px; cursor: pointer;
            box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.3);
        }
        .btn-gradasi:hover { transform: translateY(-4px); box-shadow: 0 20px 30px -10px rgba(16, 185, 129, 0.5); }

        .btn-batal {
            display: block; text-align: center; color: var(--teks-muted);
            text-decoration: none; font-size: 0.85rem; font-weight: 700;
            margin-top: 20px; transition: 0.3s;
        }
        .btn-batal:hover { color: var(--emerald); }

        .book-grid::-webkit-scrollbar { width: 5px; }
        .book-grid::-webkit-scrollbar-thumb { background: var(--garis); border-radius: 10px; }
    </style>
</head>
<body>

    <div class="latar-animasi" id="particles-container"></div>

    <div class="form-wrapper">
        <div class="glass-card">
            <header class="card-header-luxe">
                <h2><i class="bi bi-journal-plus me-2"></i>Pinjam Buku</h2>
                <p style="color: var(--teks-muted); font-size: 0.85rem; margin: 5px 0 0 5px;">Silahkan lengkapi formulir di bawah ini</p>
            </header>

            <div class="card-body-luxe">
                <form action="{{ route('pinjam.store') }}" method="POST">
                    @csrf
                    
                    <div class="section-tag">1. Identitas Anggota</div>
                    <div class="field-group">
                        <label>Nama Peminjam</label>
                        <input type="text" class="custom-input readonly-mode" value="{{ auth()->user()->nama }}" readonly>
                    </div>

                    <div class="section-tag">2. Pilih Koleksi Buku</div>
                    <div class="search-container">
                        <i class="bi bi-search"></i>
                        <input type="text" id="searchBuku" class="custom-input" placeholder="Cari judul buku yang ingin dipinjam...">
                    </div>

                    <div class="book-grid" id="bookGrid">
                        @foreach($bukus as $b)
                        <div class="book-item {{ (request('buku_id') == $b->id || old('buku_id') == $b->id) ? 'selected' : '' }}" 
                             data-id="{{ $b->id }}" 
                             data-title="{{ strtolower($b->judul) }}">
                            
                            @php
                                $pathCover = $b->cover;
                                if ($pathCover && !str_contains($pathCover, 'covers/')) {
                                    $pathCover = 'covers/' . $pathCover;
                                }
                            @endphp
                            
                            <img src="{{ $b->cover ? asset('storage/' . $pathCover) : 'https://via.placeholder.com/150x200?text=NO+COVER' }}" 
                                 class="book-cover" alt="{{ $b->judul }}">
                            <div class="book-title">{{ $b->judul }}</div>
                        </div>
                        @endforeach
                    </div>
                    
                    <input type="hidden" name="buku_id" id="selected_buku_id" value="{{ old('buku_id', request('buku_id')) }}">
                    @error('buku_id')
                        <span class="error-msg"><i class="bi bi-exclamation-circle me-1"></i>Pilih minimal satu buku</span>
                    @enderror

                    <div class="section-tag">3. Penjadwalan</div>
                    <div class="row g-3">
                        <div class="col-md-6 field-group">
                            <label>Tanggal Pinjam</label>
                            <input type="date" name="tgl_pinjam" id="tgl_pinjam" 
                                   class="custom-input @error('tgl_pinjam') is-invalid @enderror" 
                                   value="{{ old('tgl_pinjam', date('Y-m-d')) }}" 
                                   required onchange="calculateReturnDate()">
                            @error('tgl_pinjam')
                                <span class="error-msg"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 field-group">
                            <label>Estimasi Pengembalian (7 Hari)</label>
                            <input type="date" id="tgl_kembali" class="custom-input readonly-mode" readonly>
                        </div>
                    </div>

                    <button type="submit" class="btn-gradasi">
                        <i class="bi bi-check-circle-fill me-2"></i>KONFIRMASI PINJAMAN
                    </button>
                    <a href="{{ route('pinjam') }}" class="btn-batal">Kembali ke List</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        // --- SEARCH & SELECTION ---
        const searchInput = document.getElementById('searchBuku');
        const bookItems = document.querySelectorAll('.book-item');
        const hiddenInput = document.getElementById('selected_buku_id');

        searchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            bookItems.forEach(item => {
                const title = item.getAttribute('data-title');
                item.style.display = title.includes(filter) ? 'block' : 'none';
            });
        });

        bookItems.forEach(item => {
            item.addEventListener('click', function() {
                bookItems.forEach(i => i.classList.remove('selected'));
                this.classList.add('selected');
                hiddenInput.value = this.getAttribute('data-id');
            });
        });

        // --- TANGGAL LOGIC ---
        function calculateReturnDate() {
            const pinjamInput = document.getElementById('tgl_pinjam');
            const kembaliInput = document.getElementById('tgl_kembali');
            if (pinjamInput.value) {
                let date = new window.Date(pinjamInput.value);
                date.setDate(date.getDate() + 7);
                kembaliInput.value = date.toISOString().split('T')[0];
            }
        }

        // --- ANIMASI PARTIKEL ---
        const container = document.getElementById('particles-container');
        for (let i = 0; i < 15; i++) {
            const p = document.createElement('div');
            p.className = 'partikel';
            p.style.left = Math.random() * 100 + 'vw';
            const size = Math.random() * 3 + 2 + 'px';
            p.style.width = size; p.style.height = size;
            p.style.animationDuration = Math.random() * 8 + 8 + 's';
            p.style.animationDelay = Math.random() * 5 + 's';
            container.appendChild(p);
        }

        window.onload = () => { calculateReturnDate(); };
    </script>
</body>
</html>