<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>SIPUS SMEKDA || Homepage</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('duralux/assets/images/logo/logo open book perpus.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --bg-body: #020617;
            --bg-nav: rgba(2, 6, 23, 0.95);
            --teks-utama: #ffffff !important;
            --teks-muted: #cbd5e1 !important;
            --kaca: rgba(255, 255, 255, 0.05);
            --garis: rgba(255, 255, 255, 0.1);
            --emerald: #10b981;
            --ocean: #0ea5e9;
            --gradasi: linear-gradient(135deg, #10b981 0%, #0ea5e9 100%);
            --btn-theme: #ffffff;
        }

        [data-theme="light"] {
            --bg-body: #f8fafc;
            --bg-nav: rgba(248, 250, 252, 0.95);
            --teks-utama: #0f172a !important;
            --teks-muted: #475569 !important;
            --kaca: rgba(15, 23, 42, 0.05);
            --garis: rgba(15, 23, 42, 0.1);
            --btn-theme: #0f172a;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--teks-utama);
            transition: all 0.4s ease;
        }

        h1, h2, h3, h4, h5, h6, .logo-smekda, .btn-mewah, .footer-title { color: var(--teks-utama) !important; }
        p, .small, .text-muted, label { color: var(--teks-muted) !important; }

        .latar-animasi { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; }

        .nav-utama {
            position: fixed; top: 0; width: 100%; height: 90px;
            background: var(--bg-nav); backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--garis);
            padding: 0 6%; display: flex; align-items: center; justify-content: space-between; 
            z-index: 1040; 
        }
        .logo-smekda { font-weight: 800; font-size: 1.6rem; text-decoration: none; }
        .logo-smekda span { color: var(--emerald); }

        .menu-nav a {
            text-decoration: none; font-weight: 600; font-size: 0.9rem;
            margin-right: 30px; transition: 0.3s; position: relative;
            color: var(--teks-muted) !important;
        }
        
        .menu-nav a.active { color: var(--teks-utama) !important; }
        .menu-nav a.active::after {
            content: ''; position: absolute; bottom: -8px; left: 0;
            width: 100%; height: 2px; background: var(--gradasi);
            border-radius: 10px;
        }

        .grid-buku {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .kartu-buku {
            background: var(--kaca);
            border: 1px solid var(--garis);
            border-radius: 20px;
            padding: 15px;
            transition: all 0.3s ease;
            cursor: pointer;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .kartu-buku:hover {
            transform: translateY(-10px);
            border-color: var(--emerald);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.1);
        }

        .sampul {
            position: relative;
            width: 100%;
            aspect-ratio: 3/4;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 15px;
        }

        .sampul img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s;
        }

        .kartu-buku:hover .sampul img {
            transform: scale(1.1);
        }

        .status-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 0.65rem;
            padding: 5px 12px;
            border-radius: 50px;
            font-weight: 700;
            z-index: 2;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .text-emerald {
            color: var(--emerald) !important;
        }

        .modal {
            z-index: 2100; 
        }
        .modal-dialog {
            margin-top: 110px;
        }
        .modal-content {
            background: var(--bg-body) !important;
            border: 1px solid var(--garis) !important;
            border-radius: 28px !important;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        #theme-toggle { color: var(--btn-theme) !important; font-size: 1.2rem; cursor: pointer; transition: 0.3s; }

        .hero-section { min-height: 100vh; display: flex; align-items: center; padding: 120px 6% 60px; position: relative; overflow: hidden; }
        .hero-img-perpus {
            position: absolute; right: 0; top: 0; width: 60%; height: 100%;
            background: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2000') center/cover;
            mask-image: linear-gradient(to left, black 30%, transparent 100%);
            -webkit-mask-image: linear-gradient(to left, black 30%, transparent 100%);
            opacity: 0.3; z-index: 1;
        }
        .hero-teks { position: relative; z-index: 10; width: 60%; }
        .hero-teks h1 { font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 800; line-height: 1.1; margin-bottom: 25px; }
        .hero-teks h1 span { background: var(--gradasi); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; }

        .search-box {
            background: var(--kaca); border: 1px solid var(--garis);
            border-radius: 18px; padding: 8px 8px 8px 20px;
            display: flex; align-items: center; max-width: 500px;
        }
        .search-box input { background: transparent; border: none; color: var(--teks-utama); width: 100%; outline: none; }

        .btn-mewah {
            background: var(--gradasi); padding: 12px 30px; border-radius: 12px;
            text-decoration: none; font-weight: 700; border: none; transition: 0.3s;
            display: inline-block;
        }

        .step-card, .info-box, .stat-item {
            background: var(--kaca); border: 1px solid var(--garis);
            border-radius: 24px; padding: 25px; transition: 0.3s;
        }

        .footer-section { border-top: 1px solid var(--garis); padding: 80px 6% 40px; margin-top: 100px; background: var(--bg-body); }
        .footer-links { list-style: none; padding: 0; }
        .footer-links a { text-decoration: none; color: var(--teks-muted) !important; transition: 0.3s; display: block; margin-bottom: 12px; }

        .fab-whatsapp { position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px; background: #25d366; color: white !important; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; z-index: 1000; }

        @media (max-width: 991px) {
            .hero-teks { width: 100%; text-align: center; }
            .menu-nav { display: none; }
            .modal-dialog { margin-top: 20px; } 
        }
    </style>
</head>
<body>

    <div class="latar-animasi"></div>
    <a href="https://wa.me/628123456789" class="fab-whatsapp" target="_blank"><i class="bi bi-whatsapp"></i></a>

    <nav class="nav-utama">
        <a href="#" class="logo-smekda">SIPUS<span>SMEKDA</span></a>
        
        <div class="menu-nav d-none d-lg-flex" id="nav-container">
            <a href="#beranda" class="nav-link-custom">Beranda</a>
            <a href="#katalog" class="nav-link-custom">Koleksi</a>
            <a href="#alur" class="nav-link-custom">Alur</a>
            <a href="#lokasi" class="nav-link-custom">Lokasi</a>
            <a href="#bantuan" class="nav-link-custom">Bantuan</a>
        </div>

        <div class="nav-controls d-flex align-items-center gap-3">
            <button id="theme-toggle" class="btn"><i class="bi bi-moon-stars-fill" id="theme-icon"></i></button>
            <div class="d-none d-lg-flex align-items-center gap-3">
                @auth 
                    <a href="{{ route('dashboard') }}" class="btn fw-bold" style="color: var(--teks-utama) !important;">Dashboard</a>
                @else 
                    <a href="{{ route('login') }}" class="btn fw-bold" style="color: var(--teks-utama) !important;">Login</a>
                    <a href="{{ route('register') }}" class="btn-mewah">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <section id="beranda" class="hero-section">
        <div class="hero-img-perpus"></div>
        <div class="hero-teks">
            <p style="color: var(--emerald); font-weight: 800; letter-spacing: 4px; font-size: 0.75rem;">DIGITAL LIBRARY ECOSYSTEM</p>
            <h1>Literasi Tanpa <br><span>Sekat.</span></h1>
            <p class="fs-5 mb-4">Akses koleksi buku SMKN 2 secara digital dengan standar teknologi masa depan.</p>
            <form action="{{ route('login') }}" method="GET" class="search-box">
                <i class="bi bi-search me-3" style="color: var(--emerald);"></i>
                <input type="text" name="search" placeholder="Cari judul buku...">
                <button type="submit" class="btn-mewah ms-2">Cari</button>
            </form>
        </div>
    </section>

    <section style="padding: 0 6% 80px;">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3"><div class="stat-item"><div style="font-size: 2rem; font-weight: 800; color: var(--emerald);">12K+</div><p class="small mb-0">Koleksi</p></div></div>
            <div class="col-6 col-md-3"><div class="stat-item"><div style="font-size: 2rem; font-weight: 800; color: var(--emerald);">3K+</div><p class="small mb-0">Siswa</p></div></div>
            <div class="col-6 col-md-3"><div class="stat-item"><div style="font-size: 2rem; font-weight: 800; color: var(--emerald);">450</div><p class="small mb-0">E-Book</p></div></div>
            <div class="col-6 col-md-3"><div class="stat-item"><div style="font-size: 2rem; font-weight: 800; color: var(--emerald);">24/7</div><p class="small mb-0">Akses</p></div></div>
        </div>
    </section>

    <section id="katalog" style="padding: 80px 6% 0;">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-800 mb-1">Koleksi Unggulan</h2>
                <p class="text-muted">Jelajahi buku-buku terpopuler di SMEKDA</p>
            </div>
            <a href="{{ route('login') }}" class="text-emerald text-decoration-none fw-bold">
                Lihat Semua <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>

        <div class="grid-buku">
            @forelse($semua_buku as $buku)
                <div class="kartu-buku" data-bs-toggle="modal" data-bs-target="#modalBuku{{ $buku->id }}">
                    <div class="sampul">
                        <img src="{{ $buku->cover ? asset('storage/covers/' . $buku->cover) : 'https://ui-avatars.com/api/?name='.urlencode($buku->judul).'&background=10b981&color=fff' }}" alt="{{ $buku->judul }}">
                        <div class="status-badge {{ $buku->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                            {{ $buku->stok > 0 ? 'Tersedia' : 'Habis' }}
                        </div>
                    </div>
                    <div class="konten-kartu">
                        <h6 class="fw-bold mb-1 text-truncate" title="{{ $buku->judul }}">{{ $buku->judul }}</h6>
                        <p class="small mb-0 text-muted text-truncate">{{ $buku->penulis }}</p>
                    </div>
                </div>

                <div class="modal fade" id="modalBuku{{ $buku->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-body p-4 p-md-5">
                                <div class="row g-4">
                                    <div class="col-md-5">
                                        <img src="{{ $buku->cover ? asset('storage/covers/' . $buku->cover) : 'https://ui-avatars.com/api/?name='.urlencode($buku->judul).'&background=10b981&color=fff' }}" 
                                             class="w-100 rounded-4 shadow-lg" alt="{{ $buku->judul }}">
                                    </div>
                                    <div class="col-md-7">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <span class="badge bg-success mb-2 px-3 py-2 rounded-pill" style="background: var(--gradasi) !important;">
                                                {{ $buku->kategori }}
                                            </span>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" 
                                                    style="filter: var(--theme-toggle-filter, invert(1));"></button>
                                        </div>
                                        
                                        <h2 class="fw-800 mb-2 mt-2">{{ $buku->judul }}</h2>
                                        <p class="text-emerald fw-bold mb-3"><i class="bi bi-person-fill me-2"></i>{{ $buku->penulis }}</p>
                                        
                                        <div class="info-tambahan d-flex gap-3 mb-4">
                                            <div class="small"><i class="bi bi-box-seam me-1"></i> Stok: <b>{{ $buku->stok }}</b></div>
                                            <div class="small"><i class="bi bi-bookmark-star me-1"></i> Favorit</div>
                                        </div>

                                        <h6 class="fw-bold mb-2">Sinopsis</h6>
                                        <p class="small text-muted lh-lg mb-4">
                                            {{ $buku->sinopsis ?? 'Sinopsis untuk buku ini belum tersedia dalam database kami.' }}
                                        </p>
                                        
                                        <div class="d-grid">
                                            <a href="{{ route('pinjam.form', ['buku_id' => $buku->id]) }}" 
                                               class="btn-mewah text-center {{ $buku->stok <= 0 ? 'disabled opacity-50' : '' }}">
                                                <i class="bi bi-journal-plus me-2"></i>
                                                {{ $buku->stok > 0 ? 'PINJAM SEKARANG' : 'STOK HABIS' }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <i class="bi bi-book text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">Belum ada koleksi buku yang tersedia.</p>
                </div>
            @endforelse
        </div>
    </section>

    <section id="alur" style="padding: 100px 6% 0;">
        <div class="text-center mb-5">
            <h2 class="fw-800">Alur Peminjaman</h2>
            <p>Ikuti langkah berikut untuk meminjam buku</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4 col-lg"><div class="step-card"><div style="width: 45px; height: 45px; background: var(--gradasi); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 800; margin-bottom: 15px; color: white;">1</div><h6 class="fw-bold">Registrasi</h6><p class="small">Daftar akun anggota.</p></div></div>
            <div class="col-md-4 col-lg"><div class="step-card"><div style="width: 45px; height: 45px; background: var(--gradasi); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 800; margin-bottom: 15px; color: white;">2</div><h6 class="fw-bold">Pilih Buku</h6><p class="small">Cari buku di katalog.</p></div></div>
            <div class="col-md-4 col-lg"><div class="step-card"><div style="width: 45px; height: 45px; background: var(--gradasi); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 800; margin-bottom: 15px; color: white;">3</div><h6 class="fw-bold">Isi Form</h6><p class="small">Ajukan peminjaman.</p></div></div>
            <div class="col-md-6 col-lg"><div class="step-card"><div style="width: 45px; height: 45px; background: var(--gradasi); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 800; margin-bottom: 15px; color: white;">4</div><h6 class="fw-bold">Verifikasi</h6><p class="small">Tunggu persetujuan.</p></div></div>
            <div class="col-md-6 col-lg"><div class="step-card"><div style="width: 45px; height: 45px; background: var(--gradasi); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 800; margin-bottom: 15px; color: white;">5</div><h6 class="fw-bold">Ambil</h6><p class="small">Ambil fisik di sekolah.</p></div></div>
        </div>
    </section>

    <section id="lokasi" style="padding: 100px 6% 0;">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="info-box">
                    <h2 class="fw-800 mb-3">Ayo Visit!</h2>
                    <p class="mb-4">Baca langsung di perpustakaan fisik SMKN 2 Purwakarta.</p>
                    <label class="fw-bold text-emerald d-block mt-3">ALAMAT</label>
                    <p class="small">Jl. Jend. Ahmad Yani No.98, Nagri Tengah, Kec. Purwakarta, Kabupaten Purwakarta, Jawa Barat 41114</p>
                    <label class="fw-bold text-emerald d-block mt-3">JAM OPERASIONAL</label>
                    <p class="small mb-0">Senin - Kamis: 07.30 - 15.30 WIB</p>
                    <p class="small">Jumat: 07.30 - 14.00 WIB</p>
                    <a href="https://maps.app.goo.gl/MVTXDCzovx4JkZEF6" target="_blank" class="btn-mewah w-100 text-center mt-3">Lihat Google Maps</a>
                </div>
            </div>
            <div class="col-lg-8">
                <div style="border-radius: 24px; overflow: hidden; height: 450px; border: 1px solid var(--garis);">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.7967077208205!2d107.4397485084474!3d-6.547333993418279!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e690e5975014a5d%3A0x87f7a97e7f9f961!2sSMKN%202%20Purwakarta!5e0!3m2!1sid!2sid!4v1776572592592!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>

    <footer id="bantuan" class="footer-section">
        <div class="row g-5">
            <div class="col-lg-5">
                <h3 class="logo-smekda mb-3">SIPUS<span>SMEKDA</span></h3>
                <p class="small">Portal perpustakaan digital resmi SMKN 2 Purwakarta.</p>
            </div>
            <div class="col-lg-3 col-6">
                <h6 class="fw-bold mb-4 footer-title">Navigasi Cepat</h6>
                <ul class="footer-links">
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#katalog">Koleksi</a></li>
                    <li><a href="#alur">Alur Peminjaman</a></li>
                    <li><a href="#lokasi">Lokasi</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-6">
                <h6 class="fw-bold mb-4 footer-title">Kontak Kami</h6>
                <p class="small"><i class="bi bi-geo-alt me-2 text-emerald"></i> Purwakarta, Jawa Barat</p>
                <p class="small"><i class="bi bi-envelope me-2 text-emerald"></i> perpus@smkn2pwk.sch.id</p>
            </div>
        </div>
        <div class="text-center mt-5 pt-4" style="border-top: 1px solid var(--garis);">
            <p class="small mb-0">© 2026 SIPUS SMEKDA. Developed by Team RPL.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;
        const themeIcon = document.getElementById('theme-icon');

        themeToggle.addEventListener('click', () => {
            const isDark = html.getAttribute('data-theme') === 'dark';
            const newTheme = isDark ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            themeIcon.className = isDark ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
            localStorage.setItem('theme', newTheme);
        });

        // SCROLL SPY - Auto Highlight Navlink
        const sections = document.querySelectorAll("section[id]");
        const navLinks = document.querySelectorAll(".nav-link-custom");

        window.addEventListener("scroll", () => {
            let current = "";
            sections.forEach((section) => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= sectionTop - 150) {
                    current = section.getAttribute("id");
                }
            });

            navLinks.forEach((link) => {
                link.classList.remove("active");
                if (link.getAttribute("href").includes(current)) {
                    link.classList.add("active");
                }
            });
        });
    </script>
</body>
</html>