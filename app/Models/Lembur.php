<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    use HasFactory;

    protected $table = 'lembur';
    protected $primaryKey = 'id_lembur';
    public $timestamps = false;

    protected $fillable = [
        'id_karyawan', 'tanggal', 'jam_mulai', 'jam_selesai', 'durasi_jam', 'tarif_lembur'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}
