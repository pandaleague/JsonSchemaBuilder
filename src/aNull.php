<?php

namespace PandaLeague\JsonSchemaBuilder;

class aNull extends Type
{
    use BaseType;
    use BaseObjectType;

    public function __construct()
    {
        parent::__construct(null);
    }
}