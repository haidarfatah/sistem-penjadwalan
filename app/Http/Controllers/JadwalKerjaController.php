<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalKerja;
use App\Models\Karyawan;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;


class JadwalKerjaController extends Controller
{



    public function jadwalBelum()
    {
        // Ambil data karyawan yang belum memiliki jadwal kerja
        $karyawan = Karyawan::with('pengguna')
            ->whereHas('pengguna', function ($query) {
                $query->where('role', 'karyawan');
            })
            ->get()
            ->sortBy(fn($k) => $k->pengguna->nama);

        // Ambil data jadwal kerja yang sudah ada
        $jadwalKerja = JadwalKerja::with('karyawan.pengguna')
            ->orderBy('tanggal', 'asc')
            ->get()
            ->groupBy('id_karyawan');

        return view('admin.jadwalkerja.jadwal-belum', compact('karyawan', 'jadwalKerja'));
    }


    public function belumMemilikiJadwal()
    {
        $karyawan = Karyawan::doesntHave('jadwalKerja')->get();
        return view('jadwalkerja.belum', compact('karyawan'));
    }


    public function simpan(Request $request)
    {
        Log::info('Data diterima:', $request->all());

        $request->validate([
            'id_karyawan' => 'required|exists:karyawan,id_karyawan',
            'tanggal' => 'required|date',
            'shift' => 'required|in:pagi,siang,malam',
        ]);

        $tanggalMulai = $request->tanggal;
        $idKaryawan = $request->id_karyawan;
        $shift = $request->shift;

        // Menambahkan 5 hari kerja secara otomatis
        for ($i = 0; $i < 5; $i++) {
            JadwalKerja::create([
                'id_karyawan' => $idKaryawan,
                'tanggal' => date('Y-m-d', strtotime("+$i days", strtotime($tanggalMulai))),
                'shift' => $shift,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil ditambahkan untuk 5 hari kerja!'
        ]);
    }



    public function sudahMemilikiJadwal()
    {
        $jadwalKerja = JadwalKerja::with('karyawan.pengguna')->get()->groupBy('id_karyawan');
        return view('jadwalkerja.sudah', compact('jadwalKerja'));
    }



    public function jadwalSudah()
    {
        // Ambil data karyawan yang sudah memiliki jadwal kerja
        $jadwalKerja = JadwalKerja::with('karyawan.pengguna')
            ->orderBy('tanggal', 'asc')
            ->get()
            ->groupBy('id_karyawan');

        return view('admin.jadwalkerja.jadwal-sudah', compact('jadwalKerja'));
    }




    public function perbarui(Request $request)
    {
        Log::info('Data diterima:', $request->all());
    
        $request->validate([
            'id_jadwal' => 'required|exists:jadwal_kerja,id_jadwal',
            'tanggal' => 'required|date',
            'shift' => 'required|in:pagi,siang,malam',
        ]);
    
        $jadwal = JadwalKerja::find($request->id_jadwal);
        if (!$jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan!'
            ]);
        }
    
        $idKaryawan = $jadwal->id_karyawan;
        $tanggalBaru = $request->tanggal;
        $shift = $request->shift;
    
        // Ambil tanggal awal dan buat array tanggal baru
        $tanggalLama = $jadwal->tanggal;
        $selisihHari = (strtotime($tanggalBaru) - strtotime($tanggalLama)) / 86400; // Hitung selisih hari
    
        // Ambil semua jadwal 5 hari ke depan berdasarkan tanggal lama
        $jadwalLama = JadwalKerja::where('id_karyawan', $idKaryawan)
                                 ->whereBetween('tanggal', [
                                     $tanggalLama, 
                                     date('Y-m-d', strtotime("+4 days", strtotime($tanggalLama)))
                                 ])->get();
    
        // Update setiap jadwal dengan tanggal baru yang bergeser
        foreach ($jadwalLama as $index => $jadwalKerja) {
            $jadwalKerja->tanggal = date('Y-m-d', strtotime("+$selisihHari days", strtotime($jadwalKerja->tanggal)));
            $jadwalKerja->shift = $shift;
            $jadwalKerja->save();
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil diperbarui!',
            'tanggal_mulai' => date('d-m-Y', strtotime($tanggalBaru)),
            'tanggal_selesai' => date('d-m-Y', strtotime("+4 days", strtotime($tanggalBaru))),
            'shift' => ucfirst($shift),
            'id_karyawan' => $idKaryawan
        ]);
    }
    
    
}
