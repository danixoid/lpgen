<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(SectionSeeder::class);
        $this->call(DomainSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(BlockSeeder::class);
    }
}
