<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Paket;

class PaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paket = [
            ["Paket A Harian", 1, 15000, "Paket Harian Porsi 1 Orang"],
            ["Paket A Mingguan", 2, 150000, "Paket Mingguan Porsi 1 Orang"],
            ["Paket A Bulanan", 3, 500000, "Paket Bulanan Porsi 1 Orang"],
        ];

        foreach ($paket as $pkt) {
            Paket::updateOrCreate([
                "nama_paket" => $pkt[0],
                "tipe_id" => $pkt[1],
                "harga" => $pkt[2],
                "deskripsi" => $pkt[3],
            ]);
        }
    }
}
