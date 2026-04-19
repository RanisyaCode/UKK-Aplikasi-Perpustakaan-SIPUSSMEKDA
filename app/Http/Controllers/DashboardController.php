<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Buku;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $count_user = User::count();
        $count_buku = Buku::count();
        $count_pinjam = Transaksi::where('status', 'Dipinjam')->count();
        $count_overdue = Transaksi::where('status', 'Dipinjam')
                            ->where('tanggal_kembali', '<', now())
                            ->count();

        $recent_transactions = Transaksi::with(['user', 'buku'])
                                ->latest()
                                ->take(6)
                                ->get();

        $persen_pinjam = $count_buku > 0 ? round(($count_pinjam / $count_buku) * 100) : 0;

        $title1 = 'Dashboard Admin';
        $title2 = 'Ringkasan Statistik';

        return view('dashboardadmin', compact(
            'count_user', 
            'count_buku', 
            'count_pinjam', 
            'count_overdue', 
            'recent_transactions', 
            'persen_pinjam',
            'title1',
            'title2'
        ));
    }
}