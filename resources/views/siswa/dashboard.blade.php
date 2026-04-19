<!DOCTYPE html>
<html lang="id" data-theme="{{ auth()->user()->theme ?? 'dark' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIPUS SMEKDA | Student Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('duralux/assets/images/logo/logo open book perpus.png') }}" />

    <style>
        :root {
            --bg-body: #020617;
            --emerald: #10b981;
            --ocean: #0ea5e9;
            --gradasi: linear-gradient(135deg, #10b981 0%, #0ea5e9 100%);
            --kaca: rgba(255, 255, 255, 0.03);
            --garis: rgba(255, 255, 255, 0.08);
            --teks-utama: #f1f5f9;
            --teks-muted: #94a3b8;
            --nav-bg: rgba(2, 6, 23, 0.8);
            --danger: #ef4444;
        }

        [data-theme="light"] {
            --bg-body: #f8fafc;
            --kaca: rgba(15, 23, 42, 0.03);
            --garis: rgba(15, 23, 42, 0.08);
            --teks-utama: #0f172a;
            --teks-muted: #64748b;
            --nav-bg: rgba(248, 250, 252, 0.8);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--teks-utama);
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .notif-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-width: 350px;
        }

        .floating-notif {
            background: var(--nav-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--garis);
            border-radius: 20px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            animation: slideInNotif 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes slideInNotif {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .icon-box {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notif-warning { border-left: 4px solid var(--emerald); }
        .notif-warning .icon-box { background: rgba(16, 185, 129, 0.1); color: var(--emerald); }
        
        .notif-danger { border-left: 4px solid var(--danger); }
        .notif-danger .icon-box { background: rgba(239, 68, 68, 0.1); color: var(--danger); }

        /* --- LATAR BELAKANG GERAK --- */
        .latar-animasi {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            background: radial-gradient(circle at 50% 50%, var(--kaca) 0%, var(--bg-body) 100%);
        }

        .partikel {
            position: absolute; background: var(--emerald);
            border-radius: 2px; opacity: 0.2;
            animation: terbang 20s infinite linear;
        }

        @keyframes terbang {
            from { transform: translateY(100vh) rotate(0deg); opacity: 0.2; }
            to { transform: translateY(-10vh) rotate(360deg); opacity: 0; }
        }

        /* --- NAVBAR --- */
        .nav-utama {
            position: fixed; top: 0; width: 100%; height: 90px;
            background: var(--nav-bg); backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--garis);
            padding: 0 6%; display: flex; align-items: center; justify-content: space-between;
            z-index: 1050;
        }

        .logo-smekda { font-weight: 800; font-size: 1.6rem; color: var(--teks-utama); text-decoration: none; letter-spacing: -1px; }
        .logo-smekda span { color: var(--emerald); }

        .menu-nav a {
            color: var(--teks-muted); text-decoration: none; font-weight: 600; font-size: 0.9rem;
            margin-right: 30px; transition: 0.3s; position: relative; padding-bottom: 8px;
        }

        .menu-nav a:hover { color: var(--teks-utama); }
        .menu-nav a.active { color: var(--emerald) !important; }
        .menu-nav a.active::after {
            content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 3px;
            background: var(--gradasi); border-radius: 10px;
        }

        .theme-toggle {
            background: var(--kaca); border: 1px solid var(--garis); color: var(--teks-utama);
            width: 40px; height: 40px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: 0.3s; margin-right: 15px;
        }

        .theme-toggle:hover { background: var(--emerald); color: white; transform: rotate(15deg); }

        .user-profile-trigger {
            padding: 5px 8px; border-radius: 50px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .user-profile-trigger:hover { background: var(--kaca); }

        .avatar-wrapper {
            position: relative; padding: 2px; background: var(--gradasi);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            transition: transform 0.3s ease;
        }

        .user-profile-trigger:hover .avatar-wrapper { transform: scale(1.05) rotate(5deg); }

        .dropdown-menu-premium {
            background: var(--bg-body) !important; backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid var(--garis) !important; border-radius: 20px !important;
            padding: 10px !important; min-width: 220px !important; margin-top: 15px !important;
            animation: dropdownSlide 0.3s ease-out;
        }

        @keyframes dropdownSlide {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dropdown-item-premium {
            border-radius: 12px !important; padding: 10px 15px !important;
            color: var(--teks-utama) !important; font-size: 0.85rem; font-weight: 600;
            transition: all 0.2s; display: flex; align-items: center; gap: 10px;
        }

        .dropdown-item-premium:hover {
            background: var(--kaca) !important; color: var(--emerald) !important; transform: translateX(5px);
        }

        .dropdown-item-premium.logout:hover {
            background: rgba(239, 68, 68, 0.1) !important; color: #ef4444 !important;
        }

        .hero-section {
            min-height: 100vh; display: flex; align-items: center; padding: 120px 6% 60px;
            position: relative;
        }

        .hero-img-perpus {
            position: absolute; right: 0; top: 0; width: 55%; height: 100%;
            background: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2000') center/cover;
            mask-image: linear-gradient(to left, black 30%, transparent 100%);
            opacity: 0.25; z-index: 1; animation: zoomSoft 20s infinite alternate ease-in-out;
        }

        @keyframes zoomSoft { from { transform: scale(1); } to { transform: scale(1.1); } }

        .hero-teks { position: relative; z-index: 10; width: 60%; }
        .hero-teks h1 { font-size: clamp(2rem, 5vw, 4rem); font-weight: 700; line-height: 1.1; margin-bottom: 25px; color: var(--teks-utama); }
        .hero-teks h1 span { 
            background: var(--gradasi); 
            -webkit-background-clip: text;
            background-clip: text;       
            -webkit-text-fill-color: transparent; 
        }
        .btn-beam-wrapper {
            position: relative; padding: 2px; border-radius: 16px; overflow: hidden;
            display: inline-block; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-beam-wrapper::before {
            content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
            background: conic-gradient(transparent, rgba(16, 185, 129, 0.3), var(--emerald), var(--ocean), rgba(14, 165, 233, 0.3), transparent);
            animation: rotate-beam 4s linear infinite;
        }

        @keyframes rotate-beam { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        .btn-mewah-inner, .btn-outline-inner {
            position: relative; padding: 16px 35px; border-radius: 14px; text-decoration: none;
            font-weight: 800; display: inline-block; z-index: 1; border: none; transition: 0.3s;
            font-size: 0.85rem; letter-spacing: 1px; text-transform: uppercase;
        }

        .btn-mewah-inner { background: var(--gradasi); color: white !important; }
        .btn-outline-inner { background: var(--bg-body); color: var(--teks-utama); }

        /* --- SEARCH & FILTER SECTION --- */
        .search-container {
            background: var(--kaca);
            border: 1px solid var(--garis);
            border-radius: 25px;
            padding: 10px 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
            transition: 0.3s;
        }

        .search-container:focus-within {
            border-color: var(--emerald);
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.1);
        }

        .search-input {
            background: transparent;
            border: none;
            color: var(--teks-utama);
            width: 100%;
            padding: 10px 0;
            outline: none;
            font-weight: 600;
        }

        .category-scroll {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            padding-bottom: 10px;
            scrollbar-width: none; /* Firefox */
        }

        .category-scroll::-webkit-scrollbar { display: none; } /* Chrome/Safari */

        .cat-pill {
            padding: 8px 22px;
            background: var(--kaca);
            border: 1px solid var(--garis);
            border-radius: 50px;
            color: var(--teks-muted);
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            white-space: nowrap;
        }

        .cat-pill:hover, .cat-pill.active {
            background: var(--emerald);
            color: white;
            border-color: var(--emerald);
        }

        /* --- CATALOG --- */
        .grid-buku { display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: 30px; padding: 50px 6%; }
        .kartu-buku { text-decoration: none; color: var(--teks-utama); display: block; }
        .sampul {
            border-radius: 22px; overflow: hidden; aspect-ratio: 2/3; margin-bottom: 15px;
            border: 1px solid var(--garis); transition: 0.6s cubic-bezier(0.2, 1, 0.2, 1);
            position: relative;
        }
        .sampul img { width: 100%; height: 100%; object-fit: cover; }

        /* --- MODAL --- */
        .modal-content {
            background: var(--bg-body); backdrop-filter: blur(25px);
            border: 1px solid var(--garis); border-radius: 30px; color: var(--teks-utama);
        }

        .footer-final { background: var(--bg-body); border-top: 1px solid var(--garis); padding: 80px 6% 40px; }
    </style>
</head>

<body>
    <div id="particles-container" class="latar-animasi"></div>

    @php
        /* LOGIKA FOTO PROFIL */
        $avatarDefault = (auth()->user()->jenis_kelamin === 'Perempuan') 
                        ? 'duralux/assets/images/avatar/profilcewe.png' 
                        : 'duralux/assets/images/avatar/profilcowo.avif';

        try {
            $userProfile = \App\Models\Profile::where('user_id', auth()->id())->first();
        } catch (\Exception $e) {
            $userProfile = null;
        }

        if ($userProfile && $userProfile->profile_photo && file_exists(public_path('storage/profile_photos/' . $userProfile->profile_photo))) {
            $finalPhoto = asset('storage/profile_photos/' . $userProfile->profile_photo) . '?v=' . time();
        } else {
            $finalPhoto = asset($avatarDefault);
        }

        /* LOGIKA POPUP REMINDER (ANTI-ERROR) */
        $notifikasiData = [];
        
        $modelName = null;
        if (class_exists('App\Models\Peminjaman')) {
            $modelName = 'App\Models\Peminjaman';
        } elseif (class_exists('App\Models\Pinjam')) {
            $modelName = 'App\Models\Pinjam';
        } elseif (class_exists('App\Models\PeminjamanBuku')) {
            $modelName = 'App\Models\PeminjamanBuku';
        }

        if ($modelName) {
            try {
                $pinjamanAktif = $modelName::where('user_id', auth()->id())
                                ->where('status', 'Dipinjam')
                                ->with('buku')
                                ->get();
                
                foreach ($pinjamanAktif as $p) {
                    $tglKembali = \Carbon\Carbon::parse($p->tanggal_kembali);
                    $hariIni = \Carbon\Carbon::today();
                    $selisih = $hariIni->diffInDays($tglKembali, false);

                    if ($selisih < 0) {
                        $notifikasiData[] = [
                            'type' => 'danger', 
                            'msg' => "Buku '" . ($p->buku->judul ?? 'Buku') . "' sudah terlambat " . abs($selisih) . " hari!", 
                            'icon' => 'exclamation-octagon-fill'
                        ];
                    } elseif ($selisih >= 0 && $selisih <= 2) {
                        $notifikasiData[] = [
                            'type' => 'warning', 
                            'msg' => "Batas pengembalian '" . ($p->buku->judul ?? 'Buku') . "' tinggal $selisih hari lagi.", 
                            'icon' => 'clock-fill'
                        ];
                    }
                }
            } catch (\Exception $e) {
            }
        }
    @endphp

    <div class="notif-container">
        @foreach($notifikasiData as $notif)
        <div class="floating-notif notif-{{ $notif['type'] }}">
            <div class="icon-box">
                <i class="bi bi-{{ $notif['icon'] }} fs-4"></i>
            </div>
            <div>
                <p class="m-0 small fw-bold" style="color: var(--teks-utama);">{{ $notif['type'] == 'danger' ? 'Peringatan Terlambat' : 'Pengingat Batas' }}</p>
                <p class="m-0" style="color: var(--teks-muted); font-size: 0.75rem;">{{ $notif['msg'] }}</p>
            </div>
            <button type="button" class="btn-close ms-auto small" onclick="this.parentElement.remove()" style="scale: 0.7;"></button>
        </div>
        @endforeach
    </div>

    <nav class="nav-utama">
        <a href="#" class="logo-smekda">SIPUS<span>SMEKDA</span></a>
        
        <div class="menu-nav d-none d-lg-flex">
            <a href="#beranda" class="nav-link-custom">Beranda</a>
            <a href="#katalog" class="nav-link-custom">Koleksi</a>
        </div>

        <div class="d-flex align-items-center">
            <div class="theme-toggle" id="theme-toggle-btn">
                <i class="bi bi-{{ auth()->user()->theme == 'dark' ? 'sun' : 'moon' }}-fill fs-5"></i>
            </div>

            <div class="dropdown">
                <div class="d-flex align-items-center gap-3 user-profile-trigger" data-bs-toggle="dropdown" style="cursor: pointer;">
                    <div class="text-end d-none d-sm-block">
                        <p class="m-0 small fw-bold" style="color: var(--teks-utama);">{{ auth()->user()->nama }}</p>
                        <p class="m-0 small" style="color: var(--emerald); font-size: 0.65rem; font-weight: 800; text-transform: uppercase;">
                            <i class="bi bi-patch-check-fill me-1"></i>{{ auth()->user()->role }}
                        </p>
                    </div>
                    <div class="avatar-wrapper">
                        <img src="{{ $finalPhoto }}" class="rounded-circle" width="40" height="40" style="object-fit: cover; border: 2px solid var(--bg-body);">
                    </div>
                </div>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-premium shadow-lg">
                    <li>
                        <a class="dropdown-item dropdown-item-premium" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person-circle fs-5"></i> Profil Saya
                        </a>
                    </li>
                    
                    <li><hr class="dropdown-divider" style="border-color: var(--garis);"></li>
                    
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item dropdown-item-premium logout text-danger fw-bold w-100 border-0 bg-transparent">
                                <i class="bi bi-power fs-5"></i> Logout Aplikasi
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="beranda" class="hero-section">
        <div class="hero-img-perpus"></div>
        <div class="hero-teks">
            <p style="color: var(--emerald); font-weight: 800; letter-spacing: 4px; font-size: 0.75rem; margin-bottom: 20px;">WELCOME BACK, STUDENT</p>
            <h1>Halo, <span>{{ explode(' ', auth()->user()->nama)[0] }}!</span><br>Literasi Tanpa Sekat.</h1>
            <p style="color: var(--teks-muted); max-width: 550px; line-height: 1.7;" class="fs-5 mb-5">Temukan ribuan koleksi buku digital SMKN 2 dan pantau riwayat pinjamanmu dengan mudah.</p>

            <div class="d-flex flex-wrap gap-4">
                <div class="btn-beam-wrapper">
                    <a href="{{ route('pinjam') }}" class="btn-mewah-inner">
                        <i class="bi bi-journal-bookmark-fill me-2"></i> Pinjaman Saya
                    </a>
                </div>
                <div class="btn-beam-wrapper">
                    <a href="{{ route('pengembalian') }}" class="btn-outline-inner">
                        <i class="bi bi-arrow-left-right me-2"></i> Pengembalian
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="katalog" style="padding: 100px 6% 0;">
        <div class="row align-items-end mb-4">
            <div class="col-lg-6">
                <h2 class="fw-800" style="color: var(--teks-utama);">Koleksi Buku</h2>
                <p style="color: var(--teks-muted);">Jelajahi buku-buku terbaik di SMEKDA</p>
            </div>
            <div class="col-lg-6">
                <div class="search-container">
                    <i class="bi bi-search" style="color: var(--emerald);"></i>
                    <input type="text" id="searchInput" class="search-input" placeholder="Cari judul buku atau penulis...">
                </div>
            </div>
        </div>

        <div class="category-scroll mb-2">
            <div class="cat-pill active" data-category="all">Semua</div>
            <div class="cat-pill" data-category="novel">Novel</div>
            <div class="cat-pill" data-category="pelajaran">Pelajaran</div>
            <div class="cat-pill" data-category="biografi">Biografi</div>
            <div class="cat-pill" data-category="komik">Komik</div>
            <div class="cat-pill" data-category="teknologi">Teknologi</div>
            <div class="cat-pill" data-category="sejarah">Sejarah</div>
        </div>

        <div class="grid-buku" id="bookGrid">
            @foreach ($daftarBuku ?? [] as $item)
            <div class="book-card-wrapper" data-judul="{{ strtolower($item->judul) }}" data-penulis="{{ strtolower($item->penulis) }}" data-kategori="{{ strtolower($item->kategori ?? 'pelajaran') }}">
                <div class="book-card">
                    <a href="#" class="kartu-buku" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id }}">
                        <div class="sampul">
                            <img src="{{ $item->cover ? asset('storage/covers/' . $item->cover) : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500' }}">
                        </div>
                        <h6 class="fw-bold mb-1 text-truncate">{{ $item->judul }}</h6>
                        <p style="color: var(--teks-muted);" class="small">{{ $item->penulis }}</p>
                    </a>
                </div>
            </div>

            <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg">
                        <div class="modal-body p-0">
                            <div class="row g-0">
                                <div class="col-md-5 d-none d-md-block">
                                    <img src="{{ $item->cover ? asset('storage/covers/' . $item->cover) : 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500' }}" class="w-100 h-100" style="object-fit: cover; border-top-left-radius: 20px; border-bottom-left-radius: 20px;">
                                </div>
                                <div class="col-md-7 p-5">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h2 class="fw-800 m-0">{{ $item->judul }}</h2>
                                        <button type="button" class="btn-close {{ auth()->user()->theme == 'dark' ? 'btn-close-white' : '' }}" data-bs-dismiss="modal"></button>
                                    </div>
                                    <p class="fw-bold mb-4" style="color: var(--emerald);">Penulis: {{ $item->penulis }}</p>

                                    <div class="mb-4">
                                        <label class="small fw-bold text-uppercase mb-2 d-block" style="letter-spacing: 1px; color: var(--teks-muted);">Sinopsis</label>
                                        <div class="p-3" style="background: var(--kaca); border-radius: 15px; border: 1px solid var(--garis); max-height: 200px; overflow-y: auto;">
                                            <p class="small m-0 lh-lg" style="color: var(--teks-muted);">
                                                {{ $item->sinopsis ?? 'Belum ada sinopsis untuk buku ini.' }}
                                            </p>
                                        </div>
                                    </div>

                                    <a href="{{ route('pinjam.form', ['buku_id' => $item->id]) }}" class="btn-mewah-inner w-100 text-center py-3 d-block text-decoration-none">
                                        PINJAM SEKARANG
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div id="noBookMessage" class="text-center py-5 d-none">
            <i class="bi bi-search fs-1 mb-3 d-block" style="color: var(--teks-muted);"></i>
            <h5 style="color: var(--teks-utama);">Buku tidak ditemukan</h5>
            <p style="color: var(--teks-muted);">Coba cari dengan kata kunci lain atau kategori berbeda.</p>
        </div>
    </section>

    <footer class="footer-final">
        <hr class="mb-5" style="border-color: var(--garis);">
        <p class="small text-center" style="color: var(--teks-muted);">© 2026 SIPUS SMEKDA Digital System.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // --- LOGIKA FILTER PENCARIAN & KATEGORI (FITUR BARU) ---
        const searchInput = document.getElementById('searchInput');
        const catPills = document.querySelectorAll('.cat-pill');
        const bookCards = document.querySelectorAll('.book-card-wrapper');
        const noBookMsg = document.getElementById('noBookMessage');

        function filterBooks() {
            const searchTerm = searchInput.value.toLowerCase();
            const activeCat = document.querySelector('.cat-pill.active').getAttribute('data-category');
            let foundCount = 0;

            bookCards.forEach(card => {
                const title = card.getAttribute('data-judul');
                const author = card.getAttribute('data-penulis');
                const category = card.getAttribute('data-kategori');

                const matchesSearch = title.includes(searchTerm) || author.includes(searchTerm);
                const matchesCat = activeCat === 'all' || category === activeCat;

                if (matchesSearch && matchesCat) {
                    card.classList.remove('d-none');
                    foundCount++;
                } else {
                    card.classList.add('d-none');
                }
            });

            if (foundCount === 0) {
                noBookMsg.classList.remove('d-none');
            } else {
                noBookMsg.classList.add('d-none');
            }
        }

        searchInput.addEventListener('input', filterBooks);

        catPills.forEach(pill => {
            pill.addEventListener('click', () => {
                catPills.forEach(p => p.classList.remove('active'));
                pill.classList.add('active');
                filterBooks();
            });
        });

        // --- LOGIKA AUTO ACTIVE NAVLINK ---
        const sections = document.querySelectorAll("section");
        const navLinks = document.querySelectorAll(".nav-link-custom");

        window.onscroll = () => {
            let current = "";
            sections.forEach((section) => {
                const sectionTop = section.offsetTop;
                if (pageYOffset >= sectionTop - 120) {
                    current = section.getAttribute("id");
                }
            });

            navLinks.forEach((link) => {
                link.classList.remove("active");
                if (link.getAttribute("href").includes(current)) {
                    link.classList.add("active");
                }
            });
        };

        // --- THEME TOGGLE LOGIC ---
        const btn = document.getElementById('theme-toggle-btn');
        const html = document.documentElement;

        btn.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            btn.innerHTML = newTheme === 'dark' ? '<i class="bi bi-sun-fill fs-5"></i>' : '<i class="bi bi-moon-fill fs-5"></i>';

            fetch("{{ route('update.theme') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ theme: newTheme })
            });
        });

        // --- PARTIKEL & ANIMASI ---
        const container = document.getElementById('particles-container');
        for (let i = 0; i < 30; i++) {
            const p = document.createElement('div');
            p.className = 'partikel';
            p.style.left = Math.random() * 100 + 'vw';
            p.style.width = p.style.height = Math.random() * 5 + 2 + 'px';
            p.style.animationDuration = Math.random() * 10 + 10 + 's';
            container.appendChild(p);
        }

        const observer = new window.IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.kartu-buku').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(40px)';
            el.style.transition = 'all 0.8s ease-out';
            observer.observe(el);
        });
    </script>
</body>
</html>