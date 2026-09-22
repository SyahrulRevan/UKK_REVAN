<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PerusahaanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('perusahaan.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'foto_perusahaan' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'foto_qris' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'nama_perusahaan' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ], [
            'foto_perusahaan.image' => 'File foto perusahaan harus berupa gambar.',
            'foto_perusahaan.max' => 'Ukuran foto perusahaan maksimal 4MB.',
            'foto_qris.image' => 'File QRIS harus berupa gambar.',
            'foto_qris.max' => 'Ukuran foto QRIS maksimal 4MB.',
            'website.url' => 'Format website harus URL yang valid.',
        ]);

        $user->nama_perusahaan = $request->nama_perusahaan;
        $user->website = $request->website;
        $user->deskripsi = $request->deskripsi;

        if ($request->hasFile('foto_perusahaan')) {
            if ($user->foto_perusahaan && Storage::disk('public')->exists($user->foto_perusahaan)) {
                Storage::disk('public')->delete($user->foto_perusahaan);
            }

            $user->foto_perusahaan = $request->file('foto_perusahaan')->store('company', 'public');
        }

        if ($request->hasFile('foto_qris')) {
            if ($user->foto_qris && Storage::disk('public')->exists($user->foto_qris)) {
                Storage::disk('public')->delete($user->foto_qris);
            }

            $user->foto_qris = $request->file('foto_qris')->store('qris', 'public');
        }

        $user->save();

        return redirect()->route('perusahaan.index')->with('success', 'Profil perusahaan berhasil diperbarui.');
    }
}
