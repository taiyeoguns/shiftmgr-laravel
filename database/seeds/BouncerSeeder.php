<?php

use Illuminate\Database\Seeder;

//bouncer
//use Bouncer;

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
            'create-tasks',
            'update-tasks',
        ]);

        Bouncer::allow('manager')->to([
            'read-shifts',
            'update-shifts',
            'create-tasks',
            'update-tasks',
        ]);

        Bouncer::allow('member')->to([
            'read-shifts',
            'read-tasks',
            'update-tasks'
        ]);
    }
}
