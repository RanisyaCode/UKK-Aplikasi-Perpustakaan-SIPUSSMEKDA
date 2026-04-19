@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .edit-container {
        --edit-bg: transparent;
        --card-bg: rgba(15, 23, 42, 0.7);
        --text-title: #ffffff;
        --text-muted: #94a3b8;
        --input-bg: rgba(255, 255, 255, 0.03);
        --input-border: rgba(255, 255, 255, 0.1);
        --input-text: #f8fafc;
        --shadow: 0 40px 100px -20px rgba(0,0,0,0.5);
    }

    html[data-theme="light"] .edit-container {
        --edit-bg: #f8fafc;
        --card-bg: #ffffff;
        --text-title: #0f172a;
        --text-muted: #64748b;
        --input-bg: #f1f5f9;
        --input-border: rgba(15, 23, 42, 0.08);
        --input-text: #0f172a;
        --shadow: 0 20px 50px rgba(0,0,0,0.05);
    }

    .edit-container {
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2.5rem;
        background: var(--edit-bg);
        transition: all 0.3s ease;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .edit-card-modern {
        width: 100%;
        max-width: 650px;
        background: var(--card-bg);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 35px;
        padding: 3.5rem;
        box-shadow: var(--shadow);
        border: 1px solid var(--input-border);
        position: relative;
    }

    .edit-card-modern::after {
        content: "";
        position: absolute;
        top: -2px; left: -2px; right: -2px; bottom: -2px;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(59, 130, 246, 0.2));
        border-radius: 35px;
        z-index: -1;
    }

    .book-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 15px;
        max-height: 350px;
        overflow-y: auto;
        padding: 10px;
        background: rgba(0,0,0,0.05);
        border-radius: 20px;
        border: 1px solid var(--input-border);
    }

    .book-grid.is-invalid {
        border-color: #ef4444 !important;
    }

    .book-option-card {
        position: relative;
        cursor: pointer;
    }

    .book-option-card input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .book-content {
        background: var(--input-bg);
        border: 2px solid transparent;
        border-radius: 20px;
        padding: 10px;
        text-align: center;
        transition: 0.3s;
        height: 100%;
    }

    .book-cover-img {
        width: 100%;
        aspect-ratio: 3/4;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .book-option-card input:checked ~ .book-content {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.1);
    }

    .check-badge {
        position: absolute;
        top: 15px; right: 15px;
        background: #10b981;
        color: white;
        border-radius: 50%;
        width: 22px; height: 22px;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        z-index: 2;
    }

    .book-option-card input:checked ~ .check-badge {
        display: flex;
    }

    .book-title-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--text-title);
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .form-group-custom { margin-bottom: 1.8rem; }
    .form-label-custom {
        font-weight: 800;
        color: #10b981;
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-left: 10px;
        margin-bottom: 8px;
        display: block;
        opacity: 0.9;
    }

    .form-control-modern {
        border-radius: 16px;
        padding: 12px 20px;
        border: 1px solid var(--input-border);
        font-weight: 600;
        background: var(--input-bg);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        color: var(--input-text);
        font-size: 0.9rem;
    }

    .form-control-modern.is-invalid {
        border-color: #ef4444 !important;
    }

    .form-control-modern:focus {
        border-color: #10b981;
        box-shadow: 0 0 20px rgba(16, 185, 129, 0.15);
        outline: none;
    }

    .btn-update-grad {
        background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
        border: none;
        padding: 16px;
        border-radius: 18px;
        color: white !important;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.4s;
        box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4);
    }

    .btn-update-grad:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 35px -10px rgba(16, 185, 129, 0.5);
    }

    .icon-box {
        width: 55px; height: 55px;
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.2rem;
        font-size: 1.5rem;
    }

    /* FONT KECIL MERAH UNTUK VALIDASI */
    .text-danger-custom {
        font-size: 0.75rem;
        color: #ef4444;
        font-weight: 600;
        margin-top: 5px;
        margin-left: 10px;
        display: block;
    }

    html[data-theme="dark"] input[type="date"]::-webkit-calendar-picker-indicator { filter: invert(1); }
</style>

<div class="edit-container">
    <div class="edit-card-modern">
        <div class="text-center mb-5">
            <div class="icon-box">
                <i class="bi bi-pencil-square"></i>
            </div>
            <h3 class="fw-800" style="color: var(--text-title); letter-spacing: -1px;">Modifikasi Data</h3>
            <p style="color: var(--text-muted);" class="small fw-500">ID Transaksi Validasi #{{ $transaksi->id }}</p>
        </div>

        <form action="{{ route('admin.transaksi.update', $transaksi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group-custom">
                <label class="form-label-custom">Nama Peminjam</label>
                <div class="position-relative">
                    <input type="hidden" name="user_id" value="{{ $transaksi->user_id }}">
                    <input type="text" class="form-control-modern w-100" value="{{ $transaksi->user->nama ?? 'Siswa' }}" disabled>
                    <i class="bi bi-person position-absolute" style="right: 20px; top: 12px; color: #475569;"></i>
                </div>
            </div>

            <div class="form-group-custom">
                <label class="form-label-custom">Pilih Koleksi Buku</label>
                <div class="book-grid p-3 @error('buku_id') is-invalid @enderror">
                    @foreach($bukus as $b)
                    <label class="book-option-card">
                        <input type="radio" name="buku_id" value="{{ $b->id }}" {{ old('buku_id', $transaksi->buku_id) == $b->id ? 'checked' : '' }}>
                        <div class="check-badge"><i class="bi bi-check-lg"></i></div>
                        <div class="book-content">
                            @php
                                $coverPath = $b->cover ? asset('storage/covers/' . $b->cover) : asset('assets/images/no-cover.jpg');
                            @endphp
                            <img src="{{ $coverPath }}" alt="{{ $b->judul }}" class="book-cover-img" onerror="this.src='https://via.placeholder.com/150x200?text=Buku'">
                            <span class="book-title-label">{{ $b->judul }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('buku_id')
                    <span class="text-danger-custom"><i class="bi bi-exclamation-circle me-1"></i>Buku wajib dipilih!</span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 form-group-custom">
                    <label class="form-label-custom">Tgl Pinjam</label>
                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="form-control-modern w-100 @error('tanggal_pinjam') is-invalid @enderror" value="{{ old('tanggal_pinjam', $transaksi->tanggal_pinjam) }}">
                    @error('tanggal_pinjam')
                        <span class="text-danger-custom"><i class="bi bi-exclamation-circle me-1"></i>Tanggal pinjam wajib diisi!</span>
                    @enderror
                </div>
                <div class="col-md-6 form-group-custom">
                    <label class="form-label-custom">Tgl Kembali (Otomatis +7)</label>
                    <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control-modern w-100 @error('tanggal_kembali') is-invalid @enderror" value="{{ old('tanggal_kembali', $transaksi->tanggal_kembali) }}">
                    @error('tanggal_kembali')
                        <span class="text-danger-custom"><i class="bi bi-exclamation-circle me-1"></i>Tanggal kembali wajib diisi!</span>
                    @enderror
                </div>
            </div>

            <div class="form-group-custom">
                <label class="form-label-custom">Update Status Transaksi</label>
                <select name="status" class="form-control-modern w-100 shadow-sm @error('status') is-invalid @enderror" style="border-left: 5px solid #3b82f6;">
                    <option value="Dipinjam" {{ old('status', $transaksi->status) == 'Dipinjam' ? 'selected' : '' }}>
                        📖 Sedang Dipinjam
                    </option>
                    <option value="Menunggu Verifikasi" {{ old('status', $transaksi->status) == 'Menunggu Verifikasi' ? 'selected' : '' }}>
                        ⏳ Menunggu Verifikasi
                    </option>
                    <option value="Sudah Dikembalikan" {{ old('status', $transaksi->status) == 'Sudah Dikembalikan' ? 'selected' : '' }}>
                        ✅ Sudah Dikembalikan
                    </option>
                    <option value="Ditolak" {{ old('status', $transaksi->status) == 'Ditolak' ? 'selected' : '' }}>
                        ❌ Ditolak / Dibatalkan
                    </option>
                </select>
                @error('status')
                    <span class="text-danger-custom"><i class="bi bi-exclamation-circle me-1"></i>Status harus dipilih!</span>
                @enderror
            </div>

            <div class="form-group-custom mb-4">
                <label class="form-label-custom">Catatan Admin</label>
                <textarea name="catatan" class="form-control-modern w-100 @error('catatan') is-invalid @enderror" rows="3" placeholder="Contoh: Buku rusak, atau Alasan ditolak...">{{ old('catatan', $transaksi->catatan) }}</textarea>
                @error('catatan')
                    <span class="text-danger-custom"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span>
                @enderror
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-update-grad">
                    <i class="bi bi-save2 me-2"></i> Update Perubahan
                </button>
                <a href="{{ route('admin.transaksi.pengembalian') }}" class="btn btn-link text-decoration-none fw-700 mt-2 small" style="color: var(--text-muted);">
                    <i class="bi bi-x-circle me-1"></i> Batalkan Operasi
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputPinjam = document.getElementById('tanggal_pinjam');
        const inputKembali = document.getElementById('tanggal_kembali');

        inputPinjam.addEventListener('change', function() {
            if (this.value) {
                let date = new window.Date(this.value);
                date.setDate(date.getDate() + 7);
                
                let year = date.getFullYear();
                let month = String(date.getMonth() + 1).padStart(2, '0');
                let day = String(date.getDate()).padStart(2, '0');
                
                inputKembali.value = `${year}-${month}-${day}`;
            }
        });
    });

    const msgSuccess = "{{ session('success') }}";
    const msgError = "{{ session('error') }}";
    const msgInfo = "{{ session('info') }}";

    if (msgSuccess) Swal.fire({ icon: 'success', title: 'Berhasil!', text: msgSuccess, timer: 3000, showConfirmButton: false });
    if (msgError) Swal.fire({ icon: 'error', title: 'Gagal!', text: msgError, showConfirmButton: true });
    if (msgInfo) Swal.fire({ icon: 'info', title: 'Informasi', text: msgInfo, showConfirmButton: true });

    const selected = document.querySelector('input[type="radio"]:checked');
    if (selected) {
        selected.closest('.book-option-card').scrollIntoView({ block: 'nearest', behavior: 'smooth' });
    }
</script>
@endsection