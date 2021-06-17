<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'created_by' => function() use ($faker) {
    		$user = factory(App\Models\User::class)->create([
				'address' => NULL,
				'is_admin' => 1
			]);

    		return $user->id;
		},
		'title' => $faker->name
    ];
});
