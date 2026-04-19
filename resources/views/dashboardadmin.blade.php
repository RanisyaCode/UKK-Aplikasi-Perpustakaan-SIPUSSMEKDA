@extends('layouts.app')

@section('title', $title1)

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">

<style>
    :root {
        --bg-deep: #020617;
        --card-bg: rgba(15, 23, 42, 0.8);
        --text-main: #f8fafc;
        --text-dim: #94a3b8;
        --border-thin: rgba(255, 255, 255, 0.06);
        --btn-ghost: rgba(255,255,255,0.03);
        
        --accent-emerald: #10b981;
        --accent-blue: #3b82f6;
        --accent-amber: #f59e0b;
        --accent-rose: #f43f5e;
    }

    [data-theme="light"] {
        --bg-deep: #f1f5f9;
        --card-bg: rgba(255, 255, 255, 0.9);
        --text-main: #0f172a;
        --text-dim: #64748b;
        --border-thin: rgba(0, 0, 0, 0.08);
        --btn-ghost: rgba(0, 0, 0, 0.02);
    }

    .content-wrapper, .content, .container-fluid { 
        background: var(--bg-deep) !important; 
        border: none !important; 
        transition: background 0.3s ease;
    }

    .dashboard-premium {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-main);
        padding: 2rem;
    }

    .glass-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
    }

    .brand-logo {
        font-size: 1.6rem;
        font-weight: 800;
        background: linear-gradient(to right, #10b981, #3b82f6);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: -1px;
    }

    .bento-surface {
        background: var(--card-bg);
        backdrop-filter: blur(24px);
        border: 1px solid var(--border-thin);
        border-radius: 24px;
        padding: 1.5rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .bento-surface:hover {
        border-color: rgba(59, 130, 246, 0.4);
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .label-caps { 
        font-size: 0.7rem; 
        font-weight: 700; 
        color: var(--text-dim); 
        text-transform: uppercase; 
        letter-spacing: 1.2px; 
    }
    
    .stat-hero { 
        font-size: 2.6rem; 
        font-weight: 800; 
        letter-spacing: -2px; 
        margin: 0.4rem 0; 
        color: var(--text-main);
    }

    .status-pill {
        font-size: 0.65rem;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 8px;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .status-pill.dipinjam { background: rgba(59, 130, 246, 0.1); color: #3b82f6; border: 1px solid rgba(59, 130, 246, 0.2); }
    .status-pill.verifikasi { background: rgba(245, 158, 11, 0.1); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2); }
    .status-pill.ditolak { background: rgba(244, 63, 94, 0.1); color: #e11d48; border: 1px solid rgba(244, 63, 94, 0.2); }
    .status-pill.kembali { background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); }

    .tile-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    
    .tile-btn {
        background: var(--btn-ghost);
        border: 1px solid var(--border-thin);
        border-radius: 18px;
        padding: 1.2rem;
        text-decoration: none !important;
        transition: 0.3s;
        text-align: center;
    }
    
    .tile-btn:hover { background: var(--accent-blue); transform: scale(1.02); }
    .tile-btn i { font-size: 1.4rem; color: var(--accent-emerald); display: block; margin-bottom: 8px; }
    .tile-btn:hover i, .tile-btn:hover span { color: #fff !important; }
    .tile-btn span { font-size: 0.75rem; font-weight: 700; color: var(--text-main); }

    .feed-scroll { max-height: 500px; overflow-y: auto; overflow-x: hidden; padding-right: 10px; }
    .feed-scroll::-webkit-scrollbar { width: 4px; }
    .feed-scroll::-webkit-scrollbar-thumb { background: var(--border-thin); border-radius: 10px; }

    .transaction-row {
        background: var(--btn-ghost);
        border-radius: 18px;
        padding: 1.2rem;
        margin-bottom: 12px;
        border: 1px solid transparent;
        transition: 0.3s;
    }
    
    .transaction-row:hover { background: var(--card-bg); border-color: var(--border-thin); }

    .avatar-box {
        width: 48px; height: 48px;
        background: linear-gradient(45deg, var(--bg-deep), var(--border-thin));
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; color: var(--accent-emerald);
        border: 1px solid var(--border-thin);
    }

    .glass-header {
        display: flex;
        justify-content: space-between;
        align-items: center; 
        margin-bottom: 2.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-thin); 
    }

    #real-clock {
        line-height: 1; 
        transition: color 0.3s ease;
    }

    #real-date {
        letter-spacing: 0.5px;
    }
</style>

<div class="dashboard-premium">
    
    <div class="glass-header">
        <div>
            <h1 class="brand-logo m-0">SIPUS SMEKDA</h1>
            <p class="small text-dim m-0 fw-600" id="real-date">
                <i class="bi bi-calendar3 me-1"></i> MEMUAT KALENDER...
            </p>
        </div>

        <div class="text-end">
            <div id="real-clock" class="h2 fw-800 m-0" style="letter-spacing: -1px; color: var(--text-main);">
                00:00:00
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="bento-surface h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="label-caps">Total Anggota</span>
                        <div class="stat-hero">{{ number_format($count_user, 0, ',', '.') }}</div>
                    </div>
                    <div class="p-2 bg-emerald bg-opacity-10 rounded-3">
                        <i class="bi bi-people-fill text-emerald"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 mt-2 opacity-75">
                    <span class="badge bg-emerald bg-opacity-10 text-emerald p-1 rounded-circle">
                        <i class="bi bi-check-circle-fill" style="font-size: 0.5rem;"></i>
                    </span>
                    <span class="small text-dim fw-600">Admin & Siswa Aktif</span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="bento-surface h-100" style="border-top: 3px solid var(--accent-rose);">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="label-caps text-rose">Keterlambatan</span>
                        <div class="stat-hero text-rose">{{ $count_overdue }}</div>
                    </div>
                    <div class="p-2 bg-rose bg-opacity-10 rounded-3">
                        <i class="bi bi-exclamation-triangle-fill text-rose"></i>
                    </div>
                </div>
                <p class="small text-dim mt-2 mb-0" style="font-size: 0.65rem;">Perlu tindak lanjut segera</p>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="bento-surface h-100">
                <span class="label-caps mb-3 d-block">Status Koleksi</span>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between align-items-center pb-2 border-bottom border-secondary border-opacity-10">
                        <span class="small text-dim"><i class="bi bi-book me-2"></i>Total Buku</span>
                        <span class="small fw-800">{{ $count_buku }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small text-dim"><i class="bi bi-arrow-up-right me-2 text-blue"></i>Dipinjam</span>
                        <span class="small fw-800 text-blue">{{ $count_pinjam }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="tile-grid h-100">
                <a href="{{ route('admin.transaksi.peminjaman') }}" class="tile-btn d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-plus-circle-fill mb-1"></i>
                    <span>PINJAM</span>
                </a>
                <a href="{{ route('databuku') }}" class="tile-btn d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-grid-1x2-fill mb-1"></i>
                    <span>KATALOG</span>
                </a>
                <a href="{{ route('anggota') }}" class="tile-btn d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-person-lines-fill mb-1"></i>
                    <span>SISWA</span>
                </a>
                <div class="tile-btn d-flex flex-column align-items-center justify-content-center" style="opacity: 0.3; cursor: not-allowed;">
                    <i class="bi bi-shield-lock-fill mb-1"></i>
                    <span>ADMIN</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="bento-surface">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2">
                    <div>
                        <h5 class="fw-800 m-0">Log Transaksi</h5>
                        <p class="small text-dim m-0">Aktivitas peminjaman dan pengembalian</p>
                    </div>
                    <a href="{{ route('admin.transaksi.peminjaman') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-4 fw-800 border-opacity-25" style="font-size: 0.7rem; color: var(--text-main);">TELUSURI SEMUA</a>
                </div>

                <div class="feed-scroll">
                    <div class="row g-3">
                        @forelse($recent_transactions as $rt)
                            <div class="col-xl-4 col-md-6">
                                <div class="transaction-row">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-box">
                                            {{ strtoupper(substr($rt->user->nama ?? 'S', 0, 1)) }}
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <div class="fw-800 text-truncate" style="font-size: 0.95rem; color: var(--text-main);">
                                                {{ $rt->user->nama ?? 'Siswa' }}
                                            </div>
                                            <div class="text-dim text-truncate" style="font-size: 0.8rem;">
                                                {{ $rt->buku->judul ?? 'Judul Buku' }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <hr class="my-3 opacity-5">
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        @php $status = $rt->status ?? ''; @endphp

                                        @if($status == 'Dipinjam')
                                            <span class="status-pill dipinjam"><i class="bi bi-arrow-up-right"></i> Sedang Dipinjam</span>
                                        @elseif($status == 'Sudah Dikembalikan')
                                            <span class="status-pill kembali"><i class="bi bi-check-circle"></i> Sudah Dikembalikan</span>
                                        @elseif($status == 'Menunggu Pinjam')
                                            <span class="status-pill verifikasi"><i class="bi bi-hourglass-split"></i> Menunggu Verifikasi</span>
                                        @elseif($status == 'Ditolak')
                                            <span class="status-pill ditolak"><i class="bi bi-x-circle"></i> Ditolak</span>
                                        @else
                                            <span class="status-pill verifikasi">Status Tidak Diketahui</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 py-5 text-center opacity-20 fw-800" style="color: var(--text-dim)">
                                <i class="bi bi-folder-x display-1 d-block mb-3"></i>
                                TIDAK ADA AKTIVITAS TRANSAKSI
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateClock() {
        const now = new window.Date();
        const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        const dateOptions = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
        
        const clockEl = document.getElementById('real-clock');
        const dateEl = document.getElementById('real-date');

        if(clockEl) clockEl.innerText = now.toLocaleTimeString('id-ID', timeOptions);
        if(dateEl) dateEl.innerText = now.toLocaleDateString('id-ID', dateOptions).toUpperCase();
    }
    
    setInterval(updateClock, 1000);
    updateClock();
</script>
@endsection