<?php

use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('priorities')->insert([
            ['title' => 'High'],
            ['title' => 'Medium'],
            ['title' => 'Low'],
        ]);
    }
}
