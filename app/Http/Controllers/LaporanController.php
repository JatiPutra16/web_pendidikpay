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
        return view('laporan.laporan');
    }

    public function laporanGajiTampil(Request $request)
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
        $var_gaji = $query->with(['guru', 'absen'])->get();

        // Mengelompokkan total gaji per bulan
        $chartData = $var_gaji->groupBy(function($item) {
            return $item->tgl_gaji->format('M Y');
        })->map(function($items) {
            $totalGajiPerBulan = $items->sum('total_gaji');
            return [
                'bulan' => $items->first()->tgl_gaji->format('M Y'),
                'total_gaji' => $totalGajiPerBulan
            ];
        })->values();
        

        return view('laporan.laporangaji', [
            'var_gaji' => $var_gaji,
            'chartData' => $chartData,
            'nama' => $request->nama,
            'bulan' => $request->bulan,
            'start_bulan' => $request->start_bulan,
            'end_bulan' => $request->end_bulan,
        ]);
    }

    
    public function cetakPDFGaji(Request $request)
    {
        $query = Gaji::with(['absen.guru']);
        
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
        
        $var_gaji = $query->get();
    
        // Hitung total gaji, total jam, dan total gaji bersih
        $total_gaji = $var_gaji->sum('total_gaji');
        $total_jam = $var_gaji->sum('total_jam');
        $total_gaji_bersih = $var_gaji->sum('gaji_bersih');
        
        $pdf = PDF::loadView('laporan.pdfgaji', [
            'gaji' => $var_gaji,
            'nik' => $var_gaji->first()->absen->guru->nik ?? null,
            'namaguru' => $var_gaji->first()->absen->guru->namaguru ?? null,
            'bulan' => $request->bulan,
            'start_bulan' => $request->start_bulan,
            'end_bulan' => $request->end_bulan,
            'total_gaji' => $total_gaji,
            'total_jam' => $total_jam,
            'total_gaji_bersih' => $total_gaji_bersih,
        ]);
        
        return $pdf->stream('Laporan_Gaji_' . now()->format('Ymd_His') . '.pdf');
    }
    
    
    public function laporanTampilAbsen(Request $request)
    {
        $query = Absen::query();

        if ($request->filled('nama')) {
            $query->whereHas('guru', function ($q) use ($request) {
                $q->where('namaguru', 'like', '%' . $request->nama . '%');
            });
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', '=', date('m', strtotime($request->bulan)))
                ->whereYear('tanggal', '=', date('Y', strtotime($request->bulan)));
        }

        if ($request->filled('start_bulan') && $request->filled('end_bulan')) {
            $query->whereBetween('tanggal', [
                date('Y-m-01', strtotime($request->start_bulan)),
                date('Y-m-t', strtotime($request->end_bulan))
            ]);
        }

        $var_absen = $query->with('guru')->get();
        
        // Chart Data
        $chartData = $var_absen->groupBy(function($item) {
            return \Carbon\Carbon::parse($item->tanggal)->format('M Y');
        })->map(function($items) {
            $total_jam = $items->sum(function($item) {
                return $item->jumlah_jam * $item->jumlah_hari;
            });
            return [
                'bulan' => \Carbon\Carbon::parse($items->first()->tanggal)->format('M Y'),
                'total_jam' => $total_jam
            ];
        })->values();

        return view('laporan.laporanabsen', [
            'var_absen' => $var_absen,
            'chartData' => $chartData,
            'nama' => $request->nama,
            'bulan' => $request->bulan,
            'start_bulan' => $request->start_bulan,
            'end_bulan' => $request->end_bulan,
        ]);
    }

    public function laporanAbsen()
    {
        $var_absen = Absen::with('guru')->get();
        return view('laporan.laporanabsen', compact('var_absen'));
    }   

    public function cetakPDFAbsen(Request $request)
    {
        $query = Absen::with('guru');

        // Filter berdasarkan nama guru
        if ($request->filled('nama')) {
            $query->whereHas('guru', function ($q) use ($request) {
                $q->where('namaguru', 'like', '%' . $request->nama . '%');
            });
        }

        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', '=', date('m', strtotime($request->bulan)))
                ->whereYear('tanggal', '=', date('Y', strtotime($request->bulan)));
        }

        // Filter berdasarkan rentang periode bulan
        if ($request->filled('start_bulan') && $request->filled('end_bulan')) {
            $query->whereBetween('tanggal', [
                date('Y-m-01', strtotime($request->start_bulan)),
                date('Y-m-t', strtotime($request->end_bulan))
            ]);
        }

        $var_absen = $query->get();

        // Cek apakah ada lebih dari satu guru
        $guru = $var_absen->pluck('guru')->unique('id')->count() > 1;

        // Load view PDF dengan data yang sudah difilter
        $pdf = PDF::loadView('laporan.pdfabsen', [
            'var_absen' => $var_absen,
            'nik' => empty($request->nama) ? '' : ($guru ? '-' : ($var_absen->first()->guru->nik ?? '-')),
            'namaguru' => empty($request->nama) ? '' : ($guru ? '-' : ($var_absen->first()->guru->namaguru ?? '-')),
            'bulan' => $request->bulan,
            'start_bulan' => $request->start_bulan,
            'end_bulan' => $request->end_bulan
        ]);

        // Tampilkan PDF di browser
        return $pdf->stream('Laporan_Absensi_' . now()->format('Ymd_His') . '.pdf');
    }

    public function laporanGurutampil()
    {
        $dataguru = Guru::all();
        return view('laporan.laporanguru', ['var_guru' => $dataguru]);
    }

    public function filterGuru(Request $request)
    {
        $query = Guru::query();
    
        // Filter berdasarkan nama guru
        if ($request->filled('nama')) {
            $query->where('namaguru', 'LIKE', '%' . $request->nama . '%');
        }
    
        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', '=', date('m', strtotime($request->bulan)))
                ->whereYear('created_at', '=', date('Y', strtotime($request->bulan)));
        }
    
        // Filter berdasarkan rentang periode bulan
        if ($request->filled('start_bulan') && $request->filled('end_bulan')) {
            $query->whereBetween('created_at', [
                date('Y-m-01', strtotime($request->start_bulan)),
                date('Y-m-t', strtotime($request->end_bulan))
            ]);
        }
    
        $var_guru = $query->get();
    
        if ($request->ajax()) {
            return view('laporan.guru_data', compact('var_guru'))->render();
        }
    
        return view('laporan.laporanguru', compact('var_guru'));
    }

    public function laporanGuru(Request $request)
    {
        $query = Guru::query();
    
        if ($request->filled('nama')) {
            $query->where('namaguru', 'LIKE', '%' . $request->nama . '%');
        }
        
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', '=', date('m', strtotime($request->bulan)))
                ->whereYear('created_at', '=', date('Y', strtotime($request->bulan)));
        }
    
        if ($request->filled('start_bulan') && $request->filled('end_bulan')) {
            $query->whereBetween('created_at', [
                date('Y-m-01', strtotime($request->start_bulan)),
                date('Y-m-t', strtotime($request->end_bulan))
            ]);
        }
    
        $var_guru = $query->get();
    
        if ($request->ajax()) {
            return view('laporan.guru_data', compact('var_guru'))->render();
        }
    
        return view('laporan.laporanguru', compact('var_guru'));
    }

    public function cetakPDFGuru(Request $request)
    {
        $query = Guru::query();
        
        // Filter berdasarkan bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', '=', date('m', strtotime($request->bulan)))
                ->whereYear('created_at', '=', date('Y', strtotime($request->bulan)));
        }
        
        // Filter berdasarkan rentang periode bulan
        if ($request->filled('start_bulan') && $request->filled('end_bulan')) {
            $query->whereBetween('created_at', [
                date('Y-m-01', strtotime($request->start_bulan)),
                date('Y-m-t', strtotime($request->end_bulan))
            ]);
        }
        
        $var_guru = $query->get();
        
        $pdf = PDF::loadView('laporan.pdfguru', [
            'var_guru' => $var_guru,
            'bulan' => $request->bulan,
            'start_bulan' => $request->start_bulan,
            'end_bulan' => $request->end_bulan,
        ]);
        
        return $pdf->stream('Laporan_Data_Guru_' . now()->format('Ymd_His') . '.pdf');
    }


    public function autocompleteGuru(Request $request)
    {
        $search = $request->get('term');

        // Ambil data guru berdasarkan nama yang mengandung substring dari term yang diketik
        $gurus = Guru::where('namaguru', 'LIKE', '%' . $search . '%')
                        ->pluck('namaguru');

        // Kembalikan sebagai response JSON untuk digunakan oleh jQuery UI Autocomplete
        return response()->json($gurus);
    }
}
