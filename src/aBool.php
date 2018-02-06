<?php

namespace PandaLeague\JsonSchemaBuilder;

class aBool extends Type
{
    use BaseType;

    public function __construct()
    {
        parent::__construct('boolean');
    }
}