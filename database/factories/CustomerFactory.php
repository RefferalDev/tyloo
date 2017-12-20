<?php

use Faker\Generator as Faker;

$factory->define(App\Customer::class, function (Faker $faker) {
    $label = substr($faker->sentence(rand(3, 7)), 0, -1);
    
    return [
        'label'       => $label,
        'description' => '<p>'.$faker->text(2000).'</p>',
        'image'       => $faker->imageUrl(750, 346, 'cats', false),
    ];
});
