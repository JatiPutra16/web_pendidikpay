<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Gaji;
use App\Models\Absen;
use App\Models\Guru;
use PDF;
use Carbon\Carbon;

class GajiController extends Controller
{
    public function gajitampil(Request $request)
    {
        // Mendapatkan bulan dan tahun saat ini
        $bulan = now()->month;
        $tahun = now()->year;

        // Ambil data absen bulan ini dan tahun ini
        $dataabsen = Absen::select('idabsen', 'idguru', 'jumlah_jam', 'jumlah_hari')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->get();

        // Ambil data guru yang memiliki absensi pada bulan ini
        $dataguru = Guru::whereIn('idguru', $dataabsen->pluck('idguru')->unique())
                        ->get();

        // Gabungkan data absensi dengan data guru
        $absen_with_guru = $dataabsen->map(function ($absen) use ($dataguru) {
            $guru = $dataguru->where('idguru', $absen->idguru)->first();
            return [
                'idabsen' => $absen->idabsen,
                'namaguru' => $guru ? $guru->namaguru : 'Unknown'
            ];
        });

        // Eager loading data gaji dengan relasi guru dan absen
        $datagaji = Gaji::with(['guru', 'absen'])->get();

        // Mengirim data ke view
        return view('gaji.gaji', [
            'var_gaji' => $datagaji,
            'var_absen' => $dataabsen,
            'absen_with_guru' => $absen_with_guru,
            'bulan' => $bulan,
        ]);
    }


    public function getJumlahHari($id)
    {
        $guru = Guru::find($id);
        $jumlahHari = $guru->jumlah_hari;

        return response()->json(['jumlah_hari' => $jumlahHari]);
    }

    public function getIdAbsen($id)
    {
        $absen = Absen::where('idabsen', $id)->first();

        if ($absen !== null) {
            return response()->json($absen);
        }

        return response()->json(['message' => 'Data absensi tidak ditemukan'], 404);
    }


    public function getGajiPerJam($id)
    {
        // Ambil data absensi berdasarkan idabsen
        $absen = Absen::where('idabsen', $id)->first();

        // Jika data absensi tidak ditemukan
        if ($absen === null) {
            return response()->json(['message' => 'Data absensi tidak ditemukan'], 404);
        }

        // Ambil gaji per jam berdasarkan idguru dari absensi
        $gaji = Guru::where('idguru', $absen->idguru)->value('gajiperjam');

        // Jika gaji per jam ditemukan, kembalikan sebagai JSON
        if ($gaji !== null) {
            return response()->json($gaji);
        }

        // Jika gaji per jam tidak ditemukan
        return response()->json(['message' => 'Gaji per jam tidak ditemukan'], 404);
    }


    public function getAbsenData($id)
    {
        $absen = Absen::where('idabsen', $id)
            ->select('jumlah_jam', 'jumlah_hari')
            ->first();

        if ($absen !== null) {
            return response()->json($absen);
        }

        return response()->json(['message' => 'Data absensi tidak ditemukan'], 404);
    }



    public function tambah(Request $request)
    {
        $existingGaji = Gaji::where('idabsen', $request->idabsen)
            ->whereMonth('tgl_gaji', Carbon::parse($request->tgl_gaji)->month)
            ->whereYear('tgl_gaji', Carbon::parse($request->tgl_gaji)->year)
            ->first();

        if ($existingGaji) {
            return redirect('/gaji')->with('error', 'Data gaji untuk bulan ini sudah ditambahkan. Anda hanya bisa menambahkannya di bulan selanjutnya.');
        }

        // Menghapus format RP dan koma dari input sebelum menyimpannya ke database
        $gajiperjam = intval(str_replace(['RP ', ','], '', $request->gajiperjam));
        $total_gaji = intval(str_replace(['RP ', ','], '', $request->total_gaji));
        $gaji_bersih = intval(str_replace(['RP ', ','], '', $request->gaji_bersih));

        // Menyimpan data ke dalam tabel Gaji
        Gaji::create([
            'idabsen' => $request->idabsen,
            'gajiperjam' => $gajiperjam,
            'total_jam' => $request->total_jam,
            'total_gaji' => $total_gaji,
            'gaji_bersih' => $gaji_bersih,
            'tgl_gaji' => $request->tgl_gaji,
        ]);

        // Update status_gaji pada absen menjadi Sudah Dibayar
        Absen::where('idabsen', $request->idabsen)
            ->update(['status_gaji' => 'Sudah Dibayar']);

        return redirect('/gaji')->with('success', 'Data gaji berhasil ditambahkan.');
    }


    public function delete(Request $request)
    {
        $id = $request->input('idgaji');

        $datagaji = Gaji::find($id);

        if (!$datagaji) {
            return redirect('/gaji');
        }

        $datagaji->delete();

        // Update status_gaji pada absen menjadi Belum Dibayar
        Absen::where('idabsen', $datagaji->idabsen)
            ->update(['status_gaji' => 'Belum Dibayar']);

        return redirect('/gaji');
    }
    public function cetakPDF($bulan = 'all', $id = null)
    {
        $tahun = now()->year;
        $namaBulan = $bulan !== 'all' ? Carbon::createFromDate($tahun, $bulan, 1)->format('F') : 'Semua Bulan';

        $query = Gaji::with('guru'); // Eager load guru

        if ($bulan !== 'all') {
            $query->whereMonth('tgl_gaji', $bulan);
        }

        if ($id) {
            $query->where('id', $id);
        }

        $gaji = $query->get();

        $pdf = PDF::loadView('gaji.pdf', compact('gaji', 'namaBulan', 'tahun'));
        return $pdf->stream('laporan-gaji-' . $namaBulan . '.pdf');
    }


    public function cetakPDFprive($id)
    {
        $gaji = Gaji::with(['guru', 'absen'])->findOrFail($id);

        $pdf = PDF::loadView('gaji.pdf-prive', compact('gaji'));
        return $pdf->stream('laporan-gaji-' . $gaji->namaguru . '.pdf');
    }
}