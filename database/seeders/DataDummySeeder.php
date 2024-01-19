<?php

namespace Database\Seeders;

use App\Models\Armada;
use App\Models\JenisArmada;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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

        JenisArmada::create([
            'nama' => 'Ro-Ro Vessels',
        ]);

        JenisArmada::create([
            'nama' => 'LNG Carriers',
        ]);

        JenisArmada::create([
            'nama' => 'Large Crude Carriers',
        ]);

        JenisArmada::create([
            'nama' => 'Reefer Vessels',
        ]);

        JenisArmada::create([
            'nama' => 'Breakbulk Vessels',
        ]);

        // DUMMY ARMADA
        Armada::create([
            'jenis_armada_id' => 1,
            'nomor'           => '12345',
            'kapasitas'       => 20000,
            'ketersediaan'    => 1,
        ]);

        Armada::create([
            'jenis_armada_id' => 1,
            'nomor'           => '56789',
            'kapasitas'       => 50000,
            'ketersediaan'    => 1,
        ]);

        Armada::create([
            'jenis_armada_id' => 1,
            'nomor'           => '54321',
            'kapasitas'       => 150000,
            'ketersediaan'    => 1,
        ]);

        Armada::create([
            'jenis_armada_id' => 2,
            'nomor'           => '11111',
            'kapasitas'       => 25000,
            'ketersediaan'    => 1,
        ]);

        Armada::create([
            'jenis_armada_id' => 2,
            'nomor'           => '22222',
            'kapasitas'       => 55000,
            'ketersediaan'    => 1,
        ]);

        Armada::create([
            'jenis_armada_id' => 2,
            'nomor'           => '33333',
            'kapasitas'       => 155000,
            'ketersediaan'    => 1,
        ]);

        Armada::create([
            'jenis_armada_id' => 7,
            'nomor'           => '1212',
            'kapasitas'       => 25000,
            'ketersediaan'    => 1,
        ]);

        Armada::create([
            'jenis_armada_id' => 7,
            'nomor'           => '2121',
            'kapasitas'       => 55000,
            'ketersediaan'    => 0,
        ]);

        Armada::create([
            'jenis_armada_id' => 7,
            'nomor'           => '3131',
            'kapasitas'       => 155000,
            'ketersediaan'    => 1,
        ]);

        Armada::create([
            'jenis_armada_id' => 5,
            'nomor'           => '88888',
            'kapasitas'       => 35000,
            'ketersediaan'    => 1,
        ]);

        Armada::create([
            'jenis_armada_id' => 5,
            'nomor'           => '99999',
            'kapasitas'       => 35000,
            'ketersediaan'    => 0,
        ]);

        Armada::create([
            'jenis_armada_id' => 5,
            'nomor'           => '77777',
            'kapasitas'       => 135000,
            'ketersediaan'    => 1,
        ]);
    }
}
