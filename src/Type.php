<?php

namespace PandaLeague\JsonSchemaBuilder;

use Illuminate\Contracts\Support\Arrayable;

class Type implements Arrayable
{
    use ToArray;

    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }
}