<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'category_id' => function() use ($faker) {
    		$category = factory(App\Models\Category::class)->create();

    		return $category->id;
		},
		'name' => $faker->name,
		'description' => $faker->paragraph,
		'image' => $faker->imageUrl(),
		'price' => $faker->numberBetween(100, 1000)
    ];
});
