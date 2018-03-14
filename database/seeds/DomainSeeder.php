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
            'name' => 'www',
            'user_id' => $user->id
        ]);
        $domain->l_aliases()->create([
            'name' => env('LPGEN_KZ','b-apps.kz')
        ]);
    }
}
