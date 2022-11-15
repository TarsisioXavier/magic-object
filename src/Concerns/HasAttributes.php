<?php

namespace TarsisioXavier\MagicObject\Concerns;

trait HasAttributes
{
    /**
     * Attributes transformed in the constructor.
     *
     * @var array<string, mixed>
     */
    public array $attributes;

    /**
     * Original attributes received from the constructor.
     *
     * @var array<string, mixed>
     */
    public array $original;

    /**
     * Get an attribute from the model.
     *
     * @param  string  $value
     *
     * @return mixed
     */
    public function getAttribute(string $value): mixed
    {
        if ($this->hasAccessor($value)) {
            return $this->callAttributeAccessor($value);
        }

        return $this->attributes[$value] ?? null;
    }

    /**
     * Checks if the object has accessor for the attribute exists.
     *
     * @param  string  $value
     *
     * @return bool
     */
    public function hasAccessor(string $value): bool
    {
        return method_exists(
            static::class,
            'get' . $this->attributeNameToCamelCase($value) . 'Attribute'
        );
    }

    /**
     * Call the accessor of the attribute.
     *
     * @param  string  $value
     *
     * @return mixed
     */
    public function callAttributeAccessor(string $value): mixed
    {
        return $this->{'get' . $this->attributeNameToCamelCase($value) . 'Attribute'}();
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $field
     * @param  mixed  $value
     *
     * @return mixed
     */
    public function setAttribute(string $field, $value): mixed
    {
        if ($this->hasMutator($field)) {
            return $this->callMutatorAttribute($field, $value);
        }

        return $this->attributes[$field] = $value;
    }

    /**
     * Checks if the object has any mutator for the attribute.
     *
     * @param  string  $field
     *
     * @return bool
     */
    public function hasMutator(string $field): bool
    {
        return method_exists(
            static::class,
            'set' . $this->attributeNameToCamelCase($field) . 'Attribute'
        );
    }

    /**
     * Calls the mutator of the attribute.
     *
     * @param  string  $field
     * @param  mixed  $value
     *
     * @return mixed
     */
    public function callMutatorAttribute(string $field, $value): mixed
    {
        return $this->{'set' . $this->attributeNameToCamelCase($field) . 'Attribute'}($value);
    }

    /**
     * Return the attributes of the object.
     *
     * @return array
     */
    public function attributesToArray(): array
    {
        return $this->attributes;
    }

    /**
     * Transforms the attribute key into Camel Case.
     *
     * @param  string  $attribute
     *
     * @return string
     */
    public function attributeNameToCamelCase(string $attribute): string
    {
        $words = explode('_', $attribute);

        foreach ($words as $key => $word) {
            $words[$key] = ucfirst($word);
        }

        return implode('', $words);
    }
}
