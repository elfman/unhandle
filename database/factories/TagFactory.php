<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Tag::class, function (Faker $faker) {
    $name = $faker->text(10);
    return [
        'slug' => $name,
        'name' => $name,
    ];
});
