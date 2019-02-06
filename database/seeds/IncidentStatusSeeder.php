<?php

use Illuminate\Database\Seeder;

class IncidentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('incident_status')->insert([
            ['id' => 1, 'title' => 'New'],
            ['id' => 2, 'title' => 'In Process'],
            ['id' => 3, 'title' => 'Customer Action'],
            ['id' => 4, 'title' => 'Solution Provided'],
            ['id' => 5, 'title' => 'Confirmed'],
            ['id' => 6, 'title' => 'Handover'],
            ['id' => 7, 'title' => 'Downgraded'],
            ['id' => 8, 'title' => 'Transferred to another component'],
            ['id' => 9, 'title' => 'Customer can wait until Monday'],
            ['id' => 10, 'title' => 'Request for valid 24x7 contact'],
        ]);
    }
}
