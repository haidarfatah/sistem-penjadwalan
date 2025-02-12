<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PenggunaSeeder;

class DatabaseSeeder extends Seeder
{
  

    public function run()
    {
        $this->call(PenggunaSeeder::class);
    }
    
}
