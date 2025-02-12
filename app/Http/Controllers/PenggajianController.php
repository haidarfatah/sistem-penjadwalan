<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penggajian;
use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\Notifikasi;
use Carbon\Carbon;

class PenggajianController extends Controller
{
    // 1️⃣ **Melihat daftar gaji karyawan**
    public function index()
    {
        // Ambil semua karyawan dengan relasi pengguna
        $karyawan = Karyawan::with('pengguna')->get();

        return view('admin.penggajian.index', compact('karyawan'));
    }

    // 2️⃣ **Melihat detail absensi & estimasi gaji karyawan**
    public function detailGaji($id_karyawan)
    {
        $karyawan = Karyawan::withCount([
            'absensi as hadir' => function ($query) {
                $query->where('status', 'hadir')
                      ->whereMonth('tanggal', Carbon::now()->format('m'))
                      ->whereYear('tanggal', Carbon::now()->format('Y'));
            },
            'absensi as izin' => function ($query) {
                $query->where('status', 'izin')
                      ->whereMonth('tanggal', Carbon::now()->format('m'))
                      ->whereYear('tanggal', Carbon::now()->format('Y'));
            },
            'absensi as sakit' => function ($query) {
                $query->where('status', 'sakit')
                      ->whereMonth('tanggal', Carbon::now()->format('m'))
                      ->whereYear('tanggal', Carbon::now()->format('Y'));
            },
            'absensi as alpha' => function ($query) {
                $query->where('status', 'alpha')
                      ->whereMonth('tanggal', Carbon::now()->format('m'))
                      ->whereYear('tanggal', Carbon::now()->format('Y'));
            }
        ])->findOrFail($id_karyawan);
    
        // Pastikan semua variabel ada
        $hadir = $karyawan->hadir ?? 0;
        $izin = $karyawan->izin ?? 0;
        $sakit = $karyawan->sakit ?? 0;
        $alpha = $karyawan->alpha ?? 0;
    
        // **Hitung Potongan Gaji**
        $potonganAlpha = $alpha * 50000; // Potongan untuk Alpha (Rp50.000 per hari)
    
        // **Potongan Izin/Sakit**
        $totalIzinSakit = $izin + $sakit;
        $potonganIzinSakit = ($totalIzinSakit > 3) ? (floor($totalIzinSakit / 3) * 50000) : 0;
    
        // **Total Potongan & Gaji Akhir**
        $totalPotongan = $potonganAlpha + $potonganIzinSakit;
        $totalGaji = $karyawan->gaji - $totalPotongan;
    
        return view('admin.penggajian.detail', compact(
            'karyawan', 'hadir', 'izin', 'sakit', 'alpha', 
            'totalGaji', 'totalPotongan', 'potonganAlpha', 'potonganIzinSakit'
        ));
    }
    

    // 3️⃣ **Serahkan gaji ke database setelah dikonfirmasi admin**
    public function serahkanGaji($id_karyawan)
    {
        $karyawan = Karyawan::withCount([
            'absensi as hadir' => function ($query) {
                $query->where('status', 'hadir')
                      ->whereMonth('tanggal', Carbon::now()->format('m'))
                      ->whereYear('tanggal', Carbon::now()->format('Y'));
            },
            'absensi as izin' => function ($query) {
                $query->where('status', 'izin')
                      ->whereMonth('tanggal', Carbon::now()->format('m'))
                      ->whereYear('tanggal', Carbon::now()->format('Y'));
            },
            'absensi as sakit' => function ($query) {
                $query->where('status', 'sakit')
                      ->whereMonth('tanggal', Carbon::now()->format('m'))
                      ->whereYear('tanggal', Carbon::now()->format('Y'));
            },
            'absensi as alpha' => function ($query) {
                $query->where('status', 'alpha')
                      ->whereMonth('tanggal', Carbon::now()->format('m'))
                      ->whereYear('tanggal', Carbon::now()->format('Y'));
            }
        ])->findOrFail($id_karyawan);

        $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('Y');

        // Hitung potongan gaji
        $potonganAlpha = $karyawan->alpha * 50000;
        $potonganIzinSakit = ($karyawan->izin + $karyawan->sakit > 3) ? ($karyawan->izin + $karyawan->sakit) * 50000 : 0;
        $totalPotongan = $potonganAlpha + $potonganIzinSakit;
        $totalGaji = $karyawan->gaji - $totalPotongan;

        // Simpan penggajian ke database
        Penggajian::updateOrCreate(
            ['id_karyawan' => $id_karyawan, 'bulan' => $bulan, 'tahun' => $tahun],
            [
                'jumlah_gaji' => $karyawan->gaji,
                'status_pembayaran' => 'sudah dibayar',
                'total_gaji' => $totalGaji
            ]
        );

        // Kirim notifikasi ke karyawan (pastikan relasi pengguna ada)
        if ($karyawan->pengguna) {
            Notifikasi::create([
                'id_pengguna' => $karyawan->pengguna->id_pengguna,
                'pesan' => "Gaji Anda untuk bulan $bulan $tahun telah dihitung dan diserahkan. Total Gaji: Rp" . number_format($totalGaji, 2)
            ]);
        }

        return redirect()->route('gaji.index')->with('sukses', 'Gaji telah diserahkan!');
    }
}
