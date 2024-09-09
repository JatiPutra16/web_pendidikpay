<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Absen;
use App\Models\Gaji;

class HomeController extends Controller
{
    public function index()
    {
        // Menghitung jumlah guru, absen, dan gaji
        $jumlahGuru = Guru::count();
        $jumlahAbsen = Absen::count();
        $jumlahGaji = Gaji::count();

        // Mengambil data gaji per bulan
        $gajiPerBulan = Gaji::selectRaw('MONTH(tgl_gaji) as bulan, SUM(total_gaji) as total')
                            ->groupByRaw('MONTH(tgl_gaji)')
                            ->orderByRaw('MONTH(tgl_gaji)')
                            ->get()
                            ->map(function ($item) {
                                $item->bulan = date('F', mktime(0, 0, 0, $item->bulan, 10)); // Konversi bulan ke nama bulan
                                return $item;
                            });

        // Mengambil data 5 guru terbaru
        $guruTerbaru = Guru::latest()->take(5)->get();

        return view('home', compact('jumlahGuru', 'jumlahAbsen', 'jumlahGaji', 'gajiPerBulan', 'guruTerbaru'));
    }

}
