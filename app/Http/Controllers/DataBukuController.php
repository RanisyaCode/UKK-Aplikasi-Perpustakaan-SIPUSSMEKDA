<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class DataBukuController extends Controller
{
    public function databuku() {
        $bukus = Buku::latest()->paginate(10); 
        
        $data = [
            'title1' => 'Kelola Data Buku',
            'title2' => 'Daftar Koleksi Perpustakaan',
            'bukus'  => $bukus 
        ];
    
        return view('admin.kelola_buku.databuku', $data);
    }

    public function create() {
        $data = [
            'title1' => 'Tambah Buku',
            'title2' => 'Input Koleksi Baru',
            'kategoris' => ['Novel', 'Pelajaran', 'Biografi', 'Komik', 'Teknologi', 'Sejarah']
        ];
        return view('admin.kelola_buku.buku_create', $data);
    }

    public function store(Request $request) {
        $request->validate([
            'judul'          => 'required|min:3|max:255',
            'penulis'        => 'required|string|max:100',
            'kategori'       => 'required',
            'isbn'           => 'required|unique:bukus,isbn|max:20',
            'penerbit'       => 'required|string|max:100',
            'tahun_terbit'   => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
            'stok'           => 'required|integer|min:0',
            'jumlah_halaman' => 'required|integer|min:1',
            'sinopsis'       => 'required|string|min:10',
            'cover'          => 'required|image|mimes:jpg,jpeg,png|max:2048' 
        ], [
            'judul.required'    => 'Judul buku wajib diisi!',
            'penulis.required'  => 'Nama penulis wajib diisi!',
            'kategori.required' => 'Kategori buku wajib dipilih!',
            'penerbit.required' => 'Nama penerbit wajib diisi!',
            'isbn.required'     => 'ISBN wajib diisi!',
            'isbn.unique'       => 'ISBN ini sudah terdaftar!',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi!',
            'stok.required'     => 'Stok wajib diisi!',
            'jumlah_halaman.required' => 'Jumlah halaman wajib diisi!',
            'sinopsis.required' => 'Sinopsis wajib diisi!',
            'cover.required'    => 'Foto cover wajib diunggah!',
            'cover.image'       => 'File harus berupa gambar.',
            'cover.max'         => 'Ukuran gambar maksimal 2MB.',
        ]);
    
        $data = $request->all();
    
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/covers'), $namaFile);
            $data['cover'] = $namaFile;
        }
    
        Buku::create($data);
        return redirect()->route('databuku')->with('success', 'Koleksi baru berhasil ditambahkan!');
    }

    public function edit($id) {
        $buku = Buku::findOrFail($id);
        $data = [
            'title1' => 'Edit Buku',
            'title2' => 'Perbarui Informasi Buku',
            'buku'   => $buku,
            'kategoris' => ['Novel', 'Pelajaran', 'Biografi', 'Komik', 'Teknologi', 'Sejarah']
        ];
        return view('admin.kelola_buku.buku_edit', $data);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'judul'    => 'required|min:3|max:255',
            'penulis'  => 'required|string|max:100',
            'kategori' => 'required',
            'isbn'     => 'required|max:20|unique:bukus,isbn,'.$id, 
            'stok'     => 'required|integer|min:0',
            'sinopsis' => 'required|string|min:10',
            'cover'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ], [
            'judul.required'    => 'Judul wajib diisi!',
            'penulis.required'  => 'Penulis wajib diisi!',
            'kategori.required' => 'Kategori wajib dipilih!',
            'isbn.required'     => 'ISBN wajib diisi!',
            'isbn.unique'       => 'ISBN sudah digunakan buku lain!',
            'stok.required'     => 'Stok wajib diisi!',
            'sinopsis.required' => 'Sinopsis wajib diisi!',
            'cover.image'       => 'File harus berupa gambar.',
            'cover.max'         => 'Ukuran gambar maksimal 2MB.',
        ]);

        $buku = Buku::findOrFail($id);
        $updateData = $request->all();

        if ($request->hasFile('cover')) {
            if ($buku->cover && file_exists(public_path('storage/covers/' . $buku->cover))) {
                unlink(public_path('storage/covers/' . $buku->cover));
            }

            $file = $request->file('cover');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/covers'), $namaFile);
            $updateData['cover'] = $namaFile;
        }

        $buku->update($updateData);
        return redirect()->route('databuku')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy($id) {
        $buku = Buku::findOrFail($id);
        
        if ($buku->cover && file_exists(public_path('storage/covers/' . $buku->cover))) {
            unlink(public_path('storage/covers/' . $buku->cover));
        }
        
        $buku->delete();
        return redirect()->route('databuku')->with('success', 'Buku berhasil dihapus');
    }
}