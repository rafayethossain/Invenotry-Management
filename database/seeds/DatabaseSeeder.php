<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory(App\User::class, 1)->create();
		$this->call([
        	RolesTableSeeder::class,
        	PermissionsTableSeeder::class,
            ExpenseItemsTableSeeder::class,
        ]);
        $user = User::find(1);
        $super_admin = Role::find(1);
        $user->attachRole($super_admin);
    }
}
