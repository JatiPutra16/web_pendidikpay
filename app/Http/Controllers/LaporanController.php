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

    public function laporanGajitampil(Request $request)
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

        return view('laporan.laporangaji', [
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
        return view('laporan.laporangaji', compact('var_gaji'));
    }

    public function laporanGaji(Request $request)
    {
        // Ambil data gaji sesuai dengan filter yang diterapkan
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
    
        return view('laporan.laporangaji', [
            'var_gaji' => $var_gaji,
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
    
    

    public function laporanAbsentampil(Request $request)
    {
        $dataabsen = Absen::with('guru')->get();
        $dataguru = Guru::all();
        $bulan = now()->month;

        return view('laporan.laporanabsen', [
            'var_absen' => $dataabsen,
            'var_guru' => $dataguru,
            'bulan' => $bulan,
        ]);
    }

    public function filterAbsen(Request $request)
    {
        $query = Absen::query();

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

        $var_absen = $query->with('guru')->get();

        return view('laporan.laporanabsen', [
            'var_absen' => $var_absen,
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
            'nik' => $guru ? '-' : ($var_absen->first()->guru->nik ?? '-'),
            'namaguru' => $guru ? '-' : ($var_absen->first()->guru->namaguru ?? '-'),
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
