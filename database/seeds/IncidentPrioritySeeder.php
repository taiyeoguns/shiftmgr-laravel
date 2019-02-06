<?php

use Illuminate\Database\Seeder;

class IncidentPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('incident_priority')->insert([
            ['id' => 1, 'title' => 'Very High'],
            ['id' => 2, 'title' => 'High'],
            ['id' => 3, 'title' => 'Medium'],
            ['id' => 4, 'title' => 'Low'],
        ]);
    }
}
