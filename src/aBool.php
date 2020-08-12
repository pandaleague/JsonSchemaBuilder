<?php

namespace PandaLeague\JsonSchemaBuilder;

class aBool extends Type
{
    use BaseType;

    public function __construct()
    {
        parent::__construct('boolean');
    }

    public function default(bool $default) : aBool
    {
        $this->default = $default;
        return $this;
    }
}