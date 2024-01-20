<?php

namespace Database\Seeders;

use App\Models\User;
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
        $user 			 = new User();
        $user->name 	 = "Armada 12345";
        $user->username  = "12345";
        $user->email 	 = "12345@example.com";
        $user->password  = bcrypt("12345");
        $user->save();
        $user->assignRole('Armada');

        Armada::create([
            'user_id'         => $user->id,
            'jenis_armada_id' => 1,
            'nomor'           => '12345',
            'kapasitas'       => 20000,
            'ketersediaan'    => 1,
        ]);

        $user 			 = new User();
        $user->name 	 = "Armada 56789";
        $user->username  = "56789";
        $user->email 	 = "56789@example.com";
        $user->password  = bcrypt("56789");
        $user->save();
        $user->assignRole('Armada');

        Armada::create([
            'user_id'         => $user->id,
            'jenis_armada_id' => 1,
            'nomor'           => '56789',
            'kapasitas'       => 50000,
            'ketersediaan'    => 1,
        ]);

        $user 			 = new User();
        $user->name 	 = "Armada 54321";
        $user->username  = "54321";
        $user->email 	 = "54321@example.com";
        $user->password  = bcrypt("54321");
        $user->save();
        $user->assignRole('Armada');

        Armada::create([
            'user_id'         => $user->id,
            'jenis_armada_id' => 1,
            'nomor'           => '54321',
            'kapasitas'       => 150000,
            'ketersediaan'    => 1,
        ]);
        
        $user 			 = new User();
        $user->name 	 = "Armada 11111";
        $user->username  = "11111";
        $user->email 	 = "11111@example.com";
        $user->password  = bcrypt("11111");
        $user->save();
        $user->assignRole('Armada');

        Armada::create([
            'user_id'         => $user->id,
            'jenis_armada_id' => 2,
            'nomor'           => '11111',
            'kapasitas'       => 25000,
            'ketersediaan'    => 1,
        ]);

        $user 			 = new User();
        $user->name 	 = "Armada 22222";
        $user->username  = "22222";
        $user->email 	 = "22222@example.com";
        $user->password  = bcrypt("22222");
        $user->save();
        $user->assignRole('Armada');

        Armada::create([
            'user_id'         => $user->id,
            'jenis_armada_id' => 2,
            'nomor'           => '22222',
            'kapasitas'       => 55000,
            'ketersediaan'    => 1,
        ]);

        $user 			 = new User();
        $user->name 	 = "Armada 33333";
        $user->username  = "33333";
        $user->email 	 = "33333@example.com";
        $user->password  = bcrypt("33333");
        $user->save();
        $user->assignRole('Armada');

        Armada::create([
            'user_id'         => $user->id,
            'jenis_armada_id' => 2,
            'nomor'           => '33333',
            'kapasitas'       => 155000,
            'ketersediaan'    => 1,
        ]);

        $user 			 = new User();
        $user->name 	 = "Armada 1212";
        $user->username  = "1212";
        $user->email 	 = "1212@example.com";
        $user->password  = bcrypt("1212");
        $user->save();
        $user->assignRole('Armada');

        Armada::create([
            'user_id'         => $user->id,
            'jenis_armada_id' => 7,
            'nomor'           => '1212',
            'kapasitas'       => 25000,
            'ketersediaan'    => 1,
        ]);

        $user 			 = new User();
        $user->name 	 = "Armada 2121";
        $user->username  = "2121";
        $user->email 	 = "2121@example.com";
        $user->password  = bcrypt("2121");
        $user->save();
        $user->assignRole('Armada');

        Armada::create([
            'user_id'         => $user->id,
            'jenis_armada_id' => 7,
            'nomor'           => '2121',
            'kapasitas'       => 55000,
            'ketersediaan'    => 0,
        ]);

        $user 			 = new User();
        $user->name 	 = "Armada 3131";
        $user->username  = "3131";
        $user->email 	 = "3131@example.com";
        $user->password  = bcrypt("3131");
        $user->save();
        $user->assignRole('Armada');

        Armada::create([
            'user_id'         => $user->id,
            'jenis_armada_id' => 7,
            'nomor'           => '3131',
            'kapasitas'       => 155000,
            'ketersediaan'    => 1,
        ]);

        $user 			 = new User();
        $user->name 	 = "Armada 88888";
        $user->username  = "88888";
        $user->email 	 = "88888@example.com";
        $user->password  = bcrypt("88888");
        $user->save();
        $user->assignRole('Armada');

        Armada::create([
            'user_id'         => $user->id,
            'jenis_armada_id' => 5,
            'nomor'           => '88888',
            'kapasitas'       => 35000,
            'ketersediaan'    => 1,
        ]);

        $user 			 = new User();
        $user->name 	 = "Armada 99999";
        $user->username  = "99999";
        $user->email 	 = "99999@example.com";
        $user->password  = bcrypt("99999");
        $user->save();
        $user->assignRole('Armada');

        Armada::create([
            'user_id'         => $user->id,
            'jenis_armada_id' => 5,
            'nomor'           => '99999',
            'kapasitas'       => 35000,
            'ketersediaan'    => 0,
        ]);

        $user 			 = new User();
        $user->name 	 = "Armada 77777";
        $user->username  = "77777";
        $user->email 	 = "77777@example.com";
        $user->password  = bcrypt("77777");
        $user->save();
        $user->assignRole('Armada');

        Armada::create([
            'user_id'         => $user->id,
            'jenis_armada_id' => 5,
            'nomor'           => '77777',
            'kapasitas'       => 135000,
            'ketersediaan'    => 1,
        ]);
    }
}
