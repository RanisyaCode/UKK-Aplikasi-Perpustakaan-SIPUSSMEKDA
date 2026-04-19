<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AnggotaController extends Controller
{
    public function index() {
        $siswas = User::latest()->paginate(5); 
    
        $data = [
            'title1' => 'Kelola Anggota',
            'title2' => 'Kelola Anggota',
            'siswas' => $siswas 
        ];
    
        return view('admin.data-anggota.anggota', $data);
    }

    public function create() {
        $data = [
            'title1' => 'Tambah Anggota', 
            'title2' => 'Tambah Data Baru',
        ];
        return view('admin.data-anggota.anggota_create', $data);
    }

    public function edit($id) {
        $siswa = User::findOrFail($id);
        $data = [
            'title1' => 'Edit Anggota',
            'title2' => 'Ubah Data Anggota',
            'siswa'  => $siswa
        ];
        return view('admin.data-anggota.anggota_edit', $data);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'Data anggota berhasil dihapus');
    }

    public function store(Request $request) {
        $rules = [
            'nama'          => 'required|string|max:255',
            'nis'           => 'required|numeric|digits:9|unique:users,nis',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:8',
            'jenis_kelamin' => 'required',
            'no_telepon'    => 'required|numeric',
            'kelas'         => 'required',
        ];
    
        $messages = [
            'nama.required' => 'Nama ini wajib diisi.',
            'nis.required'  => 'NIS wajib diisi.',
            'nis.unique'    => 'NIS sudah terdaftar.',
            'nis.numeric'   => 'NIS harus berupa angka.',
            'nis.digits'    => 'NIS harus tepat 9 digit.',
            'jenis_kelamin.required' => 'Pilih jenis kelamin.',
            'email.required' => 'Email wajib diisi.',
            'email.unique'   => 'Email sudah terdaftar.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'no_telepon.numeric' => 'Nomor telepon harus berupa angka.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'no_telepon.numeric' => 'Nomor telepon harus berupa angka.',
            'kelas.required' => 'Kelas wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'email.email' => 'Format email tidak valid.',
        ];
    
        $request->validate($rules, $messages);
    
        User::create([
            'nama'          => $request->nama,
            'nis'           => $request->nis,
            'jenis_kelamin' => $request->jenis_kelamin,
            'email'         => $request->email,
            'no_telepon'    => $request->no_telepon,
            'kelas'         => $request->kelas,
            'role'          => $request->role,
            'password'      => bcrypt($request->password),
            'aksi'          => 1,
        ]);
    
        return redirect()->route('anggota')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'nama'          => 'required|string|max:255',
            'nis'           => 'required|numeric|digits:9|unique:users,nis,'.$id,
            'email'         => 'required|email|unique:users,email,'.$id,
            'jenis_kelamin' => 'required',
            'no_telepon'    => 'required|numeric',
            'kelas'         => 'required',
            'password'      => 'nullable|min:8', 
        ];

        $messages = [
            'nama.required' => 'Nama wajib diisi.',
            'nis.required'  => 'NIS wajib diisi.',
            'nis.unique'    => 'NIS sudah digunakan anggota lain.',
            'nis.numeric'   => 'NIS harus berupa angka.',
            'nis.digits'    => 'NIS harus tepat 9 digit.',
            'email.required'=> 'Email wajib diisi.',
            'email.unique'  => 'Email sudah digunakan.',
            'email.email'   => 'Format email tidak valid.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'no_telepon.numeric'  => 'Gunakan format angka.',
            'kelas.required' => 'Kelas wajib diisi.',
            'password.min'  => 'Password minimal 8 karakter.',
        ];

        $request->validate($rules, $messages);

        $data = [
            'nama'          => $request->nama,
            'nis'           => $request->nis,
            'jenis_kelamin' => $request->jenis_kelamin,
            'email'         => $request->email,
            'no_telepon'    => $request->no_telepon,
            'kelas'         => $request->kelas,
            'role'          => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('anggota')->with('success', 'Data anggota berhasil diperbarui!');
    }
}