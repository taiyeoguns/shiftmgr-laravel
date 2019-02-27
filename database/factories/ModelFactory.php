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

use App\Models\Manager;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $fn = $faker->firstName,
        'last_name' => $ln = $faker->lastName,
        'email' => strtolower(sprintf('%s.%s@dutymanager.local', $fn, $ln)),
        'phone' => $faker->phoneNumber,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),

    ];
});

$factory->define(Manager::class, function (Faker\Generator $faker) {
    return [];
});

$factory->define(Shift::class, function (Faker\Generator $faker) {
    return [
        'shift_date' => $sd = Carbon::create(date('Y'), $faker->numberBetween(1, 12), $faker->numberBetween(1, 28)),
        'manager_id' => factory(Manager::class)->create()->id,
    ];
});
