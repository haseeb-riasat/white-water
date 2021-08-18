<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $this->faker->name(),
        'image_url'=>$faker->image(public_path('images'),400,300, null, false),
        'description' => $this->faker->paragraph,
        'price' => $faker->numberBetween($min = 150, $max = 600)
    ];
});
