<?php

use Illuminate\Database\Seeder;

//bouncer
//use Bouncer; //not needed

class BouncerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		Bouncer::allow('admin')->to([
			'admin',
			'create-shifts',
			'read-shifts',
			'read-all-shifts',
			'update-shifts',
			'create-calls',
			'update-calls',
		]);
		
		Bouncer::allow('manager')->to([
			'read-shifts',
			'update-shifts',
			'create-calls',
			'update-calls',
		]);
		
		Bouncer::allow('engineer')->to([
			'read-shifts',
			'read-calls',
			'update-calls'
		]);
    }
}
