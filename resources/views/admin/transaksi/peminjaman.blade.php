@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    .admin-catalog {
        --bg-body: #020617;
        --kaca: rgba(255, 255, 255, 0.03);
        --garis: rgba(255, 255, 255, 0.08);
        --teks-utama: #f1f5f9;
        --teks-muted: #94a3b8;
        --card-hover: rgba(255, 255, 255, 0.05);
        --emerald: #10b981;
        --ocean: #0ea5e9;
        --gradasi: linear-gradient(135deg, #10b981 0%, #0ea5e9 100%);
    }

    html[data-theme="light"] .admin-catalog {
        --bg-body: #f8fafc;
        --kaca: #ffffff;
        --garis: rgba(0, 0, 0, 0.05);
        --teks-utama: #0f172a;
        --teks-muted: #64748b;
        --card-hover: #f1f5f9;
    }

    .admin-catalog {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--bg-body);
        min-height: 100vh;
        padding: 40px 6%;
        color: var(--teks-utama);
        position: relative;
        transition: all 0.3s ease;
    }

    .latar-animasi {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        z-index: 0; 
        background: radial-gradient(circle at 50% 50%, var(--card-hover) 0%, var(--bg-body) 100%);
        pointer-events: none;
    }

    .main-container { position: relative; z-index: 10; max-width: 1400px; margin: auto; }

    .text-gradient {
        background: var(--gradasi);
        -webkit-background-clip: text;
        background-clip: text; 
        -webkit-text-fill-color: transparent;
        font-weight: 800;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 35px;
    }
    @media (min-width: 992px) { .stats-grid { grid-template-columns: repeat(4, 1fr); } }

    .stat-card {
        background: var(--kaca);
        backdrop-filter: blur(10px);
        border: 1px solid var(--garis);
        border-radius: 24px;
        padding: 24px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .stat-card:hover { 
        transform: translateY(-5px); 
        border-color: var(--emerald);
        background: var(--card-hover);
    }

    .stat-icon {
        width: 48px; height: 48px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 1.4rem;
        margin-bottom: 15px;
    }

    .table-card {
        background: var(--kaca);
        backdrop-filter: blur(20px);
        border-radius: 30px;
        padding: 25px;
        border: 1px solid var(--garis);
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    }

    .custom-table thead th {
        background: transparent;
        border-bottom: 2px solid var(--garis);
        padding: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--teks-muted);
        letter-spacing: 1px;
    }

    .custom-table tbody tr {
        border-bottom: 1px solid var(--garis);
        transition: 0.2s;
        color: var(--teks-utama);
    }
    .custom-table tbody tr:hover { background: var(--card-hover); }

    .select-pill {
        border: 1px solid var(--garis);
        padding: 8px 16px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
        appearance: none;
        text-align: center;
        background-color: var(--kaca);
    }
    .bg-tunggu { background: rgba(245, 158, 11, 0.1); color: #fbbf24; border-color: rgba(245, 158, 11, 0.2); }
    .bg-pinjam { background: rgba(16, 185, 129, 0.1); color: #34d399; border-color: rgba(16, 185, 129, 0.2); }
    .bg-tolak { background: rgba(239, 68, 68, 0.1); color: #f87171; border-color: rgba(239, 68, 68, 0.2); }

    .btn-circle {
        width: 38px; height: 38px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center; justify-content: center;
        background: var(--card-hover);
        color: var(--teks-muted);
        transition: 0.3s;
        border: 1px solid var(--garis);
    }
    .btn-circle:hover { background: var(--teks-utama); color: var(--bg-body); transform: scale(1.1); }
    .btn-del:hover { background: #ef4444 !important; color: white !important; border-color: #ef4444; }

    .btn-tambah {
        background: var(--gradasi);
        color: white !important;
        padding: 14px 28px;
        border-radius: 16px;
        border: none;
        font-weight: 700;
        text-decoration: none;
        transition: 0.3s;
    }

    .avatar-init {
        width: 42px; height: 42px;
        border-radius: 12px;
        background: var(--card-hover);
        color: var(--ocean);
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; border: 1px solid var(--garis);
    }

    .partikel {
        position: absolute; background: var(--emerald);
        border-radius: 50%; opacity: 0.1;
        animation: terbang linear infinite;
    }
    @keyframes terbang {
        from { transform: translateY(100vh); opacity: 0.2; }
        to { transform: translateY(-10vh); opacity: 0; }
    }

   .modal {
        z-index: 999999 !important;
    }

    .modal-dialog {
        position: relative;
        z-index: 1000000 !important;
    }

    .modal-backdrop {
        z-index: 999998 !important;
        background-color: rgba(0, 0, 0, 0.6) !important;
    }
    .modal-content {
        background-color: #1e293b !important; 
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        border-radius: 24px !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.9) !important;
        color: white !important;
        filter: none !important;
        backdrop-filter: none !important; 
    }

    .modal-body h5 {
        color: #ffffff !important;
        font-weight: 800 !important;
    }

    .modal-body p {
        color: #cbd5e1 !important; 
    }

    html[data-theme="light"] .modal-content {
        background-color: #ffffff !important;
        color: #0f172a !important;
        border: 1px solid #e2e8f0 !important;
    }
    html[data-theme="light"] .modal-body h5 {
        color: #0f172a !important;
    }
    html[data-theme="light"] .modal-body p {
        color: #64748b !important;
    }

    .input-alasan {
        background: rgba(255,255,255,0.05);
        border: 1px solid var(--garis);
        border-radius: 12px;
        color: white;
        padding: 12px;
        width: 100%;
        outline: none;
    }
    html[data-theme="light"] .input-alasan {
        background: #f1f5f9;
        color: #0f172a;
    }
</style>

<div class="admin-catalog">
    <div class="latar-animasi" id="particles-container"></div>

    <div class="main-container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-4 mb-5" style="position: relative; z-index: 1;">
            <div>
                <h1 class="text-gradient mb-1">Log Transaksi</h1>
                <p style="color: var(--teks-muted); font-weight: 500;" class="mb-0">Kelola sirkulasi koleksi perpustakaan Anda secara real-time.</p>
            </div>
            <a href="{{ route('admin.transaksi.create') }}" class="btn-tambah d-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i>
                <span>Transaksi Baru</span>
            </a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(245, 158, 11, 0.2); color: #fbbf24;"><i class="bi bi-clock-history"></i></div>
                <p style="color: var(--teks-muted)" class="small fw-700 mb-1">MENUNGGU</p>
                <h3 class="fw-800 mb-0" style="color: var(--teks-utama)">{{ $count_pending }}</h3>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.2); color: #34d399;"><i class="bi bi-journal-check"></i></div>
                <p style="color: var(--teks-muted)" class="small fw-700 mb-1">DIPINJAM</p>
                <h3 class="fw-800 mb-0" style="color: var(--teks-utama)">{{ $count_dipinjam }}</h3>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(239, 68, 68, 0.2); color: #f87171;"><i class="bi bi-journal-x"></i></div>
                <p style="color: var(--teks-muted)" class="small fw-700 mb-1">DITOLAK</p>
                <h3 class="fw-800 mb-0" style="color: var(--teks-utama)">{{ $peminjamans_admin->where('status', 'Ditolak')->count() }}</h3>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--garis); color: var(--teks-utama);"><i class="bi bi-database-fill"></i></div>
                <p style="color: var(--teks-muted)" class="small fw-700 mb-1">TOTAL DATA</p>
                <h3 class="fw-800 mb-0" style="color: var(--teks-utama)">{{ $peminjamans_admin->total() }}</h3>
            </div>
        </div>

        <div class="table-card">
            <div class="table-responsive">
                <table class="table custom-table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="ps-4">Peminjam</th>
                            <th>Buku & Detail</th> <th>Jatuh Tempo</th>
                            <th class="text-center">Status Transaksi</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans_admin as $p)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-init">{{ strtoupper(substr($p->user->nama, 0, 1)) }}</div>
                                    <div>
                                        <div class="fw-800 mb-0" style="color: var(--teks-utama)">{{ $p->user->nama }}</div>
                                        <div style="color: var(--teks-muted); font-size: 0.7rem;">NIS: {{ $p->user->nis }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-700 small" style="color: var(--teks-utama)">{{ \Str::limit($p->buku->judul, 35) }}</div>
                            </td>
                            <td>
                                <div class="fw-800 small" style="color: var(--teks-utama)">{{ date('d M Y', strtotime($p->tanggal_kembali)) }}</div>
                            </td>
                            <td class="text-center">
                                <form id="formStatus{{ $p->id }}" action="{{ route('admin.transaksi.updateStatus', $p->id) }}" method="POST" class="m-0">
                                    @csrf @method('PATCH')
                                    <select name="status" onchange="handleStatusChange(this, '{{ $p->id }}', '{{ $p->status }}')" 
                                        class="select-pill 
                                        @if($p->status == 'Menunggu Pinjam') bg-tunggu 
                                        @elseif($p->status == 'Dipinjam') bg-pinjam 
                                        @else bg-tolak @endif">
                                        <option value="Menunggu Pinjam" {{ $p->status == 'Menunggu Pinjam' ? 'selected' : '' }}>MENUNGGU</option>
                                        <option value="Dipinjam" {{ $p->status == 'Dipinjam' ? 'selected' : '' }}>DIPINJAM</option>
                                        <option value="Ditolak" {{ $p->status == 'Ditolak' ? 'selected' : '' }}>DITOLAK</option>
                                    </select>
                                </form>
                            </td>
                            <td class="pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.transaksi.edit', $p->id) }}" class="btn-circle" title="Edit">
                                        <i class="bi bi-pencil-fill" style="font-size: 0.9rem;"></i>
                                    </a>
                                    <button type="button" class="btn-circle btn-del" title="Hapus" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $p->id }}">
                                        <i class="bi bi-trash3-fill" style="font-size: 0.9rem;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-5" style="color: var(--teks-muted)">Tidak ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $peminjamans_admin->links() }}
            </div>
        </div>
    </div>
</div>

{{-- MODAL HAPUS --}}
@foreach($peminjamans_admin as $p)
<div class="modal fade" id="modalHapus{{ $p->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-body p-4 text-center">
                <div class="mb-4">
                    <div style="width: 65px; height: 65px; background: rgba(239, 68, 68, 0.2); border-radius: 22px; display: flex; align-items: center; justify-content: center; margin: 0 auto; border: 1px solid rgba(239, 68, 68, 0.3);">
                        <i class="bi bi-trash3-fill text-danger" style="font-size: 1.8rem;"></i>
                    </div>
                </div>
                
                <h5 class="mb-2">Hapus Transaksi?</h5>
                <p class="small mb-4 px-2">Data peminjaman milik <b>{{ $p->user->nama }}</b> akan dihapus permanen.</p>
                
                <div class="d-grid gap-2">
                    <form action="{{ route('admin.transaksi.destroy', $p->id) }}" method="POST" class="m-0">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100 fw-bold py-2" style="border-radius: 16px; background: #ef4444; border: none;">
                            Ya, Hapus Sekarang
                        </button>
                    </form>
                    <button type="button" class="btn btn-link text-decoration-none text-muted fw-bold mt-2" data-bs-dismiss="modal">
                        BATALKAN
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL REJECT (BARU) --}}
<div class="modal fade" id="modalReject{{ $p->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-body p-4">
                <h5 class="mb-3">Alasan Penolakan</h5>
                <form action="{{ route('admin.transaksi.reject', $p->id) }}" method="POST">
                    @csrf
                    <textarea name="alasan_tolak" class="input-alasan mb-3" rows="3" placeholder="Contoh: Stok buku rusak atau NIS tidak valid..." required></textarea>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-danger fw-bold py-2" style="border-radius: 12px;">Kirim Penolakan</button>
                        <button type="button" class="btn btn-link text-muted fw-bold" onclick="cancelReject('{{ $p->id }}', '{{ $p->status }}')" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
    // Fungsi untuk handle perubahan status
    function handleStatusChange(selectElement, id, oldStatus) {
        if (selectElement.value === 'Ditolak') {
            const modalReject = new bootstrap.Modal(document.getElementById('modalReject' + id));
            modalReject.show();
        } else {
            selectElement.form.submit();
        }
    }

    function cancelReject(id, oldStatus) {
        const select = document.querySelector(`#formStatus${id} select`);
        select.value = oldStatus;
    }

    const msgSuccess = "{{ session('success') }}";
    const msgError = "{{ session('error') }}";
    const msgInfo = "{{ session('info') }}";

    const getThemeConfig = () => {
        const isLight = document.documentElement.getAttribute('data-theme') === 'light';
        return {
            background: isLight ? '#ffffff' : 'rgba(15, 23, 42, 0.95)',
            color: isLight ? '#1e293b' : '#ffffff',
            confirmButtonColor: '#10b981',
            backdrop: isLight ? 'rgba(0,0,0,0.2)' : 'rgba(2, 6, 23, 0.7)'
        };
    };

    if (msgSuccess) {
        const config = getThemeConfig();
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: msgSuccess,
            background: config.background,
            color: config.color,
            confirmButtonColor: config.confirmButtonColor
        });
    }

    if (msgError) {
        const config = getThemeConfig();
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: msgError,
            background: config.background,
            color: config.color,
            confirmButtonColor: '#ef4444'
        });
    }

    if (msgInfo) {
        const config = getThemeConfig();
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            text: msgInfo,
            background: config.background,
            color: config.color,
            confirmButtonColor: '#0ea5e9'
        });
    }
    
    const container = document.getElementById('particles-container');
    if(container) {
        for (let i = 0; i < 15; i++) {
            const p = document.createElement('div');
            p.className = 'partikel';
            p.style.left = Math.random() * 100 + 'vw';
            const size = Math.random() * 3 + 2 + 'px';
            p.style.width = size;
            p.style.height = size;
            p.style.animationDuration = Math.random() * 10 + 10 + 's';
            p.style.animationDelay = Math.random() * 5 + 's';
            container.appendChild(p);
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.modal').forEach(modal => {
            document.body.appendChild(modal);
        });
    });
</script>
@endsection