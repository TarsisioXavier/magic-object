<?php

namespace Tests\Support;

use TarsisioXavier\MagicObject\MagicObject;

class DummyObject extends MagicObject
{
    use Traits\SomeDummyTrait;

    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->last_name}";
    }
}
