<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UploadSeeder extends Seeder
{
    public function run()
    {
        DB::table('uploads')->insert([
            [
                'equipment_id' => 1,
                'file_path' => 'uploads/drill_manual.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'equipment_id' => 2,
                'file_path' => 'uploads/welding_manual.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'equipment_id' => 3,
                'file_path' => 'uploads/jack_manual.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
