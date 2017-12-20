<?php

use Faker\Generator as Faker;

$factory->define(App\Work::class, function (Faker $faker) {
    $title = substr($faker->sentence(rand(3, 7)), 0, -1);

    return [
        'title'     => $title,
        'slug'      => str_slug($title),
        'excerpt'   => '<p>'.$faker->text(200).'</p>',
        'content'   => '<p>'.$faker->text(2000).'</p>',
        'image'     => $faker->imageUrl(750, 346, 'cats', false),
        'author_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'link'      => 'https://tyloo.fr',
    ];
});
