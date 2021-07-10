<?php

namespace TarsisioXavier\MagicObject\Concerns;

trait HasAttributes
{
    /** 
     * Attributes transformed in the constructor.
     * 
     * @var mixed[]
     */
    public $attributes;

    /** 
     * Original attributes received from the constructor.
     * 
     * @var mixed[]
     */
    public $original;

    /**
     * Get an attribute from the model.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function getAttribute($value)
    {
        if ($this->hasAccessor($value)) {
            return $this->callAttributeAccessor($value);
        }

        return $this->attributes[$value] ?? null;
    }

    /**
     * Checks if the an accessor for the attribute exists.
     * 
     * @param  mixed  $value
     * @return bool
     */
    public function hasAccessor($value)
    {
        return method_exists(
            static::class,
            'get' . $this->attributeNameToCamelCase($value) . 'Attribute'
        );
    }

    /**
     * Call the accessor of the attribute.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function callAttributeAccessor($value)
    {
        return $this->{'get' . $this->attributeNameToCamelCase($value) . 'Attribute'}();
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function setAttribute($field, $value)
    {
        $this->attributes[$field] = $value;
    }

    /**
     * Return the attributes of the object.
     * 
     * @return array
     */
    public function attributesToArray()
    {
        return $this->attributes;
    }

    /**
     * Transforms the attribute key into Camel Case.
     * 
     * @param  string  $attribute
     * @return string
     */
    public function attributeNameToCamelCase(string $attribute)
    {
        $words = explode('_', $attribute);

        foreach ($words as $key => $word) {
            $words[$key] = ucfirst($word);
        }

        return implode('', $words);
    }
}
