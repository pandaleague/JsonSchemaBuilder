<?php

namespace PandaLeague\JsonSchemaBuilder;

class aNum extends Type
{
    use BaseType;

    protected $multipleOf;
    protected $minimum;
    protected $maximum;
    protected $exclusiveMinimum;
    protected $exclusiveMaximum;

    public function __construct()
    {
        parent::__construct('number');
    }

    public function multipleOf(float $multi) : aNum
    {
        $this->multipleOf = $multi;
        return $this;
    }

    public function minimum(float $min, bool $exclusive = null) : aNum
    {
        $this->minimum = $min;
        $this->exclusiveMinimum = $exclusive;
        return $this;
    }

    public function maximum(float $max, bool $exclusive = null) : aNum
    {
        $this->maximum = $max;
        $this->exclusiveMaximum = $exclusive;
        return $this;
    }

    public function default(float $default) : aNum
    {
        $this->default = $default;
        return $this;
    }
}