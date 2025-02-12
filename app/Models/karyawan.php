<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan'; // Nama tabel
    protected $primaryKey = 'id_karyawan'; // Primary key

    protected $fillable = [
        'id_pengguna',
        'posisi',
        'gaji',
    ];
  // Relasi ke Absensi (One to Many)
  public function absensi()
  {
      return $this->hasMany(Absensi::class, 'id_karyawan', 'id_karyawan');
  }

  // Relasi ke Pengguna (One to One)
  public function pengguna()
  {
      return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id_pengguna');
  }

     // Relasi ke Jadwal
     public function jadwalKerja()
     {
         return $this->hasMany(JadwalKerja::class, 'id_karyawan', 'id_karyawan');
     }

     public $timestamps = false; // Menonaktifkan timestamps
}
