<?php

use Illuminate\Database\Seeder;

class NexusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('nexus')->insert([
            ['title' => 'Impl/Admin'],
            ['title' => 'Webi'],
            ['title' => 'ERQA'],
            ['title' => 'IQ'],
            ['title' => 'Afaria/Remoteware'],
            ['title' => 'EPM Disclosure Management'],
            ['title' => 'SQL Anywhere'],
            ['title' => 'SUP/SMP'],
            ['title' => 'Syclo/Agentry'],
            ['title' => 'Rep. Server'],
            ['title' => 'ASE'],
        ]);
    }
}
