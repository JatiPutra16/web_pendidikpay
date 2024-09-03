<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use Illuminate\Support\Facades\File;

class GuruController extends Controller
{
    public function gurutampil()
    {
        $dataguru = Guru::all();
        return view('guru.guru', ['var_guru' => $dataguru]);
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'namaguru' => 'required',
            'alamat' => 'required',
            'tlp' => 'required',
            'gajiperjam' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        try {
            if ($request->hasFile('foto')) {
                $imageName = time() . '.' . $request->file('foto')->extension();
                $request->file('foto')->move(public_path('foto_guru'), $imageName);

                Guru::create([
                    'nik' => $request->nik,
                    'namaguru' => $request->namaguru,
                    'alamat' => $request->alamat,
                    'tlp' => $request->tlp,
                    'gajiperjam' => $request->gajiperjam,
                    'foto' => $imageName,
                ]);

                return redirect('/guru')->with('success', 'Data guru berhasil ditambahkan.');
            } else {
                return back()->withErrors(['foto' => 'File foto tidak ditemukan.']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $guru = Guru::find($id);
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required',
            'namaguru' => 'required',
            'alamat' => 'required',
            'tlp' => 'required',
            'gajiperjam' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $guru = Guru::find($id);

        if (!$guru) {
            return redirect('/guru')->withErrors('Data guru tidak ditemukan.');
        }

        $guru->nik = $request->nik;
        $guru->namaguru = $request->namaguru;
        $guru->alamat = $request->alamat;
        $guru->tlp = $request->tlp;
        $guru->gajiperjam = $request->gajiperjam;

        if ($request->hasFile('foto')) {
            // Hapus gambar lama jika ada
            $imagePath = public_path('foto_guru/' . $guru->foto);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            // Unggah gambar baru
            $imageName = time() . '.' . $request->file('foto')->extension();
            $request->file('foto')->move(public_path('foto_guru'), $imageName);
            $guru->foto = $imageName; // Update dengan nama gambar baru
        }

        $guru->save();

        return redirect('/guru')->with('success', 'Data guru berhasil diupdate.');
    }

    public function getGajiPerJam($idguru)
    {
        $guru = Guru::findOrFail($idguru);
        return response()->json($guru->gajiperjam);
    }

    public function delete(Request $request)
    {
        // Ambil ID dari request
        $id = $request->input('idguru');

        // Temukan guru berdasarkan ID
        $guru = Guru::find($id);

        if (!$guru) {
            return redirect('/guru')->withErrors('Data guru tidak ditemukan.');
        }

        // Hapus foto dari folder 'foto_guru'
        $imagePath = public_path('foto_guru/' . $guru->foto);
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        // Hapus data guru dari database
        $guru->delete();

        // Redirect ke halaman guru dengan pesan sukses
        return redirect('/guru')->with('success', 'Data guru berhasil dihapus.');
    }


}
