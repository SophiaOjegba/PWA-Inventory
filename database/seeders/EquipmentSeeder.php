<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentSeeder extends Seeder
{
    public function run()
    {
        DB::table('equipments')->insert([
            [
                'equipment_number' => 'EQ001',
                'name' => 'Drill Machine',
                'description' => 'Electric drill machine with various bits',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'equipment_number' => 'EQ002',
                'name' => 'Welding Machine',
                'description' => 'Portable welding machine with accessories',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'equipment_number' => 'EQ003',
                'name' => 'Hydraulic Jack',
                'description' => 'Heavy duty hydraulic jack',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
