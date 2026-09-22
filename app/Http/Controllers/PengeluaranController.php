<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengeluaranController extends Controller
{
    public function index()
    {
        $pengeluaran = Pengeluaran::with('user')->latest()->paginate(10);
        $totalHariIni = Pengeluaran::whereDate('created_at', Carbon::today())->sum('nominal');
        $totalBulanIni = Pengeluaran::whereYear('created_at', Carbon::today()->year)
            ->whereMonth('created_at', Carbon::today()->month)
            ->sum('nominal');

        return view('pengeluaran.index', compact('pengeluaran', 'totalHariIni', 'totalBulanIni'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'keterangan' => 'required|string|max:255',
            'nominal' => 'required|integer|min:1',
        ]);

        Pengeluaran::create([
            'user_id' => Auth::id(),
            'keterangan' => $data['keterangan'],
            'nominal' => $data['nominal'],
        ]);

        return back()->with('success', 'Pengeluaran berhasil dicatat.');
    }
}
