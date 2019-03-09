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
use App\Models\Member;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;

$factory->define(Manager::class, function () {
    return [];
});

$factory->define(Member::class, function () {
    return [];
});

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $fn = $faker->firstName,
        'last_name' => $ln = $faker->lastName,
        'email' => strtolower(sprintf('%s.%s@shiftmanager.local', $fn, $ln)),
        'phone' => $faker->phoneNumber,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),

    ];
});

$factory->define(Shift::class, function (Faker\Generator $faker) {
    return [
        'shift_date' => Carbon::create(date('Y'), $faker->numberBetween(1, 12), $faker->numberBetween(1, 28)),
    ];
});
