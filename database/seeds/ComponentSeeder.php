<?php

use Illuminate\Database\Seeder;

class ComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		DB::table('components')->insert([
            ['title' => 'MOB-SUP*'],
            ['title' => 'MOB-ONP*'],
            ['title' => 'MOB-SYC*'],
            ['title' => 'MOB-AFA'],
            ['title' => 'MOB-RWS'],
            ['title' => 'BPC-MS'],
            ['title' => 'EPM-FIM*'],
            ['title' => 'EPM-EA*'],
            ['title' => 'EPM-BPC*'],
            ['title' => 'EPM-IC*'],
            ['title' => 'EPM-DSM*'],
            ['title' => 'BC-DB-SYB'],
            ['title' => 'BC-SYB-ASE'],
            ['title' => 'BW-SYS-DB-SYB'],
            ['title' => 'BC-SYB-IQ'],
            ['title' => 'BC-SYB-REP'],
            ['title' => 'BC-SYB-REP-SAP'],
            ['title' => 'BC-SYB-SQA'],
        ]);
    }
}
