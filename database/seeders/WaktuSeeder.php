<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WaktuKirim;

class WaktuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $waktu = ["Lunch", "Dinner", "Lunch & Dinner"];
        foreach($waktu as $wkt){
            WaktuKirim::updateOrCreate([
                'waktu' => $wkt
            ]);
        }
    }
}
