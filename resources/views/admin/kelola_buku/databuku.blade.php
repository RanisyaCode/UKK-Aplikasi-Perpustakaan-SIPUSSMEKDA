@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>


<style>
    :root {
        --bg-deep: #020617;
        --card-bg: rgba(15, 23, 42, 0.8);
        --text-main: #f8fafc;
        --text-dim: #94a3b8;
        --border-thin: rgba(255, 255, 255, 0.06);
        --btn-ghost: rgba(255,255,255,0.03);
        --invert-icon: 1; 
        --accent-emerald: #10b981;
        --accent-blue: #3b82f6;
    }

    [data-theme="light"] {
        --bg-deep: #f1f5f9;
        --card-bg: rgba(255, 255, 255, 0.9);
        --text-main: #0f172a;
        --text-dim: #64748b;
        --border-thin: rgba(0, 0, 0, 0.08);
        --btn-ghost: rgba(0, 0, 0, 0.02);
        --invert-icon: 0;
    }

    .modal-backdrop { z-index: 1040 !important; }
    .modal { z-index: 1050 !important; }
    body.modal-open .admin-catalog { filter: none !important; backdrop-filter: none !important; }

    .admin-catalog {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--bg-deep) !important;
        min-height: 100vh;
        padding: 30px 2%;
        color: var(--text-main);
        transition: background 0.4s ease, color 0.4s ease;
    }

    .latar-animasi { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; pointer-events: none; }
    .partikel { position: absolute; background: var(--accent-emerald); border-radius: 50%; opacity: 0.1; animation: terbang linear infinite; }
    @keyframes terbang { from { transform: translateY(100vh); opacity: 0.2; } to { transform: translateY(-10vh); opacity: 0; } }

    .container-fluid { position: relative; z-index: 10; }

    .btn-theme-toggle {
        width: 42px; height: 42px; border-radius: 12px;
        background: var(--card-bg); border: 1px solid var(--border-thin);
        color: var(--text-main); display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: 0.3s; margin-right: 15px;
    }

    .text-gradient {
        background: linear-gradient(to right, #10b981, #3b82f6);
        background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }

    .card-kaca {
        background: var(--card-bg); backdrop-filter: blur(24px);
        border: 1px solid var(--border-thin); border-radius: 24px;
        padding: 1rem; box-shadow: 0 20px 40px rgba(0,0,0,0.05);
    }

    .stat-box {
        background: var(--card-bg); border: 1px solid var(--border-thin);
        border-radius: 18px; padding: 15px;
    }

    .table-smekda { color: var(--text-main) !important; }
    .table-smekda thead th { border: none; color: var(--text-dim); text-transform: uppercase; font-size: 11px; letter-spacing: 1px; }
    .table-smekda tbody td { border-bottom: 1px solid var(--border-thin); vertical-align: middle; color: var(--text-main) !important; }

    .search-box {
        background: var(--card-bg) !important; border: 1px solid var(--border-thin) !important;
        color: var(--text-main) !important; border-radius: 14px; height: 48px; padding-left: 50px;
    }

    .btn-mewah {
        background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
        color: white !important; padding: 10px 20px; border-radius: 12px;
        font-weight: 700; text-decoration: none; display: inline-block; transition: 0.4s; border: none;
    }

    .modal-content {
        background: var(--card-bg) !important; backdrop-filter: blur(30px);
        color: var(--text-main) !important; border: 1px solid var(--border-thin) !important;
        border-radius: 24px !important;
    }
    .btn-close { filter: invert(var(--invert-icon)); }
    
    .sampul-klik { width: 45px; height: 60px; border-radius: 8px; overflow: hidden; cursor: pointer; border: 1px solid var(--border-thin); }

    /* Efek Hover pada sampul kecil di tabel */
    .sampul-klik {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .sampul-klik:hover {
        transform: scale(1.08);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
    }

    /* Background modal light-subtle untuk dark/light mode */
    [data-theme="dark"] .bg-light-subtle {
        background: rgba(255, 255, 255, 0.03) !important;
    }
    [data-theme="light"] .bg-light-subtle {
        background: rgba(0, 0, 0, 0.02) !important;
    }

    .pagination svg, 
    nav svg, 
    .pagination-modern svg {
        display: none !important;
    }

    .pagination-modern nav div:first-child {
        display: none !important; 
    }

    .pagination-modern .pagination {
        display: flex !important;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 8px;
        justify-content: center;
    }

    .pagination-modern .page-item .page-link {
        width: 40px !important;
        height: 40px !important;
        display: flex !important;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #94a3b8 !important; /* text-dim */
        border-radius: 12px !important;
        text-decoration: none !important;
        font-weight: 700 !important;
        transition: 0.3s !important;
    }

    .pagination-modern .page-item.active .page-link {
        background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%) !important;
        color: white !important;
        border: none !important;
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3) !important;
    }

    /* 5. HOVER EFFECT */
    .pagination-modern .page-item .page-link:hover:not(.active) {
        background: rgba(59, 130, 246, 0.1) !important;
        border-color: #3b82f6 !important;
        color: #3b82f6 !important;
    }

    .pagination-modern .page-item:first-child .page-link,
    .pagination-modern .page-item:last-child .page-link {
        width: auto !important;
        padding: 0 15px !important;
    }
</style>

<div class="admin-catalog" id="mainContainer" data-theme="dark">
    <div class="latar-animasi" id="particles-container"></div>
    
    <div class="container-fluid">
        <div class="row align-items-center mb-4">
            <div class="col-md-7">
                <h3 class="fw-800 mb-1">Katalog <span class="text-gradient">Data Buku</span></h3>
                <p style="color: var(--text-dim)" class="small mb-0">Manajemen koleksi buku perpustakaan digital SMEKDA.</p>
            </div>
            <div class="col-md-5 d-flex justify-content-md-end align-items-center mt-3 mt-md-0">
                <a href="{{ route('buku.create') }}" class="btn-mewah shadow">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Koleksi
                </a>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6 col-md-2">
                <div class="stat-box d-flex align-items-center gap-3">
                    <div style="font-size: 1.2rem; color: var(--accent-emerald);"><i class="bi bi-journal-bookmark"></i></div>
                    <div>
                        <h5 class="fw-800 mb-0">{{ $bukus->count() }}</h5>
                        <small style="color: var(--text-dim); font-size: 9px;" class="text-uppercase">Judul</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-2">
                <div class="stat-box d-flex align-items-center gap-3">
                    <div style="font-size: 1.2rem; color: var(--accent-blue);"><i class="bi bi-box-seam"></i></div>
                    <div>
                        <h5 class="fw-800 mb-0">{{ $bukus->sum('stok') }}</h5>
                        <small style="color: var(--text-dim); font-size: 9px;" class="text-uppercase">Stok</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="position-relative mb-4">
            <i class="bi bi-search" style="position: absolute; left: 18px; top: 14px; color: var(--accent-emerald); z-index: 10;"></i>
            <input type="text" id="adminSearch" class="form-control search-box" placeholder="Cari judul, kategori, atau ISBN...">
        </div>

        <div class="card-kaca shadow-lg">
            <div class="table-responsive">
                <table class="table table-smekda" id="adminBookTable">
                    <thead>
                        <tr>
                            <th class="text-center">Sampul</th>
                            <th>Informasi Utama</th>
                            <th>Penerbit</th>
                            <th>ISBN</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bukus as $item)
                        <tr>
                        <td class="text-center">
                            <div class="sampul-klik mx-auto" data-bs-toggle="modal" data-bs-target="#modalSampul{{ $item->id }}"> <img src="{{ $item->cover ? asset('storage/covers/' . $item->cover) : 'https://ui-avatars.com/api/?name='.urlencode($item->judul).'&background=10b981&color=fff' }}" style="width:100%; height:100%; object-fit:cover;">
                            </div>
                        </td>
                            <td>
                                <div class="fw-700">{{ $item->judul }}</div>
                                <span style="color: var(--accent-emerald); font-size: 11px; font-weight: 600;">{{ $item->kategori }}</span>
                            </td>
                            <td>
                                <div class="small fw-600">{{ $item->penulis }}</div>
                                <div style="color: var(--text-dim); font-size: 11px;">{{ $item->penerbit }}</div>
                            </td>
                            <td>
                                <code style="color: var(--accent-blue); font-size: 11px;">{{ $item->isbn ?? '-' }}</code>
                            </td>
                            <td class="text-center fw-700">{{ $item->stok }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('buku.edit', $item->id) }}" class="btn btn-sm btn-outline-info rounded-pill px-3" style="font-size: 10px;">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3" 
                                            style="font-size: 10px;" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalHapus{{ $item->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>

                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 px-2 gap-3">
                        <div class="small fw-bold" style="color: var(--text-dim); font-size: 0.75rem; letter-spacing: 0.5px;">
                            MENAMPILKAN <span class="text-white">{{ $bukus->firstItem() ?? 0 }} - {{ $bukus->lastItem() ?? 0 }}</span> 
                            DARI <span class="text-gradient">{{ $bukus->total() }}</span> KOLEKSI
                        </div>
                        <div class="pagination-modern">
                            {{ $bukus->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL DI LUAR CONTAINER UTAMA --}}
@foreach ($bukus as $item)
    @include('admin.partials.modal-buku', ['item' => $item])
@endforeach

<script>
    // 1. Ambil session dari Laravel
   const msgSuccess = "{{ session('success') }}";
    const msgError = "{{ session('error') }}";

    // 2. Fungsi untuk mendeteksi mode saat ini
    const getThemeConfig = () => {
        const isLight = document.documentElement.getAttribute('data-theme') === 'light';
        return {
            background: isLight ? '#ffffff' : 'rgba(15, 23, 42, 0.95)',
            color: isLight ? '#1e293b' : '#ffffff',
            confirmButtonColor: '#10b981', // Tetap Emerald agar ikonik
            backdrop: isLight ? 'rgba(0,0,0,0.2)' : 'rgba(2, 6, 23, 0.7)',
            className: isLight ? 'border-light' : 'border-dark'
        };
    };

    // 3. Eksekusi Alert Sukses
    if (msgSuccess) {
        const config = getThemeConfig();
        Swal.fire({
            icon: 'success',
            title: '<span style="font-weight:800; font-family:\'Plus Jakarta Sans\'">Berhasil!</span>',
            html: `<span style="font-family:\'Plus Jakarta Sans\'; font-size: 0.9rem;">${msgSuccess}</span>`,
            background: config.background,
            color: config.color,
            confirmButtonColor: config.confirmButtonColor,
            backdrop: config.backdrop,
            showClass: {
                popup: 'animate__animated animate__fadeInUp animate__faster'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutDown animate__faster'
            },
            customClass: {
                popup: 'rounded-4 border-0 shadow-lg'
            }
        });
    }

    // 4. Eksekusi Alert Error
    if (msgError) {
        const config = getThemeConfig();
        Swal.fire({
            icon: 'error',
            title: '<span style="font-weight:800; font-family:\'Plus Jakarta Sans\'">Terjadi Kesalahan</span>',
            html: `<span style="font-family:\'Plus Jakarta Sans\'; font-size: 0.9rem;">${msgError}</span>`,
            background: config.background,
            color: config.color,
            confirmButtonColor: '#ef4444',
            backdrop: config.backdrop,
            customClass: {
                popup: 'rounded-4 border-0 shadow-lg'
            }
        });
    }

        // --- ANIMASI PARTIKEL (Tetap Ada) ---
        const pContainer = document.getElementById('particles-container');
        if(pContainer) {
            for (let i = 0; i < 15; i++) {
                const p = document.createElement('div');
                p.className = 'partikel';
                p.style.left = Math.random() * 100 + 'vw';
                const size = Math.random() * 3 + 2 + 'px';
                p.style.width = size; p.style.height = size;
                p.style.animationDuration = Math.random() * 10 + 10 + 's';
                p.style.animationDelay = Math.random() * 5 + 's';
                pContainer.appendChild(p);
            }
        }

        // --- LOGIKA PENCARIAN (Tetap Ada) ---
        const searchInput = document.getElementById('adminSearch');
        const tableRows = document.querySelectorAll('#adminBookTable tbody tr');
        if(searchInput) {
            searchInput.addEventListener('input', function() { // Gunakan 'input' agar lebih responsif
                const keyword = this.value.toLowerCase();
                tableRows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(keyword) ? '' : 'none';
                });
            });
        }

        // --- PINDAHKAN MODAL (Fix Z-Index) ---
        const allModals = document.querySelectorAll('.modal');
        allModals.forEach(modal => {
            document.body.appendChild(modal);
        });
        
    // --- FUNGSI TOGGLE TEMA ---
    function toggleTheme() {
        const container = document.getElementById('mainContainer');
        const icon = document.getElementById('themeIcon');
        if(!container) return;

        const current = container.getAttribute('data-theme');
        const target = current === 'dark' ? 'light' : 'dark';
        
        container.setAttribute('data-theme', target);
        localStorage.setItem('theme-pref', target);
        
        if(icon) {
            if(target === 'light') {
                icon.classList.replace('bi-moon-stars-fill', 'bi-sun-fill');
                icon.style.color = '#f59e0b';
            } else {
                icon.classList.replace('bi-sun-fill', 'bi-moon-stars-fill');
                icon.style.color = '#10b981';
            }
        }
    }
</script>
@endsection