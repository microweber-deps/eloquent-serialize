<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use AnourValar\EloquentSerialize\Tests\Models\User;
use AnourValar\EloquentSerialize\Tests\Models\UserPhone;
use AnourValar\EloquentSerialize\Tests\Models\UserPhoneNote;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker, array $attributes)
{
    return [
        'title' => 'admin',
        'sort' => $faker->numberBetween(1, 10),
        'meta' => json_encode(['foo' => 'a']),
        'deleted_at' => mt_rand(0, 5) ? null : $faker->date('Y-m-d H:i:s'),
    ];
});

$factory->define(UserPhone::class, function (Faker $faker, array $attributes)
{
    static $counter;
    $counter++;

    return [
        'user_id' => function() use ($counter)
        {
            if (! ($counter % 2)) {
                return UserPhone::max('id');
            }

            return factory(User::class)->create();
        },
        'phone' => $faker->phoneNumber,
        'is_primary' => $faker->boolean,
    ];
});

$factory->define(UserPhoneNote::class, function (Faker $faker, array $attributes)
{
    static $counter;
    $counter++;

    return [
        'user_phone_id' => function() use ($counter)
        {
            if (! ($counter % 2)) {
                return UserPhone::max('id');
            }

            return factory(UserPhone::class)->create();
        },
        'note' => $faker->realText(100),
    ];
});
