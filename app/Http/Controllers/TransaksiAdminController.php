<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Buku;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransaksiAdminController extends Controller
{
    public function indexPeminjaman()
    {
        $peminjamans_admin = Transaksi::with(['user', 'buku'])
            ->whereIn('status', ['Menunggu Pinjam', 'Dipinjam', 'Ditolak'])
            ->latest()
            ->paginate(5);
        
        $count_pending  = Transaksi::where('status', 'Menunggu Pinjam')->count(); 
        $count_dipinjam = Transaksi::where('status', 'Dipinjam')->count(); 
        $count_total    = Transaksi::count();

        return view('admin.transaksi.peminjaman', [
            'title1' => 'Transaksi',
            'title2' => 'Daftar Peminjaman',
            'peminjamans_admin' => $peminjamans_admin,
            'count_pending' => $count_pending,
            'count_dipinjam' => $count_dipinjam,
            'count_total' => $count_total
        ]);
    }

    public function approve($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        return DB::transaction(function () use ($transaksi) {
            $buku = Buku::where('id', $transaksi->buku_id)->lockForUpdate()->first();

            if ($transaksi->status !== 'Menunggu Pinjam') {
                return redirect()->back()->with('error', 'Hanya status Menunggu yang bisa disetujui.');
            }

            if (!$buku || $buku->stok <= 0) {
                return redirect()->back()->with('error', 'Gagal! Stok buku habis.');
            }

            // DIPINJAM: Stok Berkurang
            $transaksi->update(['status' => 'Dipinjam']);
            $buku->decrement('stok');

            return redirect()->back()->with('success', 'Peminjaman disetujui, stok berkurang.');
        });
    }

    public function reject(Request $request, $id) // Tambahkan Request
    {
        $transaksi = Transaksi::findOrFail($id);
        
        return DB::transaction(function () use ($transaksi, $request) {
            $buku = Buku::find($transaksi->buku_id);
            
            // Jika status sebelumnya adalah 'Dipinjam' atau 'Menunggu Verifikasi',
            // stok harus dikembalikan karena sebelumnya sudah terpotong.
            if (in_array($transaksi->status, ['Dipinjam', 'Menunggu Verifikasi'])) {
                if ($buku) {
                    $buku->increment('stok');
                }
            }

            // Ubah status menjadi Ditolak dan simpan CATATAN
            $transaksi->update([
                'status' => 'Ditolak',
                'catatan' => $request->alasan_tolak // Pastikan di Form name-nya 'alasan_tolak'
            ]); 
            
            return redirect()->back()->with('info', 'Peminjaman telah ditolak dan catatan telah disimpan.');
        });
    }

    public function prosesKembali($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Keamanan: Pastikan memang statusnya sedang menunggu verifikasi
        if ($transaksi->status !== 'Menunggu Verifikasi') {
            return redirect()->back()->with('error', 'Hanya transaksi berstatus Menunggu Verifikasi yang bisa diselesaikan.');
        }
        
        DB::transaction(function () use ($transaksi) {
            // 1. Update data transaksi
            $transaksi->update([
                'tgl_pengembalian_aktual' => Carbon::now(),
                'status' => 'Sudah Dikembalikan' // Ini status final (Selesai)
            ]);

            // 2. Kembalikan stok ke rak buku
            $buku = Buku::find($transaksi->buku_id);
            if ($buku) {
                $buku->increment('stok');
            }
        });

        return redirect()->back()->with('success', 'Verifikasi berhasil! Buku telah diterima kembali dan stok diperbarui.');
    }

    // TransaksiAdminController.php (Modifikasi Logic Reject untuk Pengembalian)
    public function rejectPengembalian($id, Request $request)
    {
        // Validasi agar catatan tidak kosong jika ingin memberikan alasan
        $request->validate([
            'alasan_tolak' => 'required|string|max:255'
        ]);

        $transaksi = Transaksi::findOrFail($id);
        
        $transaksi->update([
            'status' => 'Dipinjam', // Jika pengembalian ditolak, status balik ke 'Dipinjam' (belum selesai)
            'catatan' => $request->alasan_tolak 
        ]);

        return redirect()->back()->with('info', 'Permohonan pengembalian ditolak. Catatan: ' . $request->alasan_tolak);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'required',
            'catatan' => 'nullable|string'
        ]);

        $transaksi = Transaksi::findOrFail($id);
        
        return DB::transaction(function () use ($request, $transaksi) {
            $oldBukuId = $transaksi->buku_id;
            $newBukuId = $request->buku_id;
            $oldStatus = $transaksi->status;
            $newStatus = $request->status; // Ambil langsung dari input, jangan diubah paksa

            // Status yang dianggap buku sedang keluar (stok berkurang di rak)
            $statusKeluar = ['Dipinjam', 'Menunggu Verifikasi'];

            // 1. Logika Tukar Buku
            if ($oldBukuId != $newBukuId) {
                // Kembalikan stok buku lama jika sebelumnya statusnya "Keluar"
                if (in_array($oldStatus, $statusKeluar)) {
                    Buku::where('id', $oldBukuId)->increment('stok');
                }

                // Kurangi stok buku baru jika status barunya "Keluar"
                if (in_array($newStatus, $statusKeluar)) {
                    $bukuBaru = Buku::where('id', $newBukuId)->lockForUpdate()->first();
                    if ($bukuBaru->stok <= 0) {
                        return redirect()->back()->with('error', 'Stok buku baru habis!');
                    }
                    $bukuBaru->decrement('stok');
                }
            } 
            // 2. Logika Buku Tetap, Status Berubah
            else {
                $buku = Buku::where('id', $oldBukuId)->lockForUpdate()->first();
                
                // Perubahan status yang butuh balikin stok ke rak
                if (in_array($oldStatus, $statusKeluar) && !in_array($newStatus, $statusKeluar)) {
                    $buku->increment('stok');
                }
                // Perubahan status yang butuh ambil stok dari rak
                elseif (!in_array($oldStatus, $statusKeluar) && in_array($newStatus, $statusKeluar)) {
                    if ($buku->stok <= 0) {
                        return redirect()->back()->with('error', 'Stok buku habis!');
                    }
                    $buku->decrement('stok');
                }
            }

            // Update data
            $transaksi->update([
                'buku_id' => $newBukuId,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'status' => $newStatus,
                'catatan' => $request->catatan,
                // Jika status berubah jadi "Sudah Dikembalikan", set tanggal aktualnya sekarang
                'tgl_pengembalian_aktual' => ($newStatus === 'Sudah Dikembalikan') ? now() : $transaksi->tgl_pengembalian_aktual,
            ]);

            // Redirect ke menu pengembalian karena ini dari edit pengembalian
            return redirect()->route('admin.transaksi.peminjaman')->with('success', 'Data pengembalian berhasil diupdate.');
        });
    }

    public function indexPengembalian()
    {
        $data = Transaksi::with(['user', 'buku'])
            // Hanya tampilkan yang butuh verifikasi (siswa sudah klik kembali) 
            // atau yang sudah resmi kembali.
            ->whereIn('status', ['Menunggu Verifikasi', 'Sudah Dikembalikan'])
            ->latest()
            ->get(); 

        return view('admin.transaksi.pengembalianadmin', [
            'title1' => 'Transaksi',
            'title2' => 'Validasi Pengembalian',
            'data' => $data
        ]);
    }

    // Fungsi Baru untuk Siswa (Jika diletakkan di controller ini)
    // Atau pindahkan ke PeminjamanController milik siswa
    public function batalkanPengembalian($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Keamanan: Hanya bisa batal jika admin belum verifikasi
        if ($transaksi->status === 'Menunggu Verifikasi') {
            $transaksi->update([
                'status' => 'Dipinjam',
                'tgl_pengembalian_aktual' => null
            ]);
            return redirect()->back()->with('success', 'Pengembalian dibatalkan, status kembali menjadi Dipinjam.');
        }

        return redirect()->back()->with('error', 'Gagal membatalkan, mungkin sudah diverifikasi admin.');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::with(['user', 'buku'])->findOrFail($id);
        $bukus = Buku::all(); 

        return view('admin.transaksi.edit', [
            'title1' => 'Transaksi',
            'title2' => 'Edit Detail Peminjaman',
            'p' => $transaksi,
            'bukus' => $bukus 
        ]);
    }

    public function edit_pengembalian($id)
    {
        $transaksi = Transaksi::with(['user', 'buku'])->findOrFail($id);
        $bukus = Buku::all(); 
        
        return view('admin.transaksi.edit-pengembalian', [
            'title1' => 'Transaksi',
            'title2' => 'Edit Pengembalian',
            'transaksi' => $transaksi,
            'bukus' => $bukus
        ]);
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Jika dihapus saat buku masih di luar (Dipinjam/Menunggu Verifikasi)
        // Kembalikan stoknya ke rak
        if (in_array($transaksi->status, ['Dipinjam', 'Menunggu Verifikasi'])) {
            $buku = Buku::find($transaksi->buku_id);
            if ($buku) {
                $buku->increment('stok');
            }
        }

        $transaksi->delete();
        return redirect()->back()->with('success', 'Log transaksi dihapus dan stok disesuaikan.');
    }

    public function create() {
        $users = User::where('role', 'siswa')->get(); 
        $bukus = Buku::where('stok', '>', 0)->get();

        return view('admin.transaksi.create', [
            'title1' => 'Transaksi',
            'title2' => 'Tambah Pinjaman',
            'users'  => $users,
            'bukus'  => $bukus
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        return DB::transaction(function () use ($request) {
            // 1. Cek kuota peminjaman (Max 3)
            $jumlahPinjaman = Transaksi::where('user_id', $request->user_id)
                ->whereIn('status', ['Menunggu Pinjam', 'Dipinjam', 'Menunggu Verifikasi'])
                ->count();

            if ($jumlahPinjaman >= 3) {
                return redirect()->back()->withInput()->with('error', 'Siswa sudah mencapai batas maksimal 3 buku!');
            }

            // 2. Cek Stok Buku
            $buku = Buku::where('id', $request->buku_id)->lockForUpdate()->first();
            if ($buku->stok <= 0) {
                return redirect()->back()->withInput()->with('error', 'Maaf, stok buku ini sedang kosong.');
            }

            // 3. Simpan
            Transaksi::create([
                'user_id' => $request->user_id,
                'buku_id' => $request->buku_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'status' => 'Menunggu Pinjam', 
            ]);

            return redirect()->route('admin.transaksi.peminjaman')->with('success', 'Transaksi baru berhasil ditambahkan.');
        });
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $transaksi = Transaksi::findOrFail($id);
        
        // Logika sederhana untuk update status
        $transaksi->update([
            'status' => $request->status
        ]);

        // Opsional: Jika status diubah jadi 'Dipinjam', kurangi stok buku
        if ($request->status == 'Dipinjam') {
            $buku = Buku::find($transaksi->buku_id);
            if ($buku && $buku->stok > 0) {
                $buku->decrement('stok');
            }
        }

        return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui ke: ' . $request->status);
    }
}