<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		DB::table('status')->insert([
            ['id' => 1, 'title' => 'Pending'],
            ['id' => 2, 'title' => 'Confirmed'],
            ['id' => 3, 'title' => 'Declined'],
        ]);
    }
}
