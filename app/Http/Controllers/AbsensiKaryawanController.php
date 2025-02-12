<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\JadwalKerja;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class AbsensiKaryawanController extends Controller
{
    // **1. Menampilkan Halaman Absensi**
    public function index()
    {
        $karyawan = Karyawan::where('id_pengguna', Auth::id())->first();

        if (!$karyawan) {
            return redirect()->route('dashboard')->with('error', 'Anda bukan karyawan.');
        }

        // Ambil data absensi hari ini
        $absensiHariIni = Absensi::where('id_karyawan', $karyawan->id_karyawan)
            ->whereDate('tanggal', now()->toDateString())
            ->first();

        return view('karyawan.absensi.index', compact('absensiHariIni'));
    }


    // **2. Absen Masuk**
    public function masuk()
    {
        try {
            // Ambil data karyawan berdasarkan ID pengguna yang login
            $karyawan = Karyawan::where('id_pengguna', Auth::id())->first();

            if (!$karyawan) {
                return redirect()->route('karyawan.absensi.index')->with('error', 'Anda tidak terdaftar sebagai karyawan.');
            }

            // Cek apakah sudah absen masuk hari ini
            $absensiHariIni = Absensi::where('id_karyawan', $karyawan->id_karyawan)
                ->where('tanggal', Carbon::now('Asia/Jakarta')->toDateString())
                ->first();

            if ($absensiHariIni) {
                return redirect()->route('karyawan.absensi.index')->with('error', 'Anda sudah absen masuk hari ini.');
            }

            // **Simpan data absensi**
            $absensi = new Absensi();
            $absensi->id_karyawan = $karyawan->id_karyawan;
            $absensi->tanggal = Carbon::now('Asia/Jakarta')->toDateString();
            $absensi->jam_masuk = Carbon::now('Asia/Jakarta')->toTimeString();
            $absensi->jam_keluar = null;
            $absensi->status = 'hadir';
            $absensi->bukti = null;
            $absensi->save(); // Simpan data ke database

            return redirect()->route('karyawan.absensi.index')->with('sukses', 'Absen masuk berhasil!');
        } catch (\Exception $e) {
            return redirect()->route('karyawan.absensi.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    // **3. Absen Keluar**
    public function keluar()
    {
        try {
            // Ambil data karyawan berdasarkan ID pengguna yang login
            $karyawan = Karyawan::where('id_pengguna', Auth::id())->first();

            if (!$karyawan) {
                return redirect()->route('karyawan.absensi.index')->with('error', 'Anda tidak terdaftar sebagai karyawan.');
            }

            // Cek apakah sudah absen masuk hari ini
            $absensi = Absensi::where('id_karyawan', $karyawan->id_karyawan)
                ->where('tanggal', Carbon::now('Asia/Jakarta')->toDateString())
                ->first();

            if (!$absensi) {
                return redirect()->back()->with('error', 'Anda belum melakukan absen masuk.');
            }

            if ($absensi->jam_keluar) {
                return redirect()->back()->with('error', 'Anda sudah absen keluar hari ini.');
            }

            // Simpan jam keluar
            $absensi->jam_keluar = Carbon::now('Asia/Jakarta')->toTimeString();
            $absensi->save();

            return redirect()->back()->with('sukses', 'Jam keluar berhasil dicatat.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    // **4. Izin atau Sakit**

    public function izinSakit(Request $request)
    {
        $request->validate([
            'status' => 'required|in:izin,sakit',
            'bukti_absensi' => 'required|mimes:jpg,jpeg,png,pdf|max:10240' // Maksimal 10MB
        ]);
    
        $karyawan = Karyawan::where('id_pengguna', Auth::id())->first();
    
        if (!$karyawan) {
            return redirect()->route('karyawan.absensi.index')->with('error', 'Anda tidak terdaftar sebagai karyawan.');
        }
    
        // Simpan file bukti ke storage Laravel
        $file = $request->file('bukti_absensi');
        $filePath = $file->store('bukti_absen_karyawan', 'public'); // Simpan di storage/app/public/bukti_absen_karyawan
        // dd($filePath);
        // Simpan path ke database
        Absensi::create([
            'id_karyawan' => $karyawan->id_karyawan,
            'tanggal' => now()->toDateString(),
            'jam_masuk' => null,
            'jam_keluar' => null,
            'status' => $request->status,
            'bukti' => $filePath, // Path yang benar
        ]);
    
        return redirect()->route('karyawan.absensi.index')->with('sukses', 'Izin/Sakit berhasil diajukan.');
    }
    


    // **5. Melihat Riwayat Absensi**
    public function riwayat()
    {
        $karyawan = Karyawan::where('id_pengguna', Auth::id())->first();

        if (!$karyawan) {
            return redirect()->route('karyawan.absensi.index')->with('error', 'Anda tidak terdaftar sebagai karyawan.');
        }

        $riwayatAbsensi = Absensi::where('id_karyawan', $karyawan->id_karyawan)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('karyawan.absensi.riwayat', compact('riwayatAbsensi'));
    }
}
