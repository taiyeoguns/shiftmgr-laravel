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
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

$factory->define(Manager::class, function () {
    return [];
});

$factory->define(Member::class, function () {
    return [];
});

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'uuid'  => Uuid::uuid4()->toString(),
        'first_name' => $fn = $faker->firstName,
        'last_name' => $ln = $faker->lastName,
        'email' => strtolower(sprintf('%s.%s@shiftmanager.local', $fn, $ln)),
        'phone' => $faker->phoneNumber,
        'password' => \Hash::make(env('DEFAULT_USER_PASSWORD')),
        'remember_token' => str_random(10),

    ];
});

$factory->define(Shift::class, function (Faker\Generator $faker) {
    return [
        'uuid'  => Uuid::uuid4()->toString(),
        'shift_date' => Carbon::create($faker->year($max = "now"), $faker->numberBetween(1, 12), $faker->numberBetween(1, 28)),
    ];
});

$factory->define(Task::class, function (Faker\Generator $faker) {
    return [
        'title'  => $faker->sentence,
        'start'  => $start = Carbon::create(
            Carbon::now()->year,
            $faker->numberBetween(1, 12),
            $faker->numberBetween(1, 28),
            $faker->numberBetween(8, 14),
            $faker->randomElement([0, 15, 30, 45])
        ),
        'end' => $start
            ->copy()
            ->addHours($faker->numberBetween(1, 3))
            ->addMinutes($faker->randomElement([0, 15, 30, 45])),
    ];
});
