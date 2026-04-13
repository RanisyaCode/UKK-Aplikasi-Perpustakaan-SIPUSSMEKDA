<!DOCTYPE html>
<html lang="id" data-theme="{{ auth()->user()->theme ?? 'dark' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SMEKDA Library | Terminal Peminjaman</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('duralux/assets/images/logo/logo open book perpus.png') }}" />

    <style>
        :root {
            --bg-deep: #030508;
            --accent-emerald: #10b981;
            --accent-blue: #3b82f6;
            --card-glass: rgba(13, 17, 23, 0.8);
            --border-white: rgba(255, 255, 255, 0.05);
            --text-silver: #cbd5e1;
            --text-main: #ffffff;
            --gradasi: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
            --panel-bg: rgba(11, 14, 20, 0.9);
            --seg-bg: #1a1f26;
            --latar-gradient: radial-gradient(circle at 50% 50%, #0f172a 0%, #020617 100%);
        }

        [data-theme="light"] {
            --bg-deep: #f8fafc;
            --card-glass: rgba(255, 255, 255, 0.9);
            --border-white: rgba(15, 23, 42, 0.08);
            --text-silver: #64748b;
            --text-main: #0f172a;
            --panel-bg: rgba(255, 255, 255, 0.95);
            --seg-bg: #e2e8f0;
            --latar-gradient: radial-gradient(circle at 50% 50%, #f1f5f9 0%, #f8fafc 100%);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-deep);
            background-image: radial-gradient(circle at 2px 2px, var(--border-white) 1px, transparent 0);
            background-size: 32px 32px;
            color: var(--text-main);
            margin: 0; 
            min-height: 100vh;
            display: flex; 
            align-items: center; 
            justify-content: center;
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .latar-animasi { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -2; background: var(--latar-gradient); }
        .partikel { position: absolute; background: var(--accent-emerald); border-radius: 50%; opacity: 0; animation: terbang linear infinite; filter: blur(1px); }
        @keyframes terbang { 0% { transform: translateY(105vh) scale(0.5); opacity: 0; } 50% { opacity: 0.3; } 100% { transform: translateY(-10vh) scale(1.2); opacity: 0; } }
        .ambient-glow { position: fixed; width: 60vw; height: 60vh; background: radial-gradient(circle, rgba(16, 185, 129, 0.05) 0%, transparent 70%); top: -10%; left: -10%; z-index: -1; pointer-events: none; }
        
        /* RESPONSIVE LAYOUT FIX */
        .container-main { 
            width: 100%; 
            max-width: 1200px; 
            padding: 2rem; 
            display: grid; 
            grid-template-columns: 1.3fr 1fr; 
            gap: 4rem; 
            position: relative; 
            z-index: 1; 
        }

        /* Perbaikan untuk layar Tablet/HP agar tidak kepotong */
        @media (max-width: 1100px) {
            .container-main { 
                grid-template-columns: 1fr; 
                gap: 2rem; 
                padding: 5rem 1.5rem;
                text-align: center;
            }
            .hero-content { display: flex; flex-direction: column; align-items: center; }
            .title-huge { font-size: 3.5rem !important; }
            .sub-description { margin-left: auto; margin-right: auto; }
            .control-panel { position: relative !important; top: 0 !important; }
        }

        @media (max-width: 576px) {
            .title-huge { font-size: 2.5rem !important; letter-spacing: -2px !important; }
            .container-main { padding: 4rem 1rem; }
            .control-panel { padding: 2rem !important; border-radius: 32px !important; }
            .chip-status { font-size: 0.6rem; padding: 0.4rem 0.8rem; }
        }
        
        .step-item { position: relative; margin-bottom: 1.5rem; padding-left: 2rem; text-align: left; }
        .step-item::before { content: ''; position: absolute; left: 0; top: 0.2rem; width: 12px; height: 12px; border-radius: 50%; background: var(--seg-bg); border: 2px solid var(--accent-emerald); }
        .step-item.active::before { background: var(--accent-emerald); box-shadow: 0 0 10px var(--accent-emerald); }
        .step-title { font-weight: 700; font-size: 0.9rem; color: var(--text-main); margin-bottom: 2px; }
        .step-desc { font-size: 0.75rem; color: var(--text-silver); }

        .chip-status { display: inline-flex; align-items: center; gap: 8px; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); padding: 0.5rem 1rem; border-radius: 12px; font-size: 0.7rem; font-weight: 800; color: var(--accent-emerald); letter-spacing: 2px; margin-bottom: 2rem; text-transform: uppercase; }
        
        .title-huge { 
            font-size: 5rem; 
            font-weight: 800; 
            line-height: 1.1; 
            letter-spacing: -4px; 
            margin-bottom: 1.5rem; 
            color: var(--text-main); 
            word-wrap: break-word; /* Mencegah teks keluar container */
        }
        .title-huge span { 
            background: var(--gradasi); 
            -webkit-background-clip: text; 
            background-clip: text;      
            -webkit-text-fill-color: transparent;
        }        
        .sub-description { font-size: 1.1rem; color: var(--text-silver); line-height: 1.7; max-width: 500px; margin-bottom: 3.5rem; }
        .book-card-mini { background: var(--card-glass); border: 1px solid var(--border-white); border-radius: 24px; padding: 1.5rem; backdrop-filter: blur(25px); position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.1); text-align: left; width: 100%; }
        .label-header { font-size: 0.75rem; font-weight: 800; color: #475569; letter-spacing: 2px; margin-bottom: 1.5rem; display: block; }
        .book-entry { display: flex; align-items: center; gap: 1rem; padding: 1rem; border-radius: 16px; background: rgba(255,255,255,0.02); border: 1px solid transparent; transition: 0.3s; margin-bottom: 0.75rem; }
        [data-theme="light"] .book-entry { background: rgba(15, 23, 42, 0.03); }
        .book-entry:hover { border-color: var(--accent-emerald); background: rgba(16, 185, 129, 0.05); transform: translateX(10px); }
        
        .control-panel { background: var(--panel-bg); border: 1px solid var(--border-white); border-radius: 48px; padding: 3.5rem; box-shadow: 0 40px 100px -20px rgba(0,0,0,0.2); position: sticky; top: 2rem; backdrop-filter: blur(20px); text-align: left; }
        
        .quota-monitor { margin-bottom: 3rem; }
        .monitor-label { display: flex; justify-content: space-between; margin-bottom: 1rem; font-weight: 700; font-size: 0.8rem; }
        .segments { display: flex; gap: 10px; }
        .seg { height: 12px; flex: 1; border-radius: 6px; background: var(--seg-bg); border: 1px solid rgba(255,255,255,0.03); }
        .seg.filled { background: var(--gradasi); box-shadow: 0 0 15px rgba(16, 185, 129, 0.3); }
        .btn-luxe { background: var(--text-main); color: var(--bg-deep); border: none; padding: 1.25rem; border-radius: 20px; font-weight: 800; display: flex; align-items: center; justify-content: center; gap: 0.75rem; transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1); width: 100%; text-decoration: none; }
        .btn-luxe:hover { background: var(--accent-emerald); color: #fff; transform: translateY(-5px); box-shadow: 0 15px 30px -10px rgba(16, 185, 129, 0.5); }
        
        .btn-info-alur { background: rgba(255, 255, 255, 0.02); color: var(--text-silver); border: 1px dashed var(--border-white); padding: 0.8rem; border-radius: 16px; font-weight: 700; font-size: 0.75rem; display: flex; align-items: center; justify-content: center; gap: 10px; transition: 0.3s; margin-bottom: 1rem; width: 100%; cursor: pointer; }
        .btn-info-alur:hover { background: rgba(16, 185, 129, 0.05); color: var(--accent-emerald); border-color: var(--accent-emerald); }

        .btn-ghost { background: rgba(255,255,255,0.03); color: var(--text-silver); border: 1px solid var(--border-white); padding: 1rem; border-radius: 20px; font-weight: 600; width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.75rem; text-decoration: none; transition: 0.2s; margin-top: 1rem; }
        [data-theme="light"] .btn-ghost { background: #fff; }
        .btn-ghost:hover { background: rgba(255,255,255,0.08); color: var(--accent-blue); border-color: var(--accent-blue); }
        .pulse-dot { width: 6px; height: 6px; background: var(--accent-emerald); border-radius: 50%; display: inline-block; box-shadow: 0 0 8px var(--accent-emerald); animation: pulse-ring 1.5s infinite; }
        @keyframes pulse-ring { 0% { transform: scale(0.9); opacity: 1; } 50% { transform: scale(1.3); opacity: 0.5; } 100% { transform: scale(0.9); opacity: 1; } }
        .memo-terminal { margin-top: 3rem; padding: 1.5rem; border-radius: 24px; background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.1); }
        .theme-switcher { position: fixed; bottom: 30px; right: 30px; z-index: 9999; background: var(--gradasi); color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3); }
    </style>
</head>
<body>

    <div class="latar-animasi" id="particles-container"></div>
    <div class="ambient-glow"></div>

    <div class="theme-switcher" id="theme-toggle-btn">
        <i class="bi bi-sun-fill" id="theme-icon"></i>
    </div>

    <div class="container-main">
        <div class="hero-content">
            <div class="chip-status">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Menu Peminjaman Buku</span>
            </div>
            
            <h1 class="title-huge">Sistem <span>Pinjam</span><br>Mandiri.</h1>
            <p class="sub-description">Lakukan proses peminjaman koleksi SMEKDA Library secara langsung. Masukkan data buku dan pantau sisa kuota akun Anda di sini.</p>

            <div class="book-card-mini">
                <span class="label-header">DAFTAR BUKU YANG SEDANG DIPINJAM</span>
                
                @forelse($transaksiAktif as $t)
                    <div class="book-entry d-flex align-items-center justify-content-between">
                        <div class="flex-grow-1 overflow-hidden">
                            <div style="font-weight: 700; color: var(--text-main); font-size: 1rem;" class="text-truncate">{{ $t->buku->judul }}</div>
                            <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.65rem; color: var(--accent-emerald); font-weight: 700; margin-top: 4px;">
                                <span class="pulse-dot me-2"></span>{{ strtoupper($t->status) }}
                            </div>
                        </div>
                        
                        @if($t->status == 'Menunggu Pinjam')
                        <div class="d-flex gap-2 ms-2">
                            <a href="{{ route('pinjam.edit', $t->id) }}" class="btn btn-sm btn-outline-info rounded-3">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <button class="btn btn-sm btn-outline-danger rounded-3" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $t->id }}">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                        @else
                        <i class="bi bi-lock-fill text-muted ms-2"></i>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="bi bi-journal-x text-muted mb-2 d-block" style="font-size: 2rem;"></i>
                        <span class="text-muted small">Belum ada buku yang dipinjam.</span>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="control-panel">
            <div class="quota-monitor">
                <div class="monitor-label">
                    <span style="color: var(--text-main);">KAPASITAS AKUN</span>
                    <span style="color: var(--accent-emerald)">{{ $jumlahAktif }} / 3 BUKU</span>
                </div>
                <div class="segments">
                    <div class="seg {{ $jumlahAktif >= 1 ? 'filled' : '' }}"></div>
                    <div class="seg {{ $jumlahAktif >= 2 ? 'filled' : '' }}"></div>
                    <div class="seg {{ $jumlahAktif >= 3 ? 'filled' : '' }}"></div>
                </div>
            </div>

            <h3 style="font-weight: 800; margin-bottom: 0.5rem; color: var(--text-main);">Proses Peminjaman</h3>
            <p style="color: var(--text-main);" class="small mb-5">Daftarkan peminjaman buku secara mandiri segera setelah Anda mengambil buku dari rak.</p>

            <div class="d-grid">
                <div class="btn-info-alur" data-bs-toggle="modal" data-bs-target="#modalAlur">
                    <i class="bi bi-info-circle-fill text-emerald pulse-dot" style="width: 8px; height: 8px;"></i>
                    <span>LIHAT ALUR PROSES PEMINJAMAN</span>
                </div>

                @if($jumlahAktif < 3)
                <form action="{{ route('pinjam.form') }}" method="GET">
                    <input type="hidden" name="buku_id" value="{{ $buku->id ?? 0 }}">
                    <button type="submit" class="btn-luxe">
                        <i class="bi bi-pencil-square"></i> Isi Form Peminjaman
                    </button>
                </form>
                @else
                <div class="p-3 text-center rounded-4 mb-3 border border-danger border-opacity-10" style="background: rgba(220, 53, 69, 0.05);">
                    <span class="text-danger fw-bold small">KUOTA PENUH - KEMBALIKAN BUKU DULU</span>
                </div>
                @endif
                
                <a href="{{ route('dashboard') }}" class="text-center mt-4 text-decoration-none small fw-bold" style="color: #475569;">
                    <i class="bi bi-arrow-left me-2"></i> DASBOR UTAMA
                </a>
            </div>
            
            <div class="memo-terminal">
                <div class="monitor-label mb-3">
                    <span style="color: var(--accent-blue); font-size: 0.7rem; letter-spacing: 2px; font-weight: 800; text-transform: uppercase; display: flex; align-items: center; gap: 8px;">
                        <span class="pulse-dot" style="background: var(--accent-blue); box-shadow: 0 0 8px var(--accent-blue);"></span>
                        SISTEM LOG : INSTRUKSI GURU
                    </span>
                </div>

                @if(isset($transaksiTerakhir) && !empty($transaksiTerakhir->catatan) && $transaksiTerakhir->catatan != '-')
                    <div class="catatan-box position-relative overflow-hidden" style="background: rgba(255, 193, 7, 0.03); border: 1px solid rgba(255, 193, 7, 0.2); border-left: 4px solid #ffc107; padding: 1.25rem; border-radius: 16px;">
                        <div class="d-flex gap-3">
                            <div class="icon-circle" style="width: 40px; height: 40px; background: rgba(255, 193, 7, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="bi bi-chat-left-dots-fill text-warning"></i>
                            </div>
                            <div class="flex-grow-1 text-start">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span style="font-size: 0.65rem; font-weight: 800; color: #ffc107; letter-spacing: 1px; text-transform: uppercase;">Pesan Baru</span>
                                    <span style="font-size: 0.6rem; color: var(--text-silver); font-family: 'JetBrains Mono', monospace;">
                                        {{ $transaksiTerakhir->updated_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="mb-0" style="line-height: 1.5; font-size: 0.95rem; color: var(--text-main); font-weight: 500; font-style: italic;">
                                    "{{ $transaksiTerakhir->catatan }}"
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="catatan-empty" style="padding: 2rem; border: 1px dashed var(--border-white); border-radius: 20px; background: rgba(255,255,255,0.01); text-align: center;">
                        <i class="bi bi-slash-circle text-muted d-block mb-2" style="font-size: 1.2rem;"></i>
                        <span class="text-muted small fw-medium">Antrian log kosong. Belum ada catatan guru.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAlur" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="background: var(--panel-bg); backdrop-filter: blur(25px); border-radius: 32px; border: 1px solid var(--border-white);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" style="color: var(--text-main);">Alur Peminjaman</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="step-item"><div class="step-title">1. Registrasi Akun</div><div class="step-desc">Siswa wajib daftar sebagai anggota perpustakaan terlebih dahulu.</div></div>
                    <div class="step-item"><div class="step-title">2. Katalog Digital</div><div class="step-desc">Lihat-lihat koleksi buku melalui katalog digital untuk memilih buku.</div></div>
                    <div class="step-item active"><div class="step-title">3. Isi Form Pinjam</div><div class="step-desc">Ke menu "Peminjaman Saya" lalu isi form sesuai buku yang dipilih.</div></div>
                    <div class="step-item"><div class="step-title">4. Verifikasi Admin</div><div class="step-desc">Tunggu hingga admin menyetujui pengajuan peminjaman kamu.</div></div>
                    <div class="step-item"><div class="step-title">5. Pengambilan Buku</div><div class="step-desc">Jika sudah disetujui, langsung ambil buku fisiknya ke perpustakaan.</div></div>
                    <button class="btn-luxe w-100 mt-3" data-bs-dismiss="modal">Saya Mengerti</button>
                </div>
            </div>
        </div>
    </div>

    @foreach($transaksiAktif as $t)
        @if($t->status == 'Menunggu Pinjam')
            <div class="modal fade" id="modalHapus{{ $t->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content border-0" style="background: var(--panel-bg); backdrop-filter: blur(25px); border-radius: 32px; border: 1px solid var(--border-white);">
                        <div class="modal-body p-4 text-center">
                            <i class="bi bi-exclamation-triangle-fill text-danger mb-3" style="font-size: 3rem;"></i>
                            <h5 class="fw-800 mb-2" style="color: var(--text-main);">Batalkan Pinjaman?</h5>
                            <p class="small mb-4" style="color: var(--text-silver);">Yakin menghapus pengajuan <b>"{{ $t->buku->judul }}"</b>?</p>
                            <div class="d-grid gap-2">
                                <form action="{{ route('pinjam.destroy', $t->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100 fw-bold py-2" style="border-radius: 14px;">Ya, Batalkan</button>
                                </form>
                                <button type="button" class="btn btn-ghost w-100 fw-bold py-2" data-bs-dismiss="modal" style="border-radius: 14px;">Kembali</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const msgSuccess = "{{ session('success') }}";
        if (msgSuccess) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: msgSuccess,
                confirmButtonColor: '#10b981',
                customClass: { popup: 'rounded-4' }
            });
        }

        // Particles
        const container = document.getElementById('particles-container');
        for (let i = 0; i < 20; i++) {
            const p = document.createElement('div');
            p.className = 'partikel';
            p.style.left = Math.random() * 100 + 'vw';
            const size = Math.random() * 3 + 2 + 'px';
            p.style.width = size; p.style.height = size;
            p.style.animationDuration = Math.random() * 8 + 7 + 's';
            p.style.animationDelay = Math.random() * 5 + 's';
            container.appendChild(p);
        }

        const btn = document.getElementById('theme-toggle-btn');
        const html = document.documentElement;
        const icon = document.getElementById('theme-icon');

        btn.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            icon.className = newTheme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
            
            fetch("{{ route('update.theme') }}", {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                },
                body: JSON.stringify({ theme: newTheme })
            });
        });
    </script>
</body>
</html>