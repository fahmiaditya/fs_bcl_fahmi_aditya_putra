<?php

namespace Database\Seeders;

use App\Models\JenisArmada;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DUMMY JENIS ARMADA
        JenisArmada::create([
            'nama' => 'Truk trailer',
        ]);

        JenisArmada::create([
            'nama' => 'Truk box',
        ]);

        JenisArmada::create([
            'nama' => 'Truk bak terbuka',
        ]);

        JenisArmada::create([
            'nama' => 'Truk tangki',
        ]);

        JenisArmada::create([
            'nama' => 'Truk crane',
        ]);

        JenisArmada::create([
            'nama' => 'Container vessels',
        ]);

        JenisArmada::create([
            'nama' => 'General cargo ship',
        ]);
    }
}
