<?php

use App\Models\Manager;
use App\Models\Member;
use App\Models\Shift;
use App\Models\User;
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

        //seed tables
        $this->call([
            BouncerSeeder::class,
            PrioritySeeder::class,
            StatusSeeder::class,
        ]);


        //create managers and shifts
        $num_managers = (int)$this->command->ask("How many Managers to create? (Max: 50)", 3);

        if ($num_managers < 0) {
            $num_managers = 1;
            $this->command->info("Invalid. Using {$num_managers} " . str_plural('manager', $num_managers) . "...");
        } elseif ($num_managers > 50) {
            $num_managers = 50;
            $this->command->info("Invalid. Using {$num_managers} " . str_plural('manager', $num_managers) . "...");
        }

        $num_shifts = (int)$this->command->ask("How many Shifts to create? (Max: 50)", 5);

        if ($num_shifts < 0) {
            $num_shifts = 1;
            $this->command->info("Invalid. Using {$num_shifts} " . str_plural('shift', $num_shifts) . "...");
        } elseif ($num_shifts > 50) {
            $num_shifts = 50;
            $this->command->info("Invalid. Using {$num_shifts} " . str_plural('shift', $num_shifts) . "...");
        }

        $num_members = (int)$this->command->ask("How many Members to create? (Max: 50)", 7);

        if ($num_members < 0) {
            $num_members = 1;
            $this->command->info("Invalid. Using {$num_members} " . str_plural('member', $num_members) . "...");
        } elseif ($num_members > 50) {
            $num_members = 50;
            $this->command->info("Invalid. Using {$num_members} " . str_plural('member', $num_members) . "...");
        }

        $this->command->info("Creating {$num_managers} " . str_plural('manager', $num_managers) . " and {$num_shifts} " . str_plural('shift', $num_shifts) . "...");

        factory(User::class, $num_managers)->make()->each(function ($user) use ($num_shifts) {
            $manager = factory(Manager::class)->create();

            $manager->user()->save($user);

            //assign role
            Bouncer::assign('manager')->to($user);

            //for each manager, create shifts
            $manager->shifts()->saveMany(
                factory(Shift::class, $num_shifts)->make()

            );
        });

        //create engineers
        $this->command->info("Creating {$num_members} " . str_plural('member', $num_members) . "...");

        factory(User::class, $num_members)->make()->each(function ($user) {
            $member = factory(Member::class)->create();

            $member->user()->save($user);

            //assign role
            Bouncer::assign('member')->to($user);

            //get random shift and assign to member
            $shift = Shift::inRandomOrder()->first();

            $shift->members()->attach($member->id);
        });

        $this->command->info("Done.");

        Model::reguard();
    }
}
