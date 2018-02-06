<?php

namespace PandaLeague\JsonSchemaBuilder;

class Factory
{
    static function str() : aStr
    {
        return new aStr();
    }

    static function obj() : aObj
    {
        return new aObj();
    }

    static function null(): aNull
    {
        return new aNull();
    }

    static function num(): aNum
    {
        return new aNum();
    }

    static function arr(): aArr
    {
        return new aArr();
    }

    static function bool(): aBool
    {
        return new aBool();
    }
}