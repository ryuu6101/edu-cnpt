<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CoordinatePreset;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoordinatePresetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'name' => 'Vị trí 1',
            'department' => 'A2',
            'school' => 'A3',
            'class' => 'A4',
            'semester' => 'F3',
            'subject' => 'F4',
            'starting_row' => '8',
            'is_default' => true,
        ];

        CoordinatePreset::truncate();
        CoordinatePreset::insert($data);
    }
}
