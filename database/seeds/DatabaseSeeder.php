<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
//        $this->call(SectionSeeder::class);
//        $this->call(DomainSeeder::class);
//        $this->call(PageSeeder::class);
//        $this->call(BlockSeeder::class);
    }
}
