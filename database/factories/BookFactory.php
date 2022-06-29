<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->text(),
        'isbn' => $faker->isbn13,
        'published_year' => $faker->numberBetween(1900, 2020)
    ];
});
