<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanPenjualanService
{
    public function pengeluaranHariIni(): int
    {
        return (int) DB::table('pengeluaran')
            ->whereDate('created_at', Carbon::today())
            ->sum('nominal');
    }

    public function pemasukanPadaTanggal(Carbon $tanggal): int
    {
        return (int) DB::table('penjualan')
            ->whereDate('created_at', $tanggal)
            ->where('status', 'COMPLETED')
            ->sum('total_pembayaran');
    }

    public function ringkasanHariIni(): array
    {
        $data = DB::table('penjualan')
            ->whereDate('created_at', Carbon::today())
            ->where('status', 'COMPLETED')
            ->selectRaw('
                COUNT(*) as total_transaksi,
                SUM(total_pembayaran) as total_penjualan,
                SUM(CASE WHEN metode_pembayaran = "CASH" THEN total_pembayaran ELSE 0 END) as total_cash,
                SUM(CASE WHEN metode_pembayaran != "CASH" THEN total_pembayaran ELSE 0 END) as total_non_tunai
           ')
           ->first();

        return [
            'total_transaksi' => (int) ($data->total_transaksi ?? 0),
            'total_penjualan' => (int) ($data->total_penjualan ?? 0),
            'total_cash'      => (int) ($data->total_cash ?? 0),
            'total_non_tunai' => (int) ($data->total_non_tunai ?? 0),
        ];
    }

    public function ringkasanKeuangan(): array
    {
        $pemasukan = DB::table('penjualan')
            ->where('status', 'COMPLETED')
            ->sum('total_pembayaran');

        $totalStok = DB::table('produk')->sum('stok');

        return [
            'total_pemasukan' => (int) ($pemasukan ?? 0),
            'total_stok' => (int) ($totalStok ?? 0),
        ];
    }

    public function transaksiTerbaru(int $limit = 8)
    {
        return DB::table('penjualan')
            ->join('users', 'users.id', '=', 'penjualan.user_id')
            ->select(
                'penjualan.id',
                'penjualan.total_pembayaran',
                'penjualan.metode_pembayaran',
                'penjualan.status',
                'penjualan.created_at',
                'users.name as kasir'
            )
            ->orderByDesc('penjualan.created_at')
            ->limit($limit)
            ->get();
    }

    public function produkTerlarisHariIni(int $limit = 5)
    {
        return DB::table('item_penjualan')
            ->join('penjualan', 'penjualan.id', '=', 'item_penjualan.penjualan_id')
            ->join('produk', 'produk.id', '=', 'item_penjualan.produk_id')
            ->whereDate('penjualan.created_at', Carbon::today())
            ->where('penjualan.status', 'COMPLETED')
            ->groupBy('produk.id', 'produk.nama')
            ->select(
                'produk.nama',
                'produk.stok',
                DB::raw('SUM(item_penjualan.kuantitas) as total_terjual')
            )
            ->orderByDesc('total_terjual')
            ->limit($limit)
            ->get();
    }
}
