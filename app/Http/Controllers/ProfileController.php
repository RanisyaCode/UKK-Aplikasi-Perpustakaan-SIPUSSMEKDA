<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Profile;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile;
        
        if ($user->role === 'Siswa') {
            return view('profile.editsiswa', compact('user', 'profile'));
        }

        $title1 = "Profil Saya";
        $title2 = "Profil";
        return view('profile.edit', compact('user', 'profile', 'title1', 'title2'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->nama = $request->nama;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        if ($request->filled('cropped_image')) {
            $data = $request->input('cropped_image');
            
            if (strpos($data, 'base64,') !== false) {
                $folderPath = public_path('storage/profile_photos');
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0775, true);
                }

                $image_parts = explode(";base64,", $data);
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = time() . '_profile.jpeg';

                file_put_contents($folderPath . '/' . $fileName, $image_base64);

                Profile::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'nama' => $request->nama,
                        'profile_photo' => $fileName
                    ]
                );
            }
        } else {
            Profile::updateOrCreate(
                ['user_id' => $user->id],
                ['nama' => $request->nama]
            );
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function deletePhoto(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;
    
        if ($profile && $profile->profile_photo) {
            $path = public_path('storage/profile_photos/' . $profile->profile_photo);
            if (file_exists($path)) {
                unlink($path);
            }
            $profile->profile_photo = null;
            $profile->save();
        }

        return redirect()->back()->with('success', 'Foto berhasil dihapus!');
    }
}