<?php

use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    // $imageDir = storage_path('app/public/images');

    return [
        'name' => $faker->company,
        'email' => $faker->email,
        'logo' => $faker->imageUrl(100, 100, 'business'),
        'website' => $faker->url,
    ];
});

$factory->state(Company::class, 'with_id', function (Faker $faker) {
    static $id = 1;

    return [
        'id' => ++$id,
    ];
});

$factory->state(Company::class, 'with_image', function (Faker $faker) {
    // dump($faker);

    return [
        'logo' => $faker->image('storage/app/public/images', 100, 100, 'business', false),
    ];
});
