<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Author::class, function (Faker $faker) {
    return [
        'kunyah' => null,
        'name' => $faker->name,
        'used_name' => $faker->name,
        'laqab' => null,
        'nisbah' => null,
        'yob' => null,
        'yod' => null,
    ];
});
