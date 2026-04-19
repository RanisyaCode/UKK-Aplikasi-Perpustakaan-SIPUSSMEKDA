<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Buku;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiSiswaController extends Controller
{
    protected $statusAktif = ['Menunggu Pinjam', 'Dipinjam', 'Menunggu Verifikasi'];

    public function pinjam(Request $request)
    {
        $userId = Auth::id();
        $bukuId = $request->query('buku_id');
        $buku = Buku::find($bukuId);

        $transaksiAktif = Transaksi::with('buku')
                            ->where('user_id', $userId)
                            ->whereIn('status', $this->statusAktif)
                            ->get();

        $transaksiTerakhir = Transaksi::where('user_id', $userId)
                            ->latest()
                            ->first();

        $jumlahAktif = $transaksiAktif->count();

        $title1 = "Transaksi Saya";
        $title2 = "Pinjam Buku";

        $semuaBuku = Buku::where('stok', '>', 0)->get();

        return view('siswa.pinjam-buku.pinjam', compact(
            'buku', 'title1', 'title2', 'transaksiAktif', 
            'transaksiTerakhir', 'jumlahAktif', 'semuaBuku'
        ));
    }

    public function edit($id)
    {
        $transaksi = Transaksi::with('buku')->findOrFail($id);

        if ($transaksi->user_id !== Auth::id() || $transaksi->status !== 'Menunggu Pinjam') {
            return redirect()->route('pinjam')->with('error', 'Akses ditolak atau data tidak bisa diubah.');
        }

        $bukus = Buku::where('stok', '>', 0)->get();
        
        $title1 = "Edit Transaksi";
        $title2 = "Perbarui Peminjaman";

        return view('siswa.pinjam-buku.pinjam-edit', compact('transaksi', 'bukus', 'title1', 'title2'));
    }

    public function formPilih(Request $request)
    {
        $buku_id = $request->query('buku_id');
        $userId = Auth::id();
        
        $cekTransaksi = Transaksi::where('user_id', $userId)
                        ->where('buku_id', $buku_id)
                        ->whereIn('status', $this->statusAktif)
                        ->first();

        if ($cekTransaksi) {
            return redirect()->route('pinjam', ['buku_id' => $buku_id])
                ->with('error', 'Gagal! Kamu masih punya transaksi aktif untuk buku ini.');
        }

        $buku_terpilih = Buku::find($buku_id);
        $bukus = Buku::where('stok', '>', 0)->get(); 
        
        $jumlahAktif = Transaksi::where('user_id', $userId)
                        ->whereIn('status', $this->statusAktif)
                        ->count();

        $title1 = "Transaksi Saya";
        $title2 = "Pilih Buku";

        return view('siswa.pinjam-buku.pilih_buku', compact('buku_terpilih', 'bukus', 'title1', 'title2', 'jumlahAktif'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'buku_id'     => 'required|exists:bukus,id',
            'tgl_pinjam'  => 'required|date|after_or_equal:today',
            'catatan'     => 'nullable|string|max:255'
        ], [
            'buku_id.required' => 'Pilih buku yang ingin dipinjam.',
            'buku_id.exists'   => 'Buku yang dipilih tidak valid.',
            'tgl_pinjam.required' => 'Tanggal pinjam harus diisi.',
            'tgl_pinjam.date'     => 'Format tanggal pinjam tidak valid.',
            'tgl_pinjam.after_or_equal' => 'Tanggal pinjam tidak boleh sebelum hari ini.',
            'catatan.string' => 'Catatan harus berupa teks.',
            'catatan.max'    => 'Catatan maksimal 255 karakter.'
        ]);

        $userId = Auth::id();
        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stok <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok buku ini sedang kosong.');
        }

        $jumlahAktif = Transaksi::where('user_id', $userId)
                        ->whereIn('status', $this->statusAktif)
                        ->count();

        if ($jumlahAktif >= 3) {
            return redirect()->back()->with('error', 'Gagal! Kamu sudah mencapai batas maksimal 3 peminjaman.');
        }

        $tglPinjam = Carbon::parse($request->tgl_pinjam);
        $tglKembaliOtomatis = $tglPinjam->copy()->addDays(7);

        Transaksi::create([
            'user_id'         => $userId,
            'buku_id'         => $request->buku_id,
            'tanggal_pinjam'  => $tglPinjam, 
            'tanggal_kembali' => $tglKembaliOtomatis,
            'catatan'         => $request->catatan,
            'status'          => 'Menunggu Pinjam', 
        ]);
        
        return redirect()->route('pinjam', ['buku_id' => $request->buku_id])
            ->with('success', 'Pengajuan berhasil! Tanggal kembali otomatis diset: ' . $tglKembaliOtomatis->format('d-m-Y'));
    }

    public function updatePinjam(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        if ($transaksi->status !== 'Menunggu Pinjam' || $transaksi->user_id !== Auth::id()) {
            return redirect()->route('pinjam')->with('error', 'Data tidak dapat diubah karena sudah diproses.');
        }

        $request->validate([
            'buku_id'    => 'required|exists:bukus,id',
            'tgl_pinjam' => 'required|date',
            'catatan'    => 'nullable|string|max:255'
        ]);

        $tglPinjam = Carbon::parse($request->tgl_pinjam);
        $tglKembaliOtomatis = $tglPinjam->copy()->addDays(7);

        $transaksi->update([
            'buku_id'         => $request->buku_id,
            'tanggal_pinjam'  => $tglPinjam,
            'tanggal_kembali' => $tglKembaliOtomatis,
            'catatan'         => $request->catatan
        ]);

        return redirect()->route('pinjam')->with('success', 'Perubahan berhasil disimpan!');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if ($transaksi->status !== 'Menunggu Pinjam' || $transaksi->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Pengajuan tidak dapat dibatalkan.');
        }

        $transaksi->delete();
        return redirect()->back()->with('success', 'Pengajuan berhasil dibatalkan.');
    }

    public function index()
    {
        $userId = Auth::id();
        
        $riwayat = Transaksi::with('buku')
                    ->where('user_id', $userId)
                    ->orderByDesc('updated_at') 
                    ->get();

        $bukuDipinjam = Transaksi::with('buku')
                    ->where('user_id', $userId)
                    ->whereIn('status', ['Dipinjam', 'Menunggu Verifikasi', 'Ditolak'])
                    ->orderByRaw("FIELD(status, 'Ditolak', 'Dipinjam', 'Menunggu Verifikasi')") 
                    ->get();

        $title1 = "Transaksi Saya";
        $title2 = "Daftar Riwayat & Pengembalian";

        return view('siswa.pengembalian-buku.pengembalian', compact('riwayat', 'bukuDipinjam', 'title1', 'title2'));
    }

    public function update($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        
        if($transaksi->user_id !== Auth::id()) abort(403);
        
        $statusBolehKembali = ['Dipinjam', 'Ditolak'];

        if(!in_array($transaksi->status, $statusBolehKembali)) {
            return redirect()->back()->with('error', 'Transaksi sedang dalam proses atau sudah selesai.');
        }

        $transaksi->update([
            'status' => 'Menunggu Verifikasi',
            'catatan' => '-' 
        ]);

        return redirect()->route('pengembalian')->with('success', 'Permohonan terkirim! Silakan serahkan buku ke petugas perpustakaan untuk verifikasi fisik.');
    }
}