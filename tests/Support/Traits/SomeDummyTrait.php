<?php

namespace Tests\Support\Traits;

trait SomeDummyTrait
{
    public $traitProperty;

    protected function bootSomeDummyTrait()
    {
        $this->traitProperty = 'Some dummy value here';
    }
}
