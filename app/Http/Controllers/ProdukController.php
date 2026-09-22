<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori; // 1. Import Model Kategori
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        // Load relasi kategori dan user
        $query = Produk::with(['user', 'kategori'])->latest();

        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $produk = $query->paginate(10)->withQueryString();
        $produkStokMenipis = Produk::whereBetween('stok', [1, 10])->count();
        $produkStokHabis = Produk::where('stok', 0)->count();

        return view('produk.index', compact('produk', 'produkStokMenipis', 'produkStokHabis'));
    }

    public function create()
    {
        // 2. Ambil semua kategori untuk dropdown di form tambah
        $kategoris = Kategori::all();
        return view('produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        // 3. Tambahkan validasi kategori_id
        $request->validate([
            'nama'        => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga_jual'  => 'required|numeric',
            'diskon_persen' => 'nullable|integer|min:0|max:100',
            'stok'        => 'required|integer|min:1',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('products', 'public');
        }

        // 4. Simpan kategori_id ke database
        Produk::create([
            'user_id'     => Auth::id() ?? 1,
            'kategori_id' => $request->kategori_id,
            'nama'        => $request->nama,
            'harga_beli'  => $request->harga_beli ?? 0,
            'harga_jual'  => $request->harga_jual,
            'diskon_persen' => $request->diskon_persen ?? 0,
            'stok'        => $request->stok,
            'foto'        => $fotoPath
        ]);

        // Disesuaikan dengan routeResource: 'produk.index'
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show($id)
    {
        $produk = Produk::with(['user', 'kategori'])->findOrFail($id);
        return view('produk.show', compact('produk'));
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        // 5. Ambil data kategori untuk form edit
        $kategoris = Kategori::all();
        return view('produk.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama'        => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga_jual'  => 'required|numeric',
            'diskon_persen' => 'nullable|integer|min:0|max:100',
            'stok'        => 'required|integer',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $fotoPath = $produk->foto;
        if ($request->hasFile('foto')) {
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }
            $fotoPath = $request->file('foto')->store('products', 'public');
        }

        $produk->update([
            'nama'        => $request->nama,
            'kategori_id' => $request->kategori_id,
            'harga_beli'  => $request->harga_beli ?? 0,
            'harga_jual'  => $request->harga_jual,
            'diskon_persen' => $request->diskon_persen ?? 0,
            'stok'        => $request->stok,
            'foto'        => $fotoPath
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function updateDiscount(Request $request, $id)
    {
        $request->validate([
            'diskon_persen' => 'required|integer|min:0|max:100',
        ]);

        Produk::findOrFail($id)->update([
            'diskon_persen' => $request->diskon_persen,
        ]);

        return redirect()->route('produk.index')->with('success', 'Diskon produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}