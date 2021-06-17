<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
		'mobile_no' => str_replace('+', '', $faker->unique()->e164PhoneNumber),
		'address' => json_encode([
			'line_1' => $faker->secondaryAddress,
			'line_2' => $faker->streetAddress,
			'city' => $faker->city,
			'state' => $faker->state,
			'country' => $faker->country,
			'post_code' => $faker->postcode
		]),
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
		'is_admin' => 0,
        'remember_token' => Str::random(10),
    ];
});
