<?php 
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run()
    {
        DB::table('pengguna')->insert([
            // Admin
            [
                'nama' => 'Admin Utama',
                'email' => 'admin@sistem.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin'
            ],
            // Karyawan 1
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi@sistem.com',
                'password' => Hash::make('budi123'),
                'role' => 'karyawan'
            ],
            // Karyawan 2
            [
                'nama' => 'Siti Aminah',
                'email' => 'siti@sistem.com',
                'password' => Hash::make('siti123'),
                'role' => 'karyawan'
            ],
        ]);
    }
}
