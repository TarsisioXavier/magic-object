<?php

namespace TarsisioXavier\MagicObject;

use ArrayAccess;
use Iterator;

abstract class MagicObject implements ArrayAccess, Iterator
{
    use Concerns\HasAttributes,
        Concerns\IteratesWithAttributes;

    public function __construct(?array $attributes = null)
    {
        $this->bootTraits();

        if ($attributes) {
            $this->original = $attributes;
            $this->fill($attributes);
        }
    }

    public function __get($value)
    {
        return $this->getAttribute($value);
    }

    public function __set($field, $value)
    {
        return $this->setAttribute($field, $value);
    }

    public function __unset($offset)
    {
        unset($this->attributes[$offset]);
    }

    /**
     * Call methods of traits starting with 'boot'.
     * 
     * @return null
     */
    protected function bootTraits()
    {
        $traits = array_merge(
            class_uses(static::class),
            class_uses(self::class)
        );

        foreach ($traits as $trait => $namespace) {
            $traitName = array_slice(explode('\\', $namespace), -1, 1)[0];

            if (method_exists($trait, 'boot' . $traitName)) {
                $this->{'boot' . $traitName}();
            }
        }
    }

    /**
     * Sets an array of attributes.
     * 
     * @param  array  $attributes
     * @return null
     */
    public function fill(array $attributes)
    {
        foreach ($attributes as $field => $value) {
            $this->setAttribute($field, $value);
        }
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed  $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return ! is_null($this->getAttribute($offset));
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed  $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }

    /**
     * Set the value for a given offset.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        return $this->setAttribute($offset, $value);
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed  $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        $this->__unset($offset);
    }
}
