<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
 */

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->name,
		'email' => $faker->unique()->safeEmail,
		'password' => bcrypt('secret'),
		'remember_token' => str_random(10),
	];
});

$factory->define(\App\Category::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->sentence,
	];
});

$factory->define(App\Note::class, function (Faker\Generator $faker) {
	return [
		'note' => $faker->paragraph,
	];
});
