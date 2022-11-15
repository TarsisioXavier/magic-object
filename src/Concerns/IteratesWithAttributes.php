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
    public function current(): mixed
    {
        return $this->getAttribute($this->key());
    }

    /**
     * Key of the current attribute.
     * 
     * @return string
     */
    public function key(): string
    {
        return $this->attributesKeys[$this->iterator];
    }

    /**
     * Go fot the next attribute key.
     * 
     * @return void
     */
    public function next(): void
    {
        $this->iterator++;
    }

    /**
     * Rewinds class' interator.
     * 
     * @return void
     */
    public function rewind(): void
    {
        $this->iterator = 0;

        $this->attributesKeys = array_keys($this->attributes);
    }

    /**
     * Checks if there is more.
     * 
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->attributesKeys[$this->iterator]);
    }
}
