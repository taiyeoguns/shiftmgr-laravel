<?php

use Illuminate\Database\Eloquent\Model;
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
        Model::unguard();

        // $this->call(UserTableSeeder::class);
        
        //App\User::truncate();
        //App\Shift::truncate();
        
        //factory(App\Shift::class, 10)->create();
        
        //seed bouncer tables
        $this->call(BouncerSeeder::class);
        
        //seed incident status tables
        $this->call(IncidentStatusSeeder::class);
        
        //seed status tables
        $this->call(StatusSeeder::class);
        
        //seed gfm tables
        $this->call(GfmSeeder::class);
        
        //seed incident priority tables
        $this->call(IncidentPrioritySeeder::class);
        
        //seed nexus tables
        $this->call(NexusSeeder::class);
        
        //seed components tables
        $this->call(ComponentSeeder::class);
        
        /**/
        //create 3 managers
        factory(App\User::class, 3)->create()->each(function ($user) {
            $manager = new App\Manager();
            
            $manager->save();
                
            //assign role
            Bouncer::assign('manager')->to($user);
            
            $manager->user()->save($user);
            
            //add shifts
            /**/
            $manager->shifts()->saveMany(
                factory(App\Shift::class, 5)->make()
                
            );
            /**/
        });
        
        //create 7 engineers
        factory(App\User::class, 7)->create()->each(function ($user) {
            $engineer = new App\Engineer();
            
            $engineer->save();
            
            //assign role
            Bouncer::assign('engineer')->to($user);
            
            $engineer->user()->save($user);
        });
        /**/

        Model::reguard();
    }
}
