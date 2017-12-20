<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Post::class, function (Faker $faker) {
    $title = substr($faker->sentence(rand(3, 7)), 0, -1);

    return [
        'title'   => $title,
        'slug'    => str_slug($title),
        'excerpt' => '<p>'.$faker->text(200).'</p>',
        'content' => '<p>'.$faker->text(2000).'</p>',
        'image'   => $faker->imageUrl(750, 346, 'cats', false),
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
    ];
});

$factory->state(App\Post::class, 'published', [
    'published_at' => Carbon::now(),
]);
