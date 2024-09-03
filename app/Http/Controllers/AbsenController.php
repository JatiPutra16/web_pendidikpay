<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Absen;
use App\Models\Guru;

use PDF;
use Carbon\Carbon;

class AbsenController extends Controller
{
    public function absentampil(Request $request){
        $dataabsen = Absen::all();
        $dataguru = Guru::all();

        $bulan = now()->month;

        return view('absen.absen', [
            'var_absen' => $dataabsen,
            'var_guru' => $dataguru,
            'bulan' => $bulan,
        ]);
    }

    public function tambah(Request $request)
    {
        $this->validate($request,[
            'nik' => 'required',
            'jumlah_jam' => 'required',
            'jumlah_hari' => 'required',
            'tanggal' => 'required|date'
        ]);

        // Cek apakah sudah ada data absen untuk bulan dan tahun yang sama
        $existingAbsen = Absen::where('idguru', $request->nik)
            ->whereMonth('tanggal', date('m', strtotime($request->tanggal)))
            ->whereYear('tanggal', date('Y', strtotime($request->tanggal)))
            ->first();

        if ($existingAbsen) {
            // Jika sudah ada, tampilkan pesan menggunakan SweetAlert
            return redirect('/absen')->with('error', 'Data absen sudah ada untuk bulan ini. Tidak bisa ditambahkan lagi.');
        }

        // Jika belum ada, tambahkan data absen
        Absen::create([
            'idguru' => $request->nik,
            'jumlah_jam' => $request->jumlah_jam,
            'jumlah_hari' => $request->jumlah_hari,
            'tanggal' => $request->tanggal,
            'status_gaji' => "Belum Dibayar",
        ]);

        return redirect('/absen')->with('success', 'Data absen berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $absen = Absen::find($id);
        return view('absen.edit', compact('absen'));
    }


    public function update(Request $request, $id) 
    {

        $absen              = Absen::find($id);
        $absen->idguru      = $request->nik;
        $absen->jumlah_jam  = $request->jumlah_jam;
        $absen->jumlah_hari = $request->jumlah_hari;
        $absen->tanggal     = $request->tanggal;
        $absen->save();

        return redirect('/absen')->with('success', 'Data absen berhasil diupdate.');
    }
    

    public function delete(Request $request)
    {
        $id = $request->input('idabsen');

        $dataabsen = Absen::find($id);

        if (!$dataabsen) {
            return redirect('/absen');
        }

        $dataabsen->delete();

        return redirect('/absen')->with('success', 'Data absen berhasil dihapus.');
    }

    public function cetakPDF($bulan = null)
    {
        $tahun = now()->year; // Mengambil tahun saat ini, atau sesuaikan sesuai kebutuhan
        $namaBulan = $bulan ? Carbon::createFromDate($tahun, $bulan, 1)->format('F') : 'Semua Bulan';
    
        $absen = Absen::with('guru')
                        ->when($bulan, function ($query) use ($bulan) {
                            return $query->whereMonth('tanggal', $bulan);
                        })
                        ->get();
    
        $pdf = PDF::loadView('absen.pdf', compact('absen', 'namaBulan', 'tahun'));
        return $pdf->stream();
    }

    public function getDataAbsen($id)
    {
        $absen = Absen::where('idguru', $id)->first(); 

        if ($absen) {
            return response()->json([
                'jumlah_jam' => $absen->jumlah_jam,
                'jumlah_hari' => $absen->jumlah_hari
            ]);
        } else {
            return response()->json(['message' => 'Data not found'], 404);
        }
    }

}
