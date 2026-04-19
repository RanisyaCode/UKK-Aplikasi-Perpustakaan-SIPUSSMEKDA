@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .admin-content-area {
        --card-bg-local: rgba(15, 23, 42, 0.7);
        --input-bg-local: rgba(255, 255, 255, 0.03);
        --input-border-local: rgba(255, 255, 255, 0.08);
        --text-main-local: #f8fafc;
        --text-muted-local: #94a3b8;
        --card-buku-bg: rgba(255, 255, 255, 0.05);
        
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 40px 20px;
        min-height: 80vh;
        background: transparent;
        transition: all 0.3s ease;
    }

    html[data-theme="light"] .admin-content-area {
        --card-bg-local: #ffffff;
        --input-bg-local: #f1f5f9;
        --input-border-local: rgba(15, 23, 42, 0.08);
        --text-main-local: #0f172a;
        --text-muted-local: #64748b;
        --card-buku-bg: #ffffff;
    }

    .edit-card-slim {
        background: var(--card-bg-local);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        width: 100%;
        max-width: 600px;
        border-radius: 32px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
        border: 1px solid var(--input-border-local);
        position: relative;
    }

    .card-head-grad {
        background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
        padding: 30px;
        text-align: center;
        color: white;
        border-radius: 32px 32px 0 0;
    }

    .icon-badge {
        width: 50px; height: 50px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        display: inline-flex; align-items: center; justify-content: center;
        margin-bottom: 15px;
        border: 1px solid rgba(255,255,255,0.3);
    }

    .form-wrapper { padding: 35px; }

    .mini-tag {
        font-size: 0.7rem;
        font-weight: 800;
        color: #10b981;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 10px;
        display: block;
    }

    .input-box-custom {
        background: var(--input-bg-local);
        border: 1px solid var(--input-border-local);
        border-radius: 16px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 5px;
        transition: 0.3s;
    }

    .input-error-border { border-color: #ef4444 !important; }

    .error-text {
        color: #ef4444;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 15px;
        margin-left: 5px;
        display: block;
    }

    .input-box-custom input, .input-box-custom select, .input-box-custom textarea {
        border: none; outline: none; width: 100%; background: transparent;
        font-weight: 600; font-size: 14px; color: var(--text-main-local);
    }

    .buku-selector-container {
        background: var(--input-bg-local);
        border-radius: 20px;
        padding: 15px;
        border: 1px solid var(--input-border-local);
        margin-bottom: 5px;
    }

    .buku-grid-edit {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
        gap: 12px;
        max-height: 220px;
        overflow-y: auto;
        padding: 5px;
    }

    .buku-card-mini {
        background: var(--card-buku-bg);
        border-radius: 14px;
        padding: 8px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: 0.3s;
        text-align: center;
        position: relative;
    }

    .buku-card-mini.selected {
        border-color: #10b981;
        background: rgba(16, 185, 129, 0.1);
    }

    .buku-card-mini.selected::after {
        content: "\F26E"; font-family: "bootstrap-icons";
        position: absolute; top: 5px; right: 5px;
        color: #10b981; font-size: 14px;
        background: white; border-radius: 50%; width: 18px; height: 18px;
        display: flex; align-items: center; justify-content: center;
    }

    .mini-cover {
        width: 100%; aspect-ratio: 3/4;
        border-radius: 8px; object-fit: cover;
        margin-bottom: 6px; background: #334155;
    }

    .mini-judul {
        font-size: 0.7rem; font-weight: 700;
        color: var(--text-main-local);
        display: -webkit-box; 
        -webkit-line-clamp: 1; 
        line-clamp: 1; 
        -webkit-box-orient: vertical; 
        overflow: hidden;
    }

    .input-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }

    .btn-save-grad {
        background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
        color: white; border: none; width: 100%; padding: 16px;
        border-radius: 18px; font-weight: 800; font-size: 0.9rem;
        text-transform: uppercase; letter-spacing: 1px; cursor: pointer;
        transition: all 0.4s; box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4);
    }

    .btn-save-grad:hover { transform: translateY(-3px); box-shadow: 0 20px 30px -10px rgba(16, 185, 129, 0.5); }

    .btn-cancel-flat {
        display: block; text-align: center; margin-top: 18px;
        color: var(--text-muted-local); text-decoration: none;
        font-size: 13px; font-weight: 600; transition: 0.3s;
    }

    .buku-grid-edit::-webkit-scrollbar { width: 4px; }
    .buku-grid-edit::-webkit-scrollbar-thumb { background: #10b981; border-radius: 10px; }
</style>

<div class="admin-content-area">
    <div class="edit-card-slim">
        <div class="card-head-grad">
            <div class="icon-badge">
                <i class="bi bi-pencil-square fs-4"></i>
            </div>
            <h5 class="m-0 fw-bold">Edit Transaksi</h5>
            <p class="m-0 opacity-75 small">ID VALIDASI: #{{ $p->id }}</p>
        </div>

        <div class="form-wrapper">
            <form action="{{ route('admin.transaksi.update', $p->id) }}" method="POST">
                @csrf 
                @method('PUT')

                <div class="input-grid-2">
                    <div>
                        <label class="mini-tag">Nama Siswa</label>
                        <div class="input-box-custom" style="opacity: 0.6; cursor: not-allowed;">
                            <i class="bi bi-person"></i>
                            <input type="text" value="{{ $p->user->nama }}" disabled>
                        </div>
                    </div>
                    <div>
                        <label class="mini-tag">NIS</label>
                        <div class="input-box-custom" style="opacity: 0.6; cursor: not-allowed;">
                            <i class="bi bi-hash"></i>
                            <input type="text" value="{{ $p->user->nis }}" disabled>
                        </div>
                    </div>
                </div>

                <label class="mini-tag">Update Koleksi Buku</label>
                <div class="buku-selector-container {{ $errors->has('buku_id') ? 'input-error-border' : '' }}">
                    <div class="input-box-custom mb-3" style="margin-bottom: 10px !important;">
                        <i class="bi bi-search"></i>
                        <input type="text" id="filterBuku" placeholder="Cari judul koleksi...">
                    </div>
                    <div class="buku-grid-edit" id="bukuGrid">
                        @foreach($bukus as $buku)
                        <div class="buku-card-mini {{ (old('buku_id', $p->buku_id) == $buku->id) ? 'selected' : '' }}" 
                             data-id="{{ $buku->id }}" 
                             data-judul="{{ strtolower($buku->judul) }}">
                            <img src="{{ asset('storage/covers/' . $buku->cover) }}" class="mini-cover" alt="cover">
                            <div class="mini-judul">{{ $buku->judul }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @error('buku_id') <span class="error-text"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</span> @enderror
                <input type="hidden" name="buku_id" id="selected_buku_id" value="{{ old('buku_id', $p->buku_id) }}">

                <div class="input-grid-2">
                    <div>
                        <label class="mini-tag">Tgl Pinjam</label>
                        <div class="input-box-custom {{ $errors->has('tanggal_pinjam') ? 'input-error-border' : '' }}">
                            <i class="bi bi-calendar-check"></i>
                            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" value="{{ old('tanggal_pinjam', $p->tanggal_pinjam) }}">
                        </div>
                        @error('tanggal_pinjam') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="mini-tag">Deadline (Otomatis +7 Hari)</label>
                        <div class="input-box-custom {{ $errors->has('tanggal_kembali') ? 'input-error-border' : '' }}">
                            <i class="bi bi-calendar-x"></i>
                            <input type="date" name="tanggal_kembali" id="tanggal_kembali" value="{{ old('tanggal_kembali', $p->tanggal_kembali) }}">
                        </div>
                        @error('tanggal_kembali') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                </div>

                <label class="mini-tag">Status Transaksi</label>
                <div class="input-box-custom {{ $errors->has('status') ? 'input-error-border' : '' }}">
                    <i class="bi bi-shield-check"></i>
                    <select name="status">
                        <option value="Menunggu Pinjam" {{ old('status', $p->status) == 'Menunggu Pinjam' ? 'selected' : '' }}>⏳ Menunggu Konfirmasi</option>
                        <option value="Dipinjam" {{ old('status', $p->status) == 'Dipinjam' ? 'selected' : '' }}>📖 Sedang Dipinjam</option>
                        <option value="Ditolak" {{ old('status', $p->status) == 'Ditolak' ? 'selected' : '' }}>❌ Batalkan Transaksi</option>
                    </select>
                </div>
                @error('status') <span class="error-text">{{ $message }}</span> @enderror

                <label class="mini-tag">Catatan Tambahan</label>
                <div class="input-box-custom {{ $errors->has('catatan') ? 'input-error-border' : '' }}" style="align-items: flex-start; padding-top: 15px;">
                    <i class="bi bi-sticky" style="margin-top: 3px;"></i>
                    <textarea name="catatan" rows="3" placeholder="Contoh: Kondisi buku saat dipinjam ada sedikit coretan...">{{ old('catatan', $p->catatan) }}</textarea>
                </div>
                @error('catatan') <span class="error-text">{{ $message }}</span> @enderror

                <button type="submit" class="btn-save-grad">
                    <i class="bi bi-arrow-repeat me-2"></i> Update Transaksi
                </button>
                <a href="{{ route('admin.transaksi.peminjaman') }}" class="btn-cancel-flat">
                    <i class="bi bi-arrow-left me-1"></i> Batal & Kembali
                </a>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tglPinjamInput = document.getElementById('tanggal_pinjam');
        const tglKembaliInput = document.getElementById('tanggal_kembali');

        // LOGIKA OTOMATIS +7 HARI
        tglPinjamInput.addEventListener('change', function() {
            if (this.value) {
                let date = new window.Date(this.value);
                date.setDate(date.getDate() + 7); // Tambah 7 hari
                
                // Format ke YYYY-MM-DD
                let yyyy = date.getFullYear();
                let mm = String(date.getMonth() + 1).padStart(2, '0');
                let dd = String(date.getDate()).padStart(2, '0');
                
                tglKembaliInput.value = `${yyyy}-${mm}-${dd}`;
            }
        });

        // Search, Select Buku, & SweetAlert Logic
        const cards = document.querySelectorAll('.buku-card-mini');
        const hiddenInput = document.getElementById('selected_buku_id');
        const filterInput = document.getElementById('filterBuku');

        cards.forEach(card => {
            card.addEventListener('click', function() {
                cards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                hiddenInput.value = this.dataset.id;
            });
        });

        filterInput.addEventListener('input', function() {
            const val = this.value.toLowerCase();
            cards.forEach(card => {
                const judul = card.dataset.judul;
                card.style.display = judul.includes(val) ? 'block' : 'none';
            });
        });

        function getSwalConfig() {
            const isLight = document.documentElement.getAttribute('data-theme') === 'light';
            return {
                timer: 3000,
                showConfirmButton: false,
                background: isLight ? '#fff' : '#1e293b',
                color: isLight ? '#0f172a' : '#f8fafc'
            };
        }

        const msgSuccess = "{{ session('success') }}";
        const msgError = "{{ session('error') }}";

        if (msgSuccess) Swal.fire({ ...getSwalConfig(), icon: 'success', title: 'Berhasil!', text: msgSuccess });
        if (msgError) Swal.fire({ ...getSwalConfig(), icon: 'error', title: 'Gagal!', text: msgError, showConfirmButton: true, timer: null });

        const selected = document.querySelector('.buku-card-mini.selected');
        if (selected) selected.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
    });
</script>
@endsection