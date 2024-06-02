<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipePaket;

class TipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $x = ["Harian", "Mingguan", "Bulanan"];
        foreach($x as $s){
            TipePaket::updateOrCreate([
                "nama_tipe" => $s,
            ]);
        }
    }
}
