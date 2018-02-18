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
        $domain = \App\LDomain::create([ 'name' => 'lpgen.loc', 'user_id' => $user->id ]);
        $domain = \App\LDomain::create([ 'name' => 'b-apps.loc', 'user_id' => $user->id ]);
    }
}
