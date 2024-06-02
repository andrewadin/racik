<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Konsumen;

class KonsumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $konsumen = [
            ["Andrew", "08123456789101", "Perumahan Sumbersari Permai 1 Blok R-21"],
            ["Adjie", "089765432109", "Jalan Raya Cibadak-Ciampea No. 24"]
        ];
        foreach($konsumen as $kons){
            Konsumen::updateOrCreate([
                "nama" => $kons[0],
                "no_hp" => $kons[1],
                "alamat" => $kons[2]
            ]);
        }
    }
}
