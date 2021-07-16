<?php

namespace Tests\Unit;

use Faker\Factory as FakerFactory;
use PHPUnit\Framework\TestCase;
use TarsisioXavier\MagicObject\MagicObject;
use Tests\Support\DummyObject;

class MagicObjectTest extends TestCase
{
    /** @var \Faker\Generator */
    private $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = FakerFactory::create();
    }

    /**
     * @test
     */
    public function can_instantiate_object()
    {
        $object = new DummyObject();

        $this->assertInstanceOf(MagicObject::class, $object);

        $object = new DummyObject([
            'name' => $this->faker->name,
            'email' => $this->faker->email
        ]);

        $this->assertInstanceOf(MagicObject::class, $object);
    }

    /**
     * @test
     */
    public function can_set_attributes()
    {
        $object = new DummyObject([
            'name' => $name = $this->faker->name,
            'email' => $email = $this->faker->email
        ]);

        $this->assertEquals([
            'name' => $name,
            'email' => $email
            ], $object->attributesToArray(),
        );

        $object->name = $this->faker->name;

        $this->assertTrue($object->name !== $name);
    }

    /**
     * @test
     */
    public function can_unset_attributes()
    {
        $object = new DummyObject([
            'name' => $this->faker->name,
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email
        ]);

        unset($object->last_name);

        $this->assertTrue($object->last_name === null);
    }

    /**
     * @test
     */
    public function is_array_accessable()
    {
        $object = new DummyObject($attributes = [
            'name' => $this->faker->name,
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email
        ]);

        foreach ($object as $attribute => $value) {
            $this->assertEquals($attributes[$attribute], $value);
        }

        $attributes['phone'] = $this->faker->phoneNumber();
        $object->phone = $attributes['phone'];

        foreach ($object as $attribute => $value) {
            $this->assertEquals($attributes[$attribute], $value);
        }
    }

    /**
     * @test
     */
    public function can_create_attribute_accessor()
    {
        $object = new DummyObject([
            'name' => $name = $this->faker->firstName(),
            'last_name' => $lastName = $this->faker->lastName(),
        ]);

        $this->assertEquals($object->full_name, "{$name} {$lastName}");
    }

    /**
     * @test
     */
    public function boots_traits()
    {
        $object = new DummyObject();

        $this->assertEquals('Some dummy value here', $object->traitProperty);
    }

    /**
     * @test
     */
    public function can_mutate_attributes_on_setting()
    {
        $datetime = $this->faker->dateTime();

        $object = new DummyObject(['date' => $datetime]);

        $this->assertEquals($datetime->format('Y-m-d'), $object->date);
    }
}
