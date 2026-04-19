@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    .admin-catalog {
        --bg-body: #020617;
        --card-bg: rgba(255, 255, 255, 0.03);
        --card-bg-hover: rgba(255, 255, 255, 0.08);
        --text-main: #f1f5f9;
        --text-pure: #ffffff;
        --text-muted: #94a3b8;
        --garis: rgba(255, 255, 255, 0.1);
        --bg-radial: radial-gradient(circle at 50% 50%, #0f172a 0%, #020617 100%);
        --bg-table-row: rgba(255, 255, 255, 0.02);
        
        --emerald: #10b981;
        --ocean: #0ea5e9;
        --gradasi: linear-gradient(135deg, #10b981 0%, #0ea5e9 100%);
    }

    html[data-theme="light"] .admin-catalog {
        --bg-body: #f8fafc;
        --card-bg: #ffffff;
        --card-bg-hover: #f1f5f9;
        --text-main: #1e293b;
        --text-pure: #0f172a;
        --text-muted: #64748b;
        --garis: rgba(0, 0, 0, 0.08);
        --bg-radial: radial-gradient(circle at 50% 50%, #f1f5f9 0%, #f8fafc 100%);
        --bg-table-row: #ffffff;
    }

    .admin-catalog {
        font-family: 'Plus Jakarta Sans', sans-serif;
        padding: 1.5rem;
        background-color: var(--bg-body);
        min-height: 100vh;
        color: var(--text-main);
        position: relative;
        transition: background-color 0.3s ease;
    }

    @media (min-width: 768px) {
        .admin-catalog { padding: 2.5rem; }
    }

    .latar-animasi {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        z-index: 0; background: var(--bg-radial);
        pointer-events: none;
        transition: background 0.3s ease;
    }

    .container-fluid { position: relative; z-index: 10; }

    .stats-bar {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .stat-card {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 24px;
        border: 1px solid var(--garis);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: 0.3s;
    }
    .stat-card:hover { transform: translateY(-5px); background: var(--card-bg-hover); }

    .stat-icon {
        width: 50px; height: 50px;
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .header-section {
        background: var(--card-bg);
        backdrop-filter: blur(12px);
        padding: 2.5rem;
        border-radius: 30px;
        border: 1px solid var(--garis);
        margin-bottom: 2rem;
    }

    .text-gradient {
        background: var(--gradasi);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
    }

    .search-container { position: relative; max-width: 500px; }
    .search-container i {
        position: absolute; left: 20px; top: 50%;
        transform: translateY(-50%);
        color: var(--emerald);
        font-size: 1.2rem;
    }

    .search-input {
        height: 60px;
        border-radius: 20px;
        padding-left: 60px;
        border: 1px solid var(--garis);
        background: var(--card-bg) !important;
        color: var(--text-main) !important;
        font-weight: 600;
        transition: 0.4s;
    }

    .table-wrapper {
        background: var(--card-bg);
        backdrop-filter: blur(10px);
        border-radius: 32px;
        padding: 1rem;
        border: 1px solid var(--garis);
    }

    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
        color: var(--text-main);
    }

    .custom-table thead th {
        padding: 1.5rem;
        color: var(--text-pure) !important; 
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 800;
        border: none;
    }

    .custom-table tbody tr td {
        background: var(--bg-table-row);
        padding: 1.5rem 1rem;
        border-top: 1px solid var(--garis);
        border-bottom: 1px solid var(--garis);
        transition: 0.3s;
    }

    @media (max-width: 991.98px) {
        .custom-table thead { display: none; }
        .custom-table, .custom-table tbody, .custom-table tr, .custom-table td { 
            display: block; width: 100%; 
        }
        .custom-table tr {
            margin-bottom: 1.5rem;
            background: var(--card-bg-hover);
            border-radius: 25px;
            padding: 1rem;
            border: 1px solid var(--garis);
        }
        .custom-table td {
            text-align: right;
            padding: 0.8rem 0.5rem;
            border: none !important;
            background: transparent !important;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .custom-table td::before {
            content: attr(data-label);
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            font-size: 0.7rem;
        }
    }

    .role-badge {
        padding: 8px 16px; border-radius: 12px; font-size: 10px; font-weight: 800;
    }
    .role-admin { background: rgba(244, 63, 94, 0.1); color: #f43f5e; border: 1px solid rgba(244, 63, 94, 0.2); }
    .role-user { background: rgba(16, 185, 129, 0.1); color: var(--emerald); border: 1px solid rgba(16, 185, 129, 0.2); }

    .btn-modern {
        width: 40px; height: 40px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        border: 1px solid var(--garis); background: var(--card-bg); color: var(--text-main);
    }
    .btn-add-main {
        background: var(--gradasi); color: white !important; padding: 1rem 2rem;
        border-radius: 18px; font-weight: 700; text-decoration: none;
    }

    .partikel {
        position: absolute; background: var(--emerald);
        border-radius: 50%; opacity: 0;
        animation: terbang linear infinite;
    }
    @keyframes terbang {
        0% { transform: translateY(100vh) scale(0.5); opacity: 0; }
        50% { opacity: 0.3; }
        100% { transform: translateY(-10vh) scale(1.2); opacity: 0; }
    }

    .pagination-modern svg {
        display: none !important;
    }

    .pagination-modern .pagination {
        display: flex !important;
        gap: 8px;
        margin: 0;
        padding: 6px;
        background: rgba(255, 255, 255, 0.02); 
        border: 1px solid var(--garis);
        border-radius: 16px;
        list-style: none;
    }

    .pagination-modern .page-item .page-link {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--card-bg);
        border: 1px solid var(--garis);
        color: var(--text-muted);
        font-weight: 700;
        font-size: 0.9rem;
        border-radius: 12px !important;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }

    .pagination-modern .page-item .page-link:hover {
        background: rgba(14, 165, 233, 0.1);
        color: var(--ocean);
        border-color: var(--ocean);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(14, 165, 233, 0.2);
    }

    .pagination-modern .page-item.active .page-link {
        background: var(--gradasi) !important;
        color: white !important;
        border: none !important;
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }

    .pagination-modern .page-item:first-child .page-link,
    .pagination-modern .page-item:last-child .page-link {
        width: auto;
        padding: 0 18px !important;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .pagination-modern nav div:first-child {
        display: none !important;
    }
    .pagination-modern nav {
        display: flex !important;
        justify-content: center;
    }

    .record-info-badge {
        background: linear-gradient(to right, rgba(16, 185, 129, 0.05), rgba(14, 165, 233, 0.05));
        border: 1px solid var(--garis);
        padding: 10px 20px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .modal-backdrop { z-index: 1040 !important; }
    .modal { z-index: 1050 !important; }
    body.modal-open .admin-catalog { filter: none !important; backdrop-filter: none !important; }

    .modal-content {
        background: var(--card-bg) !important;
        backdrop-filter: blur(30px) !important;
        color: var(--text-pure) !important;
        border: 1px solid var(--garis) !important;
        border-radius: 28px !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
    }

    .modal.fade .modal-dialog {
        transform: scale(0.9) translateY(20px);
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .modal.show .modal-dialog {
        transform: scale(1) translateY(0);
    }

    .btn-danger-mewah {
        background: #f43f5e !important;
        color: white !important;
        border-radius: 16px;
        font-weight: 800;
        padding: 12px;
        border: none;
        transition: 0.3s;
    }
    .btn-danger-mewah:hover {
        background: #e11d48 !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(244, 63, 94, 0.3);
    }

    .modal-content {
        background: var(--card-bg) !important;
        backdrop-filter: blur(15px) !important;
        -webkit-backdrop-filter: blur(15px) !important;
        border: 1px solid var(--garis) !important;
        color: var(--text-main) !important;
    }

    .modal-body h5, .modal-body b {
        color: var(--text-pure) !important;
    }

    .modal {
        z-index: 1060 !important;
    }
</style>

<div class="admin-catalog">
    <div class="latar-animasi" id="particles-container"></div>
    
    <div class="container-fluid">
        <div class="stats-bar">
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--gradasi);"><i class="bi bi-people"></i></div>
                <div>
                    <div class="fw-800 fs-4 mb-0" style="color: var(--text-pure)">{{ $siswas->count() }}</div>
                    <small style="color: var(--text-muted)" class="fw-bold">Total Anggota</small>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #f43f5e;"><i class="bi bi-shield-lock"></i></div>
                <div>
                    <div class="fw-800 fs-4 mb-0" style="color: var(--text-pure)">{{ $siswas->filter(fn($user) => strtolower($user->role) == 'admin')->count() }}</div>
                    <small style="color: var(--text-muted)" class="fw-bold">Administrator</small>
                </div>
            </div>
        </div>

        <div class="header-section d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
            <div>
                <h1 class="fw-800 mb-1" style="color: var(--text-pure)">Pusat <span class="text-gradient">Kendali Anggota</span></h1>
                <p style="color: var(--text-muted)" class="mb-0 fw-500">Kelola hak akses pengguna dalam satu sistem terpadu.</p>
            </div>
            <a href="{{ route('anggota.create') }}" class="btn-add-main">
                <i class="bi bi-plus-lg me-2"></i>Tambah Anggota Baru
            </a>
        </div>

        <div class="mb-4">
            <div class="search-container">
                <i class="bi bi-search"></i>
                <input type="text" id="memberSearch" class="form-control search-input" placeholder="Cari Anggota...">
            </div>
        </div>

        <div class="table-wrapper">
            <div class="table-responsive">
                <table class="table custom-table align-middle" id="memberTable">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Identitas Lengkap</th>
                            <th>NIS</th>
                            <th class="text-center">L/P</th>
                            <th>Email</th>
                            <th class="text-center">Kelas</th>
                            <th class="text-center">Hak Akses</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $index => $siswa)
                        <tr>
                            <td data-label="No" class="text-center fw-800" style="color: var(--text-main); opacity: 0.5;">
                                {{ ($siswas->currentPage() - 1) * $siswas->perPage() + $loop->iteration }}
                            </td>
                            <td data-label="Identitas Lengkap"><span style="font-weight: 800; color: var(--text-pure);">{{ $siswa->nama }}</span></td>
                            <td data-label="NIS">
                                <span class="badge bg-dark text-white fw-800 border-secondary border" style="font-size: 11px; border-radius: 8px; padding: 6px 12px;">
                                    {{ $siswa->nis ?? '---' }}
                                </span>
                            </td>
                            <td data-label="L/P" class="text-center fw-800 {{ $siswa->jenis_kelamin == 'Laki-laki' ? 'text-info' : 'text-danger' }}">
                                {{ $siswa->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}
                            </td>
                            <td data-label="Email"><a href="mailto:{{ $siswa->email }}" style="color: var(--ocean); text-decoration: none; font-weight: 600;">{{ $siswa->email }}</a></td>
                            <td data-label="Kelas" class="text-center fw-800" style="color: var(--text-pure)">{{ $siswa->kelas ?? '-' }}</td>
                            <td data-label="Hak Akses" class="text-center">
                                <span class="role-badge {{ strtolower($siswa->role) == 'admin' ? 'role-admin' : 'role-user' }}">
                                    {{ strtoupper($siswa->role) }}
                                </span>
                            </td>
                            <td data-label="Aksi" class="text-center">
                                <div class="btn-action-group d-flex gap-2 justify-content-center">
                                    <a href="{{ route('anggota.edit', $siswa->id) }}" class="btn-modern"><i class="bi bi-pencil-fill"></i></a>
                                    <button type="button" class="btn-modern" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $siswa->id }}">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center py-5" style="color: var(--text-muted)">Data tidak ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="card-footer d-flex flex-column flex-md-row justify-content-between align-items-center px-4 py-4 border-0" style="background: transparent; border-top: 1px solid var(--garis) !important;">
    
                    <div class="record-info-badge mb-3 mb-md-0">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width: 8px; height: 8px; border-radius: 50%; background: var(--emerald); box-shadow: 0 0 10px var(--emerald);"></div>
                            <span style="color: var(--text-muted); font-size: 0.7rem; font-weight: 800; letter-spacing: 0.5px;">
                                SHOWING <span style="color: var(--text-pure)">{{ $siswas->firstItem() ?? 0 }}</span> 
                                TO <span style="color: var(--text-pure)">{{ $siswas->lastItem() ?? 0 }}</span>
                            </span>
                        </div>
                        <div style="width: 1px; height: 15px; background: var(--garis);"></div>
                        <span style="color: var(--text-muted); font-size: 0.7rem; font-weight: 800;">
                            TOTAL <span style="color: var(--ocean)">{{ $siswas->total() }}</span> MEMBERS
                        </span>
                    </div>

                    <div class="pagination-modern">
                        {{ $siswas->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL HAPUS --}}
@foreach($siswas as $item)
<div class="modal fade" id="modalHapus{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: 24px;">
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <i class="bi bi-trash3-fill text-danger" style="font-size: 3.5rem; opacity: 0.2; position: absolute; left: 50%; transform: translateX(-50%) translateY(-10px);"></i>
                    <i class="bi bi-exclamation-circle-fill text-danger position-relative" style="font-size: 3rem;"></i>
                </div>
                
                <h5 class="fw-800 mt-2">Konfirmasi Hapus</h5>
                <p class="text-muted small">Apakah Anda yakin ingin menghapus <b>{{ $item->nama }}</b>? Tindakan ini tidak dapat dibatalkan.</p>
                
                <div class="d-grid gap-2 mt-4">
                    <form action="{{ route('anggota.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100 fw-bold py-2" style="border-radius: 12px;">
                            Ya, Hapus Anggota
                        </button>
                    </form>
                    <button type="button" class="btn btn-light w-100 fw-bold py-2" data-bs-dismiss="modal" style="border-radius: 12px;">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
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
            confirmButtonColor: '#10b981', 
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
    
    const allModals = document.querySelectorAll('.modal');
    allModals.forEach(modal => {
        document.body.appendChild(modal);
    });

    const container = document.getElementById('particles-container');
    for (let i = 0; i < 25; i++) {
        const p = document.createElement('div');
        p.className = 'partikel';
        p.style.left = Math.random() * 100 + 'vw';
        const size = Math.random() * 3 + 2 + 'px';
        p.style.width = size; p.style.height = size;
        p.style.animationDuration = Math.random() * 8 + 5 + 's';
        p.style.animationDelay = Math.random() * 5 + 's';
        container.appendChild(p);
    }

    document.getElementById('memberSearch').addEventListener('keyup', function() {
        let keyword = this.value.toLowerCase();
        let rows = document.querySelectorAll('#memberTable tbody tr');
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none';
        });
    });
</script>
@endsection