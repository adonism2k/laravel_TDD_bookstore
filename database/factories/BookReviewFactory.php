<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BookReview;
use Faker\Generator as Faker;

$factory->define(BookReview::class, function (Faker $faker) {
    return [
        'review' => $faker->randomElement(range(1, 10)),
        'comment' => $faker->text(),
    ];
});
