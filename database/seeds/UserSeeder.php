<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_role = \App\Role::where('name','admin')->first();

        $user = \App\User::updateOrCreate([
            'email' => 'danixoid@gmail.com',
        ],[
            'name' => 'danixoid',
            'password' => Hash::make('Roamer'),
        ]);

        $user->roles()->attach($admin_role);
    }
}
