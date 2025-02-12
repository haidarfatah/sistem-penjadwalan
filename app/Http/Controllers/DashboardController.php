<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Pengguna;
use App\Models\JadwalKerja;
use App\Models\Absensi;
use App\Models\Penggajian;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $data = [];

        if ($user->role === 'admin') {
            // **Admin Dashboard Data**
            $data['totalKaryawan'] = Karyawan::count();
            $data['totalPenggajian'] = Penggajian::count();

            // **Statistik Absensi Hari Ini**
            $data['hadir'] = Absensi::whereDate('tanggal', $today)->where('status', 'hadir')->count();
            $data['izin'] = Absensi::whereDate('tanggal', $today)->where('status', 'izin')->count();
            $data['sakit'] = Absensi::whereDate('tanggal', $today)->where('status', 'sakit')->count();
            $data['alpha'] = Absensi::whereDate('tanggal', $today)->where('status', 'alpha')->count();

            // **Daftar Karyawan Terbaru**
            $karyawanBaru = Karyawan::orderBy('id_karyawan', 'desc')->take(5)->get();

        } elseif ($user->role === 'karyawan') {
            // **Karyawan Dashboard Data**
            $karyawan = Karyawan::where('id_pengguna', $user->id_pengguna)->first();

            if ($karyawan) {
                // Cek absensi hari ini
                $absensiHariIni = Absensi::where('id_karyawan', $karyawan->id_karyawan)
                    ->whereDate('tanggal', $today)
                    ->first();

                $data['statusHariIni'] = $absensiHariIni ? ucfirst($absensiHariIni->status) : 'Belum Absen';

                // Ambil jadwal kerja (bisa diambil dari tabel lain jika ada)
                $data['jadwalHariIni'] = '08:00 - 17:00'; // Default jika tidak ada jadwal di DB

                // Hitung total hadir bulan ini
                $data['totalHadirBulanIni'] = Absensi::where('id_karyawan', $karyawan->id_karyawan)
                    ->whereMonth('tanggal', $today->month)
                    ->where('status', 'hadir')
                    ->count();
            } else {
                $data['statusHariIni'] = 'Data tidak ditemukan';
                $data['jadwalHariIni'] = 'Data tidak ditemukan';
                $data['totalHadirBulanIni'] = 0;
            }
        }

        return view('dashboard.index', $data);
    }
}
