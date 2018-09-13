<?php

use Illuminate\Database\Seeder;

use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = new Role();
        $role_user->name = 'user';
        $role_user->description = 'User';
        $role_user->save();

        $role_manager = new Role();
        $role_manager->name = 'manager';
        $role_manager->description = 'Manager';
        $role_manager->save();
    }
}
