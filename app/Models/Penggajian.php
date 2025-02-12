<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    use HasFactory;

    protected $table = 'penggajian'; // 👈 Pastikan nama tabel sesuai
    protected $fillable = ['id_karyawan', 'bulan', 'tahun', 'jumlah_gaji', 'status_pembayaran'];

    public $timestamps = false;
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}
