<?php

namespace PandaLeague\JsonSchemaBuilder;

class aStr extends Type
{
    use BaseType;

    protected $minLength;
    protected $maxLength;
    protected $pattern;
    protected $format;
    protected $enum;
    protected $additionalProperties;

    public function __construct()
    {
        parent::__construct('string');
    }

    public function size(?int $min, ?int $max) : aStr
    {
        $this->minLength = $min;
        $this->maxLength = $max;
        return $this;
    }

    public function pattern(string $pattern) : aStr
    {
        $this->pattern = $pattern;
        return $this;
    }

    public function format(string $format) : aStr
    {
        $this->format = $format;
        return $this;
    }
}