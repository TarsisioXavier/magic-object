<?php

namespace Tests\Support;

use MagicObject\DataModel;

class DummyObject extends DataModel
{
    use Traits\SomeDummyTrait;

    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->last_name}";
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value->format('Y-m-d');
    }
}
