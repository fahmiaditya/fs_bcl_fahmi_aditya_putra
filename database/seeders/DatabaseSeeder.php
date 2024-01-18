<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user 			 = new User();
        $user->name 	 = "Administrator";
        $user->username  = "admin";
        $user->email 	 = "admin@example.com";
        $user->password  = bcrypt("admin");
        $user->save();
    }
}
