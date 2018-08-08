<?php

use Illuminate\Database\Seeder;

class GfmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		DB::table('gfms')->insert([
            ['title' => 'ASE+'],
            ['title' => 'BI'],
            ['title' => 'EIM'],
            ['title' => 'EPM'],
            ['title' => 'Mobility'],
            ['title' => 'Solution Manager'],
        ]);
    }
}
