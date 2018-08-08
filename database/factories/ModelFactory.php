<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use Carbon\Carbon;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        /*'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => sprintf('user%s@dutymanager.local',$faker->unique()->numberBetween(1, 20)),*/ //$faker->userName.'@sap.con', //not real obviously
        'first_name' => $fn = $faker->firstName,
        'last_name' => $ln = $faker->lastName,
        'email' => strtolower(sprintf('%s.%s@dutymanager.local',$fn, $ln)),
        'phone' => $faker->phoneNumber,
        'numberId' => sprintf('I%s',$faker->unique()->randomNumber(6, true)),
        /*
		'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
		*/
    ];
});

//custom

$factory->define(App\Shift::class, function (Faker\Generator $faker) {
    return [
        'shift_date' => $sd = Carbon::create(date('Y'), $faker->numberBetween(1,12), $faker->numberBetween(1,28))->next($faker->randomElement([Carbon::SATURDAY, Carbon::SUNDAY])),
        'manager_id' => 1,
    ];
});