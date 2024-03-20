<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ["ADMIN", "TIM DAPUR"];
        foreach ($roles as $rls) {
            Role::updateOrCreate([
                "nama_role" => $rls
            ]);
        }
    }
}
