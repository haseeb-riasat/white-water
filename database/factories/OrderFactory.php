<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;
use App\User;
$factory->define(Order::class, function (Faker $faker) {
    return [
        'user_id'=> User::pluck('id')->random(),
        'grand_total' => $faker->numberBetween($min = 5550, $max = 8098),
        'discount' => $faker->numberBetween($min = 55, $max = 98),
        'payment_method' => 'telr|cash',
        'status' => 'paid|unpaid',
    ];


});
