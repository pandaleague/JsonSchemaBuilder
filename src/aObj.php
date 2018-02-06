<?php

namespace PandaLeague\JsonSchemaBuilder;

class aObj extends Type
{
    use BaseType;
    use BaseObjectType;

    public function __construct()
    {
        parent::__construct('object');
    }

}