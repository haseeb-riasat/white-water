<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Order;
use App\OrderProduct;
use App\Product;
use Faker\Generator as Faker;

$factory->define(OrderProduct::class, function (Faker $faker) {
    return [
        'order_id'=> Order::pluck('id')->random(),
        'product_id'=> Product::pluck('id')->random(),
        'price' => $faker->numberBetween($min = 55, $max = 80),
        'quantity' => $faker->numberBetween($min = 10, $max = 50),
    ];
});
