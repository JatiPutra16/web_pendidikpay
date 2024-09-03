<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Gaji;
use App\Models\Absen;
use App\Models\Guru;
use PDF;
use Carbon\Carbon;


class LaporanController extends Controller
{
    public function laporantampil(Request $request)
    {
        $bulan = now()->month;
        $tahun = now()->year;

        $dataabsen = Absen::select('idabsen', 'idguru', 'jumlah_jam', 'jumlah_hari')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        $dataguru = Guru::whereIn('idguru', $dataabsen->pluck('idguru')->unique())
                        ->get();

        $absen_with_guru = $dataabsen->map(function ($absen) use ($dataguru) {
            $guru = $dataguru->where('idguru', $absen->idguru)->first();
            return [
                'idabsen' => $absen->idabsen,
                'namaguru' => $guru ? $guru->namaguru : 'Unknown'
            ];
        });

        $datagaji = Gaji::with(['guru', 'absen'])->get();

        return view('laporan.laporan', [
            'var_gaji' => $datagaji,
            'var_absen' => $dataabsen,
            'absen_with_guru' => $absen_with_guru,
            'bulan' => $bulan,
        ]);
    }

    public function filterGaji(Request $request)
    {
        $query = Gaji::query();

        // Filter berdasarkan nama guru
        if ($request->filled('nama')) {
            $query->whereHas('absen.guru', function ($q) use ($request) {
                $q->where('namaguru', 'like', '%' . $request->nama . '%');
            });
        }

        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tgl_gaji', '=', date('m', strtotime($request->bulan)))
                ->whereYear('tgl_gaji', '=', date('Y', strtotime($request->bulan)));
        }

        // Filter berdasarkan rentang periode bulan
        if ($request->filled('start_bulan') && $request->filled('end_bulan')) {
            $query->whereBetween('tgl_gaji', [
                date('Y-m-01', strtotime($request->start_bulan)),
                date('Y-m-t', strtotime($request->end_bulan))
            ]);
        }

        // Ambil data setelah filter
        $var_gaji = $query->get();

        // Return view dengan data yang sudah difilter
        return view('laporan.gaji', compact('var_gaji'));
    }

    public function laporanGaji()
    {
        // Ambil semua data gaji untuk pertama kali load halaman
        $var_gaji = Gaji::all();

        // Return view laporan.gaji dengan data gaji
        return view('laporan.gaji', compact('var_gaji'));
    }

    public function autocompleteGuru(Request $request)
    {
        $search = $request->get('term');

        $gurus = Guru::where('namaguru', 'LIKE', '%' . $search . '%')
                    ->pluck('namaguru');

        return response()->json($gurus);
    }
}
