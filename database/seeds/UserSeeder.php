<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'name' => 'danixoid',
            'email' => 'danixoid@gmail.com',
            'password' => bcrypt('Roamer'),
        ]);
    }
}
