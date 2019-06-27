<?php

use App\User;
use App\Role;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provider = Role::find(1);
        $client = Role::find(2);

        $user = User::create([
            'name' => 'jose perez',
            'email' => 'jose.perez@project.com',
            'password' => bcrypt('secret')
        ]);

        $user->roles()->attach($provider);

        $user = User::create([
            'name' => 'juan garcia',
            'email' => 'juan.garcia@project.com',
            'password' => bcrypt('secret')
        ]);

        $user->roles()->attach($client);
    }
}
