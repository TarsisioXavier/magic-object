<?php

namespace TarsisioXavier\MagicObject\Concerns;

trait IteratesWithAttributes
{
    /** @var int */
    private $iterator = 0;

    /** @var string[] */
    private $attributesKeys;

    /**
     * Value of the current attribute.
     * 
     * @return mixed
     */
    public function current()
    {
        return $this->getAttribute($this->key());
    }

    /**
     * Key of the current attribute.
     * 
     * @return string
     */
    public function key()
    {
        return $this->attributesKeys[$this->iterator];
    }

    /**
     * Go fot the next attribute key.
     * 
     * @return int
     */
    public function next()
    {
        return ++$this->iterator;
    }

    /**
     * Rewinds class' interator.
     * 
     * @return null
     */
    public function rewind()
    {
        $this->iterator = 0;

        $this->attributesKeys = array_keys($this->attributes);
    }

    /**
     * Checks if there is more.
     * 
     * @return bool
     */
    public function valid()
    {
        return isset($this->attributesKeys[$this->iterator]);
    }
}
