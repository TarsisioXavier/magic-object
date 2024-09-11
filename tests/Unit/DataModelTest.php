<?php

use MagicObject\DataModel;
use Tests\Support\DummyObject;

use function Pest\Faker\fake;

covers(DataModel::class);

dataset('filled object', [
    new DummyObject([
        'name' => fake()->name(),
        'last_name' => fake()->lastName(),
        'email' => fake()->email(),
    ])
]);

it('can instantiate an object', function ($object) {
    expect($object)->toBeInstanceOf(DataModel::class);
})->with([
    new DummyObject(),
    new DummyObject(['name' => fake()->name(), 'email' => fake()->email()]),
]);

it('can set attributes', function () {
    $object = new DummyObject([
        'name' => $name = fake()->name(),
        'email' => $email = fake()->email(),
    ]);

    expect($object->attributesToArray())->toMatchArray([
        'name' => $name,
        'email' => $email
    ]);

    $object->name = fake()->name();

    expect($object->name)->not->toBe($name);
});

it('can unset attributes', function ($object) {
    unset($object->last_name);

    expect($object->last_name)->toBeNull();
})->with('filled object');

it('if the array is accessable', function () {
    $object = new DummyObject($attributes = [
        'name' => fake()->name(),
        'last_name' => fake()->lastName(),
        'email' => fake()->email(),
    ]);

    foreach ($object as $attribute => $value) {
        expect($attributes[$attribute])->toBe($value);
    }

    $attributes['phone'] = fake()->phoneNumber();
    $object->phone = $attributes['phone'];

    foreach ($object as $attribute => $value) {
        expect($attributes[$attribute])->toBe($value);
    }
});

it('can create attribute accessor', function ($object) {
    expect($object->full_name)->toBe($object->name . ' ' . $object->last_name);
})->with('filled object');

it('boot traits', function ($object) {
    expect($object->traitProperty)->toBe('Some dummy value here');
})->with('filled object');

it('can mutate attributes on setting', function () {
    $datetime = fake()->dateTime();

    $object = new DummyObject(['date' => $datetime]);

    expect($object->date)->toBe($datetime->format('Y-m-d'));
});
