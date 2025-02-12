<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\JadwalKerja;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tanggal dari request, default hari ini
        $tanggal = $request->input('tanggal', date('Y-m-d'));

        // Ambil karyawan yang seharusnya masuk kerja berdasarkan jadwal kerja
        $jadwalKaryawan = JadwalKerja::where('tanggal', $tanggal)->pluck('id_karyawan')->toArray();

        // Ambil data absensi berdasarkan tanggal yang dipilih
        $absensi = Absensi::where('tanggal', $tanggal)->get();

        // Ambil semua karyawan yang memiliki jadwal kerja pada tanggal tersebut
        $karyawanMasuk = Karyawan::whereIn('id_karyawan', $jadwalKaryawan)->get();

        return view('admin.absensi.index', compact('absensi', 'tanggal', 'karyawanMasuk'));
    }
}
