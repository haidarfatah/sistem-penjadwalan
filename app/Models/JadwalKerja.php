<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKerja extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kerja';
    protected $primaryKey = 'id_jadwal';
    protected $fillable = ['id_karyawan', 'tanggal', 'shift'];

    public $timestamps = false; // Menonaktifkan timestamps


    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}
