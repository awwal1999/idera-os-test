<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Cinema;
use Faker\Generator as Faker;

$factory->define(Cinema::class, function (Faker $faker) {
    return [
        'name' => $faker->domainName.' Cinema',
        'address' => $faker->address
    ];
});
