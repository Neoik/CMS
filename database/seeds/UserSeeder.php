<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = Role::where('name', 'user')->first();
        factory(App\User::class, 10)->make()->each(function($u) use ($role_user) {
            $u->save();
            $u->roles()->save($role_user);
        });

        $role_manager = Role::where('name', 'manager')->first();
        factory(App\User::class, 1)->make()->each(function($u) use ($role_manager) {
            $u->save();
            $u->roles()->save($role_manager);
            $u->name = "meh";
            $u->password = bcrypt("secret");
            $u->email = "meh@me.com";
            $u->save();
        });
    }
}
