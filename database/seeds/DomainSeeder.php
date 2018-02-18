<?php

use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::firstOrFail();
        $domain = \App\LDomain::create([
            'name' => env('LPGEN_KZ','www.b-apps.kz'),
            'user_id' => $user->id
        ]);
    }
}
