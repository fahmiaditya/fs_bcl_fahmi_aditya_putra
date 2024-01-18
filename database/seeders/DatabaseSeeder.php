<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {
            // disable fk constrain check
            // \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Call the php artisan migrate:refresh
            $this->command->call('migrate:refresh');
            $this->command->warn("Data cleared, starting from blank database.");

            // enable back fk constrain check
            // \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        // Seed the default permissions
        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $perms) {
            Permission::firstOrCreate(['name' => $perms, 'guard_name' => 'web']);
        }

        $this->command->info('Default Permissions added.');

        // Confirm roles needed
        if ($this->command->confirm('Create Roles for user, default is Super Admin, Admin, Customer ? [y|N]', true)) {

            // Ask for roles from input
            $input_roles = $this->command->ask('Enter roles in comma separate format.', 'Super Admin, Admin, Customer');

            // Explode roles
            $roles_array = explode(',', $input_roles);

            // add roles
            foreach($roles_array as $role) {
                $role = Role::firstOrCreate(['name' => trim($role), 'guard_name' => 'web']);

                if( $role->name == 'Super Admin') {
                    // assign all permissions
                    $role->syncPermissions(Permission::all());
                    $this->command->info('Super Admin granted all the permissions');
                } elseif ($role->name == 'Admin') {
                    // assign all permissions
                    $role->syncPermissions(Permission::all());
                    $this->command->info('Kadep granted all the permissions');
                } else {
                    $role->syncPermissions(Permission::where('name', 'LIKE', 'view_%')->get());
                }

                // create one user for each role
                $this->createUser($role);
            }

            $this->command->info('Roles ' . $input_roles . ' added successfully');

        } else {
            Role::firstOrCreate(['name' => 'Admin']);
            $this->command->info('Added only default Admin role.');
        }

        $this->call([
            DataDummySeeder::class,
        ]);
    }

    private function createUser($role)
    {
        if ($role->name == 'Super Admin') {
            $user 			 = new User();
            $user->name 	 = "Super Admin";
            $user->username  = "superadmin";
            $user->email 	 = "Superadmin@example.com";
            $user->password  = bcrypt("superadmin");
            $user->save();

            $user->assignRole($role->name);
        } elseif ($role->name == 'Admin') {
            $user 			 = new User();
            $user->name 	 = "Admin";
            $user->username  = "admin";
            $user->email 	 = "admin@example.com";
            $user->password  = bcrypt("admin");
            $user->save();

            $user->assignRole($role->name);
        } 

    	if( $role->name == 'Super Admin' ) {
    		$this->command->info('Here is your Super Admin details to login:');
    		$this->command->warn($user->username);
    		$this->command->warn('Password is "superadmin"');
    	}
    }
}
