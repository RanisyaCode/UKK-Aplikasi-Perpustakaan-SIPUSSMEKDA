@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    .main-content {
        --bg-body: #020617; 
        --kaca: rgba(15, 23, 42, 0.7);
        --kaca-hover: rgba(30, 41, 59, 0.8);
        --text-main: #ffffff;
        --text-muted: #94a3b8;
        --garis: rgba(255, 255, 255, 0.08);
        --input-bg: rgba(255, 255, 255, 0.03);
        --modal-bg: #ffffff; 
        --grad-masterpiece: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
        --grad-danger: linear-gradient(135deg, #ef4444 0%, #991b1b 100%);
        
        padding: 2.5rem; 
        min-height: 100vh;
        background-color: var(--bg-body);
        transition: background-color 0.3s ease;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    html[data-theme="light"] .main-content {
        --bg-body: #f8fafc;
        --kaca: #ffffff;
        --kaca-hover: #f1f5f9;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --garis: rgba(0, 0, 0, 0.08);
        --input-bg: #ffffff;
        --modal-bg: #ffffff;
    }

    .modal-backdrop { 
        z-index: 1050 !important; 
        backdrop-filter: blur(12px) !important;
        background-color: rgba(0,0,0,0.6) !important;
    }
    
    .modal { 
        z-index: 1060 !important; 
    }

    .modal-content {
        background: #ffffff !important; /* Putih Solid */
        border: none !important;
        border-radius: 30px !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3) !important;
        overflow: hidden;
    }

    .modal-body h4, .modal-body h5 {
        color: #1e293b !important;
        font-weight: 800 !important;
    }

    .modal-body p.text-muted {
        color: #64748b !important;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        background: #f8fafc; 
        border-radius: 18px;
        margin-bottom: 12px;
        border: 1px solid #e2e8f0;
        transition: 0.2s ease-in-out;
    }

    .detail-row:hover {
        background: #f1f5f9;
        transform: translateY(-2px);
    }

    .modal-body .text-white {
        color: #0f172a !important; 
    }

    .bg-light-dark { 
        background: #f1f5f9 !important; 
        border: 1px solid #e2e8f0 !important;
    }

    .page-title { 
        font-weight: 800; 
        letter-spacing: -1.5px; 
        color: var(--text-main); 
        font-size: 2.5rem; 
    }
    
    .stat-card-glass {
        background: var(--kaca);
        backdrop-filter: blur(12px);
        border: 1px solid var(--garis);
        border-radius: 24px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .search-wrapper {
        background: var(--input-bg);
        border-radius: 20px;
        padding: 10px 24px;
        border: 1px solid var(--garis);
        display: flex;
        align-items: center;
        transition: 0.3s;
        margin-bottom: 2.5rem;
    }

    .search-wrapper:focus-within {
        border-color: #10b981;
        box-shadow: 0 0 20px rgba(16, 185, 129, 0.1);
    }

    .search-wrapper input {
        color: var(--text-main) !important;
        background: transparent !important;
    }

    .data-item {
        background: var(--kaca);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--garis);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .data-item:hover {
        transform: scale(1.01) translateX(10px);
        background: var(--kaca-hover);
        border-color: #10b981;
    }

    .brand-avatar {
        width: 50px; height: 50px;
        border-radius: 15px;
        background: var(--grad-masterpiece);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .action-group-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        justify-content: flex-end;
    }

    .btn-verify-primary {
        background: var(--grad-masterpiece);
        color: white !important; 
        border: none;
        border-radius: 14px;
        padding: 10px 22px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        transition: 0.3s;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
    }

    .action-btn-pill {
        width: 42px; height: 42px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-muted);
        border: 1px solid var(--garis);
        transition: 0.2s;
        cursor: pointer;
    }

    .action-btn-pill:hover {
        background: var(--text-main);
        color: var(--bg-body);
    }
    
    .text-white-50 { color: var(--text-main) !important; opacity: 0.7; }
    .text-white { color: var(--text-main) !important; }
    .text-muted { color: var(--text-muted) !important; }

    @media (max-width: 768px) {
        .page-title { font-size: 1.8rem; }
    }
</style>

<div class="main-content">
    <div class="container-fluid">
        <div class="row align-items-center mb-5">
            <div class="col-lg-7">
                <h1 class="page-title">Validasi Pengembalian</h1>
                <p class="text-muted fs-6 mb-0">Verifikasi fisik buku dan selesaikan data pengembalian secara real-time.</p>
            </div>
            <div class="col-lg-5 text-end d-none d-lg-block">
                <div class="stat-card-glass d-inline-flex ms-auto text-start">
                    <div class="brand-avatar" style="background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2);">
                        <i class="bi bi-clipboard-check fs-4"></i>
                    </div>
                    <div>
                        <span class="text-muted small fw-700 text-uppercase d-block" style="letter-spacing: 1px;">Antrean Validasi</span>
                        <h2 class="fw-800 mb-0 text-white">{{ $data->count() }} <small class="fs-6 fw-500 text-muted">Data</small></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="search-wrapper">
            <i class="bi bi-search me-3 text-muted fs-5"></i>
            <input type="text" id="masterSearch" class="form-control border-0 shadow-none fw-600" placeholder="Cari nama siswa atau judul buku...">
        </div>

        <div id="dataList">
            @forelse($data as $p)
            <div class="data-item searchable">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center">
                            <div class="brand-avatar me-3">
                                {{ strtoupper(substr($p->user->nama ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <h6 class="fw-800 mb-0 text-white">{{ $p->user->nama ?? 'Siswa' }}</h6>
                                <small class="text-muted fw-600">NIS: {{ $p->user->nis ?? '-' }}</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3 border-start" style="border-color: var(--garis) !important;">
                        <div class="ps-md-4">
                            <span class="text-muted small fw-700 d-block text-uppercase mb-1" style="font-size: 0.65rem; letter-spacing: 1px;">Buku Terkait</span>
                            <span class="fw-700 text-white-50">{{ \Illuminate\Support\Str::limit($p->buku->judul ?? 'Tanpa Judul', 35) }}</span>
                        </div>
                    </div>

                    <div class="col-md-2 text-center">
                        @if($p->status == 'Sudah Dikembalikan' || $p->status == 'Selesai') 
                            <span class="badge px-3 py-2 rounded-pill" style="font-size: 0.7rem; font-weight: 800; background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2);">
                                <i class="bi bi-check-circle-fill me-1"></i> SELESAI
                            </span>
                        @elseif($p->status == 'Menunggu Verifikasi')
                            <span class="badge px-3 py-2 rounded-pill" style="font-size: 0.7rem; font-weight: 800; background: rgba(245, 158, 11, 0.1); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.2);">
                                <i class="bi bi-hourglass-split me-1"></i> CEK FISIK
                            </span>
                        @else
                            <span class="badge px-3 py-2 rounded-pill" style="font-size: 0.7rem; font-weight: 800; background: rgba(59, 130, 246, 0.1); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.2);">
                                <i class="bi bi-book me-1"></i> DIPINJAM
                            </span>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <div class="action-group-wrapper">
                            @if(in_array($p->status, ['Dipinjam', 'Menunggu Verifikasi']))
                                <button type="button" class="btn-verify-primary" data-bs-toggle="modal" data-bs-target="#finalCheck{{ $p->id }}">
                                    Verifikasi
                                </button>
                            @endif

                            <div class="d-flex gap-2">
                                <button class="action-btn-pill btn-eye" data-bs-toggle="modal" data-bs-target="#detail{{ $p->id }}" title="Detail"><i class="bi bi-eye-fill"></i></button>
                                <a href="{{ route('admin.transaksi.edit_pengembalian', $p->id) }}" class="action-btn-pill btn-edit" title="Ubah Data"><i class="bi bi-pencil-square"></i></a>
                                <button class="action-btn-pill btn-trash" data-bs-toggle="modal" data-bs-target="#confirmDelete{{ $p->id }}" title="Hapus"><i class="bi bi-trash3-fill"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="finalCheck{{ $p->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body p-5 text-center">
                            <div class="mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2.5rem; background: #ecfdf5; color: #10b981; border-radius: 24px;">
                                <i class="bi bi-check2-all"></i>
                            </div>
                            <h4 class="mb-2">Konfirmasi Penerimaan</h4>
                            <p class="text-muted small">Pastikan buku dalam kondisi baik sebelum melakukan verifikasi.</p>
                            
                            <div class="bg-light-dark p-3 rounded-4 mb-4 text-start border" style="border-style: dashed !important;">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-muted">Nama Siswa:</span>
                                    <span class="fw-700 text-dark">{{ $p->user->nama ?? 'Siswa' }}</span>
                                </div>
                                <div class="d-flex justify-content-between small">
                                    <span class="text-muted">Judul Buku:</span>
                                    <span class="fw-700 text-dark text-truncate ms-3">{{ $p->buku->judul ?? 'Judul' }}</span>
                                </div>
                            </div>

                            <form action="{{ route('admin.transaksi.prosesKembali', $p->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 rounded-4 fw-bold py-3 shadow-sm border-0" style="background: #10b981;">
                                    Ya, Buku Sudah Diterima
                                </button>
                                <button type="button" class="btn btn-link text-decoration-none fw-bold py-2 text-muted mt-2" data-bs-dismiss="modal">
                                    Batal
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="detail{{ $p->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body p-5">
                            <div class="text-center mb-4">
                                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 85px; height: 85px; font-size: 2.2rem; border-radius: 22px; background: #3b82f6; color: white; box-shadow: 0 10px 30px rgba(59, 130, 246, 0.2);">
                                    {{ strtoupper(substr($p->user->nama ?? 'A', 0, 1)) }}
                                </div>
                                <h4 class="mb-1">{{ $p->user->nama ?? 'Siswa' }}</h4>
                            </div>

                            <div class="vstack gap-1 mt-4">
                                <div class="detail-row">
                                    <span class="text-muted fw-600 small"><i class="bi bi-book me-2 text-primary"></i> Judul Buku</span>
                                    <span class="fw-800 text-end text-dark" style="max-width: 180px; font-size: 0.9rem;">{{ $p->buku->judul ?? '-' }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="text-muted fw-600 small"><i class="bi bi-calendar-check me-2 text-info"></i> Tanggal Pinjam</span>
                                    <span class="fw-800 text-dark">{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="text-muted fw-600 small"><i class="bi bi-info-circle me-2 text-warning"></i> Status Saat Ini</span>
                                    <span class="fw-800 text-info" style="font-size: 0.8rem;">{{ strtoupper($p->status) }}</span>
                                </div>
                            </div>

                            <button class="btn btn-secondary w-100 rounded-4 fw-bold mt-4 py-3 border-0" style="background: #f1f5f9; color: #475569;" data-bs-dismiss="modal">
                                TUTUP BERKAS
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="confirmDelete{{ $p->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content">
                        <div class="modal-body p-4 text-center">
                            <div class="mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: #fef2f2; border-radius: 20px;">
                                <i class="bi bi-exclamation-triangle-fill text-danger fs-2"></i>
                            </div>
                            <h5 class="fw-800">Hapus Data?</h5>
                            <p class="text-muted small">Transaksi <strong>{{ $p->user->nama ?? 'Siswa' }}</strong> akan dihapus permanen.</p>
                            <form action="{{ route('admin.transaksi.destroy', $p->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100 rounded-3 fw-bold border-0 py-2" style="background: #ef4444;">Hapus Sekarang</button>
                                <button type="button" class="btn btn-link text-decoration-none text-muted fw-bold mt-2" data-bs-dismiss="modal">Batalkan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @empty
            <div class="text-center py-5">
                <div class="mb-3 opacity-25 text-white"><i class="bi bi-inbox fs-1"></i></div>
                <h6 class="fw-700 text-muted">Belum ada antrean pengembalian hari ini.</h6>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
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
    
    document.getElementById('masterSearch').addEventListener('input', function() {
        let q = this.value.toLowerCase();
        document.querySelectorAll('.searchable').forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(q) ? '' : 'none';
        });
    });
</script>
@endsection