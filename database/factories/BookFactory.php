<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use App\User;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    $randomNumber = rand(1, 500);
    $cover = "https://picsum.photos/id/{$randomNumber}/200/300";

    return [
        'user_id' => User::inRandomOrder()->first()->id,
        'title' => $faker->sentence(3),
        'cover' => $cover,
    ];
});
