<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Log;

class KaryawanController extends Controller
{
    public function index()
    {
        // Ambil hanya karyawan yang memiliki role 'karyawan' pada tabel pengguna
        $karyawans = Karyawan::whereHas('pengguna', function ($query) {
            $query->where('role', 'karyawan');
        })->with('pengguna')->get();

        // Debug: Cek apakah data karyawan ditemukan
        // dd($karyawans);

        return view('admin.karyawan.index', compact('karyawans'));
    }


    public function tambah()
    {
        return view('admin.karyawan.tambah');
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|string|min:6',
            'posisi' => 'required|string|in:Operator Produksi,Tenaga Produksi,Staff Gudang',
            'gaji' => 'required|numeric|min:0',
        ]);


        // Simpan ke pengguna
        $pengguna = Pengguna::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'karyawan',
        ]);

        // Simpan ke karyawan
        // Pastikan id_pengguna diambil dengan benar
        $karyawan = Karyawan::create([
            'id_pengguna' => $pengguna->id_pengguna, // Pastikan pakai "id", bukan "id_pengguna"
            'posisi' => $request->posisi,
            'gaji' => $request->gaji,
        ]);

        // // Debug untuk cek apakah data karyawan masuk
        // dd($karyawan);
        // dd($pengguna);

        return redirect()->route('karyawan.index')->with('sukses', 'Karyawan berhasil ditambahkan!');
    }





    public function edit($id_karyawan)
    {
        $karyawan = Karyawan::with('pengguna')->findOrFail($id_karyawan);
        return view('admin.karyawan.edit', compact('karyawan'));
    }






    public function update(Request $request, $id_karyawan)
    {
        $karyawan = Karyawan::findOrFail($id_karyawan);
        $pengguna = $karyawan->pengguna;
    
        try {
            $pengguna->update([
                'nama' => $request->nama,
                'email' => $request->email,
            ]);
    
            $karyawan->update([
                'posisi' => $request->posisi,
                'gaji' => $request->gaji,
            ]);
    
            // Log perubahan data
            Log::info('Data karyawan berhasil diperbarui:', [
                'nama' => $request->nama,
                'email' => $request->email,
                'posisi' => $request->posisi,
                'gaji' => $request->gaji
            ]);
    
            return redirect()->route('karyawan.index')->with('sukses', 'Karyawan berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui karyawan: ' . $e->getMessage());
            return redirect()->route('karyawan.index')->with('gagal', 'Terjadi kesalahan saat memperbarui karyawan!');
        }
    }
    


    public function hapus($id_karyawan)
    {
        $karyawan = Karyawan::findOrFail($id_karyawan);
        $pengguna = $karyawan->pengguna;

        // Menghapus data karyawan dan pengguna terkait
        $karyawan->delete();
        $pengguna->delete();

        // Redirect kembali ke halaman daftar karyawan
        return redirect()->route('admin.karyawan.index')->with('sukses', 'Karyawan berhasil dihapus!');
    }
}
